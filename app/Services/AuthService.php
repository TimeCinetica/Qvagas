<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Check if user is sadmin
     */
    public function isSadmin()
    {
        $user = $this->authenticatedUser();
        return isset($user) && $user->isSadmin();
    }

    /**
     * Check if user is admin
     */
    public function isAdmin()
    {
        $user = $this->authenticatedUser();
        return isset($user) && $user->isAdmin();
    }

    /**
     * Check if a valid user
     */
    public function isUser()
    {
        $user = $this->authenticatedUser();
        return isset($user) && $user->isUser();
    }

    /**
     * Check if a user is collaborator
     */
    public function isCollaborator()
    {
        $user = $this->authenticatedUser();
        return isset($user) && $user->isCollaborator();
    }

    /**
     * Check if requester has access to resume
     * @param int $userId
     */
    public function hasResumeAccess($userId)
    {
        $user = $this->authenticatedUser();
        return isset($user) && ($user->isAdmin() || $user->id == $userId);
    }

    public function hasPaycheckAccess($userId)
    {
        $user = $this->authenticatedUser();
        return isset($user) && ($user->isAdmin() || $user->id == $userId);
    }


    /**
     * Check if admin has password setted
     */
    public function hasPasswordReseted()
    {
        $user = $this->authenticatedUser();
        return isset($user) && isset($user->passwordResetedAt);
    }

    /**
     * Check and return authenticated user
     */
    private function authenticatedUser()
    {
        return Auth::check() ? Auth::user() : null;
    }
}
