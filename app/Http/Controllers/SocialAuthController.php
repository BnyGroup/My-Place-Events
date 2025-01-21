<?php

namespace App\Http\Controllers;

use App\Http\Controllers\FrontController;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\SocialAccountService;
use Socialite; // socialite namespace
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class SocialAuthController extends Controller
{

    // redirect function
    public function redirect($provider){
        session(['link' => url()->previous()]);
        return Socialite::driver($provider)->redirect();
    }
    // callback function
    public function callback(SocialAccountService $service,Request $request, $provider){
        try {
            $user = $service->createOrGetUser(Socialite::driver($provider)->user(), $provider);
            // Return Error missing Email User
            if(!isset($user->id) ) {
                /*dd($user);*/
                return $user;
            } else {
                //dd($user->email,$user->password);
                /*dd(Auth::guard('frontuser')->attempt(['email' => $user->email,'password'=>$user->password,'status' => 1]));
                if (Auth::guard('frontuser')->attempt(['email' => $user->email, 'password'=>$user->password ,'status' => 1])) {
                    dd($user->email);
                    \Session::forget('guestUser');
                    return redirect()->route('prestataire');}*/
                    /*return redirect(session('link'));*/
                Auth::guard('frontuser')->loginUsingId($user->id);
                \Session::forget('guestUser');
            }

        } catch (\Exception $e) {
           // dd($e);
            /*return redirect('login')->with(['login_required' => trans('misc.error').' - '.$e->getMessage() ]);*/
            return redirect('signin')->with(['login_required' => trans('misc.error').' - '.$e->getMessage() ]);
        }
            /*return redirect()->to('/');*/
        if(session('link') == url('signin'))
            return redirect(url('/'));
        if(session('link') != url('signin'))
            return redirect(session('link'));
    }// End callback

}//<-- End Class