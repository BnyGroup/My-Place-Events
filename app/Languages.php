<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Languages extends Model
{
    protected $table =	'languages';
    protected $fillable	=	['language_title','language_code'];

    public function getData() {
    	return static::orderBy('language_title')->get();
    }
    public function createData($input) {
    	return static::create(array_only($input,$this->fillable));
    }
    public function updateData($input,$id) {
        return static::where('id',$id)->update(array_only($input,$this->fillable));
    }
    public function deleteBooking($id) {
        return static::where('id',$id)->delete();
    }
}
