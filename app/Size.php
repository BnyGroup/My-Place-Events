<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
     protected $fillable = [
        'name', 
        'code',
    ];

    public $timestamps = false;
}
