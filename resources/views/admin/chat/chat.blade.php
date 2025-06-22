@extends('admin.layouts.tamplate')

@section('title', 'Chat dengan ' . $session->user_name)

@section('css')
    <style>
        .chat-card {
            height: 80vh;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background: #f8f9fa;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #dee2e6;
            border-radius: 0.375rem 0.375rem 0 0;
        }

        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 1rem;
            background: #f8f9fa;
            max-height: calc(80vh - 140px);
        }

        .message {
            margin-bottom: 1rem;
            display: flex;
        }

        .message.own {
            justify-content: flex-end;
        }

        .message-bubble {
            max-width: 70%;
            padding: 0.75rem 1rem;
            border-radius: 1rem;
            background: #fff;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .message.own .message-bubble {
            background: #007bff;
            color: white;
        }

        .message-info {
            font-size: 0.75rem;
            margin-top: 0.25rem;
            opacity: 0.7;
        }

        .no-messages {
            text-align: center;
            padding: 3rem 1rem;
            color: #6c757d;
        }

        .no-messages i {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .chat-input {
            padding: 1rem 1.5rem;
            background: #fff;
            border-top: 1px solid #dee2e6;
            border-radius: 0 0 0.375rem 0.375rem;
        }

        .input-group {
            display: flex;
            align-items: center;
        }

        .message-input {
            flex: 1;
            border: 1px solid #dee2e6;
            border-radius: 2rem;
            padding: 0.75rem 1rem;
            outline: none;
            resize: none;
        }

        .message-input:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        .send-btn {
            background: #007bff;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-left: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .send-btn:hover:not(:disabled) {
            background: #0056b3;
        }

        .send-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card chat-card">
                    <div class="chat-header">
                        <div class="d-flex align-items-center">
                            <a href="{{ route('konselor-dashboard.index') }}" class="btn btn-link text-decoration-none me-3">
                                <i class="fas fa-arrow-left"></i>
                            </a>

                            @if ($session->user_image)
                                <img src="{{ asset('storage/' . $session->user_image) }}" class="rounded-circle me-3"
                                    width="45" height="45">
                            @else
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 45px; height: 45px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            @endif

                            <div>
                                <h5 class="mb-0">{{ $session->user_name }}</h5>
                                <small class="text-muted">Klien • Sesi Aktif</small>
                            </div>
                        </div>
                    </div>

                    <div class="chat-messages" id="chatMessages">
                        @if ($messages->count() > 0)
                            @foreach ($messages as $message)
                                <div class="message {{ $message->sender_id == Auth::id() ? 'own' : '' }}">
                                    <div class="message-bubble">
                                        {{ $message->message }}
                                        <div class="message-info">
                                            {{ $message->sender_name }} •
                                            {{ date('H:i', strtotime($message->sent_at)) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="no-messages">
                                <i class="fas fa-comments"></i>
                                <p>Belum ada pesan. Mulai percakapan dengan mengirim pesan pertama.</p>
                            </div>
                        @endif
                    </div>

                    <div class="chat-input">
                        <form id="messageForm">
                            <div class="input-group">
                                <input type="hidden" id="sessionId" value="{{ $session->id }}">
                                <input type="text" id="messageInput" class="message-input"
                                    placeholder="Ketik balasan Anda..." maxlength="1000" required>
                                <button type="submit" class="send-btn" id="sendBtn">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('js')
    <script>
        $(document).ready(function() {
            const chatMessages = $('#chatMessages');
            const messageForm = $('#messageForm');
            const messageInput = $('#messageInput');
            const sendBtn = $('#sendBtn');
            const sessionId = $('#sessionId').val();

            // Auto scroll to bottom
            function scrollToBottom() {
                chatMessages.scrollTop(chatMessages[0].scrollHeight);
            }

            // Initial scroll
            scrollToBottom();

            // Send message
            messageForm.on('submit', function(e) {
                e.preventDefault();

                const message = messageInput.val().trim();
                if (!message) return;

                // Disable form
                sendBtn.prop('disabled', true);
                messageInput.prop('disabled', true);

                $.ajax({
                    url: '{{ route('konselor-dashboard.send-message') }}',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        session_id: sessionId,
                        message: message
                    },
                    success: function(response) {
                        messageInput.val('');

                        // Langsung tampilkan pesan baru
                        if (response.message) {
                            appendNewMessage(response.message);
                        }
                    },
                    error: function(xhr) {
                        alert('Gagal mengirim pesan. Silakan coba lagi.');
                    },
                    complete: function() {
                        sendBtn.prop('disabled', false);
                        messageInput.prop('disabled', false);
                        messageInput.focus();
                    }
                });
            });

            // Function untuk menambah pesan baru
            function appendNewMessage(message) {
                // Hapus no-messages jika ada
                $('.no-messages').remove();

                const isOwn = message.sender_id == {{ Auth::id() }};
                const time = new Date(message.sent_at).toLocaleTimeString('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                const messageHtml = `
            <div class="message ${isOwn ? 'own' : ''}">
                <div class="message-bubble">
                    ${message.message}
                    <div class="message-info">
                        ${message.sender_name} • ${time}
                    </div>
                </div>
            </div>
        `;

                chatMessages.append(messageHtml);
                scrollToBottom();
            }

            function loadMessages() {
                $.ajax({
                    url: '{{ route('konselor-dashboard.messages', $session->id) }}',
                    method: 'GET',
                    success: function(messages) {
                        let html = '';

                        if (messages.length > 0) {
                            messages.forEach(function(message) {
                                const isOwn = message.sender_id == {{ Auth::id() }};
                                const time = new Date(message.sent_at).toLocaleTimeString(
                                    'id-ID', {
                                        hour: '2-digit',
                                        minute: '2-digit'
                                    });

                                html += `
                            <div class="message ${isOwn ? 'own' : ''}">
                                <div class="message-bubble">
                                    ${message.message}
                                    <div class="message-info">
                                        ${message.sender_name} • ${time}
                                    </div>
                                </div>
                            </div>
                        `;
                            });
                        } else {
                            html = `
                        <div class="no-messages">
                            <i class="fas fa-comments"></i>
                            <p>Belum ada pesan. Mulai percakapan dengan mengirim pesan pertama.</p>
                        </div>
                    `;
                        }

                        chatMessages.html(html);
                        scrollToBottom();
                    }
                });
            }

            // Auto refresh messages every 5 seconds
            setInterval(loadMessages, 5000);

            // Enter key to send
            messageInput.on('keypress', function(e) {
                if (e.which === 13 && !e.shiftKey) {
                    e.preventDefault();
                    messageForm.submit();
                }
            });
        });
    </script>

@endsection
