<?php

use Illuminate\Support\Facades\Route;
use Modules\Video\Http\Controllers\Backend\VideosController;



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
     *  Backend Videos Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'videos', 'as' => 'videos.'],function () {
      Route::get("index_list", [VideosController::class, 'index_list'])->name("index_list");
      Route::get("index_data", [VideosController::class, 'index_data'])->name("index_data");
      Route::get('export', [VideosController::class, 'export'])->name('export');
      Route::post('update-status/{id}', [VideosController::class, 'update_status'])->name('update_status');
      Route::post('update_is_restricted/{id}', [VideosController::class, 'update_is_restricted'])->name('update_is_restricted');
      Route::post('bulk-action', [VideosController::class, 'bulk_action'])->name('bulk_action');
      Route::post('restore/{id}', [VideosController::class, 'restore'])->name('restore');
      Route::delete('force-delete/{id}', [VideosController::class, 'forceDelete'])->name('force_delete');

      Route::post('/generate-description', [VideosController::class, 'GenerateDescription'])->name('generate-description');
      Route::get('download-option/{id}', [VideosController::class, 'downloadOption'])->name('download-option');
      Route::post('store-downloads/{id}', [VideosController::class, 'storeDownloads'])->name('store-downloads');

    });
    Route::resource("videos", VideosController::class);

});



