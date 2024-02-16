@php
    $textColor = $type == 'success' ? 'text-green-800' : 'text-red-800';
    $bgColor = $type == 'success' ? 'bg-green-200' : 'bg-red-200';

    $buttonTextColor = $type == 'success' ? 'text-green-500' : 'text-red-500';
    $buttonHoverBgColor = $type == 'success' ? 'hover:bg-green-50' : 'hover:bg-red-50';
    $buttonFocusRingColor = $type == 'success' ? 'focus:ring-green-400' : 'focus:ring-red-400';
@endphp

<div id="{{ $type }}-alert" class="flex items-center p-4 mb-4 {{ $textColor }} {{ $bgColor }} rounded-lg"
    role="alert">
    <i class="fa-solid fa-info-circle"></i>
    <span class="sr-only">Info</span>
    <div class="ms-3 text-sm font-medium">
        {{ $slot }}
    </div>
    <button type="button" onclick="document.getElementById('{{ $type }}-alert').remove()"
        class="ms-auto -mx-1.5 -my-1.5 {{ $buttonTextColor }} {{ $buttonHoverBgColor }} p-1.5 inline-flex items-center justify-center h-8 w-8 rounded-lg"
        data-dismiss-target="#{{ $type }}-alert" aria-label="Close">
        <span class="sr-only">Close</span>
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
