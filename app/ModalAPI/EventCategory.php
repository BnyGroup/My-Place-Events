<?php

namespace App\ModalAPI;

use Illuminate\Database\Eloquent\Model;
use DB;

class EventCategory extends Model
{
	protected $table = 'event_category';
 	protected $fillable = [
        'category_name', 'category_slug', 'category_parent', 'category_description', 'category_image', 'category_status'
    ];

    /*============================ API DATA ==========================*/

    public function child() {
        return $this->hasMany('App\EventCategory','category_parent')->select('id','category_name','category_slug','category_parent');
    }
    public function get_Category_eventAPI() {
       return static::with('child')->select('id','category_name','category_slug','category_parent')->whereNull('category_parent')->get();
    }

    /*============================ API DATA ==========================*/
}
