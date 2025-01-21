<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Config;
use DB;

class MailServiceProvider extends ServiceProvider
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
       $vary = ['mail-driver','mail-host','mail-port','mail-username','mail-password'];
        // $mail = Setting::whereIn('slug',$vary)->get();
        $mail = \DB::table('settings')->whereIn('slug',$vary)->get();

        foreach ($mail as $key => $registerValue) {
            $result[$registerValue->slug] = $registerValue;

        }
       /* MAIL SERVER */
        $site_setting['mail_driver'] = env('MAIL_DRIVER', 'smtp');
        if(isset($result['mail-driver']) && !empty($result['mail-driver'])){
            $site_setting['mail_driver'] = $result['mail-driver']->value;
        }
        $site_setting['mail_host'] = env('MAIL_HOST', 'smtp.mailgun.org');
        if(isset($result['mail-host']) && !empty($result['mail-host'])){
            $site_setting['mail_host'] = $result['mail-host']->value;
        }
        $site_setting['mail_port'] = env('MAIL_PORT', 587);
        if(isset($result['mail-port']) && !empty($result['mail-port'])){
            $site_setting['mail_port'] = $result['mail-port']->value;
        }
        $site_setting['mail_username'] = env('MAIL_USERNAME');
        if(isset($result['mail-username']) && !empty($result['mail-username'])){
            $site_setting['mail_username'] = $result['mail-username']->value;
        }
        $site_setting['mail_password'] = env('MAIL_PASSWORD');
        if(isset($result['mail-password']) && !empty($result['mail-password'])){
            $site_setting['mail_password'] = $result['mail-password']->value;
        }
        /* MAIL SERVER */
        Config::set('mail.driver',$site_setting['mail_driver']);
        Config::set('mail.host', $site_setting['mail_host']);
        Config::set('mail.port',$site_setting['mail_port']);
        Config::set('mail.encryption','tls');
        Config::set('mail.username',$site_setting['mail_username']);
        Config::set('mail.password',$site_setting['mail_password']);
        
    }
}
