// Function to toggle the backdrop visibility and body overflow
const toggleBackdrop = (show) => {
    const backdrop = document.getElementById("backdrop");
    const body = document.body;

    if (show) {
        // At least one modal is open, show the backdrop
        backdrop.classList.remove("opacity-0", "pointer-events-none");
        backdrop.classList.add("opacity-50");
        // Disable scrolling
        body.style.overflow = "hidden";
    } else {
        // Both modals are closed, hide the backdrop
        backdrop.classList.remove("opacity-50");
        backdrop.classList.add("opacity-0", "pointer-events-none");
        // Enable scrolling
        body.style.overflow = "auto";
    }
};

const openOrderConfirmationModal = () => {
    document
        .getElementById("orderConfirmationModal")
        .classList.remove("translate-y-full");
    toggleBackdrop(true);
};

const closeOrderConfirmationModal = () => {
    document
        .getElementById("orderConfirmationModal")
        .classList.add("translate-y-full");
    toggleBackdrop(false);
};

const openItemModal = () => {
    document.getElementById("itemModal").classList.remove("translate-y-full");
    toggleBackdrop(true);
};

const closeItemModal = () => {
    document.getElementById("itemModal").classList.add("translate-y-full");
    toggleBackdrop(false);
};

const openCartModal = () => {
    document.getElementById("cartModal").classList.remove("translate-y-full");
    toggleBackdrop(true);
};

const closeCartModal = () => {
    document.getElementById("cartModal").classList.add("translate-y-full");
    toggleBackdrop(false);
};

const openCheckoutModal = () => {
    // closeCartModal();
    document
        .getElementById("checkoutModal")
        .classList.remove("translate-y-full");
    toggleBackdrop(true);
};

const closeCheckoutModal = () => {
    document.getElementById("checkoutModal").classList.add("translate-y-full");
    toggleBackdrop(false);
};

export {
    openOrderConfirmationModal,
    closeOrderConfirmationModal,
    openItemModal,
    closeItemModal,
    openCartModal,
    closeCartModal,
    openCheckoutModal,
    closeCheckoutModal,
};
