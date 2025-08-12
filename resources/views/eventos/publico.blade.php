<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendário de Eventos de {{ $user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Figtree', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4 md:p-8">
        <div class="bg-white p-4 md:p-6 shadow-lg sm:rounded-lg">
            <div class="border-b pb-4 mb-4">
                <h1 class="text-2xl font-bold text-gray-800">Calendário de Eventos</h1>
                <p class="text-sm text-gray-600">Visualizando calendário compartilhado por: <span class="font-semibold">{{ $user->name }}</span></p>
            </div>
            <div id='calendar'></div>
        </div>
    </div>
    <div id="view-event-modal" class="fixed inset-0 z-30 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 transition-opacity modal-overlay"><div class="absolute inset-0 bg-gray-500 opacity-75"></div></div>
            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6">
                    <h3 id="view-modal-title" class="text-lg leading-6 font-medium text-gray-900"></h3>
                    <div class="mt-4">
                        <p id="view-modal-description" class="text-sm text-gray-600"></p>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" class="modal-cancel-button mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 sm:mt-0 sm:w-auto sm:text-sm">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
        <script>
            $(document).ready(function() {
                const calendarEl = document.getElementById('calendar');
                const viewModal = $('#view-event-modal');
                const calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'pt-br',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,listWeek'
                    },
                    buttonText: {
                        today: 'Hoje',
                        month: 'Mês',
                        week: 'Semana',
                        list: 'Agenda'
                    },
                    events: '{{ route("calendario.publico.feed", ["token" => $user->calendario_token]) }}',
                    eventClick: function(info) {
                        $('#view-modal-title').text(info.event.title);
                        $('#view-modal-description').text(info.event.extendedProps.description || 'Nenhuma descrição fornecida.');
                        viewModal.fadeIn();
                    }
                });
                calendar.render();
                $('.modal-cancel-button, .modal-overlay').on('click', function() {
                    viewModal.fadeOut();
                });
            });
        </script>
    @endpush
    @stack('scripts')
</body>
</html>