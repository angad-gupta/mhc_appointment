<?php


namespace App\Traits;


use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait AppointmentFilter
{
    /**
     * Appointment Filter by request query
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function appointmentFilter(Request $request)
    {
        $appointments = Appointment::query();
        
        if ($request->query('status') != null) {
            $appointments->where('status', $request->query('status'));
        }

        if ($request->query('patient') != null && $request->query('patient') != 'dd') {
            $appointments->where('patient_id', $request->query('patient'));
        }

        if ($request->query('appointment_id') != null) {
            $appointments->where('search_id', 'like', '%' . $request->query('appointment_id') . '%');
        }

        if ($request->query('date_range') != null) {
            $date_from = Carbon::parse(explode('to ', $request->query('date_range'))[0])->toDateString();
            $date_to = Carbon::parse(explode('to ', $request->query('date_range'))[1])->toDateString();
            $appointments->whereBetween('schedule_date', [$date_from, $date_to]);
        }
        if ($request->query('doctor') != null && $request->query('doctor') != 'dd') {
            $appointments->where('doctor_id', $request->query('doctor'));
        }

        if (auth()->user()->role == 2) {
            $appointments->where('doctor_id', auth()->user()->doctor->id);
        }

        if ($request->query('sort_by') != null) {
            $appointments->orderBy('id', $request->query('sort_by'));
        } else {
            $appointments->orderBy('id', 'desc');
        }



        return $appointments;
    }


    /**
     * Follow up filter query
     *
     * @param Request $request
     * @return mixed
     */
    public function followUpFilter(Request $request)
    {
        $appointments = Appointment::where('next_followup', '!=', null);

        if (auth()->user()->role == 2) {
            $appointments->where('doctor_id', auth()->user()->doctor->id);
        }

        if (auth('extra_user')->check()) {
            $appointments->where('patient_id', auth()->user()->patient->id);
        }

        if ($request->query('appointment_id') != null) {
            $appointments->where('search_id', 'like', '%' . $request->query('appointment_id') . '%');
        }

        if ($request->query('date_range') != null) {
            $date_from = Carbon::parse(explode('to ', $request->query('date_range'))[0])->toDateString();
            $date_to = Carbon::parse(explode('to ', $request->query('date_range'))[1])->toDateString();
            $appointments->whereBetween('next_followup', [$date_from, $date_to]);
        }

        if ($request->query('doctor') != null && $request->query('doctor') != 'dd') {
            $appointments->where('doctor_id', $request->query('doctor'));
        }

        if ($request->query('patient') != null && $request->query('patient') != 'dd') {
            $appointments->where('patient_id', $request->query('patient'));
        }
        if ($request->query('sort_by') != null) {
            $appointments->orderBy('id', $request->query('sort_by'));
        }

        return $appointments;
    }
}