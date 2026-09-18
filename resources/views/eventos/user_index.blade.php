@extends('layout')
@section('title', 'Inicio')
@section('atributo_actu', 'hidden')
@section('atributo_1', 'hidden')

{{-- @section('foto', auth()->user()->avatar)
@section('nombre', auth()->user()->personal->nombres)
@section('area', auth()->user()->name) --}}
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
                                <div class="" style="padding:  10px 15px">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <label class="form-label"><strong>Usuario</strong></label>
                                            <div class="input-group">
                                                <select class="form-control select2_demo_user_select" name="usuario"
                                                    id="user_asig">
                                                </select>
                                                <div class="input-group-append">
                                                    <button class="btn btn-warning button_display" data-style="zoom-in"
                                                        id="eraser_events"><i class="fa fa-eraser"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-5">
                                            <label class="form-label"><strong>Estado de Seguimiento</strong></label>
                                            <div class="input-group">
                                                <select name="seguimiento_filtro" id="seguimiento_filtro"
                                                    class="form-control">
                                                    <option value="">Todos</option>
                                                    <option value="1">Sin Seguimiento</option>
                                                    <option value="2">Pendiente</option>
                                                    <option value="3">En progreso</option>
                                                    <option value="4">Completada</option>
                                                    <option value="5">Cancelada</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">&nbsp;</label>
                                            <button type="button" id="button_filtros"
                                                class="btn btn-primary form-control">Buscar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="ibox-content" style="padding:  5px 5px">

                                </div>
                                <br>
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
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group" style="margin-bottom: 0px">
                                <label class="form-label">Titulo <span class="text-red">*</span></label></label>
                                <div class="form-control">
                                    <h2 id="show_event_edit" style="margin-top: 10px"></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <label class="form-label">Cliente <span class="text-red">*</span></label>
                            {{-- <select class="form-control form-select select2_demo_client_edit" name="cliente_id"
                                id="select_cli_id" data-bs-placeholder="Seleccionar Cliente">
                            </select> --}}
                            <div class="form-control">
                                <p id="select2_demo_client_edit" style="margin-top: 5px;margin-bottom: 5px"></p>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <label class="form-label">Tipo de Atención<span class="text-red">*</span></label></label>
                            <div class="form-control" id="form-all">
                                <div id="todo_el_dia" style="text-align: center">
                                    <input type="checkbox" name="all_day_edit" id="all_day_edit"
                                        onclick="return false;">Todo
                                    el día
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <label class="form-label">Categoría<span class="text-red">*</span></label></label>
                            <div class="row">
                                <div class="col-sm-8">
                                    {{-- <select class="form-control select_cat" name="categoria" id="select_cat_edit"
                                        onchange="color_select_opt()">
                                    </select> --}}
                                    <div class="form-control">
                                        <p id="select_cat_edit" style="margin-bottom: 0px"></p>
                                    </div>
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
                                        class="form-control" required readonly>
                                </div>
                                <div class="col-sm-5 col-md-5">
                                    <input type="time" name="hora_inicio" id="hora_inicio_edit" required
                                        class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <label class="form-label">Fecha de Finalizacion <span
                                    class="text-red">*</span></label></label>
                            <div class="row">
                                <div class="col-sm-7 col-md-7">
                                    <input type="date" name="fecha_fin" id="fecha_fin_edit" class="form-control"
                                        required readonly>
                                </div>
                                <div class="col-sm-5 col-md-5">
                                    <input type="time" name="hora_fin" id="hora_fin_edit" required
                                        class="form-control" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <label class="form-label">Asignar Usuario<span class="text-red">*</span></label></label>
                            {{-- <select class="form-control select2_demo_user" name="usuario" id="user_asig">
                            </select> --}}
                            <div class="form-control">
                                <p id="select2_demo_user" style="margin-bottom: 0px"></p>
                            </div>
                        </div>
                        {{-- <div class="col-sm-6 col-md-6">
    
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label class="form-label">Descripcion del Evento<span
                                    class="text-red">*</span></label></label>
                            <textarea class="form-control" name="description" id="descripcion_edit" placeholder="Descripcion del Evento"
                                readonly></textarea>
                        </div>
                    </div>
                </div>
                <span id="event_id"></span>
                <div class="modal-footer">
                </div>
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
        .input-group>.select2-container--bootstrap {
            width: auto;
            flex: 1 1 auto;
        }

        .input-group>.select2-container--bootstrap .select2-selection--single {
            height: 100%;
            line-height: inherit;
            padding: 0.5rem 1rem;
            border: 1px solid #e5e6e7;
        }

        .select2-results__option.select2-results__option--highlighted {
            background-color: #1c84c6 !important;
            color: white !important;
        }

        select#user_asig {
            display: none;
        }

        select#seguimiento_filtro {
            display: none;
        }
    </style>
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
        // $(document).ready(function() {

        //     $('#event_menu_eventos').click();
        // });
        $(document).ready(function() {
            $('#event_menu_eventos').click();
            select_2_search();
            $('#seguimiento_filtro').select2({
                theme: "bootstrap"
            });
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
                    url: "{{ route('eventos.call_user') }}",
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
                    $('#show_event_edit').html(info.event.title);
                    $('#descripcion_edit').val(info.event.extendedProps.description);
                    $('#fecha_inicio_edit').val(moment(info.event.start, 'DD.MM.YYYY').format(
                        'YYYY-MM-DD'));
                    $('#fecha_fin_edit').val(moment(info.event.extendedProps.endStr, 'YYYY-MM-DDTHH:mm')
                        .format('YYYY-MM-DD'));

                    // var select = new Option(info.event.extendedProps.cliente_name + `|` + info.event
                    //     .extendedProps.cliente_doc, info.event.extendedProps.cliente_id);
                    // select.selected = true;
                    $("#select2_demo_client_edit").html(info.event.extendedProps.cliente_name);

                    // selected_ajax();
                    $('#select_cat_edit').val(info.event.color);
                    // $('#select_cat_edit').append(
                    //     '<option id="select_cat_opt" value=' + info.event.extendedProps.id_color +
                    //     ' selected >' + info.event.extendedProps.name_color + '</option>' +
                    //     `@foreach ($categories as $category)
                //     <option value="{{ $category->id }}">{{ $category->titulo }}</option>
                // @endforeach`);
                    $("#select_cat_edit").html(info.event.extendedProps.name_color);
                    // $('#id_cat_edit').val(info.event.extendedProps.id_color);
                    $('.category-color').css('background-color', `` + info.event.backgroundColor + ``);
                    console.log(info.event.backgroundColor);

                    // var select2 = new Option(info.event
                    //     .extendedProps.user_name, info.event.extendedProps.user_id);
                    // select2.selected = true;
                    // $(".select2_demo_user").append(select2);
                    $('#select2_demo_user').html(info.event.extendedProps.user_name)
                    // selected_user_ajax();

                    $('#event_id_form').val(info.event.id);
                    // color_select_opt();
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
                // dateClick: function(info) {
                //     // FUNCION AL HACER CLICK EN UN DIA - EVENTOS DEL DIA COMPLETO
                //     console.log(moment(info.date, 'DD.MM.YYYY').format('HH:mm'))
                //     var fecha = moment(info.date, 'DD.MM.YYYY').format('YYYY-MM-DD');
                //     var hora_ini = moment(info.date, 'DD.MM.YYYY').format('HH:mm');

                //     if (moment(info.date, 'DD.MM.YYYY').format('HH:mm') == '00:00') {
                //         //EVENTO TODO EL DIA

                //         $('#inicio_date').val(fecha);
                //         $('#fin_date').val(fecha);

                //         $('#all_day').attr('checked', true);
                //         $('#hora_inicio').attr('disabled', true);
                //         $('#hora_fin').attr('disabled', true);
                //         $('#hora_inicio').attr('required', true);
                //         $('#hora_fin').attr('required', true);
                //         // alert('1');
                //     } else {
                //         $('#inicio_date').val(fecha);
                //         $('#fin_date').val(fecha);
                //         $('#fin_date').val();
                //         $('#hora_inicio').val(hora_ini);
                //         $('#all_day').attr('checked', false);
                //         $('#hora_inicio').attr('disabled', false);
                //         $('#hora_fin').attr('disabled', false);
                //         $('#hora_inicio').attr('required', true);
                //         $('#hora_fin').attr('required', true);
                //         // alert('2');
                //     }
                //     $("#modal_event").modal("show");
                //     // alert('Clicked on: ' + moment(info.date,'DD.MM.YYYY').format('YYYY-MM-DD HH:mm'));
                //     // console.log(info.date);

                //     // alert('Agregar evento diario')
                // },

            });
            calendar.render();
            $('#button_filtros').click(function() {
                var eventSources = calendar.getEventSources();
                var len = eventSources.length;
                for (var i = 0; i < len; i++) {
                    eventSources[i].remove();
                }
                var data = $('.select2_demo_user_select').select2('data');
                var user_id = data.length > 0 ? data[0].id : null;

                var estado = $('#seguimiento_filtro').select2('data');
                var estado_id = estado.length > 0 ? estado[0].id : null;
                // console.log(user_id);
                $.ajax({
                    type: "post",
                    url: "{{ route('eventos.call') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'tipo': user_id,
                        'estado': estado_id
                    },
                    success: function(msg) {
                        console.log(msg);
                        calendar.addEventSource(msg);
                    },
                    error: function(eject) {
                        if (eject.status === 400) {
                            console.log(eject.responseJSON.error);
                        }
                    },
                    cache: true
                });
                // console.log(eventSources);
                /* This will make it show up */


                calendar.refetchEvents();
            });
            $('#eraser_events').click(function() {
                $('.select2_demo_user_select').val(null).trigger('change');
                var eventSources = calendar.getEventSources();
                var len = eventSources.length;
                for (var i = 0; i < len; i++) {
                    eventSources[i].remove();
                }
                $.ajax({
                    type: "post",
                    url: "{{ route('eventos.call') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'tipo': 'empty'
                    },
                    success: function(msg) {
                        console.log(msg);
                        calendar.addEventSource(msg);
                    },
                    error: function(eject) {
                        if (eject.status === 400) {
                            console.log(eject.responseJSON.error);
                        }
                    },
                    cache: true
                });

                calendar.refetchEvents();
            });
            // color_select();
        });

        function select_2_search() {
            $(".select2_demo_user_select").select2({
                theme: "bootstrap",
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

        $(".button_display").on("submit", function() {
            this.prop('disabled', true);
            setTimeout(() => {
                this.prop('disabled', false);
            }, 5000);
        });
    </script>
@endsection
