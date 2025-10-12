<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Frontend\Http\Controllers\DashboardController;
use Modules\Frontend\Http\Controllers\API\PerviewPaymentController;
use Modules\Frontend\Http\Controllers\API\PaymentController;
use Modules\Frontend\Http\Controllers\API\TransactionController;
use Modules\Frontend\Http\Controllers\TvShowController;


use Modules\Frontend\Http\Controllers\API\OTPApiController;
// Send OTP
Route::post('/send-otp', [OTPApiController::class, 'sendOtp'])->name('api.send.otp');
Route::post('/verify-otp', [OTPApiController::class, 'verifyOtp'])->name('api.verify.otp');
Route::post('/otp-register', [OTPApiController::class, 'otpRegister'])->name('api.otp.register');
Route::post('/check-user', [OTPApiController::class, 'checkUserExists'])->name('api.check.user');

Route::get('/debug-cache/{mobile}', function ($mobile) {
    // normalize to local 01XXXXXXXXX
    $digits = preg_replace('/\D+/', '', $mobile);
    if (Str::startsWith($digits, '00')) {
        $digits = substr($digits, 2);
    }
    if (Str::startsWith($digits, '8801') && strlen($digits) === 13) {
        $mobileLocal = '0' . substr($digits, 3);
    } elseif (Str::startsWith($digits, '01') && strlen($digits) === 11) {
        $mobileLocal = $digits;
    } else {
        return response()->json([
            'mobile_input' => $mobile,
            'error' => 'Invalid BD number for debug; use 01XXXXXXXXX / 8801XXXXXXXXX / +8801XXXXXXXXX'
        ], 422);
    }

    $otp = Cache::get("otp_{$mobileLocal}");

    return response()->json([
        'mobile_input' => $mobile,
        'mobile_local' => $mobileLocal,
        'cached_otp'   => $otp,
        'cache_key'    => "otp_{$mobileLocal}",
    ]);
});

Route::get('top-10-movie', [DashboardController::class, 'Top10Movies']);
Route::get('latest-movie', [DashboardController::class, 'LatestMovies']);
Route::get('fetch-languages', [DashboardController::class, 'FetchLanguages']);
Route::get('popular-movie', [DashboardController::class, 'PopularMovies']);
Route::get('top-channels', [DashboardController::class, 'TopChannels']);
Route::get('popular-tvshows', [DashboardController::class, 'PopularTVshows']);
Route::get('favorite-personality', [DashboardController::class, 'favoritePersonality']);
Route::get('free-movie', [DashboardController::class, 'FreeMovies']);
Route::get('get-gener', [DashboardController::class, 'GetGener']);
Route::get('get-video', [DashboardController::class, 'GetVideo']);
Route::get('base-on-last-watch-movie', [DashboardController::class, 'GetLastWatchContent']);
Route::get('most-like-movie', [DashboardController::class, 'MostLikeMoive']);
Route::get('most-view-movie', [DashboardController::class, 'MostviewMoive']);
Route::get('country-tranding-movie', [DashboardController::class, 'TrandingInCountry']);
Route::get('favorite-genres', [DashboardController::class, 'FavoriteGenres']);
Route::get('user-favorite-personality', [DashboardController::class, 'UserfavoritePersonality']);
Route::get('pay-per-view', [DashboardController::class, 'payperview']);
Route::get('movies-pay-per-view', [DashboardController::class, 'moviePayperview']);
Route::get('tvshows-pay-per-view', [DashboardController::class, 'tvShowPayperview']);
Route::get('videos-pay-per-view', [DashboardController::class, 'videosPayperview']);
Route::get('sessions-pay-per-view', [DashboardController::class, 'getSessionsPayPerView']);
Route::get('episodes-pay-per-view', [DashboardController::class, 'getEpisodesPayPerView']);

// Route::get('pay-per-view-list', [PerviewPaymentController::class, 'PayPerViewList']);


Route::get('web-continuewatch-list', [DashboardController::class, 'ContinuewatchList']);

Route::get('get-pinpopup/{id}', [DashboardController::class, 'getPinpopup']);

Route::get('v2/web-continuewatch-list', [DashboardController::class, 'ContinuewatchListV2']);
Route::get('v2/top-10-movie', [DashboardController::class, 'Top10MoviesV2']);

// Route::post('save-payment-pay-per-view', [PerviewPaymentController::class, 'savePaymentPayperview']);
// Route::post('start-date', [PerviewPaymentController::class, 'setStartDate']);
// Route::get('/transaction-history', [TransactionController::class, 'transactionHistory']);

Route::get('/check-episode-purchase', [TvShowController::class, 'checkEpisodePurchase'])->name('check.episode.purchase');
Route::get('/check-movie-purchase', [TvShowController::class, 'checkMoviePurchase'])->name('check.movie.purchase');



// ================= SSLCommerz API Routes =================
Route::post('/select-plan', [PaymentController::class, 'selectPlan'])->name('api.select.plan');
Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('api.process.payment');
Route::match(['get','post'],'/payment/success', [PaymentController::class, 'paymentSuccess'])->name('api.payment.success');
Route::match(['get','post'],'/payment/fail', [PaymentController::class, 'paymentFail'])->name('api.payment.fail');
Route::match(['get','post'],'/payment/cancel', [PaymentController::class, 'paymentCancel'])->name('api.payment.cancel');
Route::post('/payment/ipn', [PaymentController::class, 'ipn'])->name('api.payment.ipn');


// ================= Pay Per View API Routes =================
Route::post('/pay-per-view/payment-form', [PerviewPaymentController::class, 'PayPerViewForm'])->name('api.payperview.paymentform');
Route::post('/pay-per-view/process-payment', [PerviewPaymentController::class, 'processPayment'])->name('api.process-payment.payperview');
Route::match(['get','post'],'/pay-per-view/payment/success', [PerviewPaymentController::class, 'paymentSuccess'])->name('api.payperview.payment.success');
Route::match(['get','post'],'/pay-per-view/payment/fail', [PerviewPaymentController::class, 'paymentFail'])->name('api.payperview.payment.fail');
Route::match(['get','post'],'/pay-per-view/payment/cancel', [PerviewPaymentController::class, 'paymentCancel'])->name('api.payperview.payment.cancel');
Route::post('/pay-per-view/start-date', [PerviewPaymentController::class, 'setStartDate'])->name('api.payperview.start-date');
Route::get('/pay-per-view/unlock-videos', [PerviewPaymentController::class, 'allUnlockVideos'])->name('api.payperview.unlock-videos');

