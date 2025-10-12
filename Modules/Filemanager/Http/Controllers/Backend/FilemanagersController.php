<?php

namespace Modules\Filemanager\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Controller;
use Modules\Filemanager\Models\Filemanager;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Modules\Filemanager\Http\Requests\FilemanagerRequest;
use App\Trait\ModuleTrait;
use App\Models\Setting;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Support\Facades\Storage;
use App\Jobs\ProcessFileUpload;
use Illuminate\Bus\Batch;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Bus;
use Aws\S3\S3Client;
use Illuminate\Support\Facades\DB;
use Modules\Entertainment\Models\Entertainment;

class FilemanagersController extends Controller
{
    protected string $exportClass = '\App\Exports\FilemanagerExport';

    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
    }

    public function __construct()
    {
        $this->traitInitializeModuleTrait(
            'filemanager.title', // module title
            'media', // module name
            'fa-solid fa-clipboard-list' // module icon
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    // public function index(Request $request)
    // {
    //     $module_action = 'List';
    //     $searchQuery = $request->get('query');
    //     $perPage = 31;
    //     $page = $request->get('page', 1);

    //     $result = getMediaUrls($searchQuery, $perPage, $page);
    //     $mediaUrls = $result['mediaUrls'];
    //     $hasMore = $result['hasMore'];

    //     if ($request->ajax()) {
    //         return response()->json([
    //             'html' => view('filemanager::backend.filemanager.partial', compact('mediaUrls'))->render(),
    //             'hasMore' => $hasMore,
    //         ]);
    //     }

    //     return view('filemanager::backend.filemanager.index', compact('module_action', 'mediaUrls', 'hasMore'));
    // }
    public function index(Request $request)
{
    $module_action = 'List';
    $searchQuery = $request->get('query');
    $perPage = 31;
    $page = $request->get('page', 1);

    // 1️⃣ getMediaUrls থেকে ডাটা
    $result = getMediaUrls($searchQuery, $perPage, $page);
    $mediaUrlsFromFunction = $result['mediaUrls'];
    $hasMoreFromFunction = $result['hasMore'];

    // 2️⃣ Filemanager মডেল থেকে ডাটাবেসে থাকা সব ফাইল
    $mediaFromDBQuery = Filemanager::query();

    if ($searchQuery) {
        $mediaFromDBQuery->where('file_name', 'like', '%'.$searchQuery.'%')
                         ->orWhere('file_url', 'like', '%'.$searchQuery.'%');
    }

    $mediaFromDB = $mediaFromDBQuery->latest()->paginate($perPage, ['*'], 'page', $page);

    $mediaUrls = array_merge(
        $mediaUrlsFromFunction ?? [],
        $mediaFromDB->items() ?? []
    );

    $hasMore = $hasMoreFromFunction || $mediaFromDB->hasMorePages();

    if ($request->ajax()) {
        return response()->json([
            'html' => view('filemanager::backend.filemanager.partial', compact('mediaUrls'))->render(),
            'hasMore' => $hasMore,
        ]);
    }

    return view('filemanager::backend.filemanager.index', compact('module_action', 'mediaUrls', 'hasMore'));
}




    public function getMediaStore(Request $request)
    {
        $page = $request->input('page', 1);
        $perPage = 27; // Number of items per page

        $searchQuery = $request->get('query');
        $result = getMediaUrls($searchQuery, $perPage, $page);


        $mediaUrls = $result['mediaUrls'];
        $hasMore = $result['hasMore'];

        $html = view('filemanager::backend.filemanager.partial', compact('mediaUrls'))->render();

        return response()->json([
            'html' => $html,
            'hasMore' => $hasMore,
        ]);
    }


    public function store(FilemanagerRequest $request)
    {
        $files = Arr::wrap($request->file('file_url'));
        if (empty($files)) {
            return back()->withErrors(['file_url' => 'No files received.']);
        }

        $jobs = [];

        // We'll put temp files here: storage/app/temp
        $targetDir = storage_path('app/temp');
        File::ensureDirectoryExists($targetDir);

        foreach ($files as $file) {
            if (!$file instanceof UploadedFile || !$file->isValid()) {
                return back()->withErrors([
                    'file_url' => $file?->getErrorMessage() ?? 'Upload failed.',
                ]);
            }

            $originalName = $file->getClientOriginalName();
            $ext         = $file->getClientOriginalExtension() ?: 'bin';
            $base        = pathinfo($originalName, PATHINFO_FILENAME);
            $slug        = Str::slug($base, '_') ?: 'file';
            $unique      = $slug.'_'.Str::random(10).'.'.$ext;

            $relativeTempPath = 'temp/'.$unique;                    // what we’ll save in DB
            $absoluteTempPath = $targetDir.DIRECTORY_SEPARATOR.$unique;

            // ----------- Robust move pipeline (Windows-safe) -----------
            try {
                // 1) Preferred: move the uploaded file directly (no Flysystem)
                $file->move($targetDir, $unique);                   // -> storage/app/temp/<unique>
            } catch (\Throwable $e1) {
                try {
                    // 2) Fallback: copy via PHP streams
                    $src = fopen($file->getPathname(), 'rb');
                    if ($src === false) {
                        throw new \RuntimeException('Cannot open upload tmp for reading: '.$file->getPathname());
                    }
                    $dst = fopen($absoluteTempPath, 'wb');
                    if ($dst === false) {
                        throw new \RuntimeException('Cannot open target for writing: '.$absoluteTempPath);
                    }
                    stream_copy_to_stream($src, $dst);
                    fclose($src);
                    fclose($dst);
                } catch (\Throwable $e2) {
                    // 3) Last resort: tell us exactly what failed
                    dd([
                        'move_failed' => true,
                        'tmpPath'     => $file->getPathname(),
                        'absoluteTarget' => $absoluteTempPath,
                        'exception_stage1' => get_class($e1).': '.$e1->getMessage(),
                        'exception_stage2' => get_class($e2).': '.$e2->getMessage(),
                    ]);
                }
            }
            // -----------------------------------------------------------

            $filemanager = \Modules\Filemanager\Models\Filemanager::create([
                'file_url'  => $relativeTempPath,   // e.g. "temp/mini_logo_xxx.png"
                'file_name' => $unique,
            ]);

            $diskType = env('ACTIVE_STORAGE', 'local'); // local|public|s3|dg-ocean
            $jobs[] = new \App\Jobs\ProcessFileUpload($filemanager, $relativeTempPath, $diskType);
        }

        Bus::batch($jobs)->dispatch();

        return redirect()
            ->route('backend.media-library.index')
            ->with('success', trans('filemanager.file_added'));
    }



    public function upload(Request $request)
    {
        $fileChunk    = $request->file('file_chunk');   // UploadedFile
        $fileName     = $request->input('file_name');   // final file name (e.g., "bigvideo.mp4")
        $index        = (int) $request->input('index'); // 0-based index of this chunk
        $totalChunks  = (int) $request->input('total_chunks');

        if (!$fileChunk || !$fileChunk->isValid()) {
            return response()->json(['success' => false, 'error' => 'Chunk missing/invalid'], 422);
        }

        $temporaryDirectory = storage_path('app/temp/uploads/');
        File::ensureDirectoryExists($temporaryDirectory);

        // store each chunk as a distinct part file
        $partPath = $temporaryDirectory . $fileName . '.part' . $index;
        $fileChunk->move($temporaryDirectory, $fileName . '.part' . $index);

        // If this is the last chunk, merge all parts
        if ($index + 1 === $totalChunks) {
            $outputFilePath = $temporaryDirectory . $fileName;
            $outputFile = fopen($outputFilePath, 'wb');

            for ($i = 0; $i < $totalChunks; $i++) {
                $chunkFilePath = $temporaryDirectory . $fileName . '.part' . $i;
                if (!file_exists($chunkFilePath)) {
                    fclose($outputFile);
                    return response()->json([
                        'success' => false,
                        'error' => "Missing chunk: $i"
                    ], 500);
                }
                $chunkFile = fopen($chunkFilePath, 'rb');
                stream_copy_to_stream($chunkFile, $outputFile);
                fclose($chunkFile);
                unlink($chunkFilePath);
            }

            fclose($outputFile);

            // Now you can move $outputFilePath into your normal pipeline, e.g.
            // Storage::disk('local')->putFileAs('temp', new \Illuminate\Http\File($outputFilePath), $fileName);
            // (or dispatch a job similar to store())
        }

        return response()->json(['success' => true]);
    }

    public function destroy(Request $request)
    {

        $url = $request->input('url');

        // $activeDisk = DB::table('settings')->where('name', 'disc_type')->value('val') ?? env('ACTIVE_STORAGE','local');

        $activeDisk = env('ACTIVE_STORAGE');

        $parsedUrl = parse_url($url);
        $path = ltrim($parsedUrl['path'], '/');

        if ($activeDisk === 'local') {
            $path = str_replace('storage/', 'public/', $path);
        }
        $fileName = basename($path);

        if (public_path($path) && Storage::disk($activeDisk)->delete($path)) {

            $filemanager = Filemanager::where('file_name', $fileName)->first();
            if ($filemanager) {
                $filemanager->forceDelete();
            }
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 500);
    }

    public function  SearchMedia(Request $request)
    {

        $query = $request->input('query');
        $mediaUrls = getMediaUrls($query);
        return response()->json(['mediaUrls' => $mediaUrls]);
    }
}
