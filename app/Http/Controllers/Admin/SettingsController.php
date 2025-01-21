<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use App\Setting;
use App\Seometa;
use File;
class SettingsController extends AdminController
{
    public function __construct() {
    	parent::__construct();
        $this->settings = new Setting;
    	$this->seometa = new Seometa;
    }

    public function index()
    {
    	$settings = $this->settings->getSettings();
    	return view('Admin.setting.index',compact('settings'));
    }

    public function update(Request $request)
    {
    	$input = $request->all();

        $this->validate($request,[
            'site-front-logo' => 'mimes:jpeg,jpg,png|image',
            'site-favicon-logo'=>'mimes:jpeg,jpg,png|image',
            'site-title-name' => 'required',
            'site-tag-line' => 'required',
            'commison-set' => 'required',
            'commision-currency-set' => 'required',
            'currency-symbol' => 'required',
            'time-zone-set' => 'required',
            'time-zone-city' => 'required',
            'mail-server-side' => 'required',
            'mail-port' => 'required',
            'mail-driver' => 'required',
            'mail-username' => 'required',
            'mail-host' => 'required',
            'mail-password' => 'required',
        ]);

        

        if (!empty($input['site-front-logo'])) {
            $image= $request['site-front-logo'];
            $input['imagename'] = str_shuffle(time()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/img'),$input['imagename']);
            $input['site-front-logo'] = $input['imagename'];
            
            if (!empty($input['image_old'])) {
                if(File::exists(public_path('/img/'.$input['image_old']))){
                    File::delete(public_path('/img/'.$input['image_old']));
                }
            }
        }else{
            $input['site-front-logo'] = $input['image_old'];
        }

        if (!empty($input['site-favicon-logo'])) {
            $image= $request['site-favicon-logo'];
            $input['imagename'] = str_shuffle(time()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/img'),$input['imagename']);
            $input['site-favicon-logo'] = $input['imagename'];
            
            if (!empty($input['faviimage_old'])) {
                if(File::exists(public_path('/img/'.$input['faviimage_old']))){
                    File::delete(public_path('/img/'.$input['faviimage_old']));
                }
            }
        }else{
            $input['site-favicon-logo'] = $input['faviimage_old'];
        }

        if (!empty($input['site-header-image'])) {
            $image= $request['site-header-image'];
            $input['imagename'] = str_shuffle(time()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('/img'),$input['imagename']);
            $input['site-header-image'] = $input['imagename'];
            
            if (!empty($input['header_image_old'])) {
                if(File::exists(public_path('/img/'.$input['header_image_old']))){
                    File::delete(public_path('/img/'.$input['header_image_old']));
                }
            }
        }else{
            $input['site-header-image'] = $input['header_image_old'];
        }

        $input['currency-symbol'] = htmlspecialchars($input['currency-symbol']);          
        $this->settings->updateSettings($input);
        return redirect()->back()->with('success','Site Settings is Updated.');
    }

    public function seoindex()
    {
        $seometa = $this->seometa->getSettings();
        return view('Admin.setting.seo',compact('seometa'));
    }
    public function seoUpdate(Request $request,$key)
    {
        $input = $request->all();
        $this->seometa->updateSettings($input,$key);
        return redirect()->back()->with('success','Meta Data Settings is Updated.');
    }

    public function siteConfiguration()
    {
        $settings = $this->settings->getSettings();
        return view('Admin.setting.configuration',compact('settings'));
    }

    public function confugratioUpdate(Request $request)
    {
        $input = $request->all();
        
        // $this->validate($request,[
        //     'stripe-client-id'          =>  'required',
        //     'stripe-secret-id'          =>  'required',
        //     'stripe-currency'           =>  'required',
        //     'linkedin-client-id'        =>  'required',
        //     'linkedin-secret-id'        =>  'required',
        //     'linkedin-redirect-url'     =>  'required',
        //     'twitter-client-id'         =>  'required',
        //     'twitter-secret-id'         =>  'required',
        //     'twitter-redirect-url'      =>  'required',
        //     'paypal-client-id'          =>  'required',
        //     'paypal-secret-id'          =>  'required',
        //     'paypal-mode'               =>  'required',
        //     'paypal-currency'           =>  'required',
        //     'google-client-id'          =>  'required',
        //     'google-secret-id'          =>  'required',
        //     'google-redirect-url'       =>  'required',
        //     'google-api-key'            =>  'required',
        //     'bitly-api-key'             =>  'required',
        // ]);

        $input['google-login'] = isset($input['google-login'])?$input['google-login']:0;
        $input['linkedin-login'] = isset($input['linkedin-login'])?$input['linkedin-login']:0;
        $input['twitter-login'] = isset($input['twitter-login'])?$input['twitter-login']:0;

        $this->settings->updateSettings($input);
        return redirect()->back()->with('success','Settings Configuration Updated.');
    }
}
