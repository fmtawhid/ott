<?php

use Illuminate\Support\Facades\Route;
use Modules\Season\Http\Controllers\Backend\SeasonsController;



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
     *  Backend Seasons Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'seasons', 'as' => 'seasons.'],function () {
      Route::get("index_list", [SeasonsController::class, 'index_list'])->name("index_list");
      Route::get("index_data", [SeasonsController::class, 'index_data'])->name("index_data");
      Route::get('export', [SeasonsController::class, 'export'])->name('export');
      Route::post('update-status/{id}', [SeasonsController::class, 'update_status'])->name('update_status');
      Route::post('bulk-action', [SeasonsController::class, 'bulk_action'])->name('bulk_action');
      Route::post('restore/{id}', [SeasonsController::class, 'restore'])->name('restore');
      Route::delete('force-delete/{id}', [SeasonsController::class, 'forceDelete'])->name('force_delete');

      Route::post('/generate-description', [SeasonsController::class, 'GenerateDescription'])->name('generate-description');
      Route::get('/import-season-list', [SeasonsController::class, 'ImportSeasonlist'])->name('import-season-list');

      Route::post('/import-season', [SeasonsController::class, 'ImportSeasonDetails'])->name('import-season');
      Route::get('details/{id}', [SeasonsController::class, 'details'])->name("details");
    });
    Route::resource("seasons", SeasonsController::class);
});



