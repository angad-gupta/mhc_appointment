<?php

namespace App\Http\Controllers;

use App\Models\User;
use http\Env\Response;
use App\Models\Patient;
use Illuminate\Http\Request;
use App\Traits\PatientFilter;
use App\Models\DoctorsPatients;
use Illuminate\Validation\Rule;
use App\Http\Requests\PatientRequest;
use phpDocumentor\Reflection\DocBlock\Tags\Author;

class PatientController extends Controller
{

    use PatientFilter;

    /**
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        if (auth()->user()->role == 2) {
            return view('operations.doctors_operations.patient.all-patient', [
                'patients' => $this->filterPatientForDoctor($request)->paginate(12)
            ]);
        } else {
            return view('operations.patient.index', [
                'patients' => $this->filterPatient($request)->paginate(12)
            ]);
        }
    }


    /**
     * Show the form for creating a new patient.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('operations.patient.create');
    }

    /**
     * Store a newly created patient in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PatientRequest $request)
    {
        // Check validation
        $this->patientUserValidation($request);

        $user = null;
        if ($request->email != null) {
            $user = $this->saveUser($request);
        }
        $patient = new Patient();
        $patient->photo = save_image($request->image, '/uploads/patients/', 200);
        $patient->fill($request->all());
        $patient->user_id = $user != null ? $user->id : null;
        if ($patient->save()) {
            $this->saveDoctorsPatients($patient);
            return response()->json($patient, 200);
        }
    }

    /**
     * Display the specified patient.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $patient_id = decrypt($id);

            $user_id = Patient::findOrFail($patient_id)->user_id;
            if($user_id) {
                $user = User::findOrFail($user_id);
            } else {
                abort(404);
            }                        
        } catch (\Exception $e) {
            abort(404);
        }

        return view('operations.patient.show', [
            'patient' => Patient::findOrFail($patient_id),
            'user' =>  $user
        ]);
    }

    /**
     * Display patient appointment timeline by patient id
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function timeline($id)
    {
        try {
            $patient_id = decrypt($id);
        } catch (\Exception $e) {
            abort(404);
        }

        return view('operations.patient.timeline', [
            'patient' => Patient::findOrFail($patient_id)
        ]);
    }

    /**
     * Show the form for editing the specified patient.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $patient_id = decrypt($id);
        } catch (\Exception $e) {
            abort(404);
        }
        return view('operations.patient.edit', [
            'patient' => Patient::findOrFail($patient_id)
        ]);
    }

    /**
     * Update the specified patient in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PatientRequest $request, $id)
    {
        try {
            $patient_id = decrypt($id);
        } catch (\Exception $ex) {
            abort(404);
        }

        $user = null;
        $patient = Patient::findOrFail($patient_id);
        if (!is_object($patient->user)) {
            $this->patientUserValidation($request);
            $user = $this->saveUser($request);
        } else {
            $this->validate($request, [
                'email' => 'required|unique:users,email,' . $patient->user->id,
                'user_name' => 'sometimes|unique:users,user_name,' . $patient->user->id, ',id'
            ]);
            $user = $this->updateUser($request, $patient->user->id);
        }
        $patient->fill($request->all());
        if ($request->hasFile('image')) {
            $patient->photo = save_image($request->image, '/uploads/patients/', 200);
        }
        $patient->user_id = $user != null ? $user->id : null;
        if ($patient->save()) {
            return response()->json([__('actions.success'), __('patient.update_message')], 200);
        }


    }

    /**
     * User validation if request has email address
     *
     * @param Request $request
     */
    private function patientUserValidation(Request $request)
    {
        if ($request->email != '') {
            $this->validate($request, [
                'email' => 'unique:users',
                'password' => 'required',
                'password_confirmation' => 'required'
            ]);

            if ($request->user_name != '') {
                $this->validate($request, [
                    'user_name' => 'unique:users',
                ]);
            }
        }
    }


    /**
     * Remove the specified patient from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        if (auth()->user()->role == 2) {
            DoctorsPatients::where('patient_id', $patient->id)->where('doctor_id', auth()->user()->id)->delete();
            return redirect()->back()->with('success', 'Patient has been deleted successfully');
        }
        return redirect()->back()->with(__('actions.success'), __('patient.delete_message'));
    }


    /**
     * Save and return user
     *
     * @param Request $request
     * @return object
     */
    private function saveUser(Request $request): object
    {
        $user = new User();
        if ($request->email != null) {
            $user->role = 3;
            $user->password = bcrypt($request->password);
            $user->fill($request->all());
            $user->save();
        }
        return $user;
    }

    private function updateUser(Request $request, $user_id): object
    {
        $user = User::findOrFail($user_id);
        $user->fill($request->all());
        if ($request->password != null) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return $user;
    }

    /**
     * Save patient to doctor if doctor add a patients
     *
     * @param Patient $patient
     */
    private function saveDoctorsPatients(Patient $patient)
    {
        if (auth()->user()->role == 2) {
            $doctors_patients = DoctorsPatients::where('patient_id', $patient)->where('doctor_id', auth()->user()->doctor->id)->first();
            if ($doctors_patients == null) {
                $doctors_patients = new DoctorsPatients();
            }
            $doctors_patients->doctor_id = auth()->user()->doctor->id;
            $doctors_patients->patient_id = $patient->id;
            $doctors_patients->created_by = auth()->user()->id;
            $doctors_patients->save();
        }
    }

    /**
     * Get all patient by query string and user role
     *
     * @param Request $request
     * @return mixed
     */
    public function getAllPatient(Request $request)
    {
        if (auth()->user()->role == 2) {
            $doctor_patients = DoctorsPatients::where('doctor_id', auth()->user()->doctor->id)->pluck('patient_id');
            $patients = Patient::whereIn('id', $doctor_patients)
                ->where('full_name', 'like', '%' . $request->query('search') . '%')
                ->orWhere('cell_phone', 'like', '%' . $request->query('search') . '%')
                ->orderBy('id', 'desc')
                ->paginate(30);

        } else {
            $patients = Patient::where('full_name', 'like', '%' . $request->query('search') . '%')
                ->orWhere('cell_phone', 'like', '%' . $request->query('search') . '%')
                ->orderBy('id', 'desc')
                ->paginate(30);
        }

        return response()->json($patients);
    }

    /**
     * Get patient details by id
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPatientByEncId($id)
    {
        return response()->json(Patient::findOrFail(decrypt($id)));
    }


}
