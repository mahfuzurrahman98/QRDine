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
    public int $curItemQty = 1;

    // listeners
    protected $listeners = [
        'add-to-cart' => 'addToCart',
        'close-item-modal' => 'setCurItemToNull',
    ];

    // on mount, set the cart items from the CartService
    public function mount() {
        $this->cartItems = CartService::get();
    }

    public function render() {
        return view('livewire.simple-resto-template');
    }

    // Play with the current item
    public function setCurItem(Item $item) {
        $this->curItemQty = 1;
        $this->curItem = $item;
    }

    public function incCurItemQty() {
        $this->curItemQty++;
    }

    public function decCurItemQty() {
        if ($this->curItemQty > 1) {
            $this->curItemQty--;
        }
    }

    public function addToCart() {
        CartService::add($this->curItem->id, $this->curItemQty);
        $this->cartItems = CartService::get();
    }


    // Play with some specific item in the cart

    public function incItemQty($itemId) {
        CartService::add($itemId, 1);
        $this->cartItems = CartService::get();
    }

    public function decItemQty($itemId) {
        CartService::remove($itemId, 1);
        $this->cartItems = CartService::get();
    }

    public function removeItemFromCart($itemId) {
        CartService::remove($itemId, $this->cartItems[$itemId]);
        $this->cartItems = CartService::get();
    }

    public function clearCart() {
        CartService::clear();
        $this->cartItems = CartService::get();
    }

    public function setCurItemToNull() {
        unset($this->curItem);
    }
}
