<?php

namespace Modules\LiveTV\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Modules\LiveTV\Models\LiveTV;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\LiveTV\Http\Requests\LiveTVRequest;
use App\Trait\ModuleTrait;

class LiveTVsController extends Controller
{
    protected string $exportClass = '\App\Exports\LiveTVExport';

    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
        }

    public function __construct()
    {
        $this->traitInitializeModuleTrait(
            'livetv.title', // module title
            'livetvs', // module name
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

        $export_import = true;
        $export_columns = [
            [
                'value' => 'name',
                'text' => ' Name',
            ]
        ];
        $export_url = route('backend.livetvs.export');

        return view('livetv::backend.livetv.index', compact('module_action', 'filter', 'export_import', 'export_columns', 'export_url'));
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = 'LiveTV'; // Adjust as necessary for dynamic use
        $messageKey = __('LiveTV.Post_status'); // You might want to adjust this based on the action

        return $this->performBulkAction(LiveTV::class, $ids, $actionType, $messageKey, $moduleName);
    }

    public function index_data(Datatables $datatable, Request $request)
    {
        $query = LiveTV::query()->withTrashed();

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
              return view('livetv::backend.livetv.action', compact('data'));
          })
          ->editColumn('status', function ($data) {
              return $data->getStatusLabelAttribute();
          })
          ->editColumn('updated_at', fn($data) => formatUpdatedAt($data->updated_at))
          ->rawColumns(['action', 'status', 'check'])
          ->orderColumns(['id'], '-:column $1')
          ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */

      public function create()
    {
      return view('livetv::backend.livetv.create');
    }

    public function store(LiveTVRequest $request)
    {
        $data = $request->all();
        $livetv = LiveTV::create($data);

        return redirect()->route('backend.livetvs.index', $livetv->id)->with('success', 'Livetv added successfully!');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id 
     * @return Response
     */
    public function edit($id)
    {
        $data = LiveTV::findOrFail($id);
    return view('livetv::backend.livetv.edit', compact('data'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(LiveTVRequest $request, LiveTV $livetv)
    {
        $requestData = $request->all();
        $livetv->update($requestData);

        return redirect()->route('backend.livetvs.index', $livetv->id)->with('success', 'LiveTV updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function destroy($id)
    { 
        
        $data = LiveTV::where('id', $id)->first();
        $data->delete();
        $message = __('Taxes Deleted Successfully');
        return response()->json(['message' =>  $message, 'type' => 'DELETE_FORM']);
    }

    public function restore($id)
    {
        $data = LiveTV::withTrashed()->where('id', $id)->first();
        $data->restore();
        return response()->json(['message' => 'Tax entry restored successfully']);
    }

    public function forceDelete($id)
    {
        $data = LiveTV::withTrashed()->where('id', $id)->first();
        $data->forceDelete();
        return response()->json(['message' => 'Tax entry permanently deleted']);
    }
}
