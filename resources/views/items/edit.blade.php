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

            <x-image-uploader name="image" id="image" src="{{ $item->cover }}" title="Product Image" width="250"
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
