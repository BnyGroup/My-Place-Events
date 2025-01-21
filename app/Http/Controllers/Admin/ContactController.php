<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Contact;
use App\Http\Controllers\Admin\AdminController;
use App\Setting;

class ContactController extends AdminController
{
	public function __construct() {
    	parent::__construct();
    	$this->settings = new Setting;
    }
    
    public function contact()
	{
		$data = Contact::get();
		return view('Admin.pages.feedback',compact('data'));
	}
	public function contact_delete($id)
	{
		Contact::where('id',$id)->delete();
		return redirect()->back()->with('success','Delete Contact Successfully.');
	}
	public function index()
	{
		$settings = $this->settings->getSettings();
		return view('Admin.pages.contact',compact('settings'));
	}
	public function contact_update(Request $request)
	{	
		$input = $request->all();
		$this->validate($request,[
			'contact-page-title' => 'required',
			'contact-page-location' => 'required',
			'contact-page-address' => 'required',
			'contact-page-phone' => 'required',
			'contact-page-email' => 'required',
		]);

		$this->settings->updateSettings($input);
		return redirect()->back()->with('success','Contact Page Updated.');
	}
}
