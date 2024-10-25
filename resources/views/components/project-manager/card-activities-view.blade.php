@push('css')
    {!! push_asset_once(['css/plugins/slick/slick.css', 'css/plugins/slick/slick-theme.css',
    'css/plugins/sweetalert/sweetalert.css', 'css/project_managers/project_managers.css',
    'css/project_managers/card_chat.css', 'css/project_managers/cards/task.css',
    ]) !!}
    {{-- @once
        <link rel="stylesheet" href="{{ asset('css/project_managers/project_managers.css') }}">
        <link rel="stylesheet" href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" >
    @endonce --}}
@endpush
<div class="row justify-content-md-center">
    <div class="col-lg-12">
        <div class="card-container row animated fadeInRight">
            @foreach ($activities as $activity)
                <x-project-manager.activity.card :card="$activity"/>
            @endforeach
        </div>
    </div>
</div>
<div class="ml-3">
    {{ $activities->links() }}
</div>

@push('js')
    {!! push_asset_once(['js/plugins/slick/slick.min.js', 'js/plugins/slimscroll/jquery.slimscroll.min.js',
    'js/plugins/sweetalert/sweetalert.min.js']) !!}
    @once
        <script>
            document.addEventListener('input', function(event) {
                if (event.target.classList.contains('auto-resizable')) {
                    event.target.style.height = '22px';
                    event.target.style.height = event.target.scrollHeight + 'px';

                    const maxHeight = getComputedStyle(event.target).maxHeight;

                    if (maxHeight !== 'none' && event.target.scrollHeight >= parseInt(maxHeight)) {
                        event.target.style.overflowY = 'scroll';
                    } else {
                        event.target.style.overflowY = 'hidden';
                    }
                }
            });

            let lastTaskId = null;
            function loadTaskComments(taskId, url) {
                const commentHistory = $('.task-comment-history');
                const tasksList = $('.tasks-list');
                const minWidth = 50;

                // Verifica si el taskId ha cambiado
                if (taskId !== lastTaskId) {
                    tasksList.find('.task.selected').removeClass('selected');
                    tasksList.find(`.task[data-task-id="${taskId}"]`).addClass('selected');
                    
                    if (commentHistory.find('.task-chat-comments').length > 0) {
                        let currentWidth = Math.max(tasksList.width(), minWidth);
                        tasksList.css('width', currentWidth + 'px');
                    }

                    commentHistory.fadeOut(300, function() {
                        tasksList.css('width', '180px');
                        commentHistory.empty();

                        commentHistory.load(url.replace(':taskId', taskId), function(response, status, xhr) {
                            if (status == "error") {
                                console.error('Error al cargar los comentarios.');
                                console.error("Error al obtener comentarios: " + xhr.status + " " + xhr.statusText);
                            } else {
                                commentHistory.fadeIn(300);
                            }
                        });
                    });
                    lastTaskId = taskId;
                }
            }
            
            var lastUrls = {};
            $('[data-toggle="modal"]').on('click', function(event) {
                event.preventDefault();

                var button = $(this);
                var modalTarget = button.data('target');
                var url = button.data('url');
                var modal = $(modalTarget);

                var currentModal = button.closest('.modal');

                if (currentModal.length > 0) {
                    currentModal.modal('hide');
                }

                if (url !== lastUrls[modalTarget]) {
                    modal.find('.modal-dialog').load(url, function() {
                        lastUrls[modalTarget] = url;
                        modal.modal('show');
                    });
                } else {
                    modal.modal('show');
                }
            });

            // Mostrar confirmación del delete
            function deleteItem(id) {
                const form = document.getElementById(`delete-item-form-${id}`);

                swal({
                    title: '¿Estás seguro?',
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, borrar',
                    cancelButtonText: 'Cancelar'},
                    function (isConfirm) {
                        if (isConfirm) {
                            form.submit();
                        }
                    }
                );
            }
    
            // Funciones auxiliares para el manejo de colores
            function invertColor(hex, bw) {
                hex = hex.replace(/^#/, '');
                if (hex.length === 3) hex = hex.split('').map(h => h + h).join('');
                if (hex.length !== 6) throw new Error('Hex invalido.');
                let [r, g, b] = [0, 2, 4].map(offset => parseInt(hex.slice(offset, offset + 2), 16));
                return bw ? (r * 0.299 + g * 0.587 + b * 0.114) > 186 ? '#000000' : '#FFFFFF'
                        : '#' + [r, g, b].map(c => padZero((255 - c).toString(16))).join('');
            }

            function padZero(str, len = 2) {
                return ('0'.repeat(len) + str).slice(-len);
            }

            function rgbToHex(rgb) {
                const result = rgb.match(/\d+/g).map(Number);
                return "#" + ((1 << 24) + (result[0] << 16) + (result[1] << 8) + result[2]).toString(16).slice(1).toUpperCase();
            }

            const coloresGuardados = {};
            const calculateTextColor = (bgColor) => {
                if (!coloresGuardados[bgColor]) {
                    const hexColor = rgbToHex(bgColor);
                    coloresGuardados[bgColor] = invertColor(hexColor, true);
                }
                return coloresGuardados[bgColor];
            };
            
            $(document).ready(function() {
                // Función para invertir el color del título de la tarjeta
                const cards = document.querySelectorAll('.p-card');
                cards.forEach(card => {
                    const bgColor = window.getComputedStyle(card).backgroundColor;
                    card.querySelector('.p-card-title').style.color = calculateTextColor(bgColor);
                });

                // Función para truncar texto
                document.querySelectorAll('.truncate-text').forEach(parrafo => {
                    let atributoTruncate = parrafo.getAttribute('truncate');

                    // Si el atributo truncate no está definido, se asigna 100 como valor por defecto
                    if (atributoTruncate === null || isNaN(parseInt(atributoTruncate))) {
                        atributoTruncate = 100;
                    }

                    const longitudMax = parseInt(atributoTruncate);

                    const textoCompleto = parrafo.textContent.trim();

                    if (textoCompleto.length <= longitudMax) return;

                    const textoTruncado = textoCompleto.slice(0, longitudMax) + '... ';
                    const botonVerMas = `<span class="ver-mas">más</span>`;
                    const botonVerMenos = `<span class="ver-menos">menos</span>`;

                    parrafo.innerHTML = textoTruncado + botonVerMas;

                    parrafo.addEventListener('click', (e) => {
                        if (e.target.classList.contains('ver-mas')) {
                            parrafo.innerHTML = textoCompleto + ' ' + botonVerMenos;
                        } else if (e.target.classList.contains('ver-menos')) {
                            parrafo.innerHTML = textoTruncado + botonVerMas;
                        }
                    });
                });

                // let $carousel = $('.cards').slick({
                //     infinite: true,
                //     slidesToShow: 4,
                //     slidesToScroll: 1,
                //     arrows: true,
                //     dots: true,
                //     responsive: [{
                //             breakpoint: 1024,
                //             settings: {
                //                 slidesToShow: 3,
                //                 slidesToScroll: 1,
                //                 infinite: true,
                //                 dots: true
                //             }
                //         },
                //         {
                //             breakpoint: 800,
                //             settings: {
                //                 slidesToShow: 2,
                //                 slidesToScroll: 1
                //             }
                //         },
                //         {
                //             breakpoint: 480,
                //             settings: {
                //                 slidesToShow: 1,
                //                 slidesToScroll: 1
                //             }
                //         }
                //     ]
                // });

                // // Detectar cuando se muestra el tab correspondiente y recalcular slick
                // $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                //     let target = $(e.target).attr("href"); // El tab objetivo
                //     if (target === '#tab-2') { // El ID del tab donde está el carrusel
                //         $carousel.slick('setPosition');
                //     }
                // });
            });
        </script>
    @endonce
@endpush
