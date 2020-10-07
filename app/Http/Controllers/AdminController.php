<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminRequest;
use App\Models\Admin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('operations.admin.index', [
            'admins' => User::where('role', 1)->paginate(12)
        ]);
    }

    /**
     * Show the form for creating a new admin.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('operations.admin.create');
    }

    /**
     * Store a newly created admin in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        $this->validate($request, [
            'email' => 'unique:users', 'user_name' => 'nullable|unique:users', 'password' => 'required'
        ]);
        $user = new User();
        $user->password = bcrypt($request->password);
        $user->role = 1;
        $user->fill($request->all());
        if ($request->hasFile('image')) {
            $user->photo = save_image($request->image, '/uploads/admin/', 400);
        }
        if ($user->save()) {
            $this->saveAdmin($request, $user);
            return response()->json([__('actions.success'), trans_choice('actions.success_message', 1, ['attribute' => __('admin.admin')])], 200);
        }
    }

    /**
     * Display the specified admin.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('operations.admin.show', [
            'user' => User::where('role', 1)->where('id', decrypt($id))->firstOrFail()
        ]);
    }

    /**
     * Show the form for editing the specified admin.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('operations.admin.edit', [
            'admin' => User::where('role', 1)->where('id', decrypt($id))->firstOrFail()
        ]);
    }

    /**
     * Update the specified admin in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'email' => 'unique:users,email,' . decrypt($id),
            'user_name' => 'unique:users,user_name,' . decrypt($id)
        ]);

        $user = User::findOrFail(decrypt($id));
        if ($request->has('status'))
            $user->status = $request->status == 'on' ? 1 : 0;
        $user->fill($request->all());
        if ($request->hasFile('image')) {
            $user->photo = save_image($request->image, '/uploads/admin/', 400);
        }
        if ($request->password != '') $user->password = bcrypt($request->password);
        if ($user->save()) {
            $this->saveAdmin($request, $user);
            return response()->json([__('actions.success'), trans_choice('actions.update_message', 1, ['attribute' => __('admin.admin')])], 200);
        }
    }

    /**
     * Store data into admin
     *
     * @param Request $request
     * @param User $user
     */
    private function saveAdmin(Request $request, User $user)
    {
        $admin = null;
        if (is_object($user->admin)) {
            $admin = Admin::findOrFail($user->admin->id);
        }

        if (!is_object($admin)) {
            $admin = new Admin();
        }
        $admin->photo = $user->photo;
        $admin->user_id = $user->id;
        $admin->fill($request->all());
        $admin->save();
    }

    /**
     * Remove the specified admin from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::where('id', decrypt($id))->first();
        $user->status = !$user->status;
        if ($user->save()) {
            return redirect()->back()->with('success', 'Admin account status change successfully');
        }
    }
}
