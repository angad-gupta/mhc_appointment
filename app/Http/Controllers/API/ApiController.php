<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\WebAppointmentRequest;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\DoctorsCollection;
use App\Http\Resources\SpecialitiesCollection;
use App\Http\Resources\SpecialityResource;
use App\Models\Appointment;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\PatientPayment;
use App\Models\Schedule;
use App\Models\VideoCall;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use stdClass;
use Illuminate\Support\Str;
use PhpParser\Comment\Doc;

class ApiController extends Controller
{
    public function index()
    {
        $data = [];
        $doctors =  Doctor::where('featured', 1)->get();
        $specialities = Department::all();
        $data['doctors'] = DoctorResource::collection($doctors);
        $data['department'] = SpecialitiesCollection::collection($specialities);
        return response()->json($data,200); 
    }

    public function Specialities()
    {
        $data = [];
        $specialities = Department::all();
        $data['department'] = SpecialitiesCollection::collection($specialities);
        return response()->json($data,200); 
    }

    public function DoctorsInDepartment($slug)
    {
        $data = [];
        $department= Department::where('slug',$slug)->first();
        $doctors = Doctor::leftjoin('users','users.id','doctors.user_id')->where('department_id', $department->id)->where('doctors.doctor_status','approved')->where('users.status',1)->select('doctors.*')->paginate(10);
        return [
            'doctors' => DoctorResource::collection($doctors)->response()->getData(true),
            'department' => SpecialityResource::make($department),
        ];
    }

    public function Doctor($slug)
    {
        try {
            $day = Carbon::today()->format('l');
            } catch (\Exception $ex) {
        }   
            $doctor = Doctor::where('slug', $slug)->first();
            $date = Carbon::today();
            $schedule = Schedule::where('day', $day)->where('doctor_id', $doctor->id)->with('scheduleDetails')->first();
            $morning = [];
            $evening = [];
            $noon = [];
            $appointment = Appointment::where('schedule_date',$date)->where('status',3)->get();            
            $booked_time = [];
            foreach($appointment as $ap)
            {
                array_push($booked_time,$ap->schedule_time);
            }
            if($schedule){
            foreach($schedule->scheduleDetails as $sd)
            {
                if(!in_array($sd->start_time. ' To ' .$sd->end_time, $booked_time)){
                $time = Carbon::parse($sd->start_time);
                $hour = $time->format('H');
                if ($hour < 12) {
                    
                        $timing = new stdClass;                
                        $timing->start_time = $sd->start_time;
                        $timing->end_time = $sd->end_time;
                        $timing->schedule_id = $sd->schedule_id;
                        $timing->schedule_url = route('api.booking',['start_time' => $sd->start_time,'end_time' => $sd->end_time,'date' => date_format($date, "M d, Y"),'schedule_id' => $sd->schedule_id]);
                        array_push($morning,$timing);                             
                }
                elseif($hour < 17) {
                    $timing = new stdClass;
                    $timing->start_time = $sd->start_time;
                    $timing->end_time = $sd->end_time;
                    $timing->schedule_id = $sd->schedule_id;
                    $timing->schedule_url = route('api.booking',['start_time' => $sd->start_time,'end_time' => $sd->end_time,'date' => date_format($date, "M d, Y"),'schedule_id' => $sd->schedule_id]);
                    array_push($noon,$timing);
                }
                else{
                    $timing = new stdClass;
                    $timing->start_time = $sd->start_time;
                    $timing->end_time = $sd->end_time;
                    $timing->schedule_id = $sd->schedule_id;
                    $timing->schedule_url = route('api.booking',['start_time' => $sd->start_time,'end_time' => $sd->end_time,'date' => date_format($date, "M d, Y"),'schedule_id' => $sd->schedule_id]);
                    array_push($evening,$timing);
                }
            }
        }
        }
        else{
            $morning = null;
            $evening = null;
            $noon = null;
        }
        $appointment = [];
        $appointment['morning'] = $morning;
        $appointment['evening'] = $evening;
        $appointment['noon'] = $noon;
        $data['doctor'] = DoctorResource::make($doctor);
        $data['appointments'] = $appointment;
        return response()->json($data,200); 
    }

