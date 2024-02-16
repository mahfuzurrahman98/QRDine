<div>
    <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-white">
        {{ $label }}
    </label>
    <textarea name="{{ $name }}" id="{{ $id }}"
        class="border sm:text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 text-white"
        value="{{ $value }}" placeholder="{{ $placeholder }}" required="{{ $required }}">{{ $value }}</textarea>
</div>
