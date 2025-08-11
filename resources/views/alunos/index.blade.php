<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Alunos
        </h2>
    </x-slot>
    <div class="bg-white p-6" x-data>
        <div class="mb-6">
            <form action="{{ route('alunos.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
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
                    <div>
                        <label for="turma_id" class="block text-sm font-medium text-gray-700">Filtrar por Turma</label>
                        <select id="turma_id" name="turma_id"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Selecione uma turma</option>
                        </select>
                    </div>
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Pesquisar por
                            Nome/CPF</label>
                        <input type="text" id="search" name="search" placeholder="Digite aqui..."
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            value="{{ $filters['search'] ?? '' }}">
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('alunos.create') }}"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        + Novo Aluno
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">Filtrar</button>
                    <a href="{{ route('alunos.index') }}" class="text-sm text-gray-600 hover:underline">Limpar
                        Filtros</a>
                </div>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome
                        </th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CPF
                        </th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Telefone</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Turma
                        </th>
                        <th class="py-3 px-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($alunos as $aluno)
                        <tr>
                            <td class="py-4 px-6 whitespace-nowrap">{{ $aluno->nome_aluno }}</td>
                            <td class="py-4 px-6 whitespace-nowrap">{{ $aluno->cpf }}</td>
                            <td class="py-4 px-6 whitespace-nowrap">{{ $aluno->telefone }}</td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                {{ $aluno->turma?->nome_turma ?? 'Sem turma' }}
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap text-center">
                                <a href="{{ route('alunos.edit', $aluno->id) }}"
                                    class="inline-flex items-center px-3 py-1 text-sm text-white bg-black hover:bg-gray-800 rounded-md">
                                    ✏️ Editar
                                </a>
                                <button
                                    @click="$dispatch('open-exclusao-modal', { url: '{{ route('alunos.destroy', $aluno->id) }}' })"
                                    type="button"
                                    class="inline-flex items-center px-3 py-1 text-sm text-white bg-red-600 hover:bg-red-700 rounded-md">
                                    🗑️ Excluir
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 px-6 text-center text-gray-500">Nenhum aluno encontrado com
                                os filtros aplicados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <x-exclusao-modal>
            Você tem certeza que deseja excluir este aluno? Esta ação não poderá ser desfeita.
        </x-exclusao-modal>
        <div class="mt-6 flex items-center justify-between">
            <div class="text-sm text-gray-700">
                {{ __('pagination.showing') }}
                <span class="font-medium">{{ $alunos->firstItem() }}</span>
                {{ __('pagination.to') }}
                <span class="font-medium">{{ $alunos->lastItem() }}</span>
                {{ __('pagination.of') }}
                <span class="font-medium">{{ $alunos->total() }}</span>
                {{ __('pagination.results') }}
            </div>

            {{-- Links da paginação (agora com o estilo do Tailwind) --}}
            <div>
                {{ $alunos->appends($filters)->links() }}
            </div>
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
