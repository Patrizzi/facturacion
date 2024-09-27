@extends('layout')
@section('title', 'Proyectos')
@section('content')

    <!-- CSS Activities -->
    <link rel="stylesheet" href="{{ asset('css/project_managers/project_managers.css') }}">

    <!-- Contenido -->
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ibox-activities">
                    <div class="ibox-title">
                        <div class="button-container">
                            <x-btn-link url="{{ route('project_managers.index') }}" text="Proyectos" />
                            <x-btn-link url="{{ route('project_managers.cards', $project_manager->id) }}" text="Tarjetas" active="true" />
                        </div>
                        <h3 style="margin-left: 10px;">Listado de Tarjetas - {{$project_manager->nombre}}</h3>
                        <div class="ibox-tools">
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="carousel-container">
                            @foreach ($project_manager->activities as $activity)
                                <x-ProjectManager.Activity.Card :card="$activity"/>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleChat(activityId, taskId) {
            const chatBox = document.getElementById('chat-box-' + taskId);
            const tasksContainer = document.getElementById("tasks-container-" + activityId);

            if (chatBox.classList.contains('active')) {
                chatBox.style.maxHeight = '0';
                chatBox.classList.remove('active');
                chatBox.style.padding = '0';
                chatBox.style.margin = '0';
                tasksContainer.style.maxHeight = "98px";
                return;
            }

            const activeChatsInActivity = tasksContainer.querySelectorAll('.task-chat-box.active');
            activeChatsInActivity.forEach(activeChat => {
                activeChat.style.maxHeight = '0';
                activeChat.classList.remove('active');
                activeChat.style.padding = '0';
                activeChat.style.margin = '0';
            });

            tasksContainer.style.maxHeight = "330px";
            chatBox.style.margin = '5px 0px 5px 0px';
            chatBox.style.padding = '6px';
            chatBox.classList.add('active');
            chatBox.style.maxHeight = chatBox.scrollHeight + 12 + 'px';
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
