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

<body class="font-sans antialiased bg-gray-100 h-screen flex flex-col">
    
    {{-- 1. Barra de Navegação Superior (a toda a largura e não rola) --}}
    <header class="flex-shrink-0 bg-white border-b shadow-sm z-20">
        @include('layouts.navigation')
    </header>

    {{-- 2. Container Flex para o corpo da página (sidebar + conteúdo) --}}
    <div class="flex flex-grow overflow-hidden">
        
        {{-- 3. Sidebar (Menu Lateral) --}}
        <aside class="w-64 bg-white border-r shadow-sm hidden md:block flex-shrink-0">
            @include('layouts.sidebar')
        </aside>

        {{-- 4. Área de Conteúdo Principal (com scroll interno) --}}
        <main class="flex-1 p-6 overflow-y-auto">
            
            {{-- O seu slot de conteúdo principal, agora envolvendo o header --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Cabeçalho da Página (se existir) --}}
                @if (isset($header) && $header->isNotEmpty())
                    <header class="p-6 border-b border-gray-200">
                        <div class="text-xl font-semibold text-gray-800 leading-tight">
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
    
    @stack('scripts')
</body>

</html>