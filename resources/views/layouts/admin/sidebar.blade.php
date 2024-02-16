<aside id="sidebar"
    class="fixed top-0 left-0 z-20 flex flex-col flex-shrink-0 hidden w-64 h-full pt-16 font-normal duration-75 lg:flex transition-width"
    aria-label="Sidebar">
    <div
        class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="flex flex-col flex-1 pt-5 pb-4 overflow-y-auto">
            <div class="flex-1 px-3 space-y-1 bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                <ul class="pb-2 space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700">
                            <i class="fa-solid fa-gauge"></i>
                            <span class="ml-3" sidebar-toggle-item>Dashboard</span>
                        </a>
                    </li>

                    {{-- Restaurant listing --}}
                    @if (auth()->user()->type == 1)
                        <li>
                            <a href="{{ route('restaurants') }}"
                                class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700">
                                <i class="fa-solid fa-shop"></i>
                                <span class="ml-3" sidebar-toggle-item>Restaurants</span>
                            </a>
                        </li>
                    @endif

                    {{-- Setting menu --}}
                    <li>
                        <button type="button"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                            aria-controls="dropdown-auth" data-collapse-toggle="dropdown-auth">
                            <i class="fa-solid fa-gear"></i>
                            <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Settings</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </button>
                        <ul id="dropdown-auth" class="hidden py-2 space-y-2">
                            @if (auth()->user()->type == 2)
                                <li>
                                    <a href="{{ route('restaurants.edit', ['restaurant' => auth()->user()->restaurant->id]) }}"
                                        class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                        Restaurent
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('dinein-tables') }}"
                                        class="flex items-center p-2 text-base text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700">
                                        Dinein Tables
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>

                    {{-- Food menu --}}
                    @if (auth()->user()->type == 2)
                        <li>
                            <button type="button"
                                class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-700"
                                aria-controls="dropdown-food-menu" data-collapse-toggle="dropdown-food-menu">
                                <i class="fa-solid fa-utensils"></i>
                                <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>
                                    Food Menu
                                </span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <ul id="dropdown-food-menu" class="space-y-2 py-2 hidden ">
                                <li>
                                    <a href="{{ route('categories') }}"
                                        class="text-base text-gray-900 rounded-lg flex items-center p-2 group hover:bg-gray-100 transition duration-75 pl-11 dark:text-gray-200 dark:hover:bg-gray-700">
                                        Categories
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('items') }}"
                                        class="text-base text-gray-900 rounded-lg flex items-center p-2 group hover:bg-gray-100 transition duration-75 pl-11 dark:text-gray-200 dark:hover:bg-gray-700">
                                        Menu
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('allergens') }}"
                                        class="text-base text-gray-900 rounded-lg flex items-center p-2 group hover:bg-gray-100 transition duration-75 pl-11 dark:text-gray-200 dark:hover:bg-gray-700">
                                        Allergens
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    {{-- Orders --}}
                    <li>
                        <a href="{{ route('orders') }}"
                            class="flex items-center p-2 text-base text-gray-900 rounded-lg hover:bg-gray-100 group dark:text-gray-200 dark:hover:bg-gray-700">
                            <i class="fa-solid fa-basket-shopping"></i>
                            <span class="ml-3" sidebar-toggle-item>Orders</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</aside>
