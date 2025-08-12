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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Importa Inputmask -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')
        <!-- Page Content -->
        <main class="h-screen">
            <div class="flex min-h-screen">
                <aside class="w-80 flex-shrink-0 bg-white h-screen">
                    @include('layouts.sidebar')
                </aside>

                <main class="flex-1 p-6 bg-gray-100">
                    <div class="bg-white overflow-hidden sm:rounded-lg">
                        @if (isset($header))
                            <header class="bg-white shadow mb-6">
                                <div
                                    class="mx-auto py-6 px-4 sm:px-6 lg:px-8 text-xl font-semibold text-gray-800 leading-tight">
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
        </main>
    </div>
    @stack('scripts')
</body>

</html>
