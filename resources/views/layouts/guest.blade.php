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
    <body class="font-sans bg-gray-50 text-black/50 dark:bg-purple-950 dark:text-white/80 antialiased">
        <div class="flex flex-col items-center px-6 py-12 sm:pt-0 ">
            <div class="mt-12">
                <a href="/" wire:navigate class="text-2xl font-bold text-gray-900 dark:text-white/50">
                    Westpack Festspiele
                </a>
            </div>

            <div class="w-full sm:max-w-7xl lg:max-w-4xl mt-6 px-6 py-4 text-gray-900 dark:text-white/50 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
