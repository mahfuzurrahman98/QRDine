@php
    $imagePath = strlen($src) ? $src : asset('assets/images/camera-icon.jpg');
    $removeButtonStyle = strlen($src) ? 'block' : 'hidden';
@endphp

<div id="image-preview" class="flex flex-col items-center">
    <label class="font-semibold" for="">{{ $title }}</label>
    @isset($help)
        <p class="text-gray-600" v-html="help"></p>
    @endisset

    <div class="relative overflow-hidden border border-gray-300"
        style="width: {{ $width }}px; height: {{ $height }}px">
        <img src="{{ $imagePath }}" id="{{ $id }}_preview_div"
            class="w-full h-auto absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" />
    </div>

    <div class="mt-3 flex justify-center">
        <div>
            <label for="{{ $id }}"
                class="cursor-pointer px-2 py-1 bg-black text-white text-sm leading-4 font-medium rounded">Upload</label>
            <input type="file" name="{{ $name }}" id="{{ $id }}" accept="image/*"
                onchange="previewImage(event)" class="hidden">
        </div>

        <div>
            <button type="button" id="{{ $id }}_remove_btn"
                class="px-2 py-1 bg-red-600 text-white text-sm leading-4 font-medium rounded ml-3 {{ $removeButtonStyle }}">
                Remove
            </button>
        </div>
        <input type="hidden" name="{{ $name }}_ex" id="{{ $id }}_ex" value="0">
    </div>
</div>
