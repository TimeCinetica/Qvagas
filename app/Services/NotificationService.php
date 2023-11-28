<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

use App\Mails\ForgotPassword;
use App\Mails\ResetAdminPassword;
use App\Mails\Welcome;

class NotificationService
{
    public function __construct()
    {
        //
    }

    public function sendWelcomeEmail($user)
    {
        $template = new Welcome($user);
        $this->sendEmail($user->email, $template);
    }

    /**
     * 
     */
    public function sendForgotEmail($user)
    {
        $template = new ForgotPassword($user);
        $this->sendEmail($user->email, $template);
    }

    /**
     * 
     */
    public function sendResetPassordEmail($user)
    {
        $template = new ResetAdminPassword($user);
        $this->sendEmail($user->email, $template);
    }

    /**
     * 
     */
    private function sendEmail($recipient, $template)
    {
        $mailTo = Mail::to($recipient);
        $mailTo->send($template);
    }
}
