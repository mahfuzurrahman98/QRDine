@php
    $types = ['Percentage', 'Fixed'];
@endphp

@extends('layouts.admin.master')

@section('title', 'Create Coupon')
@section('main')
    <main class="bg-white dark:bg-gray-800 p-6 rounded-lg max-w-2xl">
        <h1 class="mb-5 text-3xl font-bold text-gray-900 dark:text-white">Create Coupon</h1>
        <form class="space-y-8 mb-5" action="{{ route('coupons.store') }}" method="POST">
            @csrf

            <div>
                <h3
                    class="text-xl font-semibold mb-4 border-b pb-2 text-gray-900 dark:text-white border-gray-300 dark:border-gray-700">
                    Coupon Info</h3>
                <div class="space-y-3">
                    <x-form.input label="Coupon name" type="text" name="name" id="name" value="{{ old('name') }}"
                        placeholder="Enter coupon name" required="1" />

                    <x-form.input label="Coupon code" type="text" name="code" id="code"
                        value="{{ old('code') }}" placeholder="Enter coupon code" required="1" />

                    <x-form.select label="Coupon Type" name="type" id="type" value="{{ old('type') }}"
                        placeholder="Select type" required="1" :options="$types"
                        class="bg-white dark:bg-gray-700 text-gray-900 dark:text-white" />

                    <x-form.input label="Coupon amount" type="text" name="value" id="value"
                        value="{{ old('value') }}" placeholder="Enter coupon amount" required="1" />

                    <x-form.input label="Valid from" type="date" name="valid_from" id="valid_from"
                        value="{{ old('valid_from') }}" placeholder="Enter start date" required="1" />

                    <x-form.input label="Valid to" type="date" name="valid_to" id="valid_to"
                        value="{{ old('valid_to') }}" placeholder="Enter end date" required="1" />

                    <x-form.input label="Coupon limit" type="text" name="limit" id="limit"
                        value="{{ old('limit') }}" placeholder="Enter coupon limit" required="1" />

                    <x-form.input-checkbox label="Active" name="active" id="active" checked="{{ old('active') }}"
                        required="0" />
                </div>
            </div>

            <x-button type="submit" id="create-coupon-btn" usage="create"
                class="bg-green-600 dark:bg-green-800 text-white dark:text-white rounded px-4 py-2 transition duration-300 hover:bg-green-700 dark:hover:bg-green-900">
                Save
            </x-button>
        </form>
    </main>
@endsection

@push('scripts')
    <script>
        const startDateInput = document.getElementById('valid_from');
        const endDateInput = document.getElementById('valid_to');

        // Ensure that end date is not before start date
        startDateInput.addEventListener('change', function() {
            if (endDateInput.value && startDateInput.value > endDateInput.value) {
                endDateInput.setCustomValidity('End date cannot be before start date');
            } else {
                endDateInput.setCustomValidity('');
            }
        });

        endDateInput.addEventListener('change', function() {
            if (startDateInput.value && endDateInput.value < startDateInput.value) {
                endDateInput.setCustomValidity('End date cannot be before start date');
            } else {
                endDateInput.setCustomValidity('');
            }
        });
    </script>
@endpush
