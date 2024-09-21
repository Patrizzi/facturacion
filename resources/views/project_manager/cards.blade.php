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
                <div class="ibox">
                    <div class="ibox-title">
                        <h3 style="margin-left: 10px;">Listado de Tarjetas - 1</h3>
                        <div class="ibox-tools">
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="carousel-container">

                            @for ($a = 0; $a < 15; $a++)

                            <div class="p-card" id="p-card-{{$a}}" style="background-color: #94f261">
                                <div class="p-card-title"> Titulo de actividad a-{{$a}}</div>
                                <div class="p-card-content">
                                    <div class="p-card-header">
                                        <img src="https://static-00.iconduck.com/assets.00/profile-circle-icon-256x256-cm91gqm2.png" class="worker-image" alt="worker image">
                                        <div class="worker-info">
                                            <div class="worker-name">Usuario de actividad a-{{$a}}</div>
                                            <div class="worker-time">{{$a}}d</div>
                                        </div>
                                        <div class="p-card-action-icons">
                                            <a href="#" class="fa fa-plus"></a>
                                            <a href="#" class="fa fa-trash" , method: :delete, data: { confirm: 'Estás seguro?' }></a>
                                            <a href="#" class="fa fa-edit"></a>
                                        </div>
                                    </div>
                                    <div class="p-card-text">
                                        Descripción de actividad p-{{$a}}
                                    </div>
                                    <img src="https://t4.ftcdn.net/jpg/07/11/03/89/360_F_711038915_Nl8j4lQaXBS2NFKGar9LatVMn3U1pXqc.jpg" class="p-card-image" alt="p-card image">
                                    <div class="p-card-footer">
                                        <div class="progress-container">
                                            <div class="progress-bar-date">{{$a}}/20/2024</div>
                                            <div class="progress-bar-container">
                                                <div class="progress-bar-border">
                                                    <!-- Barra de progreso -->
                                                    <div class="progress-bar" style="background-color: #94f261;  width: {{$a}}%;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="progress-bar-text">{{$a}}%</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Contenedor para los Tasks> -->
                                <div class="tasks-container" id="tasks-container-{{$a}}">

                                    @for ($t = 0; $t < 8; $t++)

                                    <div class="task" id="task-{{$a}}-{{$t}}">
                                        <div class="task-worker-header">
                                            <img src="https://static-00.iconduck.com/assets.00/profile-circle-icon-256x256-cm91gqm2.png" class="task-worker-image">
                                            <div class="task-worker-info">
                                                <span class="worker-name">Usuario de tarea a{{$a}}-t{{$t}}</span>
                                            </div>
                                        </div>
                                        <div class="task-text">
                                            Descripción Tarea a{{$a}}-t{{$t}}
                                        </div>
                                        <div class="task-footer">
                                            <div class="progress-container">
                                                <div class="progress-bar-date">{{$t}}/10/2024</div>
                                                <div class="progress-bar-container">
                                                    <div class="progress-bar-border">
                                                        <!-- Barra de progreso -->
                                                        <div class="progress-bar" style="background-color: #94f261; width: {{$t}}%;"></div>
                                                    </div>
                                                </div>
                                                <div class="progress-bar-text">{{$t}}%</div>
                                                <div class="task-action-icons">
                                                    <i class="fa fa-pencil-square-o task-buttons"></i>
                                                    <a href="#" class="fa fa-trash task-buttons" data: { confirm: 'Estás seguro?' }></a>
                                                    <i class="fa fa-comment" style="cursor: pointer;" onclick="toggleChat('chat-box-{{$a}}-{{$t}}')"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="chat-box" id="chat-box-{{$a}}-{{$t}}">
                                            <div class="chat-history" id="chat-history-{{$a}}-{{$t}}">

                                                @for ($c = 0; $c < 20; $c++)

                                                <div class="chat-message @if ($c % 2 == 0) right @else left @endif" id="comment-{{$a}}-{{$t}}-{{$c}}">
                                                    <img src="https://static-00.iconduck.com/assets.00/profile-circle-icon-256x256-cm91gqm2.png" class="chat-worker-image" alt="chat worker image">
                                                    <div class="chat-message-text">Texto Comentario a{{$a}}-t{{$t}}-c{{$c}}</div>
                                                    <img src="https://t4.ftcdn.net/jpg/07/11/03/89/360_F_711038915_Nl8j4lQaXBS2NFKGar9LatVMn3U1pXqc.jpg" class="chat-attached-image">
                                                </div>
                                                
                                                @endfor

                                            </div>
                                            <form action="" class="chat-input">
                                                <label for="file-input-1" class="file-input-label"><i class="fa fa-image"></i></label>
                                                <input id="file-input-1" type="file" class="file-input" name="attachments[image]">
                                                <input type="text" placeholder="Escribe un mensaje...">
                                                <button type="submit"><i class="fa fa-paper-plane"></i></button>
                                            </form>
                                        </div>
                                    </div>

                                    @endfor
                                    
                                </div>
                            </div>

                            @endfor

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleChat(chatId) {
            var chatBox = document.getElementById(chatId);
            if (chatBox.classList.contains('active')) {
                chatBox.classList.remove('active');
            } else {
                chatBox.classList.add('active');
            }
        }
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
