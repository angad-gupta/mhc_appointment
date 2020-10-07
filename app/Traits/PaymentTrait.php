<?php


namespace App\Traits;


use App\Models\PatientPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;

trait PaymentTrait
{

    /**
     * Filter patient payment by request query
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function filterPayment(Request $request)
    {

        $payment = PatientPayment::query();

        if ($request->query('patient') != null) {
            $payment->where('patient_id', $request->query('patient'));
        }

        if ($request->query('taken_by') != null) {
            $payment->where('created_by', $request->query('taken_by'));
        }

        if ($request->query('doctor') != null) {
            $payment->where('doctor_id', $request->query('doctor'));
        }

        if ($request->query('date_range') != null) {
            $date_from = Carbon::parse(explode('to ', $request->query('date_range'))[0])->toDateString();
            $date_to = Carbon::parse(explode('to ', $request->query('date_range'))[1])->toDateString();
            $payment->whereBetween('created_at', [$date_from, $date_to]);
        }

        if ($request->query('sort_by') != null) {
            $payment->orderBy('id', $request->query('sort_by'));
        }

        return $payment;
    }
}