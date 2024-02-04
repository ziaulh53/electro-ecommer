<?php

use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\UserAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:user')->group(function () {
    Route::post('/signout', [UserAuthController::class, 'userSignout']);
});

Route::post('/signup', [UserAuthController::class, 'userSignup']);
Route::post('/signin', [UserAuthController::class, 'userLogin']);

// Route::post('/forgot-password', [UserPasswordResetController::class, 'forgotPassword'])->name('password.email');
// Route::post('/reset-password', [UserPasswordResetController::class, 'resetPassword'])->name('password.reset');


// admin routes
Route::prefix('/admin')->group(function () {


    Route::post('/signup', [AdminAuthController::class, 'adminSignup']);
    Route::post('/signin', [AdminAuthController::class, 'adminSignin']);
});
