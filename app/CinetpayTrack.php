<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Carbon\Carbon;

// Tentative de reservation
class CinetpayTrack extends Model
{
    //protected $primaryKey = 'id';
    protected $fillable = [
        'payment_method', 'telephone', 'num_transaction',
        'code_erreur', 'message','designation','data_track'
    ];

    public function insertData($input) {
        return static::create(array_only($input,$this->fillable));
    }

    public function updateData($input,$orderId){

        return static::where('order_id',$orderId)->update(array_only($input,$this->fillable));
    }

}
