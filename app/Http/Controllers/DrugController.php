<?php

namespace App\Http\Controllers;

use App\Helpers\UploadHelper;
use App\Http\Requests\DrugRequest;
use App\Models\Department;
use App\Models\Drug;
use function GuzzleHttp\Psr7\_parse_request_uri;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DrugController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('operations.drug.index', [
            'drugs' => Drug::all()
        ]);
    }

    /**
     * All drug by doctor department
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDrugByDoctor()
    {
        $durg = Drug::where('department_id', auth()->user()->doctor->department_id)->orWhere('department_id', 0)->where('status', 1)->pluck('trade_name');
        return response()->json($durg);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (auth()->user()->role == 1) {
            $departments = Department::all();
        } else {
            $departments = Department::where('id', auth()->user()->doctor->department_id)->get();
        }
        return view('operations.drug.create', [
            'departments' => $departments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(DrugRequest $request)
    {
        $this->validate($request, [
            'trade_name' => Rule::unique('drugs')->ignore(null, 'deleted_at')
        ]);
        $drug = new Drug();
        $drug->image = save_image($request->image, '/uploads/drugs/', '');
        $drug->fill($request->all());
        if ($drug->save()) {
            return response()->json([__('drug.success'), __('drug.save_message')], 200);
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
        return view('operations.drug.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (auth()->user()->role == 1) {
            $departments = Department::all();
        } else {
            $departments = Department::where('id', auth()->user()->doctor->department_id)->get();
        }
        return view('operations.drug.edit', [
            'drug' => Drug::findOrFail(decrypt($id)),
            'departments' => $departments
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(DrugRequest $request, $id)
    {
        $this->validate($request, [
            'trade_name' => Rule::unique('drugs')->ignore(decrypt($id), 'id')
        ]);
        $drug = Drug::findOrFail(decrypt($id));
        $drug->fill($request->all());
        $drug->status = $request->status == 'on' ? 1 : 0;
        if ($drug->save()) {
            return response()->json([__('drug.success'), __('drug.update_message')], 200);
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
        if (Drug::destroy($id)) {
            return redirect()->back()->with('success', __('drug.delete_drug'));
        }
    }
}
