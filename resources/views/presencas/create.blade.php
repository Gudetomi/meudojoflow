<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Cadastrar Nova Frequência
        </h2>
    </x-slot>

    <div class="bg-white p-6">
        <form action="{{ route('presenca.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="unidade_id" class="block text-sm font-medium text-gray-700">Unidade</label>
                    <select name="unidade_id" id="unidade_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        <option value="">Selecione</option>
                        @foreach ($unidades as $unidade)
                            <option value="{{ $unidade->id }}">{{ $unidade->nome_unidade }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="turma_id" class="block text-sm font-medium text-gray-700">Turma</label>
                    <select name="turma_id" id="turma_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        <option value="">Selecione uma unidade primeiro</option>
                    </select>
                </div>
                <div>
                    <label for="data_presenca" class="block text-sm font-medium text-gray-700">Data da Aula</label>
                    <input type="date" name="data_presenca" id="data_presenca" value="{{ old('data_presenca', date('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
            </div>

            <!-- Lista de Alunos (será preenchida via AJAX como uma tabela) -->
            <div id="lista-alunos">
                {{-- O JavaScript irá inserir a tabela de alunos aqui --}}
            </div>
            @if ($errors->any())
                <div class="mt-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div id="botao-salvar-container" class="mt-6 flex justify-left gap-4 hidden">
                <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                    Salvar
                </button>
                <a href="{{ route('presenca.index') }}" class="text-sm text-gray-600 hover:underline self-center">Cancelar</a>
            </div>
        </form>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                // Função para carregar turmas baseada na unidade
                $('#unidade_id').on('change', function() {
                    var unidadeId = $(this).val();
                    var turmaSelect = $('#turma_id');
                    var listaAlunosDiv = $('#lista-alunos');
                    var botaoSalvar = $('#botao-salvar-container');

                    turmaSelect.empty().append('<option value="">Carregando...</option>');
                    listaAlunosDiv.empty();
                    botaoSalvar.addClass('hidden');

                    if (unidadeId) {
                        // Usando a sua rota para buscar turmas
                        $.getJSON(`/turmas/por-unidade/${unidadeId}`, function(data) {
                            turmaSelect.empty().append('<option value="">Selecione uma turma</option>');
                            data.forEach(turma => {
                                turmaSelect.append(`<option value="${turma.id}">${turma.nome_turma}</option>`);
                            });
                        });
                    } else {
                        turmaSelect.empty().append('<option value="">Selecione uma unidade primeiro</option>');
                    }
                });
                $('#turma_id').on('change', function() {
                    var turmaId = $(this).val();
                    var listaAlunosDiv = $('#lista-alunos');
                    var botaoSalvar = $('#botao-salvar-container');

                    if (!turmaId) {
                        listaAlunosDiv.empty();
                        botaoSalvar.addClass('hidden');
                        return;
                    }

                    // Faz a chamada AJAX para buscar os alunos
                    $.ajax({
                        url: '/alunos/por-turma/' + turmaId,
                        type: 'GET',
                        success: function(alunos) {
                            listaAlunosDiv.empty();
                            if (alunos.length > 0) {
                                var tableHtml = `
                                    <div class="overflow-x-auto border rounded-lg mt-6">
                                        <table class="min-w-full bg-white">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aluno</th>
                                                    <th class="py-3 px-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status da Presença</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                            </tbody>
                                        </table>
                                    </div>
                                `;
                                listaAlunosDiv.append(tableHtml);
                                var tableBody = listaAlunosDiv.find('tbody');
                                $.each(alunos, function(index, aluno) {
                                    var alunoRowHtml = `
                                        <tr>
                                            <td class="py-4 px-6 whitespace-nowrap text-gray-800">${aluno.nome_aluno}</td>
                                            <td class="py-4 px-6 whitespace-nowrap">
                                                <label for="aluno_${aluno.id}" class="flex items-center justify-center cursor-pointer">
                                                    <div class="relative">
                                                        <input type="checkbox" id="aluno_${aluno.id}" name="presencas[]" value="${aluno.id}" class="sr-only" checked>
                                                        <div class="block bg-gray-200 w-14 h-8 rounded-full"></div>
                                                        <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition"></div>
                                                    </div>
                                                    <div class="ml-3 text-gray-700 font-medium">Presente</div>
                                                </label>
                                            </td>
                                        </tr>
                                    `;
                                    tableBody.append(alunoRowHtml);
                                });
                                botaoSalvar.removeClass('hidden');
                            } else {
                                listaAlunosDiv.append('<p class="text-gray-500 mt-4">Nenhum aluno encontrado para esta turma.</p>');
                                botaoSalvar.addClass('hidden');
                            }
                        },
                        error: function() {
                            listaAlunosDiv.empty().append('<p class="text-red-500 mt-4">Ocorreu um erro ao carregar os alunos.</p>');
                            botaoSalvar.addClass('hidden');
                        }
                    });
                });
            });
        </script>
        {{-- Estilos para o Toggle Switch --}}
        <style>
            input:checked ~ .dot {
                transform: translateX(100%);
                background-color: #48bb78; /* Cor verde quando presente */
            }
            input:checked ~ .block {
                background-color: #c6f6d5; /* Fundo verde claro quando presente */
            }
        </style>
    @endpush
</x-app-layout>