<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileSettingController extends Controller
{

    /**
     * Change password
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changePassword()
    {
        return view('operations.profile-setting.change-password');
    }

    /**
     * Update password of auth user
     *
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(ChangePasswordRequest $request)
    {
        if ($this->isCurrentPasswordMatched($request->current_password)) {
            $user = User::find(auth()->user()->id);
            $user->password = Hash::make($request->password);
            if ($user->save()) {

                if ($request->query('red')) {
                    return redirect()->back()->with('update_password', 'Password has been updated successfully');
                }

                return response()->json(['Success', 'Password has been updated successfully'], 200);
            }
        } else {
            return response()->json(['Error', 'Current Password Does not matched'], 421);
        }
    }

    /**
     * Change Profile info
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function changeProfile()
    {
        return view('operations.profile-setting.change-profile');
    }

    /**
     * Update email of auth user
     *
     * @param ChangeEmailRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEmail(ChangeEmailRequest $request)
    {
        $this->validate($request, [
            'email' => "unique:users,email," . auth()->user()->id,
        ]);

        if ($this->isCurrentPasswordMatched($request->current_password)) {
            $user = User::find(auth()->user()->id);
            $user->email = $request->email;
            if ($user->save()) {

                if ($request->query('red')) {
                    return redirect()->back()->with('update_email', 'Email has been updated successfully');
                }

                return response()->json(['Success', 'Email has been updated successfully'], 200);
            }
        } else {
            return response()->json(['Error', 'Current Password Does not matched'], 421);
        }
    }

    /**
     * Update user name of auth user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateUserName(Request $request)
    {
        if ($this->isCurrentPasswordMatched($request->current_password)) {
            $user = User::find(auth()->user()->id);
            $user->user_name = $request->user_name;
            if ($user->save()) {

                if ($request->query('red')) {
                    return redirect()->back()->with('update_username', 'User name has been updated successfully');
                }

                return response()->json(['Success', 'User name has been updated successfully'], 200);
            }
        } else {
            return response()->json(['Error', 'Current Password Does not matched'], 421);
        }
    }

    /**
     * Authenticate user profile
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile()
    {
        if (auth()->user()->role == 1) {
            return view('operations.profile-setting.profile.admin');
        }

        if (auth()->user()->role == 2) {
            return view('operations.profile-setting.profile.doctor');
        }

        if (auth('extra_user')->check()) {
            return view('operations.profile-setting.profile.patient');
        }

        if (auth()->user()->role == 4) {
            return view('operations.profile-setting.profile.assestant');
        }
    }

    /**
     * Check if current password is matched
     *
     * @param $password
     * @return bool
     */
    private function isCurrentPasswordMatched($password)
    {
        if (Hash::check($password, auth()->user()->getAuthPassword())) {
            return true;
        } else {
            return false;
        }

    }
}
