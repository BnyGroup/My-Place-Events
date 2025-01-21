<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bankdetail extends Model
{
    protected $table = 'bankdetails';

    protected $fillable = ['user_id','field','value'];

    public function createData($input)
    {
    	return static::create(array_only($input,$this->fillable));
    }
    public function getData()
    {	
    	$id = auth()->guard('frontuser')->check()?auth()->guard('frontuser')->user()->id:'';
    	return static::where('user_id',$id)->get();
    }
}
