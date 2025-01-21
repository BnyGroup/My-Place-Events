<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = ['name','email','subject','user_id','message'];

    protected $table = 'contacts';

    public function createData($input)
    {
    	return static::create(array_only($input,$this->fillable));
    }
    public function getData()
    {
    	return static::get();
    }
}
