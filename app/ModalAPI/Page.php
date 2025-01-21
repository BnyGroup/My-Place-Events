<?php

namespace App\ModalAPI;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{	
	protected $table = 'pages';
	protected $fillable = ['page_title','page_slug','page_desc','page_image','page_status','title','keyword','description'];

    /*============================ API DATA ==========================*/
    public function getDataWithSlug($slug)
    {
        return static::select('page_title','page_desc')
                    ->where('page_slug',$slug)
                    ->first();
    }
    /*============================ API DATA ==========================*/
}
