<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Editar Unidade
        </h2>
    </x-slot>

    <div class="mt-6">
        <form action="{{ route('unidades.update', $unidade) }}" method="POST" class="space-y-4 max-w-md bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium">Nome da Unidade</label>
                <input type="text" name="nome_unidade" required class="mt-1 w-full border-gray-300 rounded shadow-sm"
                       value="{{ old('nome_unidade', $unidade->nome_unidade) }}">
                @error('nome_unidade') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="inline-flex items-center">
                    <input type="checkbox" name="ativo" value="1" {{ $unidade->ativo ? 'checked' : '' }}>
                    <span class="ml-2">Ativa</span>
                </label>
            </div>

            <div>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Atualizar
                </button>
                <a href="{{ route('unidades.index') }}" class="ml-4 text-gray-600 hover:underline">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>
