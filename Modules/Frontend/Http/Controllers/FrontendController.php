<?php

namespace Modules\Frontend\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MobileSetting;
use Modules\Entertainment\Models\Entertainment;
use Modules\Banner\Models\Banner;
use App\Models\Device;
use App\Models\User;
use Modules\Banner\Transformers\SliderResource;
use Modules\Subscriptions\Models\Plan;
use Modules\Subscriptions\Models\Subscription;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Modules\Entertainment\Transformers\MoviesResource;
use Modules\Entertainment\Transformers\TvshowResource;
use Modules\Tax\Models\Tax;
use Modules\Constant\Models\Constant;
use Modules\FAQ\Models\FAQ;
use Modules\Coupon\Models\Coupon;
use App\Services\RecommendationService;
use Barryvdh\DomPDF\Facade\Pdf;
use Modules\Subscriptions\Trait\SubscriptionTrait;
use Illuminate\Support\Facades\Cache;
use Modules\Frontend\Models\PayPerView;
use Modules\Entertainment\Models\Subtitle;
use Modules\Entertainment\Models\EntertainmentDownload;
use Modules\Entertainment\Transformers\MovieDetailResource;
use Modules\Entertainment\Models\Watchlist;
use Modules\Entertainment\Models\ContinueWatch;
use Modules\Entertainment\Models\Like;
use Modules\Entertainment\Models\EntertainmentGenerMapping;
use App\Models\UserSearchHistory;
use Modules\Season\Models\Season;
use Modules\Entertainment\Transformers\EpisodeDetailResource;
use Modules\Genres\Models\Genres;
use Modules\Episode\Models\Episode;
use Modules\Entertainment\Transformers\TvshowDetailResource;
use Modules\Video\Models\Video;
use Modules\Video\Transformers\VideoDetailResource;
use Modules\LiveTV\Models\LiveTvChannel;
use Modules\LiveTV\Transformers\LiveTvChannelResource;
use Modules\SEO\Models\Seo;

