<?php

namespace App\Mail;

use App\Models\Prescription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PrescriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    public $prescription;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Prescription $prescription)
    {
        $this->prescription = $prescription;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.prescription');
    }
}
