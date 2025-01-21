<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Hit extends Model
{
    protected $fillable = ['event_id','ip'];    

    public function countInsert($input)
    {
    	return static::create(array_only($input,$this->fillable));
    }
    public function hits($id)
    {
    	//dd(\Request::ip());
    	return static::where('event_id',$id)->where('ip',\Request::ip())->first();    	
    }
    public function countUpdate($id,$co)
    {
    	return static::where('event_id',$id)->update(['hits' => $co]);
    }
}
