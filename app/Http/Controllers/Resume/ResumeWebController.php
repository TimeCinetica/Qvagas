<?php

namespace App\Http\Controllers\Resume;

use App\Http\Controllers\Controller;
use App\Services\RaceService;
use App\Services\ResumeService;
use App\Services\UserService;
use App\Services\VacancyTypeService;
use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Spatie\Fractal\Facades\Fractal;
use PDF;

class ResumeWebController extends Controller
{
    protected $resumeService;
    protected $userService;
    protected $vacancyTypes;
    protected $raceService;

    public function __construct(
        ResumeService $resumeService,
        UserService $userService,
        VacancyTypeService $vacancyTypeService,
        RaceService $raceService
    ) {
        $this->resumeService = $resumeService;
        $this->userService = $userService;
        $this->vacancyTypes = $vacancyTypeService;
        $this->raceService = $raceService;
    }

    /**
     * 
     */
    public function renderResume($userId)
    {
        $loggedUser = auth()->user();

        if ($loggedUser->isCollaborator() || $loggedUser->isRh()) {
            // Redirecione para a tela de contracheques ou outra página apropriada
            return redirect('paychecks.index');
        }

        $user = $this->userService->getById($userId);
        $races = $this->raceService->index();
        $vacancyTypes = $this->vacancyTypes->index();
        $userTransformed = $this->transformUserToResume($user);
        $performance = $this->transformUserToPerformance($user);
        $loggedUser = auth()->user();

        return view('resume.details', [
            'user'         => $userTransformed,
            'races'        => $races,
            'vacancyTypes' => $vacancyTypes,
            'performance'  => $performance,
            'roleId'       => $loggedUser->roleId
        ]);
    }

    /**
     * 
     */
    public function renderResumes(Request $request)
    {
        $loggedUser = auth()->user();

        if ($loggedUser->isCollaborator()) {
            // Redirecione para a tela de contracheques ou outra página apropriada
            return redirect('paychecks.index');
        }

        $policies = $this->getResumePolicies();
        $resumes = $this->resumeService->indexResumes($request);
        return view('admin.resumes', ['resumes' => $resumes, 'policies' => $policies]);
    }

    /**
     * 
     */
    public function downloadPdf($userId)
    {
        $user = $this->userService->getById($userId);
        $user = $this->transformUserToResume($user);
        $user = $this->handleEmptyValues($user);
        $pdf = PDF::loadView('resume.pdf', $user);
        return $pdf->download("{$user['name']}.pdf");
    }

    /**
     * 
     */
    public function resumeByStatus()
    {
        $resumeStatus = $this->resumeService->resumeByStatus();
        return response()->json($resumeStatus, 200);
    }

    /**
     * 
     */
    public function resumeInfos()
    {
        $resumeTypes = $this->resumeService->resumeInfos();
        return response()->json($resumeTypes, 200);
    }

    /**
     * 
     */
    public function delete($id)
    {
        $this->resumeService->delete($id);
        return response()->noContent();
    }

    /**
     * 
     */
    public function exportCsv(Request $request)
    {
        $fileName = 'curriculos.csv';
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $response = $this->resumeService->getResumeCsv($request);

        return response()->stream($response, 200, $headers);
    }

    /**
     * 
     */
    private function transformUserToResume($user)
    {
        $transformer = new UserTransformer();
        $includes = [
            'role',
            'race',
            'resume',
            'resume.companies',
            'resume.languages',
            'resume.occupations',
            'resume.status',
            'resume.vacancyType',
            'state',
            'city',
            'rgState'
        ];

        return Fractal::item($user)
            ->parseIncludes($includes)
            ->transformWith($transformer)
            ->toArray();
    }

