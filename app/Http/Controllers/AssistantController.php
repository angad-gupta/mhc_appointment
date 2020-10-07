<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssistantRequest;
use App\Models\Assistant;
use App\Traits\AssistantFilter;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AssistantController extends Controller
{

    use AssistantFilter;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('operations.assistant.index', [
            'assistants' => $this->filteredAssistant($request)->paginate(12)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('operations.assistant.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AssistantRequest $request)
    {
        $this->validate($request, [
            'user_name' => 'nullable|unique:users',
            'email' => 'unique:users',
            'password' => 'required',
            'password_confirmation' => 'required'
        ]);


        $user = new User();
        $user->role = 4;
        $user->password = bcrypt($request->password);
        if ($request->hasFile('image')) {
            $user->photo = save_image($request->image, '/uploads/assistant/', 400);
        }
        $user->fill($request->all());
        if ($user->save()) {
            $assistant = new Assistant();
            $assistant->fill($request->all());
            $assistant->photo = $user->photo;
            $assistant->user_id = $user->id;
            if ($assistant->save()) {
                return response()->json([__('actions.success'), __('actions.success_message', ['attribute' => __('assistant.assistant')])], 200);
            }
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
        return view('operations.assistant.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        return view('operations.assistant.edit', [
            'assistant' => Assistant::findOrFail(decrypt($id))
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(AssistantRequest $request, $id)
    {

        $assistant = Assistant::findOrFail($id);

        $this->validate($request, [
            'email' => 'unique:users,email,' . $assistant->user_id,
            'user_name' => 'unique:users,user_name,' . $assistant->user_id,
            'password' => 'nullable|confirmed',
            'password_confirmation' => 'nullable'
        ]);


        $user = $assistant->user;
        if ($request->password != '') {
            $user->password = bcrypt($request->password);
        }
        if ($request->hasFile('image')) {
            $user->photo = save_image($request->image, '/uploads/assistant/', 400);
        }
        $user->fill($request->all());
        $user->status = $request->status == 'on' ? 1 : 0;
        if ($user->save()) {
            $assistant->fill($request->all());
            $assistant->photo = $user->photo;
            $assistant->save();
            return response()->json(['Success', 'Assistant has been modified successfully'], 200);
        }

    }

    /**
     * Delete assistant if they have do noting
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $assistant = Assistant::findOrFail(decrypt($id));
        if ($assistant->user->createdPatients->count() > 0
            || $assistant->user->createdMedicalDocuments->count() > 0
            || $assistant->user->createdPatientPayment->count() > 0
            || $assistant->user->createdPatientMedicalNote->count() > 0
            || $assistant->user->refereeDoctorPatients->count() > 0
            || $assistant->user->createdDepartments->count() > 0
            || $assistant->user->createdAssistants->count() > 0
            || $assistant->user->createdAdmins->count() > 0
            || $assistant->user->createdAppointments->count() > 0
            || $assistant->user->createdAppointmentFollowUpNotes->count() > 0
            || $assistant->user->createdDrugs->count() > 0
            || $assistant->user->createdPrescriptionHelpers->count() > 0) {

            return redirect()->back()->with('error', 'This assistant contain '
                . $assistant->user->createdPatients->count() . ' Patient(s), '
                . $assistant->user->createdMedicalDocuments->count() . ' Medical Document(s)'
                . $assistant->user->createdPatientMedicalNote->count() . ' Medical Note(s)'
                . $assistant->user->createdAppointments->count() . ' Appointment(s)'
                . $assistant->user->createdAppointmentFollowUpNotes->count() . ' Followup note(s)'
                . $assistant->user->createdPatientPayment->count() . ' PaymentTrait(s)');
        } else {
            User::destroy($assistant->user_id);
            $assistant->delete();
            return redirect()->back()->with('success', 'Assistant has been deleted successfully');
        }
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'full_name' => 'required|max:150',
            'phone' => 'required|max:150'
        ]);

        $user = User::find(auth()->user()->id);
        if ($request->hasFile('image')) {
            $user->photo = save_image($request->image, '/uploads/assistant/', 400);
        }

        if ($user->save()) {
            $assistant = Assistant::where('user_id', $user->id)->first();
            $assistant->fill($request->all());
            $assistant->photo = $user->photo;
            $assistant->save();
            return response()->json(['Success', 'Assistant has been modified successfully'], 200);
        }
    }
}
