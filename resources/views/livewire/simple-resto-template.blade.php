<div>
    <!-- Backdrop overlay -->
    <div id="backdrop"
        class="fixed inset-0 bg-black opacity-0 pointer-events-none z-10 transition-opacity duration-300 ease-in-out">
    </div>

    <!-- Cart Modal Button -->
    <button onclick="openCartModal()"
        class="fixed bottom-6 right-6 bg-gray-500 text-white py-2 px-4 rounded-full shadow-md z-20">
        Cart {{ count($cartItems) > 0 ? $cartQty : '' }}
    </button>

    <!-- Item Modal -->
    <div id="itemModal"
        class="{{ $curItem ? '' : 'translate-y-full' }} fixed bottom-0 inset-x-0 bg-white p-4 transform transition duration-300 ease-in-out z-30 rounded-t-3xl mx-2">
        <!-- Close button and Item name -->
        <div class="flex justify-between mb-3">
            <h2 class="text-2xl font-semibold">{{ $curItem ? $curItem->name : '' }}</h2>
            <button onclick="closeItemModal()" class="bg-gray-200 text-gray-600 rounded-full px-3 py-1">&times;</button>
        </div>
        <!-- Item details -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <img src="{{ $curItem ? $curItem->imageUrl : '' }}" alt="Item Image" class="w-full h-full rounded-md">
            <div>
                <p class="font-semibold text-lg">{{ $curItem ? $curItem->name : '' }}</p>
                <p class="text-gray-600">{{ $curItem ? $curItem->description : '' }}</p>
                <!-- Quantity selector -->
                <div class="mt-3 flex items-center">
                    <button wire:click="decrementQuantity"
                        class="bg-gray-300 text-gray-700 rounded px-3 py-1 mr-2">-</button>
                    <span class="text-lg">{{ $curQuantity }}</span>
                    <button wire:click="incrementQuantity"
                        class="bg-gray-300 text-gray-700 rounded px-3 py-1 ml-2">+</button>
                </div>
                <!-- Allergens and toppings here -->
                <!-- ... -->
            </div>
        </div>
        <!-- Checkout button -->
        <button onclick="addToCart()" class="w-full bg-blue-500 text-white py-2 mt-4 rounded-lg">
            Add to Cart
        </button>
    </div>


    <!-- Cart Modal -->
    <div id="cartModal"
        class="fixed bottom-0 inset-x-0 bg-white p-4 transform translate-y-full transition duration-300 ease-in-out z-30 rounded-t-3xl mx-2">
        <!-- Close button -->
        <div class="flex justify-between mb-3">
            <h2 class="text-2xl font-semibold">Cart</h2>
            <button onclick="closeCartModal()" class="bg-gray-200 text-gray-600 rounded-full px-3 py-1">&times;</button>
        </div>
        <!-- Cart items list -->
        <div class="overflow-y-auto max-h-96">
            <!-- Iterate over cart items and display them here -->
            @foreach ($cartItems as $itemId => $qty)
                @php
                    $item = App\Models\Item::find($itemId);
                @endphp
                <div class="flex items-center justify-between border-b border-gray-200 py-2">
                    <div class="flex space-x-4">
                        <img src="{{ 'https://rimazkitchen.bikri.io/uploads/restorants/19/d4f6f2a1-f34c-42e9-9537-4ea6d29cd451_thumbnail.jpg' }}"
                            alt="Item Image" class="w-16 h-16 rounded-md">
                        <div class="flex flex-col justify-between">
                            <div>
                                <p class="font-semibold">{{ $item->name }}</p>
                                <p class="text-gray-600">{{ $item->price }}</p>
                            </div>
                            <div class="flex items-center">
                                <button onclick="decreaseItemQty({{ $itemId }})"
                                    class="bg-gray-200 text-gray-600 rounded px-2 py-1">-</button>
                                <span class="mx-2">{{ $qty }}</span>
                                <button onclick="increaseItemQty({{ $itemId }})"
                                    class="bg-gray-200 text-gray-600 rounded px-2 py-1">+</button>
                            </div>
                        </div>
                    </div>
                    <button onclick="removeItemFromCart({{ $itemId }})" class="text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endforeach
        </div>
        <!-- Checkout button -->
        <button onclick="openCheckoutModal()"
            class="w-full bg-gray-500 text-white py-2 mt-4 rounded-lg">Checkout</button>
    </div>

    <!-- Checkout Modal -->
    <div id="checkoutModal"
        class="fixed bottom-0 inset-x-0 bg-white p-4 transform translate-y-full transition duration-300 ease-in-out z-30 rounded-t-3xl mx-2">

        <div class="flex justify-between mb-3">
            <h2 class="text-2xl font-semibold">Checkout</h2>
            <button onclick="closeCheckoutModal()"
                class="bg-gray-200 text-gray-600 rounded-full px-3 py-1">&times;</button>
        </div>
        <form class="space-y-4">
            <div>
                <label for="name" class="block font-semibold">Name</label>
                <input type="text" id="name" name="name"
                    class="w-full border border-gray-200 rounded-md py-2 px-3">
            </div>
            <div>
                <label for="phone" class="block font-semibold">Phone</label>
                <input type="text" id="phone" name="phone"
                    class="w-full border border-gray-200 rounded-md py-2 px-3">
            </div>
            <div>
                <label for="coupon" class="block font-semibold">Coupon Code</label>
                <input type="text" id="coupon" name="coupon"
                    class="w-full border border-gray-200 rounded-md py-2 px-3">
            </div>
            <!-- Submit button -->
            <button type="submit" class="w-full bg-gray-500 text-white py-2 rounded-lg">Place Order</button>
        </form>
    </div>

    <!-- Cover Image -->
    <div class="bg-cover bg-center h-80 hidden md:block"
        style="background-image: url('{{ $restaurant->cover != '' ? $restaurant->cover : 'https://bikri.io/uploads/restorants/38/a17479bd-fc39-4858-98e3-fef835c4edd6_cover.jpg' }}');">
    </div>

    <div class="container mx-auto px-4 lg:px-0">
        <!-- Restaurant Logo and Name -->
        <div class="flex flex-col items-center mt-2 md:items-start">
            <img src="{{ $restaurant->logo != '' ? $restaurant->logo : 'https://rimazkitchen.bikri.io/uploads/restorants/19/eb0861c1-0316-4f30-b8fa-a5cffdbb8cb4_thumbnail.jpg' }}"
                alt="{{ $restaurant->name }} Logo" class="w-32 h-32 p-1 rounded-full border-black border-4 mb-4">
            <h2 class="text-3xl font-semibold my-4">{{ $restaurant->name }}</h2>
            <p class="text-gray-600">{{ $restaurant->description }}</p>
        </div>

        <!-- Categories List -->
        <div class="flex items-center justify-between mt-6 overflow-x-auto sticky top-1 mb-3">
            <div class="flex gap-3 mb-1">
                @foreach ($restaurant->categories as $category)
                    <a href="#cat-{{ str_replace(' ', '-', $category->name) }}"
                        class="category-link bg-gray-300 text-lg text-gray-700 px-3 py-1 rounded-xl hover:bg-gray-400"
                        onclick="toggleActive(this)">{{ $category->name }}</a>
                @endforeach
            </div>
        </div>


        <!-- Categories and Items -->
        <div class="flex flex-col gap-y-6 mt-6 mb-5">
            @foreach ($restaurant->categories as $category)
                @if ($category->items->isNotEmpty() && $category->active)
                    <div class="bg-green-10 max-w-5xl rounded-lg"
                        id="cat-{{ str_replace(' ', '-', $category->name) }}">
                        <h2 class="text-xl font-semibold mb-2">{{ $category->name }}</h2>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @foreach ($category->items as $item)
                                <div class="flex items-center gap-x-2 justify-between border p-2 mb-2 rounded-lg cursor-pointer"
                                    wire:click="setCurItem({{ $item->id }})">
                                    <div class="ml-3">
                                        <p class="text-md font-semibold">{{ $item->name }}</p>
                                        <p class="text-gray-600">{{ $item->price }}</p>
                                        <!-- Description for small devices -->
                                        <p class="text-gray-500">
                                            {{ Str::limit($item->description, 50) }}</p>
                                    </div>
                                    <div class="flex-shrink-0">
                                        <img src="{{ $item->logo != '' ? $item->logo : 'https://rimazkitchen.bikri.io/uploads/restorants/19/d4f6f2a1-f34c-42e9-9537-4ea6d29cd451_thumbnail.jpg' }}"
                                            alt="{{ $item->name }}" class="w-20 h-20 rounded-md">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
