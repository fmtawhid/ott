
<?php

use Illuminate\Support\Facades\Route;
use Modules\Subscriptions\Http\Controllers\Backend\PlanController;
use Modules\Subscriptions\Http\Controllers\Backend\PlanLimitationController;
use Modules\Subscriptions\Http\Controllers\Backend\SubscriptionController;

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
     *  Backend  plan  Routes
     *
     * ---------------------------------------------------------------------
     */
    // Planlimitation Routes

    Route::group(['prefix' => 'subscriptions', 'as' => 'subscriptions.'], function () {
        Route::get('/index_data', [SubscriptionController::class, 'index_data'])->name('index_data');
        Route::get('export', [SubscriptionController::class, 'export'])->name('export');
        Route::get('/trashed', [SubscriptionController::class, 'trashed'])->name('trashed');
        Route::post('bulk-action', [SubscriptionController::class, 'bulk_action'])->name('bulk_action');
        Route::post('restore/{id}', [SubscriptionController::class, 'restore'])->name('restore');
        Route::delete('force-delete/{id}', [SubscriptionController::class, 'forceDelete'])->name('force_delete');



        Route::post('subscriptions/export-pdf', [SubscriptionController::class, 'exportPdf'])->name('exportPdf');
    });

    Route::resource('subscriptions', SubscriptionController::class);

      Route::get('/pay-per-view-history', [SubscriptionController::class, 'pay_per_view_data'])->name('pay-per-view-history');
      Route::get('/pay-per-view-history-data', [SubscriptionController::class, 'RentData'])->name('pay-per-view-history-data');
      Route::get('export', [SubscriptionController::class, 'export'])->name('pay-per-view-export');




    // subscription Plan Routes


        Route::group(['prefix' => 'plans', 'as' => 'plans.'], function () {
            Route::get('/index_list', [PlanController::class, 'index_list'])->name('index_list');
            Route::get('/index_data', [PlanController::class, 'index_data'])->name('index_data');
            Route::get('export', [PlanController::class, 'export'])->name('export');
            Route::get('/trashed', [PlanController::class, 'trashed'])->name('trashed');
            Route::post('/restore/{id}', [PlanController::class, 'restore'])->name('restore');
            Route::delete('/force_delete/{id}', [PlanController::class, 'forceDelete'])->name('force_delete');
            Route::post('bulk-action', [PlanController::class, 'bulk_action'])->name('bulk_action');
            Route::post('update-status/{id}', [PlanController::class, 'update_status'])->name('update_status');
         });

     Route::resource('plans', PlanController::class);

        Route::group(['prefix' => '/planlimitation', 'as' => 'planlimitation.'], function () {
            Route::get('/index_list', [PlanLimitationController::class, 'index_list'])->name('index_list');
            Route::get('/index_data', [PlanLimitationController::class, 'index_data'])->name('index_data');
            Route::get('export', [PlanLimitationController::class, 'export'])->name('export');
            Route::get('/trashed', [PlanLimitationController::class, 'trashed'])->name('trashed');
            Route::post('/restore/{id}', [PlanLimitationController::class, 'restore'])->name('restore');
            Route::delete('/force_delete/{id}', [PlanLimitationController::class, 'forceDelete'])->name('force_delete');
            Route::post('bulk-action', [PlanLimitationController::class, 'bulk_action'])->name('bulk_action');
            Route::post('update-status/{id}', [PlanLimitationController::class, 'update_status'])->name('update_status');
        });
        Route::resource('planlimitation', PlanLimitationController::class);


    Route::group(['prefix' => 'subscription', 'as' => 'subscription.'], function () {
        Route::group(['prefix' => '/account', 'as' => 'account.'], function () {
        });


    });


});
