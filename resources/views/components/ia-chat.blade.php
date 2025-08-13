<div x-data="{ open: false }" class="fixed bottom-6 right-6 z-40">
    <button @click="open = !open" class="bg-red-600 text-white rounded-full p-4 shadow-lg hover:bg-red-700 transition-transform transform hover:scale-110">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
            <path d="M12 4.75a1.75 1.75 0 100 3.5 1.75 1.75 0 000-3.5zM3.25 9.5a1.75 1.75 0 103.5 0 1.75 1.75 0 00-3.5 0zM17.25 9.5a1.75 1.75 0 103.5 0 1.75 1.75 0 00-3.5 0zM12 14.75a1.75 1.75 0 100 3.5 1.75 1.75 0 000-3.5zM3.25 15.5a1.75 1.75 0 103.5 0 1.75 1.75 0 00-3.5 0zM17.25 15.5a1.75 1.75 0 103.5 0 1.75 1.75 0 00-3.5 0z"></path>
        </svg>
    </button>
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-4"
         @click.away="open = false"
         class="absolute bottom-20 right-0 w-96 bg-white rounded-lg shadow-2xl border flex flex-col"
         style="display: none; height: 60vh;">
        <header class="bg-gray-50 p-4 text-center border-b rounded-t-lg">
            <h3 class="text-lg font-semibold text-gray-800">Assistente de IA</h3>
            <p class="text-sm text-gray-500">Faça uma pergunta sobre os seus dados</p>
        </header>
        <main id="ai-chat-area" class="flex-1 p-4 overflow-y-auto space-y-4">
            <div class="flex">
                <div class="bg-gray-200 text-gray-800 p-3 rounded-lg max-w-xs">
                    <p>Olá! Como posso ajudar a analisar os seus dados hoje?</p>
                </div>
            </div>
        </main>
        <footer class="bg-white border-t p-3">
            <form id="ai-chat-form" class="flex items-center gap-2">
                <input type="text" id="ai-pergunta" placeholder="Pergunte aqui..." class="flex-1 p-2 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-red-500" autocomplete="off">
                <button type="submit" id="ai-submit-button" class="bg-red-600 text-white p-2 rounded-full hover:bg-red-700 transition-colors disabled:bg-red-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                    </svg>
                </button>
            </form>
        </footer>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        const chatForm = $('#ai-chat-form');
        const perguntaInput = $('#ai-pergunta');
        const chatArea = $('#ai-chat-area');
        const submitButton = $('#ai-submit-button');

        chatForm.on('submit', function(e) {
            e.preventDefault();
            const pergunta = perguntaInput.val().trim();
            if (!pergunta) return;

            addMessage(pergunta, 'user');
            perguntaInput.val('');
            submitButton.prop('disabled', true);

            const thinkingMessageId = addMessage('A pensar...', 'ia', true);

            $.ajax({
                url: '',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    pergunta: pergunta
                },
                success: function(response) {
                    updateMessage(thinkingMessageId, response.resposta);
                },
                error: function() {
                    updateMessage(thinkingMessageId, 'Desculpe, não consegui processar a sua pergunta neste momento.');
                },
                complete: function() {
                    submitButton.prop('disabled', false);
                }
            });
        });

        function addMessage(text, sender, isThinking = false) {
            const messageId = 'msg-' + Date.now();
            const messageWrapper = $('<div></div>').addClass(`flex ${sender === 'user' ? 'justify-end' : ''}`);
            const messageBubble = $('<div></div>').attr('id', messageId).addClass(`p-3 rounded-lg max-w-md ${sender === 'user' ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-800'}`).html(`<p>${text}</p>`);

            if (isThinking) {
                messageBubble.addClass('thinking');
            }

            messageWrapper.append(messageBubble);
            chatArea.append(messageWrapper);
            chatArea.scrollTop(chatArea[0].scrollHeight);
            return messageId;
        }

        function updateMessage(messageId, newText) {
            const messageBubble = $('#' + messageId);
            if (messageBubble.length) {
                const formattedText = newText.replace(/\n/g, '<br>');
                messageBubble.html(`<p>${formattedText}</p>`).removeClass('thinking');
                chatArea.scrollTop(chatArea[0].scrollHeight);
            }
        }
    });
</script>
@endpush