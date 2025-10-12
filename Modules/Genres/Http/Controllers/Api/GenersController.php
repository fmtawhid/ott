<?php

namespace Modules\Genres\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Genres\Services\GenreService;
use Modules\Genres\Transformers\GenresResource;
use Illuminate\Support\Facades\Cache;

class GenersController extends Controller
{
    protected $genreService;

    public function __construct(GenreService $genreService)
    {
        $this->genreService = $genreService;
    }

    public function genreList(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $searchTerm = $request->input('search', null);
        $page = $request->input('page', 1);

        $cacheKey = 'genres_' . $page . '_per_' . $perPage . '_search_' . md5($searchTerm);

        $genres = Cache::get($cacheKey);

        if(!$genres) {
            $genres = $this->genreService->getGenresList($perPage, $searchTerm);
            Cache::put($cacheKey, $genres);
        }

        $responseData = GenresResource::collection($genres);

        if ($request->has('is_ajax') && $request->is_ajax == 1) {

            $html = '';
            foreach ($responseData ->toArray($request) as $index => $value) {
                $html .= view('frontend::components.card.card_geners',['genres_list' => $value])->render();
            }
            $hasMore =  $genres->hasMorePages();

            return response()->json([
                'status' => true,
                'html' => $html,
                'message' => __('movie.search_list'),
                'hasMore' => $hasMore,
            ], 200);
        }
        return response()->json([
            'status' => true,
            'data' => $responseData,
            'message' => __('genres.genres_list'),
        ], 200);
    }
}
