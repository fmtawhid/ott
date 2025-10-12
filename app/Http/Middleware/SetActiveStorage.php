<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SetActiveStorage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Schema::hasTable('settings')){
            $activeStorage = DB::table('settings')->where('name', 'disc_type')->value('val') ?? 'local';

            Config::set('filesystems.default', $activeStorage);

        }
        return $next($request);

    }
}
