<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'payment/ipn',
        'payment/success',
        'payment/fail',
        'payment/cancel',


        'payment-form/pay-per-view',
        'process-payment/pay-per-view',
        'payment/success/pay-per-view',
        'payment/cancel/pay-per-view',
        'payment/fail/pay-per-view',
        
        "send-otp",
        "auth/otp-login-store"


    ];
}
