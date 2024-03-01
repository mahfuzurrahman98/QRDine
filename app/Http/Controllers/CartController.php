<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Services\CartService;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller {
    public function get() {
        $cart = CartService::get();

        return response()->json([
            'success' => true,
            'data' => [
                'cart' => $cart
            ]
        ], 200);
    }

    public function add(Request $request) {
        $validator = Validator::make($request->all(), [
            'itemId' => 'required|integer|exists:items,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        CartService::add($request->itemId, $request->quantity);

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart',
            'data' => [
                'cart' => CartService::get()
            ]
        ], 200);
    }

    public function remove(Request $request) {
        $validator = Validator::make($request->all(), [
            'itemId' => 'required|integer|exists:items,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        CartService::remove($request->itemId, $request->quantity);

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart',
            'data' => [
                'cart' => CartService::get()
            ]
        ], 200);
    }

    public function clear() {
        CartService::clear();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared',
            'data' => [
                'cart' => CartService::get()
            ]
        ], 200);
    }
}
