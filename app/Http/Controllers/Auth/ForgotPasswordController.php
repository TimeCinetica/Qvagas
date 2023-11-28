<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Services\UserService;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }


    /**
     * @hideFromAPIDocumentation
     */
    public function renderForgotPassword()
    {
        return view('auth.forgotPassword');
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $response = $this->userService->sendForgotPassword($request);
        return response()->json($response, 200);
    }
}
