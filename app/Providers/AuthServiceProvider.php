<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
 
        Passport::tokensCan([
            'frontuser' => 'remember_token',
            'event-booking-url' => 'Can generate event booking url',
        ]);
        Passport::tokensExpireIn(\Carbon\Carbon::now()->addDays(30));

        // Register Laravel Passport routes
        Passport::routes(null, ['prefix' => 'api/oauth']);
    }
}
