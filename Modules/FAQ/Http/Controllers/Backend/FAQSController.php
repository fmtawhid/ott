<?php

namespace Modules\FAQ\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Modules\FAQ\Models\FAQ;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\FAQ\Http\Requests\FAQRequest;
use App\Trait\ModuleTrait;

class FAQSController extends Controller
{
    protected string $exportClass = '\App\Exports\FAQExport';

    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
    }

    public function __construct()
    {
        $this->traitInitializeModuleTrait(
            'faq.title', // module title
            'faqs', // module name
            'fa-solid fa-clipboard-list' // module icon
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
                'value' => 'question',
                'text' => 'Question',
            ]
        ];
        $export_url = route('backend.faqs.export');

        return view('faq::backend.faq.index', compact('module_action', 'filter', 'export_import', 'export_columns', 'export_url'));
    }

    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = 'FAQ'; // Adjust as necessary for dynamic use
        $messageKey = __('FAQ.Post_status'); // You might want to adjust this based on the action

        return $this->performBulkAction(FAQ::class, $ids, $actionType, $messageKey, $moduleName);
    }

    public function update_status(Request $request, FAQ $id)
    {
        $id->update(['status' => $request->status]);

        return response()->json(['status' => true, 'message' => __('messages.status_updated_faq')]);
    }

    public function index_data(Datatables $datatable, Request $request)
    {
        $query = FAQ::query()->withTrashed();

        $filter = $request->filter;

        if (isset($filter)) {
            if (isset($filter['column_status'])) {
                $query->where('status', $filter['column_status']);
            }
        }

        return $datatable->eloquent($query)
            ->editColumn('question', fn($data) => $data->question)
            ->editColumn('answer', fn($data) => $data->answer)
            ->addColumn('check', function ($data) {
                return '<input type="checkbox" class="form-check-input select-table-row" id="datatable-row-'.$data->id.'" name="datatable_ids[]" value="'.$data->id.'" data-type="faqs" onclick="dataTableRowCheck('.$data->id.',this)">';
            })


            ->addColumn('answer', function ($data) {
                return $data->answer;
            })

            ->addColumn('action', function ($data) {
                return view('faq::backend.faq.action', compact('data'));
            })
            ->editColumn('status', function ($row) {
                $checked = $row->status ? 'checked="checked"' : '';
                $disabled = $row->trashed() ? 'disabled' : ''; // Disable if soft deleted

                return '
                <div class="form-check form-switch ">
                    <input type="checkbox" data-url="'.route('backend.faqs.update_status', $row->id).'" data-token="'.csrf_token().'" class="switch-status-change form-check-input"  id="datatable-row-'.$row->id.'" name="status" value="'.$row->id.'" '.$checked.' '.$disabled.'>
                </div>
                ';
            })
            ->editColumn('updated_at', fn($data) => formatUpdatedAt($data->updated_at))
            ->rawColumns(['answer','action', 'status', 'check'])
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
        $module_title = __('faq.add_title');
         $assets = ['textarea'];
        return view('faq::backend.faq.create',compact('module_title','assets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Modules\FAQ\Http\Requests\FAQRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(FAQRequest $request)
    {
        $data = $request->all();
        $faq = FAQ::create($data);

        $message = __('messages.create_form_faq', ['form' => __('faq.title')]);
        return redirect()->route('backend.faqs.index')->with('success', $message);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $data = FAQ::findOrFail($id);
         $assets = ['textarea'];
        $module_title = __('faq.edit_title');
        return view('faq::backend.faq.edit', compact('data','module_title','assets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Modules\FAQ\Http\Requests\FAQRequest  $request
     * @param  \Modules\FAQ\Models\FAQ  $faq
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FAQRequest $request, FAQ $faq)
    {
        $requestData = $request->all();
        $faq->update($requestData);

        $message = __('messages.update_form_faq', ['form' => __('FAQ.title')]);
        return redirect()->route('backend.faqs.index')->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $data = FAQ::findOrFail($id);
        $data->delete();

        $message = __('messages.delete_form_faq', ['form' => __('FAQ.title')]);
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore($id)
    {
        $data = FAQ::withTrashed()->findOrFail($id);
        $data->restore();

        $message = __('messages.restore_form_faq', ['form' => __('FAQ.title')]);
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    /**
     * Permanently remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function forceDelete($id)
    {
        $data = FAQ::withTrashed()->findOrFail($id);
        $data->forceDelete();

        $message = __('messages.permanent_delete_form_faq', ['form' => __('FAQ.title')]);
        return response()->json(['message' => $message, 'status' => true], 200);
    }
}
