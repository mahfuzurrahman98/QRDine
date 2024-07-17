import { createApp } from "vue/dist/vue.esm-bundler.js";
import axios from "axios";
import {
    openOrderConfirmationModal,
    closeOrderConfirmationModal,
    openItemModal,
    closeItemModal,
    openCartModal,
    closeCartModal,
    openCheckoutModal,
    closeCheckoutModal,
} from "./functions";

let CartComponent = null;
let CurItemComponent = null;
let CheckoutComponent = null;
let OrderConfirmationComponent = null;

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
            throw error;
        });
};

const applyCoupon = () => {
    CheckoutComponent.couponApplied = "pending";
    if (!CheckoutComponent.couponCode) {
        CheckoutComponent.couponApplied = "error";
        return;
    }
    axios
        .post("/coupons/apply", {
            code: CheckoutComponent.couponCode,
            payment_amount: CheckoutComponent.paymentAmount,
            restaurant_id: CheckoutComponent.restaurantId,
        })
        .then((response) => {
            const data = response.data.data;
            CheckoutComponent.discount = data.discount;
            CheckoutComponent.couponApplied = "success";
        })
        .catch((error) => {
            CheckoutComponent.couponApplied = "error";
            console.error(error);
        });
};

const placeOrder = () => {
    // only pick item id and quantity
    let cart = [];
    for (let cartItem of CartComponent.cart) {
        cart.push({
            itemId: cartItem.item.id,
            quantity: cartItem.quantity,
        });
    }

    // console.log(CheckoutComponent.paymentMethod);
    // return;

    CheckoutComponent.submitBtnLoading = true;
    axios
        .post("/orders", {
            restaurantId: CheckoutComponent.restaurantId,
            tableId: CheckoutComponent.tableId,
            cart,
            customer: CheckoutComponent.customer,
            paymentMethod: CheckoutComponent.paymentMethod,
            couponCode: CheckoutComponent.couponCode,
        })
        .then((response) => {
            const data = response.data.data;

            clearCart();

            const order = data.order;
            console.log(order);
            if (order.payment_method === "card") {
                window.location.href = data.redirect_url;
            } else {
                console.log("here we are");
                // cash payment
                OrderConfirmationComponent.orderId = order.id;
                OrderConfirmationComponent.paymentMethod = "cash";
                OrderConfirmationComponent.loading = false;

                CheckoutComponent.discount = null;
                CheckoutComponent.couponApplied = "";
                CheckoutComponent.couponCode = "";

                CheckoutComponent.closeCheckoutModal();
                OrderConfirmationComponent.openOrderConfirmationModal();
            }
        })
        .catch((error) => {
            CheckoutComponent.error = error.response.data.message;
            CheckoutComponent.submitBtnLoading = false;
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
        computed: {
            cartTotal() {
                let total = 0;
                for (let item of this.cart) {
                    total += item.item.price * item.quantity;
                }
                return total;
            },
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
            isNumber(event) {
                if (
                    !Number.isInteger(Number(event.key)) &&
                    event.keyCode !== 8 &&
                    event.keyCode !== 46
                ) {
                    event.preventDefault();
                }
            },
        },
        watch: {
            quantity(newVal) {
                const valType = typeof newVal;
                if (valType === "string") {
                    newVal = newVal.replace(/\D/g, "");
                    this.quantity = newVal == "0" ? 1 : Number(newVal);
                } else if (valType === "number") {
                    this.quantity = newVal == 0 ? 1 : newVal;
                }
            },
        },
    }).mount("#itemModal");

    CheckoutComponent = createApp({
        data() {
            return {
                restaurantId: restoId,
                tableId: tableId,
                customer: {
                    name: "",
                    phone: "",
                    email: "",
                },
                discount: null,
                couponApplied: "",
                paymentMethod: "cash",
                couponCode: "",
                submitBtnLoading: false,
                error: null,
            };
        },
        methods: {
            openCheckoutModal,
            closeCheckoutModal,
            placeOrder,
            applyCoupon,
        },
        computed: {
            paymentAmount() {
                let cartTotal = CartComponent.cartTotal;
                return cartTotal;
            },
        },
        mounted() {
            getCart();
        },
    }).mount("#checkoutModal");

    OrderConfirmationComponent = createApp({
        data() {
            return {
                loading: true,
                orderId: orderId,
                paymentId: paymentId,
                error: null,
            };
        },
        methods: {
            openOrderConfirmationModal() {
                // Logic to open modal
                this.loading = false;
                // this.error = null;
                openOrderConfirmationModal();
            },
            closeOrderConfirmationModal() {
                this.orderId = null;
                this.paymentId = null;
                this.loading = false;
                this.error = null;
                closeOrderConfirmationModal();
            },
            sendToWhatsApp() {
                axios
                    .post("/orders/send", {
                        order_id: this.orderId,
                    })
                    .then((response) => {
                        const data = response.data.data;
                        const redirect_url = data.redirect_url;
                        window.location.href = redirect_url;

                        this.loading = false;
                        this.error = null;
                    })
                    .catch((error) => {
                        this.loading = false;
                        this.error = error.response.data.message;
                    });
            },
        },
    }).mount("#orderConfirmationModal");
};

window.openCheckoutModal = () => {
    closeCartModal();
    openCheckoutModal();
};

window.closeCheckoutModal = closeCheckoutModal;

window.setCurItem = (itemId) => {
    axios
        .post("/resto/items", {
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

window.addEventListener("load", function () {
    if (orderId && paymentId) {
        OrderConfirmationComponent.openOrderConfirmationModal();
    }
});
