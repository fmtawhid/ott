<?php

namespace Modules\CastCrew\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\CastCrew\Models\CastCrew;
use Modules\CastCrew\Transformers\CastCrewListResource;
use Modules\Entertainment\Models\EntertainmentTalentMapping;

class CastCrewController extends Controller
{
    public function castCrewList(Request $request){

        $perPage = $request->input('per_page', 10);
        $castcrew_list = CastCrew::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $castcrew_list->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%");
            });
        }

        if($request->has('type')){
            $castcrew_list->where('type', $request->type);
        }

        if($request->has('movie_id') && $request->movie_id !=null){
            $talentIds=EntertainmentTalentMapping::where('entertainment_id',$request->movie_id)->pluck('talent_id');
            $castcrew_list->whereIn('id',$talentIds);
        }
        if($request->has('movie_id') && $request->movie_id =='all'){
            $castcrew_list = CastCrew::query();
        }

        $castcrew = $castcrew_list->orderBy('updated_at', 'desc');
        $castcrew = $castcrew->paginate($perPage);

        $responseData = CastCrewListResource::collection($castcrew);

        if ($request->has('is_ajax') && $request->is_ajax == 1) {
            $html = '';

            foreach ($responseData->toArray($request) as $castcrewData) {
                $html .= view('frontend::components.card.card_castcrew_details', ['data' => $castcrewData])->render();
            }

            $hasMore = $castcrew->hasMorePages();

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
            'message' => __('castcrew.castcrew_list'),
        ], 200);
    }
}
