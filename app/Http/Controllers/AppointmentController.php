<?php

namespace App\Http\Controllers;

use Mail;
use Carbon\Carbon;
use App\Models\Doctor;
use http\Env\Response;
use App\Models\Patient;
use Twilio\Rest\Client;
use App\Models\VideoCall;
use App\Traits\Decrypter;
use App\Models\Department;
use App\Models\Appointment;
use Twilio\Jwt\AccessToken;
use Illuminate\Http\Request;
use App\Models\PatientPayment;
use App\Models\DoctorsPatients;
use App\Traits\AppointmentFilter;
use Twilio\Jwt\Grants\VideoGrant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\PatientAppointmentEmail;
use App\Http\Requests\AppointmentRequest;

class AppointmentController extends Controller
{
    use AppointmentFilter;

    protected $sid;
    protected $token;
    protected $key;
    protected $secret;

    public function __construct()
    {
        $this->sid = config('services.twilio.sid');
        $this->token = config('services.twilio.token');
        $this->key = config('services.twilio.key');
        $this->secret = config('services.twilio.secret');
    }

    public function index(Request $request)
    {
        $appointments = $this->appointmentFilter($request);
        $appointments = $appointments->whereHas('payments');

        // $payedAppointmentId = [];
        // $patientIds = [];
        // foreach ($appointments->get() as $appointment) {
        //     $app = PatientPayment::where('appointment_id', $appointment->id)->first();
        //     if($app && !(in_array($app->appointment_id, $payedAppointmentId))) {
        //         array_push($payedAppointmentId, $app->appointment_id);
        //     }

        //     //get the patient with payment success appointment
        //     if($app && !(in_array($app->patient_id, $patientIds))) {
        //         array_push($patientIds, $app->patient_id);
        //     }
        // }
        // //display appointments with payment success
        // $appointments = Appointment::whereIn('id', $payedAppointmentId);

        //get the patients
        // $patients = Patient::whereIn('id', $patientIds)->get();
        if(auth()->user()->role == 2)
            $patients = Patient::whereHas('payments', function($query){
                $query->where('doctor_id',auth()->user()->doctor->id);
            })->get();
        else
            $patients = Patient::whereHas('payments')->get();
        
        return view('operations.appointment.index', [
            'request' => $request,
            'appointments' => $appointments->paginate(10),
            'patients' => $patients
        ]);
    }

    public function followUp(Request $request)
    {

        return view('operations.appointment.follow-up', [
            'appointments' => $this->followUpFilter($request)->paginate(20),
            'doctors' => Doctor::all(),
            'request' => $request
        ]);
    }

    /**
     * Display on process appointment
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function onProcessAppointment()
    {
        if (auth()->user()->role == 2) {
            $appointments = Appointment::where('doctor_id', auth()->user()->doctor->id)->where('status', 4)->get();
        } else {
            $appointments = Appointment::where('status', 4)->get();
        }

        return view('operations.appointment.recent-appointments', [
            'appointments' => $appointments
        ]);
    }


    /**
     * Display recent appointments
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function recentAppointment()
    {
        $appointments = Appointment::whereBetween('schedule_date', array(Carbon::today(), Carbon::now()->addDay(2)))->get();
        if (auth()->user()->role == 2) {
            $appointments = $appointments->where('doctor_id', auth()->user()->doctor->id);
        }
        return view('operations.appointment.recent-appointments', [
            'appointments' => $appointments
        ]);
    }

    /**
     * return recent appointment in ajax datatbales
     *
     * @return mixed
     */
    public function appointmentsDatatable()
    {
        if (auth()->user()->role == 2) {
            $appointments = Appointment::where('doctor_id', auth()->user()->doctor->id)->get();
        } else {
            $appointments = Appointment::whereBetween('schedule_date', [Carbon::now()->subDay(1), Carbon::now()->addDay(6)])->get();
        }

        return datatables($appointments)
            ->addColumn('#', function () {
                static $i = 1;
                return $i++;
            })
            ->addColumn('appointment', function ($appointments) {
                return view('operations.appointment.datatables.appointment-details', [
                    'appointment' => $appointments
                ]);
            })
            ->addColumn('patient', function ($appointments) {
                return view('operations.appointment.datatables.patient', ['appointment' => $appointments]);
            })
            ->addColumn('doctor', function ($appointments) {
                return view('operations.appointment.datatables.doctor', ['appointment' => $appointments]);
            })
            ->addColumn('status', function ($appointments) {
                return view('operations.appointment.datatables.status', ['appointment' => $appointments]);
            })
            ->addColumn('actions', function ($appointments) {
                return view('operations.appointment.datatables.action', ['appointment' => $appointments]);
            })
            ->rawColumns(['appointment', 'patient', 'doctor', 'status', 'actions'])
            ->make(true);

    }

