<?php

use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\Api\FileUploadController;
use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\Api\UsersController;
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

// auth routes
Route::middleware('auth:sanctum')->group(function () {
    // user
    Route::middleware(['role:user'])->group(function () {
        Route::post('/signout', [UserAuthController::class, 'userSignout']);
    });


    //admin
    Route::prefix('/admin')->group(function () {
        Route::middleware(['role:super_admin,admin'])->group(function () {
            Route::post('/signout', [AdminAuthController::class, 'adminSignout']);
            Route::get('/user',[UsersController::class, 'getUsers']);
            Route::apiResource('/brand', BrandController::class);
            Route::apiResource('/color', ColorController::class);
            Route::apiResource('/category', CategoryController::class);
        });
    });

    // common
    Route::post('/file-upload', [FileUploadController::class, 'storeUploads']);
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
