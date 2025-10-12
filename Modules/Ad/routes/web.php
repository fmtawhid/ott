<?php

use Illuminate\Support\Facades\Route;
use Modules\Ad\Http\Controllers\Backend\AdsController;
use Modules\Ad\Http\Controllers\Backend\VastAdsSettingController;
use Modules\Ad\Http\Controllers\Backend\CustomAdsSettingController;


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
/*
*
* Backend Routes
*
* --------------------------------------------------------------------
*/
Route::group(['prefix' => 'app', 'as' => 'backend.', 'middleware' => ['auth','admin']], function () {
    /*
    * These routes need view-backend permission
    * (good if you want to allow more than one group in the backend,
    * then limit the backend features by different roles or permissions)
    *
    * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
    */

    /*
     *
     *  Backend Ads Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'ads', 'as' => 'ads.'],function () {
      Route::get("index_list", [AdsController::class, 'index_list'])->name("index_list");
      Route::get("index_data", [AdsController::class, 'index_data'])->name("index_data");
      Route::get('export', [AdsController::class, 'export'])->name('export');
      Route::get('ads/{' . 'ads' . '}/edit', [AdsController::class, 'edit'])->name('edit');
      Route::post('bulk-action', [AdsController::class, 'bulk_action'])->name('bulk_action');
      Route::post('restore/{id}', [AdsController::class, 'restore'])->name('restore');
      Route::delete('force-delete/{id}', [AdsController::class, 'forceDelete'])->name('force_delete');
    });
    Route::resource("ads", AdsController::class);

    Route::group(['prefix' => 'vastads', 'as' => 'vastads.'],function () {
      Route::get("index_list", [VastAdsSettingController::class, 'index_list'])->name("index_list");
      Route::get("index_data", [VastAdsSettingController::class, 'index_data'])->name("index_data");
      Route::get('export', [VastAdsSettingController::class, 'export'])->name('export');
      Route::get('ads/{' . 'ads' . '}/edit', [VastAdsSettingController::class, 'edit'])->name('edit');
      Route::post('bulk-action', [VastAdsSettingController::class, 'bulk_action'])->name('bulk_action');
      Route::post('restore/{id}', [VastAdsSettingController::class, 'restore'])->name('restore');
      Route::delete('force-delete/{id}', [VastAdsSettingController::class, 'forceDelete'])->name('force_delete');
      Route::post('update-status/{id}', [VastAdsSettingController::class, 'update_status'])->name('update_status');
      Route::get('/get-target-selection', [VastAdsSettingController::class, 'getTargetSelection'])->name('get-target-selection');
      Route::post('reactivate/{id}', [VastAdsSettingController::class, 'reactivate'])->name('reactivate');


    });
    Route::resource("vastads", VastAdsSettingController::class);


    Route::group(['prefix' => 'customads', 'as' => 'customads.'],function () {
      Route::get("index_list", [CustomAdsSettingController::class, 'index_list'])->name("index_list");
      Route::get("index_data", [CustomAdsSettingController::class, 'index_data'])->name("index_data");
      Route::get('export', [CustomAdsSettingController::class, 'export'])->name('export');
      Route::get('ads/{' . 'ads' . '}/edit', [CustomAdsSettingController::class, 'edit'])->name('edit');
      Route::post('bulk-action', [CustomAdsSettingController::class, 'bulk_action'])->name('bulk_action');
      Route::post('restore/{id}', [CustomAdsSettingController::class, 'restore'])->name('restore');
      Route::delete('force-delete/{id}', [CustomAdsSettingController::class, 'forceDelete'])->name('force_delete');
      Route::post('update-status/{id}', [CustomAdsSettingController::class, 'update_status'])->name('update_status');
      Route::get('/get-target-categories', [CustomAdsSettingController::class, 'getTargetCategories'])->name('get-target-categories');
      Route::post('reactivate/{id}', [CustomAdsSettingController::class, 'reactivate'])->name('reactivate');


    });
    Route::resource("customads", CustomAdsSettingController::class);
});



