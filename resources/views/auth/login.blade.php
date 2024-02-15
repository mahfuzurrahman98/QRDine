<!doctype html>
<html lang="en" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Themesberg">
    <meta name="generator" content="Hugo 0.58.2">
    <title>Restaurant Tableside Ordering</title>
    @vite(['resources/css/app.css'])
    <link rel="apple-touch-icon" sizes="180x180" href="">

    <meta name="theme-color" content="#ffffff">
</head>

<body class="bg-gray-800">
    <main class="bg-gray-900">
        <div class="flex flex-col items-center justify-center px-6 pt-8 mx-auto md:h-screen bg-gray-900">
            <a href="https://flowbite-admin-dashboard.vercel.app/"
                class="flex items-center justify-center mb-8 text-2xl font-semibold lg:mb-10 text-white">
                <img src="https://flowbite-admin-dashboard.vercel.app/images/logo.svg" class="mr-4 h-11"
                    alt="FlowBite Logo">
                <span>Flowbite</span>
            </a>
            <!-- Card -->
            <div class="w-full max-w-xl p-6 space-y-8 sm:p-8 bg-gray-800 rounded-lg shadow">
                <h2 class="text-2xl font-bold text-white">
                    Create a Free Account
                </h2>

                @if (session('error'))
                    <div id="error-alert" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-200"
                        role="alert">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="sr-only">Info</span>
                        <div class="ms-3 text-sm font-medium">
                            {{ session('error') }}
                        </div>
                        <button type="button" onclick="document.getElementById('error-alert').remove()"
                            class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8  dark:text-red-400 dark:hover:bg-gray-700"
                            data-dismiss-target="#alert-2" aria-label="Close">
                            <span class="sr-only">Close</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                        </button>
                    </div>
                @endif

                <form class="mt-8 space-y-6" action="{{ route('authenticate') }}" method="POST">
                    @csrf
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-white">
                            Email
                        </label>
                        <input type="email" name="email" id="email"
                            class="border sm:text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 text-white"
                            placeholder="name@company.com" required>
                    </div>
                    <div>
                        <label for="password" class="block mb-2 text-sm font-medium text-white">
                            Password
                        </label>
                        <input type="password" name="password" id="password" placeholder="••••••••"
                            class="border sm:text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 text-white"
                            required>
                    </div>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="remember" aria-describedby="remember" name="remember" type="checkbox"
                                class="w-4 h-4 rounded bg-gray-700 border-gray-600">
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="remember" class="font-medium text-white">
                                Remember me
                            </label>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full px-5 py-3 text-base font-medium text-center text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                        Login
                    </button>
                    <div class="text-sm font-medium text-gray-400">
                        Don't have an account?
                        <a href="#" class="text-blue-500 hover:underline">
                            Create an account
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>
