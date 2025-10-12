<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Coupon\Http\Controllers\API\CouponController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::group(['middleware' => 'auth:sanctum'], function () {

    // Coupon API routes
        Route::get('/', [CouponController::class, 'index'])->name('coupons.index');
        Route::post('/store-coupons', [CouponController::class, 'store'])->name('coupons.store');
        Route::get('coupon-list', [CouponController::class, 'couponlist'])->name('couponlist');
        Route::put('update/{id}', [CouponController::class, 'update'])->name('coupons.update');
        Route::delete('destroy/{id}', [CouponController::class, 'destroy'])->name('coupons.destroy');
});
