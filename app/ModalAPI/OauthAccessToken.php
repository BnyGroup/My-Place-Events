<?php

namespace App\ModalAPI;

use Illuminate\Database\Eloquent\Model;

class OauthAccessToken extends Model
{
	protected $table = 'oauth_access_tokens';
	
	 /*============================ API DATA ==========================*/
    public function removes($id)
    {
    	return static::where('user_id',$id)->delete();
    }
     /*============================ API DATA ==========================*/
}
