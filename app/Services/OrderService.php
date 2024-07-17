<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Coupon;
use App\Models\CouponOrder;

class OrderService {
    public function create(array $data): Order {
        $amount = 0;
        foreach ($data['items'] as $item) {
            $amount += $item['price'] * $item['quantity'];
        }

        $order = Order::create([
            'restaurant_id' => $data['restaurantId'],
            'dinein_table_id' => $data['tableId'],
            'customer_name' => $data['customer']['name'],
            'customer_phone' => $data['customer']['phone'],
            'customer_email' => $data['customer']['email'],
            'items' => json_encode($data['items']),
            'amount' => $amount,
            'payment_method' => $data['paymentMethod'],
            'status' => 0,
        ]);

        $coupon = $data['coupon'];
        if ($coupon) {
            $couponOrder = new CouponOrder([
                'order_id' => $order->id,
                'coupon_id' => $coupon->id,
                'coupon_type' => $coupon->type, // Assuming 'type' is defined in Coupon model
                'coupon_code' => $coupon->code,
                'value' => $coupon->value, // Assuming 'value' is the amount to be applied,
                'discount' => $data['discount'],
            ]);
            $couponOrder->save();

            // find the coupon and increment the used column
            $coupon->increment('used');
        }

        return $order;
    }
}
