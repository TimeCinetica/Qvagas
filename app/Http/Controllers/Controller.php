<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
use App\Models\User;
use App\Services\PaycheckService;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $userService;
    protected $resumeService;
    protected $authService;
    protected $PaycheckService;

    public function __construct(
        UserService $userService,
        ResumeService $resumeService,
        AuthService $authService,
        PaycheckService $PaycheckService
    ) {
        $this->userService = $userService;
        $this->resumeService = $resumeService;
        $this->authService = $authService;
        $this->PaycheckService = $PaycheckService;;
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

     public function renderCollaboratorHome(User $user)
     {
         $paychecks= DB::table('paycheck')->where('nameUser', $user->name)->get();
         
         // Organize seus contracheques por ano
         $paychecksByYear = $paychecks->groupBy('year');
     
         foreach ($paychecksByYear as $year => $paychecks) {
             $paychecksByYear[$year] = $paychecks->sortBy(function ($paycheck) {
                 return substr($paycheck->month_year, 0, 2); // Extrai o número do mês de month_year
             });
         }
         
         return view('collaborator.home', [
             'user' => $user,
             'paychecksByYear' => $paychecksByYear,
         ]);
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
