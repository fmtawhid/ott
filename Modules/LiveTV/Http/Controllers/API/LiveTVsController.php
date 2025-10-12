<?php

namespace Modules\LiveTV\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\LiveTV\Models\LiveTvCategory;
use Modules\LiveTV\Transformers\LiveTvCategoryResource;
use Modules\LiveTV\Models\LiveTvChannel;
use Modules\LiveTV\Transformers\LiveTvCategoryResourceV2;
use Modules\LiveTV\Transformers\LiveTvChannelResource;
use Modules\LiveTV\Transformers\LiveTvChannelDetailsResource;

class LiveTVsController extends Controller
{
    public function liveTvCategoryList(Request $request){

        $perPage = $request->input('per_page', 10);
        $category_list = LiveTvCategory::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $category_list->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%");
            });
        }

        $category_list =$category_list->where('status',1);

        $category = $category_list->orderBy('updated_at', 'desc');
        $category = $category->paginate($perPage);

        $responseData = LiveTvCategoryResource::collection($category);

        return response()->json([
            'status' => true,
            'data' => $responseData,
            'message' => __('livetv.livetv_category_list'),
        ], 200);
    }

    public function liveTvDashboard(Request $request){

        $channelData = LiveTvChannel::with('TvCategory','plan','TvChannelStreamContentMappings')->where('status',1)->orderBy('updated_at', 'desc')->take(6)->get();
        $categoryData = LiveTvCategory::with('tvChannels')->where('status',1)->orderBy('updated_at', 'desc')->get();

        $responseData['slider'] = LiveTvChannelResource::collection($channelData);
        $responseData['category_data'] = LiveTvCategoryResource::collection($categoryData);

        return response()->json([
            'status' => true,
            'data' => $responseData,
            'message' => __('livetv.livetv_dashboard'),
        ], 200);
    }

    public function liveTvDetails(Request $request){

        $channelData = LiveTvChannel::where('id', $request->channel_id)->with('TvCategory','plan','TvChannelStreamContentMappings')->first();

        $responseData = new LiveTvChannelDetailsResource($channelData);

        return response()->json([
            'status' => true,
            'data' => $responseData,
            'message' => __('livetv.livetv_details'),
        ], 200);
    }
    public function channelList(Request $request){
        $channelData = LiveTvChannel::with('TvCategory','plan','TvChannelStreamContentMappings')->where('status',1)->orderBy('updated_at', 'desc');
        if(!empty($request->category_id)){
            $channelData = $channelData->where('category_id',$request->category_id);
        }
        if ($request->has('is_ajax') && $request->is_ajax == 1) {
            $perPage = 14;
            $channel =$channelData->paginate($perPage);
            $html = '';
            $channelList = LiveTvChannelResource::collection($channel);

            foreach ($channelList->toArray($request) as $index => $value) {
                $html .= view('frontend::components.card.card_tvchannel', [
                    'value' => $value,
                ])->render();
            }
            $hasMore =  $channel->hasMorePages();

            return response()->json([
                'status' => true,
                'html' => $html,
                'message' => __('movie.search_list'),
                'hasMore' => $hasMore,
            ], 200);
        }else{
            $channelData=  $channelData->get();
            $responseData['channel'] = LiveTvChannelResource::collection($channelData);
            return response()->json([
                'status' => true,
                 'data' => $responseData,
                'message' => __('livetv.channel_list'),
            ], 200);
        }

    }

    public function liveTvDashboardV2(Request $request){

        $channelData =  LiveTvChannel::get_channel();

        $categoryData = LiveTvCategory::where('status',1)->orderBy('updated_at', 'desc')->get();

        $responseData['slider'] = LiveTvChannelResource::collection($channelData);
    
    
        $responseData['category_data'] = LiveTvCategoryResourceV2::collection($categoryData);

        return response()->json([
            'status' => true,
            'data' => $responseData,
            'message' => __('livetv.livetv_dashboard'),
        ], 200);
    }
}