    /**
     * 
     */
    private function handleEmptyValues($user)
    {
        $emptyValue = 'Não informado';
        $user['cellphone2'] = $user['cellphone2'] ?? $emptyValue;
        $user['resume']['linkedin'] = $user['linkedin'] ?? $emptyValue;
        $user['resume']['lattes'] = $user['lattes'] ?? $emptyValue;
        $user['resume']['video'] = $user['video'] ?? $emptyValue;

        if ($user['sex'] == 0) {
            $user['sex'] = $user['otherSex'];
        } else if ($user['sex'] == 1) {
            $user['sex'] = 'Feminino';
        } else if ($user['sex'] == 2) {
            $user['sex'] = 'Masculino';
        } else if ($user['sex'] == 3) {
            $user['sex'] = 'Prefiro não responder';
        }

        $user['father'] = $user['father'] ?? $emptyValue;

        if ($user['civil'] == 0) {
            $user['civil'] = $user['otherCivil'];
        } else if ($user['civil'] == 1) {
            $user['civil'] = 'Solteiro';
        } else if ($user['civil'] == 2) {
            $user['civil'] = 'Casado';
        } else if ($user['civil'] == 3) {
            $user['civil'] = 'Divorciado';
        }

        if ($user['volunteerWork'] == 1) {
            $user['volunteerWork'] = 'Sim';
        } else {
            $user['volunteerWork'] = 'Não';
        }

        if ($user['hasChildren'] == 0) {
            $user['hasChildren'] = $user['otherHasChildren'];
        } else if ($user['hasChildren'] == 1) {
            $user['hasChildren'] = 'Não';
        } else if ($user['hasChildren'] == 2) {
            $user['hasChildren'] = 'Sim';
        }

        $user['whoHelps'] = $user['whoHelps'] ?? $emptyValue;
        $user['accident'] = $user['accident'] ?? $emptyValue;
        $user['smoke'] = $user['smoke'] ?? $emptyValue;
        $user['timeAvailability'] = $user['timeAvailability'] ?? $emptyValue;
        $user['workWeekends'] = $user['workWeekends'] ?? $emptyValue;
        $user['missWork'] = $user['missWork'] ?? $emptyValue;

        $user['resume']['salary'] = $user['resume']['salary'] ?? $emptyValue;

        $typeWorking = $user['resume']['typeWorking'];
        $userTypeWorking = $emptyValue;
        if ($typeWorking == 1) {
            $userTypeWorking = 'Integral';
        } else if ($typeWorking == 2) {
            $userTypeWorking = 'Home Office';
        } else if ($typeWorking == 3) {
            $userTypeWorking = 'Flexível';
        } else if ($typeWorking == 4) {
            $userTypeWorking = 'Meio Período (noturno, matutino ou vespertino)';
        }
        $user['resume']['typeWorking'] = $userTypeWorking;

        $typeContract = $user['resume']['typeContract'];
        $userTypeContract = $emptyValue;
        if ($typeContract == 1) {
            $userTypeContract = 'CLT (Carteira Assinada)';
        } else if ($typeContract == 2) {
            $userTypeContract = 'PJ (Pessoa Jurídica)';
        } else if ($typeContract == 3) {
            $userTypeContract = 'Freelancer';
        }
        $user['resume']['typeContract'] = $userTypeContract;

        $user['resume']['courses'] = $user['resume']['courses'] ?? $emptyValue;
        $user['resume']['firstJob'] = $user['resume']['firstJob'] ?? $emptyValue;
        $user['resume']['unemployedTime'] = $user['resume']['unemployedTime'] ?? $emptyValue;
        $user['resume']['laborActivity'] = $user['resume']['laborActivity'] ?? $emptyValue;

        $user['resume']['lastSalary'] = $user['resume']['lastSalary'] ?? $emptyValue;
        $user['resume']['abstract'] = $user['resume']['abstract'] ?? $emptyValue;
        $user['resume']['reference'] = $user['resume']['reference'] ?? $emptyValue;

        $user['hobbies'] = $user['hobbies'] ?? $emptyValue;

        if ($user['availableTravel'] == 1) {
            $user['availableTravel'] = 'Sim';
        } else {
            $user['availableTravel'] = 'Não';
        }


        return $user;
    }

    /**
     * 
     */
    private function getResumePolicies()
    {
        $isSadmin = auth()->user()->isSadmin();
        return (object) [
            'details' => true,
            'edit'    => false,
            'delete'  => $isSadmin
        ];
    }
}
