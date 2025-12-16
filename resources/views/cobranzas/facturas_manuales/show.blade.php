@extends('layout')

@section('title', 'Registros de Pago')
@section('content')

    {{-- Resumen de Factura --}}
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox border-bottom">
                    <div class="ibox-title">
                        <h5>Resumen de Factura {{ $factura_m->codigo_fac }}</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-down"></i>
                            </a>
                            {{-- <a class="dropdown-toggle" data-toggle="dropdown-down" href="#">
                                <i class="fa fa-wrench"></i>
                            </a> --}}
                            {{-- <ul class="dropdown-menu dropdown-user">
                                <li><a href="#" class="dropdown-item">Config option 1</a>
                                </li>
                                <li><a href="#" class="dropdown-item">Config option 2</a>
                                </li>
                            </ul> --}}
                            @if ($factura_m->estado_pago == 2)
                                {{-- Estado Pagado --}}
                                <a class="close-link" href="{{ route('cobranzas.index_facturas_m') }}">
                                    <i class="fa fa-times"></i>
                                </a>
                            @else
                                <a class="close-link" href="{{ route('cobranzas.index_facturas_m_pagados') }}">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="ibox-content" style="display: none;">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-control">
                                    <div class="text-center">
                                        <h3>Datos del Cliente</h3>
                                    </div>
                                    <div class="text-left">
                                        <strong>Señor(es):</strong> {{ $factura_m->cliente->nombre }}<br>
                                        <strong>{{ $factura_m->cliente->documento_identificacion }}:</strong>
                                        {{ $factura_m->cliente->numero_documento }} <br>
                                        <strong>Dirección:</strong> {{ $factura_m->cliente->direccion }}<br>
                                        <div style="display: flex;column-gap: 15px">
                                            <div>
                                                <strong>Teléfono:</strong>
                                                {{ $factura_m->cliente->telefono }}
                                            </div>
                                            <div>
                                                <strong>Celular:</strong> {{ $factura_m->cliente->celular }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-control">
                                    <div class="text-center">
                                        <h3>Información de la Factura Manual</h3>
                                        <div class="text-left">
                                            <div style="display: flex;column-gap: 15px">
                                                <div>
                                                    <strong>Orden de Compra:</strong> {{ $factura_m->orden_compra }}
                                                </div>
                                                <div>
                                                    <strong>Guia Remisión:</strong> {{ $factura_m->guia_remision }}
                                                </div>
                                            </div>
                                            <div style="display: flex;column-gap: 15px">
                                                <div>
                                                    <strong>Condicion Pago:</strong> {{ $factura_m->forma_pago->nombre }}
                                                </div>
                                                <div>
                                                    <strong>Moneda:</strong> {{ $factura_m->moneda->nombre }}
                                                </div>
                                            </div>
                                            <strong>F. Emision:</strong> {{ $factura_m->fecha_emision }} <br>
                                            <strong>F. Vencimiento:</strong> {{ $factura_m->fecha_vencimiento }} <br>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Código de Producto</th>
                                        <th>Descripción</th>
                                        <th>Cantidad</th>
                                        <th>Valor unitario</th>
                                        <th>Valor Venta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($factura_m->registros_m as $item => $registros)
                                        <tr>
                                            <td>{{ $item + 1 }}</td>
                                            <td>{{ $registros->producto->codigo_producto }}</td>
                                            <td>{{ $registros->producto->nombre }}</td>
                                            <td>{{ $registros->cantidad }}</td>
                                            <td>{{ number_format($registros->precio, 2) }}</td>
                                            <td>{{ number_format(round($registros->cantidad * $registros->precio, 2), 2) }}
                                            </td>
                                            <td style="display: none">
                                                {{ $sub_total = $registros->factura_ids->op_gravada + $registros->factura_ids->op_inafecta + $registros->factura_ids->op_exonerada }}
                                                {{ $sub_total_gravado = $registros->factura_ids->op_gravada }}
                                                {{ $igv_p = (round($sub_total_gravado, 2) * $igv->igv_total) / 100 }}
                                                {{ $end = round($sub_total, 2) + round($igv_p, 2) }}
                                                {{ $end2 = number_format(round($sub_total, 2) + round($igv_p, 2), 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-lg-8">
                                <h3 align="left">
                                    <?php use Luecano\NumeroALetras\NumeroALetras;
                                    $v = new NumeroALetras();
                                    $letra = $v->toInvoice($end, 2);
                                    // $letra = $v->convertirEurosEnLetras($end);
                                    // $letra_final = ucfirst(strstr($letra, 'soles', true));
                                    // $end_final_point = strstr($end2, '.', false);
                                    // $end_final = str_replace('.', '', $end_final_point);
                                    ?>
                                    Son : {{ ucfirst(mb_strtolower($letra, 'UTF-8')) }} {{ $factura_m->moneda->nombre }}
                                    {{-- {{$end2}} --}}
                                </h3>
                            </div>
                            <div class="col-lg-4">
                                {{-- <div class="col-sm-4 form-control" > --}}
                                <div class="form-control">
                                    <div style="display: flex;column-gap: 15px;justify-content: space-between">
                                        <div>
                                            <strong>Op. Gravada:</strong>
                                        </div>
                                        <div>
                                            {{ $factura_m->moneda->simbolo }}{{ number_format($factura_m->op_gravada, 2) }}
                                        </div>
                                    </div>
                                    <div style="display: flex;column-gap: 15px;justify-content: space-between">
                                        <div>
                                            <strong>Op. Inafecta:</strong>
                                        </div>
                                        <div>
                                            {{ $factura_m->moneda->simbolo }}{{ number_format($factura_m->op_inafecta, 2) }}
                                        </div>
                                    </div>
                                    <div style="display: flex;column-gap: 15px;justify-content: space-between">
                                        <div>
                                            <strong>Op. Exonerada:</strong>
                                        </div>
                                        <div>
                                            {{ $factura_m->moneda->simbolo }}{{ number_format($factura_m->op_exonerada, 2) }}
                                        </div>
                                    </div>
                                    <div style="display: flex;column-gap: 15px;justify-content: space-between">
                                        <div>
                                            <strong>I.G.V:</strong>
                                        </div>
                                        <div>
                                            {{ $factura_m->moneda->simbolo }}{{ number_format($igv_p, 2) }}
                                        </div>
                                    </div>
                                    <div style="display: flex;column-gap: 15px;justify-content: space-between">
                                        <div>
                                            <strong>Importe Total:</strong>
                                        </div>
                                        <div>
                                            {{ $factura_m->moneda->simbolo }}{{ number_format($end, 2) }}
                                        </div>
                                    </div>
                                    {{-- <span style=""> Sub Total:</span>
                                    <span style=";">
                                        {{ $simbologia = $factura_m->moneda->simbolo }}
                                        {{ number_format($sub_total, 2) }}</span>
                                    <br>
                                    <span style=""> Op. Agravada: </span>
                                    <span style="">{{ $simbologia }}
                                        {{ number_format($factura_m->op_gravada, 2) }}</span><br>
                                    <span style=""> Op. Inafecta: </span>
                                    <span style="">{{ $simbologia }}
                                        {{ number_format($factura_m->op_inafecta, 2) }}</span><br>
                                    <span style=""> Op. Exonerada: </span>
                                    <span style="">{{ $simbologia }}
                                        {{ number_format($factura_m->op_exonerada, 2) }} </span><br>
                                    <span style=""> I.G.V.: </span>
                                    <span style="">{{ $factura_m->moneda->simbolo }}
                                        {{ number_format(round($igv_p, 2), 2) }}</span><br>
                                    <span style=""> Importe Total: </span>
                                    <span style="">{{ $factura_m->moneda->simbolo }}
                                        {{ number_format(round($end, 2), 2) }}</span> --}}
                                </div>

                            </div>
                        </div>
                        <br>
                        <div class="row">
                            {{-- @if ($detraccion == 'not')
                                <div class="col-sm-12 form-control" style="height:  100px">
                                    <strong>Observaciones:</strong><br>
                                    {{ $factura_m->observacion }}
                                </div>
                            @else
                                <div class="col-sm-6 ">
                                    <div class="form-control" style="height: 100% !important">
                                        <strong>Informacion de Detraccion:</strong><br>
                                        <strong>Tipo de Detraccion:</strong>
                                        {{ $detraccion->tipo_detraccion->descripcion }} -
                                        {{ $detraccion->porcentaje_detraccion }} %<br>
                                        <strong>Medio de Pago:</strong>
                                        {{ $detraccion->medio_pago->descripcion }} <br>
                                        <strong>Monto de Detraccion:</strong>
                                        S/. {{ number_format($detraccion->monto_detraccion, 2) }} <br>
                                    </div>
                                </div>
                                <div class="col-sm-6 ">
                                    <div class="form-control" style="height: 100% !important">
                                        <strong>Observaciones:</strong><br>
                                        {{ $facturacion->observacion }}
                                    </div>
                                </div>
                            @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox border-bottom">
                    <div class="ibox-title">
                        <h5>Resumen de Pagos {{ $factura_m->codigo_fac }} - </h5>
                        @switch($factura_m->estado_pago)
                            @case(0)
                                <span class="label label-danger">Sin pagar</span>
                            @break

                            @case(1)
                                <span class="label label-warning">Pagado Parcial</span>
                            @break

                            @case(2)
                                <span class="label label-success">Pagado Completo</span>
                            @break

                            @default
                        @endswitch
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-down"></i>
                            </a>
                            {{-- <a class="dropdown-toggle" data-toggle="dropdown-down" href="#">
                                <i class="fa fa-wrench"></i>
                            </a> --}}
                            {{-- <ul class="dropdown-menu dropdown-user">
                                <li><a href="#" class="dropdown-item">Config option 1</a>
                                </li>
                                <li><a href="#" class="dropdown-item">Config option 2</a>
                                </li>
                            </ul> --}}
                            {{-- <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a> --}}
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-3">
                                <h3>Lista de Cuotas</h3>
                                <div class="">

                                    @if ($factura_m->forma_pago_id == 1) <!-- Contado -->
                                        <h2>Contado</h2>
                                    @else
                                        @foreach ($factura_m->cuotas_credito as $i => $cuotas)
                                            <div style="margin-top: 10px;margin-bottom: 10px">
                                                <div style="cursor: pointer;" class="form-control box-detalle"
                                                    onclick="detalle_cuotas(this,{{ $i }},{{ $cuotas->id }})">
                                                    <h4
                                                        style="display: flex;flex-direction: row;justify-content: space-between;">
                                                        Cuota N° {{ $cuotas->numero_cuota }}
                                                        @switch($cuotas->estado)
                                                            @case(0)
                                                                <span class="label label-danger">Sin pagar</span>
                                                            @break

                                                            @case(1)
                                                                <span class="label label-warning">Pagado Parcial</span>
                                                            @break

                                                            @case(2)
                                                                <span class="label label-success">Pagado</span>
                                                            @break

                                                            @default
                                                        @endswitch
                                                    </h4>
                                                    {{ $factura_m->moneda->simbolo }} {{ $cuotas->monto }}
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-9">
                                <div id="detalle_cuotas_general">
                                    <h3 style="padding-right: 15px;padding-left: 15px;">Detalle de Cuota General</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="table-general-cuotas">
                                            <thead>
                                                <tr>
                                                    <th>N°</th>
                                                    <th>Estado</th>
                                                    <th>Total</th>
                                                    <th>Pagado ($ - S/)</th>
                                                    <th>Saldo Restante</th>
                                                    <th>Fecha de Pago</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>

                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                @foreach ($factura_m->cuotas_credito as $f => $cuota)
                                    <div class="detalle_cuota_detallado d-none" id="cuota_detalla_{{ $f }}">
                                        <h3 style="padding-right: 15px;padding-left: 15px;">Detalle de Cuota N°
                                            {{ $cuota->numero_cuota }}</h3>
                                        <div class="row">
                                            <div class="col-sm-4">

                                            </div>
                                            <div class="col-sm-4">

                                            </div>
                                            <div class="col-sm-4">

                                            </div>
                                        </div>
                                        {{-- <h3 style="padding-right: 15px;padding-left: 15px;">Detalle de Pagos</h3> --}}
                                        <div class="table-responsive">
                                            <table class="table table-bordered"
                                                id="table-detalle-cuotas-{{ $cuota->id }}">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Tipo de Pago</th> {{-- Si es Adelanto o pago --}}
                                                        <th>Monto Pagado</th>
                                                        <th>Método de Pago</th>
                                                        <th>Emisor</th>
                                                        <th>Fecha de Pago</th>
                                                        <th>Detalles</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .box-detalle.active {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .box-detalle:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        #table-general-cuotas_length,
        #table-general-cuotas_filter {
            display: none;
        }

        .table {
            width: 100%;
        }
    </style>
    <!-- scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

    <script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>

    <link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
    <!-- Switchery -->
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    {{-- @include('cobranzas.pago_contado')
    @include('cobranzas.adelanto_view')
    @include('cobranzas.adelanto') --}}

    <script>
        var table_cuota_general = $('#table-general-cuotas').DataTable({
            "autoWidth": false,
            "serverSide": true,
            "ajax": {
                url: "{{ route('api.get_cuotas_credito_table') }}",
                method: "get",
                data: function(d) {
                    d.tipo_documento = "factura_manual";
                    d.id_documento = "{{ $factura_m->id }}"
                }
            },
            "columnDefs": [{
                    'targets': [0],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        return full[0];
                    }
                }, {
                    'targets': [1],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        const estados = {
                            0: `<span class="label label-danger">Sin cancelar</span>`,
                            1: `<span class="label label-warning">Pagado Parcial</span>`,
                            2: `<span class="label label-success">Completo</span>`
                        };

                        return estados[data] ?? `<span class="label label-default">Desconocido</span>`;
                    }
                }, {
                    'targets': [2],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        return full[2];
                    }
                },
                {
                    'targets': [3],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        return full[4] + " - " + full[5];
                    }
                },
                {
                    'targets': [4],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        return full[6] + " - " + full[7];
                    }
                },
                {
                    'targets': [5],
                    'orderable': false,
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
                    'targets': [6],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var button =
                            `<button class="btn btn-sm btn-primary"><i class="fa fa-eye" ></i></button>`;
                        return button;
                    }
                }
            ]
        })

        function detalle_cuotas(item, numero, id_cuota) {
            const $el = $(item);
            const $detalles = $('.detalle_cuota_detallado');
            const $general = $('#detalle_cuotas_general');

            const table_cuota = '#table-detalle-cuotas-' + id_cuota;

            if ($el.hasClass('active')) {
                $('.box-detalle').removeClass('active');
                $detalles.addClass('d-none');
                $general.removeClass('d-none');
                return;
            }

            $('.box-detalle').removeClass('active');
            $el.addClass('active');

            $general.addClass('d-none');
            $detalles.addClass('d-none');
            $('#cuota_detalla_' + numero).removeClass('d-none');

            if ($.fn.DataTable.isDataTable(table_cuota)) {
                $(table_cuota).DataTable().ajax.reload();
                return;
            }

            $(table_cuota).DataTable({
                autoWidth: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('api.get_detalle_pago_cuota_table') }}",
                    method: "get",
                    data: function(d) {
                        d.id_cuota = id_cuota;
                        d.id_documento = "{{ $factura_m->id }}";
                    }
                },
                language: {
                    emptyTable: 'No hay pagos disponibles para esta cuota'
                },
                columnDefs: [{
                        targets: [0],
                        orderable: false,
                        render: function(data, type, full) {
                            return full[0];
                        }
                    },
                    {
                        targets: [1],
                        orderable: false,
                        render: function(data, type, full) {
                            const estados = {
                                "Pagado": `<span class="label label-default">${full[1]}</span>`,
                                "Adelantado": `<span class="label label-default">${full[1]}</span>`
                            };

                            return estados[data] ?? `<span class="label label-default">Desconocido</span>`;
                        }
                    },
                    {
                        targets: [2],
                        orderable: false,
                        render: function(data, type, full) {
                            return full[2];
                        }
                    },
                    {
                        targets: [3],
                        orderable: false,
                        render: function(data, type, full) {
                            return full[3];
                        }
                    },
                    {
                        targets: [4],
                        orderable: false,
                        render: function(data, type, full) {
                            return full[4];
                        }
                    },
                    {
                        targets: [5],
                        orderable: false,
                        render: function(data, type, full) {
                            return full[5];
                        }
                    },
                    {
                        targets: [6],
                        orderable: false,
                        render: function() {
                            return `<button class="btn btn-sm btn-primary">
                                <i class="fa fa-eye"></i>
                            </button>`;
                        }
                    }
                ]
            });
        }
    </script>

    <script>
        var elem_2 = document.querySelector('.js-switch-pago');
        var switchery_2 = new Switchery(elem_2, {
            color: '#ED5565'
        });

        $(document).ready(function() {
            table = $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
            $('.dataTables-examaple').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });
            $('.footable').footable();

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

            $('#id_factura').attr('name', 'id_factura_m[]');
            $('#cod_factura').attr('name', 'numero_factura_m[]');
        });

        function changue_bancos_pagos() {
            // $("#select_banco_adl").attr('disabled', false);
            console.log('a');
            var id_banc = $("#select_banco_pagos").val();
            $('#select_cuenta_pago').select2({
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
    </script>
    <script>
        function detalle_cuota(item) {
            $('#detalle_pago').modal('show');
            $('#id_cuota').html(item);

            var data = item;
            $.ajax({
                type: "post",
                url: "{{ route('pagos.show_cuota') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'data': item,
                },
                success: function(msg) {
                    var numero = $(`#numero_` + item).val();
                    var monto = $(`#monto_` + item).val();
                    // var vencimiento = $(`#fecha_ven_` + item).val();
                    var estado = $(`#estado_` + item).val();
                    $('#n_cuota_header').html(`Cuota N° ` + numero);
                    $('#monto_cuota_header').html(monto);
                    $('#estado_cuota_header').html(estado);
                    $('#body_pago_detail').append(msg['html_end']);
                }
            });
        }
        $('#detalle_pago').on('hidden.bs.modal', function(e) {
            $('#body_pago_detail').empty();
        });

        function check_lote(num) {
            var count_check = document.querySelectorAll('.check_only');
            let checkboxesDesactivados = 0;

            // Recorrer los checkboxes y contar los desactivados
            count_check.forEach(function(checkbox) {
                if (checkbox.checked) {
                    checkboxesDesactivados++;
                }
            });
            // console.log(checkboxesDesactivados);
            if (checkboxesDesactivados > 0) {
                $('#pago_lote').attr('disabled', false);
            } else {
                $('#pago_lote').attr('disabled', true);
            }
        }


        $('#pago_lote').on('click', function() {
            $('.lote_pago_sect').remove();
            $('.input_check').remove();
            $('.cuota_prec_fact').remove();
            var total_c = 0;
            var count_check = document.querySelectorAll('.check_only');
            count_check.forEach(function(checkbox) {
                if (checkbox.checked) {
                    var id_cuot = checkbox.id;
                    let id_one = id_cuot.match(/\d+/g);
                    modal_pagos_lote(id_one[0]);
                    total_c += parseFloat($(`#total_` + id_one[0]).val());
                    // $(`#cuota_precio`+id_one[0]+``).val(id_one[0] + '_' + total_c);
                }
            });
            $('#efectivo_pago').attr('min', total_c);
            $('#total_cuota').val(total_c);
        });
    </script>
@endsection
