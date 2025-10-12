<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\API\UserController;
use Modules\User\Http\Controllers\API\UserMultiProfileController;
use Modules\User\Http\Controllers\API\UserSearchHistoryController;


Route::get('device-logout-data', [UserController::class, 'deviceLogout']);
Route::get('logout-all-data', [UserController::class, 'logoutAll']);

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('profile-details', [UserController::class, 'profileDetails']);
    Route::get('account-setting', [UserController::class, 'accountSetting']);
    Route::get('device-logout', [UserController::class, 'deviceLogout']);
    Route::get('logout-all', [UserController::class, 'logoutAll']);
    Route::get('delete-account', [UserController::class, 'deleteAccount']);

    Route::get('user-profile-list', [UserMultiProfileController::class, 'profileList']);
    Route::post('save-userprofile', [UserMultiProfileController::class, 'saveProfile']);
    Route::get('get-userprofile/{id}', [UserMultiProfileController::class, 'getprofile']);
    Route::post('delete-userprofile', [UserMultiProfileController::class, 'deleteProfile']);

    Route::get('select-userprofile/{id}', [UserMultiProfileController::class, 'SelectProfile']);



    Route::get('search-list', [UserSearchHistoryController::class, 'searchHistoryList']);
    Route::post('save-search', [UserSearchHistoryController::class, 'saveSearchHistory']);
    Route::get('delete-search', [UserSearchHistoryController::class, 'deleteSearchHistory']);

    Route::post('save-watch-content', [UserController::class, 'saveWatchHistory']);


});
?>
