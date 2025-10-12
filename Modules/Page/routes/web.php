<?php

use Illuminate\Support\Facades\Route;
use Modules\Page\Http\Controllers\Backend\PagesController;



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

Route::get('page/{slug}', [PagesController::class,'page'])->name('backend.copyurl');
Route::get('/{slug}', [PagesController::class, 'show'])->name('page.show');
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
     *  Backend Pages Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'pages', 'as' => 'pages.'],function () {
      Route::get("index_list", [PagesController::class, 'index_list'])->name("index_list");
      Route::get("index_data", [PagesController::class, 'index_data'])->name("index_data");
      Route::get('export', [PagesController::class, 'export'])->name('export');
      Route::post('bulk-action', [PagesController::class, 'bulk_action'])->name('bulk_action');
      Route::post('update-status/{id}', [PagesController::class, 'update_status'])->name('update_status');
      Route::post('restore/{id}', [PagesController::class, 'restore'])->name('restore');
      Route::delete('force-delete/{id}', [PagesController::class, 'forceDelete'])->name('force_delete');
    });

    Route::resource("pages", PagesController::class);
});
