<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormuleService extends Model
{
    //
    protected $table = 'formule_service';
    protected  $fillable = ['nom_service','id_service','type_service','periode_service','montant_service'];

    public function getData(){
        return static::get();
    }

    public function getdatabyservicetype($id){
        return static::where('id_service',$id)->first();
    }
}