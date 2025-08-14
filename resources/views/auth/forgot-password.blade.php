@extends('layouts.auth')

@section('title', 'Esqueci minha senha')

@section('content')
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Esqueceu sua senha? Sem problema. Informe seu e-mail e nós enviaremos um link para redefini-la.') }}
    </div>

    <!-- Status da sessão -->
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- E-mail -->
        <div>
            <x-input-label for="email" :value="__('E-mail')" />
            <x-text-input id="email" class="block mt-1 w-full"
                          type="email" name="email"
                          :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Enviar link de redefinição') }}
            </x-primary-button>
        </div>
    </form>
@endsection
