<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensei Virtual - Especialista em Judô</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'Figtree', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex flex-col h-screen max-w-2xl mx-auto bg-white shadow-lg">
        <header class="bg-white shadow-md p-4 text-center border-b">
            <h1 class="text-2xl font-bold text-gray-800">Sensei Virtual</h1>
            <p class="text-sm text-gray-600">O seu especialista em história e técnicas de Judô</p>
        </header>
        <main id="chat-area" class="flex-1 p-6 overflow-y-auto space-y-4">
            <div class="flex">
                <div class="bg-gray-200 text-gray-800 p-3 rounded-lg max-w-xs">
                    <p>Hajime! Estou pronto para responder às suas perguntas sobre o Caminho Suave. O que gostaria de saber?</p>
                </div>
            </div>
        </main>
        <footer class="bg-white border-t p-4">
            <form id="chat-form" class="flex items-center gap-4">
                <input type="text" id="pergunta" placeholder="Digite a sua pergunta aqui..." class="flex-1 p-3 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-red-500" autocomplete="off">
                <button type="submit" id="submit-button" class="bg-red-600 text-white p-3 rounded-full hover:bg-red-700 transition-colors disabled:bg-red-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                      <path d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                    </svg>
                </button>
            </form>
        </footer>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            const chatForm = $('#chat-form');
            const perguntaInput = $('#pergunta');
            const chatArea = $('#chat-area');
            const submitButton = $('#submit-button');

            chatForm.on('submit', function(e) {
                e.preventDefault();
                const pergunta = perguntaInput.val().trim();
                if (!pergunta) return;

                addMessage(pergunta, 'user');
                perguntaInput.val('');
                submitButton.prop('disabled', true);

                const thinkingMessageId = addMessage('...', 'ia', true);

                $.ajax({
                    url: '{{ route("ia.judo.ask") }}',
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
</body>
</html>
