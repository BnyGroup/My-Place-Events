<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FrontController;
use App\Frontuser;
use App\GuestUser;
use App\ImageUpload;
use App\Bookmark;
use App\Booking;
use App\Bank;
use App\Bankdetail;
use Mail;
use File;
use Hash;
use Illuminate\Support\Facades\DB;
use Bavix\Wallet\Models\Transaction;
use Jenssegers\Date\Date;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends FrontController
{
    public function __construct()
	{
		parent::__construct();
        $this->frontUser = new Frontuser;
        $this->bookmark = new Bookmark;
        $this->booking = new Booking;
        $this->bank = new Bank;
        $this->bankDetials = new Bankdetail;
        $this->guestUser = new GuestUser;
	}

 	public function index(){
        $data = $this->frontUser->findData(auth()->guard('frontuser')->user()->id);
        $bank = $this->bank->getData();
        $bdet = $this->bankDetials->getData();
		$amountLastTransaction=0;
		$dateLastTransaction="";
		
        //wallet
        $frontuser_id = Auth::guard('frontuser')->id();

		if (optional($data->getWallet('default'))->id) {

			$q = $data->transactions
                                ->where('wallet_id', $data->getWallet('default')->id)
                                ->reverse()
                                ->first();
			if(!empty($q)){
				$amountLastTransaction=$q->amount;
				$dateLastTransaction=$q->created_at;
			}
			
        }else{
            $amountLastTransaction = 0;
            $dateLastTransaction = '';
        }

        $transactions = $data->transactions
                                ->where('wallet_id', optional($data->getWallet('default'))->id)
                                ->reverse()
                                ->take(5);

        $transactionsBonus = $data->transactions
                            ->where('wallet_id', optional($data->getWallet('bonus'))->id)
                            ->reverse()
                            ->take(5);


        $tickets = DB::table('order_payment')->where('payment_user_id', $frontuser_id)->orderBy('created_at', 'desc')->get();


       $bd = array();
        foreach ($bdet as $key => $dvalue) {
            $bd[$dvalue->field] = $dvalue->value;
        }
 		return view('theme.user.user-profile',compact('data','bank','bd','amountLastTransaction','dateLastTransaction','transactions','transactionsBonus'));
 	}

 	public function user_tickets(){
 		return view('theme.user.user-tickets');
 	}

 	public function front_login(){
        return view('theme.user.user-login');
    }

 	public function user_signup(){
        if (auth()->guard('frontuser')->check()) {
            return redirect()->back();
        }else{
            return view('theme.user.user-signup');
        }
    }

    public function store(Request $request){
        $input = $request->all();
        $this->validate($request,[
            'firstname'=>'required',
            'lastname'=>'required',
            'email'=>'required|email|unique:frontusers',
            'password'=>'required|same:confirm_password',
            'confirm_password'=>'required',
        ]);

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

        $input['password'] = bcrypt($request->password);
        $input['remember_token'] = $tokens;
        $data = $this->frontUser->createData($input);
        try {
            Mail::send('theme.user.mail',['userdata'=>$userdata],function($message) use ($mail)
            {
                $message->from(frommail(), forcompany());
                $message->to($mail);
                $message->subject(trans('words.msg.active_acc_a'));
            });
        } catch (\Exception $e) {
            return redirect()->route('user.login')->with('success',trans('words.msg.cnf_link_to') . $input['email']. trans('words.msg.cnf_link_to_last'));
        }
        return redirect()->route('user.login')->with('success',trans('words.msg.cnf_link_to') . $input['email']. trans('words.msg.cnf_link_to_last'));
    }
	
	public function storeAjax(Request $request){
      
		$input = $request->all();         
		$validator = Validator::make($request->all(), [
           	  'firstname'=>'required',
           	  'lastname'=>'required',
          	  'email'=>'required|email|unique:frontusers',
          	  'password'=>'required|same:confirm_password',
          	  'confirm_password'=>'required',
       		 ]);
		
		
	    if ($validator->fails()){
            	return response()->json([
                    "status" => false,
                    "errors" => $validator->errors()
                ]);
            }

        $tokens = str_random(60);
        $mail = [$request->email];

        $userdata = array();
        $userdata = [
            'firstname'     => $input['firstname'],
            'lastname'      => $input['lastname'],
            'email'         => $input['email'],
            'cellphone'     => $input['mobile'],
            'remember_token'=>  $tokens,
        ];
        $userdata = (object) $userdata;

        $input['password'] = bcrypt($request->password);
        $input['remember_token'] = $tokens;
        $data = $this->frontUser->createData($input);
		
        try {
            Mail::send('theme.user.mail',['userdata'=>$userdata],function($message) use ($mail)
            {
                $message->from(frommail(), forcompany());
                $message->to($mail);
                $message->subject(trans('words.msg.active_acc_a'));
            });
			
		return response()->json([
                    "status" => true,
                    "success" => ["Votre compte a été créé avec succès. ".trans('words.msg.cnf_link_to') . $input['email']. trans('words.msg.cnf_link_to_last')]
                ]);
			
        } catch (\Exception $e) {     
			return response()->json([
                    "status" => true,
                    "success" => ["Votre compte a été créé avec succès. ".trans('words.msg.cnf_link_to') . $input['email']. trans('words.msg.cnf_link_to_last')]
                ]);
        }
			return response()->json([
                    "status" => true,
                    "success" => ["Votre compte a été créé avec succès. ".trans('words.msg.cnf_link_to') . $input['email']. trans('words.msg.cnf_link_to_last')]
                ]);
    }

    public function activation($token) {

       $data = $this->frontUser->avtivation($token);

       if (is_null($data)) {
            return redirect()->route('user.login')->with('error',trans('words.msg.exper_lnia'));
       }

       $datas = $this->frontUser->tokenUpdate($data->id);
       return redirect()->route('user.login')->with('success',trans('words.msg.exper_active'));
    }

    public function update_pro(Request $request) {

        $input = $request->all();
        $id = $request->id;

        $this->validate($request,[
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

        $path   = 'public/upload/front/'.date('Y').'/'.date('m');
        $upath  = 'upload/front/'.date('Y').'/'.date('m');

        if (!is_dir(public_path($upath))) {
            File::makeDirectory(public_path($upath),0777,true);
        }

        if (!empty($request->file('profile_pic'))) {
            $iinput['image'] = ImageUpload::upload($upath,$request->file('profile_pic'),'userprofile');
            ImageUpload::uploadThumbnail($upath,$iinput['image'],200,200);


                if (!empty($input['old_image'])) {
                    $data = image_delete($input['old_image']);
                    $path = $data['path'];
                    $image = $data['image_name'];
                    $image_thum = $data['image_thumbnail'];
                    ImageUpload::removeFile($path,$image,$image_thum);
                }

            $input['profile_pic'] = save_image($upath,$iinput['image']);
            $this->frontUser->UpdatedataPro($id,$input);
        } else {
            $input['profile_pic'] = $input['old_image'];
            $this->frontUser->UpdatedataPro($id,$input);
        }
        return redirect()->route('users.pro','profile')->with('success',trans('words.msg.profie_update'));
    }

    public function password_update_pro(Request $request) {
        $input = $request->all();
        $id    = $request->id;
        $user  = Frontuser::find($id);

        if(isset(\Auth::guard('frontuser')->user()->password)){
                $old_password   = $request->password;
                $this->validate($request,[
                    'password' => 'required',
                    'new_password' =>'required|same:repeat_new_password',
                    'repeat_new_password' =>'required',
                ]);

                if(Hash::check($old_password, $user->password))
                {
                    $pwd = bcrypt($request->new_password);
                    $this->frontUser->updateUserpwd($id,$pwd);
                    return redirect()->route('users.pro','buzz')->with('success',trans('words.msg.pawd_update'));
                } else {
                    return redirect()->route('users.pro','buzz')->with('error',trans('words.msg.old_update'));
                }
        }else{
             $this->validate($request,[
                    'new_password' =>'required|same:repeat_new_password',
                    'repeat_new_password' =>'required',
                ]);

                if(isset($request->new_password)):
                    $pwd = bcrypt($request->new_password);
                    $this->frontUser->updateUserpwd($id,$pwd);
                    return redirect()->route('users.pro','buzz')->with('success',trans('words.msg.pawd_update'));
                else:
                    return redirect()->route('users.pro','buzz')->with('error',trans('words.msg.old_update'));
                endif;
        }


    }

    public function close(Request $request) {
        $input = $request->all();
        $password = $request->password;
        $id = $request->id;

        $this->validate($request,[
            'password' => 'required',
            'reason' =>'required',
        ]);

        $res = $request->reason;
        $other_res = $request->other_reason;
        $user = Frontuser::find($id);

        if(Hash::check($password, $user->password))
        {
            if($input['reason'] == 8) {
                $this->validate($request,[
                    'other_reason' => 'required',
                ]);
                $this->frontUser->close($id,$res,$other_res);
                auth()->guard('frontuser')->logout();
            } else {
                $this->frontUser->close($id,$res,$other_res);
                auth()->guard('frontuser')->logout();
            }
            return redirect()->route('index')->with('success',trans('words.msg.accou_succes'));
        }else{
            return redirect()->route('users.pro','profile')->with('error',trans('words.msg.pes_not_match'));
        }
    }

    public function bookmark() {
        $id = auth()->guard('frontuser')->user()->id;
        $bookdata = $this->booking->getOrderlist($id);
        $past = $this->booking->getOrderpast($id);
        $data = $this->bookmark->getlists($id);
        $savedcount = $this->bookmark->saved_events($id);
        $upcount = $this->booking->upCounts($id);
        $pasteve = $this->booking->pastCounts($id);
        return view('theme.bookmark.bookmark',compact('data','savedcount','bookdata','past','upcount','pasteve'));
    }

    public function bankDetials(Request $request)
    {
        $input = $request->all();

        foreach($input as $key => $value) {
            $rules["{$key}"] = 'required';
        }

        $this->validate($request, $rules);

        $input = array_except($input, array('_token'));

        $id = (auth()->guard('frontuser')->check()?auth()->guard('frontuser')->user()->id:'');

        $data = Bankdetail::where('user_id',$id)->get();

        if (!empty($data)) {
            Bankdetail::where('user_id',$id)->where('field','!=','paypal_payment_email')->delete();
        }
            foreach ($input as $key => $value) {
                $data = [];
                $data['user_id'] = $id;
                $data['field'] = $key;
                $data['value'] = $value;
                $this->bankDetials->createData($data);
            }
        // }else{
        //     foreach ($input as $key => $value) {
        //         $data = [];
        //         $data['user_id'] = $id;
        //         $data['field'] = $key;
        //         $data['value'] = $value;
        //         $this->bankDetials->createData($data);
        //     }
        // }
        return redirect()->back()->with(['bank' => 'Bank Details is Successfully Updated.']);
    }

    public function paypalEmail(Request $request)
    {
        $input = $request->all();

        $this->validate($request,[
            'paypal_payment_email' => 'required'
        ]);
        $input = array_except($input, array('_token'));
        $id = (auth()->guard('frontuser')->check()?auth()->guard('frontuser')->user()->id:'');
        $data = Bankdetail::where('user_id',$id)->where('field','paypal_payment_email')->get();

        if (!empty($data)) {
            Bankdetail::where('user_id',$id)->where('field','paypal_payment_email')->delete();
        }
        $data = [];
        $data['user_id']    = $id;
        $data['field']      = 'paypal_payment_email';
        $data['value']      = $input['paypal_payment_email'];
        $this->bankDetials->createData($data);
        return redirect()->back()->with(['bank' => 'PayPal Email is Successfully Updated.']);
    }

    public function updateGuestEmail($id, $newEmail)
    {
        $this->guestUser->updateEmail($id, $newEmail);
        return "success";
    }

    public function updateUserEmail($oldEmail, $newEmail)
    {
        $this->guestUser->updateEmail($oldEmail, $newEmail);
        return "success";
    }

}
