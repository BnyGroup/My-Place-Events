<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class GuestUser extends Model
{
    protected $table = 'guest_user';
 	protected $fillable = [
		'guest_id', 'user_name', 'guest_email','cellphone'
    ];

    public function insertData($input) {
    	return static::create(array_only($input,$this->fillable));
    }
    public function updateData($input,$guest_id){
        return static::where('guest_id',$guest_id)->update(array_only($input,$this->fillable));
    }
    public function findData($guest_id) {
 		return static::where('guest_id',$guest_id)->first();
 	}
 	public function searchByEmail($guest_email) {
 		return static::where('guest_email',$guest_email)->first();
 	}
 	public function deleteData($guest_id) {
        return static::where('guest_id',$guest_id)->delete();
    }

    public function updateEmail($id, $newEmail){
        return static::where("guest_id",$id)->update(["guest_email" => $newEmail]);
    }

}
