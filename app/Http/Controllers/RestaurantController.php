<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RestaurantController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        // paginate the restaurants
        $restaurants = Restaurant::paginate(10);

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
        return view('restaurants.show', ['restaurant' => $restaurant]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Restaurant $restaurant) {
        return view('restaurants.edit', ['restaurant' => $restaurant]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Restaurant $restaurant) {
        try {
            // merge the request with the boolean values
            $request->merge([
                'enable_ordering' => $request->has('enable_ordering'),
                'cod' => $request->has('cod'),
                'stripe_payment' => $request->has('stripe_payment'),
                'enable_wa_notification' => $request->has('enable_wa_notification'),
            ]);

            // the phone only contain numbers and + sign, not required
            // not more than 15 characters, not less than 10 characters
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
                'address' => 'required|string',
                'minimum_order_amount' => 'nullable|numeric',
                'enable_ordering' => 'required|boolean',
                'cod' => 'required|boolean',
                'stripe_payment' => 'required|boolean',
                'phone' => 'nullable|regex:/^[0-9+]{10,15}$/',
                'enable_wa_notification' => 'required|boolean',
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

        return response()->json([
            'success' => true,
            'data' => [
                'item' => Item::find($request->itemId)
            ]
        ], 200);
    }
}
