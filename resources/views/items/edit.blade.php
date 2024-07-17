@php
    // dd($item);
    $categories = $categories
        ->mapWithKeys(function ($category) {
            return [$category->id => $category->name];
        })
        ->toArray();
@endphp

@extends('layouts.admin.master')

@section('title', 'Edit Item')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('main')
    <main>
        <h1 class="mb-5 text-3xl font-bold text-white">Edit Item</h1>
        <form class="space-y-4 lg:w-[50%] mb-5" action="{{ route('items.update', ['item' => $item]) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <x-form.input label="Item Name" type="text" name="name" id="name" value="{{ $item->name }}"
                placeholder="Enter item name" required="true" />

            <x-form.input-textarea label="Description" name="description" id="description" value="{{ $item->description }}"
                placeholder="Enter item description" required="true" rows="3" />

            <x-form.input label="Price" type="number" name="price" id="price" value="{{ $item->price }}"
                placeholder="Enter item price" required="true" step="0.01" />

            <x-form.select label="Category" name="category_id" id="category_id" :options="$categories"
                value="{{ $item->category_id }}" placeholder="Select category" required="true" />

            <x-form.input-checkbox label="Active" name="active" id="active" checked="{{ $item->active }}"
                required="true" />

            <x-image-uploader name="image" id="image" src="{{ $item->cover }}" title="Product Image" width="300"
                height="200" help="Preferred image dimensions are 300x300. Max file size: 5MB." />

            <div>
                <label for="allergens" class="text-black dark:text-white block mb-2 text-sm font-medium">Allergens</label>
                <select id="allergens" name="allergens[]" multiple
                    class="mt-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    @foreach ($allergens as $key => $allergen)
                        <option value="{{ $allergen }}"
                            {{ $item->itemAllergens && in_array($allergen, $item->itemAllergens) ? 'selected' : '' }}>
                            {{ $allergen }}</option>
                    @endforeach
                </select>
            </div>

            <x-button type="submit" id="add-item-btn" usage="create">
                Save
            </x-button>
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
