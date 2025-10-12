<?php

namespace App\Http\Middleware;

use Closure;

class JsonResponseMiddleware
{
    public function handle($request, Closure $next)
    {
        // Get the response from the next middleware in the pipeline
        $response = $next($request);

        // Check if the response is a JSON response
        if ($response->headers->get('Content-Type') === 'application/json') {
            // Decode the JSON content
            $data = json_decode($response->getContent(), true);

            // Re-encode the JSON content with JSON_NUMERIC_CHECK option
            $jsonResponse = json_encode($data, JSON_NUMERIC_CHECK);

            // Set the modified JSON content back to the response
            $response->setContent($jsonResponse);
        }

        return $response;
    }
}
