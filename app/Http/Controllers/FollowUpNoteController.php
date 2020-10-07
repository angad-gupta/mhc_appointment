<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\AppointmentFollowUpNote;

class FollowUpNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $appointment_id = decrypt($request->query('appointment'));
        } catch (\Exception $e) {
            abort(404);
        }
        return view('operations.appointment-follow-up.create', [
            'appointment' => Appointment::findOrFail($appointment_id)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $followUpNote = new AppointmentFollowUpNote();
        $followUpNote->appointment_id = $request->appointment_id;
        $followUpNote->note = $request->note;

        $followUpNote->save();        

        if ($followUpNote->save()) {
            $this->updateAppointmentFollowUpStatus($followUpNote, $request);
            return redirect()->back()->with('success', __('actions.success_message', ['attribute' => __('appointment.follow_up')]));
        }
    }

    private function updateAppointmentFollowUpStatus(AppointmentFollowUpNote $appointmentFollowUpNote, $request)
    {
        $appointment = Appointment::where('id', $appointmentFollowUpNote->appointment_id)->first();
        if ($appointment->follow_up_status != 2) {
            $appointment->follow_up_status = 1;
            $appointment->schedule_date = Carbon::parse($request->schedule_date);
            $appointment->schedule_time = $request->schedule_time;
            $appointment->save();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $follow_up_id = decrypt($id);
        } catch (\Exception $ex) {
            abort(404);
        }
        return view('operations.appointment-follow-up.edit', [
            'appointment_follow_up_note' => AppointmentFollowUpNote::findOrFail($follow_up_id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $follow_up_id = decrypt($id);
        } catch (\Exception $ex) {
            abort(404);
        }

        $followUpNote = AppointmentFollowUpNote::findOrFail($follow_up_id);
        $followUpNote->appointment_id = decrypt($request->appointment_id);
        $followUpNote->note = $request->note;

        if ($followUpNote->save()) {
            $this->updateAppointmentFollowUpStatus($followUpNote, $request);
            return redirect()->back()->with('success', 'Appointment Follow up note has been save successfully');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $follow_up_id = decrypt($id);
        } catch (\Exception $ex) {
            abort(404);
        }
        if (AppointmentFollowUpNote::destroy($follow_up_id)) {
            return redirect()->back()->with('success', 'Followup not has been deleted successfully');
        }
    }
}
