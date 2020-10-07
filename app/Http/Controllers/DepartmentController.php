<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('operations.department.index', [
            'departments' => Department::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('operations.department.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|unique:departments'
        ]);
        $department = new Department();
        $department->fill($request->all());
        if ($request->hasFile('photo')) {
            $department->photo = save_image($request->photo, '/uploads/departments/', 400);
        }
        if ($department->save()) {
            return response()->json([__('actions.success'), __('department.success_message')], 200);
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
        return view('operations.department.show', [
            'department' => Department::findOrFail($id)
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
        return view('operations.department.edit', [
            'department' => Department::findOrFail(decrypt($id))
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|unique:departments,title,' . $id
        ]);
        $department = Department::findOrFail($id);
        $department->status = $request->status == 'on' ? 1 : 0;
        if ($request->hasFile('photo')) $department->photo = save_image($request->photo, '/uploads/departments', 400);
        $department->fill($request->all());
        if ($department->save()) {
            return response()->json([__('actions.success'), __('department.update_message')], 200);
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
        $department = Department::findOrFail(decrypt($id));
        if ($department->doctors->count() > 0) {
            return redirect()->back()->with('error', 'This department ' . $department->title . ' Contain ' . $department->doctors->count() . ' Doctor(s). We are unable to delete this department');
        } else {
            Department::destroy($id);
            return redirect()->back()->with('success', __('department.delete_message', ['attribute' => __('department.department')]));
        }
    }
}