class FrontendController extends Controller
{
    use SubscriptionTrait;
    /**
     * Display a listing of the resource.
     */
    protected $recommendationService;
    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;

    }

    public function index(Request $request)
    {
        $user_id = auth()->id();
        $cacheKey = 'slider';
        Cache::flush();

        $sliders = Cache::get($cacheKey);
        if (!$sliders) {
           $sliderList = Banner::where('banner_for', 'home')->where('status', 1)->get();
           $sliders = SliderResource::collection($sliderList->map(function ($slider) use ($user_id) {
                return new SliderResource($slider, $user_id);
           }));

           $sliders = $sliders->toArray(request());
           Cache::put($cacheKey, $sliders);

        }


        return view('frontend::index', compact('user_id','sliders'));
    }



    public function searchList()
    {
        $entertainment_list = Entertainment::query()
        ->with([
            'entertainmentGenerMappings',
            'plan',
            'entertainmentTalentMappings',
            'entertainmentStreamContentMappings',
            'entertainmentReviews' => function ($query) {
                $query->whereBetween('rating', [4, 5]);
            }
        ])
        ->where('status', 1);

    // Fetch movies
    $movieList = $entertainment_list->where('type', 'movie')->take(10)->get();
    $movieData = (isenablemodule('movie') == 1) ? MoviesResource::collection($movieList) : [];

    $entertainment_data = Entertainment::query()
    ->with([
        'entertainmentGenerMappings',
        'plan',
        'entertainmentTalentMappings',
        'entertainmentStreamContentMappings',
        'entertainmentReviews' => function ($query) {
            $query->whereBetween('rating', [4, 5]);
        }
    ])
    ->where('status', 1);


    // Fetch TV shows
    $tvshowList = $entertainment_data->where('type', 'tvshow')->take(10)->get();
    $tvshowData = (isenablemodule('tvshow') == 1) ? TvshowResource::collection($tvshowList) : [];


        return view('frontend::search', compact('movieData', 'tvshowData'));
    }

    public function tvshowList()
    {

        return view('frontend::movie');
    }

    public function continueWatchList()
    {
        return view('frontend::continueWatch');
    }

    public function languageList()
    {
        $languageIds = MobileSetting::getValueBySlug('enjoy-in-your-native-tongue');
        $popular_language = Constant::whereIn('id',json_decode($languageIds))->get();

        return view('frontend::language',compact('popular_language'));
    }
    public function languageData(Request $request){
        $perPage = $request->input('per_page', 10);
        $languageIds = MobileSetting::getValueBySlug('enjoy-in-your-native-tongue');
        $popular_language = Constant::whereIn('id',json_decode($languageIds));

        $html = '';
        $popular_language = $popular_language->paginate($perPage);
            foreach($popular_language as $language) {
                $html .= view('frontend::components.card.card_language',['popular_language' => $language])->render();
            }
            $hasMore = $popular_language->hasMorePages();
            return response()->json([
                'status' => true,
                'html' => $html,
                'message' => __('movie.tvshow_list'),
                'hasMore' => $hasMore,
            ], 200);
    }
    public function topChannelList()
    {
        return view('frontend::topChannel');
    }
    public function genresList()
    {
        return view('frontend::genres');
    }

    public function comingsoon()
    {
        return view('frontend::comingsoon');
    }
    public function livetv()
    {
        return view('frontend::livetv');
    }
    public function subscriptionPlan()
    {

        $plans = Plan::with('planLimitation')->where('status',1)->get();
        $activeSubscriptions = Subscription::where('user_id', auth()->id())->where('status', 'active')->where('end_date', '>', now())->orderBy('id','desc')->first();
        $currentPlanId = $activeSubscriptions ? $activeSubscriptions->plan_id : null;
        $subscriptions = Subscription::where('user_id', auth()->id())
        ->with('subscription_transaction')
        ->where('end_date', '<', now())
        ->get();

        return view('frontend::subscriptionplan', compact('plans','currentPlanId','activeSubscriptions'));
    }
    public function watchList()
    {
        return view('frontend::watchlist');
    }

    public function accountSetting()
    {
        $user = auth()->user();

         $subscriptions = Subscription::where('user_id', auth()->id())
            ->where('status', 'active')
            ->orderBy('id','desc')
            ->first();

        $devices = $user->devices;

        $your_device = null;
        $other_devices = [];

        $currentDeviceIp = request()->getClientIp();

        foreach ($devices as $device) {
            if ($device->device_id == $currentDeviceIp) {
                $your_device = $device;
            } else {
                $other_devices[] = $device;
            }
        }

        return view('frontend::accountSetting', compact('subscriptions', 'user', 'your_device', 'other_devices'));
    }


    public function deviceLogout(Request $request)
    {
        $userId = auth()->user()->id;

        $deviceQuery = Device::where('user_id', $userId);

        if ($request->has('device_id')) {
            $deviceQuery->where('device_id', $request->device_id);
        }

        if ($request->has('id')) {
            $deviceQuery->orWhere('id', $request->id);
        }

        $device = $deviceQuery->first();
        if (!$device) {
            return redirect()->back()->with('error', __('users.device_not_found'));
        }

        $device->delete();

        $sessionQuery = DB::table('sessions')->where('user_id', $userId);

        if ($request->has('device_id')) {
            $sessionQuery->where('ip_address', $request->device_id);
        }

        if ($request->has('id')) {
            $sessionQuery->orWhere('id', $request->id);
        }

        $session = $sessionQuery->first();
        if ($session) {
            $sessionQuery->delete();
        }

        return redirect()->back()->with('success', __('users.device_logout'));
    }


    public function faq()
    {
        $content = FAQ::where('status',1)->get();
        return view('frontend::faq',compact('content'));
    }


  public function PaymentHistory()
{
    $subscriptions = Subscription::where('user_id', auth()->id())
        ->with('subscription_transaction', 'plan')
        ->orderBy('id', 'desc')  // <--- add this line
        ->get();

    $activeSubscriptions = Subscription::where('user_id', auth()->id())
        ->where('status', 'active')
        ->where('end_date', '>', now())
        ->orderBy('id', 'desc')
        ->first();

    return view('frontend::paymentHistory', compact('activeSubscriptions', 'subscriptions'));
}


    public function transactionHistory()
    {
        $payPerViews = PayPerView::where('user_id', auth()->id())
        ->with(['movie', 'episode', 'video'])
        ->orderBy('created_at', 'desc')
        ->get();

        return view('frontend::transactionHistory', compact('payPerViews'));
    }

    public function allReview($id)
    {
        $entertainment = Entertainment::findOrFail($id);
        $reviews = $entertainment->entertainmentReviews;
        $ratingCounts = [
            5 => 0,
            4 => 0,
            3 => 0,
            2 => 0,
            1 => 0,
        ];
        foreach ($reviews as $review) {
            if (isset($ratingCounts[$review->rating])) {
                $ratingCounts[$review->rating]++;
            }
        }
        $totalRating = $reviews->sum('rating');
        $reviewCount = $reviews->count();
        $averageRating = $reviewCount > 0 ? $totalRating / $reviewCount : 0;

        return view('frontend::review', compact('entertainment', 'reviews', 'averageRating', 'ratingCounts', 'reviewCount'));
    }

    public function EpisodeDetails()
    {
        return view('frontend::episode_detail');
    }

    public function VideoDetails()
    {
     return view('frontend::video_detail');
    }

    public function profile()
    {
        return view('frontend::components.user.profile');
    }

    public function cancelSubscription(Request $request)
    {
        try {
            $planId = $request->input('plan_id');
            Subscription::where('user_id', auth()->id())
                ->where('id', $request->id)
                ->where('status', 'active')
                ->update(['status' => 'cancel']);

            $otherSubscription=Subscription::where('user_id', auth()->id())
                ->where('status', 'active')->get();

            if($otherSubscription->isEmpty()){

                $user=User::where('id',auth()->id() )->first();

                $user->update(['is_subscribe'=>0]);

            }



            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function decryptUrl(Request $request)
  {
      $encryptedUrl = $request->input('encrypted_url');

      try {
          $decryptedUrl = Crypt::decryptString($encryptedUrl);
          return response()->json(['url' => $decryptedUrl], 200);
      } catch (\Exception $e) {
          return response()->json(['error' => 'Invalid URL'], 400);
      }
  }
public function getPaymentDetails(Request $request)
{
    $planId = $request->input('plan_id');
    $promotionId = $request->input('promotion_id'); // Optional promotion
    $plan = Plan::find($planId);
    $discount_percentage = $plan->discount_percentage;

    $discount_amount = ($discount_percentage * $plan->price) / 100;

    $taxes = Tax::where('status', 1)->get();
    $baseAmount = $plan->total_price;
    $totalTaxamount = 0;
    $taxesArray = [];

    $subtotalBeforePromotion = $baseAmount;
    $promotionDiscountAmount = 0;

    // Apply promotion if provided
    if ($promotionId) {
        $promotion = Coupon::where('id', $promotionId)
            ->where('status', 1)
            ->whereHas('subscriptionPlans', function ($query) use ($planId) {
                $query->where('subscription_plan_id', $planId);
            })
            ->first();

        if ($promotion) {
            if ($promotion->discount_type === 'percentage') {
                $promotionDiscountAmount = ($promotion->discount * $baseAmount) / 100;
            } elseif ($promotion->discount_type === 'fixed') {
                $promotionDiscountAmount = $promotion->discount;
            }
        } else {
            return response()->json(['error' => 'Invalid or expired promotion.'], 400);
        }
    }

    // Calculate the subtotal after applying the promotion discount
    $subtotalAfterPromotion = max(0, $subtotalBeforePromotion - $promotionDiscountAmount);

    // Recalculate taxes based on the updated subtotal
    foreach ($taxes as $tax) {
        $taxAmount = 0;

        if (strtolower($tax->type) == 'fixed') {
            $taxAmount = $tax->value;
        } elseif (strtolower($tax->type) == 'percentage') {
            $taxAmount = ($subtotalAfterPromotion * $tax->value) / 100;
        }

        $taxesArray[] = [
            'name' => $tax->title,
            'type' => $tax->type,
            'value' => $tax->value,
            'tax_amount' => $taxAmount
        ];

        $totalTaxamount += $taxAmount;
    }

    // Calculate the total amount
    $totalAfterPromotion = $subtotalAfterPromotion + $totalTaxamount;

    return response()->json([
        'price' => $plan->price,
        'total_price' => $plan->total_price,
        'subtotal' => $subtotalAfterPromotion,
        'discount_percentage' => $discount_percentage,
        'plan_discount_amount' => $discount_amount,
        'tax' => $totalTaxamount,
        'tax_array' => $taxesArray,
        'promotion_id' => $promotionId,
        'promotion_discount_amount' => $promotionDiscountAmount,
        'total' => $totalAfterPromotion,
    ]);
}

    public function checkSubscription($planId)
   {
    $user = auth()->user();
    $currentSubscription = Subscription::where('user_id', $user->id)->where('status', 'active')->get();

    $planData=Plan::Where('id',$planId)->first();

    $level=$planData->level;

    foreach($currentSubscription as $plan)
    {

        if ($plan->level >= $level) {
            return response()->json(['isActive' => true]);
        }
    }
    return response()->json(['isActive' => false]);
   }


   public function checkDeviceType() {
        $checkDeviceType = Subscription::checkPlanSupportDevice(auth()->id());
        return $checkDeviceType;
    }



    public function downloadInvoice(Request $request)
    {

        $data = Subscription::with('plan','subscription_transaction','user')->find($request->id);
            if (!$data) {
                return response()->json(['status' => false, 'message' => 'subscription not found'], 404);
            }

        $pdf = PDF::loadView('frontend::components.partials.invoice', compact('data'))
        ->setOptions([
            'defaultFont' => 'Noto Sans',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => false,
        ]);
        return response()->streamDownload(
            function () use ($pdf) {
                echo $pdf->output();
            },
            "invoice.pdf",
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="invoice.pdf"',
            ]
        );
    }


}


