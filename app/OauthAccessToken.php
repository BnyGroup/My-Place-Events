<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OauthAccessToken extends Model
{
	protected $table = 'oauth_access_tokens';
	
    public function removes($id)
    {
    	return static::where('user_id',$id)->delete();
    }
}
