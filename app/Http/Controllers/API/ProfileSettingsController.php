<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangeEmailRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\User;
use Illuminate\Support\Facades\Hash;

class ProfileSettingsController extends Controller
{
    public function updatePassword(ChangePasswordRequest $request)
    {
        if ($this->isCurrentPasswordMatched($request)) {
            $user = User::find($request->user()->id);
            $user->password = Hash::make($request->password);
            if ($user->save()) {
                return response()->json(['status' => 'success','message' =>'Password has been updated successfully'], 200);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Current Password Does not match'], 421);
        }
    }

    public function updateEmail(ChangeEmailRequest $request)
    {
        $this->validate($request, [
            'email' => "unique:users,email," . $request->user()->id,
        ]);

        if ($this->isCurrentPasswordMatched($request)) {
            $user = User::find(auth()->user()->id);
            $user->email = $request->email;
            if ($user->save()) {
                return response()->json(['status' => 'success','message' =>'Email has been updated successfully'], 200);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Current Password Does not match'], 421);
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
        if ($this->isCurrentPasswordMatched($request)) {
            $user = User::find($request->user()->id);
            $user->user_name = $request->user_name;
            if ($user->save()) {
                return response()->json(['status' => 'success','message' =>'Username has been updated successfully'], 200);
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Current Password Does not match'], 421);
        }
    }

    /**
     * Authenticate user profile
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    /**
     * Check if current password is matched
     *
     * @param $password
     * @return bool
     */
    private function isCurrentPasswordMatched(Request $request)
    {
        if (Hash::check($request->current_password, $request->user()->getAuthPassword())) {
            return true;
        } else {
            return false;
        }

    }
}
