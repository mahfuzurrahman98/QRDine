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
                <form class="mt-8 space-y-6" action="#">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-white">
                            Restaurant Name
                        </label>
                        <input type="text" name="name" id="name"
                            class="border sm:text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 text-white"
                            placeholder="Enter restaurant name" required>
                    </div>
                    <div>
                        <label for="slug" class="block mb-2 text-sm font-medium text-white">
                            Slug
                        </label>
                        <input type="text" name="slug" id="slug"
                            class="border sm:text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 text-white"
                            placeholder="Enter an unique slug" required>
                    </div>
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
                                class="w-4 h-4 rounded bg-gray-700 border-gray-600" required>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="remember" class="font-medium text-white">
                                I accept the
                                <a href="#" class="text-blue-500 hover:underline">Terms and Conditions</a>
                            </label>
                        </div>
                    </div>
                    <button type="submit"
                        class="w-full px-5 py-3 text-base font-medium text-center text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                        Create account
                    </button>
                    <div class="text-sm font-medium text-gray-400">
                        Already have an account?
                        <a href="#" class="text-blue-500 hover:underline">
                            Login here
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>

</html>
