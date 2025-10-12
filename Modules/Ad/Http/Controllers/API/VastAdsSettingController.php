<?php

namespace Modules\Ad\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Ad\Models\VastAdsSetting;
use Modules\Ad\Transformers\VastAdsSettingResource;

class VastAdsSettingController extends Controller
{
    public function vastadsList(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $vastads = VastAdsSetting::where('status',1)->get();
        $responseData = VastAdsSettingResource::collection($vastads);
        dd($responseData);
         return response()->json([
            'status' => true,
            'data' => $responseData,
            'message' => __('messages.vast_ads_list'),
        ], 200);
    }
}