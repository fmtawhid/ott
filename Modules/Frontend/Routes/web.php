<?php

use Illuminate\Support\Facades\Route;
use Modules\Frontend\Http\Controllers\MovieController;
use Modules\Frontend\Http\Controllers\FrontendController;
use Modules\Frontend\Http\Controllers\PaymentController;
use Modules\Frontend\Http\Controllers\Auth\AuthController;
use Modules\Frontend\Http\Controllers\Auth\OTPController;
use App\Http\Controllers\LanguageController;
use Modules\Frontend\Http\Controllers\TvShowController;
use Modules\Frontend\Http\Controllers\CastCrewController;
use Modules\Frontend\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Modules\Frontend\Http\Controllers\Auth\UserController;
use Modules\Frontend\Http\Controllers\PerviewPaymentController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::middleware(['checkInstallation'])->group(function () {

// Login with Applelo
Route::get('/auth/apple', [AuthController::class, 'redirectToApple'])->name('auth.apple');
Route::get('/auth/apple/callback', [AuthController::class, 'handleAppleCallback'])->name('auth.apple.callback');


// Login with OTP
Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::get('/otp-login', [OTPController::class, 'otpLogin'])->name('otp-login');
Route::post('/send-otp', [OTPController::class, 'sendOtp'])->name('send.otp');
Route::get('/verify-otp', [OTPController::class, 'verifyOtpPage'])->name('verify.otp.page');
Route::post('/verify-otp', [OTPController::class, 'verifyOtp'])->name('verify.otp');
Route::get('/otp-register', [OTPController::class, 'otpRegister'])->name('otp.register');
Route::post('/auth/otp-login-store', [OTPController::class, 'otpLoginStore'])->name('auth.otp-login-store');
Route::get('/auth/check-user-exists', [OTPController::class, 'checkUserExists'])->name('check.user.exists');


// Login with Google
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');



Route::get('language/{language}', [LanguageController::class, 'switch'])->name('frontend.language.switch');
Route::get('/login-page', [AuthController::class, 'login'])->name('login-page');
Route::post('/store-user', [AuthController::class, 'store'])->name('store-user');
Route::get('/register', [AuthController::class, 'registration'])->name('register-page');
Route::get('/forget-password', [AuthController::class, 'forgetpassword'])->name('forget-password');


Route::post('/security-control', function(Request $request) {
    $user = auth()->user();

    if ($user) {
        $user->is_parental_lock_enable=1;
        $user->save();

        return response()->json(['status' => 'success']);
    }

    return response()->json(['status' => 'fail'], 400);
})->name('security-control');

Route::post('/disable-security', function(Request $request) {
    $user = auth()->user();
    $user->is_parental_lock_enable=0;
    $user->save();

    if ($user) {
        return response()->json(['status' => 'success']);
    }

    return response()->json(['status' => 'fail'], 400);
})->name('disable-security');





Route::get('movies/genre/{genre_id}', [MovieController::class, 'moviesListByGenre'])->middleware('checkModule')->name('movies.genre');
Route::get('movies/{language}', [MovieController::class, 'movieList'])->middleware('checkModule')->name('movies.language');
Route::get('/movies', [MovieController::class, 'movieList'])->middleware('checkModule')->name('movies');
Route::get('/movie/{id}', [MovieController::class, 'movieDetails'])->middleware('checkModule')->name('movie-details');
Route::get('/tv-shows', [TvShowController::class, 'tvShowList'])->middleware('checkModule')->name('tv-shows');
Route::get('/tvshow-details/{id}', [TvShowController::class, 'tvshowDetail'])->middleware('checkModule')->name('tvshow-details');
Route::get('/episode-details/{id}', [TvShowController::class, 'episodeDetail'])->middleware('checkModule')->name('episode-details');
Route::get('/videos', [VideoController::class, 'videoList'])->middleware('checkModule')->name('videos');
Route::get('/videos-details/{id}', [VideoController::class, 'videoDetails'])->middleware('checkModule')->name('video-detail');
Route::get('/pay-per-view', [PerviewPaymentController::class, 'peyPerView'])->name('pay-per-view');


Route::get('/comingsoon', [MovieController::class, 'comingSoonList'])->middleware('checkModule')->name('comingsoon');
Route::get('/livetv', [MovieController::class, 'livetvList'])->middleware('checkModule')->name('livetv');
Route::get('/livetv-details/{id}', [MovieController::class, 'liveTvDetails'])->middleware('checkModule')->name('livetv-details');
Route::get('/livetv-channels/{id}', [MovieController::class, 'livetvChannelsList'])->middleware('checkModule')->name('livetv-channels');



Route::get('/castcrew-detail/{id}', [CastCrewController::class, 'castCrewDetail'])->name('castcrew-detail');
Route::get('/castcrew-list', [CastCrewController::class, 'castcrewList'])->name('castcrewList');
Route::get('/castcrew-list/{type}/{id}', [CastCrewController::class, 'moviecastcrewList'])->name('movie-castcrew-list');

Route::get('/continuewatch-list', [FrontendController::class, 'continueWatchList'])->name('continueWatchList');
Route::get('/language-list', [FrontendController::class, 'languageList'])->name('languageList');
Route::get('/topchannel-list', [FrontendController::class, 'topChannelList'])->name('topChannelList');
Route::get('/genres-list', [FrontendController::class, 'genresList'])->name('genresList');
Route::get('/languages-data',[FrontendController::class, 'languageData'])->name(name: 'languageData');
Route::get('/search', [FrontendController::class, 'searchList'])->name('search');

// Route::get('/comingsoon', [FrontendController::class, 'comingsoon'])->name('comingsoon');
// Route::get('/livetv', [MovieController::class, 'livetvList'])->name('livetv');

Route::get('/watch-list', [FrontendController::class, 'watchList'])->name('watchList');

Route::get('/faq', [FrontendController::class, 'faq'])->name('faq');

Route::get('/all-review/{id}', [FrontendController::class, 'allReview'])->name('all-review');
Route::get('/video-details/{id}', [VideoController::class, 'VideoDetails'])->name('video-details');


Route::post('/decrypt-url', [FrontendController::class, 'decryptUrl'])->name('decrypt.url');

Route::post('/get-available-promotions', [PaymentController::class, 'getAvailablePromotions'])
    ->name('get-available-promotions');
});

