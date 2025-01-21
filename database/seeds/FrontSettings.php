<?php

use Illuminate\Database\Seeder;
use App\Setting;
class FrontSettings extends Seeder
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
        		'name'  => 'Logo',
        		'slug'  => 'site-front-logo',
        		'value' =>'logo.png'
        	],
            [
                'name'  => 'Favicon Logo',
                'slug'  => 'site-favicon-logo',
                'value' =>'faviconlogo-icon.png'
            ],
        	[
        		'name'  => 'Site Name',
        		'slug'  => 'site-title-name',
        		'value' => 'Eventz'
        	],
        	[
        		'name'  => 'Site Slogan',
        		'slug'  => 'site-tag-line',
        		'value' => 'Best Your Work'
        	],
            [
                'name'  => 'About Us',
                'slug'  => 'site-about',
                'value' => 'About yours'
            ],
            [
                'name'  => 'Home Header Image',
                'slug'  => 'site-header-image',
                'value' => 'slider.jpg'
            ],
            [
                'name'  => 'Home Header Image Text',
                'slug'  => 'site-header-img-text',
                'value' => 'Set up great Event, reach your audience, sell tickets and measure performance.'
            ],
        	[
        		'name'  => 'Currencies',
        		'slug'  => 'commision-currency-set',
        		'value' => 'INR'
        	],
            [
                'name'  => 'Currencies Symbol',
                'slug'  => 'currency-symbol',
                'value' => '&#8377'
            ],
        	[
        		'name'  => 'Commision',
        		'slug'  => 'commison-set',
        		'value' => '12'
        	],
        	[
        		'name'  => 'Time Zone',
        		'slug'  => 'time-zone-set',
        		'value' => 'IN'
        	],
            [
                'name'  => 'Time Zone City',
                'slug'  => 'time-zone-city',
                'value' => 'Asia/Kolkata'
            ],
        	[
        		'name'  => 'E-Mail Address',
        		'slug'  => 'mail-server-side',
        		'value' => 'eventz@alphansotech.com'
        	],
        	[
        		'name'  => 'Mail Driver',
        		'slug'  => 'mail-driver',
        		'value' => 'smtp'
        	],
        	[
        		'name'  => 'Mail Host',
        		'slug'  => 'mail-host',
        		'value' => 'mail.alphansotech.com'
        	],
        	[
        		'name'  => 'Mail Port',
        		'slug'  => 'mail-port',
        		'value' => '25'
        	],
        	[
        		'name'  => 'Mail Username',
        		'slug'  => 'mail-username',
        		'value' => 'eventz@alphansotech.com',
        	],
        	[
        		'name'  => 'Mail Password',
        		'slug'  => 'mail-password',
        		'value' => 'alphanso@1',
        	],

        ];

        foreach ($settings as $key => $value) {
        	Setting::create($value);
        }
    }
}
