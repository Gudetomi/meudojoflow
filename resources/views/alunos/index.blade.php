<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                Alunos
            </h2>
            <a href="{{ route('alunos.create') }}" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                Novo Aluno
            </a>
        </div>
    </x-slot>

    <div class="bg-white p-6 shadow-sm sm:rounded-lg">
        <!-- Formulário de Filtros e Pesquisa -->
        <div class="mb-6">
            <form action="{{ route('alunos.index') }}" method="GET" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    {{-- Filtro de Unidade --}}
                    <div>
                        <label for="unidade_id" class="block text-sm font-medium text-gray-700">Filtrar por Unidade</label>
                        <select id="unidade_id" name="unidade_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Todas as Unidades</option>
                            @foreach ($unidades as $unidade)
                                <option value="{{ $unidade->id }}" {{ ($filters['unidade_id'] ?? '') == $unidade->id ? 'selected' : '' }}>
                                    {{ $unidade->nome_unidade }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filtro de Turma --}}
                    <div>
                        <label for="turma_id" class="block text-sm font-medium text-gray-700">Filtrar por Turma</label>
                        <select id="turma_id" name="turma_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">Todas as Turmas</option>
                            @foreach ($turmas as $turma)
                                <option value="{{ $turma->id }}" {{ ($filters['turma_id'] ?? '') == $turma->id ? 'selected' : '' }}>
                                    {{ $turma->nome_turma }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Campo de Pesquisa por Texto --}}
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Pesquisar por Nome/CPF</label>
                        <input type="text" id="search" name="search" placeholder="Digite aqui..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" value="{{ $filters['search'] ?? '' }}">
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">Filtrar</button>
                    <a href="{{ route('alunos.index') }}" class="text-sm text-gray-600 hover:underline">Limpar Filtros</a>
                </div>
            </form>
        </div>

        <!-- Tabela de Alunos (código da tabela aqui) -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nome</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CPF</th>
                        <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telefone</th>
                        <th class="py-3 px-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($alunos as $aluno)
                        <tr>
                            <td class="py-4 px-6 whitespace-nowrap">{{ $aluno->nome_aluno }}</td>
                            <td class="py-4 px-6 whitespace-nowrap">{{ $aluno->cpf }}</td>
                            <td class="py-4 px-6 whitespace-nowrap">{{ $aluno->telefone }}</td>
                            <td class="py-4 px-6 whitespace-nowrap text-center">
                                <a href="{{ route('alunos.edit', $aluno->id) }}" class="text-indigo-600 hover:text-indigo-900">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 px-6 text-center text-gray-500">Nenhum aluno encontrado com os filtros aplicados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Links de Paginação -->
        <div class="mt-6">
            {{ $alunos->appends($filters)->links() }}
        </div>
    </div>
</x-app-layout>