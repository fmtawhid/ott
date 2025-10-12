<?php

use Illuminate\Support\Facades\Route;
use Modules\Filemanager\Http\Controllers\Backend\FilemanagersController;



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
     *  Backend Filemanagers Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'media-library', 'as' => 'media-library.'],function () {
      Route::get("index_list", [FilemanagersController::class, 'index_list'])->name("index_list");
      Route::post("upload", [FilemanagersController::class, 'upload'])->name("upload");
      Route::post("store", [FilemanagersController::class, 'store'])->name("store-data");
      Route::get("getMediaStore", [FilemanagersController::class, 'getMediaStore'])->name("getMediaStore");
    //   Route::delete("destroy", [FilemanagersController::class, 'destroy'])->name("destroy");
      Route::get("index_data", [FilemanagersController::class, 'index_data'])->name("index_data");
      Route::get('export', [FilemanagersController::class, 'export'])->name('export');
      Route::post('bulk-action', [FilemanagersController::class, 'bulk_action'])->name('bulk_action');
      Route::post('restore/{id}', [FilemanagersController::class, 'restore'])->name('restore');
      Route::delete('force-delete/{id}', [FilemanagersController::class, 'forceDelete'])->name('force_delete');
      Route::get('search-media', [FilemanagersController::class, 'SearchMedia'])->name('search-media');
      Route::get('get-image-details', [FilemanagersController::class, 'GetImageDetails'])->name('get-image-details');



    });
    Route::resource("media-library", FilemanagersController::class);
});



