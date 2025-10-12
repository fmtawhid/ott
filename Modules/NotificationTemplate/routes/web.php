<?php

use Illuminate\Support\Facades\Route;
use Modules\NotificationTemplate\Http\Controllers\Backend\NotificationTemplatesController;

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
     *  Backend NotificationTemplates Routes
     *
     * ---------------------------------------------------------------------
     */

    Route::group(['prefix' => 'notifications-templates', 'as' => 'notificationtemplates.'], function () {
        Route::get('index_list', [NotificationTemplatesController::class, 'index_list'])->name('index_list');
        Route::get('index_data', [NotificationTemplatesController::class, 'index_data'])->name('index_data');
        Route::get('export', [NotificationTemplatesController::class, 'export'])->name('export');
        Route::get('trashed', [NotificationTemplatesController::class, 'trashed'])->name('trashed');
        Route::patch('trashed/{id}', [NotificationTemplatesController::class, 'restore'])->name('restore');
        Route::get('ajax-list', [NotificationTemplatesController::class, 'getAjaxList'])->name('ajax-list');
        Route::get('notification-buttons', [NotificationTemplatesController::class, 'notificationButton'])->name('notification-buttons');
        Route::get('notification-template', [NotificationTemplatesController::class, 'notificationTemplate'])->name('notification-template');
        Route::post('channels-update', [NotificationTemplatesController::class, 'updateChanels'])->name('settings.update');
        Route::post('update-status/{id}', [NotificationTemplatesController::class, 'update_status'])->name('update_status');
        Route::post('bulk-action', [NotificationTemplatesController::class, 'bulk_action'])->name('bulk_action');
    });
    Route::resource('notification-templates', NotificationTemplatesController::class, ['names' => 'notification-templates']);
});
