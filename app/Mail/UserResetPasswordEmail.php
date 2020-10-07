<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class UserResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user, $token;
    
    public function __construct(User $user, $token)
    {
        $this->token = $token;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->user->email)->view('mail.userresetpassword')->with('name',$this->user->name)->with('token',$this->token);
    }
}
