@extends('layout')
@section('title', 'Proyectos')
@section('href_accion', route('project_managers.index'))
@section('value_accion', 'Proyectos')
@section('button2', 'Nueva tarjeta')
@section('content')


    <!-- CSS Activities -->
    <link rel="stylesheet" href="{{ asset('css/project_managers/activites.css') }}">
    <link rel="stylesheet" href="{{ asset('css/project_managers/project_managers.css') }}">

    <!-- Contenido -->
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox" style="margin-bottom: 0px;">
                    <div class="ibox-title">
                        <h3 style="margin-left: 10px;">Listado de Tarjetas - {{$project_manager->nombre}}</h3>
                        <div class="ibox-tools">
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content" style="padding: 15px 20px 15px 20px;">
                        <div class="carousel-container">
                            @foreach ($project_manager->activities as $activity)
                            <div class="p-card" id="p-card-{{$activity->id}}" style="background-color: {{$activity->color}}">
                                <div class="p-card-title">{{Str::ucfirst($activity->nombre)}}</div>
                                <div class="p-card-content">
                                    <div class="p-card-header">
                                        <img src="{{ isset($activity->responsable->avatar) ? asset('/profile/images/') . '/' . $activity->responsable->avatar : 'https://static-00.iconduck.com/assets.00/profile-circle-icon-256x256-cm91gqm2.png' }}" class="worker-image" alt="worker image">
                                        <div class="worker-info">
                                            <div class="worker-name">{{ Str::ucfirst($activity->responsable->nombre ?? $activity->responsable->name) }}</div>
                                            <div class="worker-time">{{createdTime($activity)}}</div>
                                        </div>
                                        <div class="p-card-action-icons">
                                            <a href="#" class="fa fa-plus"></a>
                                            <a href="#" class="fa fa-trash" , method: :delete, data: { confirm: 'Estás seguro?' }></a>
                                            <a href="#" class="fa fa-edit"></a>
                                        </div>
                                    </div> 
                                    <div class="p-card-text">
                                        <p class="truncate-text" truncate="120">
                                            {{$activity->contenido}}
                                        </p>
                                    </div>
                                    @if ($activity->foto) <img src="{{ $activity->foto }}" class="p-card-image" alt="p-card image"> @endif
                                    <div class="p-card-footer">
                                        <div class="progress-container">
                                            <div class="progress-bar-date">{{$activity->fecha_inicio->format('d/m/Y')}}</div>
                                            <div class="progress-bar-container">
                                                <div class="progress-bar-border">
                                                    <div class="progress-bar" style="background-color: #94f261;  width: {{progressDate($activity->fecha_inicio, $activity->fecha_cierre)}}%;"></div>
                                                </div>
                                            </div>
                                            <div class="progress-bar-text">{{progressDate($activity->fecha_inicio, $activity->fecha_cierre)}}%</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Contenedor para los Tasks> -->
                                @if ($activity->tasks->isNotEmpty())
                                <div class="tasks-container" id="tasks-container-{{$activity->id}}">
                                    @foreach ($activity->tasks as $task)
                                    <div class="task" id="task-{{$task->id}}">
                                        <div class="task-worker-header">
                                            <img src="{{ isset($activity->responsable->avatar) ? asset('/profile/images/') . '/' . $activity->responsable->avatar : 'https://static-00.iconduck.com/assets.00/profile-circle-icon-256x256-cm91gqm2.png' }}" class="worker-image" alt="worker image">
                                            <div class="task-worker-info">
                                                <div class="worker-name">{{ Str::ucfirst($task->user->nombre ?? $task->user->name) }}</div>
                                                <div class="worker-time">{{createdTime($task)}}</div>
                                            </div>
                                        </div>
                                        <div class="task-text">
                                            <p class="truncate-text" truncate="100">
                                                {{$task->contenido}}
                                            </p>
                                        </div>
                                        <div class="task-footer">
                                            <div class="progress-container">
                                                <div class="progress-bar-date">{{$task->fecha_inicio->format('d/m/Y')}}</div>
                                                <div class="progress-bar-container">
                                                    <div class="progress-bar-border">
                                                        <div class="progress-bar" style="background-color: #94f261;  width: {{progressDate($task->fecha_inicio, $task->fecha_cierre)}}%;"></div>
                                                    </div>
                                                </div>
                                                <div class="progress-bar-text">{{progressDate($task->fecha_inicio, $task->fecha_cierre)}}%</div>
                                                <div class="task-action-icons">
                                                    <i class="fa fa-pencil-square-o task-buttons"></i>
                                                    <a href="#" class="fa fa-trash task-buttons" data: { confirm: 'Estás seguro?' }></a>
                                                    <i class="fa fa-comment" style="cursor: pointer;" onclick="toggleChat('chat-box-{{$task->id}}')"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chat-box" id="chat-box-{{$task->id}}">
                                            @if ($task->comments->isNotEmpty())
                                                <div class="chat-history" id="chat-history-{{$task->id}}">
                                                    @foreach ($task->comments as $comment)
                                                    <div class="chat-message @if ($comment->user_id == auth()->id()) right @else left @endif" id="comment-{{$comment->id}}">
                                                        <div class="comment-header">
                                                            <img src="{{ isset($activity->responsable->avatar) ? asset('/profile/images/') . '/' . $activity->responsable->avatar : 'https://static-00.iconduck.com/assets.00/profile-circle-icon-256x256-cm91gqm2.png' }}" class="chat-worker-image" alt="chat worker image">
                                                            <div class="comment-user-info">
                                                                <div class="worker-name">{{ Str::ucfirst($comment->user->nombre ?? $comment->user->name) }}</div>
                                                            </div>
                                                        </div>
                                                        <div class="chat-message-text">
                                                            <p class="truncate-text" truncate="90">
                                                                {{$comment->contenido}}
                                                            </p>
                                                        </div>
                                                        @if ($comment->foto) <img src="{{ $comment->foto }}" class="chat-attached-image" alt="chat-attached-image"> @endif
                                                    </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                            <form action="" class="chat-input">
                                                <label for="file-input-1" class="file-input-label"><i class="fa fa-image"></i></label>
                                                <input id="file-input-1" type="file" class="file-input" name="attachments[image]">
                                                <input type="text" placeholder="Escribe un mensaje...">
                                                <button type="submit"><i class="fa fa-paper-plane"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleChat(chatId) {
            const chatBox = document.getElementById(chatId);
            
            if (!chatBox.classList.contains('active')) {
                chatBox.style.margin = '5px 0px 5px 0px';
                chatBox.style.padding = '6px';
                chatBox.classList.add('active');
                chatBox.style.maxHeight = chatBox.scrollHeight + 12 + 'px';
            } else {
                chatBox.style.maxHeight = '0';
                chatBox.classList.remove('active');
                chatBox.style.padding = '0';
                chatBox.style.margin = '0';
            }
        }

        // Funciones auxiliares
        function invertColor(hex, bw) {
            hex = hex.replace(/^#/, '');
            if (hex.length === 3) hex = hex.split('').map(h => h + h).join('');
            if (hex.length !== 6) throw new Error('Hex invalido.');
            let [r, g, b] = [0, 2, 4].map(offset => parseInt(hex.slice(offset, offset + 2), 16));
            if (bw) return (r * 0.299 + g * 0.587 + b * 0.114) > 186 ? '#000000' : '#FFFFFF';
            return '#' + [r, g, b].map(c => padZero((255 - c).toString(16))).join('');
        }

        function padZero(str, len) {
            len = len || 2;
            var zeros = new Array(len).join('0');
            return (zeros + str).slice(-len);
        }

        function rgbToHex(rgb) {
            const result = rgb.match(/\d+/g).map(Number);
            return "#" + ((1 << 24) + (result[0] << 16) + (result[1] << 8) + result[2]).toString(16).slice(1).toUpperCase();
        }
        /**/

        document.addEventListener('DOMContentLoaded', function() {

            // Función para invertir el color titulo de la tarjeta respecto al color de la tarjeta
            const cards = document.querySelectorAll('.p-card');
            cards.forEach(card => {
                const bgColor = window.getComputedStyle(card).backgroundColor;
                const hexColor = rgbToHex(bgColor);
                const textColor = invertColor(hexColor, true);
                card.querySelector('.p-card-title').style.color = textColor;
            });

            // Función para truncar texto
            const truncarTextos = document.querySelectorAll('.truncate-text');

            truncarTextos.forEach(parrafo => {
                const longitud = parseInt(parrafo.getAttribute('truncate'));
                const textoCompleto = parrafo.innerHTML.trim();

                if (textoCompleto.length > longitud) {
                    const textoTruncado = textoCompleto.substring(0, longitud) + '<span class="ver-mas"> ...más</span>';
                    parrafo.innerHTML = textoTruncado;

                    parrafo.addEventListener('click', function(event) {
                        if (event.target.classList.contains('ver-mas')) {
                            parrafo.innerHTML = textoCompleto + '<span class="ver-menos"> ...menos</span>';
                        } else if (event.target.classList.contains('ver-menos')) {
                            parrafo.innerHTML = textoTruncado;
                        }
                    });
                }
            });
        });
    </script>

    <!-- CSS needed -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <!-- Switchery -->
    <link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

@endsection
