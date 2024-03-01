<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }} Menu</title>
    @vite(['resources/css/app.css', 'resources/js/restaurant-front.js'])

    <style>
        .category-link.cat-active {
            /* Styles for active category link */
            color: #fff;
            background-color: #030a12;
        }
    </style>

</head>

<body class="bg-gray-100 relative">

    @include('templates.hunger-template')

  </body>

</html>
