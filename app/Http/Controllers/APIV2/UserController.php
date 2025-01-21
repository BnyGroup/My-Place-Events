<?php

namespace App\Http\Controllers\APIV2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\ModalAPI\OauthAccessToken;
use App\ModalAPI\Frontuser;
use App\ModalAPI\Setting;
use App\ModalAPI\Page;

class UserController extends Controller {

	public $successStatus = 200;
    public function __construct(){
        $this->AauthAcessToken = new OauthAccessToken;
        $this->setting = new Setting;
        //$this->page = new Page;
    }

public function login(Request $request) {
        $input = $request->all();
        $validator = Validator::make($input,[
            'email'     => 'required',
            'password'  => 'required',
        ]);
        if ($validator->passes()) {
            if (Auth::guard('frontuser')->attempt(['email' => $input['email'], 'password' => $input['password'],'status' => 1])){
                    $user = Auth::guard('frontuser')->user();
                    $data['id']         = user_data($user->id)->id;
                    $data['fullname']   = user_data($user->id)->fullname;
                    $data['email']      = user_data($user->id)->email;
                    $data['profile_pic']= user_data($user->id)->profile_pic;
                    $data['firstname']  = user_data($user->id)->firstname;
                    $data['lastname']   = user_data($user->id)->lastname;
                    $data['token']      =  $user->createToken('MyApp',['frontuser'])->accessToken;

                    $message = "User Loging Successfully";
                    return $this->getSuccessResult($data,$message,true);
            }else{
                $data = Frontuser::where('email',$input['email'])->first();
                if (isset($data->status) && $data->status == 2) {
                    $message = trans('words.msg.accou_close').' '.frommail();
                    return $this->getValidationMessage($message);
                }elseif(isset($data->status) && $data->status == 0) {
                    $message = trans('words.msg.active_usr');
                    return $this->getValidationMessage($message);
                }
                elseif(isset($data->status) && $data->status == 3) {
                    $mail = '<a href="mailto:'.frommail().'">' . frommail() .'</a>';
                    $message = trans('words.msg.usr_ban'). frommail();
                    return $this->getValidationMessage($message);
                } else {
                    $message = trans('words.msg.email_pwd');
                    return $this->getValidationMessage($message);
                }
            }
        }else{
            return $this->getValidationMessage($validator->errors()->first());
        }
    }


    /* User LogIn */
    public function logmein(Request $request){
        $input = $request->all();
        $validator = Validator::make($input,[
            'email'     => 'required',
            'password'  => 'required',
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
                    
                    $data['id']         = user_data($udata->id)->id;
                    $data['fullname']   = user_data($udata->id)->fullname;
                    $data['email']      = user_data($udata->id)->email;
                    $data['profile_pic']= user_data($udata->id)->profile_pic;
                    $data['firstname']  = user_data($udata->id)->firstname;
                    $data['lastname']   = user_data($udata->id)->lastname;

                    $message = "User Loging Successfully";
                    $success['token']   =  $user->createToken('MyApp',['frontuser'])->accessToken;
                    return response()->json(['success' => '1','id' => $data['id'], 'firstname' => $data['firstname'],'lastname' => $data['lastname'],'fullname' => $data['fullname'],
                    'email' => $data['email'], 'profile_pic' => $data['profile_pic'],'status' => $data['status'],'cellphone' => $data['cellphone'],'address' => $data['address'],'country' => $data['country'],'token' => $success['token']],$this->successStatus);

            }else{
                $data = Frontuser::where('email',$input['email'])->first();
                if (isset($data->status) && $data->status == 2) {
                    $message = trans('words.msg.accou_close').' '.frommail();
                    return $this->getValidationMessage($message);
                }elseif(isset($data->status) && $data->status == 0) {
                    $message = trans('words.msg.active_usr');
                    return $this->getValidationMessage($message);
                }
                elseif(isset($data->status) && $data->status == 3) {
                    $mail = '<a href="mailto:'.frommail().'">' . frommail() .'</a>';
                    $message = trans('words.msg.usr_ban'). frommail();
                    return $this->getValidationMessage($message);
                } else {
                    $message = trans('words.msg.email_pwd');
                    return $this->getValidationMessage($message);
                }
            }
        }else{
            return $this->getValidationMessage($validator->errors()->first());
        }
    }
    /* User logout */
    public function log_out() {
        if (Auth::guard('api')->check()) {
            $accessToken = Auth::user()->token();
            $id = Auth::user()->id;
            \DB::table('oauth_refresh_tokens')
                ->where('access_token_id', $accessToken->id)
                ->update([
                    'revoked' => true
                ]);
            $accessToken->revoke();    
            $message = "User Successfully Logout";
            return $this->getSuccessResult('',$message,true);
        }else{
            return $this->getErrorMessage();
        }
    }

/* ================================================================================= */
/* ================================================================================= */
/* ================================================================================= */
    /* NEW CODE */
    public function getSuccessResult($datas='',$message,$response) {
        $output['data']       = $datas;
        $output['message']    = $message;
        $output['response']   = $response;
        return response()->json($output);        
    }
    public function getErrorMessage($message='Some Thing Wrong!') {
        $output['data']       = '';
        $output['message']    = $message;
        $output['response']   = false;
        return response()->json($output);
    }
    public function getValidationMessage($message) {
        $output['data']       = '';
        $output['message']    = $message;
        $output['response']   = false;
        return response()->json($output);   
    }
    /* NEW CODE */
/* ================================================================================= */
/* ================================================================================= */
/* ================================================================================= */

    // public function notFound()
    // {
    //     $msg = array('status'=>array('code'=> 404,'msg' => "Event not Found."));
    //     return $msg;   
    // }
    // public function noContent()
    // {
    //     $msg = array('status'=>array('code'=> 204,'msg' => "No Content"));
    //     return $msg;
    // }
    // public function getSuccessResult($data)
    // {
    //     $result['status'] = ['code' => 200, 'msg' =>''];
    //     $result['result'] = $data;
    //     return $result;
    // }
    // public function getErrorMessage($type){

    //     $msg = array('status'=>array('code'=> 108,'error' => "There are error."));
    //     return $msg;
    // }
}
