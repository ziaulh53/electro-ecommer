<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

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

    public function userUpdateProfile(Request $request)
    {
        $user  = Auth::user();
        $data = $request->validate([
            'firstName' => 'required|string',
            'firstName' => 'required|string',
            'phone' => 'required|string',
        ]);
        /** @var User $user */
        $user->update($data);
        return response(['success' => true, 'msg' => 'Profile updated']);
    }

    public function userUpdateEmail(Request $request)
    {
        $user  = Auth::user();
        if (!$user || !Hash::check($request['password'], $user->password)) {
            return response(['success' => false, 'msg' => 'Password is incorrect']);
        }
        $user->email = $request['email'];
        /** @var User $user */
        $user->update();
        return response(['success' => true, 'msg' => 'Email has been changed!']);
    }

    public function userUpdatePassword(Request $request)
    {
        $user  = Auth::user();
        if (!$user || !Hash::check($request['currentPassword'], $user->password)) {
            return response(['success' => false, 'msg' => 'Password is incorrect']);
        }
        $user->password = Hash::make($request['newPassword']);
        /** @var User $user */
        $user->update();
        return response(['success' => true, 'msg' => 'Password has been updated!']);
    }

    public function userSignout()
    {
        /** @var User $user */
        $user  = Auth::user();
        $user->currentAccessToken()->delete;
        return response(['success' => true]);
    }

    public function userResetPasswordRequest(Request $request)
    {
        /** @var User $user */
        $user = User::where('email', $request['email'])->first();
        if (!$user) {
            return response(['success' => false, 'msg' => 'User not found'], 404);
        }
        Password::broker('users')->sendResetLink($request->only('email'));
        return response(['success' => true, 'msg' => 'Password reset link sent successfully.'], 201);
    }

    public function userResetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required',
        ]);

        $user = Password::broker('users')->reset($request->only('email', 'password', 'token'), function (User $user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });

        if (!$user) {
            return response()->json(['error' => 'Invalid token.'], 401);
        }

        return response(['success' => true, 'msg' => 'Password reset successfully.']);
    }
}
