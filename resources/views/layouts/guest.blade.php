<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased" style="background-color: #556B2F;">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        
        <!-- Logo -->
        <img src="{{ asset('imagenes/logo1.png') }}" alt="Logo Sistema" class="mb-8" style="max-width: 250px; height: auto;">

        <!-- Caja blanca central -->
        <div class="w-full sm:max-w-md px-6 py-6 bg-white shadow-lg rounded-lg border border-[#e9e3c4]">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