    public function DoctorSchedule(Request $request)
    {
        $this->validate($request, [
            'doctor_id' => 'required',
            'date' => 'required',
        ]);
        try {
            $day = Carbon::parse($request->get('date'))->format('l');
            } catch (\Exception $ex) {
        }
        $date = Carbon::parse($request->get('date'));
        $today = Carbon::today();
        if($date < $today)
        {
            $appointment_date = date_format($date, "M d, Y");
            $schedule = null;
            $morning = [];
            $evening = [];
            $noon = [];
        }
        elseif($date == $today)
        {
            $appointment_date = date_format($date, "M d, Y");
            $schedule = Schedule::where('day', $day)->where('doctor_id', $request->get('doctor_id'))->with('scheduleDetails')->first();
            $morning = [];
            $evening = [];
            $noon = [];
            $appointment = Appointment::where('schedule_date',$date)->where('status',3)->get();            
            $booked_time = [];
            foreach($appointment as $ap)
            {
                array_push($booked_time,$ap->schedule_time);
            }
            if($schedule){
                foreach($schedule->scheduleDetails as $sd)
                {
                    $now = Carbon::now()->format('H');
                    if(!in_array($sd->start_time. ' To ' .$sd->end_time, $booked_time)){
                    $time = Carbon::parse($sd->start_time);
                    $hour = $time->format('H');
                    if($hour >= $now){
                        if ($hour < 12) {
                                $timing = new stdClass;                
                                $timing->start_time = $sd->start_time;
                                $timing->end_time = $sd->end_time;
                                $timing->schedule_id = $sd->schedule_id;
                                $timing->schedule_url = route('api.booking',['start_time' => $sd->start_time,'end_time' => $sd->end_time,'date' => $appointment_date,'schedule_id' => $sd->schedule_id]);
                                array_push($morning,$timing);                             
                        }
                        elseif($hour < 17) {
                            $timing = new stdClass;
                            $timing->start_time = $sd->start_time;
                            $timing->end_time = $sd->end_time;
                            $timing->schedule_id = $sd->schedule_id;
                            $timing->schedule_url = route('api.booking',['start_time' => $sd->start_time,'end_time' => $sd->end_time,'date' => $appointment_date,'schedule_id' => $sd->schedule_id]);
                            array_push($noon,$timing);
                        }
                        else{
                            $timing = new stdClass;
                            $timing->start_time = $sd->start_time;
                            $timing->end_time = $sd->end_time;
                            $timing->schedule_id = $sd->schedule_id;
                            $timing->schedule_url = route('api.booking',['start_time' => $sd->start_time,'end_time' => $sd->end_time,'date' => $appointment_date,'schedule_id' => $sd->schedule_id]);
                            array_push($evening,$timing);
                            }
                        }
                    }
        
                }
            }
        }
        else{
            $appointment_date = date_format($date, "M d, Y");
            $schedule = Schedule::where('day', $day)->where('doctor_id', $request->get('doctor_id'))->with('scheduleDetails')->first();
            $morning = [];
            $evening = [];
            $noon = [];
            $appointment = Appointment::where('schedule_date',$date)->where('status',3)->get();            
            $booked_time = [];
            foreach($appointment as $ap)
            {
                array_push($booked_time,$ap->schedule_time);
            }
            if($schedule){
                foreach($schedule->scheduleDetails as $sd)
                {
                    if(!in_array($sd->start_time. ' To ' .$sd->end_time, $booked_time)){
                    $time = Carbon::parse($sd->start_time);
                    $hour = $time->format('H');
                    if ($hour < 12) {
                            $timing = new stdClass;                
                            $timing->start_time = $sd->start_time;
                            $timing->end_time = $sd->end_time;
                            $timing->schedule_id = $sd->schedule_id;
                            $timing->schedule_url = route('api.booking',['start_time' => $sd->start_time,'end_time' => $sd->end_time,'date' => $appointment_date,'schedule_id' => $sd->schedule_id]);
                            array_push($morning,$timing);                             
                    }
                    elseif($hour < 17) {
                        $timing = new stdClass;
                        $timing->start_time = $sd->start_time;
                        $timing->end_time = $sd->end_time;
                        $timing->schedule_id = $sd->schedule_id;
                        $timing->schedule_url = route('api.booking',['start_time' => $sd->start_time,'end_time' => $sd->end_time,'date' => $appointment_date,'schedule_id' => $sd->schedule_id]);
                        array_push($noon,$timing);
                    }
                    else{
                        $timing = new stdClass;
                        $timing->start_time = $sd->start_time;
                        $timing->end_time = $sd->end_time;
                        $timing->schedule_id = $sd->schedule_id;
                        $timing->schedule_url = route('api.booking',['start_time' => $sd->start_time,'end_time' => $sd->end_time,'date' => $appointment_date,'schedule_id' => $sd->schedule_id]);
                        array_push($evening,$timing);
                        }
                    }
                }
            }
        }

        $data['appointment_date'] = $appointment_date;
        $data['schedule']['morning'] = $morning;
        $data['schedule']['evening'] = $morning;
        $data['schedule']['noon'] = $morning;
        return response()->json($data,200); 
    }

    public function Booking(Request $request)
    {
        $date = $request->get('date');
        $date = Carbon::parse($request->get('date'));
        $today = Carbon::today();
        if($this->CheckIfAppointmentExists($date,$request->get('start_time'),$request->get('end_time'))){
            return response()->json("The scheduled date and appointment time is already taken. Please select new appointment timing",422);
        }
        if($date < $today)
        {
            return response()->json("Previous dates is not acceptable",422);
        }
        else
        {
            $data=[];
            $data['start_time'] = $request->get('start_time');
            $data['end_time'] = $request->get('end_time');
            $data['schedule_id'] = $request->get('schedule_id');
            $data['schedule'] = Schedule::where('id',$data['schedule_id'])->first();
            $data['doctor'] = DoctorResource::make(Doctor::where('id',$data['schedule']->doctor_id)->first()); 
            $data['date'] = date_format($date,"M d, Y");
            return response()->json($data,200);
        } 
    }

