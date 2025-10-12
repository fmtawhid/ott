<?php

use Illuminate\Support\Facades\Route;
use Modules\LiveTV\Http\Controllers\Backend\LiveTVsController;
use Modules\LiveTV\Http\Controllers\Backend\LiveTvCatgeoryController;
use Modules\LiveTV\Http\Controllers\Backend\LiveTvChannelController;



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
     *  Backend LiveTVs Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'livetvs', 'as' => 'livetvs.'],function () {
      Route::get("index_list", [LiveTVsController::class, 'index_list'])->name("index_list");
      Route::get("index_data", [LiveTVsController::class, 'index_data'])->name("index_data");
      Route::get('export', [LiveTVsController::class, 'export'])->name('export');
      Route::post('bulk-action', [LiveTVsController::class, 'bulk_action'])->name('bulk_action');
      Route::post('restore/{id}', [LiveTVsController::class, 'restore'])->name('restore');
      Route::delete('force-delete/{id}', [LiveTVsController::class, 'forceDelete'])->name('force_delete');
    });
    Route::resource("livetvs", LiveTVsController::class);


    Route::group(['prefix' => 'tv-category', 'as' => 'tv-category.'],function () {
      Route::get("index_list", [LiveTvCatgeoryController::class, 'index_list'])->name("index_list");
      Route::get("index_data", [LiveTvCatgeoryController::class, 'index_data'])->name("index_data");
      Route::get('export', [LiveTvCatgeoryController::class, 'export'])->name('export');
      Route::post('bulk-action', [LiveTvCatgeoryController::class, 'bulk_action'])->name('bulk_action');
      Route::post('restore/{id}', [LiveTvCatgeoryController::class, 'restore'])->name('restore');
      Route::delete('force-delete/{id}', [LiveTvCatgeoryController::class, 'forceDelete'])->name('force_delete');
      Route::post('update-status/{id}', [LiveTvCatgeoryController::class, 'update_status'])->name('update_status');
    });
    Route::resource('tv-category', LiveTvCatgeoryController::class);

    Route::group(['prefix' => 'tv-channel', 'as' => 'tv-channel.'],function () {
      Route::get("index_list", [LiveTvChannelController::class, 'index_list'])->name("index_list");
      Route::get("index_data", [LiveTvChannelController::class, 'index_data'])->name("index_data");
      Route::get('export', [LiveTvChannelController::class, 'export'])->name('export');
      Route::post('bulk-action', [LiveTvChannelController::class, 'bulk_action'])->name('bulk_action');
      Route::post('restore/{id}', [LiveTvChannelController::class, 'restore'])->name('restore');
      Route::delete('force-delete/{id}', [LiveTvChannelController::class, 'forceDelete'])->name('force_delete');
      Route::post('update-status/{id}', [LiveTvChannelController::class, 'update_status'])->name('update_status');
    });
    Route::resource("tv-channel", LiveTvChannelController::class);
});



