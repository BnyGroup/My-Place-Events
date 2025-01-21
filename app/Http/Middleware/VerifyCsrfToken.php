<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        'prestataire/cinetpay/*',
        'prestataire/cinetpay/notify',
        'prestataire/cinetpay/return',
        'notification/cinetpay',
        'retour/cinetpay',
        'annulation/cinetpay/*',
        'a_la_une/pay/return',
        'a_la_une/pay/notify',
        'a_la_une/pay',
        'p/cinetPay/return',
        'paypal/directpay',
        'paypal-transaction-complete/*',
        'prestataire/paypal-transaction-complete/*'
    ];
}
