<?php

namespace Modules\Tax\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Modules\Tax\Models\Tax;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\Tax\Http\Requests\TaxRequest;
use App\Trait\ModuleTrait;

class TaxesController extends Controller
{
    protected string $exportClass = '\App\Exports\TaxExport';

    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
        }

    public function __construct()
    {
        $this->traitInitializeModuleTrait(
            'tax.title', // module title
            'taxes', // module name
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
        $export_url = route('backend.taxes.export');

        return view('tax::backend.tax.index', compact('module_action', 'filter', 'export_import', 'export_columns', 'export_url'));
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = 'Tax'; // Adjust as necessary for dynamic use
       

        return $this->performBulkAction(Tax::class, $ids, $actionType, $moduleName);
    }

    public function update_status(Request $request, tax $id)
    {
        $id->update(['status' => $request->status]);

        return response()->json(['status' => true, 'message' => __('messages.status_updated_tax')]);
    }

    public function index_data(Datatables $datatable, Request $request)
    {
        $query = Tax::query()->withTrashed();

        $filter = $request->filter;

        if (isset($filter)) {
            if (isset($filter['column_status'])) {
                $query->where('status', $filter['column_status']);
            }
        }

        return $datatable->eloquent($query)
          ->editColumn('name', fn($data) => $data->name)
          ->addColumn('check', function ($data) {
              return '<input type="checkbox" class="form-check-input select-table-row"  id="datatable-row-'.$data->id.'"  name="datatable_ids[]" value="'.$data->id.'" data-type="taxes" onclick="dataTableRowCheck('.$data->id.',this)">';
          })
          ->addColumn('action', function ($data) {
              return view('tax::backend.tax.action', compact('data'));
          })
          ->editColumn('status', function ($row) {
            $checked = $row->status ? 'checked="checked"' : ''; // Check if the status is true
            $disabled = $row->trashed() ? 'disabled' : ''; // Disable if the record is soft-deleted
        
            return '
                <div class="form-check form-switch ">
                    <input type="checkbox" data-url="' . route('backend.taxes.update_status', $row->id) . '" 
                           data-token="' . csrf_token() . '" class="switch-status-change form-check-input"  
                           id="datatable-row-' . $row->id . '" name="status" value="' . $row->id . '" 
                           ' . $checked . ' ' . $disabled . '>
                </div>
            ';
        })        
        ->editColumn('value', function ($row) {
            if ($row->type === 'Fixed') {
                return '$'.$row->value;  
            } else if ($row->type === 'Percentage') {
                return $row->value.'%';  
            }
            return $row->value;  
        })
          ->editColumn('updated_at', fn($data) => formatUpdatedAt($data->updated_at))
          ->filterColumn('value', function ($query, $keyword) {
            $cleanedKeyword = preg_replace('/[^0-9.]/', '', $keyword);

            if ($cleanedKeyword !== '') {
                $query->where(function($query) use ($cleanedKeyword) {
                    $query->whereRaw("CAST(REGEXP_REPLACE(value, '[^0-9.]', '') AS DECIMAL(10, 2)) LIKE ?", ["%{$cleanedKeyword}%"])
                          ->orWhereRaw("CAST(REPLACE(REPLACE(value, '$', ''), '%', '') AS DECIMAL(10, 2)) LIKE ?", ["%{$cleanedKeyword}%"]);
                });
            }
        })
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
      return view('tax::backend.tax.create');
    }

    public function store(TaxRequest $request)
    {
        $data = $request->all();
        $tax = Tax::create($data);
        $message = __('messages.create_form_tax', ['form' => __('tax.title')]);
        return redirect()->route('backend.taxes.index', $tax->id)->with('success', $message);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data = Tax::findOrFail($id);
        return view('tax::backend.tax.edit', compact('data'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(TaxRequest $request, Tax $tax)
    {
        $requestData = $request->all();
        $tax->update($requestData);
        $message = __('messages.update_form_tax', ['form' => __('tax.title')]);
        return redirect()->route('backend.taxes.index', $tax->id)->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function destroy($id)
    {
        $data = Tax::findOrFail($id);
        $data->delete();
        $message = __('messages.delete_form_tax', ['form' => __('tax.title')]);
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function restore($id)
    {
        $data = Tax::withTrashed()->findOrFail($id);
        $data->restore();
        $message = __('messages.restore_form_tax', ['form' => __('tax.title')]);
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function forceDelete($id)
    {
        $data = Tax::withTrashed()->findOrFail($id);
        $data->forceDelete();
        $message = __('messages.permanent_delete_form_tax', ['form' => __('tax.title')]);
        return response()->json(['message' => $message, 'status' => true], 200);
    }
}
