<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center gap-4 border border-gray-200">
            <div class="bg-blue-100 rounded-full p-4 flex-shrink-0">
                <x-heroicon-o-users class="w-8 h-8 text-blue-600" />
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Alunos Ativos</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalAlunosAtivos }}</p>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center gap-4 border border-gray-200">
            <div class="bg-purple-100 rounded-full p-4 flex-shrink-0">
                <x-heroicon-o-academic-cap class="w-8 h-8 text-purple-600" />
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Turmas Ativas</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalTurmasAtivas }}</p>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center gap-4 border border-gray-200">
            <div class="bg-indigo-100 rounded-full p-4 flex-shrink-0">
                <x-heroicon-o-building-office-2 class="w-8 h-8 text-indigo-600" />
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Unidades Ativas</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalUnidadesAtivas }}</p>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center gap-4 border border-gray-200">
            <div class="bg-green-100 rounded-full p-4 flex-shrink-0">
                <x-heroicon-o-check-circle class="w-8 h-8 text-green-600" />
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Taxa de Presença (Últimos 30 dias)</p>
                <p class="text-3xl font-bold text-gray-900">{{ $taxaDePresenca }}%</p>
            </div>
        </div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Próximos Eventos</h3>
        <div class="space-y-4">
            @forelse($proximosEventos as $evento)
                <div class="flex items-start gap-4">
                    <div class="bg-red-100 rounded-md p-2 text-center flex-shrink-0">
                        <p class="font-bold text-red-600 text-lg">{{ $evento->data_inicio->format('d') }}</p>
                        <p class="text-xs text-red-500 uppercase">{{ $evento->data_inicio->format('M') }}</p>
                    </div>
                    <div class="flex-grow">
                        <p class="font-semibold text-gray-900">{{ $evento->titulo }}</p>
                        <p class="text-sm text-gray-500">{{ Str::limit($evento->descricao, 50, '...') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-sm text-gray-500">Nenhum evento futuro agendado.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>