@extends('layouts.admin.master')

@section('main')
    <main>
        <h1 class="mb-5 text-3xl font-bold text-white">Edit Restaurant</h1>
        <form class="space-y-4 lg:w-[50%] mb-5" action="{{ route('restaurants.update', $restaurant->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.input label="Restaurant Name" type="text" name="name" id="name"
                value="{{ $restaurant->name }}" placeholder="Enter restaurant name" required="true" />

            <x-form.input label="Slug" type="text" name="slug" id="slug" value="{{ $restaurant->slug }}"
                placeholder="Enter an unique slug" required="true" disabled="true" />

            <x-form.input-textarea label="Description" name="description" id="description"
                value="{{ $restaurant->description }}" placeholder="Enter restaurant description" required="true"
                rows="3" />

            <x-form.input label="Address" type="text" name="address" id="address" value="{{ $restaurant->address }}"
                placeholder="Enter restaurant address" required="false" />

            <x-form.input label="Phone" type="text" name="phone" id="phone" value="{{ $restaurant->phone }}"
                placeholder="Enter restaurant phone" required="false" />

            <x-form.input label="Minimum order amount" type="number" name="minimum_order_amount" id="minimum_order_amount"
                value="{{ $restaurant->minimum_order_amount }}" placeholder="Enter minimum order amount" required="false" />

            <x-form.input-checkbox label="Enable online ordering" name="enable_ordering" id="enable_ordering"
                checked="{{ $restaurant->enable_ordering }}" required="true" />

            <x-form.input-checkbox label="Enable WhatsApp notification" name="enable_wa_notification"
                id="enable_wa_notification" checked="{{ $restaurant->enable_wa_notification }}" required="false" />


            <x-button type="submit" id="edit-restaurant-btn" usage="update">
                Save
            </x-button>
        </form>
    </main>
@endsection

@push('scripts')
    <script>
        const phoneInput = document.getElementById('phone');
        const enableWANotification = document.getElementById('enable_wa_notification');

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
    </script>
@endpush
