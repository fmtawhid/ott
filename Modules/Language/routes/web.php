<?php

use Illuminate\Support\Facades\Route;
use Modules\Language\Http\Controllers\Backend\LanguagesController;

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
     *  Backend Languages Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'languages', 'as' => 'languages.'], function () {
        Route::get('index_list', [LanguagesController::class, 'index_list'])->name('index_list');
        Route::get('array_list', [LanguagesController::class, 'array_list'])->name('array_list');

        Route::get('get_file_data', [LanguagesController::class, 'get_file_data'])->name('get_file_data');
    });
    Route::resource('languages', LanguagesController::class);
});
