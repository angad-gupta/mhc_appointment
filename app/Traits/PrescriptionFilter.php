<?php


namespace App\Traits;


use App\Models\Prescription;
use Carbon\Carbon;
use Illuminate\Http\Request;

trait PrescriptionFilter
{
    /**
     * Prescription filter by request query
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prescriptionFilter(Request $request)
    {
        $prescription = Prescription::query();

        if ($request->query('patient') != null && $request->query('patient') != 'dd') {
            $prescription->where('patient_id', $request->query('patient'));
        }

        if ($request->query('prescription') != null) {
            $prescription->where('search_id', 'like', '%' . $request->query('prescription') . '%');
        }

        if ($request->query('doctor') != null && $request->query('doctor') != 'dd') {
            $prescription->where('doctor_id', $request->query('doctor'));
        }

        if ($request->query('date_range') != null) {
            $date_from = Carbon::parse(explode('to ', $request->query('date_range'))[0])->toDateString();
            $date_to = Carbon::parse(explode('to ', $request->query('date_range'))[1])->toDateString();
            $prescription->whereBetween('created_at', [$date_from, $date_to]);
        }

        if (auth()->user()->role == 2) {
            $prescription->where('doctor_id', auth()->user()->doctor->id);
        }

        return $prescription;
    }
}