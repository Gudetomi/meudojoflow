<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight mb-4 md:mb-0">
                Calendário de Eventos
            </h2>
            <div class="flex items-center gap-4">
                <button id="share-button" class="inline-flex items-center gap-2 px-3 py-1.5 text-sm bg-gray-700 text-white rounded-md hover:bg-gray-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M15 8a3 3 0 10-2.977-2.63l-4.94 2.47a3 3 0 100 4.319l4.94 2.47a3 3 0 10.895-1.789l-4.94-2.47a3.027 3.027 0 000-.74l4.94-2.47C13.456 7.68 14.19 8 15 8z" />
                    </svg>
                    <span>Compartilhar</span>
                </button>
                <button id="add-event-button" class="inline-flex items-center gap-2 px-3 py-1.5 text-sm bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                    </svg>
                    <span>Novo Evento</span>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="bg-white p-4 md:p-6 shadow-sm sm:rounded-lg">
        <div id='calendar'></div>
    </div>
    <div id="event-modal" class="fixed inset-0 z-30 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center">
            <div class="fixed inset-0 transition-opacity modal-overlay">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="event-form">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 id="modal-title" class="text-lg leading-6 font-medium text-gray-900"></h3>
                        <div class="mt-4 space-y-4">
                            <input type="hidden" id="event-id" name="id">
                            <div>
                                <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
                                <input type="text" name="titulo" id="titulo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                            </div>
                            {{-- AJUSTE: Adicionado campo para Data Final --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="data_inicio" class="block text-sm font-medium text-gray-700">Data de Início</label>
                                    <input type="date" name="data_inicio" id="data_inicio" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                </div>
                                <div>
                                    <label for="data_fim" class="block text-sm font-medium text-gray-700">Data Final (Opcional)</label>
                                    <input type="date" name="data_fim" id="data_fim" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                </div>
                            </div>
                            <div>
                                <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição (Opcional)</label>
                                <textarea name="descricao" id="descricao" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                            </div>
                            <div>
                                <label for="cor" class="block text-sm font-medium text-gray-700">Cor do Evento</label>
                                <input type="color" name="cor" id="cor" class="mt-1 block w-full h-10 rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse items-center">
                        <button type="submit" id="save-event-button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 sm:ml-3 sm:w-auto sm:text-sm"></button>
                        <button type="button" class="modal-cancel-button mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">Cancelar</button>
                        <button type="button" id="delete-event-button" class="mr-auto w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-200 text-base font-medium text-gray-700 hover:bg-gray-300 sm:w-auto sm:text-sm" style="display: none;">Excluir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="share-modal" class="fixed inset-0 z-30 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 transition-opacity modal-overlay"><div class="absolute inset-0 bg-gray-500 opacity-75"></div></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Compartilhar Calendário</h3>
                    <p class="mt-2 text-sm text-gray-500">Qualquer pessoa com este link poderá ver os seus eventos. Não compartilhe com quem não confia.</p>
                    <div class="mt-4">
                        <label for="share-link" class="sr-only">Link de compartilhamento</label>
                        <div class="flex rounded-md shadow-sm">
                            <input type="text" id="share-link" readonly class="block w-full rounded-none rounded-l-md border-gray-300 bg-gray-50" value="Carregando...">
                            <button id="copy-button" class="relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-md px-3 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-100">Copiar</button>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="modal-cancel-button mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <x-exclusao-modal>
        Você tem certeza que deseja excluir este evento?
    </x-exclusao-modal>
    @push('scripts')
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>

        <script>
            $(document).ready(function() {
                const calendarEl = document.getElementById('calendar');
                const eventModal = $('#event-modal');
                const shareModal = $('#share-modal');
                let currentEventId = null;

                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'pt-br',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek'
                    },
                    buttonText: {
                        today: 'Hoje',
                        month: 'Mês',
                        week: 'Semana',
                    },
                    events: '{{ route("calendario.feed") }}',
                    dateClick: function(info) {
                        openCreateModal(info.dateStr);
                    },
                    eventClick: function(info) {
                        openEditModal(info.event);
                    }
                });
                calendar.render();
                function openCreateModal(date) {
                    currentEventId = null;
                    $('#event-form')[0].reset();
                    $('#modal-title').text('Criar Novo Evento');
                    $('#data_inicio').val(date);
                    $('#cor').val('#ef4444');
                    $('#save-event-button').text('Criar Evento');
                    $('#delete-event-button').hide();
                    eventModal.fadeIn();
                }

                function openEditModal(event) {
                    currentEventId = event.id;
                    $('#event-form')[0].reset();
                    $('#modal-title').text('Editar Evento');
                    $('#event-id').val(event.id);
                    $('#titulo').val(event.title);
                    $('#data_inicio').val(event.startStr.substring(0, 10));
                    $('#data_fim').val(event.endStr ? event.endStr.substring(0, 10) : '');
                    $('#descricao').val(event.extendedProps.description || '');
                    $('#cor').val(event.backgroundColor || '#ef4444');
                    $('#save-event-button').text('Salvar Alterações');
                    $('#delete-event-button').show();
                    eventModal.fadeIn();
                }

                $('#add-event-button').on('click', function() {
                    openCreateModal(new Date().toISOString().slice(0, 10));
                });

                $('#event-form').on('submit', function(e) {
                    e.preventDefault();
                    const url = currentEventId ? `/calendario/${currentEventId}` : '/calendario';
                    const method = currentEventId ? 'PUT' : 'POST';

                    $.ajax({
                        url: url,
                        method: method,
                        data: {
                            _token: '{{ csrf_token() }}',
                            titulo: $('#titulo').val(),
                            data_inicio: $('#data_inicio').val(),
                            data_fim: $('#data_fim').val(),
                            descricao: $('#descricao').val(),
                            cor: $('#cor').val()
                        },
                        success: function() {
                            calendar.refetchEvents();
                            eventModal.fadeOut();
                        },
                        error: function() {
                            alert('Ocorreu um erro ao salvar o evento.');
                        }
                    });
                });

                $('#delete-event-button').on('click', function() {
                    const deleteUrl = `/calendario/${currentEventId}`;
                    eventModal.fadeOut();
                    window.dispatchEvent(new CustomEvent('open-exclusao-modal', {
                        bubbles: true,
                        detail: { url: deleteUrl }
                    }));
                });

                $('#share-button').on('click', function() {
                    $('#share-link').val('Carregando...');
                    $('#copy-button').text('Copiar');
                    shareModal.fadeIn();

                    $.post('{{ route("calendario.gerar-link") }}', { _token: '{{ csrf_token() }}' }, function(data) {
                        $('#share-link').val(data.url);
                    });
                });

                $('#copy-button').on('click', function() {
                    const linkInput = document.getElementById('share-link');
                    linkInput.select();
                    document.execCommand('copy');
                    $(this).text('Copiado!');
                    setTimeout(() => $(this).text('Copiar'), 2000);
                });
                $('.modal-cancel-button, .modal-overlay').on('click', function() {
                    eventModal.fadeOut();
                    shareModal.fadeOut();
                });
            });
        </script>
    @endpush
</x-app-layout>