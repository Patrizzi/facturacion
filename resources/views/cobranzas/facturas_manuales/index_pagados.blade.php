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

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">

                    </div>
                    <div class="ibox-content">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist"
                                style="align-items: center;border-bottom: 0px !important;">
                                @include('cobranzas.facturas_manuales._shared.tabs')
                                {{-- <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    <button class="btn btn-primary" type="button" id="pago_lote_total" disabled><i
                                            class="fa fa-money"></i></button>
                                </ul> --}}
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
                                                        value="{{ date('01/m/Y') }} - {{ date('t/m/Y') }}"
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
                                            {{-- <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <select class="select_2_estado" name="" id="select_estado">
                                                        <option value="">Seleccionar Estado de Pago</option>
                                                        <option value="0">Sin Pagar</option>
                                                        <option value="1">Pagado Parcial</option>
                                                    </select>
                                                </div>
                                            </div> --}}
                                            {{-- <div class="col-lg-3 col-md-6 col-sm-12">
                                                <div class="input-group" style="align-items: center">
                                                    Contado: &nbsp;<input type="checkbox" class="form-control tipo_check"
                                                        name="" id="contad_check">&nbsp;&nbsp;
                                                    Credito: &nbsp;<input type="checkbox" class="form-control tipo_check"
                                                        name="" id="credit_check">
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="limpiar_select_estado()" style="visibility: hidden">
                                                            <i class="fa fa-eraser"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div> --}}
                                        </div>
                                    </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table
                                            class="table table-striped table-bordered table-hover dataTables-example-facturas_manual_pagados">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Estado</th>
                                                    <th>N° de Factura M</th>
                                                    <th>Cliente</th>
                                                    <th>Emisión</th>
                                                    <th>Forma de Pago</th>
                                                    <th>N° Cuotas</th>
                                                    <th>Total</th>
                                                    <th>Fecha Cancelado</th>
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

    <script>
        $('#tab-2-tab').addClass('active');

        // FUNCION DE DATATABLE FACTURA M
        var fact_m_table = $('.dataTables-example-facturas_manual_pagados').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('cobranzas.lista_facturas_manual_pagados_index') }}",
                method: "get",
                data: function(d) {
                    d.datarange = $('#data_range_filter').val();
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
                    // 'width': '5%',
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
                    // 'render': function(data, type, full, meta) {
                    //     var fechaStr = full[8];
                    //     if (!fechaStr) return "";

                    //     var partes = fechaStr.split("-");
                    //     var fecha = new Date(partes[2], partes[1] - 1, partes[0]);

                    //     var hoy = new Date();


                    //     if (fecha < hoy) {
                    //         return `<span style="color:red; font-weight:bold;">${fechaStr}</span>`;
                    //     } else {

                    //         return `<span>${fechaStr}</span>`;
                    //     }
                    // }
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
    </script>
@endsection
