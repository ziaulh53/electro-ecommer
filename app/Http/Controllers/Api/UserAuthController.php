<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{
    public function userSignup(UserRegisterRequest $request)
    {
        $data = $request->validated();
        /** @var User $user */
        $data['password'] = bcrypt($data['password']); 
        User::create($data);
        return response(['success' => true, 'msg' => 'Registration Successfully']);
    }

    public function userLogin(Request $request)
    {
        $credential = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (!Auth::attempt($credential)) {
            return response([
                'msg' => 'Email or Password is incorrect',
                'success' => false
            ], 200);
        }
        /** @var User $user */
        $user  = Auth::user();
        $token = $user->createToken('main')->plainTextToken;
        $success = true;
        $msg = 'Login success!';
        return response(compact('user', 'token', 'success', 'msg'));
    }

    public function userSignout (){
          /** @var User $user */
        $user  = Auth::user();
        $user->currentAccessToken()->delete;
        return response(['success' => true]);
    }
}
