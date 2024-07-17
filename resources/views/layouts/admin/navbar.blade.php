<nav class="fixed z-30 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
    <div class="px-3 py-2 lg:px-5 lg:pl-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center justify-start">
                <button id="toggleSidebarMobile" aria-expanded="true" aria-controls="sidebar"
                    class="p-2 text-gray-600 rounded cursor-pointer lg:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                    <i class="fa-solid fa-bars"></i>
                    {{-- <i class="fa-solid fa-xmark"></i> --}}
                </button>
                <a href="/" class="flex ml-2 md:mr-24 text-xl font-semibold sm:text-2xl dark:text-white">
                    QRDine
                </a>
            </div>

            <div class="flex items-center">
                <button id="toggleSidebarMobileSearch" type="button"
                    class="p-2 text-gray-500 rounded-lg lg:hidden hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                </button>

                <div>
                    <button type="button" data-dropdown-toggle="notification-dropdown"
                        class="p-2 text-gray-500 rounded-lg hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 ">
                        <span class="sr-only">View notifications</span>
                        <i class="fa-solid fa-bell"></i>
                    </button>

                    <div class="z-50 hidden max-w-sm my-4 overflow-hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow-lg dark:divide-gray-600 dark:bg-gray-700"
                        id="notification-dropdown">
                        <div
                            class="block px-4 py-2 text-base font-medium text-center text-gray-700 bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            Notifications
                        </div>
                        <div>
                            <a href="#"
                                class="flex px-4 py-3 border-b hover:bg-gray-100 dark:hover:bg-gray-600 dark:border-gray-600">
                                <div class="flex-shrink-0">
                                    <img class="rounded-full w-11 h-11" src="/images/users/bonnie-green.png"
                                        alt="Jese image">
                                    <div
                                        class="absolute flex items-center justify-center w-5 h-5 ml-6 -mt-5 border border-white rounded-full bg-primary-700 dark:border-gray-700">
                                        <i class="fa-solid fa-circle"></i>
                                    </div>
                                </div>
                                <div class="w-full pl-3">
                                    <div class="text-gray-500 font-normal text-sm mb-1.5 dark:text-gray-400">New message
                                        from <span class="font-semibold text-gray-900 dark:text-white">Bonnie
                                            Green</span>:
                                        "Hey, what's up? All set for the presentation?"</div>
                                    <div class="text-xs font-medium text-primary-700 dark:text-primary-400">a few
                                        moments
                                        ago</div>
                                </div>
                            </a>
                        </div>
                        <a href="#"
                            class="block py-2 text-base font-normal text-center text-gray-900 bg-gray-50 hover:bg-gray-100 dark:bg-gray-700 dark:text-white dark:hover:underline">
                            <div class="inline-flex items-center ">
                                <i class="fa-solid fa-arrow-right"></i>
                                View all
                            </div>
                        </a>
                    </div>
                </div>

                <div>
                    <button id="theme-toggle" data-tooltip-target="tooltip-toggle" type="button"
                        class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-lg p-2">
                        <i id="theme-toggle-dark-icon" class="fa-solid fa-moon" style="display: none;"></i>
                        <i id="theme-toggle-light-icon" class="fa-solid fa-sun" style="display: none;"></i>
                    </button>
                    <div id="tooltip-toggle" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                        Toggle dark mode
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>

                <div class="flex items-center ml-3">
                    <button type="button"
                        class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-lg p-2"
                        id="user-menu-button-2" aria-expanded="false" data-dropdown-toggle="dropdown-2">
                        <i class="fa-solid fa-user"></i>
                    </button>
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                        id="dropdown-2">
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-gray-900 dark:text-white" role="none">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                        <ul class="py-1" role="none">
                            <li>
                                <a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">Profile</a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white">
                                        Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
