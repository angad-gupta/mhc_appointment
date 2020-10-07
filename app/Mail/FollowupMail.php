<?php

namespace App\Mail;

use App\Models\Appointment;
use App\Models\AppointmentFollowUpNote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FollowupMail extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment, $note;

    /**
     * FollowupMail constructor.
     * @param AppointmentFollowUpNote $appointmentFollowUpNote
     */
    public function __construct(Appointment $appointment, $note)
    {
        $this->appointment = $appointment;
        $this->note = $note;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.followup');
    }
}
