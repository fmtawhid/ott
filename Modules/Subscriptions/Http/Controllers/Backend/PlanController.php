<?php

namespace Modules\Subscriptions\Http\Controllers\Backend;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Subscriptions\Http\Requests\PlanRequest;
use Modules\Subscriptions\Models\Plan;
use Modules\Subscriptions\Models\PlanLimitation;
use Modules\Subscriptions\Models\PlanLimitationMapping;
use Yajra\DataTables\DataTables;
use Currency;
use Modules\Constant\Models\Constant;
use App\Trait\ModuleTrait;
use Modules\Setting\Models\Setting;

class PlanController extends Controller
{
    protected string $exportClass = '\App\Exports\PlanExport';
    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
        }
    public function __construct()
    {
        // // Page Title
        // $this->module_title = 'plan.title';

        // // module name
        // $this->module_name = 'plans';

        // // module icon
        // $this->module_icon = 'fa-solid fa-clipboard-list';

        // view()->share([
        //     'module_title' => $this->module_title,
        //     'module_icon' => $this->module_icon,
        //     'module_name' => $this->module_name,
        // ]);
        $this->traitInitializeModuleTrait(
            'plan.title', // module title
            'plans', // module name
            'fa-solid fa-clipboard-list' // module icon
        );
    }

    // public function bulk_action(Request $request)
    // {
    //     $ids = explode(',', $request->rowIds);

    //     $actionType = $request->action_type;

    //     $message = __('messages.bulk_update');

    //     switch ($actionType) {
    //         case 'change-status':
    //             $service_providers = Plan::whereIn('id', $ids)->update(['status' => $request->status]);
    //             $message = __('messages.bulk_plan_update');
    //             break;

    //         case 'delete':
    //             Plan::whereIn('id', $ids)->delete();
    //             $message = __('messages.bulk_plan_delete');
    //             break;

    //         default:
    //             return response()->json(['status' => false, 'message' => __('service_providers.invalid_action')]);
    //             break;
    //     }

    //     return response()->json(['status' => true, 'message' => __('messages.bulk_update')]);
    // }
    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = 'Plan'; // Adjust as necessary for dynamic use

        return $this->performBulkAction(Plan::class, $ids, $actionType, $moduleName);
    }
    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        $module_action = 'List';
        $module_name = 'plans';

        $filter = [
            'status' => $request->status,
        ];

        $plan= Plan::count();

        $minPrice = Plan::min('price');
        $maxPrice = Plan::max('price');

        $export_import = true;
        $export_columns = [
            [
                'value' => 'name',
                'text' => __('messages.name'),
            ],
            [
                'value' => 'duration_value',
                'text' => __('plan.lbl_duration_value'),
            ],
            [
                'value' => 'duration',
                'text' => __('movie.lbl_duration'),
            ],
            [
                'value' => 'price',
                'text' => __('plan.lbl_amount'),
            ],
            [
                'value' => 'level',
                'text' => __('plan.lbl_level'),
            ],
            [
                'value' => 'status',
                'text' => __('plan.lbl_status'),
            ],
        ];
        $export_url = route('backend.plans.export');
        return view('subscriptions::backend.plan.index', compact('module_action', 'module_name' , 'export_import', 'export_columns', 'export_url','filter','plan','minPrice','maxPrice'));
    }

    public function index_data(Datatables $datatable, Request $request)
    {
        $query = Plan::withTrashed();

        $filter = $request->filter;

        if (isset($filter)) {
            if (isset($filter['column_status'])) {
                $query->where('status', $filter['column_status']);
            }

            if (isset($filter['name'])) {
                $namePattern = '%' . $filter['name'] . '%';
               $query->where('name', 'like', $namePattern);
            }

            if (isset($filter['price'])) {

                $priceRange = explode(' - ', $filter['price']);

                if (count($priceRange) == 2) {
                    $minPrice = (float) $priceRange[0];
                    $maxPrice = (float) $priceRange[1];

                    $query->whereBetween('price', [$minPrice, $maxPrice]);
                }
            }
            if (isset($filter['level'])) {
                $query->where('level', $filter['level']);
            }

            
        }



        $datatable = $datatable->eloquent($query)
            ->addColumn('check', function ($row) {
                return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$row->id.'"  name="datatable_ids[]" value="'.$row->id.'" data-type="plan" onclick="dataTableRowCheck('.$row->id.', this)">';
            })
            ->addColumn('action', function ($data) {
                return view('subscriptions::backend.plan.action_column', compact('data'));
            })

            ->editColumn('price', function ($data) {
                return Currency::format($data->price);
            })
            ->editColumn('discount_percentage', function ($data) {
                if (is_null($data->discount_percentage)) {
                    return '-'; 
                }           
                return intval($data->discount_percentage) . '%';
            })
            
            ->editColumn('total_price', function ($data) {
                return Currency::format($data->total_price);
            })


            ->editColumn('level', function ($data) {
                return __("plan.lbl_level").' '.$data->level;
            })


            ->editColumn('duration', function ($data) {
                return $data->duration_value.' '.$data->duration;
            })


            ->editColumn('status', function ($row) {
                $checked = $row->status ? 'checked="checked"' : ''; // Set checked status based on the row's status
                $disabled = $row->trashed() ? 'disabled' : ''; // Disable if the record is soft-deleted
            
                return '
                    <div class="form-check form-switch ">
                        <input type="checkbox" data-url="' . route('backend.plans.update_status', $row->id) . '" 
                               data-token="' . csrf_token() . '" class="switch-status-change form-check-input"  
                               id="datatable-row-' . $row->id . '" name="status" value="' . $row->id . '" 
                               ' . $checked . ' ' . $disabled . '>
                    </div>
                ';
            })            
            ->editColumn('updated_at', function ($data) {
                $diff = Carbon::now()->diffInHours($data->updated_at);

                if ($diff < 25) {
                    return $data->updated_at->diffForHumans();
                } else {
                    return $data->updated_at->isoFormat('llll');
                }
            })
            ->filterColumn('duration', function($query, $keyword) {
                $cleanedKeyword = trim($keyword);
            
                $query->whereRaw("LOWER(CONCAT(duration_value, ' ', duration)) LIKE ?", ["%" . strtolower($cleanedKeyword) . "%"]);
            })

            ->filterColumn('price', function($query, $keyword) {
                $cleanedKeyword = preg_replace('/[^0-9.]/', '', $keyword);
        
                if ($cleanedKeyword !== '') {
                    $query->whereRaw("CAST(REGEXP_REPLACE(price, '[^0-9.]', '') AS DECIMAL(10, 2)) LIKE ?", ["%{$cleanedKeyword}%"]);
                }
            }) 
                     
            
            ->orderColumns(['id'], '-:column $1');

        return $datatable->rawColumns(array_merge(['action','name', 'type', 'duration', 'amount','discount_percentage','total_price', 'planlimitation', 'status', 'check']))
            ->toJson();
    }

    public function index_list(Request $request)
    {
        $term = trim($request->q);

        $query_data = PlanLimitation::where('status', 1)
            ->where(function ($q) {
                if (! empty($term)) {
                    $q->orWhere('name', 'LIKE', "%$term%");
                }
            })->get();

        $data = [];

        foreach ($query_data as $row) {
            $data[] = [
                'id' => $row->id,
                'name' => $row->name,
                'limit' => $row->limit,
            ];
        }

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Renderable
     */


     public function create()
     {
        $planLimits=PlanLimitation::where('status',1)->get();

        $downloadoptions=Constant::where('type','video_quality')->get();

        $purchaseMethodEnabled  = Setting::where('name', 'iap_payment_method')->value('val') == 1;

        $assets = ['textarea'];

        $module_title = __('plan.lbl_add_new_plan');

       return view('subscriptions::backend.plan.form',compact('planLimits','downloadoptions','module_title','assets','purchaseMethodEnabled'));
     }


    public function store(PlanRequest $request)
    {
        $data = $request->all();
        $data['identifier'] = strtolower(str_replace(' ', '_', $data['name']));

        $plan_level=Plan::max('level');

        if($plan_level){

            $data['level']=$plan_level+1;

        }else{

            $data['level']=1;

        }
        if (isset($data['discount']) && $data['discount'] == 1 && isset($data['discount_percentage']) && isset($data['price'])) {
            $discountPercentage = floatval($data['discount_percentage']);
            $price = floatval($data['price']);
    
            $discountValue = ($discountPercentage / 100) * $price;
            $data['total_price'] = $price - $discountValue;
        } else {
            $data['discount_percentage'] = 0;
            $data['total_price'] = floatval($data['price']);
        }


        $plandata = Plan::create($data);

        if ($request->has('limits') && !empty($request->limits)) {
            foreach ($request->input('limits') as $limit) {
                $additionalLimit = null;
                
                if ($limit['limitation_slug'] == 'supported-device-type') {
                    // Prepare the device types data
                    $deviceTypes = $request->input('supported_device_types', []);
                    $limitationValue = '1';
                    $additionalLimit = json_encode($deviceTypes);
                } elseif ($limit['limitation_slug'] == 'download-status') {
                    // Convert download options to integers
                    $downloadOptions = array_map('intval', $request->input('download_options', []));
                    $additionalLimit = json_encode($downloadOptions);
                } elseif ($limit['limitation_slug'] == 'device-limit') {
                    $additionalLimit = $request->input('device_limit_value');
                } elseif ($limit['limitation_slug'] == 'profile-limit') {
                    $additionalLimit = $request->input('profile_limit_value');
                }        
        
                PlanLimitationMapping::create([
                    'plan_id' => $plandata->id,
                    'planlimitation_id' => $limit['planlimitation_id'],
                    'limitation_slug' => $limit['limitation_slug'],
                    'limitation_value' => $limit['value'],
                    'limit' => $additionalLimit,
                ]);
            }
        }

        $message = __('messages.create_form_plansdetail', ['form' => __('plan.singular_title')]);

        return redirect()->route('backend.plans.index')->with('success', $message);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = Plan::findOrFail($id);
        $purchaseMethodEnabled = Setting::where('name', 'iap_payment_method')->value('val') == 1;
        $plan= Plan::max('level');

        $assets = ['textarea'];

        $plan=$plan;

        $planLimits = PlanLimitationMapping::where('plan_id', $id)->get();

        // $planLimits=PlanLimitation::where('status',1)->get();
        $limits = [];
        foreach ($planLimits as $mapping) {
            $limits[$mapping->limitation_slug] = json_decode($mapping->limit, true);
        }
        $downloadoptions=Constant::where('type','video_quality')->get();
        $discount = $data->discount;
        $discount_percentage = $data->discount_percentage;
        $total_price = $data->total_price;
        $module_title = __('plan.lbl_edit_plan');

        return view('subscriptions::backend.plan.edit_form',compact('plan','data','planLimits','downloadoptions','discount','discount_percentage','total_price','module_title','assets','limits','purchaseMethodEnabled'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Renderable
     */
    public function update(PlanRequest $request, $id)
    {

        $request_data = $request->all();

        $data = Plan::where('id', $id)->first();

        $level=$data->level;

          $data->update($request_data);

          if (isset($request_data['discount']) && $request_data['discount'] == 1 && isset($request_data['discount_percentage']) && isset($request_data['price'])) {
            $discountPercentage = floatval($request_data['discount_percentage']);
            $price = floatval($request_data['price']);
            $discountValue = ($discountPercentage / 100) * $price;
            $data->total_price = $price - $discountValue;
        } else {
            $data->total_price = floatval($request_data['price']);
        }
        if ($level < $request_data['level']) {

            $plansToUpdate = Plan::where('level', '>',$level)->where('id','!=',$id)->get();

            foreach ($plansToUpdate as $plan) {
                $plan->update(['level' => $plan->level + 1]);
            }
        }


        if($level > $request_data['level']){

            $plansToUpdate = Plan::where('level', '<',$level)->where('id','!=',$id)->get();

            foreach ($plansToUpdate as $plan) {
                $plan->update(['level' => $plan->level + 1]);
            }

        }

         if ($request->has('limits') && !empty($request->limits)) {
            foreach ($request->input('limits') as $limit) {
                $additionalLimit = null;

                if ($limit['limitation_slug'] === 'supported-device-type') {
                    $deviceTypes = $request->input('supported_device_types', []);
                    $additionalLimit = json_encode($deviceTypes);
                } elseif ($limit['limitation_slug'] === 'download-status') {
                    $downloadOptions = array_map('intval', $request->input('download_options', []));
                    $additionalLimit = json_encode($downloadOptions);
                } elseif ($limit['limitation_slug'] === 'device-limit') {
                    $additionalLimit = $request->input('device_limit_value');
                } elseif ($limit['limitation_slug'] == 'profile-limit') {
                    $additionalLimit = $request->input('profile_limit_value');
                }   

                PlanLimitationMapping::updateOrCreate(
                    [
                        'plan_id' => $id,
                        'planlimitation_id' => $limit['planlimitation_id'],
                        'limitation_slug' => $limit['limitation_slug']
                    ],
                    [
                        'limitation_value' => $limit['value'],
                        'limit' => $additionalLimit,
                    ]
                );
            }
        }

        $message = __('messages.update_form_plansdetail', ['form' => __('plan.singular_title')]);

        return redirect()->route('backend.plans.index')->with('success', $message );


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Renderable
     */

    
    public function destroy($id)
    {
        $data = Plan::findOrFail($id);
        $data->delete();
        $message = trans('messages.delete_form_plansdetail', ['form' => 'plan']);
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function restore($id)
    {
        $data = Plan::withTrashed()->findOrFail($id);
        $data->restore();
        $message = trans('messages.restore_form_plansdetail', ['form' => 'plan']);
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function forceDelete($id)
    {
        $data = Plan::withTrashed()->findOrFail($id);
        $data->forceDelete();
        $message = trans('messages.permanent_delete_form_plansdetail', ['form' => 'plan']);
        return response()->json(['message' => $message, 'status' => true], 200);
    }


    public function update_status(Request $request, Plan $id)
    {
        $id->update(['status' => $request->status]);

        return response()->json(['status' => true, 'message' => __('messages.status_updated_plansdetail')]);
    }
}
