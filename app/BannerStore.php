<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ImageUpload;
use DB;

class BannerStore extends Model
{
    //
    protected $table = 'banner_store';
    protected $fillable = ['title','description','image','position','statut'];

    public function getData(){
        return static::get();
    }


}