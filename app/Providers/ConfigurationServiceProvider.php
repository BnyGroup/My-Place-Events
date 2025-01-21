<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Config;
use DB;

class ConfigurationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
       $vary = [
            'stripe-client-id',
            'stripe-secret-id',
            'stripe-currency',
            'linkedin-client-id',
            'linkedin-secret-id',
            'linkedin-redirect-url',
            'twitter-client-id',
            'twitter-secret-id',
            'twitter-redirect-url',
            'paypal-client-id',
            'paypal-secret-id',
            'paypal-mode',
            'paypal-currency',
            'google-client-id',
            'google-secret-id',
            'google-redirect-url',
            'google-api-key',
            'bitly-api-key',
        ];
        // $mail = Setting::whereIn('slug',$vary)->get();
        $mail = \DB::table('settings')->whereIn('slug',$vary)->get();

        foreach ($mail as $key => $registerValue) {
            $result[$registerValue->slug] = $registerValue;
        }
       
       // Stripe
        $site_setting['stripe_client_id'] = '';
        if(isset($result['stripe-client-id']) && !empty($result['stripe-client-id'])){
            $site_setting['stripe_client_id'] = $result['stripe-client-id']->value;
        }
        $site_setting['stripe_secret_id'] = '';
        if(isset($result['stripe-secret-id']) && !empty($result['stripe-secret-id'])){
            $site_setting['stripe_secret_id'] = $result['stripe-secret-id']->value;
        }
        $site_setting['stripe_currency'] = '';
        if(isset($result['stripe-currency']) && !empty($result['stripe-currency'])){
            $site_setting['stripe_currency'] = $result['stripe-currency']->value;
        }

        // linkedin
        $site_setting['linkedin_client_id'] = '';
        if(isset($result['linkedin-client-id']) && !empty($result['linkedin-client-id'])){
            $site_setting['linkedin_client_id'] = $result['linkedin-client-id']->value;
        }

        $site_setting['linkedin_secret_id'] = '';
        if(isset($result['linkedin-secret-id']) && !empty($result['linkedin-secret-id'])){
            $site_setting['linkedin_secret_id'] = $result['linkedin-secret-id']->value;
        }

        $site_setting['linkedin_redirect_url'] = '';
        if(isset($result['linkedin-redirect-url']) && !empty($result['linkedin-redirect-url'])){
            $site_setting['linkedin_redirect_url'] = $result['linkedin-redirect-url']->value;
        }

        // Twitter
        $site_setting['twitter_client_id'] = '';
        if(isset($result['twitter-client-id']) && !empty($result['twitter-client-id'])){
            $site_setting['twitter_client_id'] = $result['twitter-client-id']->value;
        }

        $site_setting['twitter_secret_id'] = '';
        if(isset($result['twitter-secret-id']) && !empty($result['twitter-secret-id'])){
            $site_setting['twitter_secret_id'] = $result['twitter-secret-id']->value;
        }

        $site_setting['twitter_redirect_url'] = '';
        if(isset($result['twitter-redirect-url']) && !empty($result['twitter-redirect-url'])){
            $site_setting['twitter_redirect_url'] = $result['twitter-redirect-url']->value;
        }

        // Google
        $site_setting['google_client_id'] = '';
        if(isset($result['google-client-id']) && !empty($result['google-client-id'])){
            $site_setting['google_client_id'] = $result['google-client-id']->value;
        }

        $site_setting['google_secret_id'] = '';
        if(isset($result['google-secret-id']) && !empty($result['google-secret-id'])){
            $site_setting['google_secret_id'] = $result['google-secret-id']->value;
        }

        $site_setting['google_redirect_url'] = '';
        if(isset($result['google-redirect-url']) && !empty($result['google-redirect-url'])){
            $site_setting['google_redirect_url'] = $result['google-redirect-url']->value;
        }

        $site_setting['google_api_key'] = '';
        if(isset($result['google-api-key']) && !empty($result['google-api-key'])){
            $site_setting['google_api_key'] = $result['google-api-key']->value;
        }

        // Paypal
        $site_setting['paypal_client_id'] = '';
        if(isset($result['paypal-client-id']) && !empty($result['paypal-client-id'])){
            $site_setting['paypal_client_id'] = $result['paypal-client-id']->value;
        }

        $site_setting['paypal_secret_id'] = '';
        if(isset($result['paypal-secret-id']) && !empty($result['paypal-secret-id'])){
            $site_setting['paypal_secret_id'] = $result['paypal-secret-id']->value;
        }

        $site_setting['paypal_mode'] = '';
        if(isset($result['paypal-mode']) && !empty($result['paypal-mode'])){
            $site_setting['paypal_mode'] = $result['paypal-mode']->value;
        }

        $site_setting['paypal_currency'] = '';
        if(isset($result['paypal-currency']) && !empty($result['paypal-currency'])){
            $site_setting['paypal_currency'] = $result['paypal-currency']->value;
        }

        // Bitly

        $site_setting['bitly_api_key'] = '';
        if(isset($result['bitly-api-key']) && !empty($result['bitly-api-key'])){
            $site_setting['bitly_api_key'] = $result['bitly-api-key']->value;
        }



        // Stripe :
        Config::set('services.stripe.key',$site_setting['stripe_client_id']);
        Config::set('services.stripe.secret',$site_setting['stripe_secret_id']);
        Config::set('services.stripe.currency',$site_setting['stripe_currency']);

        // Linkedin
        Config::set('services.linkedin.client_id',$site_setting['linkedin_client_id']);        
        Config::set('services.linkedin.client_secret',$site_setting['linkedin_secret_id']);        
        Config::set('services.linkedin.redirect',$site_setting['linkedin_redirect_url']);        


        // twitter
        Config::set('services.twitter.client_id',$site_setting['twitter_client_id']);        
        Config::set('services.twitter.client_secret',$site_setting['twitter_secret_id']);        
        Config::set('services.twitter.redirect',$site_setting['twitter_redirect_url']);        

        // google
        Config::set('services.google.client_id',$site_setting['google_client_id']); 
       /* Config::set('services.google.client_secret',$site_setting['google_client_id']);
        Config::set('services.google.redirect',$site_setting['google_client_id']);*/
        Config::set('services.google.client_secret',$site_setting['google_secret_id']);
        Config::set('services.google.redirect',$site_setting['google_redirect_url']);
        Config::set('services.google.api_key',$site_setting['google_api_key']);

        // PayPal
        Config::set('services.paypal.client_id',$site_setting['paypal_client_id']); 
        Config::set('services.paypal.secret',$site_setting['paypal_secret_id']);        
        Config::set('services.paypal.currency',$site_setting['paypal_mode']);
        Config::set('services.paypal.mode',$site_setting['paypal_currency']);

        // Bitly
        Config::set('services.shortlink.bitly.key',$site_setting['bitly_api_key']);
    }
}
