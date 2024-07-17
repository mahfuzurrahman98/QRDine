<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CouponOrder extends Model {
    use HasFactory;

    protected $fillable = [
        'coupon_id',
        'order_id',
        'coupon_type',
        'coupon_code',
        'value',
        'discount',
    ];
}