    /**
     * Show the form for creating a new appointment.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $patient_id = $request->query('patient');

        return view('operations.appointment.create', [
            'doctors' => Doctor::all()
        ]);
    }

    /**
     * Store a newly created appointment.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppointmentRequest $request)
    {
        $appointment = new Appointment();
        $appointment->fill($request->all());
        if ($appointment->save()) {
            $this->updateReffrenceAppointment($request, $appointment);
            $this->savePatientToDoctorIfNew($request->doctor_id, $request->patient_id);
            if ($request->payment_amount != '') {
                $patientPayment = new PatientPayment();
                // $patientPayment->fill($request->all());
                $patientPayment->doctor_id = $appointment->doctor_id;
                $patientPayment->patient_id = $appointment->patient_id;
                $patientPayment->appointment_id = $appointment->id;
                $patientPayment->payment_info = $request->payment_info;
                $patientPayment->payment_amount = $request->payment_amount;

                $patientPayment->payment_method = $request->payment_type;
                $patientPayment->created_by = auth()->user()->id;
                $patientPayment->save();
            }
            return response()->json([__('actions.success'),
                trans_choice('actions.success_message', 1, ['attribute' => __('appointment.appointment')])], 200);
        }
    }

    private function updateReffrenceAppointment(Request $request, Appointment $_appointment)
    {
        if ($request->ref_appointment != '') {
            $appointment = Appointment::where('search_id', $request->ref_appointment)->first();
            if (is_object($appointment)) {
                $appointment->follow_up_status = 2;
                $appointment->next_appointment_id = $_appointment->id;
                $appointment->save();
            }
        }

    }

    /**
     * Save patient to doctor if not exist
     *
     * @param $doctor_id
     * @param $patient_id
     */
    private function savePatientToDoctorIfNew($doctor_id, $patient_id): void
    {
        $doctorPatient = DoctorsPatients::where('doctor_id', decrypt($doctor_id))->where('patient_id', $patient_id)->first();
        if (!is_object($doctorPatient)) {
            $dP = new DoctorsPatients();
            $dP->doctor_id = decrypt($doctor_id);
            $dP->patient_id = $patient_id;
            $dP->created_by = auth()->user()->id;
            $dP->save();
        }
    }

    /**
     * Start Appointment
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function startAppointment(Request $request)
    {
        try {
            $appointment_id = decrypt($request->appointment_id);
        } catch (\Exception $ex) {
            abort(500);
        }
        $appointment = Appointment::findOrFail($appointment_id);
        if($appointment->appointment_type == 'video')
        {
            $this->createRoom($appointment);
        }
        
        $appointment->status = 4;
        if ($appointment->save()) {
            $patient = $appointment->patient;
            $doctor = $appointment->doctor;
            $message = 'Your appointment with '.$doctor->title.' '.$doctor->full_name.' has started.';
            if($patient->contact_email) {
                Mail::to($patient->contact_email)->send(new PatientAppointmentEmail($appointment,$message));
            }

            return redirect()->route('prescription.create', 'patient=' . encrypt($appointment->patient_id) . '&appointment=' . encrypt($appointment->id));
        }
    }

    /**
     * Create an appointment and redirect to prescription create page
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function quickAppointment(Request $request)
    {
        try {
            $patient_id = decrypt($request->patient_id);
        } catch (\Exception $ex) {
            abort(500);
        }
        $appointment = $this->getPendingAppointment($patient_id, auth()->user()->doctor->id);
        if (!is_object($appointment)) {
            $appointment = new Appointment();
            $appointment->doctor_id = encrypt(auth()->user()->doctor->id);
            $appointment->patient_id = $patient_id;
            $appointment->schedule_id = 0;
            $appointment->schedule_date = Carbon::today()->toDateString();
            $appointment->schedule_time = Carbon::now()->toTimeString();
            $appointment->created_by = $appointment->doctor_id;
            $appointment->status = 4;
            $appointment->save();
        }
        return redirect()->route('prescription.create', 'patient=' . encrypt($appointment->patient_id) . '&appointment=' . encrypt($appointment->id));
    }

    /**
     * Get pending appointment by patient id and doctor id
     *
     * @param $patient_id
     * @param $doctor_id
     * @return mixed
     */
    private function getPendingAppointment($patient_id, $doctor_id)
    {
        $appointment = Appointment::where('patient_id', $patient_id)->where('doctor_id', $doctor_id)->where('status', 4)->first();
        return $appointment;
    }

