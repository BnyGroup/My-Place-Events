<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
        return view('home');
    }

    /*public function test_email(){
        $mail = array('contact@myplace-events.com'*//*,'williamscedricdabo@gmail.com'* /);
        try {
            Mail::send('Admin.mail.test',['orderData'=>'Données'],function($message) use ($mail)
            {
                $message->from(frommail(), forcompany());
                $message->to($mail);
                $message->subject('Messsage à l\'admin');
            });
        } catch (\Exception $e) {
            //dd($e);
            //return redirect()->route('index');
        }

        return "success";
    }*/
}
