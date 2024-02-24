<div>
    <label for="{{ $id }}" class="text-black dark:text-white block mb-2 text-sm font-medium">
        {{ $label }}
    </label>
    <textarea name="{{ $name }}" id="{{ $id }}"
        class="border sm:text-sm rounded-lg block w-full p-2.5
    dark:bg-gray-700 dark:border-gray-600 dark:text-white
    light:bg-gray-200 light:border-gray-300 light:text-black {{ $disabled ? 'opacity-75' : '' }}"
        value="{{ $value }}" placeholder="{{ $placeholder }}" required="{{ $required }}">{{ $value }}</textarea>
</div>
