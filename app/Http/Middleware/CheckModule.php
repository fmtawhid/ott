<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckModule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the current route name
        $routeName = $request->route()->getName();

        // Check the status of the module based on the route name
        switch ($routeName) {
            case 'movies': // Adjust this to your actual route name for movies
                if (isenablemodule('movie') == 0) {
                    return abort(404);
                }
                break;
            case 'movie-details': // Adjust this to your actual route name for TV shows
                if (isenablemodule('movie') == 0) {
                    return abort(404);
                }
                break;
            case 'movies.language': // Adjust this to your actual route name for TV shows
                if (isenablemodule('movie') == 0) {
                    return abort(404);
                }
                break;

            case 'movies.genre': // Adjust this to your actual route name for TV shows
                if (isenablemodule('movie') == 0) {
                    return abort(404);
                }
                break;

            case 'comingsoon': // Adjust this to your actual route name for TV shows
                if (isenablemodule('movie') == 0 && isenablemodule('tvshow') == 0) {
                    return abort(404);
                }
                break;

            case 'tv-shows': // Adjust this to your actual route name for TV shows
                if (isenablemodule('tvshow') == 0) {
                    return abort(404);
                }
                break;
            case 'tvshow-details': // Adjust this to your actual route name for TV shows
                if (isenablemodule('tvshow') == 0) {
                    return abort(404);
                }
                break;

            case 'livetv': // Adjust this to your actual route name for Live TV
                if (isenablemodule('livetv') == 0) {
                    return abort(404);
                }
                break;

            case 'videos': // Adjust this to your actual route name for Videos
                if (isenablemodule('video') == 0) {
                    return abort(404);
                }
                break;
            case 'videos': // Adjust this to your actual route name for Videos
                    if (isenablemodule('video') == 0) {
                        return abort(404);
                    }
                    break;

            // Add additional cases as necessary
        }

        return $next($request);
    }
}
