<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ImageUpload;
use DB;

class BannerImmanquables extends Model
{
    //
    protected $table = 'banner_immanquables';
    protected $fillable = ['title','description','image','statut'];

    public function getData(){
        return static::get();
    }


}