<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ColorController;
use App\Http\Controllers\Api\FileUploadController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TrendingController;
use App\Http\Controllers\Api\UserAuthController;
use App\Http\Controllers\Api\UsersController;
use App\Models\ProductColor;
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
        Route::post('/update-profile', [UserAuthController::class,'userUpdateProfile']);
        Route::post('/change-email-request', [UserAuthController::class,'userUpdateEmail']);
        Route::post('/change-password', [UserAuthController::class,'userUpdatePassword']);
        

        Route::apiResource('/address', AddressController::class);
        Route::apiResource('/order', OrderController::class);
        Route::get('/order/{id}', [OrderController::class, 'getSingleOrder']);
    });

    //admin
    Route::prefix('/admin')->group(function () {
        Route::middleware(['role:super_admin,admin'])->group(function () {
            Route::post('/signout', [AdminAuthController::class, 'adminSignout']);
            Route::get('/user', [UsersController::class, 'getUsers']);
            Route::apiResource('/brand', BrandController::class);
            Route::apiResource('/color', ColorController::class);
            Route::apiResource('/category', CategoryController::class);
            Route::apiResource('/product', ProductController::class);
            Route::apiResource('/banner', BannerController::class);
            Route::apiResource('/trending', TrendingController::class);
            Route::get('/order', [OrderController::class, 'getAdminOrders']);
            Route::put('/order/{id}', [OrderController::class, 'updateOrderAdmin']);
            Route::get('/order/{id}', [OrderController::class, 'getSingleOrder']);
            // Route::delete('/order/{id}',[OrderController::class,'destroy']);
        });
    });

    // common
    Route::post('/file-upload', [FileUploadController::class, 'storeUploads']);
});

// public route
Route::get('/brands', [BrandController::class, 'index']);
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/product/new-arrival', [ProductController::class, 'getNewArrival']);
Route::get('/product/trending', [TrendingController::class, 'index']);
Route::get('/banner', [BannerController::class, 'index']);
Route::get('/category/{id}', [CategoryController::class, 'show']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/product-by-category/{id}',[ProductController::class,'getProductsByCategory']);
Route::get('/product-suggestion', [ProductController::class, 'getSuggestion']);
Route::get('/brands/{id}', [ProductController::class, 'getProdcutsByBrand']);

Route::post('/signup', [UserAuthController::class, 'userSignup']);
Route::post('/signin', [UserAuthController::class, 'userLogin']);
Route::post('/forgot-password',[UserAuthController::class, 'userResetPasswordRequest'])->name('password.email');
Route::post('/reset-password', [UserAuthController::class, 'userResetPassword'])->name('password.reset');


// admin routes
Route::prefix('/admin')->group(function () {
    Route::post('/signup', [AdminAuthController::class, 'adminSignup']);
    Route::post('/signin', [AdminAuthController::class, 'adminSignin']);
});
