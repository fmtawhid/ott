<?php

namespace Modules\Entertainment\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Entertainment\Models\Review;
use Modules\Entertainment\Transformers\ReviewResource;
use Modules\Entertainment\Models\Like;
use Modules\Video\Models\Video;
use Modules\Entertainment\Models\Entertainment;
use Illuminate\Support\Facades\Cache;

class ReviewController extends Controller
{
    public function getRating(Request $request)
    {

        $perPage = $request->input('per_page', 10);

        $reviews = Review::query();

        if ($request->has('entertainment_id')) {
            $reviews = $reviews->where('entertainment_id', $request->entertainment_id);
        }
        if ($request->has('movie_id')) {
            $reviews = $reviews->where('entertainment_id', $request->movie_id);
        }

        if ($request->has('sort') && $request->sort==='top_star') {
             $reviews = $reviews->orderBy('rating', 'desc')
                           ->paginate($perPage);
        }else{
            $reviews = $reviews->orderBy('updated_at', 'desc')->paginate($perPage);
        }

        $review =   ReviewResource::collection($reviews);

        if ($request->has('is_ajax') && $request->is_ajax == 1) {
            $html = '';
            foreach ($review->toArray($request) as $reviewData) {
                $userId = auth()->id();

                $html .= '<li>' . view('frontend::components.card.card_review_list', ['data' => $reviewData])->render() . '</li>';;
            }

            $hasMore = $reviews->hasMorePages();

            return response()->json([
                'status' => true,
                'html' => $html,
                'message' => __('movie.movie_list'),
                'hasMore' => $hasMore,
            ], 200);
        }
        return response()->json([
            'status' => true,
            'data' => $review,
            'message' => __('movie.review_list'),
        ], 200);
    }

    public function saveRating(Request $request)
    {
        $user = auth()->user();
        $rating_data = $request->all();
        $rating_data['user_id'] = $user->id;

        $entertainment = Entertainment::where('id', $request->entertainment_id)->first();

        $result = Review::updateOrCreate(['id' => $request->id], $rating_data);

        Cache::flush();

        $message = __('movie.rating_update');
        if ($result->wasRecentlyCreated) {
            $message = __('movie.rating_add');
        }
        if ($request->has('is_ajax') && $request->is_ajax == 1) {
            $review = Review::with('user')->find($result->id);
            $reviewResource = new ReviewResource($review);
            return response()->json(['status' => true, 'message' => $message,'data'=> $reviewResource ]);
        }
        return response()->json(['status' => true, 'message' => $message]);
    }

    public function update(Request $request)
    {
        $rating = Review::find($request->id);
        $rating->update($request->all());

        return response()->json(['message' => 'Rating updated successfully!','rating'=>$rating]);
    }


    public function deleteRating(Request $request)
    {
        $user = auth()->user();
        $rating = Review::where('id', $request->id)->first();

        if ($rating == null) {

            $message = __('movie.rating_notfound');

            return response()->json(['status' => false, 'message' => $message]);
        }
        $message = __('movie.rating_delete');

        $entertainment_id=$rating->entertainment_id;

        $rating->delete();

        $rating_count=Review::where('entertainment_id',  $entertainment_id)->count();

        Cache::flush();


        return response()->json(['status' => true, 'message' => $message, 'rating_count'=> $rating_count]);
    }

    public function saveLikes(Request $request)
    {
        $user = auth()->user();

        $profile_id=$request->has('profile_id') && $request->profile_id
        ? $request->profile_id
        : getCurrentProfile($user->id, $request);

        $likes_data = $request->all();

        $likes_data['profile_id']= $profile_id;

        $likes_data['user_id'] = $user->id;

        if($request->type == 'video'){
            $entertainment = Video::where('id', $request->entertainment_id)->first();

        }else{
            $entertainment = Entertainment::where('id', $request->entertainment_id)->first();
        }

        $likes = Like::updateOrCreate(
            ['entertainment_id' => $request->entertainment_id, 'user_id' => $user->id],
            $likes_data
        );
        if ($entertainment->type == 'movie') {
            $cacheKey = 'movie_' . $request->entertainment_id.'_'. $profile_id;
            Cache::flush();

        } else if ($entertainment->type == 'tvshow') {
            $cacheKey = 'tvshow_' . $request->entertainment_id.'_'. $profile_id;
            Cache::flush();

            $message = $likes->is_like == 1 ? __('movie.like_msg') : __('movie.unlike_msg');

            return response()->json(['status' => true, 'message' => $message]);
        }


        $message = $likes->is_like == 1 ? __('movie.like_msg') : __('movie.unlike_msg');

        return response()->json(['status' => true, 'message' => $message]);
    }

}
