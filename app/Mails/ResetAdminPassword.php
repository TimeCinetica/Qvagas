<?php

namespace App\Mails;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetAdminPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $subject = '[QVagas] Conta cadastrada';
    protected $template = 'mail.resetAdminPassword';

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->template);
    }
}
