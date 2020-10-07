<?php

namespace App\Http\Controllers;

use App\Http\Requests\PrescriptionHelperRequest;
use App\Models\PrescriptionHelper;
use http\Env\Response;
use Illuminate\Http\Request;

class PrescriptionHelperController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $prescription_helpers = PrescriptionHelper::query();
        if (auth()->user()->role == 2) {
            $prescription_helpers->where('created_by', auth()->user()->id);
        }
        return view('operations.prescription-helper.index', [
            'prescription_helpers' => $prescription_helpers->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('operations.prescription-helper.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrescriptionHelperRequest $request)
    {
        $helper = new PrescriptionHelper();
        $helper->fill($request->all());
        if ($helper->save()) {
            return response()->json([__('actions.success'), 'Prescription Helper has been saved successfully'], 200);
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
        return view('operations.prescription-helper.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('operations.prescription-helper.edit', [
            'helper' => PrescriptionHelper::findOrfail(decrypt($id))
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(PrescriptionHelperRequest $request, $id)
    {
        $helper = PrescriptionHelper::findOrFail(decrypt($id));
        $helper->fill($request->all());
        if ($helper->save()) {
            return response()->json([__('actions.success'), 'Prescription Helper has been saved successfully'], 200);
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
        if (PrescriptionHelper::destroy($id)) {
            return redirect()->back()->with('success', 'Prescription helper has been deleted successfully');
        }
    }

    public function getHelpers()
    {
        $helpers = PrescriptionHelper::where('created_by', auth()->user()->id)->orWhere('public', 1)->get();
        return response()->json($helpers);
    }
}
