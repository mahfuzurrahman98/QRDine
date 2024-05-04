<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <title>Restaurant Tableside Ordering</title>
    @vite(['resources/css/app.css'])
    <link rel="apple-touch-icon" sizes="180x180" href="">

    <meta name="theme-color" content="#ffffff">
</head>

<body class="">
    <main class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow-md">
            <h2 class="text-3xl text-blue-700 font-bold mb-5 border-b-2 pb-2">QRDine</h2>
            <p class="text-lg text-gray-700">Register your restaurant and start taking orders.</p>
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
                        class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8"
                        data-dismiss-target="#alert-2" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                </div>
            @endif
            <form class="mt-8 space-y-6" action="{{ route('restaurants.store') }}" method="POST">
                @csrf
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-700">Restaurant Name</label>
                    <input type="text" name="name" id="name" oninput="generateSlug()"
                        value="{{ old('name') }}"
                        class="border sm:text-sm rounded-lg block w-full p-2.5 border-gray-300 text-gray-700"
                        placeholder="Enter restaurant name" required>
                </div>
                <div>
                    <label for="slug" class="block mb-2 text-sm font-medium text-gray-700">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                        class="border sm:text-sm rounded-lg block w-full p-2.5 border-gray-300 text-gray-700"
                        placeholder="Enter a unique slug" required>
                </div>
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="border sm:text-sm rounded-lg block w-full p-2.5 border-gray-300 text-gray-700"
                        placeholder="name@company.com" required>
                </div>
                <div>
                    <label for="password" class="block mb-2 text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" placeholder="••••••••"
                        class="border sm:text-sm rounded-lg block w-full p-2.5 border-gray-300 text-gray-700" required>
                </div>
                <button type="submit"
                    class="w-full px-5 py-3 text-base font-medium text-center text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                    Create account
                </button>
                <div class="text-sm font-medium text-gray-400">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-blue-500 hover:underline">
                        Login here
                    </a>
                </div>
            </form>
        </div>
    </main>

    <script>
        function generateSlug() {
            var name = document.getElementById("name").value;
            var URL = name.split(" ")
                .slice(0, 2).join(" ")
                .substring(0, 30)
                .replace(/\s+/g, "")
                .toLowerCase()
                .replace(/[^a-zA-Z0-9- ]/g, "");
            document.getElementById("slug").value = URL;
        }

        const form = document.querySelector('form');
        const submitButton = form.querySelector('button[type="submit"]');
        form.addEventListener('submit', function(event) {
            submitButton.disabled = true;
            submitButton.classList.add('cursor-not-allowed', 'opacity-50');
            submitButton.innerHTML = 'Processing...';
        });
    </script>
</body>

</html>
