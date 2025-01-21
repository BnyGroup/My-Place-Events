<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormulePrestataire extends Model
{
    //
    protected $table = 'formule_prestataires';
    protected  $fillable = ['formule','montant'];

    public function getData(){
        return static::get();
    }
}
