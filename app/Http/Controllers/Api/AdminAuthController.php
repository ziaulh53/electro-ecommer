<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminRegisterRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function adminSignout (){
          /** @var Admin $user */
        $user  = Auth::guard('admin')->user();
        echo $user;
        // $user->currentAccessToken()->delete;
        return response(['success' => true]);
    }
}
