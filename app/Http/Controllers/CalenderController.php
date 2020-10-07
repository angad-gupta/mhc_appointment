<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\ScheduleDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;
use function Symfony\Component\Debug\Tests\testHeader;

class CalenderController extends Controller
{
    /**
     * Resource Calender
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('operations.calender.index', [
            'schedules' => Schedule::all()
        ]);
    }

    /**
     * Get appointment as json by date range
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function events(Request $request)
    {
        return response()->json($this->appointments($request));
    }

    /**
     * Get all appointment by date
     *
     * @param $date
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEventsByDate($date)
    {
        try {
            $date = Carbon::parse($date)->toDateString();
        } catch (\Exception $ex) {
            abort(404);
        }

        $appointment = Appointment::whereDate('schedule_date', $date)->with('doctor')->with('patient')->with('createdBy');

        if (auth()->user()->role == 2) {
            $appointment->where('doctor_id', auth()->user()->doctor->id);
        }

        if (auth('extra_user')->check()) {
            $appointment->where('patient_id', auth('extra_user')->user()->patient->id);
        }

        return response()->json($appointment->get());
    }

    /**
     * Filter Appointment by auth role and date range
     *
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    private function appointments(Request $request)
    {
        $appointment = Appointment::query();
        if (auth()->user()->role == 2) {
            $appointment->where('doctor_id', auth()->user()->doctor->id);
        }
        if ($request->query('start') != null && $request->query('end') != null) {
            $start = Carbon::parse($request->query('start'))->toDateString();
            $end = Carbon::parse($request->query('end'))->toDateString();
            $appointment->whereBetween('schedule_date', [$start, $end]);
        }

        if (auth()->user()->role == 2) {
            $appointment->where('doctor_id', auth()->user()->doctor->id);
        }

        if (auth('extra_user')->check()) {
            $appointment->where('patient_id', auth('extra_user')->user()->patient->id);
        }

        return $appointment->get();
    }
}
