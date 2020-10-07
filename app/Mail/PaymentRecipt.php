<?php

namespace App\Mail;

use App\Models\PatientPayment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentRecipt extends Mailable
{
    use Queueable, SerializesModels;

    public $payment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(PatientPayment $patientPayment)
    {
        $this->payment = $patientPayment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.payment');
    }
}
