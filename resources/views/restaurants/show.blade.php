<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }} Menu</title>
    @vite(['resources/css/app.css', 'resources/js/restaurant-front.js'])

    <style>
        .category-link.cat-active {
            /* Styles for active category link */
            color: #fff;
            background-color: #030a12;
        }
    </style>

</head>

<body class="bg-gray-100 relative">
    <div>
        <!-- Backdrop overlay -->
        <div id="backdrop"
            class="fixed inset-0 bg-black opacity-0 pointer-events-none z-10 transition-opacity duration-300 ease-in-out">
        </div>

        <!-- Item Modal -->
        <div id="itemModal"
            class="fixed bottom-0 inset-x-0 bg-white p-4 transform translate-y-full transition duration-300 ease-in-out z-30 rounded-t-3xl mx-2 h-[99vh] flex flex-col"
            v-cloak>
            <!-- Modal header and Item name, Header -->
            <div class="flex justify-between border-b pb-2 mb-3">
                <h2 class="text-2xl font-semibold">@{{ item.name }}</h2>
                <button @click="closeItemModal()"
                    class="bg-gray-200 text-gray-600 rounded-full px-3 py-1">&times;</button>
            </div>

            <!-- Item details, Body -->
            <div v-if="item.name" class="flex-1 overflow-y-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="max-h-100 max-w-80">
                        <img :src="item.image" alt="Item Image" class="w-full h-full rounded-md">
                    </div>
                    <div>
                        <p class="font-semibold text-lg">@{{ item.name }}</p>
                        <p class="text-gray-600">£@{{ item.price }}</p>
                        <p class="text-gray-600">@{{ item.description }}</p>


                        <!-- Allergens and toppings here -->
                        <!-- ... -->
                    </div>
                </div>
            </div>

            <!-- Checkout button, Footer -->
            @if ($table)
                @if ($restaurant->enable_ordering)
                    <!-- Quantity selector -->
                    <div class="mt-3 flex items-center gap-x-3">
                        <button
                            class="bg-white text-black rounded-full px-2 py-1 text-sm border border-black hover:bg-black hover:text-white hover:border-black"
                            @click="decCurItemQty()">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="text" v-model="quantity"
                            class="w-12 px-0 py-1 text-center border border-black rounded-md" />
                        <button
                            class="bg-white text-black rounded-full px-2 py-1 text-sm border border-black hover:bg-black hover:text-white hover:border-black"
                            @click="incCurItemQty()">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                    <button @click="addToCart()" class="w-full bg-gray-500 text-white py-2 mt-4 rounded-lg">
                        Add to Cart
                    </button>
                @else
                    <p class="text-red-700">
                        {{ $restaurant->disable_ordering_message }}
                    </p>
                @endif
            @endif
        </div>


        <!-- Cart and Checkout Modal based on some condition -->
        @if ($table && $restaurant->enable_ordering)
            <div id="cart">
                <button @click="openCartModal()" id="cartBtn"
                    class="fixed bottom-6 right-6 bg-gray-500 text-white py-2 px-4 rounded-full shadow-md z-20 hover:bg-black">
                    Cart
                    <span v-if="cart.length > 0" class="ml-1 group-hover:block" v-cloak>
                        (@{{ cart.length }})
                    </span>
                </button>

                <!-- Cart Modal -->
                <div id="cartModal"
                    class="fixed bottom-0 inset-x-0 bg-white p-4 transform translate-y-full transition duration-300 ease-in-out z-30 rounded-t-3xl mx-2 h-[90vh] flex flex-col"
                    v-cloak>

                    <!-- Modal header -->
                    <div class="flex justify-between border-b pb-2 mb-3">
                        <h2 class="text-2xl font-semibold">Cart</h2>
                        <button @click="closeCartModal()" class="bg-gray-200 text-gray-600 rounded-full px-3 py-1">
                            &times;
                        </button>
                    </div>

                    <div class="">
                        <!-- Cart items list -->
                        <div v-if="cart.length > 0" class="flex-1 overflow-y-auto">
                            <div class="overflow-y-auto">
                                <div v-for="data in cart" :key="data.item.id"
                                    class="flex items-center justify-between border-b border-gray-200 py-2">
                                    <div class="flex space-x-6">
                                        <img :src="data.item.image" alt="Item Image" class="w-20 h-20 rounded-md" />
                                        <div class="flex flex-col justify-between">
                                            <div>
                                                <p class="font-semibold">
                                                    @{{ data.item.name }}
                                                </p>
                                                <p class="text-gray-600">
                                                    £@{{ data.item.price }} x @{{ data.quantity }}
                                                </p>
                                            </div>
                                            <div class="flex items-center">
                                                <!-- Minus Button -->
                                                <button
                                                    :class="`${data.quantity === 1 ? 'bg-gray-400' : 'bg-black'} bg-white text-black rounded-full px-2 py-1 text-sm border border-black hover:bg-black hover:text-white hover:border-black`"
                                                    @click="removeFromCart(data.item.id, 1)"
                                                    :disabled="data.quantity == 1">
                                                    <i class="fas fa-minus"></i>
                                                </button>

                                                <!-- Plus Button -->
                                                <button
                                                    class="bg-white text-black rounded-full px-2 py-1 text-sm ml-3 border border-black hover:bg-black hover:text-white hover:border-black"
                                                    @click="addToCart(data.item.id, 1)">
                                                    <i class="fas fa-plus"></i>
                                                </button>

                                                <!-- Trash Button -->
                                                <button
                                                    class="text-red-700 bg-red-100 hover:bg-red-600 hover:text-white ml-5 rounded-full px-2 py-1 text-sm border border-red-700"
                                                    @click="removeFromCart(data.item.id, data.quantity)">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cart total amount -->
                        <div v-if="cart.length > 0" class="border-b border-gray-200 py-2">
                            <p class="text-gray-700 font-semibold">
                                Total: £@{{ cartTotal.toFixed(2) }}
                            </p>
                        </div>


                        <!-- Checkout button -->
                        <button v-if="cart.length > 0" onclick="openCheckoutModal()"
                            class="w-full bg-gray-500 text-white py-2 mt-4 rounded-lg">
                            Checkout
                        </button>

                        <!-- Empty cart message -->
                        <div v-else class="text-lg text-red-500 rounded">
                            Your cart is empty
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checkout Modal -->
            <div id="checkoutModal"
                class="fixed bottom-0 inset-x-0 bg-white p-4 transform translate-y-full transition duration-300 ease-in-out z-30 rounded-t-3xl mx-2 h-[90vh] flex flex-col"
                v-cloak>

                <!-- Modal header -->
                <div class="flex justify-between border-b pb-2 mb-3">
                    <h2 class="text-2xl font-semibold">Checkout</h2>
                    <button @click="closeCheckoutModal()" class="bg-gray-200 text-gray-600 rounded-full px-3 py-1">
                        &times;
                    </button>
                </div>

                <!-- Cart items list -->
                <div class="flex-1 overflow-y-auto mt-4">
                    <form class="space-y-4" id="checkoutForm" @submit.prevent="placeOrder()">
                        <!-- Error div -->
                        <div v-if="error" class="text-red-600">
                            <p>@{{ error }}</p>
                        </div>

                        <!-- Payment methods, cash and card radio buttons, the vue component hav paymentMethod property -->
                        <div class="">
                            <label for="paymentMethod" class="block font-semibold">Payment Method</label>
                            <div class="flex items-center space-x-3">
                                <input type="radio" id="cash" name="paymentMethod" value="cash"
                                    v-model="paymentMethod"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                <label for="cash">Cash</label>
                                @if ($restaurant->stripe_payment)
                                    <input type="radio" id="card" name="paymentMethod" value="card"
                                        v-model="paymentMethod"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500">
                                    <label for="card">Card</label>
                                @endif
                            </div>
                        </div>

                        <!-- Name, phone and email inputs -->
                        <div>
                            <label for="name" class="block font-semibold">Name</label>
                            <input type="text" id="name" name="name" v-model="customer.name"
                                class="w-full border border-gray-400 rounded-md py-2 px-3" required
                                placeholder="Enter your name">
                        </div>
                        <div>
                            <label for="phone" class="block font-semibold">Phone</label>
                            <input type="text" id="phone" name="phone" v-model="customer.phone"
                                class="w-full border border-gray-400 rounded-md py-2 px-3" required
                                placeholder="Enter your phone">
                        </div>
                        <div v-if="paymentMethod == 'card'">
                            <label for="email" class="block font-semibold">Email</label>
                            <input type="email" id="email" name="email" v-model="customer.email"
                                class="w-full border border-gray-400 rounded-md py-2 px-3" required
                                placeholder="Enter your email">
                        </div>
                        <div>
                            <label for="couponCode" class="block font-semibold">Coupon Code</label>
                            <div class="flex">
                                <input type="text" id="couponCode" name="couponCode" v-model="couponCode"
                                    class="w-full border border-gray-400 rounded-md py-1 px-2"
                                    :disabled="couponApplied == 'success' || couponApplied == 'pending'"
                                    placeholder="Enter coupon code">
                                <a @click="applyCoupon()"
                                    class="bg-gray-500 text-white px-4 ml-2 rounded-lg flex items-center cursor-pointer"
                                    :disabled="couponApplied == 'success' || couponApplied == 'pending'">
                                    @{{ couponApplied == 'pending' ? 'Applying...' : 'Apply' }}
                                </a>
                            </div>

                            <div v-if="couponApplied != ''" class="mt-2">
                                <p v-if="couponApplied == 'error'" class="text-red-600">Invalid coupon code</p>
                                <p v-if="couponApplied == 'success'" class="text-green-600">
                                    Coupon applied successfully
                                </p>
                            </div>
                        </div>

                        <div v-if="paymentAmount > 0" class="border-b border-gray-200 py-2">
                            <p v-if="couponApplied == 'success'" class="text-gray-700 font-semibold">
                                Total: <span class="float-right">£@{{ paymentAmount.toFixed(2) }}</span>
                            </p>
                            <p v-if="couponApplied == 'success'" class="text-gray-700 font-semibold">
                                Coupon discount: <span class="float-right">£@{{ discount.toFixed(2) }}</span>
                            </p>
                            <p class="text-gray-700 font-semibold">
                                Payable amount:
                                <span class="float-right">
                                    £@{{ (paymentAmount - (couponApplied == 'success' ? discount : 0)).toFixed(2) }}
                                </span>
                            </p>
                        </div>

                        <!-- Checkout button -->
                        <button
                            class="w-full bg-gray-500 text-white py-2 mt-4 rounded-lg disabled:opacity-60 disabled:cursor-not-allowed"
                            :disabled="submitBtnLoading" form="checkoutForm">
                            @{{ submitBtnLoading ? 'Processing...' : 'Place Order' }}
                        </button>
                    </form>
                </div>
            </div>
        @endif
    </div>

    @include('templates.hunger-template')

    <!-- Order Modal -->
    <div id="orderConfirmationModal" v-if="orderId"
        class="translate-y-full fixed bottom-0 inset-x-0 bg-white p-4 transform transition duration-300 ease-in-out z-30 rounded-t-3xl mx-2">
        <!-- Modal header and Item name -->
        <div class="flex justify-between border-b pb-2 mb-3">
            <h2 class="text-2xl font-semibold">Order</h2>
            <button @click="closeOrderConfirmationModal()"
                class="bg-gray-200 text-gray-600 rounded-full px-3 py-1">&times;</button>
        </div>

        <div class="mt-4">
            <p v-if="loading" class="text-gray-600 flex items-center">
                <svg class="animate-spin h-5 w-5 mr-3 text-gray-600" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.372 0 0 5.372 0 12h4zm2 5.291A7.966 7.966 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Processing...
            </p>
            <div v-else>
                <div v-if="!error" class="text-gray-600">
                    <p class="text-green-600 text-lg">Your order has been placed successfully</p>
                    <div class="mt-3">
                        <p class="text-gray-600">
                            <span class="font-semibold">Order ID:</span>
                            #@{{ orderId }}
                        </p>
                        <p v-if="paymentId" class="text-gray-600">
                            <span class="font-semibold">Payment ID:</span>
                            #@{{ paymentId }}
                        </p>
                    </div>
                </div>
                <p v-if="error" class="text-red-600">@{{ error }}</p>
                <form v-if="!error" @submit.prevent="sendToWhatsApp">
                    <input type="hidden" v-model="orderId" name="orderId">
                    <button type="submit" class="bg-green-500 text-white rounded px-4 py-2 mt-3">
                        <i class="fa-brands fa-whatsapp mr-1"></i> Send to WhatsApp
                    </button>
                </form>
            </div>
        </div>
    </div>


    <script>
        let restoId = {{ $restaurant->id }};
        let tableId = {{ $table ? $table->id : 'null' }};
        let paymentId = {{ $paymentId ? $paymentId : 'null' }};
        let orderId = {{ $orderId ? $orderId : 'null' }};
    </script>
</body>

</html>
