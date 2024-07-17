<!-- Cover Image -->
<div class="bg-cover bg-center h-80 hidden md:block"
    style="background-image: url('{{ $restaurant->cover != '' ? $restaurant->cover : 'https://bikri.io/uploads/restorants/38/a17479bd-fc39-4858-98e3-fef835c4edd6_cover.jpg' }}');">
</div>

<div class="container mx-auto px-4 lg:px-0">
    <!-- Restaurant Logo and Name -->
    <div class="flex flex-col items-center mt-2 md:items-start">
        <img src="{{ $restaurant->logo != '' ? $restaurant->logo : 'https://rimazkitchen.bikri.io/uploads/restorants/19/eb0861c1-0316-4f30-b8fa-a5cffdbb8cb4_thumbnail.jpg' }}"
            alt="{{ $restaurant->name }} Logo" class="w-32 h-32 p-1 rounded-full border-gray-600 border-2 mb-4">
        <h2 class="text-3xl font-semibold my-4">{{ $restaurant->name }}</h2>
        <p class="text-gray-600">{{ $restaurant->description }}</p>
    </div>

    <!-- Categories List -->
    <div class="flex flex-wrap gap-2 items-center mt-6 mb-3">
        @foreach ($restaurant->categories as $category)
            <a href="#cat-{{ str_replace(' ', '-', $category->name) }}"
                class="shadow bg-gray-300 text-lg text-gray-700 px-3 py-1 rounded-full hover:bg-gray-800 hover:text-white"
                onclick="toggleActive(this)">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    <!-- Categories and Items -->
    <div class="flex flex-col gap-y-6 mt-6 mb-5" id="#item-section">
        @foreach ($restaurant->categories as $category)
            @if ($category->items->isNotEmpty() && $category->active)
                <div class="bg-green-10 max-w-5xl rounded-lg" id="cat-{{ str_replace(' ', '-', $category->name) }}">
                    <h2 class="text-xl font-semibold mb-2">{{ $category->name }}</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach ($category->items as $item)
                            <div class="flex items-center gap-x-3 justify-between border-2 border-gray-200 p-3 mb-2 rounded-lg cursor-pointer"
                                onclick="setCurItem({{ $item->id }})">
                                <div class="">
                                    <p class="text-md font-semibold">{{ $item->name }}</p>
                                    <!-- Description for small devices -->
                                    <p class="text-gray-500">
                                        {{ Str::limit($item->description, 50) }}</p>
                                    <p class="text-gray-700 font-bold">£{{ $item->price }}</p>
                                </div>
                                <div class="flex-shrink-0">
                                    <img src="{{ $item->logo != '' ? $item->logo : asset('assets') . '/images/no-image.png' }}"
                                        alt="{{ $item->name }}"
                                        class="w-20 h-20 rounded-full">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach
    </div>
</div>
</div>
