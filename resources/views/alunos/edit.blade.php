<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Editar Aluno
        </h2>
    </x-slot>
    <div class="bg-white p-6 shadow-sm sm:rounded-lg mb-8">
        <h3 class="text-lg font-semibold text-gray-800 border-b pb-4 mb-6">Dados Pessoais</h3>
        <form action="{{ route('alunos.update', $aluno->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="nome_aluno" class="block text-sm font-medium text-gray-700">Nome</label>
                    <input type="text" name="nome_aluno" id="nome_aluno"
                        value="{{ old('nome_aluno', $aluno->nome_aluno) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label for="data_nascimento" class="block text-sm font-medium text-gray-700">Data de
                        Nascimento</label>
                    <input type="date" name="data_nascimento" id="data_nascimento"
                        value="{{ old('data_nascimento', $aluno->data_nascimento) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label for="cpf" class="block text-sm font-medium text-gray-700">CPF</label>
                    <input type="text" name="cpf" id="cpf" value="{{ old('cpf', $aluno->cpf) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="telefone" class="block text-sm font-medium text-gray-700">Celular</label>
                    <input type="text" name="telefone" id="telefone" value="{{ old('telefone', $aluno->telefone) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $aluno->email) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="idade" class="block text-sm font-medium text-gray-700">Idade</label>
                    <input type="text" name="idade" id="idade" value="{{ old('idade', $aluno->idade) }}"
                        readonly class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100">
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="sexo" class="block text-sm font-medium text-gray-700">Sexo</label>
                    <select name="sexo" id="sexo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                        required>
                        <option value="">Selecione</option>
                        <option value="1" {{ old('sexo', $aluno->sexo) == 1 ? 'selected' : '' }}>Masculino</option>
                        <option value="2" {{ old('sexo', $aluno->sexo) == 2 ? 'selected' : '' }}>Feminino</option>
                    </select>
                </div>
                <div>
                    <label for="unidade_id" class="block text-sm font-medium text-gray-700">Unidade</label>
                    <select name="unidade_id" id="unidade_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        <option value="">Selecione</option>
                        @foreach ($unidades as $unidade)
                            <option value="{{ $unidade->id }}"
                                {{ old('unidade_id', $aluno->unidade_id) == $unidade->id ? 'selected' : '' }}>
                                {{ $unidade->nome_unidade }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="turma_id" class="block text-sm font-medium text-gray-700">Turma</label>
                    <select name="turma_id" id="turma_id"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        <option value="">Selecione uma turma</option>
                        @foreach ($turmas as $turma)
                            <option value="{{ $turma->id }}" {{ old('turma_id', $aluno->turma_id) == $turma->id ? 'selected' : '' }}>
                                {{ $turma->nome_turma }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="possui_responsavel" class="block text-sm font-medium text-gray-700">Possui
                        Responsável?</label>
                    <select name="possui_responsavel" id="possui_responsavel"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        <option value="1"
                            {{ old('possui_responsavel', $aluno->possui_responsavel) == 1 ? 'selected' : '' }}>Sim
                        </option>
                        <option value="0"
                            {{ old('possui_responsavel', $aluno->possui_responsavel) == 0 ? 'selected' : '' }}>Não
                        </option>
                    </select>
                </div>
            </div>
            <div id="campos_responsavel"
                class="{{ old('possui_responsavel', $aluno->possui_responsavel) ? '' : 'hidden' }}">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-6 pt-6 border-t">
                    <div class="md:col-span-4">
                        <label for="nome_responsavel" class="block text-sm font-medium text-gray-700">Nome do
                            Responsável</label>
                        <input type="text" name="nome_responsavel" id="nome_responsavel"
                            value="{{ old('nome_responsavel', $aluno->responsavel->nome_responsavel ?? '') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label for="cpf_responsavel" class="block text-sm font-medium text-gray-700">CPF do
                            Responsável</label>
                        <input type="text" name="cpf_responsavel" id="cpf_responsavel"
                            value="{{ old('cpf_responsavel', $aluno->responsavel->cpf_responsavel ?? '') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="md:col-span-2">
                        <label for="telefone_responsavel" class="block text-sm font-medium text-gray-700">Celular do
                            Responsável</label>
                        <input type="text" name="telefone_responsavel" id="telefone_responsavel"
                            value="{{ old('telefone_responsavel', $aluno->responsavel->telefone_responsavel ?? '') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                    <div class="md:col-span-4">
                        <label for="email_responsavel" class="block text-sm font-medium text-gray-700">E-mail do
                            Responsável</label>
                        <input type="email" name="email_responsavel" id="email_responsavel"
                            value="{{ old('email_responsavel', $aluno->responsavel->email_responsavel ?? '') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-1 ">
                    <label for="cep" class="block text-sm font-medium text-gray-700">CEP</label>
                    <input type="text" name="cep" id="cep" value="{{ old('cep', $aluno->cep ?? '') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div class="md:col-span-3">
                    <label for="endereco" class="block text-sm font-medium text-gray-700">Endereço</label>
                    <input type="text" name="endereco" id="endereco"
                        value="{{ old('endereco', $aluno->endereco ?? '') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label for="numero" class="block text-sm font-medium text-gray-700">Número</label>
                    <input type="text" name="numero" id="numero"
                        value="{{ old('numero', $aluno->numero ?? '') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div class="md:col-span-3">
                    <label for="bairro" class="block text-sm font-medium text-gray-700">Bairro</label>
                    <input type="text" name="bairro" id="bairro"
                        value="{{ old('bairro', $aluno->bairro ?? '') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div class="md:col-span-3">
                    <label for="cidade" class="block text-sm font-medium text-gray-700">Cidade</label>
                    <input type="text" name="cidade" id="cidade"
                        value="{{ old('cidade', $aluno->cidade ?? '') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                    <input type="text" name="estado" id="estado"
                        value="{{ old('estado', $aluno->estado ?? '') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>
            </div>
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="mt-6 flex justify-left gap-4">
                <button type="submit"
                    class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                    Atualizar Aluno
                </button>
                <a href="{{ route('alunos.index') }}"
                    class="text-sm text-gray-600 hover:underline self-center">Cancelar</a>
            </div>
        </form>
    </div>
    <div class="bg-white p-6 shadow-sm sm:rounded-lg">
        <h3 class="text-lg font-semibold text-gray-800 border-b pb-4 mb-6">Histórico de Graduações</h3>
        <div class="overflow-x-auto mb-8">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase">Faixa</th>
                        <th class="py-2 px-4 text-left text-xs font-medium text-gray-500 uppercase">Data da Graduação
                        </th>
                        <th class="py-2 px-4 text-center text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($aluno->graduacoes as $graduacao)
                        <tr>
                            <td class="py-3 px-4">{{ $graduacao->faixa->nome }}</td>
                            <td class="py-3 px-4">{{ $graduacao->data_graduacao->format('d/m/Y') }}</td>
                            <td class="py-3 px-4 text-center">
                                <button type="button"
                                    class="text-white bg-red-600 hover:bg-red-700 px-3 py-1 rounded-md remove-graduacao-btn"
                                    onclick="window.dispatchEvent(new CustomEvent('open-exclusao-modal', { 
                                    bubbles: true, 
                                    detail: { 
                                        url: '{{ route('graduacoes.destroy', $graduacao->id) }}',
                                        rowId: 'graduacao-row-{{ $graduacao->id }}'
                                    } 
                                }))">
                                    🗑️ Remover
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-4 px-4 text-center text-gray-500">Nenhum registo de graduação
                                encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <h4 class="text-md font-semibold text-gray-700 border-t pt-6">Registar Nova Graduação</h4>
        <form action="{{ route('graduacoes.store') }}" method="POST" class="mt-4 space-y-4">
            @csrf
            <input type="hidden" name="aluno_id" value="{{ $aluno->id }}">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div>
                    <label for="faixa_id" class="block text-sm font-medium text-gray-700">Nova Faixa</label>
                    <select name="faixa_id" id="faixa_id"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">Selecione a faixa</option>
                        @foreach ($faixas as $faixa)
                            <option value="{{ $faixa->id }}">{{ $faixa->nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="data_graduacao" class="block text-sm font-medium text-gray-700">Data da
                        Graduação</label>
                    <input type="date" name="data_graduacao" id="data_graduacao" value="{{ date('Y-m-d') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>
                <div class="flex-shrink-0">
                    <button type="submit"
                        class="w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                        Salvar Graduação
                    </button>
                </div>
            </div>
            <div>
                <label for="observacoes" class="block text-sm font-medium text-gray-700">Observações
                    (Opcional)</label>
                <textarea name="observacoes" id="observacoes" rows="2"
                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"></textarea>
            </div>
        </form>
        <x-exclusao-modal id="exclusao-modal">
            Você tem certeza que deseja excluir esta graduação?
        </x-exclusao-modal>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                window.addEventListener('open-exclusao-modal', function(e) {
                    const modal = document.getElementById('exclusao-modal');
                    const url = e.detail.url;
                    const rowId = e.detail.rowId;

                    modal.style.display = 'block';

                    const confirmButton = modal.querySelector('#confirm-delete-button');
                });

                // Fechar modal
                document.querySelectorAll('.modal-cancel-button, .modal-overlay').forEach(el => {
                    el.addEventListener('click', function() {
                        document.getElementById('exclusao-modal').style.display = 'none';
                    });
                });
            });
            $(function() {
                $('#cpf, #cpf_responsavel').inputmask('999.999.999-99');
                $('#telefone, #telefone_responsavel').inputmask('(99) 99999-9999');
                $('#cep').inputmask('99999-999');

                $('#cep').on('blur', function() {
                    /* ... Lógica ViaCEP ... */ });

              $('#unidade_id').on('change', function() {
    var unidadeId = $(this).val();
    var turmaSelect = $('#turma_id');

    // Guarda a turma selecionada antes de limpar
    var selectedTurma = turmaSelect.data('selected') || '';

    turmaSelect.empty().append('<option value="">Carregando...</option>');

    if (unidadeId) {
        $.getJSON(`/turmas/por-unidade/${unidadeId}`, function(data) {
            turmaSelect.empty().append('<option value="">Selecione uma turma</option>');
            data.forEach(turma => {
                // Mantém a turma selecionada se estiver na nova lista
                var isSelected = turma.id == selectedTurma ? 'selected' : '';
                turmaSelect.append(
                    `<option value="${turma.id}" ${isSelected}>${turma.nome_turma}</option>`
                );
            });
        });
    } else {
        turmaSelect.empty().append('<option value="">Selecione uma turma</option>');
    }
});
$('#turma_id').data('selected', '{{ $aluno->turma_id }}');
            });

            document.addEventListener('DOMContentLoaded', function() {
                const nascimentoInput = document.getElementById('data_nascimento');
                const idadeInput = document.getElementById('idade');
                const camposResponsavel = document.getElementById('campos_responsavel');
                const possuiResponsavelSelect = document.getElementById('possui_responsavel');
                const campos = ['#nome_responsavel', '#cpf_responsavel', '#telefone_responsavel', '#email_responsavel'];

                function toggleResponsavelFields() {
                    const show = possuiResponsavelSelect.value == '1';
                    camposResponsavel.classList.toggle('hidden', !show);
                    campos.forEach(campo => {
                        $(campo).prop('required', show);
                        if (!show) $(campo).val('');
                    });
                }

                function calcularIdade() {
                    const dataNascimento = new Date(nascimentoInput.value);
                    if (!isNaN(dataNascimento.getTime())) {
                        let idade = new Date().getFullYear() - dataNascimento.getFullYear();
                        const m = new Date().getMonth() - dataNascimento.getMonth();
                        if (m < 0 || (m === 0 && new Date().getDate() < dataNascimento.getDate())) {
                            idade--;
                        }
                        idadeInput.value = idade >= 0 ? idade : '';
                        if (idade < 18) {
                            possuiResponsavelSelect.value = '1';
                        }
                        toggleResponsavelFields();
                    } else {
                        idadeInput.value = '';
                    }
                }

                nascimentoInput.addEventListener('change', calcularIdade);
                possuiResponsavelSelect.addEventListener('change', toggleResponsavelFields);

                calcularIdade();
            });
        </script>
    @endpush
</x-app-layout>
