<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        <!-- Card: Alunos Ativos -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center gap-4 border border-gray-200">
            <div class="bg-blue-100 rounded-full p-4 flex-shrink-0">
                <svg class="w-8 h-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m-7.5-2.962A3.75 3.75 0 0112 15v-2.25A3.75 3.75 0 0115.75 9v-2.25a2.25 2.25 0 00-2.25-2.25H12M7.5 15v-2.25A3.75 3.75 0 0111.25 9V6.75a2.25 2.25 0 00-2.25-2.25H7.5m0-3c-1.657 0-3 1.343-3 3v10.5a3 3 0 003 3h7.5a3 3 0 003-3V6.75a3 3 0 00-3-3H7.5z" />
                </svg>
            </div>
            <div>
              
            </div>
        </div>

        <!-- Card: Taxa de Presença -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex items-center gap-4 border border-gray-200">
            <div class="bg-green-100 rounded-full p-4 flex-shrink-0">
                <svg class="w-8 h-8 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                
            </div>
        </div>

        <!-- Card: Próximos Eventos -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 col-span-1 md:col-span-2 lg:col-span-1 border border-gray-200">
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

    </div>
</x-app-layout>
