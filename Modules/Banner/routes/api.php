<?php
use Illuminate\Support\Facades\Route;
use Modules\Banner\Http\Controllers\API\BannersController;

Route::get('/banners', [BannersController::class, 'getBanners']);