<?php

namespace Modules\Genres\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Genres\Http\Requests\GenresRequest;
use Modules\Genres\Services\GenreService;
use Yajra\DataTables\DataTables;
use Modules\Genres\Models\Genres;
use App\Trait\ModuleTrait;
use Illuminate\Support\Facades\Cache;

class GenresController extends Controller
{
    protected string $exportClass = '\App\Exports\GenresExport';
    protected $genreService;

    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
    }

    public function __construct(GenreService $genreService)
    {
        $this->genreService = $genreService;
        $this->traitInitializeModuleTrait(
            'genres.title',
            'genres',
            'fa-solid fa-clipboard-list'
        );
    }

    public function index()
    {
        $module_action = 'List';
        $export_import = true;
        $export_columns = [
            [
                'value' => 'name',
                'text' => __('messages.name'),
            ],
            [
                'value' => 'description',
                'text' => __('messages.description'),
            ],
            [
                'value' => 'status',
                'text' => __('plan.lbl_status'),
            ],
        ];
        $export_url = route('backend.genres.export');

        return view('genres::backend.genres.index', compact('module_action', 'export_import', 'export_columns', 'export_url'));
    }


    public function bulk_action(Request $request)
    {
        $ids = explode(',', $request->rowIds);
        $actionType = $request->action_type;
        $moduleName = __('genres.title');
        Cache::flush();
        return $this->performBulkAction(Genres::class, $ids, $actionType, $moduleName);
    }

    public function index_data(Datatables $datatable, Request $request)
    {
        $filter = $request->filter;
        return $this->genreService->getDataTable($datatable, $filter);
    }


    public function update_status(Request $request, $id)
    {
        $this->genreService->updateGenre($id, ['status' => $request->status]);
        return response()->json(['status' => true, 'message' => __('messages.status_updated_genre')]);
    }

    public function create(Request $request)
    {
        $module_title = __('genres.add_title');

        $searchQuery = $request->get('query');
        $perPage = 21;
        $page = $request->get('page', 1);

        $result = getMediaUrls($searchQuery, $perPage, $page);
        $mediaUrls = $result['mediaUrls'];
        $hasMore = [];

        if ($request->ajax()) {
            return response()->json([
                'html' => view('filemanager::backend.filemanager.partial', compact('mediaUrls'))->render(),
                'hasMore' => $hasMore,
            ]);
        }

        return view('genres::backend.genres.create', compact('module_title', 'hasMore'));


       // return view('genres::backend.genres.create', compact('mediaUrls','module_title'));
    }

    public function store(GenresRequest $request)
    {
        $data = $request->all();
        $data['file_url'] = extractFileNameFromUrl($data['file_url']);

        $this->genreService->createGenre($data);
        $message = __('messages.create_form_genre', ['form' => 'Genres']);
        return redirect()->route('backend.genres.index')->with('success', $message);
    }

    public function show($id)
    {
        return view('genres::show');
    }

    public function edit($id)
    {
        $genre = $this->genreService->getGenreById($id);
        $mediaUrls = getMediaUrls();
        $module_title = __('genres.edit_title');
        return view('genres::backend.genres.edit', compact('genre', 'mediaUrls','module_title'));
    }

    public function update(GenresRequest $request, $id)
    {
        $data = $request->all();
        $data['file_url'] = extractFileNameFromUrl($data['file_url']);

        $genre = $this->genreService->getGenreById($id);

        $this->genreService->updateGenre($id, $data);
        $message = __('messages.update_form_genre', ['form' => 'Genres']);
        return redirect()->route('backend.genres.index')->with('success', $message);
    }

    public function destroy($id)
    {
        $this->genreService->deleteGenre($id);
        $message = __('messages.delete_form_genre', ['form' => 'Genres']);
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function restore($id)
    {
        $this->genreService->restoreGenre($id);
        $message = __('messages.restore_form_genre', ['form' => 'Genres']);
        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function forceDelete($id)
    {
        $this->genreService->forceDeleteGenre($id);
        $message = __('messages.permanent_delete_form_genre', ['form' => 'Genres']);
        return response()->json(['message' => $message, 'status' => true], 200);
    }
}
