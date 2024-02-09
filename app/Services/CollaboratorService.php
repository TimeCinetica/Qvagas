<?php

namespace App\Services;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Resume;
use App\Models\Role;
use App\Models\User;

class UserService
{
    private $utilsService;
    private $assetService;
    private $notificationService;
    private $user;
    private $resume;

    public function __construct(
        UtilsService $utilsService,
        AssetService $assetService,
        NotificationService $notificationService,
        User $user,
        Resume $resume
    ) {
        $this->utilsService = $utilsService;
        $this->assetService = $assetService;
        $this->notificationService = $notificationService;
        $this->user = $user;
        $this->resume = $resume;
    }

    /**
     * Store user
     * 
     * @return User $user
     */
    public function store(StoreUserRequest $request)
    {
        $user = null;
        $this->utilsService->validateCpf($request->cpf);
        DB::transaction(function () use (&$user, $request) {
            $request->merge([
                'roleId'   => Role::Collaborator
            ]);

            $user = $this->user->create($request->all());
            $request->merge([
                'userId'   => $user->id,
                'lastUpdate' => now()
            ]);

            $resume = $this->resume->create($request->all());
            $this->createResumeCompany($request, $resume);
            $this->createResumeLanguage($request, $resume);
            $this->createOccupations($request, $resume);
            $this->notificationService->sendWelcomeEmail($user);
        });

        return $user;
    }

    /**
     * Update user
     * 
     * @return User $user
     */
    public function update(UpdateUserRequest $request)
    {
        $user = $this->user->findOrFail($request->userId);

        DB::transaction(function () use (&$user, $request) {
            $user->update($request->all());

            $request->merge(['lastUpdate' => now()]);
            $user->resume->update($request->all());

            $this->clearResumeRelatedData($user->resume);
            $this->createResumeCompany($request, $user->resume);
            $this->createResumeLanguage($request, $user->resume);
            $this->createOccupations($request, $user->resume);
        });

        return $user;
    }


    /**
     * @param UpdateUserPhotosRequest $request
     */
    public function updatePhotos($request)
    {
        $user = $this->user->findOrFail($request->userId);

        DB::transaction(function () use ($request, $user) {
            $this->assetService->updateUserPhoto($request->file('personalPhoto'), $user);
            $this->assetService->updatePcdReport($request->file('pcdReport'), $user);
            $this->assetService->updateResumePhotos(
                $request->file('resumePhoto'),
                $request->file('recomendationPhoto'),
                $user->resume
            );
        });

        return $user;
    }

    /**
     * Send Forgot code password
     * 
     * @param ForgotPasswordRequest $request
     */
    public function sendForgotPassword($request)
    {
        $user = $this->getByCpf($request->cpf);
        $this->upsertUserCode($user);

        $this->notificationService->sendForgotEmail($user);
        return $user;
    }

    /**
     * Altera senha de usuario
     * 
     * @param ForgotPasswordRequest $request
     * @return User $user
     */
    public function newPasswordFromForgot($request)
    {
        $user = $this->getByCpf($request->cpf);

        if ($this->validateConfirmation($request, $user)) {
            DB::transaction(function () use (&$user, $request) {
                $user->confirmation->update(['confirmed' => true]);
                $user->update(['password' => $request->password]);
            });

            return $user;
        }

        return false;
    }

    /**
     * @param ChangePasswordRequest $request
     * @return User $user
     */
    public function changePassword($request)
    {
        $user = auth()->user();
        $user->update(['password' => $request->password]);

        return $user;
    }

    /**
     * 
     */
    public function delete($request)
    {
        $user = auth()->user();
        $this->clearResumeRelatedData($user->resume);
        $user->resume->delete();

        Auth::logout();
        return $user->delete();
    }

    /**
     * 
     */
    public function userInfos()
    {
        $races = $this->usersCountByQuery('raceId')->with('race')->get();
        $sex = $this->usersCountByQuery('sex')->get();
        $cities = $this->usersCountByQuery('cityId')
            ->with('city')
            ->orderByRaw('count(users.cityId) desc')
            ->limit(7)
            ->get();

        $sex = $this->parseTotalToPercentage($sex);

        return (object) [
            'races' => $races,
            'sex' => $sex,
            'cities' => $cities
        ];
    }