    /**
     * Display the appointment.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appointment = Appointment::where('id', decrypt($id))->firstOrFail(); 
        if($appointment->patient->user) {
            return view('operations.appointment.show', [
                'appointment' => $appointment
            ]);
        }
        
        abort(404);        
    }

    /**
     * Show the form for editing the appointment.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('operations.appointment.edit', [
            'appointment' => Appointment::findOrFail(decrypt($id))
        ]);
    }

    /**
     * Update appointment in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $appointment_id = decrypt($id);
        } catch (\Exception $ex) {
            abort(404);
        }
        $appointment = Appointment::findOrFail($appointment_id);
        $appointment->fill($request->all());
        $appointment->doctor_id = decrypt($request->doctor_id);
        $appointment->schedule_date = Carbon::parse($request->schedule_date)->toDateString();
        if ($appointment->save()) {
            $this->savePatientToDoctorIfNew($request->doctor_id, $request->patient_id);

            $patient = $appointment->patient;
            $doctor = $appointment->doctor;
            $message = 'Your appointment with '.$doctor->title.' '.$doctor->full_name.' has been Rescheduled.';
            if($patient->contact_email)
                Mail::to($patient->contact_email)->send(new PatientAppointmentEmail($appointment,$message));

            return response()->json([__('actions.success'),
                trans_choice('actions.success_message', 1, ['attribute' => __('appointment.appointment')])], 200);
        }
    }

    /**
     * Update appointment status as complete "2"
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function finishAppointment(Request $request)
    {
        try {
            $appointment_id = decrypt($request->appointment_id);
        } catch (\Exception $ex) {
            abort(404);
        }

        $appointment = Appointment::find($appointment_id);
        $video_call = VideoCall::where('appointment_id',$appointment_id)->where('room_id',$appointment->search_id)->first();
        
        if($video_call) {            
            $video_call->status = 0;
            $video_call->save(); 
        }
          
        $appointment->note = $request->note;
        $appointment->next_followup = Carbon::parse($request->next_followup)->toDateString();
        $appointment->status = 2;
        if ($appointment->save()) {
            return redirect()->route('appointment.index')->with('success', 'Appointment has been end successfully');
        }
    }

    /**
     * Remove appointment from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $appointment = Appointment::find(decrypt($id));
        $appointment->status = 0;
        if ($appointment->save()) {
            return redirect()->back()->with('success', 'Appointment has been canceled successfully');
        }
    }

    /**
     * Change appointment status
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus(Request $request)
    {
        try {
            $id = $request->appointment_id;
            $status = $request->status;
        } catch (\Exception $exception) {
            abort(404);
        }
        
        $appointment = Appointment::findOrFail($id);
        $appointment->status = $status;
        if ($appointment->save()) {

            if($status == 0 || $status == 3 ){
                $patient = $appointment->patient;
                $doctor = $appointment->doctor;
                $message = 'Your appointment with '.$doctor->title.' '.$doctor->full_name.' has been '.($status == 3 ? 'approved.':'cancelled.');
                if($patient->contact_email) {
                    Mail::to($patient->contact_email)->send(new PatientAppointmentEmail($appointment,$message));
                }
            }
            return redirect()->back()->with('success', 'Appointment status has been changed successfully');
        }

    }

    /**
     * Get appointment details by id
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAppointmentById($id)
    {
        $appointment = Appointment::findOrFail($id);
        return response()->json($appointment);
    }

    public function createRoom($appointment)
    {
        VideoCall::create([
            'appointment_id' => $appointment->id,
            'room_id' => $appointment->search_id,
            'patient_id'=>$appointment->patient_id,
            'doctor_id'=>$appointment->doctor_id,
            'status' => 1
        ]);

        $client = new Client($this->sid, $this->token);
        $exists = $client->video->rooms->read([ 'uniqueName' => $appointment->search_id]);

        if (empty($exists)) {
            $client->video->rooms->create([
                'uniqueName' => $appointment->search_id,
                'type' => 'peer-to-peer',
                'recordParticipantsOnConnect' => false
            ]);
            \Log::debug("created new room: ".$appointment->search_id);
        }
        return true;
    }

    public function patientRoom($roomName)
    {
        $appointment = Appointment::where('search_id', $roomName)->first();

        if (auth('extra_user')->check()){
            $videoCall = VideoCall::where('room_id',$roomName)->first();
            if($videoCall->status == 0){
                abort(404);
            }
        }

        $user = Auth::guard('extra_user')->user();
        
        $identity = $user->name;

        \Log::debug("joined with identity: $identity");
        $token = new AccessToken($this->sid, $this->key, $this->secret, 3600, $identity);
        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($roomName);
        $token->addGrant($videoGrant);
        return view('video.room', [ 'accessToken' => $token->toJWT(), 'roomName' => $roomName, 'appointment' => $appointment]);
    }

    
    public function doctorRoom($roomName)
    {   
        $appointment = Appointment::where('search_id', $roomName)->first();

        $user = Auth::user();
        if($user->role == 2) {
            $identity = $user->full_name;            
        } 

        \Log::debug("joined with identity: $identity");
        $token = new AccessToken($this->sid, $this->key, $this->secret, 3600, $identity);
        $videoGrant = new VideoGrant();
        $videoGrant->setRoom($roomName);
        $token->addGrant($videoGrant);
        return view('video.room', [ 'accessToken' => $token->toJWT(), 'roomName' => $roomName, 'appointment' => $appointment]);
    }

    public function destroyRoom($roomName)
    {
        $videoCall = VideoCall::where('room_id',$roomName)->first();
       
        if($videoCall) {
            $videoCall->status = 0;
            $videoCall->save();

            $appointment = Appointment::where('id', $videoCall->appointment_id)->first();
            $appointment->status = 2;
            $appointment->save();
        }

        return response()->json([
            "message" => 'Appointment completed'
        ]);
    }
}
