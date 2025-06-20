<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Konsultasi dengan {{ $konselor->user_name }} - HKSR</title>
    @include('frontend.layouts.head')
    <style>
        :root {
            --primary-color: #e63946;
            --secondary-color: #1d3557;
            --light-color: #f1faee;
            --medium-color: #a8dadc;
            --dark-color: #457b9d;
        }

        .chat-container {
            height: 100vh;
            background: var(--light-color);
            padding: 0;
        }

        .chat-sidebar {
            background: white;
            height: 100vh;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            overflow-y: auto;
        }

        .konselor-profile {
            text-align: center;
            padding-bottom: 30px;
            border-bottom: 2px solid var(--light-color);
            margin-bottom: 30px;
        }

        .profile-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--medium-color);
            margin-bottom: 20px;
        }

        .profile-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: var(--medium-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            border: 4px solid var(--medium-color);
        }

        .konselor-name {
            color: var(--secondary-color);
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .konselor-type-badge {
            background: var(--primary-color);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.9rem;
            display: inline-block;
            margin-bottom: 15px;
        }

        .konselor-status {
            background: #28a745;
            color: white;
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 0.8rem;
            display: inline-block;
        }

        .konselor-info h5 {
            color: var(--secondary-color);
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .konselor-info p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            color: var(--dark-color);
        }

        .info-item i {
            width: 20px;
            margin-right: 10px;
            color: var(--primary-color);
        }

        .chat-main {
            height: 100vh;
            display: flex;
            flex-direction: column;
            background: white;
        }

        .chat-header {
            background: var(--secondary-color);
            color: white;
            padding: 20px 30px;
            border-bottom: 3px solid var(--primary-color);
        }

        .chat-header h4 {
            margin: 0;
            font-size: 1.2rem;
        }

        .chat-header p {
            margin: 5px 0 0 0;
            opacity: 0.8;
            font-size: 0.9rem;
        }

        .chat-messages {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
            background: #f8f9fa;
            height: calc(100vh - 200px);
        }

        .message {
            margin-bottom: 20px;
            display: flex;
            animation: slideIn 0.3s ease;
        }

        .message.own {
            justify-content: flex-end;
        }

        .message-bubble {
            max-width: 70%;
            padding: 15px 20px;
            border-radius: 20px;
            position: relative;
            word-wrap: break-word;
        }

        .message.own .message-bubble {
            background: var(--primary-color);
            color: white;
            border-bottom-right-radius: 5px;
        }

        .message:not(.own) .message-bubble {
            background: white;
            color: #333;
            border: 1px solid #e0e0e0;
            border-bottom-left-radius: 5px;
        }

        .message-info {
            font-size: 0.75rem;
            opacity: 0.7;
            margin-top: 5px;
        }

        .message.own .message-info {
            text-align: right;
        }

        .chat-input {
            background: white;
            border-top: 1px solid #e0e0e0;
            padding: 20px;
        }

        .input-group {
            display: flex;
            gap: 10px;
        }

        .message-input {
            flex: 1;
            border: 2px solid var(--medium-color);
            border-radius: 25px;
            padding: 12px 20px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s;
        }

        .message-input:focus {
            border-color: var(--primary-color);
        }

        .send-btn {
            background: var(--primary-color);
            border: none;
            color: white;
            padding: 12px 20px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .send-btn:hover {
            background: #d52532;
            transform: scale(1.1);
        }

        .send-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
        }

        .no-messages {
            text-align: center;
            color: #999;
            padding: 40px 20px;
        }

        .no-messages i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: var(--medium-color);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .chat-container {
                height: auto;
            }

            .chat-sidebar {
                height: auto;
                padding: 20px;
            }

            .chat-main {
                height: 80vh;
            }

            .chat-messages {
                height: calc(80vh - 160px);
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid chat-container">
        <div class="row h-100">
            <!-- Sidebar Konselor Detail -->
            <div class="col-lg-4 col-md-5 chat-sidebar">
                <div class="konselor-profile">
                    @if ($konselor->gambar_konselor)
                        <img src="{{ asset( $konselor->gambar_konselor) }}" alt="{{ $konselor->user_name }}"
                            class="profile-image">
                    @else
                        <div class="profile-placeholder">
                            <i class="fas fa-user-tie fa-3x text-white"></i>
                        </div>
                    @endif

                    <h4 class="konselor-name">{{ $konselor->user_name }}</h4>
                    <div class="konselor-type-badge">{{ $konselor->jenis_konselor }}</div>
                    <div class="konselor-status">
                        <i class="fas fa-circle me-1"></i>Online
                    </div>
                </div>

                <div class="konselor-info">
                    <h5><i class="fas fa-info-circle me-2"></i>Tentang Konselor</h5>
                    <p>{{ $konselor->deskripsi }}</p>

                    <div class="info-item">
                        <i class="fas fa-clock"></i>
                        <span>{{ date('H:i', strtotime($konselor->jam_aktif_awal)) }} -
                            {{ date('H:i', strtotime($konselor->jam_aktif_akhir)) }}</span>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-envelope"></i>
                        <span>{{ $konselor->email }}</span>
                    </div>

                    <div class="info-item">
                        <i class="fas fa-shield-alt"></i>
                        <span>Sertifikat Profesional</span>
                    </div>
                </div>

                <a href="{{ route('konselor.index') }}" class="btn btn-outline-secondary w-100 mt-3">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Konselor
                </a>
            </div>

            <!-- Chat Area -->
            <div class="col-lg-8 col-md-7 p-0">
                <div class="chat-main">
                    <div class="chat-header">
                        <h4>Konsultasi dengan {{ $konselor->user_name }}</h4>
                        <p>{{ $konselor->jenis_konselor }} • Sesi Aktif</p>
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
                                <p>Belum ada pesan. Mulai percakapan dengan mengirim pesan pertama Anda.</p>
                            </div>
                        @endif
                    </div>

                    <div class="chat-input">
                        <form id="messageForm">
                            <div class="input-group">
                                <input type="hidden" id="sessionId" value="{{ $sessionId }}">
                                <input type="text" id="messageInput" class="message-input"
                                    placeholder="Ketik pesan Anda..." maxlength="1000" required>
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

    @include('frontend.layouts.script')

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
                    url: '{{ route('frontend.konselor.send-message') }}',
                    method: 'POST',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        session_id: sessionId,
                        message: message
                    },
                    success: function(response) {
                        messageInput.val('');
                        loadMessages();
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

            // Load messages
            function loadMessages() {
                $.ajax({
                    url: '{{ url('konselor/messages') }}/' + sessionId,
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
                                    <p>Belum ada pesan. Mulai percakapan dengan mengirim pesan pertama Anda.</p>
                                </div>
                            `;
                        }

                        chatMessages.html(html);
                        scrollToBottom();
                    }
                });
            }

            // Auto refresh messages every 3 seconds
            setInterval(loadMessages, 3000);

            // Enter key to send
            messageInput.on('keypress', function(e) {
                if (e.which === 13 && !e.shiftKey) {
                    e.preventDefault();
                    messageForm.submit();
                }
            });
        });
    </script>
</body>

</html>
