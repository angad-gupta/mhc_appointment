<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorRequest;
use App\Mail\ApproveDoctorEmail;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Schedule;
use App\Traits\DeleteTrait;
use App\Traits\DoctorFilter;
use App\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Mail;
use Illuminate\Validation\Rule;
use PhpParser\Comment\Doc;

class DoctorController extends Controller
{

    use DeleteTrait, DoctorFilter;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('operations.doctor.index', [
            'doctors' => $this->getFeltedDoctor($request)->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('operations.doctor.create', [
            'departments' => Department::where('status', 1)->orderBy('title', 'asc')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DoctorRequest $request)
    {

        $this->validate($request, [
            'email' => 'nullable|unique:users',
            'user_name' => 'nullable|unique:users',
            'password' => 'required',
            'password_confirmation' => 'required'
        ]);

        $user = new User();
        $user->role = 2;
        $user->password = bcrypt($request->password);
        $user->photo = save_image($request->image, '/uploads/doctors/user/', 400);
        $user->fill($request->all());
        if ($user->save()) {
            $doctor = new Doctor();
            $doctor->photo = save_image($request->image, '/uploads/doctors/', null, 800);
            $doctor->user_id = $user->id;
            $doctor->featured = $request->featured == 'on' ? 1 : 0;
            $doctor->video_consultation = $request->video_consultation == 'on' ? 1 : 0;
            $doctor->fill($request->all());
            if ($doctor->save()) {
                $this->saveSchedule($doctor);
                return response()->json([__('actions.success'),
                    trans_choice('actions.success_message', 1, ['attribute' => __('doctor.doctor')])], 200);
            }
        }
    }

    public function DoctorApprove($id)
    {
        
            $doctor_id = decrypt($id);
            $doctor = Doctor::find($doctor_id);
            $user = User::find($doctor->user_id);
            $doctor->doctor_status = "approved";
            $user->status = 1;
            $user->save();
            $doctor->save();

            Mail::to($user->email)->send(new ApproveDoctorEmail($user));
            
            return redirect()->back();
    
    }

    public function DoctorReject($id)
    {
        
            $doctor_id = decrypt($id);
            $doctor = Doctor::find($doctor_id);
            $user = User::find($doctor->user_id);
            $doctor->doctor_status = "rejected";
            $user->status = 0;
            $user->save();
            $doctor->save();
            return redirect()->back();
    
    }
    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $doctor_id = decrypt($id);
        } catch (\Exception $ex) {
            abort(404);
        }
        return view('operations.doctor.show', [
            'doctor' => Doctor::findOrFail($doctor_id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('operations.doctor.edit', [
            'doctor' => Doctor::findOrFail(decrypt($id)),
            'departments' => Department::where('status', 1)->orderBy('title', 'asc')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(DoctorRequest $request, $id)
    {
        $doctor = Doctor::findOrFail(decrypt($id));
        if ($request->password != null) {
            $this->validate($request, [
                'password_confirmation' => 'required'
            ]);
        }

        $this->validate($request, [
            'email' => "unique:users,email," . $doctor->user->id,
            'user_name' => 'required|unique:users,user_name,' . $doctor->user->id
        ]);

        if ($request->hasFile('image')) {
            $doctor->photo = save_image($request->image, '/uploads/doctors/', null, 800);
        }
        $doctor->featured = $request->featured == 'on' ? 1 : 0;
        $doctor->video_consultation = $request->video_consultation == 'on' ? 1 : 0;
        $doctor->fill($request->all());
        if ($doctor->save()) {
            $user = User::findOrFail($doctor->user->id);
            $user->status = $request->status == 'on' ? 1 : 0;
            if ($request->password != null) {
                $user->password = bcrypt($request->password);
            }
            $user->fill($request->all());
            if ($request->hasFile('image')) $user->photo = save_image($request->image, '/uploads/doctors/user/', 400);
            $user->save();
            return response()->json([__('actions.success'),
                trans_choice('actions.update_message', 1, ['attribute' => __('doctor.doctor')])], 200);
        }
    }


    /**
     * Update doctor profile
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $doctor = Doctor::findOrFail(auth()->user()->doctor->id);
        if ($request->hasFile('image')) {
            $doctor->photo = save_image($request->image, '/uploads/doctors/', 200);
        }
        $doctor->video_consultation = $request->video_consultation == 'on' ? 1 : 0;
        $doctor->fill($request->all());
        if ($doctor->save()) {
            return response()->json(['Success', 'Profile has been updated'], 200);
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
        $doctor = Doctor::findOrFail(decrypt($id));
        $user = User::findOrFail($doctor->user_id);

        if ($this->isEmptyDoctorsRelatedData($user)) {
            $doctor->delete();
            $user->delete();
            if (request()->method('delete')) {
                return redirect()->route('doctor.index')->with('success', __('doctor.success_message'));
            }
            return redirect()->back()->with('success', __('doctor.success_message'));
        } else {
            if (request()->method('delete')) {
                return redirect()->route('doctor.index')->with('error', 'System cannot delete this doctor until related data has been deleted');
            }
            return redirect()->back()->with('error', 'System cannot delete this doctor until related data has been deleted');
        }


    }


    /**
     * Save schedule while creating a doctor
     *
     * @param Doctor $doctor
     */
    private function saveSchedule(Doctor $doctor)
    {
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        foreach ($days as $key => $day) {
            $schedule = new Schedule();
            $schedule->day = $day;
            $schedule->day_index = $key;
            $schedule->doctor_id = $doctor->id;
            $schedule->save();
        }
    }

    /**
     * Get doctor by encrypted id
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDoctorByEncId($id)
    {
        return response()->json(Doctor::findOrFail(decrypt($id)));
    }
}
