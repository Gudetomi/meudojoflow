<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 leading-tight">
            Editar Frequência
        </h2>
    </x-slot>

    <div class="bg-white p-6">
        <form action="{{ route('presenca.update', ['turma' => $turma->id, 'data' => $data]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div>
                    <label for="unidade_id" class="block text-sm font-medium text-gray-700">Unidade</label>
                    <input type="text" value="{{ $turma->unidade->nome_unidade }}" class="mt-1 block w-full bg-gray-100 rounded-md border-gray-300 shadow-sm" disabled>
                </div>
                <div>
                    <label for="turma_id" class="block text-sm font-medium text-gray-700">Turma</label>
                   <input type="text" value="{{ $turma->nome_turma }}" class="mt-1 block w-full bg-gray-100 rounded-md border-gray-300 shadow-sm" disabled>
                </div>
                <div>
                    <label for="data_presenca" class="block text-sm font-medium text-gray-700">Data da Aula</label>
                    <input type="date" name="data_presenca" value="{{ $data }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" readonly>
                </div>
            </div>
            <div id="lista-alunos">
                @php
                    // Cria um mapa de presenças para facilitar a verificação na view
                    $presencasMap = $presencas->keyBy('aluno_id');
                @endphp

                <div class="overflow-x-auto border rounded-lg mt-6 max-h-96 overflow-y-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-50 sticky top-0">
                            <tr>
                                <th class="py-3 px-6 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aluno</th>
                                <th class="py-3 px-6 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status da Presença</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($alunos as $aluno)
                                @php
                                    $estaPresente = $presencasMap->has($aluno->id) && $presencasMap[$aluno->id]->presente;
                                @endphp
                                <tr>
                                    <td class="py-4 px-6 whitespace-nowrap text-gray-800 align-middle">{{ $aluno->nome_aluno }}</td>
                                    <td class="py-4 px-6 whitespace-nowrap text-center align-middle">
                                        <label for="aluno_{{ $aluno->id }}" class="inline-flex items-center cursor-pointer">
                                            <div class="relative">
                                                <input type="checkbox" id="aluno_{{ $aluno->id }}" name="presencas[]" value="{{ $aluno->id }}" class="sr-only peer" {{ $estaPresente ? 'checked' : '' }}>
                                                <div class="block bg-gray-200 w-14 h-8 rounded-full peer-checked:bg-green-200"></div>
                                                <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition peer-checked:translate-x-full peer-checked:bg-green-500"></div>
                                            </div>
                                            <div id="toggle-text-{{ $aluno->id }}" class="ml-3 font-medium {{ $estaPresente ? 'text-gray-700' : 'text-red-600' }}">
                                                {{ $estaPresente ? 'Presente' : 'Ausente' }}
                                            </div>
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
            <div class="mt-6 flex justify-left gap-4">
                <button type="submit" class="inline-flex justify-center py-2 px-6 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700">
                    Atualizar Presenças
                </button>
                <a href="{{ route('presenca.index') }}" class="text-sm text-gray-600 hover:underline self-center">Cancelar</a>
            </div>
        </form>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#lista-alunos').on('change', 'input[type="checkbox"]', function() {
                    const alunoId = $(this).val();
                    const textLabel = $('#toggle-text-' + alunoId);
                    if ($(this).is(':checked')) {
                        textLabel.text('Presente').removeClass('text-red-600').addClass('text-gray-700');
                    } else {
                        textLabel.text('Ausente').removeClass('text-gray-700').addClass('text-red-600');
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>