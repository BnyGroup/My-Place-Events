<?php

namespace App\ModalAPI;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Frontuser extends Authenticatable
{
	 use HasApiTokens, Notifiable;

	protected $guard = 'frontusers';
	
 	protected $fillable = ['firstname','lastname','status','profile_pic','gender','email','password','remember_token','cellphone','website','address','postalcode','country','state','city','reason','other_reason','social_id'];

 	protected $hidden = ['password','remember_token'];


    /*============================ API DATA ==========================*/

    public function front_user_editdetail($user_id)
    {
        return static::select('email','profile_pic','firstname','lastname','cellphone','website','address','city','postalcode','country','state')
                        ->where('id',$user_id)
                        ->first();
    }

    public function UpdatedataPro($id, $input)
    {
        return static::where('id',$id)->update(array_only($input,$this->fillable));
    }

 	public function createData($input)
 	{
 		return static::create(array_only($input,$this->fillable));
 	}

    public function checkmail($email)
    {
        return static::where('email',$email)->first();
    }

    public function updateUserpwd($id,$pwd)
    {
        return static::where('id',$id)->update(['password'=>$pwd]);
    }

    /*============================ API DATA ==========================*/

}