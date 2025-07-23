<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-g">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="flex flex-col md:flex-row min-h-screen bg-white">
            <!-- Seção Esquerda (Branding/Logo) -->
            <div class="w-full md:w-1/2 bg-gray-50 flex items-center justify-center p-6 md:p-12 order-2 md:order-1">
                <div class="text-center max-w-md">
                    {{-- Substitua este SVG pelo seu logo ou use o x-application-logo --}}
                    <img src="{{ asset('logo.png') }}" alt="DojoManager Logo">
                    <h1 class="mt-8 text-3xl font-bold tracking-tight text-gray-900">
                        Seu Sistema de Gestão
                    </h1>
                    <p class="mt-4 text-lg text-gray-600">
                        Acesse sua conta para gerenciar suas unidades, turmas e alunos de forma simples e eficiente.
                    </p>
                </div>
            </div>

            <!-- Seção Direita (Formulário de Login) -->
            <div class="w-full md:w-1/2 flex items-center justify-center p-6 md:p-12 order-1 md:order-2">
                <div class="w-full max-w-sm">
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">Bem-vindo de volta!</h2>
                    <p class="text-gray-600 mb-6">Por favor, insira seus dados para continuar.</p>

                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mt-4">
                            <div class="flex items-center justify-between">
                                <x-input-label for="password" :value="__('Senha')" />
                                @if (Route::has('password.request'))
                                    <a class="text-sm text-red-600 hover:text-red-500 font-medium" href="{{ route('password.request') }}">
                                        Esqueceu a senha?
                                    </a>
                                @endif
                            </div>
                            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me -->
                        <div class="block mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500" name="remember">
                                <span class="ms-2 text-sm text-gray-600">{{ __('Lembrar de mim') }}</span>
                            </label>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Entrar
                            </button>
                        </div>

                        {{-- Link para registro, se houver --}}
                        @if (Route::has('register'))
                            <p class="mt-8 text-center text-sm text-gray-600">
                                Não tem uma conta?
                                <a href="{{ route('register') }}" class="font-medium text-red-600 hover:text-red-500">
                                    Crie uma agora
                                </a>
                            </p>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
