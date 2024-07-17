@extends('layouts.admin.master')

@section('title', 'Edit Restaurant')
@section('main')
    <main class="bg-white dark:bg-gray-800 p-6 rounded-lg max-w-2xl">
        <h1 class="mb-5 text-3xl font-bold text-gray-900 dark:text-white">Edit Restaurant</h1>
        <form class="space-y-8 mb-5" action="{{ route('restaurants.update', $restaurant->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div>
                <h3
                    class="text-xl font-semibold mb-4 border-b pb-2 text-gray-900 dark:text-white border-gray-300 dark:border-gray-700">
                    Basic Info</h3>
                <div class="space-y-3">
                    <x-form.input label="Restaurant Name" type="text" name="name" id="name"
                        value="{{ $restaurant->name }}" placeholder="Enter restaurant name" required="1" />

                    <x-form.input label="Slug" type="text" name="slug" id="slug"
                        value="{{ $restaurant->slug }}" placeholder="Enter a unique slug" required="1" disabled="true"
                        class="bg-gray-200 dark:bg-gray-600 text-gray-500 dark:text-gray-300" />

                    <x-form.input-textarea label="Description" name="description" id="description"
                        value="{{ $restaurant->description }}" placeholder="Enter restaurant description" required="1"
                        rows="3" />

                    <x-form.input label="Address" type="text" name="address" id="address"
                        value="{{ $restaurant->address }}" placeholder="Enter restaurant address" required="0" />
                </div>
            </div>

            <div>
                <h3
                    class="text-xl font-semibold mb-4 border-b pb-2 text-gray-900 dark:text-white border-gray-300 dark:border-gray-700">
                    Ordering</h3>
                <div class="space-y-3">
                    <x-form.input-checkbox label="Enable online ordering" name="enable_ordering" id="enable_ordering"
                        checked="{{ $restaurant->enable_ordering }}" required="1" />

                    <x-form.input divClass="{{ $restaurant->enable_ordering ? 'hidden' : '' }}"
                        label="Disable Ordering Message" type="text" name="disable_ordering_message"
                        id="disable_ordering_message" value="{{ $restaurant->disable_ordering_message }}"
                        placeholder="Leave a message" required="{{ $restaurant->enable_ordering ? '0' : '1' }}" />

                    <x-form.input label="Minimum order amount" type="number" name="minimum_order_amount"
                        id="minimum_order_amount" value="{{ $restaurant->minimum_order_amount }}"
                        placeholder="Enter minimum order amount" required="0" />

                    <x-form.input-checkbox label="Cash on delivery" name="cod" id="cod"
                        checked="{{ $restaurant->cod }}" required="0" />

                    <x-form.input-checkbox label="Payment through Stripe" name="stripe_payment" id="stripe_payment"
                        checked="{{ $restaurant->stripe_payment }}" required="0" />

                    <x-form.input label="Stripe secret key" type="text" name="stripe_id" id="stripe_id"
                        value="{{ $restaurant->stripe_id }}" placeholder="Enter stripe secret key" required="0" />
                </div>
            </div>

            <div>
                <h3
                    class="text-xl font-semibold mb-4 border-b pb-2 text-gray-900 dark:text-white border-gray-300 dark:border-gray-700">
                    WhatsApp Integration</h3>
                <div class="space-y-3">
                    <x-form.input label="Phone" type="text" name="phone" id="phone"
                        value="{{ $restaurant->phone }}" placeholder="Enter restaurant phone" required="0" />

                    <x-form.input-checkbox label="Enable WhatsApp notification" name="enable_wa_notification"
                        id="enable_wa_notification" checked="{{ $restaurant->enable_wa_notification }}" required="0" />
                </div>
            </div>

            <x-button type="submit" id="edit-restaurant-btn" usage="update"
                class="bg-blue-600 dark:bg-blue-800 text-white dark:text-white rounded px-4 py-2 transition duration-300 hover:bg-blue-700 dark:hover:bg-blue-900">
                Save
            </x-button>
        </form>
    </main>
@endsection

@push('scripts')
    <script>
        const phoneInput = document.getElementById('phone');
        const enableWANotification = document.getElementById('enable_wa_notification');

        const enableOrdering = document.getElementById('enable_ordering');
        const disableOrderingMessageInput = document.getElementById('disable_ordering_message');
        const disableOrderingMessageInputDiv = document.getElementById('disable_ordering_message_div');
        const codInput = document.getElementById('cod');
        const stripePaymentInput = document.getElementById('stripe_payment');
        const stripeIdInput = document.getElementById('stripe_id');

        // only contain numbers and + sign, not more than 15 characters, not less than 10 characters
        phoneInput.addEventListener('input', function() {
            phoneInput.value = phoneInput.value.replace(/[^0-9+]/g, '');
            if (phoneInput.value.length == 0) {
                enableWANotification.checked = false;
                enableWANotification.setAttribute('disabled', 'disabled');
            } else {
                // if no + sign, set error
                if (!phoneInput.value.includes('+')) {
                    phoneInput.setCustomValidity('Must contain + sign at the beginning');
                    enableWANotification.checked = false;
                    enableWANotification.setAttribute('disabled', 'disabled');
                    return;
                }
                if (phoneInput.value.length > 15) {
                    phoneInput.setCustomValidity('Must be at most 15 characters including + sign');
                    phoneInput.value = phoneInput.value.slice(0, 15);
                    return;
                }
                if (phoneInput.value.length < 10) {
                    phoneInput.setCustomValidity('Must be at least 10 characters including + sign');
                    return;
                }
                phoneInput.setCustomValidity('');
            }
        });

        const toggleOrdering = () => {
            if (codInput.checked || stripePaymentInput.checked) {
                enableOrdering.checked = true;
                disableOrderingMessageInput.removeAttribute('required');
                disableOrderingMessageInputDiv.classList.add('hidden');
            } else {
                enableOrdering.checked = false;
                disableOrderingMessageInput.setAttribute('required', '1');
                disableOrderingMessageInputDiv.classList.remove('hidden');
            }
        }

        enableOrdering.addEventListener('change', () => {
            if (enableOrdering.checked) {
                disableOrderingMessageInput.removeAttribute('required');
                disableOrderingMessageInputDiv.classList.add('hidden');
            } else {
                disableOrderingMessageInput.setAttribute('required', '1');
                disableOrderingMessageInputDiv.classList.remove('hidden');
            }
        });

        // if both COD and Stripe Payment are checked, disable ordering
        codInput.addEventListener('change', toggleOrdering);
        stripePaymentInput.addEventListener('change', () => {
            if (stripePaymentInput.checked) {
                stripeIdInput.setAttribute('required', '1');
            } else {
                // remove required from stripe id input
                stripeIdInput.removeAttribute('required');
            }
            toggleOrdering();
        });
    </script>
@endpush
