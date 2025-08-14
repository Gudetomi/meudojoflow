@extends('layouts.auth')

@section('title', 'Cadastro')

@section('content')
    <h2 class="text-2xl font-bold text-gray-800 mb-2">Crie sua conta</h2>
    <p class="text-gray-600 mb-6">Preencha os dados abaixo para começar a usar o sistema.</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nome -->
        <div>
            <x-input-label for="name" :value="__('Nome')" />
            <x-text-input id="name" class="block mt-1 w-full"
                          type="text" name="name" :value="old('name')"
                          required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full"
                          type="email" name="email" :value="old('email')"
                          required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Senha -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Senha')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirmar Senha -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Senha')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                          type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="mt-6">
            <button type="submit"
                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm
                           text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none
                           focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Cadastrar
            </button>
        </div>

        <p class="mt-8 text-center text-sm text-gray-600">
            Já possui conta?
            <a href="{{ route('login') }}" class="font-medium text-red-600 hover:text-red-500">
                Entre agora
            </a>
        </p>
    </form>
@endsection
