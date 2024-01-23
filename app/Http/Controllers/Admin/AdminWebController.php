<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\ResetAdminPasswordRequest;
use App\Services\AdminService;
use App\Services\ResumeService;
use Illuminate\Http\Request;

class AdminWebController extends Controller
{
    protected $adminService;
    protected $resumeService;

    public function __construct(
        AdminService $adminService,
        ResumeService $resumeService
    ) {
        $this->adminService = $adminService;
        $this->resumeService = $resumeService;
    }

    /**
     * 
     */
    public function renderList(Request $request)
    {
        $policies = $this->getPolicies();
        $admins = $this->adminService->indexAdmins($request);
        return view('admin.list', ['data' => $admins, 'policies' => $policies]);
    }

    /**
     * 
     */
    public function renderNewAdmin()
    {
        return view('admin.new');
    }


    /**
     * 
     */
    public function renderSetPassword()
    {
        $user = auth()->user();
        return view('admin.setPassword', ['user' => $user]);
    }

    /**
     * 
     */
    public function renderInfos()
    {
        $deprecatedResumes = $this->resumeService->countDeprecatedResumes();
        $totalResumes = $this->resumeService->countTotal();
        $stampedResumes =  $this->resumeService->countStamped();
        $evaluatedResumes = $this->resumeService->countEvaluated();

        return view('admin.infos', [
            'deprecated' => $deprecatedResumes,
            'total'      => $totalResumes,
            'stamped'    => $stampedResumes,
            'evaluated'  => $evaluatedResumes,
        ]);
    }

    /**
     * Set admin password
     */
    public function setPassword(ResetAdminPasswordRequest $request)
    {
        $user = $this->adminService->setPassword($request);
        return response()->json($user, 200);
    }

    /**
     * 
     */
    public function delete($id)
    {
        $this->adminService->delete($id);
        return response()->noContent();
    }

    /**
     * Create new admin
     */
    public function newAdmin(StoreAdminRequest $request)
    {
        $admin = $this->adminService->newAdmin($request);
        return response()->json($admin, 201);
    }

    /**
     * 
     */
    private function getPolicies()
    {
        return (object) [
            'details' => false,
            'edit'    => false,
            'delete'  => true,
        ];
    }
    public function teste(){
        
    }
}
