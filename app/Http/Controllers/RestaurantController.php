<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Restaurant;
use App\Models\DineinTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        $date_from = request()->get('date_from');
        $date_to = request()->get('date_to');
        $name = request()->get('name');
        $email = request()->get('email');

        $restaurants = Restaurant::query();

        if ($date_from && $date_to) {
            $restaurants->whereBetween('created_at', [$date_from, $date_to]);
        } else if ($date_from) {
            $restaurants->where('created_at', '>=', $date_from);
        } else if ($date_to) {
            $restaurants->where('created_at', '<=', $date_to);
        }
        if ($name) {
            // search with both name and slug, match any of them
            $restaurants->where(function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%')
                    ->orWhere('slug', 'like', '%' . $name . '%');
            });
        }
        if ($email) {
            // user has email, and user is related to the restaurant
            $restaurants->whereHas('user', function ($query) use ($email) {
                $query->where('email', 'like', '%' . $email . '%');
            });
        }

        $restaurants = $restaurants->paginate(10);

        return view('restaurants.index', ['restaurants' => $restaurants]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $slug) {
        $restaurant = Restaurant::where('slug', $slug)->first();
        if (!$restaurant) {
            abort(404);
        }

        $tableId = $request->input('table');
        $dineinTable = DineinTable::find($tableId);

        if (
            $dineinTable &&
            ($dineinTable->restaurant_id !== $restaurant->id || $dineinTable->active == 0)
        ) {
            $dineinTable = null;
        }

        $payment = null;
        $order = null;

        // if query param have payment_method=cash, and payment_id as valid integer, and order_id is a valid integer
        if (
            $request->input('payment_method') == 'card' &&
            is_numeric($request->input('payment_id')) &&
            is_numeric($request->input('order_id'))
        ) {
            // find both order and payment
            $payment = Payment::find($request->input('payment_id'));
            $order = Order::find($request->input('order_id'));

            if (
                $payment->id != $order->payment_id ||
                $order->restaurant_id != $restaurant->id
            ) {
                // if payment id does not match the order payment reference or
                // the order is not referencing to the correct restaurant

                // make both payment and order as null
                $payment = null;
                $order = null;
            }
        }

        $viewData = [
            'restaurant' => $restaurant,
            'table' => $dineinTable,
            'paymentId' => $payment ? $payment->id : null,
            'orderId' => $order ? $order->id : null
        ];
        // dd($viewData);
        return view('restaurants.show', $viewData);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant) {
        // dd($restaurant->id, auth()->user()->restaurant->id);
        if ($restaurant->id !== auth()->user()->restaurant->id) {
            return redirect()
                ->route('dashboard')
                ->withError('You are not authorized to edit this restaurant');
        }


        return view('restaurants.edit', [
            'restaurant' => $restaurant
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant) {
        try {
            // merge the request with the boolean values
            $request->merge([
                'enable_ordering' => $request->has('enable_ordering') ? 1 : 0,
                'cod' => $request->has('cod') ? 1 : 0,
                'stripe_payment' => $request->has('stripe_payment') ? 1 : 0,
                'enable_wa_notification' => $request->has('enable_wa_notification') ? 1 : 0,
            ]);
            // dd($request->all());

            // the phone only contain numbers and + sign, not required
            // not more than 15 characters, not less than 10 characters
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'address' => 'required|string',
                'minimum_order_amount' => 'nullable|numeric',
                'enable_ordering' => 'required|boolean',
                'disable_ordering_message' => 'required_if:enable_ordering,false|string|max:255|nullable',
                'cod' => 'required|boolean',
                'stripe_payment' => 'required|boolean',
                'phone' => 'nullable|regex:/^[0-9+]{10,15}$/',
                'enable_wa_notification' => 'required|boolean',
                'stripe_id' => 'required_if:stripe_payment,true',
            ]);

            if ($validator->fails()) {
                return back()->withError($validator->errors()->first());
            }

            $restaurant->update($request->all());
            return back()->withStatus('Restaurant updated successfully');
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Restaurant $restaurant) {
        //
    }


    public function getItem(Request $request) {
        $validator = Validator::make($request->all(), [
            'itemId' => 'required|integer|exists:items,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $item = Item::find($request->itemId);
        $item = [
            'id' => $item->id,
            'name' => $item->name,
            'description' => $item->description,
            'price' => $item->price,
            'allergens' => $item->allergens,
            'image' => $item->cover ? $item->cover : asset('assets/images/no-image-cover.png')
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'item' => $item
            ]
        ], 200);
    }
}
