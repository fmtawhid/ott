<?php

namespace Modules\World\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Modules\World\Models\Country;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\World\Http\Requests\CountryRequest;
use App\Trait\ModuleTrait;

class CountryController extends Controller
{

    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
        }

    public function __construct()
    {
        $this->traitInitializeModuleTrait(
            'country.title', // module title
            'country', // module name
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


        $export_columns = [
            [
                'value' => 'name',
                'text' => ' Name',
            ]
        ];

        return view('world::backend.country.index', compact('module_action', 'filter', 'export_columns'));
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = 'Country'; // Adjust as necessary for dynamic use
        $messageKey = __('World.Post_status'); // You might want to adjust this based on the action

        return $this->performBulkAction(Country::class, $ids, $actionType, $messageKey, $moduleName);
    }

    public function update_status(Request $request, country $id)
    {
        $id->update(['status' => $request->status]);

        return response()->json(['status' => true, 'message' => __('country.status_update')]);
    }

    public function index_data(Datatables $datatable, Request $request)
    {
        $query = country::query();

        $filter = $request->filter;

        if (isset($filter['name'])) {
            $query->where('name', $filter['name']);
        }

        return $datatable->eloquent($query)
          ->editColumn('name', fn($data) => $data->name)
          ->addColumn('check', function ($data) {
              return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$data->id.'"  name="datatable_ids[]" value="'.$data->id.'" onclick="dataTableRowCheck('.$data->id.')">';
          })
          ->addColumn('action', function ($data) {
              return view('world::backend.country.action', compact('data'));
          })
          ->editColumn('status', function ($row) {
            $checked = $row->status ? 'checked="checked"' : ''; // Check if the status is true
            $disabled = $row->trashed() ? 'disabled' : ''; // Disable if the record is soft-deleted
        
            return '
                <div class="form-check form-switch">
                    <input type="checkbox" data-url="' . route('backend.country.update_status', $row->id) . '" 
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
        $module_title = __('country.add_title');
      return view('world::backend.country.create',compact('module_title'));
    }

    public function store(CountryRequest $request)
    {
        $data = $request->all();
        $country = country::create($data);

        return redirect()->route('backend.country.index', $country->id)->with('success', '$country Added Successfully');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data = country::find($id);
        $module_title = __('country.edit_title');
    return view('world::backend.country.edit', compact('data','module_title'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(CountryRequest $request, country $country)
    {
        $requestData = $request->all();
        $country->update($requestData);
        return redirect()->route('backend.country.index', $country->id)->with('success', 'Country Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $data = country::find($id);
        $data->delete();
        $message = 'country Deleted Successfully';
        return response()->json(['message' =>  $message, 'type' => 'DELETE_FORM']);
    }
    public function restore($id)
    {
        $data = country::withTrashed()->findOrFail($id);
        $data->restore();
        return response()->json(['message' => 'Tax entry restored successfully']);
    }

    public function forceDelete($id)
    {
        $data = country::withTrashed()->findOrFail($id);
        $data->forceDelete();
        return response()->json(['message' => 'Tax entry permanently deleted']);
    }
}
