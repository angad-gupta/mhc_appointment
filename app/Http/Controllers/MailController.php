<?php

namespace App\Http\Controllers;

use App\Mail\FollowupMail;
use App\Mail\PaymentRecipt;
use App\Mail\PrescriptionMail;
use App\Models\Appointment;
use App\Models\PatientPayment;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    /**
     * Send prescription mail to given email address
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function prescription(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $prescription = Prescription::findOrFail(decrypt($request->prescription_id));
        try {
            Mail::to($request->email)->send(new PrescriptionMail($prescription));
        } catch (\Exception $exception) {
            abort(500);
        }
        return redirect()->back()->with('success', 'Prescription has been send to ' . $request->email);

    }

    /**
     * Send payment receipt mail to given email address
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payment(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $patient_payment = PatientPayment::findOrFail(decrypt($request->payment_id));
        try {
            Mail::to($request->email)->send(new PaymentRecipt($patient_payment));
        } catch (\Exception $exception) {
            throw  $exception;
//            abort(500);
        }


        return redirect()->back()->with('success', 'Payment receipt has been send to ' . $request->email);
    }

    /**
     * Send follow up mail
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function followUp(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $appointment = Appointment::findOrFail(decrypt($request->appointment_id));
        try{
            Mail::to($request->email)->send(new FollowupMail($appointment, $request->follow_up_note));
        }catch (\Exception $exception){
            abort(500);
        }
        return redirect()->back()->with('success', 'Mail send to ' . $request->email);
    }
}
