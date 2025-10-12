<?php

use Illuminate\Support\Facades\Route;
use Modules\Coupon\Http\Controllers\CouponController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'app', 'as' => 'backend.', 'middleware' => ['auth', 'admin']], function () {
    Route::group(['prefix' => 'coupon', 'as' => 'coupon.'], function () {
        Route::get('/', [CouponController::class, 'index'])->name('index');
        Route::get('create', [CouponController::class, 'create'])->name('create');
        Route::post('store', [CouponController::class, 'store'])->name('store');
        Route::get('edit/{coupon}', [CouponController::class, 'edit'])->name('edit');
        Route::put('update/{coupon}', [CouponController::class, 'update'])->name('update');
        Route::delete('destroy/{id}', [CouponController::class, 'destroy'])->name('destroy');
        Route::get('index_data', [CouponController::class, 'index_data'])->name('index_data');
        Route::post('coupons/bulk-action', [CouponController::class, 'bulk_action'])->name('backend.coupon.bulk_action');
        Route::get('export', [CouponController::class, 'export'])->name('export');
        Route::get('/trashed', [CouponController::class, 'trashed'])->name('trashed');
        Route::post('bulk-action', [CouponController::class, 'bulk_action'])->name('bulk_action');
        Route::post('update-status/{id}', [CouponController::class, 'update_status'])->name('update_status');
        Route::post('restore/{id}', [CouponController::class, 'restore'])->name('restore');
        Route::delete('force-delete/{id}', [CouponController::class, 'forceDelete'])->name('force_delete');
        Route::get('coupons-view', [CouponController::class, 'couponsview'])->name('coupons-view');
        Route::get('coupon-data/{id}', [CouponController::class, 'coupon_data'])->name('coupon_data');
        Route::post('/calculate-discount', [CouponController::class, 'calculate_discount'])->name('calculate_discount');        
        Route::post('/get-plan-coupons', [CouponController::class, 'getPlanCoupons'])->name('get-plan-coupons');
        Route::get('/apply-coupon', [CouponController::class, 'applyCoupon'])->name('applyCoupon');  
        Route::post('/get-plan-coupons', [CouponController::class, 'getPlanCoupons'])->name('get-plan-coupons');
    });
    Route::get('coupon/{id}/restore', [CouponController::class, 'restore'])->name('backend.coupon.restore');
    Route::delete('coupon/{id}/force-delete', [CouponController::class, 'force_delete'])->name('backend.coupon.force_delete');
});