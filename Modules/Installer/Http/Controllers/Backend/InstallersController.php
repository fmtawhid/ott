<?php

namespace Modules\Installer\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Modules\Installer\Models\Installer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\Installer\Http\Requests\InstallerRequest;
use App\Trait\ModuleTrait;

class InstallersController extends Controller
{
    protected string $exportClass = '\App\Exports\InstallerExport';

    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
        }

    public function __construct()
    {
        $this->traitInitializeModuleTrait(
            'installer.title', // module title
            'installers', // module name
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

        $module_action = __('messages.list');

        $export_import = true;
        $export_columns = [
            [
                'value' => 'name',
                'text' => __('messages.name'),
            ]
        ];
        $export_url = route('backend.installers.export');

        return view('installer::backend.installer.index', compact('module_action', 'filter', 'export_import', 'export_columns', 'export_url'));
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = 'Installer'; // Adjust as necessary for dynamic use
        $messageKey = __('Installer.Post_status'); // You might want to adjust this based on the action

        return $this->performBulkAction(Installer::class, $ids, $actionType, $messageKey, $moduleName);
    }

    public function index_data(Datatables $datatable, Request $request)
    {
        $query = Installer::query()->withTrashed();

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
              return view('installer::backend.installer.action', compact('data'));
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
      return view('installer::backend.installer.create');
    }

    public function store(InstallerRequest $request)
    {
        $data = $request->all();
        $installer = Installer::create($data);

        return redirect()->route('backend.installers.index', $installer->id)->with('success', '$installer Added Successfully');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data = Installer::findOrFail($id);
    return view('installer::backend.installer.edit', compact('data'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(InstallerRequest $request, Installer $installer)
    {
        $requestData = $request->all();
        $installer->update($requestData);

        return redirect()->route('backend.installers.index', $installer->id)->with('success', 'Installer Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function destroy($id)
    {
        $data = Installer::findOrFail($id);
        $data->delete();
        $message = __('messages.installer_delete');
        return response()->json(['message' =>  $message, 'type' => 'DELETE_FORM']);
    }

    public function restore($id)
    {
        $data = Installer::withTrashed()->findOrFail($id);
        $data->restore();
        return response()->json(['message' => __('messages.installer_restore')]);
    }

    public function forceDelete($id)
    {
        $data = Installer::withTrashed()->findOrFail($id);
        $data->forceDelete();
        return response()->json(['message' => __('messages.installer_parmently_delete')]);
    }
}
