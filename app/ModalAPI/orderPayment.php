<?php

namespace App\ModalAPI;

use Illuminate\Database\Eloquent\Model;
use DB;

class OrderPayment extends Model
{
  	protected $table = 'order_payment';
 	protected $fillable = ['payment_user_id','payment_order_id','payment_event_id','payment_amount','payment_currency','payment_status','payment_gateway','stripe_id','failure_code','failure_message'];

 	 /*============================ API DATA ==========================*/
 	public function insertData($input) {
    	return static::create(array_only($input,$this->fillable));
    }
 	 /*============================ API DATA ==========================*/
}
