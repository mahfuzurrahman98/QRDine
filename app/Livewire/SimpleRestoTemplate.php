<?php

namespace App\Livewire;

use App\Models\Item;
use App\Models\Restaurant;
use Livewire\Component;
use App\Services\CartService;

class SimpleRestoTemplate extends Component {
    public Restaurant $restaurant;
    public Item $curItem;
    public array $cartItems;
    public int $cartQty = 0;
    public int $curQuantity = 1;

    // Livewire.dispatch('close-item-modal');

    // listeners
    protected $listeners = [
        'add-to-cart' => 'addToCart',
        'close-item-modal' => 'setCurItemToNull',
    ];

    // on mount, set the cart items from the CartService
    public function mount() {
        $this->cartItems = CartService::get();
        $this->cartQty = array_sum($this->cartItems);
    }

    public function setCurItem(Item $item) {
        $this->curItem = $item;
    }

    public function render() {
        return view('livewire.simple-resto-template');
    }

    public function incrementQuantity() {
        $this->curQuantity++;
    }

    public function decrementQuantity() {
        if ($this->curQuantity > 1) {
            $this->curQuantity--;
        }
    }


    public function addToCart() {
        CartService::add($this->curItem->id, $this->curQuantity);
        $this->cartQty += $this->curQuantity;
        $this->cartItems = CartService::get();
    }

    public function setCurItemToNull() {
        unset($this->curItem);
    }

    public function removeFromCart() {
        CartService::remove($this->curItem->id, $this->curQuantity);
        $this->cartItems = CartService::get();
    }

    public function clearCart() {
        CartService::clear();
        $this->cartItems = CartService::get();
    }
}
