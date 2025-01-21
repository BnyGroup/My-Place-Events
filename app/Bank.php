<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $table =	'bankforms';

    protected $fillable	=	['fieldname','slug','type','placeholder','note'];


    public function getData()
    {
    	return static::orderBy('id')->get();
    }
    public function createData($input)
    {
    	return static::create(array_only($input,$this->fillable));
    }    
}
