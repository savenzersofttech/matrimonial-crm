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

    <!-- Custom Theme Color -->
    <style>
        :root {
            --primary-color: #6777ef;
        }

        body {
            /* background-color: var(--primary-color); */
            font-family: 'Figtree', sans-serif;
        }

        .auth-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }

        a {
            color: var(--primary-color);
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <a href="/">
                <img width="150px" src="{{ asset('assets/img/logo2.png') }}" style="mix-blend-mode: multiply;" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 auth-card">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
