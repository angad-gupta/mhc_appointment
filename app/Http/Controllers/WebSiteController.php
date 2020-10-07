<?php

namespace App\Http\Controllers;

use DB;
use Mail;
use Session;
use App\User;
use stdClass;
use Carbon\Carbon;
use App\Models\About;
use App\Models\Doctor;
use http\Env\Response;
use App\Models\Contact;
use App\Models\Patient;
use App\Models\Schedule;
use App\Models\Department;
use App\Mail\PaymentRecipt;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\PatientPayment;
use App\Models\ScheduleDetails;
use App\Mail\NewAppointmentMail;
use App\Http\Requests\AboutRequest;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\WebAppointmentRequest;

class WebSiteController extends Controller
{
    public function index()
    {
        return view('front.index', [
            'doctors' => Doctor::where('featured', 1)->get(),
            'about' => About::first(),
            'contact' => Contact::first(),
            'specialities' => Department::all()->take(6),
        ]);
    }

    public function changeLang($lang)
    {
        App::setLocale($lang);
        session()->put('locale', $lang);
        return redirect()->back();
    }

    /**
     * Show contact page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function contact()
    {
        return view('website.contact', [
            'about' => About::first(),
            'contact' => Contact::first()
        ]);
    }

    /**
     * Show appointment page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function appointment()
    {
        return view('front.search', [
            'about' => About::first(),
            'contact' => Contact::first(),
            'departments' => Department::all(),
        ]);
    }

    /**
     *
     * Show doctors page
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function Search(Request $request)
    {
        $doctors = Doctor::query(); 
       
        if($request->query('doctor') != ''){
            $doctors->leftjoin('users','users.id','doctors.user_id')->where('doctors.full_name', 'LIKE', "%{$request->get('doctor')}%")->where('doctors.doctor_status','approved')->where('users.status',1)->select('doctors.*');
        }

        if ($request->query('department') != '') {
            $department = Department::where('slug',$request->query('department'))->first();
            $doctors->where('department_id', $department->id);

        }
        
        if ($request->query('gender') != '') {
            
            $this->validate($request, [
                'gender' => 'in:Any,Female,Male,Others',
            ]);
            
            if($request->query('gender') == "Any"){
                $doctors->whereIn('sex', ['Male', 'Female', 'Other']);
            } else {
                $doctors->where('sex', $request->query('gender'));
            }
        }
        if ($request->query('consultation_fee') != '') {
            
            $this->validate($request, [
                'consultation_fee' => 'in:free,300,500,1000,1000+,Any',
            ]);
            if($request->query('consultation_fee') == 'free')
            {
                $doctors->where('video_consultation_fee', '<=' ,0);
            }
            elseif($request->query('consultation_fee') == '300')
            {
                $doctors->where('video_consultation_fee', '<=' ,300);
            }
            elseif($request->query('consultation_fee') == '500')
            {
                $doctors->where('video_consultation_fee', '<=' ,500);
            }
            elseif($request->query('consultation_fee') == '1000'){
                $doctors->where('video_consultation_fee', '<=' ,1000);
            }
            elseif($request->query('consultation_fee') == 'Any'){
                $doctors->where('video_consultation_fee', '<=', 1000)
                        ->orWhere('video_consultation_fee', '>', 1000);
            }
            else{
                $doctors->where('video_consultation_fee', '>' ,1000);
            }
        }

        $doctors->where('doctor_status', 'approved');

        return view('front.appointment', [
            'doctors' => $doctors->orderBy('full_name', 'asc')->with('appointmentSchedules')->paginate(8),
            'departments' => Department::all(),
            'about' => About::first(),
            'contact' => Contact::first()
        ]);
    }

    public function DepartmentDoctors($slug)
    {
            $department= Department::where('slug',$slug)->first();
            $doctors = Doctor::query();
            $doctors->leftjoin('users','users.id','doctors.user_id')->where('department_id', $department->id)->where('doctors.doctor_status','approved')->where('users.status',1)->select('doctors.*');
            return view('front.appointment', [
            'doctors' => $doctors->orderBy('full_name', 'asc')->with('appointmentSchedules')->paginate(8),
            'departments' => Department::all(),
            'about' => About::first(),
            'contact' => Contact::first(),
            'department_slug' => $slug,
        ]);
    }


    public function GetDoctor(Request $request)
    {
        $this->validate($request, [
            'doctor_id' => 'required',
        ]);

        $video = false;
        if($request->has('video_consultation'))
        {
           if($request->get('video_consultation') == 'true')
           {
               $video = true;
           }
        }
    
        $doctor = Doctor::where('id',$request->get('doctor_id'))->first();
        
        $scheduleDetails = ScheduleDetails::where('created_by', $doctor->user_id)->get();

        $scheduleDays = [];

        foreach ($scheduleDetails as $detail) {
            $schedule = Schedule::where('id', $detail->schedule_id)->first();
            $dayIndex = $schedule->day_index;

            if(!in_array($dayIndex, $scheduleDays)){
                $scheduleDays [] = (int)$dayIndex;
            }
        }

        $returnHTML = view('front.ajax.appointment_date_picker', compact('doctor','video'))->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML, 'scheduleDays' => $scheduleDays));

    }

    public function GetSchedules(Request $request)
    {
        $this->validate($request, [
            'doctor_id' => 'required',
            'date' => 'required',
        ]);
        
        try {
            $day = Carbon::parse($request->get('date'))->format('l');
        } catch (\Exception $ex) {
        }

        $video = false;
        if($request->has('video'))
        {
           if($request->get('video') == 'true')
           {
               $video = true;
           }
        }

        $date = Carbon::parse($request->get('date'));
        $today = Carbon::today();

        $current_time = Carbon::now()->format('H:i:s');

        if($date < $today)
        {
            $appointment_date = date_format($date, "M d, Y");
            $schedule = null;
            $morning = [];
            $evening = [];
            $noon = [];
            $schedule_count = 0;
        }
        else{
            $appointment_date = date_format($date, "M d, Y");
            $schedule = Schedule::where('day', $day)->where('doctor_id', $request->get('doctor_id'))->with('scheduleDetails')->first();
            $morning = [];
            $evening = [];
            $noon = [];
            if($schedule)
            {
                $schedule_count = count($schedule->scheduleDetails);
            }            
            else{
                $schedule_count = 0;
            }
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
                    if ($hour < 12 && (($current_time < $sd->start_time) || ($today->format('Y-m-d') != $date->format('Y-m-d')))) {
                        $timing = new stdClass;                
                        $timing->start_time = $sd->start_time;
                        $timing->end_time = $sd->end_time;
                        $timing->schedule_id = $sd->schedule_id;
                        array_push($morning,$timing);                             
                    }
                    elseif($hour < 17 && (($current_time < $sd->start_time) || ($today->format('Y-m-d') != $date->format('Y-m-d')))) {
                        $timing = new stdClass;
                        $timing->start_time = $sd->start_time;
                        $timing->end_time = $sd->end_time;
                        $timing->schedule_id = $sd->schedule_id;
                        array_push($noon,$timing);
                    }
                    else{
                        if(($current_time < $sd->start_time) || ($today->format('Y-m-d') != $date->format('Y-m-d'))) {                            
                            $timing = new stdClass;
                            $timing->start_time = $sd->start_time;
                            $timing->end_time = $sd->end_time;
                            $timing->schedule_id = $sd->schedule_id;
                            array_push($evening,$timing);
                        }
                    }
                }
        
                }
            }
           
            if(count($morning)== 0 && count($evening)== 0 && count($noon)== 0)
            {
                $schedule_count = 0;
            }
        }
       
        $doctor_id = $request->get('doctor_id');
        $returnHTML = view('front.ajax.schedule', compact('morning','noon','evening','schedule_count','appointment_date','doctor_id','video', 'current_time'))->render();
        return response()->json(array('success' => true, 'html'=>$returnHTML));
    }

    public function Booking(Request $request)
    {
        $this->validate($request, [
            'video' => 'required|in:0,1',
        ]);
        // $video = $request->get('video') == 1 ? true : false;
        
        
        $video= true;
        $date = $request->get('date');
        $date = Carbon::parse($request->get('date'));
        $today = Carbon::today();
        if($this->CheckIfAppointmentExists($date,$request->get('start_time'),$request->get('end_time'))){
            Session::flash('failed','The scheduled date and appointment time is already taken. Please select new appointment timing');
            return redirect()->route('home');
        }
        if($date < $today)
        {
            abort(403);
        }
        else
        {
            $start_time = $request->get('start_time');
            $end_time = $request->get('end_time');
            $schedule_id = $request->get('schedule_id');
            $schedule = Schedule::where('id',$schedule_id)->first();
            $doctor = Doctor::where('id',$schedule->doctor_id)->first();
            $date = date_format($date,"M d, Y");
            return view('front.booking',compact('date','doctor','schedule','start_time','end_time','video'));
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
        //Need Validation
        // try{
        //     DB::beginTransaction();
            $appointment = null;
            $appointment_check = Appointment::where('status',3)->where('schedule_date',$request->get('date'))->where('schedule_time',$request->get('schedule_time'))->first();
            if($appointment_check)
            {
                return response()->json('The scheduled date and appointment time is already taken. Please select new appointment timing', 433);
            }
           
        // if patient is authenticated
        if (auth('extra_user')->check()) {
            // create appointment
            $appointment = $this->createAppointment($request, auth('extra_user')->user()->patient);
        } else {
            if ($request->get('new_user') == 'on') {
                // create patient
                $user = $this->createPatient($request);            
                $appointment = $this->createAppointment($request, $user->patient);            
            } else {
                // get patient by matching email and password
                $user = User::where('email', $request->email)->where('role', 3)->first();
                if (!Hash::check($request->password, $user->password)) {
                    return response()->json($request->all())->withErrors(['email' => 'Credentials does not match'], 200);
                } else {
                    $appointment = $this->createAppointment($request, $user->patient);
                }
            }
        }
        $payment = $appointment->doctor->video_consultation_fee ? $appointment->doctor->video_consultation_fee : 300;
        $url = $request->url();
        $date = $request->get('date');
        $schedule_date = $request->get('schedule_date');
        $schedule_time = $request->get('schedule_time');
        $view = view('front.payment.pay_now',compact('appointment','payment','url','schedule_date','schedule_time'))->render();
        return response()->json($view, 200);
    }

    private function createPatient(Request $request)
    {
        $user = new User();
        $user->fill($request->all());
        $user->password = bcrypt($request->password);
        $user->role = 3;
        if ($user->save()) {
            $patient = new Patient();
            $patient->fill($request->all());
            $patient->user_id = $user->id;
            $patient->date_of_birth = Carbon::parse($request->date_of_birth);
            $patient->save();
        }
        return $user;
    }

    public function createAppointment(Request $request, Patient $patient)
    {
        $appointment = new Appointment();
        $appointment->patient_id = $patient->id;
        //Currently its all video so this would be video for now, later will be needing this condition
        //$appointment->appointment_type = $request->video == 1 ? "video":"clinic";
        $appointment->appointment_type = "video";        
        $appointment->fill($request->all());
        $appointment->status = 1;
        if ($appointment->save()) {
            return $appointment;
        }
    }

    // Verification after trannsaction

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
        
        $url = env('KHALTI_URL');
        # Make the call using API.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $khalti = config('khalti');
        $headers = ['Authorization: Key '.env('KHALTI_SECRET_KEY')];
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
            $payment->created_by = auth('extra_user')->user()->id;
            $payment->payment_method = "khalti";
            $payment->save();
            $appointment->status = 3;
            $appointment->save();
            
            if($appointment->patient->contact_email) 
                Mail::to($appointment->patient->contact_email)->send(new PaymentRecipt($payment));
            Mail::to($appointment->doctor->user->email)->send(new NewAppointmentMail($appointment));

            return $response;
        }
        return response()->json('error', 500);
    
    }

    public function PayMentSuccessKhalti(Request $request)
    {
        $appointment_id = $request->get('appointment_id');
        if(Auth::guard('extra_user')->check())
        {
            \Session::flash('appointment_submission','Your Appointment id is <strong>'.$appointment_id.'</strong>. Please check your email for further details');
            return redirect()->route('web.patient.appointments')->with('appointment_id');        
        }
        else{
            \Session::flash('appointment_submission','Your Appointment id is <strong>'.$appointment_id.'</strong>. Please check your email for further details');
            return redirect()->route('/')->with('appointment_id');   
        } 
    }

    public function PayMentSuccess(Request $request)
    {
        $appointment_id = $request->get('appointment_id');
        $appointment = Appointment::where('search_id', $appointment_id)->firstOrFail();

        if(!$appointment)
        {
            $data['success'] = false;
            $data['message'] = 'Payment Not Found';
            return response()->json($data,500);
        }

        if($request->has('oid') && $request->has('amt') && $request->has('refId')) {

            if($appointment->status == 3)
            {
                $data['success'] = false;
                $data['message'] = 'Payment is already completed';
                return response()->json($data,422);
            }
            
            $amount = $appointment->doctor->video_consultation_fee ? $appointment->doctor->video_consultation_fee : 300;
            
            if((int)$amount != $request->amt)
            {
                $data['success'] = false;
                $data['message'] = 'Order Amount is incorrect';
                return response()->json($data,422);
            }

            $patientId = $appointment->patient_id;

            $userId = Patient::findOrFail($patientId)->user_id;
            
            $data = array('amt' => $request->amt,'rid' => $request->refId,'pid' => $request->oid,'scd' => env('ESEWA_MERCHANT_CODE'));

            //verification with esewa server
            $response = $this->esewaVerification($data);

            if($response == "Success") {
                $payment = PatientPayment::create([
                    'patient_id' => $patientId,
                    'doctor_id' => $appointment->doctor_id,
                    'appointment_id' => $appointment->id,
                    'payment_info' => 'Payment for video consultation',
                    'payment_amount' => $request->amt,
                    'payment_method' => 'Esewa',
                    'created_by' => $userId
                ]);

                $appointment->status = 3;
                $appointment->save();
                
                Mail::to($appointment->patient->user->email)->send(new PaymentRecipt($payment));
                Mail::to($appointment->doctor->user->email)->send(new NewAppointmentMail($appointment));

                if(Auth::guard('extra_user')->check())
                {
                    \Session::flash('appointment_submission','Your Appointment id is <strong>'.$appointment_id.'</strong>. Please check your email for further details');
                    return redirect()->route('web.patient.appointments')->with('appointment_id');           
                }
                else{
                    \Session::flash('appointment_submission','Your Appointment id is <strong>'.$appointment_id.'</strong>. Please check your email for further details');
                    return redirect()->route('/')->with('appointment_id');   
                }  
                
            }
           
        }
    }

    public function PayMentFailed(Request $request)
    {        
        $appointment_id = $request->get('appointment_id');
        if(Auth::guard('extra_user')->check())
        {
            \Session::flash('failed','Payment verification failed');
            return redirect()->route('web.patient.appointments')->with('appointment_id');            
        }
        else{
            \Session::flash('failed','Payment verification failed');
            return redirect()->route('/')->with('appointment_id');   
        }
        
    }

    public function esewaVerification($data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => env('ESEWA_VERIFICATION_URL'),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            "Cookie: TSc4fa6d1f029=08ea48504aab28005e64f09ce2a45fce4b7b0be4a3ed0d4fcbe5772c471d3baa345812e5642e8840589471c20f893d9d"
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);


        //convert xml into json
        $response = str_replace(array("\n", "\r", "\t"), '', $response);

        $response = trim(str_replace('"', "'", $response));

        $simpleXml = simplexml_load_string($response);

        $json = json_encode($simpleXml);


        return json_decode($json)->response_code;
    }

    public function Specialities()
    {
        $specialities = Department::all();
        return view('front.specialities',compact('specialities'));
    }

    /**
     * Show doctor page
     *
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function doctor($slug)
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
                        array_push($morning,$timing);                             
                }
                elseif($hour < 17) {
                    $timing = new stdClass;
                    $timing->start_time = $sd->start_time;
                    $timing->end_time = $sd->end_time;
                    $timing->schedule_id = $sd->schedule_id;
                    array_push($noon,$timing);
                }
                else{
                    $timing = new stdClass;
                    $timing->start_time = $sd->start_time;
                    $timing->end_time = $sd->end_time;
                    $timing->schedule_id = $sd->schedule_id;
                    array_push($evening,$timing);
                }
            }
        }

            if(count($morning)== 0 && count($evening)== 0 && count($noon)== 0)
            {
                $schedule_count = 0;
            }
            else{
                $schedule_count = count($schedule->scheduleDetails);
            }
        }
        else{
            $schedule_count = 0;
        }
        $about = About::first();
        $contact = Contact::first();
        return view('front.doctors',compact('about','contact','doctor','morning','noon','evening','schedule_count'));
    }

    /**
     * Success message page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function success()
    {
        return view('website.success', [
            'about' => About::first(),
            'contact' => Contact::first()
        ]);
    }

    /**
     * Website setup page only can access by admin
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function webSiteSetup()
    {
        return view('operations.app-setting.website-setup', [
            'about' => About::first(),
            'contact' => Contact::first()
        ]);
    }

    /**
     * Save about text for website
     *
     * @param AboutRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveAbout(AboutRequest $request)
    {
        $about = About::first();
        if (!is_object($about)) {
            $about = new About();
        }
        $about->fill($request->all());
        if ($request->hasFile('about_us_image')) {
            $about->about_us_image = save_image($request->about_us_image, '/uploads/website/', 700);
        }
        if ($about->save()) {
            return response()->json(['Success', 'About us saved successfully'], 200);
        } else {
            return response()->json(['Error', 'Something went wrong'], 400);
        }

    }

    /**
     * Save contact details of website by admin
     *
     * @param ContactRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveContact(ContactRequest $request)
    {
        $contact = Contact::first();
        if (!is_object($contact)) {
            $contact = new Contact();
        }
        $contact->fill($request->all());
        if ($contact->save()) {
            return response()->json(['Success', 'Contact us saved successfully'], 200);
        } else {
            return response()->json(['Error', 'Something went wrong'], 400);
        }
    }
}
