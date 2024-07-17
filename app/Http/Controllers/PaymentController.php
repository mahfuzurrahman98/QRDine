<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Restaurant;
use App\Services\CartService;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller {
    public function success(Request $request) {
        $sessionId = $request->input('session_id');
        $restaurantId = $request->input('restaurant_id');
        $orderId = $request->input('order_id');

        if (!$sessionId || !$restaurantId || !$orderId) {
            abort(404, 'Payment not found');
        }

        $restaurant = Restaurant::find($restaurantId);
        if (!$restaurant) {
            abort(404, 'Restaurant not found');
        }

        $order = Order::find($orderId);
        if (!$order) {
            abort(404, 'Order not found');
        }

        if ($order->status != 0) {
            abort(403, 'This order is already paid');
        }

        $paymentService = new PaymentService($restaurant->stripe_id);
        $data = $paymentService->validatePayment($sessionId);

        if ($data['success']) {
            $stripePayment = $data['payment'];
            // dd($stripePayment);

            if (
                $order->payment_method == 'card' && // its a card payment
                $order->payment_id == null && // not yet paid
                $order->status == 0 // order is just placed
            ) {
                try {
                    // begin database transaction
                    DB::beginTransaction();

                    // create payment
                    $payment = Payment::create([
                        'stripe_id' => $restaurant->stripe_id,
                        'session_payment_created' => $stripePayment['created'],
                        'session_id' => $stripePayment['session_id'],
                        'session_payment_id' => $stripePayment['id'],
                        'customer_email' => $stripePayment['customer_email'],
                        'customer_name' => $stripePayment['customer_name'],
                        'currency' => $stripePayment['currency'],
                        'amount' => $stripePayment['amount'],
                    ]);

                    // we will update the order
                    $order->status = 5;
                    $order->payment_id = $payment->id;
                    $order->save();

                    // commit database transaction
                    DB::commit();

                    // clear cart
                    $cartService = new CartService();
                    $cartService->clear();

                    $restaurantUrl = route('restaurants.show', ['slug' => $restaurant->slug]);
                    // add query params to redirect
                    $restaurantUrl .= "?order_status=5&order_id={$orderId}&payment_method=card&payment_id={$payment->id}";
                    return redirect($restaurantUrl);
                } catch (\Throwable $th) {
                    // rollback database transaction
                    DB::rollBack();
                    dd($th);
                }
            }
        } else {
            dd($data['message']);
        }
    }

    public function cancel(Request $request) {
    }
}
