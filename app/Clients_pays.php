<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Clients_pays extends Model
{
    protected $table = 'clients_pays';
 	protected $fillable = [
        'guestUserPhone', 'guestuserName', 'guestUserEmail', 'confirmguestUserEmail',
     ];


}
