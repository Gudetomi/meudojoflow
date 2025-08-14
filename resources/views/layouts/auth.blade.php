<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="flex flex-col md:flex-row min-h-screen bg-white">
        <!-- Coluna Esquerda (Branding) -->
        <div class="w-full md:w-1/2 bg-white flex items-center justify-center p-6 md:p-12 order-2 md:order-1">
            <div class="text-center max-w-md">
                <img src="{{ asset('logo.png') }}" alt="Logo">
                <h1 class="mt-8 text-3xl font-bold tracking-tight text-gray-900">
                    Seu Sistema de Gestão
                </h1>
                <p class="mt-4 text-lg text-gray-600">
                    Gerencie unidades, turmas e alunos com facilidade.
                </p>
            </div>
        </div>

        <!-- Coluna Direita (Conteúdo do Formulário) -->
        <div class="w-full md:w-1/2 flex items-center bg-gray-50 justify-center p-6 md:p-12 order-1 md:order-2">
            <div class="w-full max-w-sm">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
