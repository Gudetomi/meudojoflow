<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Cadastrar Novo Aluno
        </h2>
    </x-slot>
    <form action="{{ route('alunos.store') }}" method="POST" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="nome_aluno" class="block text-sm font-medium text-gray-700">Nome</label>
                <input type="text" name="nome_aluno" id="nome_aluno"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>

            <div>
                <label for="data_nascimento" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
                <input type="date" name="data_nascimento" id="data_nascimento"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>

            <div>
                <label for="cpf" class="block text-sm font-medium text-gray-700">CPF</label>
                <input type="text" name="cpf" id="cpf"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
        </div>

        {{-- Linha 2: Celular, E-mail, Idade --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="telefone" class="block text-sm font-medium text-gray-700">Celular</label>
                <input type="text" name="telefone" id="telefone"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                <input type="email" name="email" id="email"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label for="idade" class="block text-sm font-medium text-gray-700">Idade</label>
                <input type="text" name="idade" id="idade" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
        </div>

        {{-- Linha 3: Sexo, Unidade, Responsável --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="sexo" class="block text-sm font-medium text-gray-700">Sexo</label>
                <select name="sexo" id="sexo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    required>
                    <option value="">Selecione</option>
                    <option value="1">Masculino</option>
                    <option value="2">Feminino</option>
                </select>
            </div>

            <div>
                <label for="unidade_id" class="block text-sm font-medium text-gray-700">Unidade</label>
                <select name="unidade_id" id="unidade_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    required>
                    <option value="">Selecione</option>
                    @foreach ($unidades as $unidade)
                        <option value="{{ $unidade->id }}">{{ $unidade->nome_unidade }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="turma_id" class="block text-sm font-medium text-gray-700">Turma</label>
                <select name="turma_id" id="turma_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                    required>
                    <option value="">Selecione uma turma</option>
                </select>
            </div>

            <div>
                <label for="possui_responsavel" class="block text-sm font-medium text-gray-700">Possui
                    Responsável?</label>
                <select name="possui_responsavel" id="possui_responsavel"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                    <option value="1">Sim</option>
                    <option  selected value="0">Não</option>
                </select>
            </div>
        </div>
        <div id="campos_responsavel" class="hidden ">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <div class="md:col-span-4">
                    <label for="nome_aluno" class="block text-sm font-medium text-gray-700">Nome do Responsável</label>
                    <input type="text" name="nome_responsavel" id="nome_aluno"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div class="md:col-span-2">
                    <label for="cpf" class="block text-sm font-medium text-gray-700">CPF do Responsável</label>
                    <input type="text" name="cpf_responsavel" id="cpf_responsavel"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" >
                </div>
                <div class="md:col-span-2">
                    <label for="telefone" class="block text-sm font-medium text-gray-700">Celular do Responsável</label>
                    <input type="text" name="telefone_responsavel" id="telefone_responsavel"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div class="md:col-span-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">E-mail do Responsável</label>
                    <input type="email" name="email_responsavel" id="email_responsavel"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>
        </div>
        {{-- Linha 4: Endereço --}}
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-1 ">
                <label for="cep" class="block text-sm font-medium text-gray-700">CEP</label>
                <input type="text" name="cep" id="cep"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
            <div class="md:col-span-3">
                <label for="endereco" class="block text-sm font-medium text-gray-700">Endereço</label>
                <input type="text" name="endereco" id="endereco"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
            <div>
                <label for="numero" class="block text-sm font-medium text-gray-700">Número</label>
                <input type="text" name="numero" id="numero"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
            </div>
            <div class="md:col-span-3">
                <label for="bairro" class="block text-sm font-medium text-gray-700">Bairro</label>
                <input type="text" name="bairro" id="bairro"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
            <div class="md:col-span-3">
                <label for="cidade" class="block text-sm font-medium text-gray-700">Cidade</label>
                <input type="text" name="cidade" id="cidade"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
            <div>
                <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                <input type="text" name="estado" id="estado"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
            </div>
        </div>


        <div class="mt-6 flex justify-left gap-4">
            <button type="submit"
                class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                Salvar
            </button>
            <a href="{{ route('alunos.index') }}"
                class="text-sm text-gray-600 hover:underline self-center">Cancelar</a>
        </div>
    </form>
    </div>
    @push('scripts')
        <!-- Importa jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Importa Inputmask -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>


        <script>
            $(function() {
                $('#cpf').inputmask('999.999.999-99');
                $('#telefone').inputmask('(99) 99999-9999');
                $('#cep').inputmask('99999-999');
                $('#cpf_responsavel').inputmask('999.999.999-99');
                $('#telefone_responsavel').inputmask('(99) 99999-9999');

                $('#cep').on('blur', function() {
                    var cep = $(this).val().replace(/\D/g, '');
                    if (cep.length === 8) {
                        $.getJSON('https://viacep.com.br/ws/' + cep + '/json/', function(data) {
                            if (!data.erro) {
                                $('#endereco').val(data.logradouro);
                                $('#bairro').val(data.bairro);
                                $('#cidade').val(data.localidade);
                                $('#estado').val(data.uf);
                            }
                        });
                    }
                });
            });
            document.addEventListener('DOMContentLoaded', function() {
                const nascimentoInput = document.getElementById('data_nascimento');
                const idadeInput = document.getElementById('idade');

                nascimentoInput.addEventListener('change', function() {
                    const dataNascimento = new Date(this.value);
                    const hoje = new Date();

                    if (!isNaN(dataNascimento.getTime())) {
                        let idade = hoje.getFullYear() - dataNascimento.getFullYear();
                        const mesAtual = hoje.getMonth();
                        const diaAtual = hoje.getDate();
                        const mesNascimento = dataNascimento.getMonth();
                        const diaNascimento = dataNascimento.getDate();

                        if (mesAtual < mesNascimento || (mesAtual === mesNascimento && diaAtual <
                            diaNascimento)) {
                            idade--;
                        }

                        idadeInput.value = idade >= 0 ? idade : '';
                    } else {
                        idadeInput.value = '';
                    }
                });
            });
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
            $('#possui_responsavel').on('change', function() {
                const valor = $(this).val();
                if (valor === '1') {
                    $('#campos_responsavel').removeClass('hidden');
                } else {
                    $('#campos_responsavel').addClass('hidden');
                    // Limpa os campos ao esconder
                    $('#nome_responsavel, #cpf_responsavel, #email_responsavel, #telefone_responsavel').val('');
                }
            });
        </script>
    @endpush
</x-app-layout>
