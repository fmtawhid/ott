<?php

namespace Modules\Ad\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Ad\Models\VastAdsSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VastAdsController extends Controller
{
    /**
     * Get active VAST ads filtered by content type, content ID, and date range
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function getActiveAds(Request $request)
    {
        try {
            $user = User::with('subscriptionPackage')->find(auth()->id());

            // Check if user has Ads disabled in their subscription plan
            $subscription = $user->subscriptionPackage;
            if ($subscription && isset($subscription['plan_type'])) {
                $planLimitations = json_decode($subscription['plan_type'], true);
                foreach ($planLimitations as $limitation) {
                    if (
                        isset($limitation['limitation_title']) &&
                        strtolower($limitation['limitation_title']) === 'ads' &&
                        isset($limitation['limitation_value']) &&
                        $limitation['limitation_value'] == 0
                    ) {
                        return response()->json([
                            'success' => true,
                            'data' => [],
                            'message' => 'Ads are disabled in your subscription.'
                        ]);
                    }
                }
            }

            $contentId = $request->input('content_id');
            $contentType = $request->input('type'); // movie, tvshow, video, livetv
            $contentVideoType = $request->input('video_type'); // e.g., trailer, full
            $episodeId = $request->input('episode_id'); // Optional, for TV shows

            // Use episode_id as content_id only if type is tvshow
            if ($contentType === 'tvshow') {
                $contentId = $episodeId ?? $request->input('content_id');
            }

            // Skip ads for trailers
            if ($contentVideoType === 'trailer') {
                return response()->json([
                    'success' => true,
                    'data' => [],
                ]);
            }

            $currentDate = Carbon::now()->format('Y-m-d');

            Log::info('VastAds API called', [
                'content_id' => $contentId,
                'content_type' => $contentType,
                'current_date' => $currentDate,
                'request_params' => $request->all()
            ]);

            $query = VastAdsSetting::active();

            // Filter by date range - ads should be active on current date
            $query->where(function ($q) use ($currentDate) {
                $q->where(function ($dateQuery) use ($currentDate) {
                    $dateQuery->whereNotNull('start_date')
                        ->whereNotNull('end_date')
                        ->where('start_date', '<=', $currentDate)
                        ->where('end_date', '>=', $currentDate);
                })->orWhere(function ($dateQuery) use ($currentDate) {
                    $dateQuery->whereNotNull('start_date')
                        ->whereNull('end_date')
                        ->where('start_date', '<=', $currentDate);
                })->orWhere(function ($dateQuery) use ($currentDate) {
                    $dateQuery->whereNull('start_date')
                        ->whereNotNull('end_date')
                        ->where('end_date', '>=', $currentDate);
                })->orWhere(function ($dateQuery) {
                    $dateQuery->whereNull('start_date')
                        ->whereNull('end_date');
                });
            });

            // Filter by content type if provided
            // if ($contentType) {
            //     $query->where('target_type', $contentType);

            //     if ($contentId) {
            //         $query->where(function ($q) use ($contentId) {
            //             $q->whereRaw("JSON_CONTAINS(CAST(target_selection AS JSON), JSON_QUOTE(?))", [$contentId])
            //                 ->orWhereRaw("JSON_CONTAINS(CAST(target_selection AS JSON), ?)", [$contentId]);
            //         });
            //     }
            // }
            if ($contentType) {
                $query->where('target_type', $contentType);
            }
            if ($contentId) {
                $query->where(function ($q) use ($contentId) {
                    $q->where('target_selection', 'like', '%[' . $contentId . ',%')    // Match beginning
                        ->orWhere('target_selection', 'like', '%,' . $contentId . ',%')  // Match middle
                        ->orWhere('target_selection', 'like', '%,' . $contentId . ']%')  // Match end
                        ->orWhere('target_selection', 'like', '%[' . $contentId . ']%'); // Match only value
                });
            }



            $activeAds = $query->orderBy('id', 'asc')->where('status', 1)->get();

            $filteredAds = $activeAds->map(function ($ad) use ($user) {
                $targetType = $ad->target_type; // 'video', 'movie', or 'tvshow'
                $targetIds = json_decode($ad->target_selection, true);

                if (!is_array($targetIds) || empty($targetIds)) {
                    return $ad;
                }

                // If ad target_type is 'tvshow', map it to 'episode' in pay_per_views
                $payPerViewType = $targetType === 'tvshow' ? 'episode' : $targetType;
                // Fetch purchased IDs of same type from pay_per_views
                $purchasedIds = DB::table('pay_per_views')
                    ->where('user_id', $user->id)
                    ->where('type', $payPerViewType)
                    ->whereIn('movie_id', $targetIds)
                    ->pluck('movie_id')
                    ->toArray();
                $contentId = request()->input('content_id');
                $contentType = request()->input('type'); // movie, tvshow, video
                $checkId = null;
                $checkType = null;
                if ($contentType === 'episode' || $contentType === 'tvshow') {
                    $checkId = $contentId;
                    $checkType = 'episode';
                } elseif ($contentType === 'video') {
                    $checkId = $contentId;
                    $checkType = 'video';
                } elseif ($contentType === 'movie') {
                    $checkId = $contentId;
                    $checkType = 'movie';
                }
                if ($checkId && $checkType) {
                    $isPurchased = DB::table('pay_per_views')
                        ->where('user_id', $user->id)
                        ->where('type', $checkType)
                        ->where('movie_id', $checkId)
                        ->exists();
                    if ($isPurchased) {
                        return null; // Skip this ad completely
                    }
                }

                // Remove purchased content from ad target_selection
                $remainingIds = array_values(array_diff($targetIds, $purchasedIds));
                $ad->target_selection = json_encode($remainingIds);

                return $ad;
            })->filter(function ($ad) {
                // Remove null values (ads for purchased content)
                if ($ad === null) {
                    return false;
                }
                // Remove ads where no target left
                $targets = json_decode($ad->target_selection, true);
                return is_array($targets) && count($targets) > 0;
            })->values();

            Log::info('VastAds query result', [
                'content_type' => $contentType,
                'content_id' => $contentId,
                'current_date' => $currentDate,
                'ads_found' => $filteredAds->count(),
                'ads' => $filteredAds->toArray()
            ]);

            return response()->json([
                'success' => true,
                'data' => $filteredAds,
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getActiveAds:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'content_id' => $request->input('content_id'),
                'type' => $request->input('type')
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}