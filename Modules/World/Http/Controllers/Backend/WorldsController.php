<?php

namespace Modules\World\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Modules\World\Models\World;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\World\Http\Requests\WorldRequest;
use App\Trait\ModuleTrait;

class WorldsController extends Controller
{
    protected string $exportClass = '\App\Exports\WorldExport';

    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
        }

    public function __construct()
    {
        $this->traitInitializeModuleTrait(
            'world.title', // module title
            'worlds', // module name
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
        $export_url = route('backend.worlds.export');

        return view('world::backend.world.index', compact('module_action', 'filter',  'export_import', 'export_columns', 'export_url'));
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = 'World'; // Adjust as necessary for dynamic use
        $messageKey = __('World.Post_status'); // You might want to adjust this based on the action

        return $this->performBulkAction(World::class, $ids, $actionType, $messageKey, $moduleName);
    }

    public function index_data(Datatables $datatable, Request $request)
    {
        $query = World::query()->withTrashed();

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
              return view('world::backend.world.action', compact('data'));
          })
          ->editColumn('status', function ($data) {
              return $data->getStatusLabelAttribute();
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
      return view('world::backend.world.create');
    }

    public function store(WorldRequest $request)
    {
        $data = $request->all();
        $world = World::create($data);

        return redirect()->route('backend.worlds.index', $world->id)->with('success', '$world Added Successfully');

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $data = World::findOrFail($id);
    return view('world::backend.world.edit', compact('data'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(WorldRequest $request, World $world)
    {
        $requestData = $request->all();
        $world->update($requestData);

        return redirect()->route('backend.worlds.index', $world->id)->with('success', 'World Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */

    public function destroy($id)
    {
        $data = World::findOrFail($id);
        $data->delete();
        $message = __('Taxes Deleted Successfully');
        return response()->json(['message' =>  $message, 'type' => 'DELETE_FORM']);
    }

    public function restore($id)
    {
        $data = World::withTrashed()->findOrFail($id);
        $data->restore();
        return response()->json(['message' => 'Tax entry restored successfully']);
    }

    public function forceDelete($id)
    {
        $data = World::withTrashed()->findOrFail($id);
        $data->forceDelete();
        return response()->json(['message' => 'Tax entry permanently deleted']);
    }
}
