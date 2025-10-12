<?php

use Illuminate\Support\Facades\Route;
use Modules\Currency\Http\Controllers\Backend\CurrenciesController;



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
     *  Backend Currencies Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'currencies', 'as' => 'currencies.'],function () {
      Route::get("index_list", [CurrenciesController::class, 'index_list'])->name("index_list");
      Route::get("index_data", [CurrenciesController::class, 'index_data'])->name("index_data");
      Route::get('export', [CurrenciesController::class, 'export'])->name('export');
      Route::post('bulk-action', [CurrenciesController::class, 'bulk_action'])->name('bulk_action');
      Route::post('restore/{id}', [CurrenciesController::class, 'restore'])->name('restore');
      Route::delete('force-delete/{id}', [CurrenciesController::class, 'forceDelete'])->name('force_delete');
      Route::post('update-status/{id}', [CurrenciesController::class, 'update_status'])->name('update_status');


    });
    Route::resource("currencies", CurrenciesController::class);
});



