<?php

use Illuminate\Database\Seeder;
use App\Setting;
class ConfiguratioSeeder extends Seeder
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
        		'name'  => 'Google Client ID',
        		'slug'  => 'google-client-id',
        		'value' => '651214379658-3v4kk2ms2l1hmqsctgfmcn9pplkg0prs.apps.googleusercontent.com'
        	],[
        		'name'  => 'Google Secret ID',
        		'slug'  => 'google-secret-id',
        		'value' => '0_F6UGCNy2OcmCt_HL9IOrKr'
        	],[
        		'name'  => 'Google Redirect URL',
        		'slug'  => 'google-redirect-url',
        		'value' => 'http://eventz.alphansoprojects.com/login/google/callback'
        	],[
        		'name'  => 'Linkedin Client ID',
        		'slug'  => 'linkedin-client-id',
        		'value' => '81t68clqwamcf2'
        	],[
        		'name'  => 'Linkedin Secret ID',
        		'slug'  => 'linkedin-secret-id',
        		'value' => '1BWJhfRmcElp9FYO'
        	],[
        		'name'  => 'Linkedin Redirect URL',
        		'slug'  => 'linkedin-redirect-url',
        		'value' => 'http://eventz.alphansoprojects.com/login/linkedin/callback'
        	],[
        		'name'  => 'Twitter Client ID',
        		'slug'  => 'twitter-client-id',
        		'value' => 'qrcMtyIeMfFSIxi4uDLjoxhyy'
        	],[
        		'name'  => 'Twitter Secret ID',
        		'slug'  => 'twitter-secret-id',
        		'value' => 'JLaHiwHXufVaYm4xfR5bfKzXtvxpkk6T1FNHMER3Nm3ZR1eFzl'
        	],[
        		'name'  => 'Twitter Redirect URL',
        		'slug'  => 'twitter-redirect-url',
        		'value' => 'http://eventz.alphansoprojects.com/login/twitter/callback'
        	],[
                'name'  => 'Paypal Client ID',
                'slug'  => 'paypal-client-id',
                'value' => 'Ab0M3WzDkrbJqNmKa4UdUn3U3hXiOIYfzxfvZgSrn1CLT7_Np7m28lJpOGdJbUzh0uyHZh6QrjIGi_oN'
            ],[
                'name'  => 'Paypal Secret ID',
                'slug'  => 'paypal-secret-id',
                'value' => 'EIfHIcEizFxNVBLw46NfmHwMCTd0bV7lq5wD1fj_AW77mNVACZwa6kkDXk68IGeoh84mDJFnLZTzf9bj'
            ],[
                'name'  => 'Paypal Mode',
                'slug'  => 'paypal-mode',
                'value' => 'sandbox'
            ],[
                'name'  => 'Paypal Currency',
                'slug'  => 'paypal-currency',
                'value' => 'USD'
            ],[
                'name'  => 'Stripe Client ID',
                'slug'  => 'stripe-client-id',
                'value' => 'pk_test_t1NpI0e5bcSbWxukkOWaUZqn'
            ],[
                'name'  => 'Stripe Secret ID',
                'slug'  => 'stripe-secret-id',
                'value' => 'sk_test_lejK3e8mt6OkEeOF6tYARcju'
            ],[
                'name'  => 'Stripe Currency',
                'slug'  => 'stripe-currency',
                'value' => 'USD'
            ],[
                'name'  => 'Google API KEY',
                'slug'  => 'google-api-key',
                'value' => 'AIzaSyAyvAkYa_2PaUCpxsZrIXwC5QWhlO_Q-Sg'
            ],[
                'name'  => 'Bitly API KEY',
                'slug'  => 'bitly-api-key',
                'value' => '902da49df4b3f07d043b6517e596f927ccdbfeed'
            ]
        ];

        foreach ($settings as $key => $value) {
        	Setting::create($value);
        }
    }
}
