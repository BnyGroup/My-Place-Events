<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class EventCategory extends Model
{
	protected $table = 'event_category';
 	protected $fillable = [
        'category_name', 'category_slug', 'category_parent', 'category_description', 'category_image', 'category_status'
    ];

    public function getCategBySlug($slug)
    {
        return static::where('category_slug',$slug)
            ->first();
    }

 	public function getAll()
    {        
        return static::get()->toArray();
    }

    public function children() {
        return $this->hasMany('App\EventCategory','category_parent');
    }
    public function get_Category_event() {
       return static::with('children')->whereNull('category_parent')->where('category_status',1)->get();
    }

    public function child() {
        return $this->hasMany('App\EventCategory','category_parent')->select('id','category_name','category_slug','category_parent');
    }
    public function get_Category_eventAPI() {
       return static::with('child')->select('id','category_name','category_slug','category_parent')->whereNull('category_parent')->get();
    }

    public function getChildCategory($category_parent) {
        return static::where('category_parent', $category_parent)->pluck('id');
    }

    public function getCategorylist()
    {
    	return static::whereNull('category_parent')->pluck('category_name','id');
    }

    public function getSingleCategory($id)
    {
    	return static::where('id',$id)->first();
    }

    public function insertData($input)
    {    	
    	return static::create(array_only($input,$this->fillable));
    }
    public function updatData($input, $id)
    {
    	return static::find($id)->update(array_only($input,$this->fillable));
    }
    public function getList()
    {
        return static::whereNull('category_parent')->take(7)->get();
    }

    public function getAllList()
    {
        return static::whereNull('category_parent')->get();
        /*return $data = DB::table("event_category")
            ->select("events.*",
                DB::raw("(SELECT event_category FROM events
                WHERE event_category.id = events.event_category)"))
        ->where('event_status', 1)
            ->get();*/

    }
    public function checkSubcat($id)
    {
        return static::where('category_parent',$id)->first();
    }
    public function findCategories($url){
        return static::select('id')->where('category_parent',$url)->pluck('id')->toArray();
    }

}
