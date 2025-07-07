<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Unidades
        </h2>
    </x-slot>
    <div x-data>
        <div class="mt-6 space-y-4">
            <a href="{{ route('unidades.create') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                + Nova Unidade
            </a>

            <div class="bg-white p-4">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="pb-2">Nome</th>
                            <th class="pb-2">Status</th>
                            <th class="pb-2 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($unidades as $unidade)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-4">{{ $unidade->nome_unidade }}</td>
                                <td class="py-4">{{ $unidade->ativo ? 'Ativa' : 'Inativa' }}</td>
                                <td class="py-4 flex items-center justify-center space-x-2">
                                    <a href="{{ route('unidades.edit', $unidade->id) }}"
                                       class="inline-flex items-center px-3 py-1 text-sm text-white bg-black hover:bg-gray-800 rounded-md">
                                        ✏️ Editar
                                    </a>
                                    <button @click="$dispatch('open-exclusao-modal', { url: '{{ route('unidades.destroy', $unidade->id) }}' })"
                                            type="button"
                                            class="inline-flex items-center px-3 py-1 text-sm text-white bg-red-600 hover:bg-red-700 rounded-md">
                                        🗑️ Excluir
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-4 text-center text-gray-500">Nenhuma unidade cadastrada.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- O componente é simplesmente incluído aqui. Ele se auto-gerencia. --}}
        <x-exclusao-modal>
            Você tem certeza que deseja excluir esta unidade? Esta ação não poderá ser desfeita.
        </x-exclusao-modal>
    </div>
</x-app-layout>
