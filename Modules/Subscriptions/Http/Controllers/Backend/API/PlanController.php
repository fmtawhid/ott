<?php

namespace Modules\Subscriptions\Http\Controllers\Backend\API;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Subscriptions\Http\Requests\PlanRequest;
use Modules\Subscriptions\Models\Plan;
use Modules\Subscriptions\Models\PlanLimitationMapping;
use Modules\Subscriptions\Transformers\PlanResource;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index()
    {
        return $this->sendResponse(PlanResource::collection(Plan::with('planLimitation')->get()), 'Plan List');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Renderable
     */
    public function store(PlanRequest $request)
    {
        $data = $request->all();

        if ($data['duration'] == '') {
            $data['duration'] = 1;
        }

        $data['identifier'] = strtolower($data['name']);

        if ($data['status'] != 1) {
            $data['status'] == 0;
        }

        $plandata = Plan::create($data);

        $plan_id = $plandata['id'];

        $limitation_data = $data['limitation_data'];

        if (count($limitation_data) != 0 && $data['planlimitation'] === 'Limited') {
            foreach ($limitation_data as $item) {
                PlanLimitationMapping::create(['plan_id' => $plan_id,
                    'planlimitation_id' => $item['planlimitation_id'],
                    'limit' => $item['limit'],
                ]);
            }
        }

        return $this->sendResponse(new PlanResource($plandata), 'Plan Created Sucessfully');
    }

    /**
     * Show the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function show(Plan $plan)
    {
        return $this->sendResponse(new PlanResource($plan), 'Plan Detail');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Renderable
     */
    public function update(PlanRequest $request, Plan $plan)
    {
        $data = $request->all();

        if ($data['duration'] == '') {
            $data['duration'] = 1;
        }

        if ($data['status'] != 1) {
            $data['status'] == 0;
        }

        $plan->update($data);

        $limitation_data = $data['limitation_data'];

        PlanLimitationMapping::where('plan_id', $plan['id'])->forceDelete();

        if (count($limitation_data) != 0 && $data['planlimitation'] == 2) {
            if (count($limitation_data) != 0 && $data['planlimitation'] === 'Limited') {
                PlanLimitationMapping::create(['plan_id' => $plan['id'],
                    'planlimitation_id' => $item['planlimitation_id'],
                    'limit' => $item['limit'],
                ]);
            }
        }

        return $this->sendResponse(new PlanResource($plan), 'Plan Updated Sucessfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function destroy(Plan $plan)
    {
        $id = $plan->id;
        $plan->delete();

        return $this->sendResponse($id, 'Plan Deleted Sucessfully');
    }

    public function planList(Request $request){
        
        $perPage = $request->input('per_page', 10);
        $plan_list = Plan::query()->with('planLimitation');

        $plan_list =$plan_list->where('status',1);

        $plan = $plan_list->orderBy('updated_at', 'desc');
        $plan = $plan->paginate($perPage);

        $responseData = PlanResource::collection($plan);
        
        return response()->json([
            'status' => true,
            'data' => $responseData,
            'message' => __('plan.plan_list'),
        ], 200);
    }
}
