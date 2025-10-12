<?php

namespace Modules\Subscriptions\Http\Controllers\Backend;
use App\Authorizable;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Subscriptions\Http\Requests\PlanLimitationRequest;
use Modules\Subscriptions\Models\PlanLimitation;
use Yajra\DataTables\DataTables;
use App\Trait\ModuleTrait;


class PlanLimitationController extends Controller
{
    protected string $exportClass = '\App\Exports\PlanLimitationExport';
    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
        }

    public function __construct()
    {
        $this->traitInitializeModuleTrait(
            'plan_limitation.title', // module title
            'planlimitation', // module name
            'fa-solid fa-clipboard-list' // module icon
        );
    }
   

    /**
     * Display a listing of the resource.
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        $filter = [
            'status' => $request->status,
        ];
        $module_action = 'List';

        $export_import = true;
        $export_columns = [
            [
                'value' => 'title',
                'text' => __('plan_limitation.lbl_title'),
            ],
            [
                'value' => 'description',
                'text' => __('plan.lbl_description'),
            ],
            [
                'value' => 'status',
                'text' => __('plan.lbl_status'),
            ],
        ];
        $export_url = route('backend.planlimitation.export');

        return view('subscriptions::backend.planlimitation.index', compact('module_action', 'export_import', 'export_columns', 'export_url','filter'));
        // return view('subscriptions::backend.planlimitation.index', compact('module_action', 'columns'));
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = 'Plan Limitation'; // Adjust as necessary for dynamic use

        return $this->performBulkAction(PlanLimitation::class, $ids, $actionType, $moduleName);
    }
    public function index_data(Datatables $datatable, Request $request)
    {
        $module_name = 'planlimitation';
        $query = PlanLimitation::withTrashed();
        // $query->orderBy('created_at', 'desc');

        $filter = $request->filter;

        if (isset($filter)) {
            if (isset($filter['column_status'])) {
                $query->where('status', $filter['column_status']);
            }
        }

        $datatable = $datatable->eloquent($query)
            ->addColumn('check', function ($row) {
                return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$row->id.'"  name="datatable_ids[]" value="'.$row->id.'" data-type="plan-limitation" onclick="dataTableRowCheck('.$row->id.', this)">';
            })
            ->addColumn('action', function ($data) {
                return view('subscriptions::backend.planlimitation.action_column', compact('data'));
            })
            ->editColumn('status', function ($row) {
                $checked = $row->status ? 'checked="checked"' : ''; // Set checked status based on the row's status
                $disabled = $row->trashed() ? 'disabled' : ''; // Disable if the record is soft-deleted
            
                return '
                    <div class="form-check form-switch ">
                        <input type="checkbox" data-url="' . route('backend.planlimitation.update_status', $row->id) . '" 
                               data-token="' . csrf_token() . '" class="switch-status-change form-check-input"  
                               id="datatable-row-' . $row->id . '" name="status" value="' . $row->id . '" 
                               ' . $checked . ' ' . $disabled . '>
                    </div>
                ';
            })            
            ->editColumn('updated_at', function ($data) {
                $module_name = 'planlimitation';

                $diff = Carbon::now()->diffInHours($data->updated_at);

                if ($diff < 25) {
                    return $data->updated_at->diffForHumans();
                } else {
                    return $data->updated_at->isoFormat('llll');
                }
            })
            ->orderColumn('title', function ($query, $order) {
                $query->orderBy('title', $order);
            })
            ->orderColumns(['id'], '-:column $1');

        return $datatable->rawColumns(array_merge(['action', 'status', 'check','title']))
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Renderable
     */
    public function store(PlanLimitationRequest $request)
    {
        $data= $request->all();

        $data['slug']=Str::slug($data['title']);

        $data = PlanLimitation::create($data);

        $message = __('messages.create_form_plan', ['form' => __('plan_limitation.title')]);

        return redirect()->route('backend.planlimitation.index')->with('success', $message );


    }

    public function create()
    {
        $module_title = __('plan_limitation.add_planlimit_title');
      return view('subscriptions::backend.planlimitation.form',compact('module_title'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = PlanLimitation::findOrFail($id);
        $module_title = __('plan_limitation.edit_planlimit_title');
        return view('subscriptions::backend.planlimitation.edit_form',compact('data','module_title'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Renderable
     */
    public function update(PlanLimitationRequest $request, $id)
    {
        $data = PlanLimitation::findOrFail($id);

        $data->update($request->all());

        $message = __('messages.update_form_plan', ['form' => __('plan_limitation.title')]);

        return redirect()->route('backend.planlimitation.index')->with('success', $message );

      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Renderable
     */

    public function destroy($id)
    {
        $data = PlanLimitation::findOrFail($id);
        $data->delete();
        $message = trans('messages.delete_form_plan', ['form' => 'plan_limitation.title']);
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function restore($id)
    {
        $data = PlanLimitation::withTrashed()->where('id',$id)->first();
        $data->restore();
        $message = trans('messages.restore_form_plan', ['form' => 'plan_limitation.title']);
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function forceDelete($id)
    {
        $data = PlanLimitation::withTrashed()->where('id',$id)->first();
        $data->forceDelete();
        $message = trans('messages.permanent_delete_form_plan', ['form' => 'plan_limitation.title']);
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function update_status(Request $request, PlanLimitation $id)
    {
        $id->update(['status' => $request->status]);

        return response()->json(['status' => true, 'message' => __('messages.status_updated_plan')]);
    }
}
