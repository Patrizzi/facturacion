@extends('layout')
@section('title', 'Inicio')
@section('atributo_actu', 'hidden')
@section('atributo_1', 'hidden')

@section('foto', auth()->user()->avatar )
@section('nombre', auth()->user()->personal->nombres )
@section('area', auth()->user()->name )
@section('content')

    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 style="color:#0073c1">Control de Eventos</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-3">
                                @include('eventos.menu')
                            </div>
                            <div class="col-lg-9">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_button">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ver Evento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('eventos.update') }}" method="POST" id="form_update" style="margin: 5px 2em">
                    @csrf
                    <input type="hidden" name="id_evento" id="event_id_form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Titulo <span class="text-red">*</span></label></label>
                                    <input type="text" class="form-control title-input" name="title"
                                        id="show_event_edit" placeholder="Titulo del Evento" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-12 col-md-12">
                                <label class="form-label">Cliente <span class="text-red">*</span></label>
                                <select class="form-control form-select select2_demo_client_edit" name="cliente_id"
                                    id="select_cli_id" data-bs-placeholder="Seleccionar Cliente">
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <label class="form-label">Tipo de Atención<span class="text-red">*</span></label></label>
                                <div class="form-control" id="form-all">
                                    <div id="todo_el_dia" style="text-align: center">
                                        <input type="checkbox" name="all_day_edit" id="all_day_edit"
                                            onclick="check_day_update()">Todo
                                        el día
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <label class="form-label">Categoría<span class="text-red">*</span></label></label>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <select class="form-control select_cat" name="categoria" id="select_cat_edit"
                                            onchange="color_select_opt()">
                                        </select>
                                        <input type="hidden" id="id_cat_edit">
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-control category-color">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <label class="form-label">Fecha de Inicio <span class="text-red">*</span></label></label>
                                <div class="row">
                                    <div class="col-sm-7 col-md-7">
                                        <input type="date" name="fecha_inicio" id="fecha_inicio_edit"
                                            class="form-control" required>
                                    </div>
                                    <div class="col-sm-5 col-md-5">
                                        <input type="time" name="hora_inicio" id="hora_inicio_edit" required
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6">
                                <label class="form-label">Fecha de Finalizacion <span
                                        class="text-red">*</span></label></label>
                                <div class="row">
                                    <div class="col-sm-7 col-md-7">
                                        <input type="date" name="fecha_fin" id="fecha_fin_edit" class="form-control"
                                            required>
                                    </div>
                                    <div class="col-sm-5 col-md-5">
                                        <input type="time" name="hora_fin" id="hora_fin_edit" required
                                            class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-6 col-md-6">
                                <label class="form-label">Asignar Usuario<span class="text-red">*</span></label></label>
                                <select class="form-control select2_demo_user" name="usuario" id="user_asig">
                                </select>
                            </div>
                            {{-- <div class="col-sm-6 col-md-6">
    
                        </div> --}}
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="form-label">Descripcion del Evento<span
                                        class="text-red">*</span></label></label>
                                <textarea class="form-control" name="description" id="descripcion_edit" placeholder="Descripcion del Evento"></textarea>
                            </div>
                        </div>
                    </div>
                    <span id="event_id"></span>
                    <div class="modal-footer">
                        <button class="btn btn-primary" id="btn_save_update">Save changes</button>
                        <button class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <style>
        .fc-toolbar-chunk>button {
            height: auto !important;
        }

        .fc-button-group>button {
            height: auto !important;
        }

        .title-input {
            font-size: 25px;
        }



        .fc-event-time,
        .fc-event-title {
            color: white;
        }

        .fc-toolbar-title:first-letter {
            text-transform: capitalize;
        }

        .fc-daygrid-event.fc-daygrid-dot-event.fc-event.fc-event-start.fc-event-end.fc-event-today:hover {
            cursor: pointer;
        }

        .fc-daygrid-event.fc-daygrid-dot-event.fc-event.fc-event-start.fc-event-end.fc-event-future {
            cursor: pointer;
        }

        .fc-daygrid-event.fc-daygrid-block-event.fc-h-event.fc-event.fc-event-start.fc-event-end.fc-event-today {
            cursor: pointer;
        }

        .fc-event.main {
            color: var(--fc-event-text-color, #fff);
        }
    </style>
    <input type="hidden" name="_token" value="ggmY2I1Gjt0wDFRU1ds0cP9H4g5dJaFg7X6wXgXU">
    <!-- Mainly scripts -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script src='https://momentjs.com/downloads/moment-with-locales.js'></script>

    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- jQuery UI  -->
    <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- iCheck -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <!-- Full Calendar -->
    <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#event_menu_eventos').click();
        });

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                locale: 'es',
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,timeGridDay,listMonth"
                },
                eventSources: [{
                    // type: "POST",
                    url: "{{ route('eventos.call') }}",
                    method: 'POST',
                    extraParams: {
                        '_token': $('input[name=_token]').val()
                    },
                }],
                eventClick: function(info) {
                    console.log(info.event);
                    //* AL HACER CLICK EN UN EVENTO
                    $('#select_cat_edit').empty();
                    // $('#select_cli_id').empty();
                    $('#show_event_edit').val(info.event.title);
                    $('#descripcion_edit').val(info.event.extendedProps.description);
                    $('#fecha_inicio_edit').val(moment(info.event.start, 'DD.MM.YYYY').format(
                        'YYYY-MM-DD'));
                    $('#fecha_fin_edit').val(moment(info.event.extendedProps.endStr, 'YYYY-MM-DDTHH:mm')
                        .format('YYYY-MM-DD'));

                    var select = new Option(info.event.extendedProps.cliente_name + `|` + info.event
                        .extendedProps.cliente_doc, info.event.extendedProps.cliente_id);
                    select.selected = true;
                    $(".select2_demo_client_edit").append(select);

                    selected_ajax();
                    $('#select_cat_edit').val(info.event.color);
                    $('#select_cat_edit').append(
                        '<option id="select_cat_opt" value=' + info.event.extendedProps.id_color +
                        ' selected >' + info.event.extendedProps.name_color + '</option>' +
                        `@foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->titulo }}</option>
                    @endforeach`);
                    $('#id_cat_edit').val(info.event.extendedProps.id_color);

                    var select2 = new Option(info.event
                        .extendedProps.user_name, info.event.extendedProps.user_id);
                    select2.selected = true;
                    $(".select2_demo_user").append(select2);
                    selected_user_ajax();

                    $('#event_id_form').val(info.event.id);
                    color_select_opt();
                    if (info.event.extendedProps.all_day == 1) {
                        $('#hora_inicio_edit').val('');
                        $('#hora_fin_edit').val('');
                        $('#all_day_edit').prop("checked", true);
                        $('#hora_inicio_edit').attr('disabled', true);
                        $('#hora_fin_edit').attr('disabled', true);
                    } else {
                        $('#hora_inicio_edit').val(moment(info.event.start, 'DD.MM.YYYY').format(
                            'HH:mm'));

                        $('#hora_fin_edit').val(moment(info.event.extendedProps.endStr,
                            'YYYY-MM-DDTHH:mm').format('HH:mm'));
                        console.log(moment(info.event.extendedProps.endStr, '').format('HH:mm'));

                        $('#all_day_edit').prop("checked", false);
                        $('#hora_inicio_edit').attr('disabled', false);
                        $('#hora_fin_edit').attr('disabled', false);

                    }
                    $("#edit_button").modal("show");


                },
                dateClick: function(info) {
                    // FUNCION AL HACER CLICK EN UN DIA - EVENTOS DEL DIA COMPLETO
                    console.log(moment(info.date, 'DD.MM.YYYY').format('HH:mm'))
                    var fecha = moment(info.date, 'DD.MM.YYYY').format('YYYY-MM-DD');
                    var hora_ini = moment(info.date, 'DD.MM.YYYY').format('HH:mm');

                    if (moment(info.date, 'DD.MM.YYYY').format('HH:mm') == '00:00') {
                        //EVENTO TODO EL DIA

                        $('#inicio_date').val(fecha);
                        $('#fin_date').val(fecha);

                        $('#all_day').attr('checked', true);
                        $('#hora_inicio').attr('disabled', true);
                        $('#hora_fin').attr('disabled', true);
                        $('#hora_inicio').attr('required', true);
                        $('#hora_fin').attr('required', true);
                        // alert('1');
                    } else {
                        $('#inicio_date').val(fecha);
                        $('#fin_date').val(fecha);
                        $('#fin_date').val();
                        $('#hora_inicio').val(hora_ini);
                        $('#all_day').attr('checked', false);
                        $('#hora_inicio').attr('disabled', false);
                        $('#hora_fin').attr('disabled', false);
                        $('#hora_inicio').attr('required', true);
                        $('#hora_fin').attr('required', true);
                        // alert('2');
                    }
                    $("#modal_event").modal("show");
                    // alert('Clicked on: ' + moment(info.date,'DD.MM.YYYY').format('YYYY-MM-DD HH:mm'));
                    // console.log(info.date);

                    // alert('Agregar evento diario')
                },

            });
            calendar.render();
            color_select();
        });



        function check_day_update() {
            if ($('#all_day_edit').is(':checked')) {
                $('#hora_inicio_edit').attr('disabled', true);
                $('#hora_fin_edit').attr('disabled', true);
                $('#hora_inicio_edit').attr('required', false);
                $('#hora_fin_edit').attr('required', false);
            } else {
                $('#hora_inicio_edit').attr('disabled', false);
                $('#hora_fin_edit').attr('disabled', false);
                $('#hora_inicio_edit').attr('required', true);
                $('#hora_fin_edit').attr('required', true);
            }
        }



        function color_select_opt() {
            var color_id = $('#select_cat_edit').val();
            console.log(color_id);
            $.ajax({
                type: "post",
                url: "{{ route('category.color') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'color': color_id
                },
                success: function(msg) {
                    console.log(msg);
                    $('.category-color').css('background-color', "" + msg + "");
                },
                error: function(eject) {
                    if (eject.status === 400) {
                        console.log(eject.responseJSON.error);
                    }
                },
                cache: true
            });
        }

        function selected_ajax() {
            $(".select2_demo_client_edit").select2({
                placeholder: "Seleccionar Cliente",
                ajax: {
                    minimumInputLength: 1,
                    url: "{{ route('pa.clients') }}",
                    dataType: 'json',
                    type: "POST",
                    delay: 10,
                    data: function(params) {
                        var tipo_coti = $('[name="tipo_coti"]:checked').val();
                        return {
                            _token: "{{ csrf_token() }}",
                            search: params.term, // search term
                            tipo_coti: tipo_coti
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.nombre + ' | ' + item.numero_documento,
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        }

        function selected_user_ajax() {
            $(".select2_demo_user").select2({
                placeholder: "Seleccionar Usuario",
                ajax: {
                    minimumInputLength: 1,
                    url: "{{ route('pa.user_search') }}",
                    dataType: 'json',
                    type: "POST",
                    delay: 10,
                    data: function(params) {
                        var tipo_coti = $('[name="tipo_coti"]:checked').val();
                        return {
                            _token: "{{ csrf_token() }}",
                            search: params.term, // search term
                            tipo_coti: tipo_coti
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.nombre,
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        }
    </script>

@endsection
