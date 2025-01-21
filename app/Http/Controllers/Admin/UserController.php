<?php



namespace App\Http\Controllers\admin;



use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Http\Controllers\Admin\AdminController;

use App\User;

use App\ImageUpload;

use Hash;

use File;



class UserController extends AdminController

{

    public function __construct() {

    	parent::__construct();

    	$this->user = new User;

    }



    public function index() {

    	return view('Admin.user.profile',compact('data'));

    }



    public function update_profile(Request $request){ 



        $input = $request->all();

        $id = $request->id;



        $this->validate($request,[

         'firstname' => 'required',

         'lastname'  => 'required',

         'image'     => 'mimes:png,jpg,jpeg',

        ]);    

        $path = 'upload/admin/'.date('Y').'/'.date('m'); 
        if (!is_dir(public_path($path))) {
            File::makeDirectory(public_path($path),0777,true);
        }
        if (!empty($request->file('image'))) {
            $iinput['image'] = ImageUpload::upload($path,$request->file('image'),'userprofile');
            ImageUpload::uploadThumbnail($path,$iinput['image'],200,200);
                
                if (!empty($input['old_image'])) {
                    $data = image_delete($input['old_image']);
                    $path = $data['path'];
                    $image = $data['image_name'];
                    $image_thum = $data['image_thumbnail'];
                    ImageUpload::removeFile($path,$image,$image_thum);
                }
            $input['profile_pic'] = save_image($path,$iinput['image']);
            $data = $this->user->updateUserData($input, $id);
        }
        else
        {
            $input['profile_pic'] = $input['old_image'];
            $data = $this->user->updateUserData($input, $id);   
        }
    		return redirect()->route('user.index')->with('success', 'Profile is Updated.');
    }



    

    public function update_password(Request $request){

    	$input 			= $request->all();

    	$id 			= $request->id;

    	$old_password	= $request->old_password;



    	$this->validate($request,[

    		'password' => 'required|same:reenter_password',

    		'reenter_password' => 'required',

    		'old_password' => 'required',



    	]);

    	$user = User::find($id);    	



		if(Hash::check($old_password, $user->password))

        {	

        	$pwd = bcrypt($request->password);

        	$this->user->updateUserpwd($pwd, $id);

            return redirect()->route('user.index')->with('success_pass', 'Password is Updated.');

        }

        else

        {

            return redirect()->route('user.index')->with('error_pass', 'Old Password not Match.');

        }







    }

}

