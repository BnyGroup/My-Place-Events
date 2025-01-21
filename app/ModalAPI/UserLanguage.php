<?php

namespace App\ModalAPI;

use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model
{
    protected $table =	'user_language';
    protected $fillable	=	['user_id','user_email','language'];

    
    /*============================ API DATA ==========================*/
    public function getByUserId($user_id){
    	return static::select('user_language.*','languages.language_title','languages.language_code')
            ->join('languages','user_language.language','=','languages.id')
            ->where('user_id',$user_id)
            ->get();
    }
    /*============================ API DATA ==========================*/  
}
