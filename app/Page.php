<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{	
	protected $table = 'pages';
	protected $fillable = ['page_title','page_slug','page_desc','page_image','page_status','title','keyword','description'];

    public function createData($input)
    {
    	return static::create(array_only($input,$this->fillable));
    }
    public function getList()
    {
    	return static::get();
    }
    public function updateData($slug,$input)
    {
        return static::where('page_slug',$slug)->update(array_only($input,$this->fillable));
    }
    public function getfootermenu()
    {
        return static::select('pages.*')
        ->join('menus','menus.menu_link','=','pages.id')
        ->where('menu_type','footer')
        ->orderBy('menus.menu_order','asc')
        ->get();
    }
    public function getDataWithSlug($slug)
    {
        return static::select('page_title','page_desc')
                    ->where('page_slug',$slug)
                    ->first();
    }
   
}
