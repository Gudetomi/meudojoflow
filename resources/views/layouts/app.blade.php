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
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Importa Inputmask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
</head>

<body class="font-sans antialiased bg-gray-100">
    {{-- CORREÇÃO: O container principal agora é o 'flex' para alinhar a sidebar e o conteúdo --}}
    <div class="flex min-h-screen">
        
        {{-- 1. Sidebar (Menu Lateral) --}}
        <aside class="w-80 bg-white border-r shadow-sm hidden md:block">
            @include('layouts.sidebar')
        </aside>

        {{-- 2. Área de Conteúdo Principal (que contém tudo o resto) --}}
        <div class="flex-1 flex flex-col">
            
            {{-- Barra de Navegação Superior --}}
            @include('layouts.navigation')

            {{-- Conteúdo do Slot Principal (a parte que cresce e rola) --}}
            <main class="flex-grow p-6">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                     @if (isset($header))
                        <header class="bg-white shadow-sm">
                            <div class="mx-auto py-6 px-4 sm:px-6 lg:px-8 text-xl font-semibold text-gray-800 leading-tight">
                                {{ $header }}
                            </div>
                        </header>
                    @endif
                    <div class="p-6 text-gray-900">
                        {{ $slot }}
                    </div>
                </div>
            </main>

        </div>
    </div>
    @stack('scripts')
</body>

</html>
