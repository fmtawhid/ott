<?php

use Illuminate\Support\Facades\Route;
use Modules\Installer\Http\Controllers\Backend\WelcomeController;
use Modules\Installer\Http\Controllers\Backend\RequirementsController;
use Modules\Installer\Http\Controllers\Backend\PermissionsController;
use Modules\Installer\Http\Controllers\Backend\EnvironmentController;
use Modules\Installer\Http\Controllers\Backend\DatabaseController;
use Modules\Installer\Http\Controllers\Backend\FinalController;



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
Route::group(['prefix' => 'install'], function () {


    Route::get("/", [WelcomeController::class, 'welcome'])->name('install.index');

    Route::get("/environment", [EnvironmentController::class, 'environmentMenu'])->name("environment");
    Route::post("/environment/save", [WelcomeController::class, 'environmentSave'])->name("environment.save");
    Route::get("/requirements", [RequirementsController::class, 'requirements'])->name("requirements");
    Route::get("/permissions", [PermissionsController::class, 'permissions'])->name("permissions");
    Route::get("environment/wizard", [EnvironmentController::class, 'environmentWizard'])->name("environmentWizard");
    Route::get("environment/classic", [EnvironmentController::class, 'environmentClassic'])->name("environmentClassic");
    Route::post("environment/saveWizard", [EnvironmentController::class, 'saveWizard'])->name("environmentSaveWizard");
    Route::post("environment/saveClassic", [EnvironmentController::class, 'saveClassic'])->name("environmentSaveClassic");
    Route::get("/database", [DatabaseController::class, 'database'])->name("database");

    Route::get("/final", [FinalController::class, 'finish'])->name("final");




});





