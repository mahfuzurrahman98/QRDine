<div class="flex items-start">
    <div class="flex items-center h-5">
        <input id="{{ $id }}" name="{{ $name }}" type="checkbox"
            class="w-4 h-4 rounded bg-gray-700 border-gray-600" checked="{{ $checked }}">
    </div>
    <div class="ml-3 text-sm">
        <label for="{{ $id }}" class="font-medium text-white">
            {{ $label }}
        </label>
    </div>
</div>
