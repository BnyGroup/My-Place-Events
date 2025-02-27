<?php

use Illuminate\Database\Seeder;
use App\Page;

class Defaultpages extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
	    	[
	    		'page_title'	=>	'Privacy And Policy',
	    		'page_slug'		=>	'privacy-and-policy',
	    		'page_desc'		=>	'Enter Your Content',
	    		'page_image'	=>	 NULL,
	    		'page_status'	=>	'1',
	    	],
	    	[
	    		'page_title'	=>	'Terms And Condtion',
	    		'page_slug'		=>	'terms-and-condtion',
	    		'page_desc'		=>	'Enter Your Content',
	    		'page_image'	=>	 NULL,
	    		'page_status'	=>	'1',
	    	]
	    ];
			    foreach ($data as $key => $value) {
		        	Page::create($value);
		        }
    }
}
