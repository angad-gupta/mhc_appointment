<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\ScheduleDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Display all schedule by doctor
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function schedule()
    {
        return view('operations.schedule.my-schedule', [
            'schedules' => Schedule::where('doctor_id', auth()->user()->doctor->id)->get()
        ]);
    }


    /**
     * Display new schedule create page
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createSchedule($id)
    {
        if ($this->isValidScheduleId($id)) {
            return view('operations.schedule.create', [
                'schedule' => Schedule::where('id', $id)->where('doctor_id', auth()->user()->doctor->id)->firstOrFail()
            ]);
        } else {
            abort(403);
        }
    }

    /**
     * Store schedule into database
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeSchedule(Request $request)
    {
        $this->validate($request, [
            'schedule_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        $scheduleId = encrypt($request->schedule_id);
        
        $getScheduleDetails = ScheduleDetails::where('schedule_id', $request->schedule_id)->get();
        
        //insert if there is no previous schedule
        if($getScheduleDetails->count() < 1) {
            $schedule_details =ScheduleDetails::create([
                'schedule_id' => $scheduleId,
                'start_time' => date('H:i:s',strtotime($request->start_time)),
                'end_time' => date('H:i:s',strtotime($request->end_time)),
            ]);
            // $schedule_details = new ScheduleDetails();
            // $schedule_details->fill($request->all());
            if ($schedule_details) {
                return redirect('/settings/schedule')->with([
                    'success' => 'Schedule has been created successfully.' 
                ]);            
            } 
        } else {
            $scheduleOverlap = 'false';

            foreach ($getScheduleDetails as $scheduleDetail) {
                $startTime = date('H:i:s',strtotime($request->start_time));
                $endTime = date('H:i:s',strtotime($request->end_time));
    
                $scheduledStartTime = $scheduleDetail->start_time;
                $scheduledEndTime = $scheduleDetail->end_time;
                //check if schedule already exist
                if(($startTime > $scheduledStartTime && $startTime >= $scheduledEndTime)) {
                    $scheduleOverlap = 'false';
                } else if(($startTime < $scheduledStartTime && $endTime <= $scheduledStartTime)) {
                    $scheduleOverlap = 'false';
                } else {
                    return redirect('/settings/schedule')->with([
                        'error' => 'Time range has been overlapped.' 
                    ]);  
                }
            }

            //only insert if schedule does not overlap
            if($scheduleOverlap == 'false') {
                $schedule_details =ScheduleDetails::create([
                    'schedule_id' => $scheduleId,
                    'start_time' => date('H:i:s',strtotime($request->start_time)),
                    'end_time' => date('H:i:s',strtotime($request->end_time)),
                ]);

                if ($schedule_details) {
                    return redirect('/settings/schedule')->with([
                        'success' => 'Schedule has been created successfully.' 
                    ]);  
                }
            } 
        }
        
    }

    /**
     * Check the given schedule id is valid
     *
     * @param $id
     * @return bool
     */
    private function isValidScheduleId($id): bool
    {
        $schedule = Schedule::where('id', $id)->where('doctor_id', auth()->user()->doctor->id)->first();
        if ($schedule == null) {
            return false;
        }
        return true;
    }

    public function getSchedulesByDate(Request $request, $date)
    {
        $day = Carbon::parse($date)->format('l');

        $schedule = Schedule::where('day', $day)
            ->where('doctor_id', decrypt($request->query('doctor_id')))
            ->with('scheduleDetails')
            ->first();
        return response()->json($schedule);
    }

    public function edit($id)
    {
        $schedule_details = ScheduleDetails::findOrFail(decrypt($id));
        return view('operations.schedule.edit', [
            'schedule_details' => $schedule_details
        ]);
    }

    public function updateSchedule(Request $request, $id)
    {
        $this->validate($request, [
            'schedule_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        $detailId = decrypt($id);
        $scheduleId = decrypt($request->schedule_id);
        
        $deleted = ScheduleDetails::where('id', $detailId)->delete();

        if($deleted) {
            
            $getScheduleDetails = ScheduleDetails::where('schedule_id', $scheduleId)->get();
            
            //insert if there is no previous schedule
            if($getScheduleDetails->count() < 1) {
                $schedule_details =ScheduleDetails::create([
                    'schedule_id' => $request->schedule_id,
                    'start_time' => date('H:i:s',strtotime($request->start_time)),
                    'end_time' => date('H:i:s',strtotime($request->end_time)),
                ]);
                // $schedule_details = new ScheduleDetails();
                // $schedule_details->fill($request->all());
                if ($schedule_details) {
                    return back()->with([
                        'success' => 'Schedule has been updated successfully.' 
                    ]);            
                } 
            } else {
                $scheduleOverlap = 'false';

                foreach ($getScheduleDetails as $scheduleDetail) {
                    $startTime = date('H:i:s',strtotime($request->start_time));
                    $endTime = date('H:i:s',strtotime($request->end_time));
        
                    $scheduledStartTime = $scheduleDetail->start_time;
                    $scheduledEndTime = $scheduleDetail->end_time;
                    //check if schedule already exist
                    if(($startTime > $scheduledStartTime && $startTime >= $scheduledEndTime)) {
                        $scheduleOverlap = 'false';
                    } else if(($startTime < $scheduledStartTime && $endTime <= $scheduledStartTime)) {
                        $scheduleOverlap = 'false';
                    } else {
                        return back()->with([
                            'error' => 'Time range has been overlapped.' 
                        ]);                       
                    }
                }

                //only insert if schedule does not overlap
                if($scheduleOverlap == 'false') {
                    $schedule_details =ScheduleDetails::create([
                        'schedule_id' => $request->schedule_id,
                        'start_time' => date('H:i:s',strtotime($request->start_time)),
                        'end_time' => date('H:i:s',strtotime($request->end_time)),
                    ]);

                    if ($schedule_details) {
                        return back()->with([
                            'success_edit' => 'Schedule has been updated successfully.' 
                        ]); 
                    }
                } 
            }
        }

        // $schedule_details = ScheduleDetails::findOrFail(decrypt($id));
        // $schedule_details->fill($request->all());
        // $schedule_details->schedule_id = decrypt($request->schedule_id);
        // if ($schedule_details->save()) {
        //     return response()->json([__('actions.success'), trans_choice('actions.success_message', 1, ['attribute' => __('schedule.schedule')])], 200);
        // }
    }

    public function deleteSchedule(Request $request, $id)
    {
        if (ScheduleDetails::destroy(decrypt($id))) {
            return redirect()->back()->with('success', trans_choice('actions.delete_message', 1, ['attribute' => __('schedule.schedule')]));
        } else {
            return redirect()->back()->with('error', 'Cannot delete schedule');
        }
    }

}
