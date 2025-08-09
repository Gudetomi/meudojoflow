<div class="p-4 bg-gray-50">
    <table class="min-w-full bg-white rounded-md shadow-inner">
        <thead class="border-b">
            <tr>
                <th class="py-2 px-4 text-left text-xs font-semibold text-gray-600 uppercase">Aluno</th>
                <th class="py-2 px-4 text-center text-xs font-semibold text-gray-600 uppercase">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($presencas as $presenca)
                <tr class="border-t">
                    <td class="py-3 px-4 whitespace-nowrap">{{ $presenca->aluno->nome_aluno ?? 'Aluno não encontrado' }}</td>
                    <td class="py-3 px-4 whitespace-nowrap text-center">
                        @if ($presenca->presente)
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Presente
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                Ausente
                            </span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr class="border-t">
                    <td colspan="2" class="py-3 px-4 text-center text-gray-500">Nenhum aluno encontrado para esta aula.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>