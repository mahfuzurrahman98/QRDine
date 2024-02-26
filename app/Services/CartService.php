<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class CartService {
    public static function initCart() {
        if (!Session::has('cart')) {
            Session::put('cart', []);
        }
    }

    public static function add(int $id, int $quantity): void {
        self::initCart();
        $cart = Session::get('cart');
        if (isset($cart[$id])) {
            $cart[$id] += $quantity;
        } else {
            $cart[$id] = $quantity;
        }
        Session::put('cart', $cart);
    }

    public static function remove(int $id, int $quantity): void {
        self::initCart();
        $cart = Session::get('cart');
        if (isset($cart[$id])) {
            $cart[$id] -= $quantity;
            if ($cart[$id] <= 0) {
                unset($cart[$id]);
            }
            Session::put('cart', $cart);
        }
    }

    public static function get(): array {
        self::initCart();
        return Session::get('cart');
    }

    public static function clear(): void {
        Session::put('cart', []);
    }
}
