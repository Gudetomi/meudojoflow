<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Editar Unidade
        </h2>
    </x-slot>
    <div class="bg-white p-6">
        <form action="{{ route('unidades.update', $unidade->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label for="nome_unidade" class="block text-sm font-medium text-gray-700">Nome da Unidade</label>
            <div class="mt-1 flex items-center gap-4">
                <div class="flex-grow max-w-md">
                    <input type="text" id="nome_unidade" name="nome_unidade" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" value="{{ old('nome_unidade', $unidade->nome_unidade) }}">
                    @error('nome_unidade') <p class="mt-1 text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>
                <div class="flex-shrink-0">
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Atualizar
                    </button>
                    <a href="{{ route('unidades.index') }}" class="ml-4 text-sm text-gray-600 hover:underline">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>