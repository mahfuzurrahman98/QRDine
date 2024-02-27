<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }} Menu</title>
    @vite(['resources/css/app.css'])
    @livewireStyles

    <style>
        .category-link.cat-active {
            /* Styles for active category link */
            color: #fff;
            background-color: #030a12;
        }
    </style>

</head>

<body class="bg-gray-100 relative">
    @livewire('simple-resto-template', [
        'restaurant' => $restaurant,
    ])

    @livewireScripts

    <script>
        function toggleActive(element) {
            // Remove 'active' class from all category links
            document.querySelectorAll('.category-link').forEach(function(link) {
                link.classList.remove('cat-active');
            });

            // Add 'active' class to the clicked category link
            element.classList.add('cat-active');
        }

        function closeItemModal() {
            Livewire.dispatch('close-item-modal');
        }

        function openCartModal() {
            document.getElementById('cartModal').classList.remove('translate-y-full');
            toggleBackdrop(true);
        }

        function closeCartModal() {
            document.getElementById('cartModal').classList.add('translate-y-full');
            toggleBackdrop(false);
        }

        function openCheckoutModal() {
            closeCartModal();
            document.getElementById('checkoutModal').classList.remove('translate-y-full');
            toggleBackdrop(true);
        }

        function closeCheckoutModal() {
            document.getElementById('checkoutModal').classList.add('translate-y-full');
            toggleBackdrop(false);
        }

        function addToCart() {
            Livewire.dispatch('add-to-cart');
            closeItemModal();
        }

        // Function to toggle the backdrop visibility and body overflow
        function toggleBackdrop(show) {
            const backdrop = document.getElementById('backdrop');
            const body = document.body;

            if (show) {
                // At least one modal is open, show the backdrop
                backdrop.classList.remove('opacity-0', 'pointer-events-none');
                backdrop.classList.add('opacity-50');
                // Disable scrolling
                body.style.overflow = 'hidden';
            } else {
                // Both modals are closed, hide the backdrop
                backdrop.classList.remove('opacity-50');
                backdrop.classList.add('opacity-0', 'pointer-events-none');
                // Enable scrolling
                body.style.overflow = 'auto';
            }
        }
    </script>
</body>

</html>