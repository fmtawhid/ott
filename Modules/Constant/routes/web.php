<?php

use Illuminate\Support\Facades\Route;
use Modules\Constant\Http\Controllers\Backend\ConstantsController;



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
Route::get('app/constants', [ConstantsController::class, 'index'])->name('backend.constants.index');
Route::get('app/constants/create', [ConstantsController::class, 'create'])->name('backend.constants.create');
Route::get('app/constants/{id}/edit', [ConstantsController::class, 'edit'])->name('backend.constants.edit');
Route::post('app/constants/store', [ConstantsController::class, 'store'])->name('backend.constants.store');
Route::delete('app/constants/{id}', [ConstantsController::class, 'destroy'])->name('backend.constants.destroy');
Route::put('app/constants/update/{id}', [ConstantsController::class, 'update'])->name('backend.constants.update');





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
   *  Backend Constants Routes
   *
   * ---------------------------------------------------------------------
   */

  Route::group(['prefix' => 'constants', 'as' => 'constants.'], function () {
    Route::get("/index_list", [ConstantsController::class, 'index_list'])->name("index_list");
    Route::get("index_data", [ConstantsController::class, 'index_data'])->name("index_data");
    Route::get('export', [ConstantsController::class, 'export'])->name('export');

    Route::post('restore/{id}', [ConstantsController::class, 'restore'])->name('restore');
    Route::post('bulk-action', [ConstantsController::class, 'bulk_action'])->name('bulk_action');
    Route::post('update-status/{id}', [ConstantsController::class, 'update_status'])->name('update_status');
    Route::delete('force-delete/{id}', [ConstantsController::class, 'forceDelete'])->name('force_delete');

  });
});



