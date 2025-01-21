<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class EventTicketsCoupon extends Model
{
    protected $fillable = [
        'title',
        'code',
        'discount',
        'discount_type',
        'discount_on',
        'discount_on_details',
        'expire_date',
        'status'
    ];
}