    public function CheckIfAppointmentExists($date,$start_time,$end_time)
    {
        $time = $start_time. ' To ' .$end_time;
        $appointment = Appointment::where('status',3)->where('schedule_date',$date)->where('schedule_time',$time)->first();
        if($appointment)
        {
            return true;
        }
        else{
            return false;
        }
    }

    public function PayNow(WebAppointmentRequest $request)
    {
        $appointment = null;
        $appointment_check = Appointment::where('status',3)->where('schedule_date',$request->get('date'))->where('schedule_time',$request->get('schedule_time'))->first();
        if($appointment_check)
        {
            return response()->json(['status' => 'error','message' =>'The scheduled date and appointment time is already taken. Please select new appointment timing'],433);
        }

        $appointment = $this->createAppointment($request, $request->user()->patient);
        $payment = $appointment->doctor->video_consultation_fee ? $appointment->doctor->video_consultation_fee : 300;
        $url = $request->url();
        $date = $request->get('date');
        $schedule_date = $request->get('schedule_date');
        $schedule_time = $request->get('schedule_time');
        return response()->json(['status' => 'success','message' => 'Appointment created proceed with the payment to verify']);
    }


    public function Search(Request $request)
    {
        
        $doctors = Doctor::query(); 
       
        if($request->query('doctor') != ''){
            $doctors->leftjoin('users','users.id','doctors.user_id')->where('doctors.full_name', 'LIKE', "%{$request->get('doctor')}%")->where('doctors.doctor_status','approved')->where('users.status',1)->select('doctors.*');
        }

        if ($request->query('department') != '') {
            $department = Department::where('slug',$request->query('department'))->first();
            if($department)
            {
                $doctors->where('department_id', $department->id);
            }
            else{
                $data['success'] = false;
                $data['message'] = 'Department Not found';
                return response()->json($data,422);
            }
            

        }
        return response()->json($doctors->paginate(12));
    }


    public function createAppointment(Request $request, Patient $patient)
    {
        $appointment = new Appointment();
        $appointment->patient_id = $patient->id;
        $appointment->appointment_type = "video";        
        $appointment->fill($request->all());
        $appointment->status = 1;
    
        if ($appointment->save()) {
            return $appointment;
        }
    }

    public function khaltiVerification(Request $request)
    {        
        $appointment = Appointment::where('search_id',$request->order_number)->first();
        if(!$appointment)
        {
            $data['success'] = false;
            $data['message'] = 'Payment Not Found';
            return response()->json($data,500);
        }
           if($appointment->status == 3)
           {
            $data['success'] = false;
            $data['message'] = 'Payment is already completed';
            return response()->json($data,422);
           }
        $amount = $appointment->doctor->video_consultation_fee ? $appointment->doctor->video_consultation_fee * 100 : 300 * 100;
        if((int)$amount != $request->amount)
        {
            $data['success'] = false;
            $data['message'] = 'Order Amount is incorrect';
            return response()->json($data,422);
        }
        $args = http_build_query(array(
            'token' => $request->token,
            'amount'  => $request->amount
        ));
        
        $url = "https://khalti.com/api/v2/payment/verify/";
        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $khalti = config('khalti');
        $headers = ['Authorization: Key test_secret_key_6ba54dd7636b4d958490f4a0c288c5c9'];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        // Response
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $token = json_decode($response, TRUE);
        if (isset($token['idx']) && $status_code == 200)
        {
            $payment = new PatientPayment();
            $payment->doctor_id = $appointment->doctor->id;
            $payment->patient_id = $appointment->patient->id;
            $payment->appointment_id = $appointment->id;
            $payment->payment_amount = $appointment->doctor->video_consultation_fee ? $appointment->doctor->video_consultation_fee : 300;
            $payment->created_by = $request->user()->id;
            $payment->payment_method = "khalti";
            $payment->save();
            $appointment->status = 3;
            $appointment->save();
            //Need to send email to user and doctor here
            return response()->json(['status' => 'success','data' => $response]);
        }
    
    }

    public function CheckIfVideoActive(Request $request)
    {
            if ($request->user()->role == 3) {
                $videoCall = VideoCall::where('patient_id',$request->user()->patient->id)->where('status',1)->first();
                if($videoCall)
                {
                    return response()->json(['room_id' => $videoCall->room_id,'call_exists' => true],200);
                }
                else{
                    return response()->json(['room_id' => null,'call_exists' => false,'message' => 'No Active Call found'],200);
                }
            }
    }



}
