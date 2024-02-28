<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
let cart = ref([]);

onMounted(() => {
    axios.get("/cart").then((response) => {
        cart.value = response.data.data.cart;
    });
});
</script>

<template>
    <!-- Cart Modal Button -->
    <button
        onclick="openCartModal()"
        class="fixed bottom-6 right-6 bg-gray-500 text-white py-2 px-4 rounded-full shadow-md z-20"
    >
        Cart ({{ cart.length }})
    </button>

    <!-- Cart Modal -->
    <div
        id="cartModal"
        class="fixed bottom-0 inset-x-0 bg-white p-4 transform translate-y-full transition duration-300 ease-in-out z-30 rounded-t-3xl mx-2"
    >
        <!-- Close button -->
        <div class="flex justify-between mb-3">
            <h2 class="text-2xl font-semibold">Cart</h2>
            <button
                onclick="closeCartModal()"
                class="bg-gray-200 text-gray-600 rounded-full px-3 py-1"
            >
                &times;
            </button>
        </div>
        <!-- Cart items list -->
        <div class="overflow-y-auto max-h-96">
            <!-- Iterate over cart items and display them here -->
            <div
                v-for="data in cart"
                :key="data.item.id"
                class="flex items-center justify-between border-b border-gray-200 py-2"
            >
                <div class="flex space-x-4">
                    <img
                        :src="'https://rimazkitchen.bikri.io/uploads/restorants/19/d4f6f2a1-f34c-42e9-9537-4ea6d29cd451_thumbnail.jpg'"
                        alt="Item Image"
                        class="w-16 h-16 rounded-md"
                    />
                    <div class="flex flex-col justify-between">
                        <div>
                            <p class="font-semibold">
                                {{ data.item.name }}
                            </p>
                            <p class="text-gray-600">
                                {{ data.item.price }}
                            </p>
                        </div>
                        <div class="flex items-center">
                            <button
                                class="bg-gray-200 text-gray-600 rounded px-2 py-1"
                            >
                                -
                            </button>
                            <span class="mx-2">{{ data.item.quantity }}</span>
                            <button
                                class="bg-gray-200 text-gray-600 rounded px-2 py-1"
                            >
                                +
                            </button>
                        </div>
                    </div>
                </div>
                <button class="text-red-600">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>
        <!-- Checkout button -->
        <button
            onclick="openCheckoutModal()"
            class="w-full bg-gray-500 text-white py-2 mt-4 rounded-lg"
        >
            Checkout
        </button>
    </div>
</template>

<style scoped>
button {
    font-weight: bold;
}
</style>
