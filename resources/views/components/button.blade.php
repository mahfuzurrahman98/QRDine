@php
    $textColor = 'text-white';
    $bgColor = $usage == 'create' ? 'bg-green-700' : ($usage == 'update' ? 'bg-blue-700' : 'bg-red-700');
    $hoverBgColor = $usage == 'create' ? 'hover:bg-green-500' : ($usage == 'update' ? 'hover:bg-blue-600' : 'hover:bg-red-50');
    $sizeClasses = $size == 'normal' ? 'px-5 py-2 text-base' : ($size == 'small' ? 'px-3 py-1 text-sm' : 'px-7 py-3 text-lg');
@endphp

@if ($type == 'link')
    <a href="{{ $href }}" id="{{ $id }}"
        class="{{ $sizeClasses }} text-center {{ $textColor }} {{ $bgColor }} {{ $hoverBgColor }} rounded-lg">
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" id="{{ $id }}"
        class="{{ $sizeClasses }} text-center {{ $textColor }} {{ $bgColor }} {{ $hoverBgColor }} rounded-lg">
        {{ $slot }}
    </button>
@endif
