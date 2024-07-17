<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model {
    use HasFactory;

    protected $fillable = [
        'restaurant_id', 'dinein_table_id', 'payment_method',
        'items', 'amount', 'status', 'items',
        'customer_name', 'customer_email', 'customer_phone',
    ];

    // define relationships
    public function restaurant() {
        return $this->belongsTo(Restaurant::class);
    }

    public function dineinTable() {
        return $this->belongsTo(DineinTable::class);
    }

    // items is basically a json consisting of an array of items_id
    // can we make an attribute for this so that we can get items as an array of real items object

    // define methods
    protected function items(): Attribute {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                return json_decode($attributes['items'], true);
            }
        );
    }

    public function payment() {
        // order has payment id, but in case of cash payment, payment id is null
        // an order can have payment, or not based on payment_method
        // payments table has nothing related to an order but order table might have payment_id
        return $this->belongsTo(Payment::class);
    }

    // I have a pivot table coupon_order. One coupon can be applied to multiple orders
    // But a specific order can only have one coupon
    // now make attribute to find coupon for a specific order


    public function coupon() {
        // CouponOrder table has both order_id and coupon_id
        return $this->hasOne(CouponOrder::class, 'order_id', 'id');
    }
}
