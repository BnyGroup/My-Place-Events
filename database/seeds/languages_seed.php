<?php

use Illuminate\Database\Seeder;
use App\Languages;


class languages_seed extends Seeder
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
        		'language_title'  => 'English',
        		'language_code'  => 'in',        		
        	],[
        		'language_title'  => 'Arabic',
        		'language_code'  => 'ar',        		
        	],[
        		'language_title'  => 'French',
        		'language_code'  => 'fr',        		
        	],
        	
        ];
        
        foreach ($settings as $key => $value) {
        	Languages::create($value);
        }
    }
}
