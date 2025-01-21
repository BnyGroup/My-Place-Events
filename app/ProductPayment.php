<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class ProductPayment extends Model
{
  	protected $table = 'product_payment';
 	protected $fillable = ['payment_user_id','id_transaction','payment_product_id','payment_order_id','payment_amount','payment_currency','payment_status','payment_gateway','stripe_id','failure_code','failure_message','message','payment_state','payment_method','payment_number'];

 	public function insertData($input) {
    	return static::create(array_only($input,$this->fillable));
    }

    public function no_repeat_payment($id_transaction){
 	    $payment = static::where('id_transaction',$id_transaction)->first();
 	    if($payment == null):
            return 1;
 	    else:
            return 0;
 	    endif;
    }

    public function get_data($order_id){
        return static::where('id_transaction',$order_id)->first();
    }

    public function get_order_payment($id){
        return static::where('payment_user_id', $id)->get();
    }

}
