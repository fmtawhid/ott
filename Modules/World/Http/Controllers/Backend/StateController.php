<?php

namespace Modules\World\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Modules\World\Models\State;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\World\Http\Requests\StateRequest;
use App\Trait\ModuleTrait;
use Modules\World\Models\Country;

class StateController extends Controller
{

    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
        }

    public function __construct()
    {
        $this->traitInitializeModuleTrait(
            'state.title', // module title
            'state', // module name
            'fa-solid fa-clipboard-list' // module icon
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function index(Request $request)
    {
        $filter = [
            'status' => $request->status,
        ];

        $module_action = 'List';


        $countries = Country::select('id', 'name')->get();

        $export_columns = [
            [
                'value' => 'name',
                'text' => ' Name',
            ]
        ];

        return view('world::backend.state.index', compact('module_action', 'filter',  'export_columns'));
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = 'State'; // Adjust as necessary for dynamic use
        $messageKey = __('World.Post_status'); // You might want to adjust this based on the action

        return $this->performBulkAction(State::class, $ids, $actionType, $messageKey, $moduleName);
    }

    public function update_status(Request $request, state $id)
    {
        $id->update(['status' => $request->status]);

        return response()->json(['status' => true, 'message' => __('state.status_update')]);
    }

    public function index_data(Datatables $datatable, Request $request)
    {
        $query = state::query();

        $filter = $request->filter;

        if (isset($filter['name'])) {
            $query->where('name', $filter['name']);
        }

        return $datatable->eloquent($query)
          ->editColumn('name', fn($data) => $data->name)
          ->editColumn('country_id', function ($data) {
            return $data->country->name ?? '-';
        })
          ->addColumn('check', function ($data) {
              return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$data->id.'"  name="datatable_ids[]" value="'.$data->id.'" onclick="dataTableRowCheck('.$data->id.')">';
          })
          ->addColumn('action', function ($data) {
              return view('world::backend.state.action', compact('data'));
          })
          ->editColumn('status', function ($row) {
            $checked = $row->status ? 'checked="checked"' : ''; // Check if the status is true
            $disabled = $row->trashed() ? 'disabled' : ''; // Disable if the record is soft-deleted
        
            return '
                <div class="form-check form-switch">
                    <input type="checkbox" data-url="' . route('backend.state.update_status', $row->id) . '" 
                           data-token="' . csrf_token() . '" class="switch-status-change form-check-input"  
                           id="datatable-row-' . $row->id . '" name="status" value="' . $row->id . '" 
                           ' . $checked . ' ' . $disabled . '>
                </div>
            ';
        })        
          ->editColumn('updated_at', fn($data) => $this->formatUpdatedAt($data->updated_at))
          ->rawColumns(['action', 'status', 'check'])
          ->orderColumns(['id'], '-:column $1')
          ->make(true);
    }

    private function formatUpdatedAt($updatedAt)
      {
          $diff = Carbon::now()->diffInHours($updatedAt);
          return $diff < 25 ? $updatedAt->diffForHumans() : $updatedAt->isoFormat('llll');
      }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */

      public function create()
    {
        $countries = Country::select('id', 'name')->get();
        $module_title = __('state.add_title');
      return view('world::backend.state.create', compact('countries','module_title'));
    }

    public function store(StateRequest $request)
    {
        $data = $request->all();
        $countries = Country::pluck('name')->toArray();
        $state = state::create($data);

        return redirect()->route('backend.state.index', $state->id)->with('success', '$state Added Successfully');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data = state::find($id);
        $countries = Country::select('id', 'name')->get();
        $module_title = __('state.edit_title');
    return view('world::backend.state.edit', compact('data','countries','module_title'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(StateRequest $request, state $state)
    {
        $requestData = $request->all();
        $state->update($requestData);
        return redirect()->route('backend.state.index', $state->id)->with('success', 'State Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = state::find($id);
        $data->delete();
        $message = 'state Deleted Successfully';
        return response()->json(['message' =>  $message, 'type' => 'DELETE_FORM']);
    }
    public function restore($id)
    {
        $data = state::withTrashed()->findOrFail($id);
        $data->restore();
        return response()->json(['message' => 'Tax entry restored successfully']);
    }

    public function forceDelete($id)
    {
        $data = state::withTrashed()->findOrFail($id);
        $data->forceDelete();
        return response()->json(['message' => 'Tax entry permanently deleted']);
    }
}
