<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use DB;

class AdminController extends Controller
{
    public function __construct()
    {
        view()->share('AdminTheme','AdminTheme.master');
    }

    public function dashboard()
    {
        return view('Admin.dashboard.dashboard');
    }

    public function litige(){
        return view('Admin.litige.ticket-paid-not-send');
    }

    public function litige_send(Request $request){
        //dd(session('litige'));
        $input = $request->all();
        $this->validate($request,[
            'order_id'		=> 'required',
        ]);
        session(['litige' => url()->previous()]);
        return redirect()->route('ticket.oderdone',$input['order_id']);
    }

    public function litige_send_by_email(Request $request){
        session('litige');
        $input = $request->all();
        $this->validate($request,[
            'ot_email'		=> 'required|email',
        ]);
        session(['litige' => url()->previous()]);
        return redirect()->route('ticket.oderdone.byEmail',$input['ot_email']);
    }


}