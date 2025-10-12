<?php

namespace Modules\Ad\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Modules\Ad\Models\Ad;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\Ad\Http\Requests\AdRequest;
use App\Trait\ModuleTrait;

class AdsController extends Controller
{
    protected string $exportClass = '\App\Exports\AdExport';

    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
        }

    public function __construct()
    {
        $this->traitInitializeModuleTrait(
            'ad.title', // module title
            'ads', // module name
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
        $export_url = route('backend.ads.export');

        return view('ad::backend.ad.index', compact('module_action', 'filter', 'export_import', 'export_columns', 'export_url'));
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = 'Ad'; // Adjust as necessary for dynamic use
        $messageKey = __('Ad.Post_status'); // You might want to adjust this based on the action

        return $this->performBulkAction(Ad::class, $ids, $actionType, $messageKey, $moduleName);
    }

    public function index_data(Datatables $datatable, Request $request)
    {
        $query = Ad::query()->withTrashed();

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
              return view('ad::backend.ad.action', compact('data'));
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
      return view('ad::backend.ad.create');
    }

    public function store(AdRequest $request)
    {
        $data = $request->all();
        $ad = Ad::create($data);

        return redirect()->route('backend.ads.index', $ad->id)->with('success', '$ad Added Successfully');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data = Ad::findOrFail($id);
    return view('ad::backend.ad.edit', compact('data'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(AdRequest $request, Ad $ad)
    {
        $requestData = $request->all();
        $ad->update($requestData);

        return redirect()->route('backend.ads.index', $ad->id)->with('success', 'Ad Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function destroy($id)
    {
        $data = Ad::findOrFail($id);
        $data->delete();
        $message = __('Taxes Deleted Successfully');
        return response()->json(['message' =>  $message, 'type' => 'DELETE_FORM']);
    }

    public function restore($id)
    {
        $data = Ad::withTrashed()->findOrFail($id);
        $data->restore();
        return response()->json(['message' => 'Tax entry restored successfully']);
    }

    public function forceDelete($id)
    {
        $data = Ad::withTrashed()->findOrFail($id);
        $data->forceDelete();
        return response()->json(['message' => 'Tax entry permanently deleted']);
    }
}
