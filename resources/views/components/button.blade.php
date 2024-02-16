@php
    $textColor = 'text-white';
    $bgColor = $usage == 'create' ? 'bg-green-700' : ($usage == 'update' ? 'bg-blue-700' : 'bg-red-700');
    $hoverBgColor = $usage == 'create' ? 'hover:bg-green-50' : ($usage == 'update' ? 'hover:bg-blue-600' : 'hover:bg-red-50');
@endphp

<button type="{{ $type }}" id="{{ $id }}"
    class="px-5 py-2 text-base font-medium text-center {{ $textColor }} {{ $bgColor }} {{ $hoverBgColor }} rounded-lg">
    {{ $slot }}
</button>