Route::get('/trending-movies', [MovieController::class, 'getTrendingMovies'])->name('trending.movies');

Route::group(['middleware' => ['user']], function () {
    Route::post('/account/password/update', [UserController::class, 'updatePassword'])->name('account.password.update');
    Route::get('/logout', [AuthController::class, 'Logout'])->name('user-logout');
    Route::get('/account-setting', [FrontendController::class, 'accountSetting'])->name('accountSetting');
    Route::get('/edit-profile', [UserController::class, 'editProfile'])->name('edit-profile');
    Route::delete('/profile/delete/{profile}', [UserController::class, 'destroy'])->name('profile.destroy');
    Route::post('/device-logout', [FrontendController::class, 'deviceLogout'])->name('device-logout');
    Route::get('/subscription-payment', [FrontendController::class, 'subscriptPayment'])->name('subscription-payment');
    Route::get('/payment-history', [FrontendController::class, 'PaymentHistory'])->name('payment-history');
    Route::get('/transaction-history', [FrontendController::class, 'transactionHistory'])->name('transaction-history');
    Route::post('/cancel-subscription', [FrontendController::class, 'cancelSubscription'])->name('cancelSubscription');
    Route::post('/get-payment-details', [FrontendController::class, 'getPaymentDetails']);
    Route::get('invoice-download', [FrontendController::class, 'downloadInvoice'])->name('downloadinvoice');
    Route::get('/subscription-plan', [FrontendController::class, 'subscriptionPlan'])->name('subscriptionPlan');
    // Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('process-payment');
    // Route::post('/select-plan', [PaymentController::class, 'selectPlan'])->name('select.plan');
    // Route::get('/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');




    // ================= SSLCommerz Routes =================

Route::post('/select-plan', [PaymentController::class, 'selectPlan'])->name('select.plan');
Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('process-payment');
Route::match(['get','post'],'/payment/success', [PaymentController::class, 'paymentSuccess'])->name('payment.success');
Route::match(['get','post'],'/payment/fail', [PaymentController::class, 'paymentFail'])->name('payment.fail');
Route::match(['get','post'],'/payment/cancel', [PaymentController::class, 'paymentCancel'])->name('payment.cancel');
Route::post('/payment/ipn', [PaymentController::class, 'ipn'])->name('payment.ipn');



    Route::get('/security-control', [UserController::class, 'securityControl'])->name('security-control');
    // Route::get('/security-control-form', [UserController::class, 'securityControlForm'])->name('security-control-form');
Route::get('/notification-templates', [NotificationTemplatesController::class, 'index'])->name('backend.notification-templates.index');

    Route::post('/cancel-subscription', [FrontendController::class, 'cancelSubscription'])->name('cancelSubscription');
});

Route::get('/video/stream/{encryptedUrl}', [TvShowController::class, 'stream'])->name('video.stream');
Route::get('/video/1/{encryptedUrl}', [TvShowController::class, 'streamLocal'])->name('video.1');
Route::get('/check-device-type', [FrontendController::class, 'checkDeviceType'])->middleware('auth');
Route::get('/check-subscription/{planId}', [FrontendController::class, 'checkSubscription'])->middleware('auth');




Route::group(['as' => 'frontend.'], function () {
    Route::post('/clear-cache-config', function () {
        \Artisan::call('config:clear');
        \Artisan::call('cache:clear');
        return response()->json(['message' => 'Cache and Config cleared']);
    })->name('cache_config_clear'); // Define the name for the route
});

Route::get('/payment-form/pay-per-view', [PerviewPaymentController::class, 'PayPerViewForm'])->name('pay-per-view.paymentform');
Route::post('/process-payment/pay-per-view', [PerviewPaymentController::class, 'processPayment'])->name('process-payment.payperview');
Route::post('/payment/success/pay-per-view', [PerviewPaymentController::class, 'paymentSuccess'])->name('payperview.payment.success');
Route::post('/payment/fail/pay-per-view', [PerviewPaymentController::class, 'paymentFail'])->name('payperview.payment.fail');
Route::post('/payment/cancel/pay-per-view', [PerviewPaymentController::class, 'paymentCancel'])->name('payperview.payment.cancel');
Route::get('/unlock-videos', [PerviewPaymentController::class, 'unlockVideos'])->name('unlock.videos');
Route::post('/pay-per-view/start-date', [PerviewPaymentController::class, 'setStartDate'])->name('pay-per-view.start-date');
// ...existing code...


// Route::get('/entertainment/{thumbnailUrl}', [FrontendController::class, 'showEntertainment']);

// Route::get('/get-meta-data', [FrontendController::class, 'getMetaDataByThumbnailUrl']);


// This is a route that passes an entertainment ID to the controller's show method
// Route::get('/entertainment/{id}', [FrontendController::class, 'show'])->name('frontend.entertainment.show');









