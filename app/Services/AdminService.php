<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminService
{
    protected $user;
    protected $utilsService;
    protected $notificationService;

    public function __construct(
        User $user,
        UtilsService $utilsService,
        NotificationService $notificationService
    ) {
        $this->user = $user;
        $this->utilsService = $utilsService;
        $this->notificationService = $notificationService;
    }

    /**
     * @param Request $request
     */
    public function indexAdmins($request)
    {
        $query = $this->adminsQuery($request);
        $query->with('role');

        $admins = $query->paginate(10);
        return $admins;
    }

    /**
     * @param int $userId
     */
    public function delete($userId)
    {
        $this->user->destroy($userId);
        return true;
    }


    /**
     * Cria novo admin
     * 
     * @param StoreAdminRequest $request
     * @return User $admin
     */
    public function newAdmin($request)
    {
        $cpf = preg_replace('/[^0-9]/', '', $request->cpf);
        $this->utilsService->validateCpf($cpf);

        // Fill required fields for users table
        $request->merge([
            'cpf'           => $cpf,
            'created_at'    => now(),
            'updated_at'    => now(),
            'birthDate'     => empty($request->date) ? now() : $request->date,
            'cellphone'     => empty($request->tel) ? $cpf : $request->tel,
            'schooling'     => 'sadmin',
            'cep'           => '29111111',
            'address'       => 'admin',
            'number'        => '123',
            'district'      => 'sadmin',
            'city'          => 'sadmin',
            'sex'           => 3,
            'rg'            => 'sadmin',
            'mother'        => 'sadmin',
            'civil'         => 0,
            'volunteerWork' => 1,
            'hasChildren'   => 0,
            'availableTravel' => 1,
            'admin_responsed' => $request->admin_responsed,
            'job'           => $request->job,
        ]);

        $admin = null;
        DB::transaction(function () use ($request, &$admin) {
            $admin = $this->user->create($request->all());
            //aqui está a linha para descomentar futuramente (aqui manda a mensagem de email)
            //$this->notificationService->sendResetPassordEmail($admin);
        });

        return $admin;
    }

    /**
     * Define nova senha para admin
     * 
     * @param ResetAdminPasswordRequest $request
     * @return User $admin
     */
    public function setPassword($request)
    {
        $request->merge(['passwordResetedAt' => now()]);
        $admin = auth()->user();
        $admin->update($request->all());

        return $admin;
    }

    /**
     * 
     */
    private function adminsQuery($request)
    {
        $query = $this->user->query();

        $query->where(function ($q) {
            $q->where('roleId', Role::SuperAdmin)
                ->orWhere('roleId', Role::Admin);
        });

        if ($request->has('name')) {
            $query->orderBy('name', $request->name);
        } else {
            $query->orderBy('name', 'asc');
        }

        if (isset($request->search)) {
            $name = trim($request->search);
            $name = str_replace(" ", '%', $name);
            $query->where('name', 'like', '%' . $request->search . '%');
        }


        return $query;
    }
}
