@props([
    'title' => 'Confirmar Exclusão',
    'buttonText' => 'Sim, Excluir'
])

<div
    x-data="{ show: false, actionUrl: '' }"
    @open-exclusao-modal.window="show = true; actionUrl = $event.detail.url"
    x-on:close.stop="show = false"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @keydown.escape.window="show = false"
    class="fixed inset-0 z-10 flex items-center justify-center bg-black bg-opacity-25 p-4"
    style="display: none;"
>
    {{-- Conteúdo do Modal --}}
    <div @click.away="show = false"
         x-show="show"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
         class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all max-w-lg"
         role="dialog" aria-modal="true" aria-labelledby="modal-headline">

        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                {{-- Ícone de Aviso --}}
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    {{-- Título --}}
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                        {{ $title }}
                    </h3>
                    {{-- Corpo do Modal --}}
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            {{ $slot }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Formulário Escondido --}}
        <form :action="actionUrl" method="POST" x-ref="modalForm" class="hidden">
            @csrf
            @method('DELETE')
        </form>

        {{-- Botões de Ação --}}
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:justify-end sm:space-x-3">
            <button @click="show = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto">
                Cancelar
            </button>
            <button @click="$refs.modalForm.submit()" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:mt-0 sm:w-auto">
                {{ $buttonText }}
            </button>
        </div>
    </div>
</div>
