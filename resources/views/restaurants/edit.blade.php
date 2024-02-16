@extends('layouts.admin.master')

@section('main')
    <main>
        @if (session('status'))
            <div id="success-alert"
                class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800"
                role="alert">
                <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    viewBox="0 0 20 20">
                    <path
                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                </svg>
                <div class="ms-3 text-sm font-medium">
                    A simple success alert with an <a href="#"
                        class="font-semibold underline hover:no-underline">example link</a>. Give it a click if you like.
                </div>
                <button type="button" onclick="document.getElementById('success-alert').remove()"
                    class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700"
                    data-dismiss-target="#alert-border-3" aria-label="Close">
                    <span class="sr-only">Dismiss</span>
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                </button>
            </div>
        @endif

        <h1 class="mb-5 text-3xl font-bold text-white">Edit Restaurant</h1>
        <form class="space-y-4 lg:w-[50%]" action="{{ route('restaurants.update', $restaurant->id) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form.input-text label="Restaurant Name" type="text" name="name" id="name"
                value="{{ $restaurant->name }}" placeholder="Enter restaurant name" required="true" />

            <x-form.input-text label="Slug" type="text" name="slug" id="slug" value="{{ $restaurant->slug }}"
                placeholder="Enter an unique slug" required="true" disabled="true" />

            <x-form.input-textarea label="Description" name="description" id="description"
                value="{{ $restaurant->description }}" placeholder="Enter restaurant description" required="true"
                rows="3" />

            <x-form.input-text label="Address" type="text" name="address" id="address"
                value="{{ $restaurant->address }}" placeholder="Enter restaurant address" required="true" />

            <div>
                <label for="phone" class="block mb-2 text-sm font-medium text-white">
                    Phone
                </label>
                <input type="text" name="phone" id="phone"
                    class="border sm:text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 text-white"
                    value="{{ $restaurant->phone }}">
            </div>

            <x-form.input-checkbox label="Enable Online Ordering" name="enable_online_ordering" id="enable_online_ordering"
                checked="true" required="false" />

            <x-form.input-checkbox label="Receive order on WhatsApp" name="enable_wa_ordering" id="enable_wa_ordering"
                checked="true" required="false" />



            {{-- <button type="submit"
                    class="px-5 py-2 text-base font-medium text-center text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                    Save
                </button> --}}

            <x-button type="submit" id="edit-restaurant-btn" usage="update">
                Save
            </x-button>
        </form>
    </main>
@endsection
