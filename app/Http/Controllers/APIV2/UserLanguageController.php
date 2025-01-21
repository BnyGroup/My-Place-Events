<?php

namespace App\Http\Controllers\APIV2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\APIV2\UserController;

use App\ModalAPI\Frontuser;
use App\ModalAPI\UserLanguage;
use App\ModalAPI\Languages;
use Auth;

class UserLanguageController extends UserController
{
    public function __construct()
    {        
        $this->UserLanguage	= new UserLanguage;
        $this->Languages	= new Languages;
        $this->Frontuser 	= new Frontuser;
    }

    public function getUserLanguage($user_id) {
    	$getlist = $this->UserLanguage->getByUserId($user_id);
        if( $getlist->isEmpty() ){
            $language_list['0']['language_title']  = 'English';
            $language_list['0']['language_code']   = 'in';
        }else{
            foreach ($getlist as $key => $value) {
                $language_list[$key]['language_title']  = $value->language_title;
                $language_list[$key]['language_code']   = $value->language_code;            
            }
        }
    	$output     = $language_list;
        $message    = 'Language List';
        return $this->getSuccessResult($output,$message,true);
    }

}
