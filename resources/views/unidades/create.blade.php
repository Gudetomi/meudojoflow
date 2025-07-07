<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Nova Unidade
        </h2>
    </x-slot>

    <div class="mt-6">
        <form action="{{ route('unidades.store') }}" method="POST" class="space-y-6 max-w-md bg-white p-6">
            @csrf

            <div>
                <label class="block text-sm font-medium">Nome da Unidade</label>
                <input type="text" name="nome_unidade" required class="mt-1 w-full border-gray-300 rounded shadow-sm" value="{{ old('nome_unidade') }}">
                @error('nome_unidade') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Salvar
                </button>
                <a href="{{ route('unidades.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>
