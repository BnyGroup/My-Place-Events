<?php

namespace App\Http\Controllers\AdminAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Frontuser;
use Socialite;
use Auth;
use Exception;

class SocialController extends Controller
{

	protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function redirectToProvider($provieder)
    {
        return Socialite::driver($provieder)->redirect();
    }

    public function handleProviderCallback($provieder)
    {           
        $user = Socialite::driver($provieder)->user();
        dd($user);
        if (isset($user)) {
            $social = $this->createUser($user,$provieder);
            return redirect()->route('index');
        }
        return redirect()->route('user.signup');
    }


    public function createUser($data,$provieder)
    {
        
            $udata = Frontuser::where('email',$data->email)->first();
        if (! is_null($udata)) {
                Frontuser::where('email',$data->email)->update(['social_id' => $data->token,'provider' => $provieder]);
        } else {
            if ($provieder == 'google') {
                $socail = [
                    'unique_id' => str_shuffle(time()),
                    'firstname' => $data->user['name']['givenName'],
                    'lastname' => $data->user['name']['familyName'],
                    'status' => 1,
                    'email' => $data->email,
                    'social_id' => $data->token,
                    // 'unique_id' => str_shuffle(time()),
                    // 'firstname' => $data['fnm'],
                    // 'lastname' => $data['lnm'],
                    // 'status' => 1,
                    // 'email' => $data['email'],
                    // 'social_id' => $data['id'],
                ];
            }elseif ($provieder == 'linkedin') {
                $socail = [
                    'unique_id' => str_shuffle(time()),
                    'firstname' => $data->user['firstName'],
                    'lastname' => $data->user['lastName'],
                    'status' => 1,
                    'email' => $data->email,
                    'social_id' => $data->token,
                ];
            }else{
                $socail = [
                    'unique_id' => str_shuffle(time()),
                    'firstname' => $data->name,
                    'lastname' => $data->nickname,
                    'status' => 1,
                    'email' => $data->nickname,
                    'social_id' => $data->token,
                ];
            }

            $gdata = Frontuser::create($socail);
        }
        $authType = is_null($udata)?$gdata:$udata;
        Auth::guard('frontuser')->login($authType);
        return $udata;
    }


}
