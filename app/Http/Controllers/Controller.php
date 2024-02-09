<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\ResumeService;
use App\Services\UserService;
use App\Transformers\PerformanceTransformer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Spatie\Fractal\Facades\Fractal;
use App\Models\Paycheck;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $userService;
    protected $resumeService;
    protected $authService;

    public function __construct(
        UserService $userService,
        ResumeService $resumeService,
        AuthService $authService
    ) {
        $this->userService = $userService;
        $this->resumeService = $resumeService;
        $this->authService = $authService;
    }

    /**
     * 
     */
    public function renderHome()
    {
        $user = auth()->user();
        if ($user->isAdmin()) {
            return $this->renderAdminHome();
        } elseif ($user->isCollaborator()) {
            return $this->renderCollaboratorHome($user);
        } else {
            return $this->renderUserHome($user);
        }
    }

    /**
     * 
     */
    public function getFile($folder, $file)
    {
        return response()->file(storage_path("app/$folder/$file"));
    }

    /**
     * 
     */
    protected function transformUserToPerformance($user)
    {
        $transformer = new PerformanceTransformer();
        $userTransformed = Fractal::item($user)
            ->transformWith($transformer)
            ->toArray();

        return $userTransformed;
    }

    /**
     * 
     */
    private function renderUserHome($user)
    {
        $performance = $this->transformUserToPerformance($user);
        $logged = auth()->user();

        return view('user.home', ['user' => $performance, 'roleId' => $logged->roleId]);
    }

    /**
     * 
     */
    private function renderAdminHome()
    {
        if (!$this->checkAdminPassword()) {
            return redirect('admin/set-password');
        }

        $deprecatedResumes = $this->resumeService->countDeprecatedResumes();
        $totalResumes = $this->resumeService->countTotal();
        $stampedResumes =  $this->resumeService->countStamped();
        $evaluatedResumes = $this->resumeService->countEvaluated();

        return view('admin.home', [
            'deprecated' => $deprecatedResumes,
            'total'      => $totalResumes,
            'stamped'    => $stampedResumes,
            'evaluated'  => $evaluatedResumes,
        ]);
    }

    /**
     * 
     */
    private function renderCollaboratorHome($user)
    {
        $performance = $this->transformUserToPerformance($user);
        $logged = auth()->user();

        // Buscar contracheques do usuário autenticado
        $paychecks = Paycheck::where('nameUser', $logged->name)->get();

        return view('collaborator.home', ['paychecks' => $paychecks]);
    }

    /**
     * 
     */
    private function checkAdminPassword()
    {
        $hasPasswordReseted = $this->authService->hasPasswordReseted();

        if (!$hasPasswordReseted) {
            return false;
        }

        return true;
    }
}
