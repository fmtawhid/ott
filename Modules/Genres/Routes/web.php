<?php

use Illuminate\Support\Facades\Route;
use Modules\Genres\Http\Controllers\GenresController;

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

Route::group(['prefix' => 'app', 'as' => 'backend.', 'middleware' => ['auth','admin']], function () {

    Route::group(['prefix' => '/genres', 'as' => 'genres.'], function () {
        Route::get('/index_list', [GenresController::class, 'index_list'])->name('index_list');
        Route::get('/index_data', [GenresController::class, 'index_data'])->name('index_data');
        Route::get('export', [GenresController::class, 'export'])->name('export');
        Route::get('/trashed', [GenresController::class, 'trashed'])->name('trashed');
        Route::post('bulk-action', [GenresController::class, 'bulk_action'])->name('bulk_action');
        Route::post('update-status/{id}', [GenresController::class, 'update_status'])->name('update_status');
        Route::post('restore/{id}', [GenresController::class, 'restore'])->name('restore');
        Route::delete('force-delete/{id}', [GenresController::class, 'forceDelete'])->name('force_delete');
    });
    Route::resource('genres', GenresController::class)->names('genres');

});
