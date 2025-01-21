<?php

namespace App;

class CouponEnum
{
    /**
     * Return values for discount_on field
     */
    public static function discountOptions()
    {
        return [
            'all' => __('Tous les évènements'),
            'category' => __('Toutes les Catégories d\'évènements'),
            'product' => __('Un évènement précis'),
        ];
    }
}
