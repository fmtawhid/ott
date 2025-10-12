<?php

namespace Modules\Ad\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ad\Models\CustomAdsSetting;
use Modules\Ad\Transformers\CustomAdsSettingResource;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CustomAdsSettingController extends Controller
{
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
                        // Ads are disabled for this user
                        return response()->json([
                            'success' => true,
                            'data' => [],
                            'message' => 'Ads are disabled in your subscription.'
                        ]);
                    }
                }
            }

            $contentId = $request->input('content_id');
            $contentType = $request->input('type'); // video, movie, tvshow, channel
            $contentVideoType = $request->input('video_type');
            $currentDate = Carbon::now()->format('Y-m-d');

            Log::info('CustomAds API called', [
                'content_id' => $contentId,
                'content_type' => $contentType,
                'current_date' => $currentDate,
                'request_params' => $request->all()
            ]);

            // Skip ads for trailers
            if ($contentVideoType === 'trailer') {
                return response()->json([
                    'success' => true,
                    'data' => [],
                ]);
            }
            $query = CustomAdsSetting::where('status', 1);

            // Date range filter
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

            // Filter by content type and ID if provided
            // if ($contentType) {
            //     $query->where('target_content_type', $contentType);

            //     if ($contentId) {
            //         $query->where(function ($q) use ($contentId) {
            //             $q->whereRaw("JSON_CONTAINS(target_categories, ?)", [json_encode((int)$contentId)]);
            //         });
            //     }
            // }

            if ($contentType) {
                $query->where('target_content_type', $contentType);

                if ($contentId) {
                    $query->where(function ($q) use ($contentId) {
                        $q->where('target_categories', 'like', '%[' . $contentId . ',%')
                            ->orWhere('target_categories', 'like', '%,' . $contentId . ',%')
                            ->orWhere('target_categories', 'like', '%,' . $contentId . ']%')
                            ->orWhere('target_categories', 'like', '%[' . $contentId . ']%');
                    });
                }
            }


            $activeAds = $query->orderBy('id', 'asc')->get();

            $filteredAds = $activeAds->map(function ($ad) use ($user) {
            $targetType = strtolower($ad->target_content_type ?? '');

            // Always keep ads with target_content_type 'home_page', null, or empty string
            if (in_array($targetType, ['home_page', ''])) {
                return $ad;
            }

            $targetIds = json_decode($ad->target_categories, true);
            if (!is_array($targetIds) || empty($targetIds)) {
                return $ad;
            }

            $payPerViewType = $targetType === 'tvshow' ? 'episode' : $targetType;

            $purchasedIds = DB::table('pay_per_views')
                ->where('user_id', $user->id)
                ->where('type', $payPerViewType)
                ->whereIn('movie_id', $targetIds)
                ->pluck('movie_id')
                ->toArray();

            // Check if the current content is purchased - skip this ad if purchased
            $contentId = request()->input('content_id');
            if ($contentId && in_array((int)$contentId, $purchasedIds)) {
                // If the current content is purchased, skip this ad completely
                return null;
            }

            $remainingIds = array_values(array_diff($targetIds, $purchasedIds));
            $ad->target_categories = json_encode($remainingIds);

            return $ad;
        })->filter(function ($ad) {
            // Remove null values (ads for purchased content)
            if ($ad === null) {
                return false;
            }

            $targetType = strtolower($ad->target_content_type ?? '');

            // Always keep ads with target_content_type 'home_page', null, or ''
            if (in_array($targetType, ['home_page', ''])) {
                return true;
            }

            $targets = json_decode($ad->target_categories, true);
            return is_array($targets) && count($targets) > 0;
        })->values();


            Log::info('CustomAds query result', [
                'content_type' => $contentType,
                'content_id' => $contentId,
                'current_date' => $currentDate,
                'ads_found' => $filteredAds->count(),
                'ads' => $filteredAds->toArray()
            ]);

            return response()->json([
                'success' => true,
                'data' => CustomAdsSettingResource::collection($filteredAds),
            ]);
        } catch (\Exception $e) {
            Log::error('Error in getActiveAds:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'content_id' => $request->input('content_id'),
                'category_id' => $request->input('category_id'),
                'type' => $request->input('type')
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}