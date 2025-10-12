<?php

namespace Modules\Frontend\Http\Controllers;

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
use Modules\Frontend\Http\Controllers\EpisodeResource;
use Modules\Frontend\Http\Controllers\MoviesResource;
class PerviewPaymentController extends Controller
{
    /**
     * Show Pay Per View Payment Form
     */
    public function PayPerViewForm(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $type = $request->type;
        $id   = $request->id;
// dd($request->all());
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
        return view('frontend::perviewpayment', compact('data'));
    }

    /**
     * Process Payment via SSLCommerz
     */
    public function processPayment(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login first.');
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
            'value_a'         => $request->movie_id,       // Content ID
            'value_b'         => $user->id,          // User ID
            'value_c'         => $request->type,     // Content Type
            'value_d'         => $request->access_duration ?? null,
            'value_e'         => $request->available_for ?? 48,
            'value_f'         => $request->discount ?? 0,
        ];
        session::put('movie_id', $request->id);
        session::put('access_duration', $request->access_duration ?? null);
        session::put('available_for', $request->available_for ?? 48);
        session::put('discount', $request->discount ?? 0);

        

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
    public function paymentSuccess(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $transaction_id = $request->tran_id;
        $amount         = $request->amount;
        $payment_type   = 'sslcommerz';
        $movie_id       = $request->value_a ?? null;
        $type           = $request->value_c ?? null;
        $access_duration= session::get('access_duration', null);
        $available_for  = session::get('available_for', 48);
        $discount       = session::get('discount', 0);

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
            return redirect('/')->with('error', 'Content not found after payment.');
        }

        $viewExpiry = now()->addDays((int) $available_for);

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

        PayperviewTransaction::create([
            'user_id'        => $user->id,
            'amount'         => $amount,
            'payment_type'   => $payment_type,
            'payment_status' => 'paid',
            'transaction_id' => $transaction_id,
            'pay_per_view_id'=> $payperview->id,
        ]);

        if (function_exists('sendNotification')) {
            sendNotification([
                'notification_type' => $movie->purchase_type == 'rental' ? 'rent_video' : 'purchase_video',
                'user_id' => $user->id,
                'user_name' => $user->name ?? $user->full_name,
                'name' => $movie->name ?? 'Video',
                'content_type' => $type,
                'status' => 'success',
                'amount' => $amount,
                'notification_group' => 'pay_per_view',
                'start_date' => now()->toDateString(),
                'end_date' => $viewExpiry->toDateString(),
            ]);
        }

        return redirect('/')->with([
            'purchase_success' => 'Payment completed successfully!',
            'view_expiry' => $viewExpiry->format('j F, Y')
        ]);
    }

    /**
     * Payment Fail
     */
    public function paymentFail()
    {
        return redirect('/')->with('error', 'Payment failed. Please try again.');
    }

    /**
     * Payment Cancel
     */
    public function paymentCancel()
    {
        return redirect('/')->with('error', 'Payment cancelled by user.');
    }

    /**
     * Save Start Date for Pay Per View
     */
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
            return redirect()->route('login');
        }
        return view('frontend::unlockvideo');
    }

    public function allUnlockVideos(Request $request)
    {
        try {
            $user = Auth::user();

            // Get all purchased content
            $purchasedContent = [
                'movies' => MoviesResource::collection(
                    Entertainment::where('movie_access', 'pay-per-view')
                        ->where('type', 'movie')
                        ->where('status', 1)
                        ->when(request()->has('is_restricted'), function ($query) {
                            $query->where('is_restricted', request()->is_restricted);
                        })
                        ->when(getCurrentProfileSession('is_child_profile') && getCurrentProfileSession('is_child_profile') != 0, function ($query) {
                            $query->where('is_restricted', 0);
                        })
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
                )->map(function ($item) use ($user) {
                    $item->user_id = $user->id;
                    return $item;
                }),
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
                )->map(function ($item) use ($user) {
                    $item->user_id = $user->id;
                    return $item;
                }),
                'videos' => VideoResource::collection(
                    Video::where('access', 'pay-per-view')
                        ->where('status', 1)
                        ->when(request()->has('is_restricted'), function ($query) {
                            $query->where('is_restricted', request()->is_restricted);
                        })
                        ->when(getCurrentProfileSession('is_child_profile') && getCurrentProfileSession('is_child_profile') != 0, function ($query) {
                            $query->where('is_restricted', 0);
                        })
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
                )->map(function ($item) use ($user) {
                    $item->user_id = $user->id;
                    return $item;
                }),
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
                )->map(function ($item) use ($user) {
                    $item->user_id = $user->id;
                    return $item;
                }),
                'episodes' => EpisodeResource::collection(
                    Episode::where('access', 'pay-per-view')
                        ->where('status', 1)
                        ->when(request()->has('is_restricted'), function ($query) {
                            $query->where('is_restricted', request()->is_restricted);
                        })
                        ->when(getCurrentProfileSession('is_child_profile') && getCurrentProfileSession('is_child_profile') != 0, function ($query) {
                            $query->where('is_restricted', 0);
                        })
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
                )->map(function ($item) use ($user) {
                    $item->user_id = $user->id;
                    return $item;
                })
            ];

            return response()->json([
                'status' => true,
                'data' => $purchasedContent
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
