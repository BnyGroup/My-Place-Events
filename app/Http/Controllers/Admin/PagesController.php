<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use App\Setting;

class PagesController extends AdminController
{
	public function __construct() {
    	parent::__construct();
    	$this->settings = new Setting;
    }

    public function terms_index()
    {
    	$settings = $this->settings->getSettings();
    	return view('Admin.pages.terms',compact('settings'));
    }
    public function terms_update(Request $request)
    {
    	$input = $request->all();
    	$this->validate($request,[
    		'terms-page-title' => 'required',
    		'terms-page-content' => 'required',
    	]);
        
    	$this->settings->updateSettings($input);
		return redirect()->back()->with('success','Terms & Condtion Page Updated.');
    }
    public function privacy_index()
    {
        $settings = $this->settings->getSettings();
        return view('Admin.pages.privacy',compact('settings'));
    }
    public function privacy_update(Request $request)
    {
        $input = $request->all();
        $this->validate($request,[
            'privacy-page-title' => 'required',
            'privacy-page-content' => 'required',
        ]);
        
        $this->settings->updateSettings($input);
        return redirect()->back()->with('success','Privacy Policy Page Updated.');   
    }
    public function faqs_index()
    {
        $settings = $this->settings->getSettings();
        return view('Admin.pages.faqs',compact('settings'));
    }
    public function faqs_update(Request $request)
    {
        $input = $request->all();
        $this->validate($request,[
            'faqs-page-title' => 'required',
            'faqs-page-content' => 'required',
        ]);
        $this->settings->updateSettings($input);
        return redirect()->back()->with('success','Faqs Page Updated.');
    }
    public function sreqrmnt_index()
    {
        $settings = $this->settings->getSettings();
        return view('Admin.pages.sreqrmnt',compact('settings'));
    }
    public function sreqrmnt_update(Request $request)
    {
        $input = $request->all();
        $this->validate($request,[
            'serverrequire-page-title' => 'required',
            'serverrequire-page-content' => 'required',
        ]);
        $this->settings->updateSettings($input);
        return redirect()->back()->with('success','Faqs Page Updated.');
    }
    public function support_index()
    {
        $settings = $this->settings->getSettings();
        return view('Admin.pages.support',compact('settings'));
    }
    public function support_update(Request $request)
    {
        $input = $request->all();
        $this->validate($request,[
            'support-page-title' => 'required',
            'support-page-content' => 'required',
        ]);
        $this->settings->updateSettings($input);
        return redirect()->back()->with('success','Support Page Updated.');
    }

    public function aboutus_index()
    {
        $settings = $this->settings->getSettings();
        return view('Admin.pages.aboutus',compact('settings'));
    }
    public function aboutus_update(Request $request)
    {
        $input = $request->all();
        $this->validate($request,[
            'aboutus-page-title' => 'required',
            'aboutus-page-content' => 'required',
        ]);
        $this->settings->updateSettings($input);
        return redirect()->back()->with('success','About Us Page Updated.');
    }
}
