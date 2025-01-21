<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrestataireCategory extends Model
{
    //
    protected $table = 'prestataire_category';
    protected $fillable = ['category_name','category_slug','category_description','category_image','category_status'];

    public function getCatList(){
        return static::orderBy('id','DESC')
        ->get();
    }

}
