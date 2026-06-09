@extends('layout')

@section('title', 'Pagos de Facturas')
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

    {{-- @include('cobranzas.facturas._shared.statitics') --}}

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist"
                                style="align-items: center;border-bottom: 0px !important;">
                                @include('cobranzas.facturas._shared.tabs')
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    <button class="btn btn-primary" type="button" id="pago_lote_total" disabled><i
                                            class="fa fa-money"></i></button>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-download"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button type="button" id="btn-exportar-filtrado" class="dropdown-item">
                                            <i class="fa fa-file-excel-o"></i> Excel
                                        </button>
                                    </div>
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
                                                        id="data_range_filter" value="{{ date('01/m/Y') }} - {{ date('t/m/Y') }}" readonly="readonly" />
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
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <select class="select_2_estado" name="estado_pago" id="select_estado">
                                                        <option value="">Seleccionar Estado de Pago</option>
                                                        <option value="0">Sin Pagar</option>
                                                        <option value="1">Pagado Parcial</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <select class="select_2_tipo_pago" name="forma_pago_id" id="tipo_forma_pago">
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
                                            class="table table-striped table-bordered table-hover dataTables-example-facturas">
                                            <thead>
                                                <tr>
                                                    <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                    <th>Estado</th>
                                                    <th>N° de Factura</th>
                                                    <th>Cliente</th>
                                                    <th>Emisión</th>
                                                    <th>Monto Total</th>
                                                    <th>N° Cuotas</th>
                                                    <th>Saldo</th>
                                                    <th>Fecha V.</th>
                                                    <th>Obs.</th>
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


    <input type="hidden" name="" id="tipo_comprobante_view" value="factura">

    @include('cobranzas._shared.facturas.modal_pago_all')

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
        .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td{
            vertical-align: middle
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

    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <script>
        $('#tab-1-tab').addClass('active');

        $(document).ready(function() {
            $('#modal_pago_tipo_comprobante').val('factura');
        });
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
        // FUNCION DE DATATABLE FACTURA 
        var fact_table = $('.dataTables-example-facturas').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('cobranzas.lista_facturas_index') }}",
                method: "get",
                data: function(d) {
                    d.datarange = $('#data_range_filter').val();
                    d.cliente_id = $("#cliente option:selected").val();
                    d.select_estado = $('#select_estado').val();
                    d.tipo_forma_pago = $('#tipo_forma_pago').val();
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
                            '" class="i-checks check_fact check_only check_lost_' + full[0] +
                            ' grupo_A " name="select_row" value="' + full[0] + '" >';
                    }
                },
                {
                    // 'width': '5%',
                    'targets': [1],
                    'render': function(data, type, full, meta) {
                        const estados = {
                            "Sin pago": `<span class="badge badge-danger">Sin Pagar</span>`,
                            "Pago Parcial": `<span class="badge badge-warning">Pagado Parcial</span>`,
                        };

                        return estados[data] || `<span class="badge badge-secondary">Desconocido</span>`;
                    }
                },
                {
                    // 'width': '5%',
                    'targets': [2]
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
                    'targets': [9],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                    //  console.log(full[10]['nota_credito']);
                        var base_otros = '';
                        if (full[11] == "2") {
                            base_otros += `<span class="label label-success">NC</span> `;
                        }
                        return base_otros;
                    }
                },
                {
                    // 'width': '55%',
                    'targets': [10],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var base_url = "{{ route('pagos.show_facturas', ':id') }}";
                        var url_view = base_url.replace(':id', full[0]);
                        var view =
                            `<a class="btn btn-primary btn-sm btn-ls"
                        href=" ` + url_view + `"><i class="fa fa-eye"></i></a>
                            <div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-primary btn-sm btn-ls dropdown-toggle"><i class="fa fa-money"></i></button>
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
            drawCallback: function() {
                $('[data-toggle="tooltip"]').tooltip();
                $('.check_fact').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });

                $('[data-toggle="popover"]').popover({
                    trigger: 'hover',
                    container: 'body'
                });
            }
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
            fact_table.ajax.reload();
        });
    </script>
    <script>
        $(".select_2_multipl").select2();
        $('.select_2_estado').select2();
        $('.select_2_tipo_pago').select2();

        // PAGO INDIVIDUAL
        function pago_factura(n_factura) {
            // console.log('a');
            $('#div_facturas').empty();
            $('#tota_totas').html("0.00");
            $('#ids_divs_factura').empty();
            $('#todo_pago').modal('show');

            var only_id_fact = `
                <input type="hidden" name="id_factura[]" class="" id="id_factura_` + n_factura + `" value="` +
                n_factura + `">
            `;
            $('#ids_divs_factura').append(only_id_fact);
            var ids_array = [n_factura];
            $.ajax({
                type: "post",
                url: "{{ route('pagos.lista_ajax_fact') }}",
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
                                var tipo_cambio = row.tipo_cambio;
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

        $(document).on('ifChecked ifUnchecked', '.check_only', function () {
            check_lote(this);
        });
        function check_lote(checkbox) {
            const id = checkbox.value;
            const checked = $(checkbox).is(':checked');
            // Clase del grupo
            const grupo = [...checkbox.classList]
                .find(c => c.startsWith('grupo_A'));
            if (checked) {
                if (!$(`#id_factura_${id}`).length) {
                    $('#ids_divs_factura').append(`
                        <input
                            type="hidden"
                            class="option_select_comprobantes"
                            id="id_factura_${id}"
                            name="id_factura[]"
                            value="${id}">
                    `);
                }
            } else {
                $(`#id_factura_${id}`).remove();
            }
            const marcados = $('.check_only:checked').length;

            if (marcados > 0) {

                $('.check_only').each(function () {

                    const grupoActual = [...this.classList]
                        .find(c => c.startsWith('grupo_A'));

                    if (grupoActual !== grupo && !$(this).is(':checked')) {
                        $(this).iCheck('disable');
                    }

                });

                $('#pago_lote_total').prop('disabled', false);

            } else {

                $('.check_only').iCheck('enable');

                $('#pago_lote_total').prop('disabled', true);
            }
        }
        $('#pago_lote_total').on('click', function() {

            $('#div_facturas').empty();
            // $('#ids_divs_factura').empty();

            // $('input[name="select_row"]:checked').each(function() {
            //     check_lote($(this).val());
            // });
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
            // $('#todo_pago').modal('show');
            // console.log('a');
            $('#div_facturas').empty();
            $('#tot_simbolo').empty();
            // $('#ids_divs_factura').empty();
            $('#todo_pago').modal('show');

            $.ajax({
                type: "post",
                url: "{{ route('pagos.lista_ajax_fact') }}",
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
                                var tipo_cambio = row.tipo_cambio;
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
    @include('cobranzas._shared.js')
    @if (session('success'))
        <script>
            setTimeout(function() {
                toastr.success("{{ session('success') }}");
            }, 300);
        </script>
    @endif

    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('js/icheck.min.js') }}"></script>
    <script>
    $(document).ready(function() {
        // Variables globales
        var allSelectedIds = [];
        var masterChecked = false;
        var isUpdatingCheckboxes = false; // Flag para evitar loops infinitos

        // Inicializar iCheck
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        function hasAnySelection() {
            return Array.isArray(allSelectedIds) && allSelectedIds.length > 0;
        }

        // Función para obtener TODOS los IDs mediante AJAX (para serverSide DataTables)
        function getAllIds(callback) {
            $.ajax({
                url: "{{ route('cobranzas.lista_facturas_index') }}",
                method: "GET",
                data: {
                    datarange: $('#data_range_filter').val(),
                    estado_pago: $('#select_estado').val(),
                    cliente_id: $('#cliente option:selected').val(),
                    tipo: $('#select_tipo_pago').val(),
                    value: "",
                    length: -1,
                    start: 0,
                    get_all_ids: true
                },
                success: function(response) {
                    var ids = [];
                    if (response.data && response.data.length > 0) {
                        response.data.forEach(function(row) {
                            if (row[0]) {
                                ids.push(row[0].toString());
                            }
                        });
                    }
                    console.log('getAllIds() encontró estos IDs:', ids);
                    console.log('Total de IDs encontrados:', ids.length);
                    callback(ids);
                },
                error: function(xhr, status, error) {
                    console.error('Error obteniendo todos los IDs:', error);
                    callback([]);
                }
            });
        }

        // Función para actualizar el estado del master checkbox automáticamente
        function updateMasterCheckbox() {
            if (isUpdatingCheckboxes) return;

            getAllIds(function(allIds) {
                // Si hay IDs disponibles y todos están seleccionados, marcar master
                var allSelected = allIds.length > 0 && allIds.every(function(id) {
                    return allSelectedIds.includes(id);
                });

                isUpdatingCheckboxes = true;
                if (allSelected && !masterChecked) {
                    masterChecked = true;
                    $('thead input[type="checkbox"]').iCheck('check');
                    console.log('Master checkbox marcado automáticamente - todos los registros están seleccionados');
                } else if (!allSelected && masterChecked) {
                    masterChecked = false;
                    $('thead input[type="checkbox"]').iCheck('uncheck');
                    console.log('Master checkbox desmarcado automáticamente - no todos los registros están seleccionados');
                }
                isUpdatingCheckboxes = false;
            });
        }

        // Checkbox del header - seleccionar/deseleccionar todos
        $('thead input[type="checkbox"]').on('ifChecked ifUnchecked', function(event) {
            if (isUpdatingCheckboxes) return; // Evitar loops infinitos

            // closeWhatsappPanels();
            // closeEmailPanels();

            if (event.type === 'ifChecked') {
                masterChecked = true;
                console.log('Master checkbox marcado manualmente - obteniendo todos los IDs...');

                getAllIds(function(ids) {
                    allSelectedIds = [...ids]; // Crear una copia del array
                    console.log('allSelectedIds después del master:', allSelectedIds);
                    console.log('Cantidad de IDs en allSelectedIds:', allSelectedIds.length);

                    // Marcar todos los checkboxes visibles en la página actual
                    isUpdatingCheckboxes = true;
                    $('.dataTables-example-facturas tbody input[type="checkbox"]').iCheck('check');
                    isUpdatingCheckboxes = false;
                });
            } else {
                masterChecked = false;
                allSelectedIds = [];
                console.log('Master checkbox desmarcado manualmente - allSelectedIds limpio');

                isUpdatingCheckboxes = true;
                $('.dataTables-example-facturas tbody input[type="checkbox"]').iCheck('uncheck');
                isUpdatingCheckboxes = false;
            }
        });

        // Checkboxes individuales
        $(document).on('ifChecked ifUnchecked', '.dataTables-example-facturas tbody input[type="checkbox"]', function(event) {
            if (isUpdatingCheckboxes) return; // Evitar que se ejecute cuando estamos actualizando programáticamente

            // closeWhatsappPanels();
            // closeEmailPanels();

            var row = $(this).closest('tr');
            var rowData = fact_table.row(row).data();

            if (rowData && rowData[0]) {
                var id = rowData[0].toString();

                if (event.type === 'ifChecked') {
                    // Agregar ID si no está ya seleccionado
                    if (!allSelectedIds.includes(id)) {
                        allSelectedIds.push(id);
                    }
                    console.log('Registro seleccionado:', id);
                } else {
                    // Remover ID de la selección
                    allSelectedIds = allSelectedIds.filter(function(selectedId) {
                        return selectedId !== id;
                    });
                    console.log('Registro deseleccionado:', id);

                    // Cuando se desmarca individualmente, salir del modo master
                    if (masterChecked) {
                        masterChecked = false;
                        isUpdatingCheckboxes = true;
                        $('thead input[type="checkbox"]').iCheck('uncheck');
                        isUpdatingCheckboxes = false;
                        console.log('Master checkbox desmarcado por deselección individual');
                    }
                }

                console.log('allSelectedIds después de checkbox individual:', allSelectedIds);

                // AQUÍ ESTÁ LA MAGIA: Verificar automáticamente si todos están seleccionados
                setTimeout(updateMasterCheckbox, 50);
            }
        });

        // Cuando se redibuje la tabla (cambio de página, etc.)
        fact_table.on('draw', function() {
            // closeWhatsappPanels();
            // closeEmailPanels();
            console.log('Tabla redibujada. allSelectedIds actual:', allSelectedIds);
            console.log('masterChecked actual:', masterChecked);

            // Reinicializar checkboxes
            $('.dataTables-example-facturas tbody input[type="checkbox"]').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            // Usar setTimeout para asegurar que iCheck esté completamente inicializado
            setTimeout(function() {
                isUpdatingCheckboxes = true;

                // Procesar cada checkbox en la página actual
                $('.dataTables-example-facturas tbody input[type="checkbox"]').each(function() {
                    var row = $(this).closest('tr');
                    var rowData = fact_table.row(row).data();

                    if (rowData && rowData[0]) {
                        var id = rowData[0].toString();

                        // Si este ID está en nuestra lista de seleccionados, marcarlo
                        if (allSelectedIds.includes(id)) {
                            $(this).iCheck('check');
                        } else {
                            $(this).iCheck('uncheck');
                        }
                    }
                });

                // Actualizar el estado del master checkbox
                if (masterChecked) {
                    $('thead input[type="checkbox"]').iCheck('check');
                } else {
                    $('thead input[type="checkbox"]').iCheck('uncheck');
                }

                isUpdatingCheckboxes = false;

                // Verificar si necesitamos actualizar el master checkbox automáticamente
                setTimeout(updateMasterCheckbox, 100);
            }, 150);
        });

        // Manejar click del botón de exportar
        $('#btn-exportar-filtrado').on('click', function(e) {
            e.preventDefault();

            if (allSelectedIds.length === 0) {
                swal({
                    title: "Sin selección",
                    text: "Por favor, selecciona al menos una factura para exportar.",
                    type: "warning",
                    confirmButtonColor: "#1a3bb3"
                });
                return;
            }

            swal({
                title: "Confirmar exportación",
                text: `¿Deseas exportar ${allSelectedIds.length} factura(s) seleccionada(s) a Excel?`,
                type: "info",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#1a3bb3"
            }, function(isConfirm) {
                if (!isConfirm) return;

                $('#btn-exportar-filtrado').prop('disabled', true);

                $.ajax({
                    url: "{{ route('cobranzas.facturas_exportar_sin_pago') }}",
                    method: "POST",
                    contentType: "application/json",
                    data: JSON.stringify({ factura_ids: allSelectedIds }),
                    headers: { 'X-CSRF-TOKEN': "{{ csrf_token() }}" },
                    xhrFields: { responseType: 'blob' },
                    complete: () => $('#btn-exportar-filtrado').prop('disabled', false),
                    success: function(blob) {
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = `Facturas_${new Date().toISOString().slice(0,10)}.xlsx`;
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                        window.URL.revokeObjectURL(url);
                    }
                });
            });
        // });
        });

        // Funciones helper para debugging (opcional)
        window.clearAllSelections = function() {
            allSelectedIds = [];
            masterChecked = false;
            isUpdatingCheckboxes = true;
            $('thead input[type="checkbox"]').iCheck('uncheck');
            $('.dataTables-example-facturas tbody input[type="checkbox"]').iCheck('uncheck');
            isUpdatingCheckboxes = false;
            console.log('Todas las selecciones limpiadas');
        };

        window.getSelectedIds = function() {
            console.log('IDs actualmente seleccionados:', allSelectedIds);
            return allSelectedIds;
        };
    });
    </script>
    
@endsection
