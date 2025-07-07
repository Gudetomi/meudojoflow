<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Unidades
        </h2>
    </x-slot>

    <div class="mt-6 space-y-4">
        <a href="{{ route('unidades.create') }}" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            + Nova Unidade
        </a>

        <div class="bg-white  p-4">
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b">
                        <th class="pb-2">Nome</th>
                        <th class="pb-2">Status</th>
                        <th class="pb-2">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($unidades as $unidade)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-2">{{ $unidade->nome_unidade }}</td>
                            <td>{{ $unidade->ativo ? 'Ativa' : 'Inativa' }}</td>
                            <td class="space-x-2">
                                <a href="{{ route('unidades.edit', $unidade) }}" class="text-blue-600 hover:underline">Editar</a>

                                <form action="{{ route('unidades.softDelete', $unidade) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Tem certeza?')" class="text-red-600 hover:underline">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if($unidades->isEmpty())
                        <tr>
                            <td colspan="3" class="py-4 text-center text-gray-500">Nenhuma unidade cadastrada.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
