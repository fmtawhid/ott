<?php

use Illuminate\Support\Facades\Route;
use Modules\Episode\Http\Controllers\Backend\EpisodesController;



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
     *  Backend Episodes Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'episodes', 'as' => 'episodes.'],function () {
      Route::get("index_list", [EpisodesController::class, 'index_list'])->name("index_list");
      Route::get("index_data", [EpisodesController::class, 'index_data'])->name("index_data");
      Route::get('export', [EpisodesController::class, 'export'])->name('export');
      Route::post('update-status/{id}', [EpisodesController::class, 'update_status'])->name('update_status');
      Route::post('update_is_restricted/{id}', [EpisodesController::class, 'update_is_restricted'])->name('update_is_restricted');
      Route::post('bulk-action', [EpisodesController::class, 'bulk_action'])->name('bulk_action');

      Route::get('download-option/{id}', [EpisodesController::class, 'downloadOption'])->name('download-option');
      Route::Post('store-downloads/{id}', [EpisodesController::class, 'storeDownloads'])->name('store-downloads');
      Route::post('restore/{id}', [EpisodesController::class, 'restore'])->name('restore');
      Route::delete('force-delete/{id}', [EpisodesController::class, 'forceDelete'])->name('force_delete');

      Route::get('/import-season-list', [EpisodesController::class, 'ImportSeasonlist'])->name('import-season-list');
      Route::post('/import-episode-list', [EpisodesController::class, 'ImportEpisodelist'])->name('import-episode-list');
      Route::post('/generate-description', [EpisodesController::class, 'GenerateDescription'])->name('generate-description');

      Route::post('/import-episode', [EpisodesController::class, 'ImportEpisode'])->name('import-episode');
      Route::get('details/{id}', [EpisodesController::class, 'details'])->name("details");

      Route::get('get-access-type', [EpisodesController::class, 'getAccessType'])->name("get-access-type");


    });
    Route::resource("episodes", EpisodesController::class);
});



