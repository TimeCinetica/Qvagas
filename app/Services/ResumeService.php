<?php

namespace App\Services;

use App\Models\Resume;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResumeService
{
    protected $users;
    protected $resumes;

    public function __construct(
        User $users,
        Resume $resumes
    ) {
        $this->users = $users;
        $this->resumes = $resumes;
    }

    /**
     * @param int $userId
     */
    public function getByUserId($userId)
    {
        $user = $this->users->findOrFail($userId);
        return $user->resume;
    }

    /**
     * Retorna a quantidade de curriculos que nao foram atualizados ha 6 meses
     * 
     * @return int $count
     */
    public function countDeprecatedResumes()
    {
        $query = $this->resumes->query();

        $deprecatedDate = Carbon::now()->subMonths(6);
        $query->where('lastUpdate', '<', $deprecatedDate);
        $query->orWhereNull('lastUpdate');

        $count = $query->count();
        return $count;
    }

    /**
     * Retorna a quantidade total de curriculos
     * 
     * @return int $count
     */
    public function countTotal()
    {
        return $this->resumes->count();
    }

    /**
     * Retorna a quantidade de usarios com selos de talentos
     * 
     * @return int $count
     */
    public function countStamped()
    {
        $query = $this->users->query();
        $query->where('roleId', Role::User);
        $query->where('stamped', true);

        return $query->count();
    }

    /**
     * Retorna a quantidade de usuarios avaliados
     * 
     * @return int $count
     */
    public function countEvaluated()
    {
        $query = $this->users->query();
        $query->where('roleId', Role::User);
        $query->where('evaluated', true);

        return $query->count();
    }

    /**
     * 
     */
    public function indexResumes(Request $request)
    {
        $query = $this->resumesQueryFilter($request);

        $query->with(['occupations', 'status', 'user.state', 'user.city']);
        $resumes = $query->paginate(10);

        return $resumes;
    }

    /**
     * Retorna a quantidade de curriculos por status
     * 
     * @return object $data
     */
    public function resumeByStatus()
    {
        $query = $this->resumesCountByQuery('statusId');
        return $query->get();
    }

    /**
     * 
     */
    public function delete($id)
    {
        $isSadmin = auth()->user()->isSadmin();
        if (!$isSadmin) {
            abort(403, "Você não tem permissão para realizar essa operação.");
        }

        DB::transaction(function () use ($id) {
            $resume = $this->resumes->findOrFail($id);
            $resume->delete();
            $this->users->destroy($resume->userId);
        });

        return;
    }

    /**
     * 
     */
    public function resumeInfos()
    {
        $typeWorking = $this->resumesCountByQuery('typeWorking')->get();
        $typeContract = $this->resumesCountByQuery('typeContract')->get();
        $vacancyTypes = $this->resumesCountByQuery('vacancyTypeId')->with('vacancyType')->get();
        $occupationsRaking = $this->resumesOccupationsRanking();

        return (object) [
            'typeWorking' => $typeWorking,
            'typeContract' => $typeContract,
            'vacancyTypes' => $vacancyTypes,
            'occupationsRaking' => $occupationsRaking,
        ];
    }

    /**
     * 
     */
    public function getResumeCsv($request)
    {
        $query = $this->resumesQueryFilter($request);
        $query->with(['occupations']);
        $resumes = $query->get();

        $columns = ['Nome', 'Telefone', 'Email', 'Cargo pretendido'];

        $callback = function () use ($resumes, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($resumes as $resume) {
                $row['Nome'] = $resume->user->name;
                $row['Telefone'] = $resume->user->cellphone;
                $row['Email'] = $resume->user->email;
                $row['Cargo pretendido'] = collect($resume->occupations)->pluck('name')->join(' | ');

                fputcsv($file, [$row['Nome'], $row['Telefone'], $row['Email'], $row['Cargo pretendido']]);
            }

            fclose($file);
        };

        return $callback;
    }

    /**
     * @param string $param Parametro para query de count
     */
    private function resumesCountByQuery($param)
    {
        $query = $this->resumes->query();
        $query->selectRaw("{$param}, count(*) as total");
        $query->groupBy($param);

        return $query;
    }

    /**
     * 
     */
    private function resumesOccupationsRanking()
    {
        $query = $this->resumes->query();
        $query->join('resume_occupations as ro', 'ro.resumeId', '=', 'resumes.id');
        $query->join('occupations as o', 'o.id', '=', 'ro.occupationId');
        $query->selectRaw('o.id, o.name, count(o.id) as total');
        $query->groupBy(['o.id', 'o.name']);
        $query->orderByRaw('count(o.id) desc');
        $query->limit(5);
        $ranking = $query->get();

        return $ranking;
    }

    /**
     * 
     */
    private function resumesQueryFilter(Request $request)
    {
        $query = $this->resumes->query();

        $joinedUsers = false;

        if (isset($request->searchName)) {
            $name = trim($request->searchName);
            $query->join('users', 'users.id', '=', 'resumes.userId');
            $query->where('users.name', 'like', '%' . $name . '%');
            $joinedUsers = true;
        }

        if (isset($request->occupations)) {
            $occupations = explode(",", $request->occupations);
            $query->join('resume_occupations as ro', 'ro.resumeId', '=', 'resumes.id');
            $query->whereIn('ro.occupationId', $occupations);
        }

        if (isset($request->status)) {
            $statuses = explode(",", $request->status);
            $query->whereIn('statusId', $statuses);
        }

        if (isset($request->evaluated)) {
            if (!$joinedUsers) {
                $query->join('users', 'users.id', '=', 'resumes.userId');

                $joinedUsers = true;
            }

            $evaluated = explode(",", $request->evaluated);
            $query->whereIn('users.evaluated', $evaluated);
            $query->where('roleId', Role::User);
        }

        if (isset($request->stamped)) {
            if (!$joinedUsers) {
                $query->join('users', 'users.id', '=', 'resumes.userId');

                $joinedUsers = true;
            }

            $stamped = explode(",", $request->stamped);
            $query->whereIn('users.stamped', $stamped);
            $query->where('roleId', Role::User);
        }

        if (isset($request->deprecated)) {
            $deprecatedDate = Carbon::now()->subMonths(6);
            $query->where('lastUpdate', '<', $deprecatedDate);
        }

        if ($request->has('lastUpdate')) {
            $query->orderBy('resumes.lastUpdate', $request->lastUpdate);
        } else {
            $query->orderBy('resumes.lastUpdate', 'asc');
        }

        $query->select('resumes.*');

        return $query;
    }
}
