<?php

use Illuminate\Database\Seeder;

class AdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       DB::table('users')->insert([
       	'firstname'=>'Alphanso',
       	'lastname'=>'Developer',
       	'username'=>'admin',       	
        'status'=>'1',
       	'user_type'=>'1',
       	'current_login'=>\Carbon\Carbon::now(),
       	'last_login'=>'0',
       	'profile_pic'=>null,
       	'gender'=>'1',
        'email'=>'eventz@alphansotech.com',
        'password'=>bcrypt('123456'),
       	'created_at'=> \Carbon\Carbon::now(),
        'updated_at'=> \Carbon\Carbon::now()
       ]);

       /* Frount user */

       DB::table('frontusers')->insert([
        'firstname'=>'Alphanso',
        'lastname'=>'Developer',
        'status'=>'1',
        'profile_pic'=>null,
        'gender'=>null,
        'email'=>'eventz@alphansotech.com',
        'password'=>bcrypt('123456'),
        'cellphone'=>null,
        'website'=>null,
        'address'=>null,
        'postalcode'=>null,
        'country'=>null,
        'state'=>null,
        'city'=>null,
        'remember_token'=>str_random(60),
        'created_at'=> \Carbon\Carbon::now(),
        'updated_at'=> \Carbon\Carbon::now()
       ]);
    }
}
