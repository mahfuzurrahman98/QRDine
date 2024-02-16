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
</head>

<body class="bg-gray-50 dark:bg-gray-800">
    @include('layouts.admin.navbar')
    <div class="flex pt-16 overflow-hidden bg-gray-50 dark:bg-gray-900">
        @include('layouts.admin.sidebar')
        <div class="fixed inset-0 z-10 hidden bg-gray-900/50 dark:bg-gray-900/90" id="sidebarBackdrop"></div>
        <div id="main-content" class="relative w-full h-full overflow-y-auto bg-gray-50 lg:ml-64 dark:bg-gray-900">
            @yield('main')

            @include('layouts.admin.footer')
        </div>
    </div>
</body>

</html>
