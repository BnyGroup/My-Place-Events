<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Traits\HasWallets;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\CanPay;
use Bavix\Wallet\Interfaces\Customer;
use Bavix\Wallet\Models\Transaction;
use DB;

class Frontuser extends Authenticatable implements Wallet, Customer
{
	use HasApiTokens, Notifiable;
	use HasWallet, CanPay, HasWallets;

	protected $guard = 'frontusers';

 	protected $fillable = ['firstname','lastname','status','profile_pic','gender','email','password','oauth_uid','oauth_provider','token','remember_token','cellphone','website','address','postalcode','country','state','city','reason','other_reason','social_id'];

 	protected $hidden = ['password','remember_token'];

 	public function createData($input)
 	{
 		return static::create(array_only($input,$this->fillable));
 	}
 	public function avtivation($token)
 	{
 		return static::where('remember_token',$token)->first();
 	}
 	public function tokenUpdate($id)
 	{
 		return static::where('id',$id)->update(['status'=>1,'remember_token'=>str_random(60)]);
 	}
 	public function checkmail($email)
 	{
 		return static::where('email',$email)->first();
 	}
 	public function password_update($token,$password)
 	{
 		return static::where('remember_token',$token)->update(['password' => $password]);
 	}
 	public function tokeUpdate($email,$token)
 	{
 		return static::where('email',$email)->update(['remember_token' => $token]);
 	}
 	public function findData($id)
 	{
 		return static::where('id',$id)->first();
 	}
 	public function UpdatedataPro($id, $input)
 	{
 		return static::where('id',$id)->update(array_only($input,$this->fillable));
 	}
 	public function updateUserpwd($id,$pwd)
 	{
 		return static::where('id',$id)->update(['password'=>$pwd]);
 	}
    
 	public function close($id,$res,$other_res)
 	{
 		return static::where('id',$id)->update(['status' => 2,'reason'=>$res,'other_reason'=>$other_res]);
 	}
    
 	public function fetchData()
 	{
 		return static::get();
  	}
    
 	public function CountAll()
 	{ 
        $x=DB::table('frontusers')->count();
 		return $x;
  	}    
    
 	public function getUserList()
 	{
 		return static::select('frontusers.*')
 		->orderBy('id','desc')
 		->take(8)
 		->get();
 	}
 	public function AauthAcessToken(){
    	return $this->hasMany('\App\OauthAccessToken');
	}

	public function deleteData($id)
    {
        $data = static::where('id',$id)->first();
        if($data['oauth_provider'] != null && stristr($data['profile_pic'],'https')){
            /*$pathlink = ($data['profile_pic']==null)?null:explode('/',$data);
            if($pathlink != null){
                for($i=0;$i<=5;$i++){
                    $pathArray[] = $pathlink[$i];
                }
            $path = implode('/',$pathArray);*/
            File::delete($data['profile_pic']);

        }

        if($data['oauth_provider'] == null && !empty($data['profile_pic']))
        {
          $datas = image_delete($data['profile_pic']);
            $path = $datas['path'];
            $image = $datas['image_name'];
            $image_thum = $datas['image_thumbnail'];
            ImageUpload::removeFile($path,$image,$image_thum);
        }else{
            return $data->delete();
        }
        return $data->delete();
    }

    /*select particular user profile edit for api*/
    public function front_user_editdetail($user_id)
    {
        return static::select('email','profile_pic','firstname','lastname','cellphone','website','address','city','postalcode','country','state')
                        ->where('id',$user_id)
                        ->first();
    }

	public static function getBonus($bonus)
	{
		return $bonus;
	}


}