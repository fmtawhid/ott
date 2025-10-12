<?php

use Illuminate\Support\Facades\Route;
use Modules\Video\Http\Controllers\API\VideosController;

Route::get('video-list', [VideosController::class, 'videoList']);
Route::get('video-details', [VideosController::class, 'videoDetails']);


