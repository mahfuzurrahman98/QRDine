<div>
    <label for="{{ $id }}" class="block mb-2 text-sm font-medium text-white">
        {{ $label }}
    </label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}"
        {{ $type == 'number' && $min != null ? 'min=' . $min : '' }}
        {{ $type == 'number' && $max != null ? 'max=' . $max : '' }}
        {{ $type == 'number' && $step != null ? 'step=' . $step : '' }}
        class="border sm:text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 text-white {{ $disabled ? 'opacity-75' : '' }}"
        value="{{ $value }}" placeholder="{{ $placeholder }}" required="{{ $required }}"
        {{ $disabled ? 'disabled' : '' }} />
</div>