<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Frontuser;
use Mail;
class PasswordResetController extends Controller
{
	public function __construct()
	{
		view()->share('theme','layouts.master');
		$this->frontuser = new Frontuser;
	}
    public function form()
    {
    	if (auth()->guard('frontuser')->check()) {
    		return redirect()->back();
    		
    	}else{
    		return view('theme.reset.form');
    	}
    }
    public function formpost(Request $request)
    {
    	$input = $request->all();
    	$this->validate($request,[
    		'email' => 'email|required|exists:frontusers,email',
    	]);	

    	$data = $this->frontuser->checkmail($input['email']);
    	$mail = array($request->email);

        try {
        	Mail::send('theme.reset.mail',['userdata'=>$data],function($message) use ($mail)
            {
                $message->from(frommail(), forcompany())->subject("Reset Password");
                $message->to($mail);
            });
        }catch (\Exception $e) {
            return redirect()->back()->with('error','Reset password email are not send.');     
        }
       return redirect()->route('reset.link')->with('success',trans('words.msg.rest_link').$input['email']);
    }
	
	public function formpostAjax(Request $request)
    {
    	$input = $request->all();
    	$this->validate($request,[
    		'email' => 'email|required|exists:frontusers,email',
    	]);	

    	$data = $this->frontuser->checkmail($input['email']);
    	$mail = array($request->email);

        try {
        	Mail::send('theme.reset.mail',['userdata'=>$data],function($message) use ($mail)
            {
                $message->from(frommail(), forcompany())->subject("Reset Password");
                $message->to($mail);
            });
			return response()->json([
							"status" => true,
							"success" => [trans('words.msg.rest_link').$input['email']]
						]);
			
        }catch (\Exception $e) {
			return response()->json([
							"status" => false,
							"errors" => ["Reset password email are not send."]
						]);
        }
       //return redirect()->route('reset.link')->with('success',trans('words.msg.rest_link').$input['email']);
    }

    public function reset_form($token)
    {
    	if(isset($token) && $token)
        {   
            $data = $this->frontuser->avtivation($token);

            if(is_null($data)){
                return redirect()->route('user.login')->with('error',trans('words.msg.expt_link'));
            } else {
		    	return view('theme.reset.resetform',compact('token'));
            }
        }
    }
    public function password_update(Request $request)
    {
    	$input = $request->all();
    	$this->validate($request,[
    		'email' => 'required|email|exists:frontusers,email',
    		'password' => 'required|same:confirmation_password',
    		'confirmation_password' => 'required'
    	]);
    	$token = $input['token'];
    	$password = bcrypt($input['password']);
    	
    	$data = $this->frontuser->password_update($token,$password);

    	if ($data == 1) {
    		$email = $input['email'];
    		$rm_token = str_random(60);
    		$this->frontuser->tokeUpdate($email,$rm_token);
    	}
    	return redirect()->route('user.login')->with('success',trans('words.msg.updated_pwd'));
    }
}
