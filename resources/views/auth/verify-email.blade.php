@extends('layouts.auth')

@section('title', 'Verificar E-mail')

@section('content')
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Obrigado por se registrar! Antes de começar, confirme seu endereço de e-mail clicando no link que enviamos para você. 
        Caso não tenha recebido, podemos enviar novamente.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Um novo link de verificação foi enviado para o e-mail informado durante o cadastro.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <!-- Botão reenviar -->
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button>
                {{ __('Reenviar E-mail de Verificação') }}
            </x-primary-button>
        </form>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Sair') }}
            </button>
        </form>
    </div>
@endsection
