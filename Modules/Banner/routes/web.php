<?php

use Illuminate\Support\Facades\Route;
use Modules\Banner\Http\Controllers\Backend\BannersController;



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
     *  Backend Banners Routes
     *
     * ---------------------------------------------------------------------
     */

     Route::group(['prefix' => 'banners', 'as' => 'banners.'],function () {
      // Route::get("index_list", [BannersController::class, 'index_list'])->name("index_list");
      Route::get('index_list/{type}', [BannersController::class, 'index_list'])->name("index_list");

      Route::get("index_data", [BannersController::class, 'index_data'])->name("index_data");
      Route::get('export', [BannersController::class, 'export'])->name('export');
      Route::get('/trashed', [BannersController::class, 'trashed'])->name('trashed');
      Route::post('bulk-action', [BannersController::class, 'bulk_action'])->name('bulk_action');
      Route::post('update-status/{id}', [BannersController::class, 'update_status'])->name('update_status');
      Route::post('restore/{id}', [BannersController::class, 'restore'])->name('restore');
      Route::delete('force-delete/{id}', [BannersController::class, 'forceDelete'])->name('force_delete');

    });
    Route::resource("banners", BannersController::class)->names('banners');
});



