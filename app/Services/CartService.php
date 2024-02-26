<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class CartService {
    public function __construct() {
        if (!Session::has('cart')) {
            Session::put('cart', []);
        }
    }

    public function add(int $id, int $quantity): void {
        $cart = Session::get('cart');
        if (isset($cart[$id])) {
            $cart[$id] += $quantity;
        } else {
            $cart[$id] = $quantity;
        }
        Session::put('cart', $cart);
    }

    public function remove(int $id, int $quantity): void {
        $cart = Session::get('cart');
        if (isset($cart[$id])) {
            $cart[$id] -= $quantity;
            if ($cart[$id] <= 0) {
                unset($cart[$id]);
            }
            Session::put('cart', $cart);
        }
    }

    public function get(): array {
        return Session::get('cart');
    }

    public function clear(): void {
        Session::put('cart', []);
    }
}
