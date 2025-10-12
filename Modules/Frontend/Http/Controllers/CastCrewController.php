<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\CastCrew\Models\CastCrew;
use Modules\CastCrew\Transformers\CastCrewListResource;
use Modules\Entertainment\Models\Entertainment;
use App\Models\UserSearchHistory;

class CastCrewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('frontend::index');
    }


    public function castcrewList()
    {
        return view('frontend::castCrew');
    }
    public function castCrewDetail(Request $request, $id)
    {
        $castcrew = CastCrew::where('id',$id)->first();

        $responseData = New CastCrewListResource($castcrew);

        $data=$responseData->toArray(request());


        $more_items =Entertainment::with([
            'entertainmentTalentMappings' => function ($query) use ($id) {
                $query->where('talent_id', $id);
            }
        ])->limit(12)->get();


        if($request->has('is_search') && $request->is_search==1){

            $user_id=auth()->user()->id ?? $request->user_id;

                  if($user_id){

                     $currentprofile=GetCurrentprofile($user_id, $request);

                     if($currentprofile){

                        $existingSearch = UserSearchHistory::where('user_id', $user_id)
                        ->where('profile_id', $currentprofile)
                        ->where('search_query', $data['name'])
                        ->first();

                     if (!$existingSearch) {

                         UserSearchHistory::create([
                            'user_id' => $user_id,
                            'profile_id' => $currentprofile,
                            'search_query' => $data['name'],
                            'search_id'=> $data['id'],
                            'type'=>'castcrew',
                           ]);
                         }

                       }

                   }

        }

        return view('frontend::castCrewDetail', compact('data','more_items'));
    }

    public function moviecastcrewList($type,$id)
    {

        $entertainment_id=$id;
        $type=$type;

        return view('frontend::castCrew', compact('entertainment_id','type'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('frontend::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('frontend::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('frontend::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
