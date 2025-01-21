<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class WordPressServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */

    protected $bootstrapFilePath = '../path/to/wp/and/wp-load.php';


    public function boot()
    {
        //
        /**
         * Here we can enqueue any extra scripts or styles we may need.
         * I loaded my frontend specific styles and scripts that were of no use to the WP site
         */
        wp_enqueue_style('frontend-styles', URL::asset('css/frontend.css'), ['dependencies'], false);
        wp_enqueue_script('frontend-scripts', URL::asset('js/frontend.js'), ['dependencies'], false, true);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if(\File::exists($this->bootstrapFilePath)) {
            require_once($this->bootstrapFilePath);
        }

    }
}
