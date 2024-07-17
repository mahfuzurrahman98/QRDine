<?php

namespace App\Services;

use Stripe\Stripe;
use App\Models\Order;
use Stripe\Checkout\Session;

class PaymentService {
    public function __construct(string $apiKey) {
        Stripe::setApiKey($apiKey);
    }

    public function createSession(
        array $items,
        string $currency = 'gbp',
        string $customerEmail,
        int $restaurantId,
        Order $order
    ) {
        // $order->coupon have below
        /*
        'coupon_id',
        'order_id',
        'coupon_type',
        'coupon_code',
        'value',
        'discount',
        */
        $successUrl = url()->route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}';
        $successUrl = $successUrl . '&restaurant_id=' . $restaurantId . '&order_id=' . $order->id;
        $cancelUrl = url()->route('payment.cancel');

        $lineItems = [];
        foreach ($items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => $currency,
                    'unit_amount' => round($item['price'] * 100), // Amount in cents
                    'product_data' => [
                        'name' => $item['name'],
                    ]
                ],
                'quantity' => $item['quantity'],
            ];
        }

        // Calculate the total amount of all items
        $totalAmount = array_reduce($items, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);

        // Apply the discount if any
        $discountAmount = 0;
        if ($order->coupon) {
            if ($order->coupon['coupon_type'] == 0) {
                // Percentage discount
                $discountAmount = ($totalAmount * $order->coupon['value']) / 100;
            } elseif ($order->coupon['coupon_type'] == 1) {
                // Flat discount
                $discountAmount = $order->coupon['value'];
            }
        }

        // Ensure the discounted total is not negative
        $discountedTotalAmount = max($totalAmount - $discountAmount, 0);

        // If a coupon is applied, create a single line item representing the total amount with the applied discount
        if ($order->coupon) {
            $lineItems = [
                [
                    'price_data' => [
                        'currency' => $currency,
                        'unit_amount' => round($discountedTotalAmount * 100), // Amount in cents
                        'product_data' => [
                            'name' => 'Total amount with ' .
                                ($order->coupon->coupon_type == 0
                                    ? $order->coupon->value . '%'
                                    : '£' . $order->coupon->value . 'flat') .
                                ' discount'
                        ]
                    ],
                    'quantity' => 1
                ]
            ];
        }

        try {
            $session = Session::create([
                'line_items' => $lineItems,
                'customer_email' => $customerEmail,
                'mode' => 'payment',
                'success_url' => $successUrl,
                'cancel_url' => $cancelUrl,
                'metadata' => [
                    'restaurant_id' => $restaurantId,
                    'order_id' => $order->id
                ]
            ]);

            return [
                'success' => true,
                'redirect_url' => $session->url
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    public function validatePayment(String $sessionId) {
        try {
            $session = Session::retrieve($sessionId);
            $payment['session_id'] = $session->id;
            $payment['amount'] = $session->amount_total;
            $payment['customer_name'] = $session->customer_details->name;
            $payment['customer_email'] = $session->customer_details->email;
            $payment['id'] = $session->payment_intent;
            $payment['currency'] = $session->currency;
            $payment['created'] = $session->created;
            $payment['metadata']['restaurant_id'] = $session->metadata['restaurant_id'];
            $payment['metadata']['order_id'] = $session->metadata['order_id'];

            return [
                'success' => true,
                'payment' => $payment
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
