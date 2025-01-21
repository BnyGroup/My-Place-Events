<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

       \Carbon\Carbon::setLocale('fr');
        //error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_DEPRECATED & ~E_WARNING);

        view()->composer('*', function ($view)
        {
            $frontuser_id = Auth::guard('frontuser')->id();
            $array = DB::table('wallets')->where('holder_id', $frontuser_id)->get();
            if ($array->count() > 0 ) {
                $wallet = $array[0]->balance;
            }else {
                $wallet = 0;
            }
            
            if ($array->count() > 1 ) {
                $bonus = $array[1]->balance;
            }else {
                $bonus = 0;
            }

            $view->with('wallet', $wallet)
                 ->with('bonus', $bonus);

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('path.public', function() {
            return base_path('public/');
        });
    }
}
