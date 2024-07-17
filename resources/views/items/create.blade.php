@php
    $categories = $categories
        ->mapWithKeys(function ($category) {
            return [$category->id => $category->name];
        })
        ->toArray();
@endphp

@extends('layouts.admin.master')

@section('title', 'Create Item')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container .select2-selection--multiple {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            padding: 0.5rem;
            /* Tailwind p-2 */
            border-width: 1px;
            /* Tailwind border */
            border-radius: 0.375rem;
            /* Tailwind rounded-lg */
            border-color: #d1d5db;
            /* Tailwind border-gray-300 */
            color: #000;
            /* Tailwind text-black for light mode */
            min-height: 2.5rem;
            /* Tailwind h-10 */
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #3b82f6;
            /* Tailwind bg-blue-500 */
            border-color: #3b82f6;
            /* Tailwind border-blue-500 */
            color: #fff;
            /* Tailwind text-white */
            border-radius: 0.375rem;
            /* Tailwind rounded-md */
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff;
            /* Tailwind text-white */
            margin-right: 0.25rem;
            /* Tailwind mr-1 */
        }

        .select2-container--default .select2-search--inline .select2-search__field {
            padding: 0;
            /* Remove padding */
            margin: 0;
            /* Remove margin */
            height: auto;
            /* Auto height */
            background-color: transparent;
            /* Inherit background color */
            border: none;
            /* Remove border */
            color: #000;
            /* Tailwind text-black for light mode */
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #2563eb;
            /* Tailwind bg-blue-600 */
            color: #fff;
            /* Tailwind text-white */
        }

        /* Dark mode styles */
        .dark .select2-container .select2-selection--multiple {
            background-color: #374151;
            /* Tailwind bg-gray-700 */
            border-color: #4b5563;
            /* Tailwind border-gray-600 */
            color: #fff;
            /* Tailwind text-white */
        }

        .dark .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #1f2937;
            /* Tailwind bg-gray-800 */
            border-color: #1f2937;
            /* Tailwind border-gray-800 */
        }

        .dark .select2-container--default .select2-search--inline .select2-search__field {
            color: #fff;
            /* Tailwind text-white */
        }
    </style>
@endpush

@section('main')
    <main>
        <h1 class="mb-5 text-2xl font-bold text-black dark:text-gray-200">Create New Item</h1>
        <form class="space-y-4 lg:w-[50%] mb-5" action="{{ route('items.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf

            <x-form.input label="Item Name" type="text" name="name" id="name" value="{{ old('name') }}"
                placeholder="Enter item name" required="true" />

            <x-form.input-textarea label="Description" name="description" id="description" value="{{ old('description') }}"
                placeholder="Enter item description" required="true" rows="3" />

            <x-form.input label="Price" type="number" name="price" id="price" value="{{ old('price') }}"
                placeholder="Enter item price" required="true" step="0.01" />

            <x-form.select label="Category" name="category_id" id="category_id" :options="$categories" :value="old('category_id')"
                placeholder="Select category" required="true" />

            <x-form.input-checkbox label="Active" name="active" id="active" checked="{{ old('active', true) }}"
                required="true" />

            <x-image-uploader name="image" id="image" src="" title="Product Image" width="300"
                height="200" help="Preferred image dimensions are 300x300. Max file size: 5MB." />

            <div>
                <label for="allergens" class="text-black dark:text-white block mb-2 text-sm font-medium">Allergens</label>
                <select id="allergens" name="allergens[]" multiple
                    class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @foreach ($allergens as $key => $allergen)
                        <option value="{{ $allergen }}">{{ $allergen }}</option>
                    @endforeach
                </select>
            </div>

            <x-button type="submit" id="add-item-btn" usage="create">Save</x-button>
        </form>
    </main>
@endsection

@push('scripts')
    <script src="/assets/js/image-uploader.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#allergens').select2({
                tags: true, // Enable tagging feature
                tokenSeparators: [',', ' '], // Allow tags to be created by separating with comma or space
                placeholder: "Select or add allergens",
                width: '100%' // Ensure it takes the full width
            });
        });
    </script>
@endpush