    /**
     * @param string $param Parametro para query de count
     */
    private function usersCountByQuery($param)
    {
        $query = $this->user->query();
        $query->selectRaw("{$param}, count(*) as total");
        $query->groupBy($param);
        $query->where('roleId', Role::User);

        return $query;
    }

    /**
     * 
     */
    private function parseTotalToPercentage($collection)
    {
        $total = $collection->sum('total');

        $other = $collection->where('sex', 0)->sum('total');
        $female = $collection->where('sex', 1)->sum('total');
        $male = $collection->where('sex', 2)->sum('total');
        $blank = $collection->where('sex', 3)->sum('total');

        return (object) [
            'other' => round(($other / $total) * 100, 2),
            'female' => round(($female / $total) * 100, 2),
            'male' => round(($male / $total) * 100, 2),
            'blank' => round(($blank / $total) * 100, 2)
        ];
    }

    /**
     * Busca usuario por id
     */
    public function getById($userId)
    {
        return $this->user->findOrFail($userId);
    }

    /**
     * @param StoreUserRequest $request
     * @param Resume $resume
     * @return void
     */
    private function createResumeCompany($request, $resume)
    {
        if (isset($request->resumeCompanies) && !empty($request->resumeCompanies)) {
            $raw = $request->all();
            foreach ($raw["resumeCompanies"] as $resumeCompany) {
                $resumeCompany = (object) $resumeCompany;
                $resume->companies()->create([
                    'companyName'       => $resumeCompany->companyName ?? null,
                    'companyActivity'   => $resumeCompany->companyActivity ?? null,
                    'companyStart'      => $resumeCompany->companyStart ?? null,
                    'companyEnd'        => $resumeCompany->companyEnd ?? null,
                    'companyLeftReason' => $resumeCompany->companyLeftReason ?? null,
                    'actualJob'         => $resumeCompany->actualJob == "true"
                ]);
            }
        }
    }


    /**
     * @param StoreUserRequest $request
     * @param Resume $resume
     * @return void
     */
    private function createResumeLanguage($request, $resume)
    {
        if (isset($request->resumeLanguagues) && !empty($request->resumeLanguagues)) {
            $raw = $request->all();
            foreach ($raw["resumeLanguagues"] as $resumeLanguage) {
                $resumeLanguage = (object) $resumeLanguage;
                $resume->languages()->create([
                    'language'  => $resumeLanguage->language,
                    'level'     => (int) $resumeLanguage->level
                ]);
            }
        }
    }

    /**
     * Valida codigo de confimação de usuario
     */
    private function validateConfirmation($request, $user)
    {
        if ($request->code != $user->confirmation->code) {
            abort(400, "Código inválido.");
        }

        if (Carbon::now()->diffInMinutes(Carbon::parse($user->confirmation->updated_at)) > 30 || $user->confirmation->confirmed) {
            abort(400, "Código expirado.");
        }

        return true;
    }

    /**
     * Busca usuario por cpf
     */
    private function getByCpf($cpf, $skipAbort = false)
    {
        if ($this->utilsService->validateCpf($cpf)) {
            $user = $this->user->where('cpf', $cpf)->first();

            if (!isset($user) && !$skipAbort) {
                abort(404, 'Usuário não encontrado.');
            }

            return $user;
        }
    }

    /**
     * Cria ou atualiza codigo de usuario
     * 
     * @param User $user
     * 
     * @return void
     */
    private function upsertUserCode($user)
    {
        $code = $this->utilsService->generateCode();

        $confirmation = $user->confirmation()->first();
        if (isset($confirmation)) {
            $confirmation->update(['code' => $code, 'confirmed' => false]);
        } else {
            $user->confirmation()->create(['code' => $code]);
        }
    }

    /**
     * 
     */
    private function createOccupations($request, $resume)
    {
        if (is_array($request->occupationArea)) {
            foreach ($request->occupationArea as $occupation) {
                $resume->occupations()->attach((int) $occupation, [
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        } else {
            $resume->occupations()->attach((int) $request->occupationArea, [
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    /**
     * @param Resume $resume
     * @return Resume $resume
     */
    private function clearResumeRelatedData($resume)
    {
        $resume->occupations()->detach();
        $resume->companies()->delete();
        $resume->languages()->delete();
    }
}
