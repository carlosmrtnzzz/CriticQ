@extends('layouts.base')
@section('titulo', 'Conversación con ' . $contacto->username)

@section('content')
    <div class="container">
        <div class="chat-container">
            <div class="chat-header">
                <a href="{{ route('chat') }}" class="btn btn-sm btn-outline-secondary me-3">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
                <div class="d-flex align-items-center">
                    <img src="{{ $contacto->avatar ? asset('storage/' . $contacto->avatar) : asset('extra/default-foto.jpg') }}"
                        alt="Foto de perfil" class="rounded-circle me-3" width="40" height="40" style="object-fit: cover;">
                    <div>
                        <h5 class="mb-0">{{ $contacto->nombre }}</h5>
                        <p class="text-muted mb-0"><span>@</span>{{ $contacto->username }}</p>
                    </div>
                </div>
            </div>

            <div class="chat-messages">
                <ul id="messages-list" class="messages-list">
                    @foreach($mensajes as $mensaje)
                        <li class="{{ $mensaje->emisor_id == Auth::id() ? 'sent' : 'received' }}">
                            <span class="message-time">{{ $mensaje->created_at->format('H:i') }}</span>
                            <div class="message-content">
                                {{ $mensaje->contenido }}
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <form id="chat-form" class="chat-form">
                <input type="hidden" id="receptor_id" value="{{ $contacto->id }}">
                <div class="input-group">
                    <textarea id="contenido" class="form-control" placeholder="Escribe un mensaje..."></textarea>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            let receptorId = $('#receptor_id').val();
            let lastMessageId = {{ $mensajes->isEmpty() ? 0 : $mensajes->last()->id }};
            let userScrolled = false;

            scrollToBottom();

            $('#messages-list').on('scroll', function () {
                const messagesList = document.getElementById('messages-list');
                if (messagesList.scrollHeight - messagesList.scrollTop > messagesList.clientHeight + 50) {
                    userScrolled = true;
                } else {
                    userScrolled = false;
                }
            });

            function cargarMensajes() {
                $.ajax({
                    url: '{{ route("chat.getMessages") }}',
                    type: 'GET',
                    data: { contact_id: receptorId, last_message_id: lastMessageId },
                    success: function (data) {
                        let newMessagesAdded = false;

                        data.forEach(msg => {
                            if (msg.id > lastMessageId) {
                                const senderIsMe = msg.emisor_id == {{ Auth::id() }};
                                const messageTime = new Date(msg.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                                $('#messages-list').append(`
                                                            <li class="${senderIsMe ? 'sent' : 'received'}">
                                                                <span class="message-time">${messageTime}</span>
                                                                <div class="message-content">
                                                                    ${msg.contenido}
                                                                </div>
                                                            </li>
                                                        `);
                                lastMessageId = msg.id;
                                newMessagesAdded = true;
                            }
                        });

                        if (newMessagesAdded && !userScrolled) {
                            scrollToBottom();
                        }

                        if (newMessagesAdded && userScrolled) {
                            showNewMessageIndicator();
                        }
                    }
                });
            }

            function scrollToBottom() {
                const messagesList = document.getElementById('messages-list');
                messagesList.scrollTop = messagesList.scrollHeight;
            }

            function showNewMessageIndicator() {
                if ($('#new-messages-indicator').length === 0) {
                    const indicator = $('<div id="new-messages-indicator" class="new-messages-indicator">Nuevos mensajes ↓</div>');
                    $('.chat-messages').append(indicator);

                    indicator.click(function () {
                        scrollToBottom();
                        userScrolled = false;
                        $(this).remove();
                    });
                }
            }

            $('#chat-form').submit(function (e) {
                e.preventDefault();
                let contenido = $('#contenido').val();

                if (!contenido.trim()) {
                    return;
                }

                $.ajax({
                    url: '{{ route("chat.store") }}',
                    type: 'POST',
                    data: {
                        receptor_id: receptorId,
                        contenido: contenido,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        const messageTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                        $('#messages-list').append(`
                                                    <li class="sent">
                                                        <span class="message-time">${messageTime}</span>
                                                        <div class="message-content">
                                                            ${data.contenido}
                                                        </div>
                                                    </li>
                                                `);
                        $('#contenido').val('');
                        lastMessageId = data.id;

                        userScrolled = false;
                        scrollToBottom();
                        $('#new-messages-indicator').remove();
                    },
                    error: function (xhr) {
                        if (xhr.status === 403) {
                            alert('No puedes enviar mensajes a este usuario.');
                        } else {
                            alert('Error al enviar el mensaje. Inténtalo de nuevo.');
                        }
                    }
                });
            });

            $('#contenido').on('input', function () {
                this.style.height = 'auto';
                this.style.height = (this.scrollHeight) + 'px';
            });

            setInterval(cargarMensajes, 1000);
        });
    </script>


@endsection