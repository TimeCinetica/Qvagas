<?php

namespace App\Mails;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Welcome extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $subject = ' [Quallity Psi] Boas Vindas ao Portal QVagas';
    protected $template = 'mail.welcome';

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->view($this->template);
    }
}
