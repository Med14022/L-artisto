<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'L\'Artisto Barbershop') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Custom Styles -->
        <style>
            body {
                font-family: 'Figtree', sans-serif;
                background: linear-gradient(to bottom, #1a1a1a, #000000);
                color: #fff;
            }
            header {
                background: #111 !important;
                border-bottom: 2px solid #d4af37; /* doré */
            }
            header h2 {
                color: #d4af37;
                font-weight: bold;
            }
            nav {
                background: #000;
                border-bottom: 1px solid #d4af37;
            }
            nav a {
                color: #fff;
                font-weight: 500;
                transition: 0.3s;
            }
            nav a:hover {
                color: #d4af37;
            }
            .content-card {
                background: #111;
                border: 1px solid #d4af37;
                border-radius: 16px;
                padding: 25px;
                box-shadow: 0 6px 18px rgba(0, 0, 0, 0.7);
            }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen flex flex-col">

            <!-- Navigation -->
            @include('layouts.navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                        <h2 class="text-xl">
                            {{ $header }}
                        </h2>
                        <img src="{{ asset('images/logo.png') }}" alt="L'Artisto" class="h-12">
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-grow py-10 px-6">
                <div class="max-w-7xl mx-auto content-card">
                    {{ $slot }}
                </div>
            </main>

        </div>
    </body>
</html>
