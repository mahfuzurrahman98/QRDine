@php
    $categories = $categories
        ->mapWithKeys(function ($category) {
            return [$category->id => $category->name];
        })
        ->toArray();
@endphp

@extends('layouts.admin.master')

@section('main')
    <main>
        <h1 class="mb-5 text-3xl font-bold text-white">Add New Item</h1>
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
                required="true" />y

            <x-image-uploader name="image" id="image" src="" title="Product Image" width="300"
                height="200" help="Preferred image dimensions are 300x300. Max file size: 5MB." />

            <x-button type="submit" id="add-item-btn" usage="create">
                Save
            </x-button>
        </form>
    </main>
@endsection

@push('scripts')
    <script src="/assets/js/image-uploader.js"></script>
@endpush
