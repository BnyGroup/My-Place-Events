<?php

use Illuminate\Database\Seeder;
use App\Setting;

class PageSetting extends Seeder
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
        		'name'  => 'Page Title',
        		'slug'  => 'contact-page-title',
        		'value' =>'Contact Us'
        	],
        	[
        		'name'  => 'Location',
        		'slug'  => 'contact-page-location',
        		'value' => 'Alphanso Tech, Jagnath Plot, Rajkot, Gujarat, India'
        	],
        	[
        		'name'  => 'Address',
        		'slug'  => 'contact-page-address',
        		'value' => 'Race course Ground <br> Rajkot, Gujarat, India'
        	],
        	[
        		'name'  => 'Phone',
        		'slug'  => 'contact-page-phone',
        		'value' => '(+1) 347-587-8729'
        	],
            [
                'name'  => 'Email',
                'slug'  => 'contact-page-email',
                'value' => 'info@alphansotech.com'
            ],
        	
        ];
        
        foreach ($settings as $key => $value) {
        	Setting::create($value);
        }
    }
}
