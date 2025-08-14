@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Bem-vindo de volta!</h2>
    <p class="text-gray-600 mb-6">Por favor, insira seus dados para continuar.</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full"
                          type="email" name="email"
                          :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Senha -->
        <div class="mt-4">
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Senha')" />
                @if (Route::has('password.request'))
                    <a class="text-sm text-red-600 hover:text-red-500 font-medium"
                       href="{{ route('password.request') }}">
                        Esqueceu a senha?
                    </a>
                @endif
            </div>
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Lembrar -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded border-gray-300 text-red-600 shadow-sm focus:ring-red-500"
                       name="remember">
                <span class="ms-2 text-sm text-gray-600">Lembrar de mim</span>
            </label>
        </div>

        <div class="mt-6">
            <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm
                           text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none
                           focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Entrar
            </button>
        </div>

        @if (Route::has('register'))
            <p class="mt-8 text-center text-sm text-gray-600">
                Não tem uma conta?
                <a href="{{ route('register') }}" class="font-medium text-red-600 hover:text-red-500">
                    Crie uma agora
                </a>
            </p>
        @endif
    </form>
@endsection
