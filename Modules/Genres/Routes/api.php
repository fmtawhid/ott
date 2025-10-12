<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Genres\Http\Controllers\Api\GenersController;

/*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
*/

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
    Route::get('genres', fn (Request $request) => $request->user())->name('genres');
});

Route::get('genre-list', [GenersController::class, 'genreList']);