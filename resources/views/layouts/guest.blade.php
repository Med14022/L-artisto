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

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Custom Style -->
        <style>
            body {
                font-family: 'Figtree', sans-serif;
                background: linear-gradient(to bottom, #1a1a1a, #000000);
                color: #fff;
            }
            .card-custom {
                background: #111;
                border: 1px solid #d4af37; /* doré */
                border-radius: 20px;
                box-shadow: 0 8px 25px rgba(0,0,0,0.7);
            }
            .btn-gold {
                background: #d4af37;
                color: #000;
                font-weight: bold;
                border-radius: 12px;
                transition: 0.3s;
            }
            .btn-gold:hover {
                background: #b9932f;
                color: #fff;
                transform: translateY(-2px);
            }
            .brand-logo img {
                width: 90px;
                margin-bottom: 15px;
            }
            h1 {
                color: #d4af37;
                font-weight: 600;
            }
        </style>
    </head>
    <body>
        <div class="min-vh-100 d-flex flex-column justify-content-center align-items-center">

            <!-- Logo + Title -->
            <div class="text-center mb-4 brand-logo">
                <a href="/">
                    <img src="{{ asset('images/logo.png') }}" alt="L'Artisto Barbershop">
                </a>
                <h1>L'Artisto Barbershop</h1>
                <p class="text-light">Votre style, notre passion</p>
            </div>

            <!-- Form Slot -->
            <div class="w-100 sm:max-w-md px-5 py-4 card-custom">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
