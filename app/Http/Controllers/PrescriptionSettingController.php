<?php

namespace App\Http\Controllers;

use App\Models\PrescriptionSetting;
use http\Env\Response;
use Illuminate\Http\Request;

class PrescriptionSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->role == 2) {
            if (auth()->user()->doctor->prescriptionSetting) {
                return view('operations.prescription-setting.edit', [
                    'prescription_setting' => auth()->user()->doctor->prescriptionSetting
                ]);
            } else {
                return view('operations.prescription-setting.create');
            }
        } else {
            $prescription_settings = PrescriptionSetting::all();
            return view('operations.prescription-setting.index', [
                'prescription_settings' => $prescription_settings
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('operations.prescription-setting.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $_doctor = decrypt($request->doctor_id);
        $prescription_setting = PrescriptionSetting::where('doctor_id', $_doctor)->first();
        if (!is_object($prescription_setting)) {
            $prescription_setting = new PrescriptionSetting();
        }
        $prescription_setting->doctor_id = decrypt($request->doctor_id);
        $prescription_setting->fill($request->all());
        if ($prescription_setting->save()) {
            if (auth()->user()->role == 2) {
                return redirect()->route('prescription-settings.index')->with('success', 'Prescription setting has been saved successfully');
            } else {
                return response()->json(['Success', 'Prescription setting has been saved successfully'], 200);
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
        return view('operations.prescription-setting.edit', [
            'prescription_setting' => PrescriptionSetting::findOrFail(decrypt($id))
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
        $prescription_setting = PrescriptionSetting::findOrFail(decrypt($id));
        $prescription_setting->doctor_id = decrypt($request->doctor_id);
        $prescription_setting->fill($request->all());
        if ($prescription_setting->save()) {
            return response()->json(['Success', 'Prescription setting has been saved successfully'], 200);
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
        //
    }
}
