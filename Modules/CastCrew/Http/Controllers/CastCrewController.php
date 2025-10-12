<?php

namespace Modules\CastCrew\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\CastCrew\Models\CastCrew;
use Modules\CastCrew\Http\Requests\CastCrewRequest;
use Yajra\DataTables\DataTables;
use App\Trait\ModuleTrait;
use AWS\CRT\HTTP\Request as HTTPRequest;
use Modules\CastCrew\Services\CastCrewService;
use App\Services\ChatGTPService;
use Illuminate\Support\Facades\Cache;

class CastCrewController extends Controller
{

    protected string $exportClass = '\App\Exports\CastCrewExport';
    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
        }

    protected $castcrewService;
    protected $chatGTPService;

    public function __construct(ChatGTPService $chatGTPService,CastCrewService $castcrewService)
    {
        $this->castcrewService = $castcrewService;
        $this->chatGTPService = $chatGTPService;


        $this->traitInitializeModuleTrait(
            'castcrew.castcrew_title',
            'castcrew',
            'fa-solid fa-clipboard-list'
        );
    }

        public function index(Request $request)
        {
            $module_action = 'List';
            $type = $request->type;

            switch($type) {

                case 'actor':

                    $module_title = 'castcrew.actors';

                    break;

                case 'director':
                    $module_title = 'castcrew.directors';

                    break;

                default:

                     $module_title = 'castcrew.castcrew_title';

                    break;

            }

            $export_import = true;
            $export_columns = [
                [
                    'value' => 'name',
                    'text' => __('messages.name'),
                ],
                [
                    'value' => 'type',
                    'text' => __('castcrew.lbl_type'),
                ],
                [
                    'value' => 'place_of_birth',
                    'text' => __('castcrew.lbl_birth_place'),
                ],
                [
                    'value' => 'dob',
                    'text' => __('castcrew.lbl_dob'),
                ],
                 [
                    'value' => 'bio',
                    'text' => __('castcrew.lbl_bio'),
                ],

            ];
            $export_url = route('backend.castcrew.export', ['type' => $type]);

            return view('castcrew::backend.castcrew.index', compact('module_action','module_title', 'export_import','export_columns', 'export_url','type'));

        }


    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = 'Cast Crew';
        Cache::flush();

        return $this->performBulkAction(CastCrew::class, $ids, $actionType, $moduleName);
    }

    public function index_data(Datatables $datatable, Request $request)
    {
        $filter = $request->filter;
        $type=$request->type;
        return $this->castcrewService->getDataTable($datatable, $filter, $type);
    }


    public function create(Request $request)
    {
        $type=$request->type;

        switch($type) {

            case 'actor':

                $module_title = 'castcrew.add_actor';

                break;

            case 'director':
                $module_title = 'castcrew.add_director';

                break;

            default:

                 $module_title = 'castcrew.castcrew_title';

                break;

        }


        $mediaUrls =  getMediaUrls();

        return view('castcrew::backend.castcrew.create',compact('type','module_title','mediaUrls'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CastCrewRequest $request)
    {

        $data = $request->all();
        $data['file_url'] = extractFileNameFromUrl($data['file_url']);

        $this->castcrewService->create($data);

         $message = __('messages.create_form_cast', ['form' =>  $data['type'] ]);

         return redirect()->route('backend.castcrew.index', ['type' =>$data['type']])->with('success',$message);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('castcrew::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {
        $cast = $this->castcrewService->getById($id);

        $type=$cast->type;

        switch($type) {

            case 'actor':

                $module_title = 'castcrew.edit_actor';

                break;

            case 'director':
                $module_title = 'castcrew.edit_director';

                break;

            default:

                 $module_title = 'castcrew.castcrew_title';

                break;

        }

        $mediaUrls = getMediaUrls();

        return view('castcrew::backend.castcrew.edit',compact('cast','type','module_title','mediaUrls'));
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['file_url'] = extractFileNameFromUrl($data['file_url']);

        $castcrew = $this->castcrewService->getById($id);

        $this->castcrewService->update($id, $data);

        $message = __('messages.update_form_cast', ['form' => $castcrew['type']]);

        return redirect()->route('backend.castcrew.index', ['type' => $castcrew['type']])->with('success',$message);

    }

    public function destroy($id)
    {
        $castcrew = $this->castcrewService->getById($id);

        $type=$castcrew->type;

        $castcrew->delete();

        $message = __('messages.delete_form_cast', ['form' => $type]);

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function restore($id)
    {
        $castcrew = $this->castcrewService->getById($id);

        $type=$castcrew->type;

        $castcrew->restore();

        $message = __('messages.restore_form_cast',  ['form' => $type]);

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function forceDelete($id)
    {
        $castcrew = $this->castcrewService->getById($id);

        $type=$castcrew->type;

        $castcrew->forcedelete();

        $message = __('messages.permanent_delete_form_cast',  ['form' => $type]);

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function GenerateBio(Request $request){

        $prompt=$request->prompt;

        $result = $this->chatGTPService->GenerateBio($prompt);

             $result =json_decode( $result, true);

             if (isset($result['error'])) {
                 return response()->json([
                     'success' => false,
                     'message' => $result['error']['message'],
                 ], 400);
             }

             return response()->json([

                 'success' => true,
                 'data' => isset($result['choices'][0]['message']['content']) ? $result['choices'][0]['message']['content'] : null,
             ], 200);


    }

}
