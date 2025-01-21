<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\ModalAPI\OauthAccessToken;
use App\ModalAPI\Event;
use App\ModalAPI\Frontuser;
use Validator;
use App\ModalAPI\Setting;
use App\ModalAPI\Page;
class UserController extends Controller
{
	public $successStatus = 200;

    public function __construct()
    {
        $this->event = new Event;
        $this->AauthAcessToken = new OauthAccessToken;
        $this->setting = new Setting;
        $this->page = new Page;
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input,[
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->passes()) {
            if (Auth::guard('frontuser')->attempt(['email' => $input['email'], 'password' => $input['password'],'status' => 1])){
                    $user = Auth::guard('frontuser')->user();
                    $udata = Frontuser::where('email',$input['email'])->first();

                    $data['id']         = $udata->id;
                    $data['fullname']   = $udata->fullname;
                    $data['email']      = $udata->email;
                    $data['profile_pic']= $udata->profile_pic;
                    $data['firstname']  = $udata->firstname;
                    $data['lastname']   = $udata->lastname;

                    $data['status']   = $udata->status;
                    $data['cellphone']   = $udata->cellphone;
                    $data['address']   = $udata->address;
                    $data['country']   = $udata->country;

                    $success['token']   =  $user->createToken('MyApp',['frontuser'])->accessToken;
                    return response()->json(['success' => '1', 'token' => $success['token'],'id' => $data['id'], 'firstname' => $data['firstname'],'lastname' => $data['lastname'],'fullname' => $data['fullname'],
                    'email' => $data['email'], 'profile_pic' => $data['profile_pic'],'status' => $data['status'],'cellphone' => $data['cellphone'],'address' => $data['address'],'country' => $data['country']],$this->successStatus);
            }else{
                    $data = Frontuser::where('email',$input['email'])->first();
                    if (isset($data->status) && $data->status == 2) {
                            return response()->json(['error' => '0','msg'=>trans('words.msg.accou_close').' '.frommail()],200);
                    }elseif(isset($data->status) && $data->status == 0)
                    {
                        return response()->json(['error' => '0','msg'=>trans('words.msg.active_usr')],200);
                    }
                    elseif(isset($data->status) && $data->status == 3)
                    {
                        $mail = '<a href="mailto:'.frommail().'">' . frommail() .'</a>';
                        return response()->json(['error' => '0','msg'=>trans('words.msg.usr_ban'). frommail()],200);
                    }
                    else{
                        return response()->json(['error' => '0','msg'=>trans('words.msg.email_pwd')],200);
                    }
            }
        }else{
            return response()->json(['success' => '0', 'error'=>$validator->errors()], 200);
        }

        // if($validator->passes()){
        //     if(Auth::guard('frontuser')->attempt(['email' => $input['email'], 'password' => $input['password']])){
        //         $user = Auth::guard('frontuser')->user();
        //         $success['token'] =  $user->createToken('MyApp',['frontuser'])->accessToken;
        //         return response()->json(['success' => '1', 'token' => $success['token']],$this->successStatus);
        //     }else{
        //         return response()->json(['success' => '0', 'token' => '', 'msg'=>'Email and password are not match'],401);
        //     }
        // }else{
        //     return response()->json(['success' => '0', 'error'=>$validator->errors()], 401);
        // }

    }

    public function log_out()
    {
        
        // if (Auth::check()) {
        //     $id = Auth::user()->id;
        //     $this->AauthAcessToken->removes($id);
        //     return response()->json(['success' => 'Logout'], $this->successStatus);
        // }


        if (Auth::check()) { 
            $accessToken = Auth::user()->token();
            $id = Auth::user()->id;
            \DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken->id)
                ->update([
                    'revoked' => true
                ]);
            $accessToken->revoke();    
            return response()->json(['success' => 'Logout'], $this->successStatus);
          }
        
    }

    public function faq()
    {
        if (auth()->check()) {
            $datas = $this->page->getDataWithSlug('faqs');
            if(is_null($datas)){
                return response()->json($this->noContent());
            }
            $data = [];
            $data['title'] = $datas->page_title;
            $data['content'] = $datas->page_desc;
            return response()->json(['data' => $data],$this->successStatus);
        }
        return response()->json($this->getErrorMessage('462'));
    }

    public function privacy()
    {
        if (auth()->check()) {
            $datas = $this->page->getDataWithSlug('privacy-and-policy');
            if(is_null($datas)){
                return response()->json($this->noContent());
            }
            $data = [];
            $data['title'] = $datas->page_title;
            $data['content'] = $datas->page_desc;
            return response()->json(['data' => $data],$this->successStatus);
        }
        return response()->json($this->getErrorMessage('462'));
    }

    public function terms()
    {
        if (auth()->check()) {
            $datas = $this->page->getDataWithSlug('terms-and-condtion');
            if(is_null($datas)){
                return response()->json($this->noContent());
            }
            $data = [];
            $data['title'] = $datas->page_title;
            $data['content'] = $datas->page_desc;
            return response()->json(['data' => $data],$this->successStatus);
        }
        return response()->json($this->getErrorMessage('462'));
    }

    public function notFound()
    {
        $msg = array('status'=>array('code'=> 404,'msg' => "Event not Found."));
        return $msg;   
    }
    public function noContent()
    {
        $msg = array('status'=>array('code'=> 204,'msg' => "No Content"));
        return $msg;
    }
    public function getSuccessResult($data)
    {
        $result['status'] = ['code' => 200, 'msg' =>''];
        $result['result'] = $data;
        return $result;
    }
    public function getErrorMessage($type){

        $msg = array('status'=>array('code'=> 108,'error' => "There are error."));
        return $msg;
    }
}
