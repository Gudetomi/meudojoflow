<div class="bg-white overflow-hidden p-4 h-full">
    <nav class="mt-4 flex flex-col space-y-1">
        <!-- Link Ativo -->
        <a href="{{ route('dashboard') }}" 
        class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-gray-200 text-gray-900' : 'text-gray-600 hover:bg-gray-100' }}">
            <x-heroicon-o-home class="w-5 h-5" />
            <span class="ml-3">Início</span>
        </a>
        <!-- Outros Links -->
        <a href="{{ route('unidades.index') }}" 
        class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('unidades') ? 'bg-gray-200 text-gray-900' : 'text-gray-600 hover:bg-gray-100' }}">
            <x-heroicon-o-building-office-2 class="w-5 h-5" />
            <span class="ml-3">Unidades</span>
        </a>
        <a href="{{ route('turmas.index') }}" 
        class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('turmas') ? 'bg-gray-200 text-gray-900' : 'text-gray-600 hover:bg-gray-100' }}">
            <x-heroicon-o-users class="w-5 h-5" />
            <span class="ml-3">Turmas</span>
        </a>
        <a href="{{ route('alunos.index') }}" 
        class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('alunos') ? 'bg-gray-200 text-gray-900' : 'text-gray-600 hover:bg-gray-100' }}">
            <x-heroicon-o-user class="w-5 h-5" />
            <span class="ml-3">Alunos</span>
        </a>
        <a href="{{ route('presenca.index') }}" 
        class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('presenca') ? 'bg-gray-200 text-gray-900' : 'text-gray-600 hover:bg-gray-100' }}">
            <x-heroicon-o-academic-cap  class="w-5 h-5" />
            <span class="ml-3">Controle de Presença</span>
        </a>
        <a href="{{ route('calendario.index') }}" 
        class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('calendario') ? 'bg-gray-200 text-gray-900' : 'text-gray-600 hover:bg-gray-100' }}">
            <x-heroicon-o-calendar-date-range  class="w-5 h-5" />
            <span class="ml-3">Calendário de Eventos</span>
        </a>
    </nav>
</div>