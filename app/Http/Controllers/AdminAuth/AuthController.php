<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OrderController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Frontuser;
use Auth;
use Illuminate\Support\Facades\Validator;
use Response;

class AuthController extends Controller
{
     use AuthenticatesUsers;

      protected $redirectTo = '/';

    public function __construct(){
        view()->share('theme','layouts.master');
        $this->middleware('guest', ['except' => 'logout']);

    }
    public function login_form(){
    	if(Auth::guard('frontuser')->check()){
    	    //return redirect()->route('users.pro');
            //dd(session('link_2'),3);
            return redirect(session('link_2'));
    	}else{
    	    $link = session('link_2');
    	    if(!isset($link))
                session(['link_2' => url()->previous()]);
            //dd(session('link_2'));
        	return view('theme.user.user-login');
    	}
    }

    public function login(Request $request)
    {
    	$input	= $request->all();
       // dd(session('link_2'));

        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required',
        ]);

    	if (Auth::guard('frontuser')->attempt(['email' => $input['email'], 'password' => $input['password'],'status' => 1])){
            \Session::forget('guestUser');
            /*return redirect('/');*/
            //dd(session('link_2'),2);
            /*if(session('link_2') == 'https://myplace-event.com/signin')
                session(['link_2' => url()->previous()]);*/
            //dd(session('link_2'));
            $link = session('link_2');
            \Session::forget('link_2');
            return redirect($link);
        }else{
                $data = Frontuser::where('email',$input['email'])->first();
                if (isset($data->status) && $data->status == 2) {
                    if (!is_null($data->reason)) {
                        return back()->with('errors',trans('words.msg.accou_close'). frommail());
                    }
                }elseif(isset($data->status) && $data->status == 0)
                {
                    return back()->with('error',trans('words.msg.active_usr'));
                }
                elseif(isset($data->status) && $data->status == 3)
                {
                    $mail = '<a href="mailto:'.frommail().'">' . frommail() .'</a>';
                    return back()->with('error',trans('words.msg.usr_ban'). frommail());
                }
                else{
                    return redirect()->route('user.login')->with('error',trans('words.msg.email_pwd'));
                }
        }
    }
	
	
    public function postLogin(Request $request)
    {
  	
	$validator = Validator::make($request->all(), [
		'email' => 'required|email',
		'password' => 'required'
	]);
	$input = $request->all();
		
	$link='';
	if(isset($_POST['ref'])){
		$link = $_POST['ref'];
	}

        if($validator->fails()){
			
				return Response::json([
					"status" => false,
					"errors" => $validator->errors()
				]);
			
        }else{
			
            if (Auth::guard('frontuser')->attempt(['email' => $input['email'], 'password' => $input['password'],'status' => 1])){

		\Session::forget('guestUser');				
            	\Session::forget('link_2');
                return Response::json(["status" => true, "redirect" =>$link]);
				
            } else {
				
		$data = Frontuser::where('email',$input['email'])->first();
                if (isset($data->status) && $data->status == 2){
					
                    if (!is_null($data->reason)) {
						
						return Response::json([
							"status" => false,
							"errors" => [trans('words.msg.accou_close'). frommail()]
						]);
                    }
					
                }elseif(isset($data->status) && $data->status == 0){
					
					return Response::json([
							"status" => false,
							"errors" => [trans('words.msg.active_usr')]
						]);
					
               }elseif(isset($data->status) && $data->status == 3){
					
                    $mail = '<a href="mailto:'.frommail().'">' . frommail() .'</a>';
					
					return Response::json([
							"status" => false,
							"errors" => [trans('words.msg.usr_ban'). frommail()]
						]);
                
				}else{
					
					return Response::json([
						"status" => false,
						"errors" => [trans('words.msg.email_pwd')]
					]);
                }
 
 				
                return Response::json([
                    "status" => false,
                    "errors" => ["Identifiants invalides"]
                ]);
            }
        }
    }
	
	
    
    public function logout()
    {
        $this->order_controller = new OrderController;
        $this->order_controller->removeUserSessionOrder();
        
        \Session::remove('order_id');

    	Auth::guard('frontuser')->logout();
    	return redirect()->route('index');
    }
}
