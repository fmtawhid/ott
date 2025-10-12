<?php

namespace Modules\Installer\Http\Controllers\Backend;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Schema;

class WelcomeController extends Controller
{
    /**
     * Display the installer welcome page.
     *
     * @return \Illuminate\Http\Response
     */
    public function welcome()
    {
        $dbConnectionStatus =dbConnectionStatus();

        if($dbConnectionStatus && Schema::hasTable('users') && file_exists(storage_path('installed')) ) {

            abort(404);
        }

        return view('installer::backend.welcome');
    }
}
