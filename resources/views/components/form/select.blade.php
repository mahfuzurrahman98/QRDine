@php
    $valueAttr = '';
    if ($value) {
        $valueAttr = 'value="' . $value . '"';
    }
@endphp

@props(['options'])

<div>
    <label for="{{ $id }}" class="text-black dark:text-white block mb-2 text-sm font-medium">
        {{ $label }}
    </label>
    <select name="{{ $name }}" id="{{ $id }}"
        class="border sm:text-sm rounded-lg block w-full p-2.5
            dark:bg-gray-700 dark:border-gray-600 dark:text-white
            light:bg-gray-200 light:border-gray-300 light:text-black {{ $disabled ? 'opacity-75' : '' }}"
        {{ $disabled ? 'disabled' : '' }} {{ $required ? 'required' : '' }}>
        <option value="">{{ $placeholder }}</option>
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" {{ $value == $optionValue ? 'selected' : '' }}>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>
</div>
