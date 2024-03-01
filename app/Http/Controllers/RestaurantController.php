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
        dd($request->all());
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
