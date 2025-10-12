<?php

use Illuminate\Support\Facades\Route;
use Modules\FAQ\Http\Controllers\Backend\FAQSController;



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
     *  Backend FAQS Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'faqs', 'as' => 'faqs.'],function () {
      Route::get("index_list", [FAQSController::class, 'index_list'])->name("index_list");
      Route::get("index_data", [FAQSController::class, 'index_data'])->name("index_data");
      Route::get('export', [FAQSController::class, 'export'])->name('export');
      Route::post('bulk-action', [FAQSController::class, 'bulk_action'])->name('bulk_action');
      Route::post('restore/{id}', [FAQSController::class, 'restore'])->name('restore');
      Route::delete('force-delete/{id}', [FAQSController::class, 'forceDelete'])->name('force_delete');
      Route::post('update-status/{id}', [FAQSController::class, 'update_status'])->name('update_status');
    });
    Route::resource("faqs", FAQSController::class);
});



