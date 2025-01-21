<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLanguage extends Model
{
    protected $table =	'user_language';
    protected $fillable	=	['user_id','user_email','language'];

    public function getData() {
    	return static::orderBy('user_id')->get();
    }
    public function getByUserId($user_id){
    	return static::select('user_language.*','languages.language_title','languages.language_code')
            ->join('languages','user_language.language','=','languages.id')
            ->where('user_id',$user_id)
            ->get();
    }
    public function checkedUserLanguage($user_id,$languages){
    	return static::select('user_language.*','languages.language_title','Languages.language_code')
    	->join('languages','user_language.language','=','languages.id')
    	->where('user_language.user_id',$user_id)
    	->where('user_language.language', $languages)
    	->first();
    }
    public function createData($input) {
    	return static::create(array_only($input,$this->fillable));
    }
    public function updateData($input,$user_id) {
        return static::where('user_id',$user_id)->update(array_only($input,$this->fillable));
    }
    public function deleteBooking($user_id) {
        return static::where('user_id',$user_id)->delete();
    }

}
