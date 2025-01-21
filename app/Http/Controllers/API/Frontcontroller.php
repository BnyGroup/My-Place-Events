<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\UserController;
use Auth;
use Mail;
use App\ModalAPI\Frontuser;
use Validator;
use App\ModalAPI\ImageUpload;
use Hash;

class Frontcontroller extends UserController
{
    public $successStatus = 200;
    public function __construct()
    {
        $this->front_user = new Frontuser;
    }

    /* particular user profile edit  for api*/
 	public function usereditprofile()
 	{
        if (auth()->check()) {

           $user_id = Auth::user()->id;


          $data = $this->front_user->front_user_editdetail($user_id);
          $data['profile_pic'] = getImage($data->profile_pic);

            if (is_null($data)) {
                return response()->json(['msg'=>'No Content'],204);    
            }
            return response()->json($this->getSuccessResult($data),200);
        } else {

            return response()->json($this->getErrorMessage('462'));
        }
 	}
    public function userUpdate(Request $request)
    {
        if (auth()->check()) {

            $input = $request->all();
            $user_id = Auth::user()->id;

            $validator = Validator::make($input,[
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

            // dd($old_image);
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
                    $this->front_user->UpdatedataPro($user_id,$input);
                } else {
                    $input['profile_pic'] = $old_image;
                    $this->front_user->UpdatedataPro($user_id,$input);
                }
                $fdata = Frontuser::where('id',$user_id)->first();

                return response()->json($this->getSuccessResult(['msg' => 'Profile updated successfully.','profile_pic' => getImage($fdata->profile_pic),'firstname' => $fdata->firstname,'lastname' => $fdata->lastname,'cellphone' => $fdata->cellphone]),200);
            }else{
                return response()->json(['errors'=>$validator->errors()]);
            }
        }
    }
/*API Register front User */
    public function registeruser(Request $request)
    {
        $input = $request->all();
        
        $validator = Validator::make($input,[
                'email'=>'required|email|unique:frontusers',
                'firstname'=>'required',
                'lastname'=>'required',
                'password'=>'required|same:confirm_password',
                'confirm_password'=>'required',                     
            ]);
                if ($validator->passes())
                {
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

                    Mail::send('theme.user.mail',['userdata'=>$userdata],function($message) use ($mail)
                    {
                        $message->from(frommail(), forcompany());
                        $message->to($mail);
                        $message->subject(trans('words.msg.active_acc_a'));
                    });
                        $input['password'] = bcrypt($input['password']);
                        $input['remember_token'] = $tokens;
                        $data = $this->front_user->createData($input);
                         if (empty($data)) {
                                return response()->json(['msg'=>'No Content'],204);
                        }       
                         else {
                            return response()->json(['msg'=>'Register User Successfull...'],200);
                        }
                }
                else
                {
                return response()->json(['errors'=>$validator->errors()]);
                }
    }

         /* API For Forgot Password*/ 
         public function forgotpassword(Request $request){

                $input = $request->all();
                $validator = Validator::make($input,[
                    'email' => 'email|required|exists:frontusers,email',
                ]);

                if ($validator->passes())  {   
                    $data = $this->front_user->checkmail($input['email']);
                    $mail = array($request->email);

                Mail::send('theme.reset.mail',['userdata'=>$data],function($message) use ($mail)
                {
                    $message->from(frommail(), forcompany())->subject("Reset Password");
                    $message->to($mail);
                });

                    $post['data'] = array();
                    $post['message'] = 'Reset link send in ' . $input['email'];
                    $post['response'] = true;
                }
                else {
                    $post['data'] = array();
                    $post['message'] = $validator->errors()->first();
                    $post['response'] = false;
                }
            return response()->json($post);
        }
        
    /*Update Password*/
        public function password_update(Request $request) {
        // if (auth()->check()) {
                $user_id = Auth::guard('api')->user()->id;
                
                $input     = $request->all();
                $old_password   = $request->password;
            
                $validator = Validator::make($input,[
                    'password' => 'required',
                    'new_password' =>'required|same:repeat_new_password',
                    'repeat_new_password' =>'required',
                ]);
            if ($validator->passes()){ 
                $user = Frontuser::find($user_id);
                if(Hash::check($old_password, $user->password)) {   
                     $pwd = bcrypt($request->new_password);
                     $this->front_user->updateUserpwd($user_id,$pwd);
                     return response()->json(['msg'=>'Password is Update']);
                }else{
                     return response()->json(['msg'=>'Password is not update']);    
                     }
            }
            else {
                 return response()->json(['errors'=>$validator->errors()]);
                }
        // }
     }
 }
                                
   