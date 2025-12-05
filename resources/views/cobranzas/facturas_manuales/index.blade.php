@extends('layout')

@section('title', 'Pagos de Facturas Manuales')
@section('content')
    @if ($errors->any())
        <div style="padding-top: 20px;">
            <div class="alert alert-danger">
                <a class="alert-link" href="#">
                    @foreach ($errors->all() as $error)
                        <li style="color: red">{{ $error }}</li>
                    @endforeach
                </a>
            </div>
        </div>
    @endif

    {{-- @include('cobranzas.facturas_manual._shared.statitics') --}}

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist"
                                style="align-items: center;border-bottom: 0px !important;">
                                @include('cobranzas.facturas_manuales._shared.tabs')
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    <button class="btn btn-primary" type="button" id="pago_lote_total" disabled><i
                                            class="fa fa-money"></i></button>
                                </ul>
                            </ul>
                            <div class="tab-content" style="margin-top: -1px">
                                <div class="tab-pane active show" role="tabpanel" id="tab-1"
                                    style="margin-top: -1px;border-top: 1px solid #e7eaec !important;">
                                    <br> {{-- FILTRADO DE DATOS --}}
                                    <div class="search-responsive">
                                        <div class="row">
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange"
                                                        id="data_range_filter"
                                                        value=""
                                                        readonly="readonly" />
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-secondary" id="revert_select">
                                                            <i class="fa fa-history"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="input-group" style="flex-wrap: nowrap;">
                                                    <select class="select2_demo_client" name="cliente" id="cliente"
                                                        required=""></select>
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="limpiar_select()">
                                                            <i class="fa fa-eraser"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <select class="select_2_estado" name="" id="select_estado">
                                                        <option value="">Seleccionar Estado de Pago</option>
                                                        <option value="0">Sin Pagar</option>
                                                        <option value="1">Pagado Parcial</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <select class="select_2_tipo_pago" name="" id="select_tipo_pago">
                                                        <option value="">Seleccionar Forma de Pago</option>
                                                        <option value="1">Contado</option>
                                                        <option value="2">Credito</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                <button type="button" class="btn btn-primary btn-block"
                                                    id="button_filtros">Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table
                                            class="table table-striped table-bordered table-hover dataTables-example-facturas_manual">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Estado</th>
                                                    <th>N° de Factura M</th>
                                                    <th>Cliente</th>
                                                    <th>Emisión</th>
                                                    <th>Monto Total</th>
                                                    <th>N° Cuotas</th>
                                                    <th>Saldo</th>
                                                    <th>Fecha V.</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>













    <input type="hidden" name="" id="tipo_comprobante_view" value="factura_manual">
    

    @include('cobranzas.facturas_manuales._shared.modal_pago_all')

    <style>
        table {
            width: 100% !important;
        }

        .pago_m {
            display: none;
        }

        .pago_m.m_pago_1 {
            display: block;
        }

        #view_all {
            display: none;
        }

        .view_pagos {
            display: none;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .select2-search__field {
            width: 100% !important;
        }

        .select2.select2-container.select2-container--default {
            width: 100% !important;
        }

        .select2-selection.select2-selection--single {
            height: 100%;
        }

        .select2-container.select2-container--default.select2-container--open {
            z-index: 3200;
        }

        .div_select>.select2.select2-container.select2-container--default {
            width: 100% !important;
        }

        label.col-form-label {
            font-weight: bold;
        }

        .input-group.col-sm-4 {
            height: fit-content;
        }

        .input-group-text {
            width: 40px;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -moz-appearance: textfield;
        }

        .col-sm-9>.select2.select2-container.select2-container--default {
            width: 100% !important;
        }

        i.fa.fa-arrow-right.icon.icon-arrow-right.glyphicon.glyphicon-arrow-right {
            color: black;
            display: none;
        }

        .next.available::after {
            content: ">>";
        }

        i.fa.fa-arrow-left.icon.icon-arrow-left.glyphicon.glyphicon-arrow-left {
            color: black;
            display: none;
        }

        .prev.available::after {
            content: "<<";
        }

        .form-control.tipo_check {
            width: 20px;
        }

        #collapse-head-three,
        #collapse-head-four {
            cursor: pointer;
        }

        .tab-pane.active.show {
            border-right: 1px;
            border-left: 1px;
            border-bottom: 1px;
        }

        .tab-pane.active.show {
            border-right: 1px solid #e7eaec;
            border-left: 1px solid #e7eaec;
            border-bottom: 1px solid #e7eaec;
        }

        .search-responsive {
            padding-right: 15px;
            padding-left: 15px;
        }
    </style>
    <!-- scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.time.js') }}"></script>

    <link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">

    <!-- Switchery -->
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
    @include('cobranzas.adelanto')

    <script>
        $('#tab-1-tab').addClass('active');


        $('#collapse-head-three').on('click', function() {
            $('#collapseThree').collapse('show');
            $('#collapseFour').collapse('hide');
        });
        $('#collapse-head-four').on('click', function() {
            $('#collapseFour').collapse('show');
            $('#collapseThree').collapse('hide');
        });

        $('.chosen-select').chosen({
            width: "100%"
        });
        // FUNCION DE DATATABLE FACTURA M
        var fact_m_table = $('.dataTables-example-facturas_manual').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('cobranzas.lista_facturas_manual_index') }}",
                method: "get",
                data: function(d) {
                    d.datarange = $('#data_range_filter').val();
                    d.cliente_id = $("#cliente option:selected").val();
                    d.estado_pago = $('#select_estado').val();
                    d.tipo = $('#select_estado').val();
                }
            },
            "drawCallback": function(settings) {
                // Esta función se ejecuta después de cada draw/redraw del DataTable
                // initializeICheck($('.dataTables-guia-ingreso'));
                // restoreCheckboxState();
                // updateSelectionCounter();
            },
            "columnDefs": [{
                    'width': '1vmax',
                    'targets': [0],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        return '<input type="checkbox" id="check_' + full[0] +
                            '" class="i-checks check_only check_lost_' + full[0] +
                            '" name="select_row" value="' + full[0] + '" onclick="check_lote(' + full[0] +
                            ')"  >';
                    }
                },
                {
                    // 'width': '5%',
                    'targets': [1],
                },
                {
                    // 'width': '5%',
                    'targets': [2],
                },
                {
                    'width': '25%',
                    'targets': [3],
                },
                {
                    // 'width': '5%',
                    'targets': [4],
                },
                {
                    // 'width': '5%',
                    'targets': [5],
                },
                {
                    // 'width': '5%',
                    'targets': [6],
                },
                {
                    // 'width': '5%',
                    'targets': [7],
                },
                {
                    // 'width': '5%',
                    'targets': [8],
                    'render': function(data, type, full, meta) {
                        var fechaStr = full[8];
                        if (!fechaStr) return "";

                        var partes = fechaStr.split("-");
                        var fecha = new Date(partes[2], partes[1] - 1, partes[0]);

                        var hoy = new Date();


                        if (fecha < hoy) {
                            return `<span style="color:red; font-weight:bold;">${fechaStr}</span>`;
                        } else {

                            return `<span>${fechaStr}</span>`;
                        }
                    }
                },
                {
                    // 'width': '55%',
                    'targets': [9],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var base_url = "{{ route('pagos.show_facturas_m', ':id') }}";
                        var url_view = base_url.replace(':id', full[2]);
                        var view =
                            `<a class="btn btn-primary btn-ls"
                        href=" ` + url_view + `"><i class="fa fa-eye"></i></a>
                            <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-primary btn-ls dropdown-toggle"><i class="fa fa-money"></i></button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="pago_factura(` + full[9] + `)">Pagar</a></li>
                                <li><a class="dropdown-item" href="#" class="font-bold">Adelantar</a></li>
                            </ul>
                        </div>`;

                        // var view +=  ``;

                        return view;
                    }
                },
                // {
                //     'width': '5%',
                //     'targets': [10],
                // },
            ],
        })
        $('input[name="daterange"]').daterangepicker({
            "locale": {
                "separator": " | ",
                "applyLabel": "Guardar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Custom",
                "daysOfWeek": [
                    "Do",
                    "Lu",
                    "Ma",
                    "Mi",
                    "Ju",
                    "Vi",
                    "Sa"
                ],
                "monthNames": [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre"
                ],
                "firstDay": 1
            }
        });
        $(`#button_filtros`).on('click', function() {
            fact_m_table.ajax.reload();
        });

        //*  Campos para el pago con cheque

        function calcular_monto_cheque() {
            var moneda_principal = $('#simbolor_label').html();
            var moneda_select = $("#moneda_pago_cheque option:selected").text();
            var tipo_cambio = parseFloat($('#tipo_cambio_cheque').val());
            var monto_actual = parseFloat($('#cheque_monto').val());
            var monto_total = parseFloat($('#tota_totas').html());
            if (moneda_select != moneda_principal) { //Si la moneda es diferente a la principal
                $('#tipo_cambio_cheque').attr('readonly', false);
                if (moneda_select != '$') { // Si la moneda no es dolar
                    var monto_convertido = monto_total * tipo_cambio;
                    $('#cheque_monto').val(monto_convertido.toFixed(2));
                } else {
                    $('#cheque_monto').val(monto_total.toFixed(2));
                }
            } else {
                if (moneda_select == '$') { // Si la moneda no es sol
                    $('#cheque_monto').val(monto_total.toFixed(2));
                } else {
                    var monto_convertido = monto_actual * tipo_cambio;
                    $('#cheque_monto').val(monto_convertido.toFixed(2));
                }

                $('#tipo_cambio_cheque').attr('readonly', true);
            }
        }
        $('#cheque_fecha_emision').on('change', function() {
            $.ajax({
                url: "{{ route('tipo_cambio.busqueda_tipo_cambio') }}",
                method: "GET",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'fecha': $(this).val()
                },
                success: function(data) {
                    toastr.success('Tipo de cambio obtenido correctamente', '', {
                        timeOut: 3000
                    });
                    $('#tipo_cambio_cheque').val(data.tipo_cambio.paralelo);
                    calcular_monto_cheque();

                },
                error: function(data) {
                    toastr.warning('No se pudo obtener el tipo de cambio, añadirlo manualmente', '', {
                        timeOut: 3000
                    });
                }
            });
        });
        $('#moneda_pago_cheque').on('change', function() { // CUANDO CAMBIA LA MONEDA DE PAGO
            var moneda_principal = $('#simbolor_label').html();
            var moneda_select = $(this).find('option:selected').text();
            var tipo_cambio = parseFloat($('#tipo_cambio_cheque').val());
            var monto_actual = parseFloat($('#cheque_monto').val());
            var monto_total = parseFloat($('#tota_totas').html());
            if (moneda_select != moneda_principal) { //Si la moneda es diferente a la principal
                $('#cheque_monto').removeAttr('max');
                $('#tipo_cambio_cheque').attr('readonly', false);
                if (moneda_select != '$') { // Si la moneda no es dolar
                    var monto_convertido = monto_total * tipo_cambio;
                    $('#cheque_monto').val(monto_convertido.toFixed(2));
                } else {
                    $('#tipo_cambio_cheque').val(1);
                    $('#cheque_monto').val(monto_total.toFixed(2));
                }
            } else {
                $('#cheque_monto').attr('max', monto_total);
                if (moneda_select == '$') { // Si la moneda no es sol
                    $('#cheque_monto').val(monto_total.toFixed(2));
                    $('#tipo_cambio_cheque').val(1);
                } else {
                    var monto_convertido = monto_actual * tipo_cambio;
                    $('#cheque_monto').val(monto_convertido.toFixed(2));
                }
                $('#tipo_cambio_cheque').attr('readonly', true);
            }
        });
        $('#cheque_monto').on('keyup', function() {
            var monto = parseFloat($(this).val());
            var monto_total = parseFloat($('#tota_totas').html());
            var moneda_principal = $('#simbolor_label').html();
            var moneda_pago = $("#moneda_pago_cheque option:selected").text();
            if (moneda_pago != moneda_principal) {
                $('#tipo_cambio_cheque').attr('readonly', false);
                if (moneda_pago == '$') {
                    var tipo_cambio = monto_total / monto;
                    $('#tipo_cambio_cheque').val(tipo_cambio.toFixed(4));
                } else {
                    var tipo_cambio = monto / monto_total;
                    $('#tipo_cambio_cheque').val(tipo_cambio.toFixed(4));
                }
            } else {
                $('#cheque_monto').val(monto_total.toFixed(2));
                $('#tipo_cambio_cheque').val(1);
                $('#tipo_cambio_cheque').attr('readonly', true);
            }
        });
        $('#tipo_cambio_cheque').on('keyup', function() {
            var tipo_cambio_manual = parseFloat($(this).val());
            var monto_total = parseFloat($('#tota_totas').html());
            var monto_actual = parseFloat($('#cheque_monto').val());
            var moneda_principal = $('#simbolor_label').html();
            var moneda_select = $("#moneda_pago_cheque option:selected").text();

            if (moneda_select != moneda_principal) { //Si la moneda es diferente a la principal
                $('#tipo_cambio_cheque').attr('readonly', false);
                if (moneda_select != '$') { // Si la moneda no es dolar
                    var monto_convertido = monto_total * tipo_cambio_manual;
                    $('#cheque_monto').val(monto_convertido.toFixed(2));
                } else {
                    var monto_convertido = monto_total / tipo_cambio_manual;
                    $('#cheque_monto').val(monto_convertido.toFixed(2));
                }
            } else {
                if (moneda_select == '$') { // Si la moneda no es sol
                    var monto_convertido = monto_actual / tipo_cambio_manual;
                    $('#cheque_monto').val(monto_convertido.toFixed(2));
                } else {
                    var monto_convertido = monto_actual * tipo_cambio_manual;
                    $('#cheque_monto').val(monto_convertido.toFixed(2));
                }
            }
        });

        //*!! Campos para el pago con tarjeta

        function calcular_monto_tarjeta() {
            var moneda_principal = $('#simbolor_label').html();
            var moneda_select = $("#moneda_pago_tarjeta option:selected").text();
            var tipo_cambio = parseFloat($('#tipo_cambio_tarjeta').val());
            var monto_total = parseFloat($('#tota_totas').html());

            if (moneda_select != moneda_principal) {

                $('#tipo_cambio_tarjeta').attr('readonly', false);

                if (moneda_select != '$') {
                    var monto_convertido = monto_total * tipo_cambio;
                    $('#tarjeta_monto').val(monto_convertido.toFixed(2));
                } else {
                    $('#tarjeta_monto').val(monto_total.toFixed(2));
                }

            } else {

                if (moneda_select == '$') {
                    $('#tarjeta_monto').val(monto_total.toFixed(2));
                } else {
                    var monto_convertido = monto_total * tipo_cambio;
                    $('#tarjeta_monto').val(monto_convertido.toFixed(2));
                }

                $('#tipo_cambio_tarjeta').attr('readonly', true);
            }
        }
        $('#tarjeta_fecha_pago').on('change', function() {
            // get_tipo_cambio($(this).val(), $('#tipo_cambio_tarjeta'));
            $.ajax({
                url: "{{ route('tipo_cambio.busqueda_tipo_cambio') }}",
                method: "GET",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'fecha': $(this).val()
                },
                success: function(data) {
                    toastr.success('Tipo de cambio obtenido correctamente', '', {
                        timeOut: 3000
                    });
                    $('#tipo_cambio_tarjeta').val(data.tipo_cambio.paralelo);
                    calcular_monto_tarjeta();

                },
                error: function(data) {
                    toastr.warning('No se pudo obtener el tipo de cambio, añadirlo manualmente', '', {
                        timeOut: 3000
                    });
                }
            });
        });
        $('#moneda_pago_tarjeta').on('change', function() { // CUANDO CAMBIA LA MONEDA DE PAGO
            var moneda_principal = $('#simbolor_label').html();
            var moneda_select = $(this).find('option:selected').text();
            var tipo_cambio = parseFloat($('#tipo_cambio_tarjeta').val());
            var monto_actual = parseFloat($('#tarjeta_monto').val());
            var monto_total = parseFloat($('#tota_totas').html());
            if (moneda_select != moneda_principal) { //Si la moneda es diferente a la principal
                $('#tipo_cambio_tarjeta').attr('readonly', false);
                if (moneda_select != '$') { // Si la moneda no es dolar
                    var monto_convertido = monto_total * tipo_cambio;
                    $('#tarjeta_monto').val(monto_convertido.toFixed(2));
                } else {
                    $('#tipo_cambio_tarjeta').val(1);
                    $('#tarjeta_monto').val(monto_total.toFixed(2));
                }
            } else {
                if (moneda_select == '$') { // Si la moneda no es sol
                    $('#tipo_cambio_tarjeta').val(1);
                    $('#tarjeta_monto').val(monto_total.toFixed(2));
                } else {
                    var monto_convertido = monto_actual * tipo_cambio;
                    $('#tarjeta_monto').val(monto_convertido.toFixed(2));
                }

                $('#tipo_cambio_tarjeta').attr('readonly', true);
            }
        });
        $('#tarjeta_monto').on('keyup', function() {
            var monto = parseFloat($(this).val());
            var monto_total = parseFloat($('#tota_totas').html());
            var moneda_principal = $('#simbolor_label').html();
            var moneda_pago = $("#moneda_pago_tarjeta option:selected").text();
            if (moneda_pago != moneda_principal) {
                $('#tipo_cambio_tarjeta').attr('readonly', false);
                if (moneda_pago == '$') {
                    var tipo_cambio = monto_total / monto;
                    $('#tipo_cambio_tarjeta').val(tipo_cambio.toFixed(4));
                } else {
                    var tipo_cambio = monto / monto_total;
                    $('#tipo_cambio_tarjeta').val(tipo_cambio.toFixed(4));
                }
            } else {
                $('#tarjeta_monto').val(monto_total.toFixed(2));
                $('#tipo_cambio_tarjeta').val(1);
                $('#tipo_cambio_tarjeta').attr('readonly', true);
            }
        });
        $('#tipo_cambio_tarjeta').on('keyup', function() {
            var tipo_cambio_manual = parseFloat($(this).val());
            var monto_total = parseFloat($('#tota_totas').html());
            var monto_actual = parseFloat($('#tarjeta_monto').val());
            var moneda_principal = $('#simbolor_label').html();
            var moneda_select = $("#moneda_pago_tarjeta option:selected").text();

            if (moneda_select != moneda_principal) { //Si la moneda es diferente a la principal
                $('#tipo_cambio_tarjeta').attr('readonly', false);
                console.log('diferentes');
                if (moneda_select != '$') { // Si la moneda no es dolar
                    var monto_convertido = monto_total * tipo_cambio_manual;
                    $('#tarjeta_monto').val(monto_convertido.toFixed(2));
                } else {
                    // var monto_convertido = monto_total / tipo_cambio_manual;
                    $('#tarjeta_monto').val(monto_convertido.toFixed(2));
                }
            } else {
                console.log('iguales');
                if (moneda_select == '$') { // Si la moneda no es sol
                    var monto_convertido = monto_actual / tipo_cambio_manual;
                    $('#tarjeta_monto').val(monto_convertido.toFixed(2));
                } else {
                    var monto_convertido = monto_actual * tipo_cambio_manual;
                    $('#tarjeta_monto').val(monto_convertido.toFixed(2));
                }
            }
        });

        //*!! Campos para el pago con Efectivo

        function calcular_monto_efectivo() {
            var moneda_principal = $('#simbolor_label').html();
            var moneda_select = $("#moneda_pago_efectivo option:selected").text();
            var tipo_cambio = parseFloat($('#tipo_cambio_efectivo').val());
            var monto_total = parseFloat($('#tota_totas').html());

            if (moneda_select != moneda_principal) {

                $('#tipo_cambio_efectivo').attr('readonly', false);

                if (moneda_select != '$') {
                    var monto_convertido = monto_total * tipo_cambio;
                    $('#efectivo_monto').val(monto_convertido.toFixed(2));
                } else {
                    $('#efectivo_monto').val(monto_total.toFixed(2));
                }

            } else {

                if (moneda_select == '$') {
                    $('#efectivo_monto').val(monto_total.toFixed(2));
                } else {
                    var monto_convertido = monto_total * tipo_cambio;
                    $('#efectivo_monto').val(monto_convertido.toFixed(2));
                }

                $('#tipo_cambio_efectivo').attr('readonly', true);
            }
        }
        $('#efectivo_fecha_pago').on('change', function() {
            // get_tipo_cambio($(this).val(), $('#tipo_cambio_efectivo'));
            $.ajax({
                url: "{{ route('tipo_cambio.busqueda_tipo_cambio') }}",
                method: "GET",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'fecha': $(this).val()
                },
                success: function(data) {
                    toastr.success('Tipo de cambio obtenido correctamente', '', {
                        timeOut: 3000
                    });
                    $('#tipo_cambio_efectivo').val(data.tipo_cambio.paralelo);
                    calcular_monto_efectivo();

                },
                error: function(data) {
                    toastr.warning('No se pudo obtener el tipo de cambio, añadirlo manualmente', '', {
                        timeOut: 3000
                    });
                }
            });
        });
        $('#moneda_pago_efectivo').on('change', function() { // CUANDO CAMBIA LA MONEDA DE PAGO
            var moneda_principal = $('#simbolor_label').html();
            var moneda_select = $(this).find('option:selected').text();
            var tipo_cambio = parseFloat($('#tipo_cambio_efectivo').val());
            var monto_actual = parseFloat($('#efectivo_monto').val());
            var monto_total = parseFloat($('#tota_totas').html());
            if (moneda_select != moneda_principal) { //Si la moneda es diferente a la principal
                $('#tipo_cambio_efectivo').attr('readonly', false);
                if (moneda_select != '$') { // Si la moneda no es dolar
                    var monto_convertido = monto_total * tipo_cambio;
                    $('#efectivo_monto').val(monto_convertido.toFixed(2));
                } else {
                    $('#tipo_cambio_efectivo').val(1);
                    $('#efectivo_monto').val(monto_total.toFixed(2));
                }
            } else {
                if (moneda_select == '$') { // Si la moneda no es sol
                    $('#tipo_cambio_efectivo').val(1);
                    $('#efectivo_monto').val(monto_total.toFixed(2));
                } else {
                    var monto_convertido = monto_actual * tipo_cambio;
                    $('#efectivo_monto').val(monto_convertido.toFixed(2));
                }

                $('#tipo_cambio_efectivo').attr('readonly', true);
            }
        });
        $('#efectivo_monto').on('keyup', function() {
            var monto = parseFloat($(this).val());
            var monto_total = parseFloat($('#tota_totas').html());
            var moneda_principal = $('#simbolor_label').html();
            var moneda_pago = $("#moneda_pago_efectivo option:selected").text();
            if (moneda_pago != moneda_principal) {
                $('#tipo_cambio_efectivo').attr('readonly', false);
                if (moneda_pago == '$') {
                    var tipo_cambio = monto_total / monto;
                    $('#tipo_cambio_efectivo').val(tipo_cambio.toFixed(4));
                } else {
                    var tipo_cambio = monto / monto_total;
                    $('#tipo_cambio_efectivo').val(tipo_cambio.toFixed(4));
                }
            } else {
                $('#efectivo_monto').val(monto_total.toFixed(2));
                $('#tipo_cambio_efectivo').val(1);
                $('#tipo_cambio_efectivo').attr('readonly', true);
            }
        });
        $('#tipo_cambio_efectivo').on('keyup', function() {
            var tipo_cambio_manual = parseFloat($(this).val());
            var monto_total = parseFloat($('#tota_totas').html());
            var monto_actual = parseFloat($('#efectivo_monto').val());
            var moneda_principal = $('#simbolor_label').html();
            var moneda_select = $("#moneda_pago_efectivo option:selected").text();

            if (moneda_select != moneda_principal) { //Si la moneda es diferente a la principal
                $('#tipo_cambio_efectivo').attr('readonly', false);
                console.log('diferentes');
                if (moneda_select != '$') { // Si la moneda no es dolar
                    var monto_convertido = monto_total * tipo_cambio_manual;
                    $('#efectivo_monto').val(monto_convertido.toFixed(2));
                } else {
                    // var monto_convertido = monto_total / tipo_cambio_manual;
                    $('#efectivo_monto').val(monto_convertido.toFixed(2));
                }
            } else {
                console.log('iguales');
                if (moneda_select == '$') { // Si la moneda no es sol
                    var monto_convertido = monto_actual / tipo_cambio_manual;
                    $('#efectivo_monto').val(monto_convertido.toFixed(2));
                } else {
                    var monto_convertido = monto_actual * tipo_cambio_manual;
                    $('#efectivo_monto').val(monto_convertido.toFixed(2));
                }
            }
        });

        //*!! Campos para el pago con Transferencia

        function calcular_monto_transferencia() {
            var moneda_principal = $('#simbolor_label').html();
            var moneda_select = $("#moneda_pago_transferencia option:selected").text();
            var tipo_cambio = parseFloat($('#tipo_cambio_transferencia').val());
            var monto_total = parseFloat($('#tota_totas').html());

            if (moneda_select != moneda_principal) {

                $('#tipo_cambio_transferencia').attr('readonly', false);

                if (moneda_select != '$') {
                    var monto_convertido = monto_total * tipo_cambio;
                    $('#transferencia_monto').val(monto_convertido.toFixed(2));
                } else {
                    $('#transferencia_monto').val(monto_total.toFixed(2));
                }

            } else {

                if (moneda_select == '$') {
                    $('#transferencia_monto').val(monto_total.toFixed(2));
                } else {
                    var monto_convertido = monto_total * tipo_cambio;
                    $('#transferencia_monto').val(monto_convertido.toFixed(2));
                }

                $('#tipo_cambio_transferencia').attr('readonly', true);
            }
        }
        $('#transferencia_fecha_pago').on('change', function() {
            $.ajax({
                url: "{{ route('tipo_cambio.busqueda_tipo_cambio') }}",
                method: "GET",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'fecha': $(this).val()
                },
                success: function(data) {
                    toastr.success('Tipo de cambio obtenido correctamente', '', {
                        timeOut: 3000
                    });
                    $('#tipo_cambio_transferencia').val(data.tipo_cambio.paralelo);
                    calcular_monto_efectivo();

                },
                error: function(data) {
                    toastr.warning('No se pudo obtener el tipo de cambio, añadirlo manualmente', '', {
                        timeOut: 3000
                    });
                }
            });
        });
        $('#moneda_pago_transferencia').on('change', function() { // CUANDO CAMBIA LA MONEDA DE PAGO
            var moneda_principal = $('#simbolor_label').html();
            var moneda_select = $(this).find('option:selected').text();
            var tipo_cambio = parseFloat($('#tipo_cambio_transferencia').val());
            var monto_actual = parseFloat($('#transferencia_monto').val());
            var monto_total = parseFloat($('#tota_totas').html());
            if (moneda_select != moneda_principal) { //Si la moneda es diferente a la principal
                $('#tipo_cambio_transferencia').attr('readonly', false);
                if (moneda_select != '$') { // Si la moneda no es dolar
                    var monto_convertido = monto_total * tipo_cambio;
                    $('#transferencia_monto').val(monto_convertido.toFixed(2));
                } else {
                    $('#tipo_cambio_transferencia').val(1);
                    $('#transferencia_monto').val(monto_total.toFixed(2));
                }
            } else {
                if (moneda_select == '$') { // Si la moneda no es sol
                    $('#tipo_cambio_transferencia').val(1);
                    $('#transferencia_monto').val(monto_total.toFixed(2));
                } else {
                    var monto_convertido = monto_actual * tipo_cambio;
                    $('#transferencia_monto').val(monto_convertido.toFixed(2));
                }

                $('#tipo_cambio_transferencia').attr('readonly', true);
            }
        });
        $('#transferencia_monto').on('keyup', function() {
            var monto = parseFloat($(this).val());
            var monto_total = parseFloat($('#tota_totas').html());
            var moneda_principal = $('#simbolor_label').html();
            var moneda_pago = $("#moneda_pago_transferencia option:selected").text();
            if (moneda_pago != moneda_principal) {
                $('#tipo_cambio_transferencia').attr('readonly', false);
                if (moneda_pago == '$') {
                    var tipo_cambio = monto_total / monto;
                    $('#tipo_cambio_transferencia').val(tipo_cambio.toFixed(4));
                } else {
                    var tipo_cambio = monto / monto_total;
                    $('#tipo_cambio_transferencia').val(tipo_cambio.toFixed(4));
                }
            } else {
                $('#transferencia_monto').val(monto_total.toFixed(2));
                $('#tipo_cambio_transferencia').val(1);
                $('#tipo_cambio_transferencia').attr('readonly', true);
            }
        });
        $('#tipo_cambio_transferencia').on('keyup', function() {
            var tipo_cambio_manual = parseFloat($(this).val());
            var monto_total = parseFloat($('#tota_totas').html());
            var monto_actual = parseFloat($('#transferencia_monto').val());
            var moneda_principal = $('#simbolor_label').html();
            var moneda_select = $("#moneda_pago_transferencia option:selected").text();

            if (moneda_select != moneda_principal) { //Si la moneda es diferente a la principal
                $('#tipo_cambio_transferencia').attr('readonly', false);
                console.log('diferentes');
                if (moneda_select != '$') { // Si la moneda no es dolar
                    var monto_convertido = monto_total * tipo_cambio_manual;
                    $('#transferencia_monto').val(monto_convertido.toFixed(2));
                } else {
                    // var monto_convertido = monto_total / tipo_cambio_manual;
                    $('#transferencia_monto').val(monto_convertido.toFixed(2));
                }
            } else {
                console.log('iguales');
                if (moneda_select == '$') { // Si la moneda no es sol
                    var monto_convertido = monto_actual / tipo_cambio_manual;
                    $('#transferencia_monto').val(monto_convertido.toFixed(2));
                } else {
                    var monto_convertido = monto_actual * tipo_cambio_manual;
                    $('#transferencia_monto').val(monto_convertido.toFixed(2));
                }
            }
        });
    </script>


    <script>
        var elem_2 = document.querySelector('.js-switch-pago');
        var switchery_2 = new Switchery(elem_2, {
            color: '#ED5565'
        });

        $(document).ready(function() {
            $('#select_banco_pagos').select2({
                placeholder: "Seleccionar",
            });
            $('#select_cuenta_pago').select2({
                placeholder: "Seleccionar",
            });

            $('#select_banco_transf_pag').select2({
                placeholder: "Seleccionar",
            });
            $('#select_cuenta_adl_pag').select2({
                placeholder: "Seleccionar",
            });
        });

        function changue_bancos_pagos(val) {
            // $("#select_banco_adl").attr('disabled', false);
            $('#select_bancos_pago').val(val);
            var id_banc = $("#select_banco_pagos").val();
            $('#select_cuenta_pago').select2({
                placeholder: `Seleccionar N° Cuenta de ${val.options[val.selectedIndex].text}`,
                ajax: {
                    minimumInputLength: 1,
                    url: "{{ route('bancos.registros_search') }}",
                    dataType: 'json',
                    type: "POST",
                    data: function(params) {
                        return {
                            '_token': $('input[name=_token]').val(),
                            'id_bancos': id_banc
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.tipo_cuenta + ' - ' + item.nombre_cuenta,
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        }

        function changue_bancos_pago_tr() {
            // $("#select_banco_adl").attr('disabled', false);
            console.log('a');
            var id_banc = $("#select_banco_transf_pag").val();
            $('#select_cuenta_adl_pag').select2({
                placeholder: "Seleccionar",
                ajax: {
                    minimumInputLength: 1,
                    url: "{{ route('bancos.registros_search') }}",
                    dataType: 'json',
                    type: "POST",
                    data: function(params) {
                        return {
                            '_token': $('input[name=_token]').val(),
                            'id_bancos': id_banc
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    id: item.id,
                                    text: item.tipo_cuenta + ' - ' + item.nombre_cuenta,
                                };
                            })
                        };
                    },
                    cache: true
                }
            });
        }

        $("#select_cuenta_adl").select2();
        $("#select_cuenta_adl_transf").select2();
        $(document).ready(function() {

            // $('input[name="daterange2"]').daterangepicker({
            //         "locale": {
            //             "format": "DD-MM-YYYY",
            //             "separator": " | ",
            //             "applyLabel": "Guardar",
            //             "cancelLabel": "Cancelar",
            //             "fromLabel": "Desde",
            //             "toLabel": "Hasta",
            //             "customRangeLabel": "Custom",
            //             "daysOfWeek": [
            //                 "Do",
            //                 "Lu",
            //                 "Ma",
            //                 "Mi",
            //                 "Ju",
            //                 "Vi",
            //                 "Sa"
            //             ],
            //             "monthNames": [
            //                 "Enero",
            //                 "Febrero",
            //                 "Marzo",
            //                 "Abril",
            //                 "Mayo",
            //                 "Junio",
            //                 "Julio",
            //                 "Agosto",
            //                 "Septiembre",
            //                 "Octubre",
            //                 "Noviembre",
            //                 "Diciembre"
            //             ],
            //             "firstDay": 1
            //         }
            //     },
            //     function(start, end, label) {
            //         var startDate = start.format('DD-MM-YYYY');
            //         var endDate = end.format('DD-MM-YYYY');
            //         var dates = [];
            //         var currentDate = new Date(start);

            //         while (currentDate <= end) {
            //             var day = ('0' + currentDate.getDate()).slice(-2);
            //             var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
            //             var year = currentDate.getFullYear();

            //             var formattedDate = day + '-' + month + '-' + year;
            //             dates.push(formattedDate);

            //             currentDate.setDate(currentDate.getDate() + 1);
            //         }
            //         var dateRangeString = dates.join('|');
            //         // console.log(dateRangeString);
            //         table2.column(6).search(dateRangeString, true, false).draw();
            //     }
            // );
        });

        function limpiar_fechas() {
            var table_lp = $('.dataTables-example').DataTable();
            table_lp.column(5).search('').draw();
        }

        function limpiar_fechas_2() {
            var table_lp_2 = $('.dataTables-examaple-2').DataTable();
            table_lp_2.column(6).search('').draw();
        }
        var tipo_coti = 3;
        $(".select2_demo_client").select2({
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
                                id: item.nombre,
                                text: item.nombre + ' | ' + item.numero_documento,
                            };
                        })
                    };
                },
                cache: true
            }
        });
        $(".select2_demo_client_2").select2({
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
                                id: item.nombre,
                                text: item.nombre + ' | ' + item.numero_documento,
                            };
                        })
                    };
                },
                cache: true
            }
        });
    </script>
    <script>
        $(".select_2_multipl").select2();
        $('.select_2_estado').select2();
        $('.select_2_tipo_pago').select2();

        $(document).ready(function() {
            table = $('.dataTables-example').DataTable({
                pageLength: 20,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                bAutoWidth: true,
                buttons: []
            });
            $(document).on('change', '#select_estado', function(event) {
                var nombre = $("#select_estado option:selected").val();
                table.column(2).search(nombre).draw();
            });
            $(document).on('change', '#cliente', function(event) {
                var nombre_2 = $("#cliente option:selected").val();
                table.column(4).search(nombre_2).draw();
            });
        });

        function limpiar_select() {
            // console.log('a');
            var table_lp = $('.dataTables-example').DataTable();
            table_lp.column(4).search('').draw();
            $('#cliente').val(null).trigger('change');

        }

        $(document).ready(function() {
            table2 = $('.dataTables-examaple-2').DataTable({
                pageLength: 20,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
            $(document).on('change', '#cliente_2', function(event) {
                var nombre2 = $("#cliente_2 option:selected").val();
                table2.column(3).search(nombre2).draw();
            });
        });

        function limpiar_select_2() {
            // console.log('a');
            var table2_2l = $('.dataTables-examaple-2').DataTable();
            table2_2l.column(3).search('').draw();
            $('#cliente_2').val(null).trigger('change');

        }
        $(document).ready(function() {
            table3 = $('.dataTables-examaple-3').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
        });
        // PAGO INDIVIDUAL
        function pago_factura(n_factura) {
            // console.log('a');
            $('#div_facturas').empty();
            $('#tota_totas').html("0.00");
            $('#ids_divs_factura').empty();
            $('#todo_pago').modal('show');

            var only_id_fact = `
                <input type="hidden" name="id_factura_m[]" class="" id="id_factura_` + n_factura + `" value="` +
                n_factura + `">
            `;
            $('#ids_divs_factura').append(only_id_fact);
            var ids_array = [n_factura];
            $.ajax({
                type: "post",
                url: "{{ route('pagos.lista_ajax_fact_m') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'ids_facturas': ids_array
                },
                success: function(msg) {
                    // console.log(msg)
                    msg.forEach(function(row, index) {
                        // console.log(row.cuotas_array);
                        // cod_factura
                        var data = `
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="d-flex align-items-center my-2">
                                            <span class=" fw-bold"><strong>` + row.factura_cod + `</strong></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-8 div_select">
                                        <select id="sel_` + index + `" class="select_2_multipl_` + index +
                            ` select2-selection--multiple" name="cuotas_precio_` + row.factura_cod +
                            `[]" multiple="multiple" onchangue="select_2_(` + index + `)" required>
                                                            ` + row.cuotas_array.map(function(bar) {
                                if (bar.estado == 0) {
                                    return '<option value="' + bar.id_cuota + '_' + bar.monto +
                                        '">' +
                                        'N°-' + bar.cuota_n + ': ' + bar.monto + '</option>'
                                }
                            }) + `
                                        </select>
                                    </div>
                                    <div class="input-group  input-group-sm col-sm-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm"
                                                style="justify-content: center">` + row.factura_simbolo + `</span>
                                        </div>
                                        <label class="form-control form-control" id="lbl_tot_` + index + `"
                                            aria-describedby="inputGroup-sizing-sm">0</label>

                                        <input class="form-control form-control-sm" type="hidden"
                                            name="tot_cuotas[]" id="total_cuotas_` +
                            index + `">
                                    </div>
                                </div>
                            `;
                        $('#div_facturas').append(data);
                        $(`.select_2_multipl_` + index + ``).select2({
                            placeholder: "Seleccionar 1 o más cuotas"
                        });
                        $(`.select_2_multipl_` + index + ``).on('select2:select', function(e) {
                            var data = e.params.data;
                            console.log(data)
                            var ant = $(`#total_cuotas_` + index + ``).val();
                            if (ant == "") {
                                ant = 0;
                            }
                            console.log("total_cuotas_" + ant)

                            var data_cuota = data.text.replace(/N°-\d+: /g, '');
                            console.log(data_cuota);

                            var math_total = Math.round((parseFloat(data_cuota) + parseFloat(
                                ant)) * 100) / 100;
                            console.log("math_total" + math_total);
                            $(`#total_cuotas_` + index + ``).val(math_total);
                            $(`#lbl_tot_` + index + ``).html(math_total);
                            // TOTAL DE TOTALES
                            var tota_tot = $('#tota_totas').html();
                            if (tota_tot == "") {
                                tota_tot = 0;
                            }
                            //TODO O NADA
                            var igual = $("#simbolor_label").html();
                            console.log("igual" + igual);
                            console.log("row.factura_simbolo" + row.factura_simbolo);
                            if (igual === row.factura_simbolo) {
                                var tot_math = Math.round((parseFloat(tota_tot) + parseFloat(
                                    data_cuota)) * 100) / 100;
                            } else {
                                if (row.factura_moneda == "soles" && igual ==
                                    '$') { //DE DOLAR A SOL
                                    var new_val = parseFloat(data_cuota) / tipo_cambio;
                                    var tot_math = Math.round((parseFloat(tota_tot) +
                                        parseFloat(new_val)) * 100) / 100;
                                    // console.log('a');
                                } else { // DE SOL A DOLAR
                                    var new_val = parseFloat(data_cuota) * tipo_cambio;
                                    var tot_math = Math.round((parseFloat(tota_tot) +
                                        parseFloat(new_val)) * 100) / 100;
                                    // console.log('b');
                                }
                            }
                            console.log("aaa" + tot_math);
                            $('#tota_totas').html(tot_math);
                            $('#cheque_monto').attr('max', tot_math);
                            $('#efectivo_pago').attr('min', tot_math);
                            $('#cheque_monto').val(tot_math);

                            $('#tarjeta_monto').val(tot_math);
                            $('#efectivo_monto').val(tot_math);
                            $('#transferencia_monto').val(tot_math);

                            console.log(data.id);
                            var ids_cuotas = data.id;
                            var ids_arry = ids_cuotas.split('_');

                            var cuota_array = `
                                <input class="input_check" type="hidden" name="id_cuota[]" value="` + ids_arry[0] +
                                `" id='cuota_` + ids_arry[0] + `'>
                            `;
                            $('#ids_divs_factura').append(cuota_array);

                        });
                        $(`.select_2_multipl_` + index + ``).on('select2:unselect', function(e) {
                            var data = e.params.data;
                            var ids_cuotas = data.id;
                            var ids_arry = ids_cuotas.split('_');
                            console.log(ids_arry);
                            $(`#cuota_` + ids_arry[0] + ``).remove();

                            var ant = $(`#total_cuotas_` + index + ``).val();
                            if (ant == "") {
                                ant = 0;
                            }
                            var data_cuota = data.text.replace(/N°-\d+: /g, '');
                            var math_total = Math.round((parseFloat(ant) - parseFloat(
                                data_cuota)) * 100) / 100;
                            $(`#total_cuotas_` + index + ``).val(math_total);
                            $(`#lbl_tot_` + index + ``).html(math_total);
                            var tota_tot = $('#tota_totas').html();

                            if (tota_tot == "") {
                                tota_tot = 0;
                            }
                            var tot_math = Math.round((parseFloat(tota_tot) - parseFloat(
                                data_cuota)) * 100) / 100;
                            $('#tota_totas').html(tot_math);
                            $('#cheque_monto').attr('max', tot_math);
                            $('#efectivo_pago').attr('min', tot_math);
                            $('#cheque_monto').val(tot_math);
                        });
                    });

                },
                error: function(eject) {
                    if (eject.status === 400) {
                        console.log(eject.responseJSON.error);
                    }
                },
                cache: true
            });
        }

        function select_pago(item) {
            $('.pago_m').css('display', 'none');
            $(`.m_pago_` + item).css('display', 'block');

            $('.class_pago').attr('required', false);
            // $('.class_pago').val('');
            $(`.pago_class_` + item).attr('required', true);
            $(`.file_input`).attr('required', false);

            $('.btn_pago_selec').addClass("btn-outline");
            $(`#bm_pago_` + item).removeClass("btn-outline");
            $('#input_pago').val(item);

            var fecha = $('#fecha_value_php').val();
            // console.log(fecha);
            $('.fecha_hoy').val(fecha);
        }
        $('#efectivo_pago').on('keyup', function() {
            var pago = this.value;
            var total = $('#tota_totas').text();
            var vuelto = parseFloat(this.value) - parseFloat(total);
            $('#efectivo_vuelto').val(Math.round(vuelto * 100) / 100);
        })

        // PAGO MULTIPLE

        function check_lote(num) {
            //separado por nombre de moneda
            var elemento = document.getElementsByClassName(`check_lost_` + num);
            var list_clas = elemento[0].className;
            let array_class = list_clas.split(' ');

            var id_cuot = elemento[0].getAttribute('id');
            let id_one = id_cuot.split('_');
            console.log('1')
            if (elemento[0].checked) {
                console.log(elemento[0])
                var only_id_fact = `
                    <input type="hidden" class="option_select_comprobantes" name="id_factura_m[]" id="id_factura_` +
                    id_one[1] + `" value="` + id_one[1] +
                    `">`;
                $('#ids_divs_factura').append(only_id_fact);
            } else {
                $(`#id_factura_` + id_one[1] + ``).remove();
                console.log('2')
            }
            console.log('3')
            var count_check = document.querySelectorAll('.check_only');
            let checkboxesDesactivados = 0;
            // Recorrer los checkboxes y contar los desactivados
            count_check.forEach(function(checkbox) {
                if (checkbox.checked) {
                    checkboxesDesactivados++;
                }
                var class_check = checkbox.className;
                let class_global = class_check.split(' ');
                if (class_global[3] != array_class[3]) {
                    checkbox.disabled = true;
                }

            });
            if (checkboxesDesactivados > 0) {
                $('#pago_lote_total').attr('disabled', false);
            } else {
                count_check.forEach(function(checkbox) {
                    checkbox.disabled = false;
                });
                $('#pago_lote_total').attr('disabled', true);
            }
        }
        $('#pago_lote_total').on('click', function() {

            $('#div_facturas').empty();
            $('#tot_simbolo').empty();

            var count_check = document.querySelectorAll('.check_only');

            var arr = new Array();
            var arr = [];
            count_check.forEach(function(checkbox) {

                if (checkbox.checked) {

                    var id_cuot = checkbox.id;
                    let id_one = id_cuot.split('_');

                    arr.push(id_one[1]);
                }

            });
            pago_lote_total(arr);

        });

        function pago_lote_total(n_factura) {
            console.log(n_factura);
            // console.log(n_factura)
            $('#todo_pago').modal('show');
            // console.log('a');
            $('#div_facturas').empty();
            $('#tot_simbolo').empty();
            // $('#ids_divs_factura').empty();
            $('#todo_pago').modal('show');

            $.ajax({
                type: "post",
                url: "{{ route('pagos.lista_ajax_fact_m') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'ids_facturas': n_factura
                },
                success: function(msg) {
                    // console.log(msg[0])
                    msg.forEach(function(row, index) {
                        // console.log(row.cuotas_array);
                        // cod_factura
                        var data = `
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="d-flex align-items-center my-2">
                                            <span class=" fw-bold"><strong>` + row.factura_cod +
                            `</strong></span>
                                            <input class="form-control" type="hidden" name="numero_factura[]" id="numero_fac_` +
                            index + `" value="` + row.factura_cod + `">
                                        </div>
                                    </div>
                                    <div class="col-sm-8 div_select">
                                        <select placeholder="Seleccionar 1 o más cuotas" id="sel_` + index +
                            `" class="select_2_multipl_` + index +
                            ` select2-selection--multiple" name="cuotas_precio_` + row.factura_cod +
                            `[]" multiple="multiple" onchangue="select_2_(` + index + `)" required>
                                                        ` + row.cuotas_array.map(function(bar) {
                                if (bar.estado == 0) {
                                    return '<option value="' + bar.id_cuota + '_' + bar.monto +
                                        '">' +
                                        'N°-' + bar.cuota_n + ': ' + bar.monto + '</option>'
                                }
                            }) + `
                                        </select>
                                    </div>
                                    <div class="input-group  input-group-sm col-sm-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="inputGroup-sizing-sm"
                                                style="justify-content: center">` + row.factura_simbolo + `</span>
                                        </div>
                                        <label class="form-control form-control" id="lbl_tot_` + index + `"
                                            aria-describedby="inputGroup-sizing-sm">0</label>

                                        <input class="form-control form-control-sm" type="hidden"
                                            name="tot_cuotas[]" id="total_cuotas_` +
                            index + `">
                                    </div>
                                </div>
                        `;
                        $('#div_facturas').append(data);

                        $(`.select_2_multipl_` + index + ``).select2({
                            placeholder: "Seleccionar Cuotas"
                        });
                        $(`.select_2_multipl_` + index + ``).on('select2:select', function(e) {
                            var data = e.params.data;
                            // console.log(data)
                            var ant = $(`#total_cuotas_` + index + ``).val();
                            if (ant == "") {
                                ant = 0;
                            }
                            var data_cuota = data.text.replace(/N°-\d+: /g, '');
                            console.log(data_cuota);

                            var math_total = Math.round((parseFloat(data_cuota) + parseFloat(
                                ant)) * 100) / 100;
                            $(`#total_cuotas_` + index + ``).val(math_total);
                            $(`#lbl_tot_` + index + ``).html(math_total);
                            // TOTAL DE TOTALES
                            var tota_tot = $('#tota_totas').html();
                            if (tota_tot == "") {
                                tota_tot = 0;
                            }
                            //TODO O NADA
                            var igual = $("#simbolor_label").html();

                            if (igual == row.factura_simbolo) {
                                var tot_math = Math.round((parseFloat(tota_tot) + parseFloat(
                                    data_cuota)) * 100) / 100;
                            } else {
                                if (row.factura_moneda == "soles" && igual ==
                                    '$') { //DE DOLAR A SOL
                                    var new_val = parseFloat(data_cuota) / tipo_cambio;
                                    var tot_math = Math.round((parseFloat(tota_tot) +
                                        parseFloat(new_val)) * 100) / 100;
                                    // console.log('a');
                                } else { // DE SOL A DOLAR
                                    var new_val = parseFloat(data_cuota) * tipo_cambio;
                                    var tot_math = Math.round((parseFloat(tota_tot) +
                                        parseFloat(new_val)) * 100) / 100;
                                    // console.log('b');
                                }
                            }
                            // console.log(tot_math);
                            $('#tota_totas').html(tot_math);
                            $('#cheque_monto').attr('max', tot_math);
                            $('#efectivo_pago').attr('min', tot_math);
                            $('#cheque_monto').val(tot_math);

                            $('#tarjeta_monto').val(tot_math);
                            $('#efectivo_monto').val(tot_math);
                            $('#transferencia_monto').val(tot_math);

                            console.log("data.id" + data.id);
                            var ids_cuotas = data.id;
                            var ids_arry = ids_cuotas.split('_');
                            console.log("ids_cuotas" + ids_cuotas);
                            console.log("ids_arry" + ids_arry);

                            var cuota_array = `
                                <input class="input_check" type="hidden" name="id_cuota[]" value="` + ids_arry[0] +
                                `" id='cuota_` + ids_arry[0] + `'>
                            `;
                            $('#ids_divs_factura').append(cuota_array);

                        });
                        $(`.select_2_multipl_` + index + ``).on('select2:unselect', function(e) {
                            var data = e.params.data;
                            var ids_cuotas = data.id;
                            var ids_arry = ids_cuotas.split('_');
                            console.log(ids_arry);
                            $(`#cuota_` + ids_arry[0] + ``).remove();

                            var ant = $(`#total_cuotas_` + index + ``).val();
                            if (ant == "") {
                                ant = 0;
                            }
                            var data_cuota = data.text.replace(/N°-\d+: /g, '');
                            var math_total = Math.round((parseFloat(ant) - parseFloat(
                                data_cuota)) * 100) / 100;
                            $(`#total_cuotas_` + index + ``).val(math_total);
                            $(`#lbl_tot_` + index + ``).html(math_total);
                            var tota_tot = $('#tota_totas').html();

                            // console.log(tota_tot);
                            if (tota_tot == "") {
                                tota_tot = 0;
                            }
                            var tot_math = Math.round((parseFloat(tota_tot) - parseFloat(
                                data_cuota)) * 100) / 100;
                            $('#tota_totas').html(tot_math);
                            $('#cheque_monto').attr('max', tot_math);
                            $('#efectivo_pago').attr('min', tot_math);
                            $('#cheque_monto').val(tot_math);
                        });
                    });
                    var data_2 =
                        `<hr><div class="input-group-prepend"><label class="form-control disabled" id="simbolor_label" style="margin: 0px">` +
                        msg[0].factura_simbolo +
                        `</label></div><label class='form-control disabled' id='tota_totas'></label>`;
                    $('#tot_simbolo').append(data_2);
                },
                error: function(eject) {
                    if (eject.status === 400) {
                        console.log(eject.responseJSON.error);
                    }
                },
                cache: true
            });
        }
        $('#contad_check').on('click', function() {
            var count_check = document.querySelectorAll('.tipo_check');
            let checkboxesDesactivados = 0;
            count_check.forEach(function(checkbox) {
                if (checkbox.checked) {
                    checkboxesDesactivados++;
                }
            });
            if (checkboxesDesactivados == 0 || checkboxesDesactivados == 2) {
                var table_lp = $('.dataTables-example').DataTable();
                table_lp.column(6).search('credito|contado', true, false).draw();
            } else {
                var table_lp = $('.dataTables-example').DataTable();
                table_lp.column(6).search('contado', true, false).draw();
            }


        });
        $('#credit_check').on('click', function() {
            var count_check = document.querySelectorAll('.tipo_check');
            let checkboxesDesactivados = 0;

            count_check.forEach(function(checkbox) {
                if (checkbox.checked) {
                    checkboxesDesactivados++;
                }
            });
            if (checkboxesDesactivados == 0 || checkboxesDesactivados == 2) {
                var table_lp = $('.dataTables-example').DataTable();
                table_lp.column(6).search('credito|contado', true, false).draw();
            } else {
                var table_lp = $('.dataTables-example').DataTable();
                table_lp.column(6).search('credito', true, false).draw();
            }
        });
        $('#todo_pago').on('hidden.bs.modal', function() {
            document.querySelectorAll('.input_check').forEach(function(input) {
                input.remove(); // Elimina el input del DOM
            });
            document.querySelectorAll('.option_select_comprobantes').forEach(function(input) {
                input.remove(); // Elimina el input del DOM
            });
        })
    </script>
@endsection
