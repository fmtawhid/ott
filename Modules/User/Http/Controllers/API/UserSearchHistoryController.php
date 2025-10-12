<?php

namespace Modules\User\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserSearchHistory;
use Modules\User\Transformers\UserSearchHistoryResource;
use Illuminate\Http\Request;
class UserSearchHistoryController extends Controller
{
    public function searchHistoryList(Request $request)
    {
        $user_id = !empty($request->user_id)? $request->user_id :auth()->user()->id;

        $perPage = $request->input('per_page', 10);
        $search_data = UserSearchHistory::query();

        if ($request->has('search') && $request->search != '') {

            $profile_id = getCurrentProfile($user_id, $request);

            $search_data->where('user_id', $user_id)
                        ->where('profile_id', $profile_id)
                        ->where('search_query', 'like', "%{$request->search}%")
                        ->distinct('search_query');
        }

        if( $request->has('profile_id') && $request->profile_id !=''){

            $search_data = $search_data->where('profile_id', $request->profile_id);

          }

        $search_data = $search_data->where('user_id', operator: $user_id)->orderBy('id', 'desc')->paginate($perPage);

        $responseData = UserSearchHistoryResource::collection($search_data);

        return response()->json([
            'status' => true,
            'data' => $responseData,
            'message' => __('movie.search_history_list'),
        ], 200);
    }

    public function saveSearchHistory(Request $request)
    {
        $user = auth()->user();
        $data = $request->all();

        $existingSearch = UserSearchHistory::where('user_id', $user->id)
        ->where('profile_id', $data['profile_id'])
        ->where('search_query', $data['search_query'])
        ->first();

       if(!$existingSearch) {

           $search_data  = [
               'user_id' => $user->id,
               'search_query' =>$data['search_query'],
               'profile_id' => $data['profile_id'],
               'search_id'=> $data['search_id'],
               'type'=>$data['type'],

              ];

              UserSearchHistory::create($search_data);

         }


        return response()->json(['status' => true, 'message' => __('movie.search')]);
    }


    public function deleteSearchHistory(Request $request)
    {
        $user = auth()->user();

        $currentprofile=GetCurrentprofile($user->id, $request);

        $profile_id=$request->has('profile_id')?$request->profile_id:  $currentprofile;

        if($request->type == 'clear_all'){
            $search_history = UserSearchHistory::where('user_id', $user->id)
            ->where(column: 'profile_id', operator: $profile_id)->delete();
            $message = __('movie.clear_all');
            return response()->json(['status' => true, 'message' => $message]);
        }

        $search_history = UserSearchHistory::where('user_id', $user->id)
        ->where('id', $request->id)->where('profile_id', $profile_id)->first();

        if ($search_history == null) {

            $message = __('movie.profile');

            return response()->json(['status' => false, 'message' => $message]);
        }
        $search_history->delete();
        $message = __('movie.delete_sucessfully');


        return response()->json(['status' => true, 'message' => $message]);
    }
}
