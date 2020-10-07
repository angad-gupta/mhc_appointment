<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;

class PatientUserResetPasswordEmail extends Mailable
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
        return $this->to($this->user->email)->view('mail.patientuserresetpassword')->with('name',$this->user->name)->with('token',$this->token);
    }
}
