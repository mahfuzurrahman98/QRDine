<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model {
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type',
        'value',
        'valid_from',
        'valid_to',
        'limit',
        'used',
        'restaurant_id',
        'active'
    ];

    public function orders() {
        return $this->belongsTo(CouponOrder::class, 'id', 'coupon_id');
    }
}
