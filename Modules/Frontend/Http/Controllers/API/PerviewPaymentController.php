<?php

namespace Modules\Frontend\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Modules\Video\Models\Video;
use Modules\Episode\Models\Episode;
use Modules\Season\Models\Season;
use Modules\Entertainment\Models\Entertainment;
use Modules\Frontend\Models\PayPerView;
use Modules\Frontend\Models\PayperviewTransaction;
use Modules\Frontend\Http\Resources\EpisodeResource;
use Modules\Frontend\Http\Resources\MoviesResource;
use Modules\Frontend\Http\Resources\VideoResource;
use Modules\Frontend\Http\Resources\SeasonResource;
use Modules\Frontend\Http\Resources\TvshowResource;
use App\Models\User;
class PerviewPaymentController extends Controller
{
    /**
     * Show Pay Per View Payment Form (API version).
     */
    public function PayPerViewForm(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['status' => false, 'message' => 'Please login first.'], 401);
        }

        $type = $request->type;
        $id   = $request->id;

        if ($type == 'video') {
            $data = Video::findOrFail($id);
        } elseif ($type == 'episode') {
            $data = Episode::findOrFail($id);
        } elseif ($type == 'season') {
            $data = Season::findOrFail($id);
        } else {
            $data = Entertainment::findOrFail($id);
        }

        $data->type = $type;
        return response()->json(['status' => true, 'data' => $data]);
    }

    /**
     * Process Payment via SSLCommerz
     */
    public function processPayment(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Please login first.'], 401);
        }
 
        $tran_id = uniqid('PPV_'); // Unique transaction ID

        $post_data = [
            'store_id'        => env('SSLCZ_STORE_ID'),
            'store_passwd'    => env('SSLCZ_STORE_PASS'),
            'total_amount'    => $request->price,
            'currency'        => "BDT",
            'tran_id'         => $tran_id,
            'success_url'     => route('payperview.payment.success'),
            'fail_url'        => route('payperview.payment.fail'),
            'cancel_url'      => route('payperview.payment.cancel'),
            'cus_name'        => $user->name ?? ($user->first_name . " " . $user->last_name),
            'cus_email'       => $user->email,
            'cus_add1'        => "Dhaka",
            'cus_city'        => "Dhaka",
            'cus_country'     => "Bangladesh",
            'shipping_method' => "NO",
            'ship_add1'       => "Dhaka",
            'ship_city'       => "Dhaka",
            'ship_name'       => $user->name ?? ($user->first_name . " " . $user->last_name),
            'ship_postcode'   => "1000",
            'ship_country'    => "Bangladesh",
            'product_name'    => "Video Rent",
            'product_category'=> "Service",
            'product_profile' => "general",
            'cus_phone'       => $user->mobile ?? '017xxxxxxxx',
            'value_a'         => $request->id,       // Content ID
            'value_b'         => $user->id,          // User ID
            'value_c'         => $request->type,     // Content Type
            'value_d'         => $request->access_duration ?? null,
            'value_e'         => $request->available_for ?? 48,
            'value_f'         => $request->discount ?? 0,
        ];

        Session::put('access_duration', $request->access_duration ?? null);
        Session::put('available_for', $request->available_for ?? 48);
        Session::put('discount', $request->discount ?? 0);

        $ssl_url = env('SSLCZ_IS_SANDBOX', true)
            ? "https://sandbox.sslcommerz.com/gwprocess/v4/api.php"
            : "https://securepay.sslcommerz.com/gwprocess/v4/api.php";

        try {
            $response = Http::asForm()->post($ssl_url, $post_data);
            $sslcommerzResponse = $response->json();

            if (!empty($sslcommerzResponse['GatewayPageURL'])) {
                return response()->json([
                    'status' => true,
                    'message' => 'Payment session created successfully',
                    'redirect_url'=> $sslcommerzResponse['GatewayPageURL']
                ]);
            } else {
                return response()->json(['status' => false, 'message' => 'SSLCommerz session failed.']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => false,'message' => 'Payment request failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Payment Success Callback
     */
    // public function paymentSuccess(Request $request)
    // {
    //     $user = Auth::user();
    //     if (!$user) {
    //         return response()->json(['status' => false, 'message' => 'Please login first.'], 401);
    //     }

    //     $transaction_id = $request->tran_id;
    //     $amount         = $request->amount;
    //     $type           = $request->value_c ?? null;
    //     $movie_id       = $request->value_a ?? null;

    //     $access_duration= Session::get('access_duration', null);
    //     $available_for  = Session::get('available_for', 48);
    //     $discount       = Session::get('discount', 0);

    //     if ($type == 'movie' || $type == 'tvshow') {
    //         $movie = Entertainment::find($movie_id);
    //     } elseif ($type == 'video') {
    //         $movie = Video::find($movie_id);
    //     } elseif ($type == 'episode') {
    //         $movie = Episode::find($movie_id);
    //     } elseif ($type == 'season') {
    //         $movie = Season::find($movie_id);
    //     } else {
    //         $movie = null;
    //     }

    //     if (!$movie) {
    //         return response()->json(['status' => false, 'message' => 'Content not found after payment.']);
    //     }

    //     $viewExpiry = now()->addDays((int) $available_for);

    //     $payperview = PayPerView::create([
    //         'user_id'             => $user->id,
    //         'movie_id'            => $movie_id,
    //         'type'                => $type,
    //         'content_price'       => $movie->price ?? $amount,
    //         'price'               => $amount,
    //         'discount_percentage' => $discount,
    //         'view_expiry_date'    => $viewExpiry,
    //         'access_duration'     => $access_duration,
    //         'available_for'       => $available_for,
    //     ]);

    //     PayperviewTransaction::create([
    //         'user_id'        => $user->id,
    //         'amount'         => $amount,
    //         'payment_type'   => 'sslcommerz',
    //         'payment_status' => 'paid',
    //         'transaction_id' => $transaction_id,
    //         'pay_per_view_id'=> $payperview->id,
    //     ]);

    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Payment completed successfully!',
    //         'view_expiry' => $viewExpiry->format('j F, Y')
    //     ]);
    // }
    public function paymentSuccess(Request $request)
{
    $user_id = $request->value_b; // ✅ এখানে user_id নিচ্ছি (SSLCommerz থেকে পাঠানো)
    $user = User::find($user_id);

    if (!$user) {
        return response()->json(['status' => false, 'message' => 'Please login first.'], 401);
    }

    $transaction_id = $request->tran_id;
    $amount         = $request->amount;
    $type           = $request->value_c ?? null;
    $movie_id       = $request->value_a ?? null;

    $access_duration = Session::get('access_duration', null);
    $available_for   = Session::get('available_for', 48);
    $discount        = Session::get('discount', 0);

    // 🎬 Determine content type
    if ($type == 'movie' || $type == 'tvshow') {
        $movie = Entertainment::find($movie_id);
    } elseif ($type == 'video') {
        $movie = Video::find($movie_id);
    } elseif ($type == 'episode') {
        $movie = Episode::find($movie_id);
    } elseif ($type == 'season') {
        $movie = Season::find($movie_id);
    } else {
        $movie = null;
    }

    if (!$movie) {
        return response()->json(['status' => false, 'message' => 'Content not found after payment.']);
    }

    $viewExpiry = now()->addDays((int) $available_for);

    // ✅ Save PayPerView record
    $payperview = PayPerView::create([
        'user_id'             => $user->id,
        'movie_id'            => $movie_id,
        'type'                => $type,
        'content_price'       => $movie->price ?? $amount,
        'price'               => $amount,
        'discount_percentage' => $discount,
        'view_expiry_date'    => $viewExpiry,
        'access_duration'     => $access_duration,
        'available_for'       => $available_for,
    ]);

    // ✅ Save Transaction
    PayperviewTransaction::create([
        'user_id'         => $user->id,
        'amount'          => $amount,
        'payment_type'    => 'sslcommerz',
        'payment_status'  => 'paid',
        'transaction_id'  => $transaction_id,
        'pay_per_view_id' => $payperview->id,
    ]);

    return response()->json([
        'status' => true,
        'message' => 'Payment completed successfully!',
        'view_expiry' => $viewExpiry->format('j F, Y')
    ]);
}

    public function paymentFail()
    {
        return response()->json(['status' => false, 'message' => 'Payment failed. Please try again.']);
    }

    public function paymentCancel()
    {
        return response()->json(['status' => false, 'message' => 'Payment cancelled by user.']);
    }

    public function setStartDate(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date'
        ]);

        Session::put('payperview_start_date', $request->start_date);

        return response()->json([
            'status' => true,
            'message' => 'Start date saved successfully',
            'start_date' => $request->start_date
        ]);
    }

    public function unlockVideos()
    {
        $user =  auth()->user();
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'Please login first.'], 401);
        }
        return response()->json(['status' => true, 'message' => 'Unlock videos view available']);
    }

    public function allUnlockVideos(Request $request)
    {
        try {
            $user = Auth::user();

            $purchasedContent = [
                'movies' => MoviesResource::collection(
                    Entertainment::where('movie_access', 'pay-per-view')
                        ->where('type', 'movie')
                        ->where('status', 1)
                        ->whereExists(function ($query) use ($user) {
                            $query->select('id')
                                ->from('pay_per_views')
                                ->whereColumn('movie_id', 'entertainments.id')
                                ->where('user_id', $user->id)
                                ->where('type', 'movie')
                                ->where(function ($q) {
                                    $q->whereNull('view_expiry_date')
                                        ->orWhere('view_expiry_date', '>', now());
                                })
                                ->where(function ($q) {
                                    $q->whereNull('first_play_date')
                                        ->orWhereRaw('DATE_ADD(first_play_date, INTERVAL access_duration DAY) > ?', [now()]);
                                });
                        })
                        ->get()
                ),
                'tvshows' => TvshowResource::collection(
                    Entertainment::where('movie_access', 'pay-per-view')
                        ->where('type', 'tvshow')
                        ->where('status', 1)
                        ->whereExists(function ($query) use ($user) {
                            $query->select('id')
                                ->from('pay_per_views')
                                ->whereColumn('movie_id', 'entertainments.id')
                                ->where('user_id', $user->id)
                                ->where('type', 'tvshow')
                                ->where(function ($q) {
                                    $q->whereNull('view_expiry_date')
                                        ->orWhere('view_expiry_date', '>', now());
                                })
                                ->where(function ($q) {
                                    $q->whereNull('first_play_date')
                                        ->orWhereRaw('DATE_ADD(first_play_date, INTERVAL access_duration DAY) > ?', [now()]);
                                });
                        })
                        ->get()
                ),
                'videos' => VideoResource::collection(
                    Video::where('access', 'pay-per-view')
                        ->where('status', 1)
                        ->whereExists(function ($query) use ($user) {
                            $query->select('id')
                                ->from('pay_per_views')
                                ->whereColumn('movie_id', 'videos.id')
                                ->where('user_id', $user->id)
                                ->where('type', 'video')
                                ->where(function ($q) {
                                    $q->whereNull('view_expiry_date')
                                        ->orWhere('view_expiry_date', '>', now());
                                })
                                ->where(function ($q) {
                                    $q->whereNull('first_play_date')
                                        ->orWhereRaw('DATE_ADD(first_play_date, INTERVAL access_duration DAY) > ?', [now()]);
                                });
                        })
                        ->get()
                ),
                'seasons' => SeasonResource::collection(
                    Season::where('access', 'pay-per-view')
                        ->where('status', 1)
                        ->whereExists(function ($query) use ($user) {
                            $query->select('id')
                                ->from('pay_per_views')
                                ->whereColumn('movie_id', 'seasons.id')
                                ->where('user_id', $user->id)
                                ->where('type', 'season')
                                ->where(function ($q) {
                                    $q->whereNull('view_expiry_date')
                                        ->orWhere('view_expiry_date', '>', now());
                                })
                                ->where(function ($q) {
                                    $q->whereNull('first_play_date')
                                        ->orWhereRaw('DATE_ADD(first_play_date, INTERVAL access_duration DAY) > ?', [now()]);
                                });
                        })
                        ->get()
                ),
                'episodes' => EpisodeResource::collection(
                    Episode::where('access', 'pay-per-view')
                        ->where('status', 1)
                        ->whereExists(function ($query) use ($user) {
                            $query->select('id')
                                ->from('pay_per_views')
                                ->whereColumn('movie_id', 'episodes.id')
                                ->where('user_id', $user->id)
                                ->where('type', 'episode')
                                ->where(function ($q) {
                                    $q->whereNull('view_expiry_date')
                                        ->orWhere('view_expiry_date', '>', now());
                                })
                                ->where(function ($q) {
                                    $q->whereNull('first_play_date')
                                        ->orWhereRaw('DATE_ADD(first_play_date, INTERVAL access_duration DAY) > ?', [now()]);
                                });
                        })
                        ->get()
                )
            ];

            return response()->json([
                'status' => true,
                'data' => $purchasedContent
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
