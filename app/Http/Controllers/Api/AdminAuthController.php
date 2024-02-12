<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminRegisterRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function adminSignup(AdminRegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        Admin::create($data);
        return response(['success' => true, 'msg' => 'Registration Successfully']);
    }

    public function adminSignin(Request $request)
    {
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (!Auth::guard('admin')->attempt($credential)) {
            return response([
                'msg' => 'Email or Password is incorrect',
                'success' => false
            ], 200);
        }
        /** @var User $user */
        $user  = Auth::guard('admin')->user();
        $token = $user->createToken('main')->plainTextToken;
        $success = true;
        $msg = 'Login success!';
        return response(compact('user', 'token', 'success', 'msg'));
    }

    public function adminUpdateProfile(Request $request)
    {
        $user  = Auth::guard('admin')->user();
        $data = $request->validate([
            'firstName' => 'required|string',
            'firstName' => 'required|string',
            'phone' => 'required|string',
        ]);
        /** @var Admin $user */
        $user->update($data);
        return response(['success' => true, 'msg' => 'Profile updated']);
    }

    public function adminUpdateEmail(Request $request)
    {
        $user  = Auth::guard('admin')->user();
        if (!$user || !Hash::check($request['password'], $user->password)) {
            return response(['success' => false, 'msg' => 'Password is incorrect']);
        }
        $user->email = $request['email'];
        /** @var Admin $user */
        $user->update();
        return response(['success' => true, 'msg' => 'Email has been changed!']);
    }

    public function adminUpdatePassword(Request $request)
    {
        $user  = Auth::guard('admin')->user();
        /** @var Admin $user */
        if (!$user || !Hash::check($request['currentPassword'], $user->password)) {
            return response(['success' => false, 'msg' => 'Password is incorrect']);
        }
        $user->password = Hash::make($request['newPassword']);
        /** @var Admin $user */
        $user->update();
        return response(['success' => true, 'msg' => 'Password has been updated!']);
    }

    public function adminSignout()
    {
        /** @var Admin $user */
        $user  = Auth::guard('admin')->user();
        $user->currentAccessToken()->delete;
        return response(['success' => true]);
    }
}
