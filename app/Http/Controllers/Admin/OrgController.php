<?php

namespace App\Http\Controllers\Admin;
use App\Organization;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
class OrgController extends AdminController
{
	public function __construct()
	{
		parent::__construct();
		$this->organization = new Organization;
	}
    public function index()
    {
    	$data = $this->organization->getDatawithUser();
    	return view('Admin.org.index',compact('data'));
    }
    public function shows($id)
    {
    	$data = $this->organization->getDataUser($id);
    	return view('Admin.org.view',compact('data'));
    }
    public function ban($id)
    {
        Organization::where('id',$id)->update(['ban'=>1]);
        return redirect()->back()->with('error','Organization ban Successfully.');
    }
    public function revoke($id)
    {
        Organization::where('id',$id)->update(['ban'=>0]);
        return redirect()->back()->with('success','Organization Revoke Successfully.');
    }

    public function sold_tikets()
    {
        $data = $this->organization->getData();
        return view('Admin.soldearning.sold',compact('data'));
    }
}
