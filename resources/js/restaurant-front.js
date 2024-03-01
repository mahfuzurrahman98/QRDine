import { createApp } from "vue/dist/vue.esm-bundler.js";
import axios from "axios";
import {
    openItemModal,
    closeItemModal,
    openCartModal,
    closeCartModal,
    openCheckoutModal,
    closeCheckoutModal,
} from "./functions";

let CartComponent = null;
let CurItemComponent = null;

const toggleActive = (element) => {
    // Remove 'active' class from all category links
    document.querySelectorAll(".category-link").forEach(function (link) {
        link.classList.remove("cat-active");
    });

    // Add 'active' class to the clicked category link
    element.classList.add("cat-active");
};

const addToCart = (itemId, quantity) => {
    axios
        .post("/cart/add", {
            itemId,
            quantity,
        })
        .then((response) => {
            CartComponent.cart = response.data.data.cart;
        })
        .catch((error) => {
            console.error(error);
        });
};

const getCart = () => {
    axios
        .get("/cart")
        .then((response) => {
            CartComponent.cart = response.data.data.cart;
        })
        .catch((error) => {
            console.error(error);
        });
};

const removeFromCart = (itemId, quantity) => {
    axios
        .post("/cart/remove", {
            itemId,
            quantity,
        })
        .then((response) => {
            CartComponent.cart = response.data.data.cart;
        })
        .catch((error) => {
            console.error(error);
        });
};

const clearCart = () => {
    axios
        .post("/cart/clear")
        .then((response) => {
            CartComponent.cart = response.data.data.cart;
        })
        .catch((error) => {
            console.error(error);
        });
};

// define Vue components on window load
window.onload = () => {
    CartComponent = createApp({
        data() {
            return {
                cart: [],
            };
        },
        methods: {
            openCartModal,
            closeCartModal,
            addToCart,
            removeFromCart,
            clearCart,
        },
        mounted() {
            getCart();
        },
    }).mount("#cart");

    CurItemComponent = createApp({
        data() {
            return {
                item: {},
                quantity: 1,
            };
        },
        methods: {
            incCurItemQty() {
                this.quantity++;
            },
            decCurItemQty() {
                this.quantity > 1 && this.quantity--;
            },
            closeItemModal() {
                this.item = {};
                closeItemModal();
            },
            addToCart() {
                addToCart(this.item.id, this.quantity);
                this.closeItemModal();
            },
        },
    }).mount("#itemModal");
};

window.setCurItem = (itemId) => {
    axios
        .post(`/resto/items`, {
            itemId,
        })
        .then((response) => {
            CurItemComponent.item = response.data.data.item;
            CurItemComponent.quantity = 1;
            openItemModal();
        })
        .catch((error) => {
            console.error(error);
        });
};
