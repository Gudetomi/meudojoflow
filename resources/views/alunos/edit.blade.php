<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Editar Turma
        </h2>
    </x-slot>

    <div class="bg-white p-6">
        <form action="{{ route('turmas.update',$turma->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl">
                <div>
                    <label for="unidade_id" class="block text-sm font-medium text-gray-700">Unidade</label>
                    <select id="unidade_id" name="unidade_id" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Selecione uma unidade</option>
                        @foreach ($unidades as $unidade)
                            <option value="{{ $unidade->id }}" {{ old('unidade_id',$turma->unidade_id) == $unidade->id ? 'selected' : '' }}>
                                {{ $unidade->nome_unidade }}
                            </option>
                        @endforeach
                    </select>
                    @error('unidade_id') <p class="mt-1 text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="nome_turma" class="block text-sm font-medium text-gray-700">Nome da Turma</label>
                    <input type="text" id="nome_turma" name="nome_turma" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ old('nome_turma',$turma->nome_turma) }}">
                    @error('nome_turma') <p class="mt-1 text-red-500 text-xs">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="mt-6 flex items-center gap-4">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                    Salvar Turma
                </button>
                <a href="{{ route('turmas.index') }}" class="text-sm text-gray-600 hover:underline">Cancelar</a>
            </div>
        </form>
    </div>
</x-app-layout>