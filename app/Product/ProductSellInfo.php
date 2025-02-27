<?php

namespace App\Product;

use App\Shipping\UserShippingAddress;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSellInfo extends Model
{
    use HasFactory;
    protected $fillable = [
        'fisrtname',
		'lastname',
        'email',
        'user_id',
        'country',
        'address',
        'city',
        'phone',

        'product_id',
        'total_amount',
        'status',

        'payment_status',
        'payment_gateway',
        'payment_track',
        'transaction_id',
        'checkout_image_path',

        'order_details',
        'shipping_address_id',
        'payment_meta',

        'selected_shipping_option'
    ];

    public function shipping()
    {
        return $this->hasOne(UserShippingAddress::class, 'id', 'shipping_address_id');
    }
}
