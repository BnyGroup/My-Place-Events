<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AluPayment extends Model
{
    //
    protected $table = 'alu_payment';
    protected $fillable = ['id_transaction','id_frontuser','id_alu','formule','montant','status','payment_gateway','payment_method','payment_phone_number','payment_designation',
        'payment_expire'];

    public function count_sousc_number($idfronuser,$idalu){
        return $count = static::where('id_frontuser',$idfronuser)
            ->where('id_alu',$idalu)
            ->count();
    }

    public function no_repeat_payment($id_transaction){
        $payment = static::where('id_transaction',$id_transaction)->first();
        if($payment == null):
            return 1;
        else:
            return 0;
        endif;
    }

    public function insertData($input)
    {
        return static::create(array_only($input,$this->fillable));
    }

}
