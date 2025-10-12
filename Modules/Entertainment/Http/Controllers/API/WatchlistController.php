<?php

namespace Modules\Entertainment\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Entertainment\Models\Watchlist;
use Modules\Entertainment\Transformers\WatchlistResource;
use Modules\Entertainment\Models\ContinueWatch;
use Modules\Entertainment\Transformers\ContinueWatchResource;
use Modules\Entertainment\Models\Entertainment;
use Modules\Video\Models\Video;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class WatchlistController extends Controller
{
    public function watchList(Request $request)
    {
        $user_id = auth()->user()->id;
        $perPage = $request->input('per_page', 10);

        $profile_id=$request->has('profile_id') && $request->profile_id
        ? $request->profile_id
        : getCurrentProfile($user_id, $request);

        $watchList = Watchlist::where('user_id', $user_id)
                    ->where('profile_id', $profile_id)
                    ->whereHas('entertainment', function ($query) {
                        $query->where('status', 1); // Only get active entertainment
                    })
                    ->orderBy('updated_at', 'desc')
                    ->paginate($perPage);

        $responseData = WatchlistResource::collection($watchList);

        if ($request->has('is_ajax') && $request->input('is_ajax') == 1) {
            $html = '';

            foreach($responseData->toArray($request) as $watchData) {
                $userId = auth()->id();
                if ($userId)

                    $isInWatchList = Watchlist::where('entertainment_id', $watchData['entertainment_id'])
                                               ->where('user_id', $userId)
                                               ->exists();

                    $watchData['is_watch_list'] = $isInWatchList;

                    if ($watchData['entertainment_type'] === 'video') {

                        $videoData = Video::find($watchData['entertainment_id']);
                        if ($videoData) {

                            $watchData['name'] = $videoData->name;
                            $watchData['description'] = $videoData->description;
                            $watchData['duration'] = $videoData->duration;
                            $watchData['poster_image'] = setBaseUrlWithFileName( $videoData->poster_url);
                            $watchData['access']=$videoData->access;
                            $watchData['id']=$watchData['entertainment_id'];

                        }
                        $html .= view('frontend::components.card.card_video', ['data' => $watchData])->render();

                    }
                    else{
                        $watchData['id']=$watchData['entertainment_id'];
                        $html .= view('frontend::components.card.card_entertainment', ['value' => $watchData])->render();

                    }
                }

            $hasMore = $watchList->hasMorePages();

            return response()->json([
                'status' => true,
                'html' => $html,
                'message' => __('movie.watch_list'),
                'hasMore' => $hasMore,
            ], 200);
        }

        return response()->json([
            'status' => true,
            'data' => $responseData,
            'message' => __('movie.watch_list'),
        ], 200);
    }


    public function saveWatchList(Request $request)
    {

        $user = auth()->user();
        $entertainmentId = $request->input('entertainment_id');

        $profile_id=$request->has('profile_id') && $request->profile_id
        ? $request->profile_id
        : getCurrentProfile($user->id, $request);

        $watchlistData = $request->except('user_id');

        $watchlistData['profile_id'] = $profile_id;

        $entertainment = Entertainment::find($entertainmentId);

        if (!$entertainment) {
            return response()->json(['status' => false, 'message' => __('movie.entertainment_not_found')]);
        }
        $watchlistData['user_id'] = $user->id;

        $watchlistEntry = Watchlist::updateOrCreate(
            ['entertainment_id' => $entertainmentId, 'user_id' => $user->id, 'profile_id'=>$profile_id],
            $watchlistData
        );

        $cacheKey = $entertainment->type === 'movie'
            ? 'movie_' . $entertainmentId.'_'. $profile_id
            : 'tvshow_' . $entertainmentId.'_'. $profile_id;

        Cache::forget($cacheKey);

        return response()->json(['status' => true, 'message' => __('movie.watchlist_add')]);
    }





    public function deleteWatchList(Request $request)
    {
        try {
            $user = auth()->user();
            
            // Get profile ID
            $profile_id = $request->has('profile_id') && $request->profile_id
                ? $request->profile_id
                : getCurrentProfile($user->id, $request);
    
            // Handle single or multiple IDs
            $ids = $request->is_ajax == 1 ? [$request->id] : explode(',', $request->id);
    
            // Validate if watchlist items exist before deletion
            $watchlistExists = Watchlist::whereIn('entertainment_id', $ids)
                ->where('user_id', $user->id)
                ->where('profile_id', $profile_id)
                ->exists();
    
            if (!$watchlistExists) {
                return response()->json([
                    'status' => false, 
                    'message' => __('movie.watchlist_notfound')
                ], 404);
            }
    
            // Delete watchlist items
            $deleted = Watchlist::whereIn('entertainment_id', $ids)
                ->where('user_id', $user->id)
                ->where('profile_id', $profile_id)
                ->forceDelete();
    
            // Clear cache
            Cache::flush();
    
            return response()->json([
                'status' => true, 
                'message' => __('movie.watchlist_delete')
            ]);
    
        } catch (\Exception $e) {
            \Log::error('Watchlist Delete Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Error removing from watchlist'
            ], 500);
        }
    }

    public function continuewatchList(Request $request)
    {
        $user_id = auth()->user()->id;

        $perPage = $request->input('per_page', 10);
        $continuewatchList = ContinueWatch::query()
         ->whereNotNull('watched_time')
         ->whereNotNull('total_watched_time')
         ->whereHas('entertainment', function ($query) {
             $query->where('status', 1);
         })
         ->with(['entertainment', 'episode', 'video']);

        $profile_id=$request->has('profile_id') && $request->profile_id
        ? $request->profile_id
        : getCurrentProfile($user_id, $request);


        $continuewatch = $continuewatchList->where('user_id', $user_id)->where('profile_id', $profile_id);
        $continuewatch = $continuewatchList->orderBy('updated_at', 'desc');
        $continuewatch = $continuewatch->paginate($perPage);

        $responseData = ContinueWatchResource::collection($continuewatch);

        if ($request->has('is_ajax') && $request->is_ajax == 1) {
            $html = '';
            foreach ($responseData->toArray($request) as $continuewatchData) {
                $userId = auth()->id();
                $html .= view('frontend::components.card.card_continue_watch', ['value' => $continuewatchData])->render();
            }

            $hasMore = $continuewatch->hasMorePages();

            return response()->json([
                'status' => true,
                'html' => $html,
                'message' => __('movie.movie_list'),
                'hasMore' => $hasMore,
            ], 200);
        }
        return response()->json([
            'status' => true,
            'data' => $responseData,
            'message' => __('movie.watch_list'),
        ], 200);
    }

    public function saveContinueWatch(Request $request)
    {
        // dd('hello');
        $user = auth()->user();
        $watch_data = $request->all();

        \Log::info($watch_data);
        $watch_data['total_watched_time'] = isset($watch_data['total_watched_time']) && substr_count($watch_data['total_watched_time'], ':') == 1 ? $watch_data['total_watched_time'] . ':00' : $watch_data['total_watched_time'];
        $watch_data['user_id'] = $user->id;

        $profile_id=$request->has('profile_id') && $request->profile_id
        ? $request->profile_id
        : getCurrentProfile($user->id, $request);

        $watch_data['profile_id'] =  $profile_id;

        $result = ContinueWatch::updateOrCreate(['entertainment_id' => $request->entertainment_id, 'user_id' => $user->id, 'entertainment_type' => $request->entertainment_type,'profile_id'=>$profile_id,'episode_id'=>$request->episode_id], $watch_data);

        Cache::flush();

        return response()->json(['status' => true, 'message' => __('movie.save_msg')]);
    }
    public function deleteContinueWatch(Request $request)
    {
        $continuewatch = ContinueWatch::where('id', $request->id)->first();

        if ($continuewatch == null) {
            $message = __('movie.continuewatch_notfound');

            return response()->json(['status' => false, 'message' => $message]);
        }

        if($request->entertainment_type == 'movie'){
            $cacheKey = 'movie_'.$continuewatch ->entertainment_id;
            Cache::flush();

        }
        else if($request->entertainment_type == 'episode'){
            $cacheKey = 'episode_'.$continuewatch ->entertainment_id;
            Cache::flush();

        }

        $continuewatch->delete();

        $message = __('movie.continuewatch_delete');


        return response()->json(['status' => true, 'message' => $message]);
    }
}
