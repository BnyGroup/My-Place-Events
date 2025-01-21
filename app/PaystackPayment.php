<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaystackPayment extends Model
{
    //
    protected $filables = ['email','order_id','amount', 'status', 'trans_id','ref_id'];
}
