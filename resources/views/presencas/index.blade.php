<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Presenças
        </h2>
    </x-slot>
    <div class="bg-white p-6" x-data>
        <div class="mb-6">
            <form action="{{ route('presenca.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                    <div class="md:col-span-4">
                        <label for="unidade_id" class="block text-sm font-medium text-gray-700">Filtrar por
                            Unidade</label>
                        <select id="unidade_id" name="unidade_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Todas as Unidades</option>
                            @foreach ($unidades as $unidade)
                                <option value="{{ $unidade->id }}"
                                    {{ ($filters['unidade_id'] ?? '') == $unidade->id ? 'selected' : '' }}>
                                    {{ $unidade->nome_unidade }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:col-span-4">
                        <label for="turma_id" class="block text-sm font-medium text-gray-700">Filtrar por Turma</label>
                        <select id="turma_id" name="turma_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Selecione uma turma</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label for="data_inicial" class="block text-sm font-medium text-gray-700">Data Inicial</label>
                        <input type="date" name="data_inicial" id="data_inicial" value="{{ $filters['data_inicial'] ?? date('Y-m-d') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                    <div class="md:col-span-2">
                        <label for="data_final" class="block text-sm font-medium text-gray-700">Data Final</label>
                        <input type="date" name="data_final" id="data_final" value="{{ $filters['data_final'] ?? date('Y-m-d') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('presenca.create') }}"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        + Novo lançamento de Frequência
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">Filtrar</button>
                    <a href="{{ route('presenca.index') }}" class="text-sm text-gray-600 hover:underline">Limpar
                        Filtros</a>
                </div>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unidade
                        </th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Turma
                        </th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data
                        </th>
                        <th class="py-3 px-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($presencas as $presenca)
                        <tr>
                            <td class="py-4 px-6 whitespace-nowrap">{{$presenca->aluno->nome_aluno ?? 'Aluno não encontrado' }}</td>
                            <td class="py-4 px-6 whitespace-nowrap">{{$presenca->turma->nome_turma ?? 'Turma não encontrada' }}</td>
                            <td class="py-4 px-6 whitespace-nowrap">{{ $presenca->data_presenca }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-center">
                                <a href="{{ route('presencas.edit', $presenca->id) }}"
                                    class="inline-flex items-center px-3 py-1 text-sm text-white bg-black hover:bg-gray-800 rounded-md">
                                    ✏️ Editar
                                </a>
                                <button
                                    @click="$dispatch('open-exclusao-modal', { url: '{{ route('presencas.destroy', $presenca->id) }}' })"
                                    type="button"
                                    class="inline-flex items-center px-3 py-1 text-sm text-white bg-red-600 hover:bg-red-700 rounded-md">
                                    🗑️ Excluir
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 px-6 text-center text-gray-500">Nenhuma aula encontrada com
                                os filtros aplicados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <x-exclusao-modal>
            Você tem certeza que deseja excluir esta aula? Esta ação não poderá ser desfeita.
        </x-exclusao-modal>
        <div class="mt-6">
            {{ $presencas->appends($filters)->links() }}
        </div>
    </div>
    @push('scripts')
        <!-- Importa jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Importa Inputmask -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>

        <script>
            $('#unidade_id').on('change', function() {
                var unidadeId = $(this).val();
                if (unidadeId) {
                    $.getJSON(`/turmas/por-unidade/${unidadeId}`, function(data) {
                        var turmaSelect = $('#turma_id');
                        turmaSelect.empty();
                        turmaSelect.append('<option value="">Selecione uma turma</option>');
                        data.forEach(turma => {
                            turmaSelect.append(
                                `<option value="${turma.id}">${turma.nome_turma}</option>`);
                        });
                    });
                }
            });
        </script>
    @endpush

</x-app-layout>
