<?php

use Illuminate\Support\Facades\Route;
use Modules\World\Http\Controllers\Backend\WorldsController;
use Modules\World\Http\Controllers\Backend\CountryController;
use Modules\World\Http\Controllers\Backend\StateController;
use Modules\World\Http\Controllers\Backend\CityController;


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
     *  Backend Worlds Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'worlds', 'as' => 'worlds.'],function () {
      Route::get("index_list", [WorldsController::class, 'index_list'])->name("index_list");
      Route::get("index_data", [WorldsController::class, 'index_data'])->name("index_data");
      Route::get('export', [WorldsController::class, 'export'])->name('export');
      Route::post('bulk-action', [WorldsController::class, 'bulk_action'])->name('bulk_action');
      Route::post('restore/{id}', [WorldsController::class, 'restore'])->name('restore');
      Route::delete('force-delete/{id}', [WorldsController::class, 'forceDelete'])->name('force_delete');
      Route::post('update-status/{id}', [WorldsController::class, 'update_status'])->name('update_status');

    });
    Route::resource("worlds", WorldsController::class);




    Route::group(['prefix' => 'country', 'as' => 'country.'], function () {
        Route::get('index_list', [CountryController::class, 'index_list'])->name('index_list');
        Route::get('index_data', [CountryController::class, 'index_data'])->name('index_data');
        Route::get('export', [CountryController::class, 'export'])->name('export');
        Route::post('bulk-action', [CountryController::class, 'bulk_action'])->name('bulk_action');
        Route::post('restore/{id}', [CountryController::class, 'restore'])->name('restore');
        Route::delete('force-delete/{id}', [CountryController::class, 'forceDelete'])->name('force_delete');
        Route::post('update-status/{id}', [CountryController::class, 'update_status'])->name('update_status');

        });
    Route::resource('country', CountryController::class);

    Route::group(['prefix' => 'state', 'as' => 'state.'], function () {
        Route::get('index_list', [StateController::class, 'index_list'])->name('index_list');
        Route::get('index_data', [StateController::class, 'index_data'])->name('index_data');
        Route::get('export', [StateController::class, 'export'])->name('export');
        Route::post('bulk-action', [StateController::class, 'bulk_action'])->name('bulk_action');
        Route::post('restore/{id}', [StateController::class, 'restore'])->name('restore');
        Route::delete('force-delete/{id}', [StateController::class, 'forceDelete'])->name('force_delete');
        Route::post('update-status/{id}', [StateController::class, 'update_status'])->name('update_status');

      });
    Route::resource('state', StateController::class);

    Route::group(['prefix' => 'city', 'as' => 'city.'], function () {
        Route::get('index_list', [CityController::class, 'index_list'])->name('index_list');
        Route::get('index_data', [CityController::class, 'index_data'])->name('index_data');
        Route::get('export', [CityController::class, 'export'])->name('export');
        Route::post('bulk-action', [CityController::class, 'bulk_action'])->name('bulk_action');
        Route::post('restore/{id}', [CityController::class, 'restore'])->name('restore');
        Route::delete('force-delete/{id}', [CityController::class, 'forceDelete'])->name('force_delete');
        Route::post('update-status/{id}', [CityController::class, 'update_status'])->name('update_status');

       });
    Route::resource('city', CityController::class);
});



