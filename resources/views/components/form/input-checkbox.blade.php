<div class="flex items-start">
    <div class="flex items-center h-5">
        <input id="{{ $id }}" name="{{ $name }}" type="checkbox"
            class="w-4 h-4 rounded dark:bg-gray-700 border-gray-600" {{ $checked ? 'checked' : '' }}>
    </div>
    <div class="ml-2 text-sm">
        <label for="{{ $id }}" class="text-black dark:text-white font-medium">
            {{ $label }}
        </label>
    </div>
</div>
