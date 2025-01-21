<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\AdminController;
use App\Bank;
class BankController extends AdminController
{

	public function __construct() {
    	parent::__construct();
    	$this->bank = new Bank;
    }

    public function create()
    {
    	$data = $this->bank->getData();
    	return view('Admin.bank.create',compact('data'));
    }

    public function store(Request $request)
    {
    	$input = $request->all();

    	$this->validate($request,[
    		'fieldname'	=>	'required',
    		'type'	=>	'required',
    	]);
    	$input['slug']	=	str_slug($input['fieldname']);
    	$this->bank->createData($input);
    	return redirect()->back()->with(['success' => 'Bank Details Form Created Successfully.']);
    }
    public function delete($id)
    {
    	Bank::where('id',$id)->delete();
    	return redirect()->back()->with(['success' => 'Field Deleted Successfully.']);	
    }
}
