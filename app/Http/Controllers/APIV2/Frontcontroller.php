<?php

namespace App\Http\Controllers\APIV2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\APIV2\UserController;
use Auth;
use Mail;
use App\ModalAPI\Frontuser;
use Validator;
use App\ModalAPI\ImageUpload;
use Hash;

class Frontcontroller extends UserController {  

    public function __construct() {
        $this->front_user = new Frontuser;
    }

/* ================================================================================= */
    /*API Register front User */
    public function registeruser(Request $request) {
        $data = array();
        $input = $request->all();
        $validator = Validator::make($input,[
            'email'=>'required|email|unique:frontusers',
            'firstname'=>'required',
            'lastname'=>'required',
            'password'=>'required|same:confirm_password',
            'confirm_password'=>'required',
        ]);
        if ($validator->passes()) {
            $tokens = str_random(60);
            $mail = [$request->email];
            $userdata = array();
            $userdata = [
                'firstname'     => $input['firstname'],
                'lastname'      => $input['lastname'],
                'email'         => $input['email'],
                'remember_token'=>  $tokens,
            ];
            $userdata = (object) $userdata;

            Mail::send('theme.user.mail',['userdata'=>$userdata],function($message) use ($mail) {
                $message->from(frommail(), forcompany());
                $message->to($mail);
                $message->subject(trans('words.msg.active_acc_a'));
            });
            $input['password'] = bcrypt($input['password']);
            $input['remember_token'] = $tokens;
            $data = $this->front_user->createData($input);
            if (!empty($data)) {
                $message = "User Registered Successfully, Send Activation Code on your email please confirm first.";
                return $this->getSuccessResult($data,$message,true);
            } else {
                $message = 'User Not Registered';
                return $this->getErrorMessage($message);
            }
        } else {
            return $this->getValidationMessage($validator->errors()->first());
        }   
    }
/* ================================================================================= */
    /* API For Forgot Password*/ 
    public function forgotpassword(Request $request){
        $input = $request->all();
        $validator = Validator::make($input,[
            'email' => 'email|required|exists:frontusers,email',
        ]);
        if ($validator->passes())  {   
            $data = $this->front_user->checkmail($input['email']);
            $mail = array($request->email);
            Mail::send('theme.reset.mail',['userdata'=>$data],function($message) use ($mail) {
                $message->from(frommail(), forcompany())->subject("Reset Password");
                $message->to($mail);
            });
            $message    = 'Reset Password link send on your email ' . $input['email'];
            return $this->getSuccessResult('',$message,true);
        } else {
            return $this->getValidationMessage($validator->errors()->first());
        }
    }
/* ================================================================================= */
    /*Update Password*/
    public function password_update(Request $request) {
        $input     = $request->all();
        $old_password   = $request->password;
        $validator = Validator::make($input,[   
            'password' => 'required',
            'new_password' =>'required|same:repeat_new_password',
            'repeat_new_password' =>'required',
        ]);
        if ($validator->passes()){ 
            if (Auth::guard('api')->check()) {
                $user_id    = Auth::guard('api')->user()->id;
                $user = Frontuser::find($user_id);
                if(Hash::check($old_password, $user->password)) {   
                    $pwd = bcrypt($request->new_password);
                    $this->front_user->updateUserpwd($user_id,$pwd);
                    $message    = 'Password Updated Successfully';
                    return $this->getSuccessResult('',$message,true);
                } else {
                    $message    = 'Old Password is not correct';
                    return $this->getErrorMessage($message);
                }
            }else{
                $message    = 'User Not Login';
                return $this->getErrorMessage($message);
            }
        } else {
            return response()->json(['errors'=>$validator->errors()]);
        }
    }
/* ================================================================================= */
    /* User Profile */
 	public function userProfile() {
        if (Auth::guard('api')->check()) {
            $user_id    = Auth::guard('api')->user()->id;
            $data = $this->front_user->front_user_editdetail($user_id);
            if (!is_null($data)) {
                $output['email']        = $data->email;
                $output['profile_pic']  = getImage($data->profile_pic);
                $output['firstname']    = isset($data->firstname)?$data->firstname:'';
                $output['lastname']     = isset($data->lastname)?$data->lastname:'';
                $output['cellphone']    = isset($data->cellphone)?$data->cellphone:'';
                $output['website']      = isset($data->website)?$data->website:'';
                $output['address']      = isset($data->address)?$data->address:'';
                $output['postalcode']   = isset($data->postalcode)?$data->postalcode:'';
                $output['city']         = isset($data->city)?$data->city:'';
                $output['state']        = isset($data->state)?$data->state:'';
                $output['country']      = isset($data->country)?$data->country:'';
                
                $message    = "User Profile";
                return $this->getSuccessResult($output,$message,true);
            }
            $message    = "User Profile not found";
            return $this->getErrorMessage($message);
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
 	}
/* ================================================================================= */
    /* User Profile Udpate */
    public function userUpdate(Request $request) {
        $input = $request->all();
        if (Auth::guard('api')->check()) {
            $user_id    = Auth::guard('api')->user()->id;
            $validator  = Validator::make($input,[
                'firstname' => 'required',
                'lastname' => 'required',
                'cellphone' => 'nullable|numeric|digits:10',
                'website' => 'nullable|url',
                'address' => 'required',
                'city' => 'required',
                'country' => 'required',
                'state' => 'required',
                'postalcode' => 'nullable|numeric',
                'profile_pic' => 'image|mimes:jpeg,jpg,png',
            ]);
            $old_image = user_data($user_id)->old_image;
            if ($validator->passes()) {
                $path   = 'public/upload/front/'.date('Y').'/'.date('m');
                $upath  = 'upload/front/'.date('Y').'/'.date('m');
                if (!is_dir(public_path($upath))) {
                    \File::makeDirectory(public_path($upath),0777,true);
                }
                if (!empty($request->file('profile_pic'))) {
                    $iinput['image'] = ImageUpload::upload($upath,$request->file('profile_pic'),'userprofile');
                    ImageUpload::uploadThumbnail($upath,$iinput['image'],200,200);
                    if (!is_null($old_image)) {
                        $data = image_delete($old_image);
                        $path = $data['path'];
                        $image = $data['image_name'];
                        $image_thum = $data['image_thumbnail'];
                        ImageUpload::removeFile($path,$image,$image_thum);
                    }
                    $input['profile_pic'] = save_image($upath,$iinput['image']);
                } else {
                    $input['profile_pic'] = $old_image;
                }
                $this->front_user->UpdatedataPro($user_id,$input);
                $fdata = Frontuser::where('id',$user_id)->first();
                $data = array();
                $data['email']          = $fdata->email;
                $data['profile_pic']    = getImage($fdata->profile_pic);
                $data['firstname']      = $fdata->firstname;
                $data['lastname']       = $fdata->lastname;
                $data['cellphone']      = $fdata->cellphone;
                $data['website']        = $fdata->website;
                $data['address']        = $fdata->address;
                $data['city']           = $fdata->city;
                $data['postalcode']     = $fdata->postalcode;
                $data['country']        = $fdata->country;
                $data['state']          = $fdata->state;
                $message    = "Profile updated successfully";
                return $this->getSuccessResult($data,$message,true);
            }else{
                return $this->getValidationMessage($validator->errors()->first());
            }
        } else {
            $message    = "User not Login";
            return $this->getErrorMessage($message);
        }
    }
/* ================================================================================= */
/* ================================================================================= */
/* ================================================================================= */
/* API FOR BOT */
/* ================================================================================= */
    public function generateToken(Request $request) {
        $input = $request->all();

        $data['id']         = 0;
        $data['firstname']  = $input['firstname'];
        $data['lastname']   = $input['lastname'];
        $data['email']      = $input['email'];
        $data['fullname']   = $input['firstname']." ".$input['lastname'];
        
        $message = "User Loging Successfully";
        return $this->getSuccessResult($data,$message,true);

    }
    public function expireToken(Request $request){

        $data['token']      =  $user->createToken('MyApp',['guestuser'])->accessToken;
    }

/* ================================================================================= */
/* API FOR BOT */
/* ================================================================================= */
}
                                
   