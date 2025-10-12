<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Trait\ModuleTrait;
use App\Models\MobileSetting;
use App\Http\Requests\MobileSettingRequest;
use App\Http\Requests\MobileAddSettingRequest;
use Modules\Entertainment\Models\Entertainment;
use Modules\Entertainment\Models\EntertainmentView;
use Illuminate\Support\Facades\DB;
use Modules\Constant\Models\Constant;
use Modules\LiveTV\Models\LiveTvChannel;
use Modules\CastCrew\Models\CastCrew;
use Modules\Genres\Models\Genres;
use Illuminate\Support\Str;
use Modules\LiveTV\Models\LiveTvCategory;
use Modules\Video\Models\Video;
use Illuminate\Support\Facades\Cache;

class MobileSettingController extends Controller
{
    use ModuleTrait {
        initializeModuleTrait as private traitInitializeModuleTrait;
    }

    public function __construct()
    {
        // Page Title
        $this->module_title = 'settings.mobile_setting';

        // module name
        $this->module_name = 'mobile-setting';

        $this->module_icon = 'fas fa-cogs';

        $this->traitInitializeModuleTrait(
            'settings.mobile_setting', // module title
            'mobile-setting', // module name
            'fas fa-cogs' // module icon
        );
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $module_action = 'List';

        $data = MobileSetting::orderBy('position', 'asc');

        $typeValue = MobileSetting::where('slug', '!=', 'banner')->where('slug', '!=', 'continue-watching');

        if (isenablemodule('movie') == 0) {
            $movie_slugs = ['latest-movies', 'top-10', 'popular-movies', 'free-movies'];
            $typeValue->whereNotIn('slug', $movie_slugs);
            $data->whereNotIn('slug', $movie_slugs);
        }
        if (isenablemodule('livetv') == 0) {

            $livetv_slug = ['top-channels'];
            $typeValue->whereNotIn('slug', $livetv_slug);
            $data->whereNotIn('slug', $livetv_slug);
        }

        $data = $data->get();
        $typeValue = $typeValue->get();

        return view('backend.mobile-setting.index', compact('module_action', 'data', 'typeValue'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MobileSettingRequest $request)
    {

        $data = $request->all();

        if($request->has('dashboard_select')){

            $data['value']=$data['dashboard_select'];

        }

        if (!empty($data) && isset($data['value']) && !empty($data['value'])) {
            
            $data['value'] = is_array($data['value']) ? json_encode($data['value']) : $data['value'];
        }else{

            $data['value'] =null;
        }
        
        $result = MobileSetting::updateOrCreate(['id' => $request->id], $data);

        if ($result->wasRecentlyCreated) {

            $result['slug'] = strtolower(Str::slug($result->name, '-'));

            $result->save();

            if (in_array($result->slug, ['banner', 'continue-watching', 'advertisement', 'rate-our-app'])) {

                $result->value = 1;

                $result->save();
            }

            $message = __('messages.create_form_mobile', ['form' => __($this->module_title)]);
        } else {
            $message = __('messages.update_form_mobile', ['form' => __($this->module_title)]);
        }

        Cache::flush();
        if ($request->ajax()) {

            return response()->json(['success' => true, 'message' => $message]);
        }

        return redirect()->route('backend.mobile-setting.index')->with('success', $message);
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = MobileSetting::where('id', $id)->first();
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = MobileSetting::where('id', $id)->first();

        Cache::flush();

        $data->delete();
        $message = trans('messages.delete_form_mobile', ['form' => __($this->module_title)]);

        return response()->json(['message' => $message, 'status' => true], 200);
    }

    public function getDropdownValue(string $id)
    {
        $data = MobileSetting::where('id', $id)->first();
        $slug = $data->slug;

        $selectedIds = json_decode($data->value, true);

        $selected_values = null;

        $value = null;
        switch ($slug) {
            case 'top-10':
                $topEntertainmentIds = EntertainmentView::groupBy('entertainment_id')
                    ->select('entertainment_id', DB::raw('count(*) as total'))
                    ->orderBy('total', 'desc')
                    ->take(10)
                    ->pluck('entertainment_id');
                $value = Entertainment::whereIn('id', $topEntertainmentIds)->released()->where('status',1)->get();

                if (!empty($selectedIds)) {
                    $selected_values = Entertainment::whereIn('id', $selectedIds)->get();
                }
                break;
            case 'latest-movies':
                  $value = Entertainment::where('type', 'movie')
                             ->released()
                             ->orderBy('release_date', 'desc')
                             ->take(10)
                             ->get();
                if (!empty($selectedIds)) {
                    $selected_values = Entertainment::whereIn('id', $selectedIds)->released()->where('status',1)->get();
                }
                break;
            case 'enjoy-in-your-native-tongue':
                $value = Constant::where('type', 'movie_language')->get();

                if (!empty($selectedIds)) {
                    $selected_values = Constant::whereIn('id', $selectedIds)->get();
                }
                break;
            case 'popular-movies':
                $value = Entertainment::where('type', 'movie')->released()->where('IMDb_rating', '>', 5)->orderBy('IMDb_rating', 'desc')->take(10)->get();

                if (!empty($selectedIds)) {
                    $selected_values = Entertainment::whereIn('id', $selectedIds)->released()->where('status',1)->get();
                }
                break;
            case 'popular-tvshows':
                $value = Entertainment::where('type', 'tvshow')->where('IMDb_rating', '>', 5)->orderBy('IMDb_rating', 'desc')->take(20)->get();

                if (!empty($selectedIds)) {
                    $selected_values = Entertainment::whereIn('id', $selectedIds)->released()->where('status',1)->get();
                }
                break;
            // case 'popular-tvcategories':
            //     $value = LiveTvCategory::take(10)->get();

            //     if (!empty($selectedIds)) {
            //         $selected_values = LiveTvCategory::whereIn('id', $selectedIds)->get();
            //     }
            //     break;
            case 'popular-videos':
                $value = Video::all();

                if (!empty($selectedIds)) {
                    $selected_values = Video::whereIn('id', $selectedIds)->whereDate('release_date', '<=', now())->where('status',1)->get();
                }
                break;
            case 'top-channels':
                $value = LiveTvChannel::take(10)->get();

                if (!empty($selectedIds)) {
                    $selected_values = LiveTvChannel::whereIn('id', $selectedIds)->where('status',1)->get();
                }
                break;
            case 'your-favorite-personality':
                $value = CastCrew::where('type', 'actor')->take(10)->get();

                if (!empty($selectedIds)) {
                    $selected_values = CastCrew::whereIn('id', $selectedIds)->get();
                }
                break;
            case '500-free-movies':
                $value = Entertainment::where('type', 'movie')->where('movie_access', 'free')->take(10)->get();

                if (!empty($selectedIds)) {
                    $selected_values = Entertainment::whereIn('id', $selectedIds)->where('status',1)->get();
                }
                break;
            case 'genre':
                $value = Genres::take(10)->get();

                if (!empty($selectedIds)) {
                    $selected_values = Genres::whereIn('id', $selectedIds)->get();
                }
                break;
        }

        if ($value && !empty($selectedIds)) {
            $value = $value->reject(function ($item) use ($selectedIds) {
                return in_array($item->id, $selectedIds);
            });
        }

        return response()->json(['selected' => $selected_values, 'available' => $value]);
    }

    public function updatePosition(Request $request)
    {
        $sortedIDs = $request->input('sortedIDs');

        foreach ($sortedIDs as $index => $id) {
            $mobileSetting = MobileSetting::find($id);
            $mobileSetting->position = $index + 1;
            $mobileSetting->save();
        }

        return response()->json(['success' => true]);
    }

    public function getTypeValue($slug)
    {

        $value = null;
        switch ($slug) {
            case 'top-10':
                $topEntertainmentIds = EntertainmentView::groupBy('entertainment_id')
                    ->select('entertainment_id', DB::raw('count(*) as total'))
                    ->orderBy('total', 'desc')
                    ->take(10)
                    ->pluck('entertainment_id');
                $value = Entertainment::whereIn('id', $topEntertainmentIds)->released()->where('status',1)->get();

                break;
            case 'latest-movies':
                $value = Entertainment::where('type', 'movie')
                    ->released()
                    ->orderBy('release_date', 'desc')
                    ->where('status',1)
                    ->take(10)
                    ->get();


                break;
            case 'enjoy-in-your-native-tongue':
                $value = Constant::where('type', 'movie_language')->get();


                break;
            case 'popular-movies':
                $value = Entertainment::where('type', 'movie')->where('IMDb_rating', '>', 5)->released()->where('status',1)->orderBy('IMDb_rating', 'desc')->take(10)->get();


                break;
            case 'popular-tvshows':
                $value = Entertainment::where('type', 'tvshow')->where('IMDb_rating', '>', 5)->orderBy('IMDb_rating', 'desc')->whereDate('release_date', '<=', now())->where('status',1)->take(20)->get();


                break;
            // case 'popular-tvcategories':
            //     $value = LiveTvCategory::take(10)->get();


            //     break;
            case 'popular-videos':
                $value = Video::whereDate('release_date', '<=', now())->where('status',1)->get();


                break;
            case 'top-channels':
                $value = LiveTvChannel::take(10)->where('status',1)->get();


                break;
            case 'your-favorite-personality':
                $value = CastCrew::where('type', 'actor')->take(10)->get();

                break;
            case '500-free-movies':
                $value = Entertainment::where('type', 'movie')->where('movie_access', 'free')->whereDate('release_date', '<=', now())->where('status',1)->take(10)->get();


                break;
            case 'genre':
                $value = Genres::take(10)->where('status',1)->get();

                break;
        }
        return response()->json($value);
    }

    public function addNewRequest(MobileAddSettingRequest $request)
    {

         Cache::flush();

        if ($request->has('type') && $request->type != null) {

            if ($request->has('optionvalue') && !empty($request->optionvalue)) {
                $value = json_encode($request->optionvalue);
            } else {
                $value = null;
            }

            $maxPosition = (int) MobileSetting::max('position');
            $mobileSetting = MobileSetting::find($request->id);

            if ($mobileSetting) {
                // Update existing entry without changing the position
                $mobileSetting->update(['name' => $request->name, 'slug' => $request->type, 'value' => $value]);
            } else {
                // Create new entry with a new position
                MobileSetting::create([
                    'id' => $request->id,
                    'name' => $request->name,
                    'slug' => $request->type,
                    'value' => $value,
                    'position' => $maxPosition + 1
                ]);
            }
        }

        $message = __('messages.create_form_mobile', ['form' => __($this->module_title)]);

        return redirect()->route('backend.mobile-setting.index')->with('success', $message);
    }
}
