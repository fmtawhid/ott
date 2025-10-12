<?php

namespace App\Http\Middleware;

use App\Helpers\Classes\Helper;
use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;


class CheckInstallation
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $dbConnectionStatus =dbConnectionStatus();

            if ($dbConnectionStatus && Schema::hasTable('users') && file_exists(storage_path('installed')) ) {

                $activeStorage = DB::table('settings')->where('name', 'disc_type')->value('val') ?? 'local';

                Config::set('filesystems.default', $activeStorage);

                return $next($request);
            } else {

                return redirect()->route('install.index');

            }
        } catch (QueryException $e) {
            if (str_contains($e->getMessage(), 'Access denied for user')) {

                return redirect()->route('install.index');
            }

            throw $e;
        }
    }
}
