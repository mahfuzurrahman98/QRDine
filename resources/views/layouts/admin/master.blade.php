<!doctype html>
<html lang="en" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Themesberg">
    <meta name="generator" content="Hugo 0.58.2">
    <title>Restaurant Tableside Ordering</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="apple-touch-icon" sizes="180x180" href="">
    <meta name="theme-color" content="#ffffff">

    @stack('styles')
</head>

<body class="bg-gray-50 dark:bg-gray-800">
    <div class="flex flex-col min-h-screen bg-gray-50 dark:bg-gray-900">
        @include('layouts.admin.navbar')
        <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
            @include('layouts.admin.sidebar')
            <div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>
            <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
                <main>
                    <div class="px-4 pt-6">
                        @if (session('status'))
                            <x-alert type='success'>
                                This is a success alert
                            </x-alert>
                        @endif
                        @if (session('error'))
                            <x-alert type='error'>
                                This is an error alert
                            </x-alert>
                        @endif
                        @yield('main')
                    </div>
                </main>

            </div>
        </div>
        @include('layouts.admin.footer')

        @stack('scripts')
    </div>
</body>

</html>
