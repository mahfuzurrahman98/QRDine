<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Item;
use App\Models\Order;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller {
    public function index(Request $request) {
        $restoId = auth()->user()->restaurant->id;

        $orders = Order::where('restaurant_id', $restoId);

        // Apply optional search filters from request parameters
        $dateFrom = $request->get('date_from');
        $dateTo = $request->get('date_to');
        $status = $request->has('status') ? $request->get('status') : '';
        $paymentMethod = $request->get('payment_method');

        if ($dateFrom && $dateTo) {
            $orders->whereBetween('created_at', [$dateFrom, $dateTo]);
        } elseif ($dateFrom) {
            $orders->where('created_at', '>=', $dateFrom);
        } elseif ($dateTo) {
            $orders->where('created_at', '<=', $dateTo);
        }
        if ($status && $status !== '') {
            $orders->where('status', $status);
        }
        if ($paymentMethod) {
            $orders->where('payment_method', $paymentMethod);
        }

        $orders = $orders->latest()->paginate(10);

        return view('orders.index', ['orders' => $orders]);
    }

    public function show(int $id) {
        $order = Order::find($id);
        if (!$order) {
            return redirect()->back()->withError('Order not found');
        }
        return view('orders.show', ['order' => $order]);
    }

    public function store(Request $request) {
        // Now we need to validate the request
        $validator = Validator::make($request->all(), [
            'restaurantId' => 'required|integer|exists:restaurants,id',
            'tableId' => 'required|integer|exists:dinein_tables,id',
            'cart' => 'required|array',
            'cart.*.itemId' => 'required|integer|exists:items,id',
            'cart.*.quantity' => 'required|integer|min:1',
            'customer.name' => 'required|string|max:255',
            'customer.phone' => 'required|string|max:255',
            'customer.email' => $request->input('paymentMethod') === 'cash' ? 'nullable|email|max:255' : 'required|email|max:255',
            'paymentMethod' => 'required|in:cash,card',
            'couponCode' => 'nullable|string|max:255|exists:coupons,code'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 401);
        }

        $cart = $request->cart;
        $items = [];
        $cartTotal = 0;
        foreach ($cart as $cartItem) {
            $item = Item::find($cartItem['itemId']);
            $items[] = [
                'id' => $cartItem['itemId'],
                'name' => $item->name,
                'price' => $item->price,
                'quantity' => $cartItem['quantity']
            ];
            $cartTotal += $item->price * $cartItem['quantity'];
        }
        $request->merge(['items' => $items]);
        $request->request->remove('cart');

        $discount = null;
        $coupon = null;

        if ($request->couponCode) {
            $coupon = Coupon::where('code', $request->couponCode)
                ->where('restaurant_id', $request->restaurantId)
                ->where('active', 1)
                ->where('valid_from', '<=', date('Y-m-d'))
                ->where('valid_to', '>=', date('Y-m-d'))
                ->whereColumn('used', '<', 'limit')
                ->first();

            if ($coupon) {
                // type 0 means percentage, 1 means flat
                $discount = $coupon->type == 0
                    ? ($cartTotal * $coupon->value) / 100
                    : $coupon->value;
            }
        }

        // dd($discount);

        $orderService = new OrderService();

        $data = $request->all();
        $data['discount'] = $discount;
        $data['coupon'] = $coupon;
        $order = $orderService->create($data);

        if ($request->paymentMethod == 'cash') {
            // return the order
            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => [
                    'order' => [
                        'id' => $order->id,
                        'payment_method' => $request->paymentMethod
                    ]
                ]
            ], 200);
        } else {
            // redirect to stripe
            $restaurant = Restaurant::find($request->restaurantId);
            $paymentService = new PaymentService($restaurant->stripe_id);
            $session = $paymentService->createSession(
                $request->items,
                'gbp',
                $request->customer['email'],
                $restaurant->id,
                $order
            );

            if (!$session['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $session['message']
                ], 402);
            }

            return response()->json([
                'success' => true,
                'message' => 'Stripe payment session created successfully',
                'data' => [
                    'order' => [
                        'id' => $order->id,
                        'payment_method' => $request->paymentMethod
                    ],
                    'redirect_url' => $session['redirect_url']
                ]
            ]);
        }
    }

    public function update(Request $request, $id) {
        $order = Order::find($id);
        if (!$order) {
            return redirect()->back()->withError('Order not found');
        }

        // Get the current status and payment method of the order
        $currentStatus = $order->status;
        $paymentMethod = $order->payment_method;

        // Define the valid next statuses and labels based on the current status and payment method
        $validNextStatuses = [];

        if ($currentStatus == 0) {
            if ($paymentMethod == 'card') {
                $validNextStatuses = [null];
            } else {
                $validNextStatuses = [1, 2];
            }
        } elseif ($currentStatus == 1) {
            $validNextStatuses = [3];
        } elseif ($currentStatus == 3) {
            $validNextStatuses = [4];
        } elseif ($currentStatus == 4) {
            if ($paymentMethod == 'cash') {
                $validNextStatuses = [5];
            } else {
                $validNextStatuses = [6];
            }
        } elseif ($currentStatus == 5) {
            if ($paymentMethod == 'cash') {
                $validNextStatuses = [6];
            } else {
                $validNextStatuses = [1, 2];
            }
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'status' => ['required', 'in:' . implode(',', $validNextStatuses)],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withError($validator->errors()->first());
        }

        // Update the order status
        $order->status = $request->input('status');
        $order->save();

        return redirect()
            ->route('orders.show', $order->id)
            ->withSuccess('Order status updated successfully');
    }

    public function sendToWhatsapp(Request $request) {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|integer|exists:orders,id',
            // 'from' => 'required|in:customer,restaurant',
        ]);

        if ($validator->fails()) {
            dd($validator->errors()->first());
        }

        $order = Order::find($request->order_id);

        // Check order status (already in your code)
        if ($order->status == 2) {
            dd('Order already rejected');
        }
        // if ($order->status == 6) {
        //     dd('Order already closed');
        // }

        // Decode order items (already in your code)
        $items = $order->items;

        // Construct WhatsApp message
        $message = "";

        // Order Details (Formatted)
        $message .= "*Order ID:* #" . $order->id . "\n\n";
        $message .= "*Customer Name:* " . $order->customer_name . "\n";
        $message .= "*Phone Number:* " . $order->customer_phone . "\n";

        if ($order->customer_email) {
            $message .= "*Email:* " . $order->customer_email . "\n";
        }

        // Items List (Formatted with quantity * price)
        $message .= "\n*_Items_*:\n";
        foreach ($items as $item) {
            $message .= "- " . $item['name'] . " × " . $item['quantity'] . " = £" . number_format($item['quantity'] * $item['price'], 2, '.', '') . "\n";
        }

        // Order Amount (Formatted with currency from restaurant)
        $message .= "\n*Total Amount:* " . "£" . number_format($order->amount, 2, '.', '') . "\n";

        // Restaurant Name (at the last line)
        $message .= "*Restaurant:* " . $order->restaurant->name . "\n";

        // Additional formatting or greetings can be added here

        // Redirect to WhatsApp (already in your code)
        $whatsAppUrl = 'https://api.whatsapp.com/send?phone=' . '8801797216574' . '&text=' . urlencode($message);
        // return redirect()->away($whatsAppUrl);
        return response()->json([
            'success' => true,
            'message' => 'Whatsapp message generated successfully',
            'data' => [
                'redirect_url' => $whatsAppUrl
            ]
        ], 200);
    }
}
