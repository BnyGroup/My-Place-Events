<?php

use Illuminate\Database\Seeder;
use App\Setting;

class SocailStatus extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$settings = [
        	[
        		'name'  => 'Google',
        		'slug'  => 'google-login',
        		'value' => '0'
        	],
        	[
        		'name'  => 'Linkedin',
        		'slug'  => 'linkedin-login',
        		'value' => '0'
        	],
        	[
        		'name'  => 'Twitter',
        		'slug'  => 'twitter-login',
        		'value' => '0'
        	],
        	
        ];

        foreach ($settings as $key => $value) {
        	Setting::create($value);
        }
    }
}
