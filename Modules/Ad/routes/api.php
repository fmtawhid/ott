<?php
use Modules\Ad\Http\Controllers\API\VastAdsSettingController;
use Modules\Ad\Http\Controllers\API\CustomAdsSettingController;
use Illuminate\Support\Facades\Route;
use Modules\Ad\Http\Controllers\API\VastAdsController;


Route::get('get-vast-ads', [VastAdsSettingController::class, 'vastadsList']);
Route::get('get-custom-ads', [CustomAdsSettingController::class, 'customadsList']);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::prefix('vast-ads')->group(function() {
        Route::get('get-active', [VastAdsController::class, 'getActiveAds'])->name('api.vast-ads.get-active');
    });

    Route::prefix('custom-ads')->group(function() {
        Route::get('get-active', [CustomAdsSettingController::class, 'getActiveAds'])->name('api.custom-ads.get-active');
    });
});