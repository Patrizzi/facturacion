@extends('layout')

@section('title', 'Registros de Pago')
@section('content')
    @include('cobranzas.facturas_manuales._shared.modal_factura_m')
    {{-- Resumen de Factura --}}

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
                                <span class="label label-primary">Pagado Completo</span>
                            @break

                            @default
                        @endswitch
                        <div class="ibox-tools">
                            <button class="btn btn-primary btn-sm" type="button" id="pago_lote" disabled><i
                                    class="fa fa-money"></i></button>
                            <a class="collapse-link">
                                <i class="fa fa-chevron-down"></i>
                            </a>
                        </div>

                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="">
                                    @if ($factura_m->forma_pago_id == 1) <!-- Contado -->
                                        <h2>Contado</h2>
                                        <div style="cursor: pointer;" class="form-control box-detalle">
                                            <h4 style="display: flex;flex-direction: row;justify-content: space-between;">
                                                Pago Único
                                                @switch($factura_m->estado_pago)
                                                    @case(0)
                                                        <span class="label label-danger">Sin pagar</span>
                                                    @break

                                                    @case(1)
                                                        <span class="label label-warning">Pagado Parcial</span>
                                                    @break

                                                    @case(2)
                                                        <span class="label label-primary">Completo</span>
                                                    @break
                                                @endswitch
                                            </h4>
                                            <div style="display: flex;justify-content: space-between">
                                                <div class="text-left" onclick="event.stopPropagation()">
                                                    @if ($factura_m->estado_pago != 2)
                                                        <div class="i-checks">
                                                            <input type="checkbox" class="check_cuota" name=""
                                                                id="" value="0"
                                                                onchange="check_lote({{ $factura_m->id }},0)">
                                                        </div>
                                                    @else
                                                        <div class="i-checks">
                                                            <input type="checkbox" name="" id="" disabled
                                                                checked>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="text-right">
                                                    {{ $factura_m->total_precio }}
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <h3>Lista de Cuotas</h3>
                                        <div>
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
                                                                    <span class="label label-primary">Completo</span>
                                                                @break
                                                            @endswitch
                                                        </h4>
                                                        <div style="display: flex;justify-content: space-between">
                                                            <div class="text-left" onclick="event.stopPropagation()">
                                                                @if ($cuotas->estado != 2)
                                                                    <div class="i-checks">
                                                                        <input type="checkbox" class="check_cuota"
                                                                            name="" id=""
                                                                            value="{{ $cuotas->id }}"
                                                                            onchange="check_lote({{ $factura_m->id }},{{ $cuotas->id }})">
                                                                    </div>
                                                                @else
                                                                    <div class="i-checks">
                                                                        <input type="checkbox" name="" id=""
                                                                            disabled checked>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            <div class="text-right">
                                                                {{ $factura_m->moneda->simbolo }}
                                                                {{ number_format($cuotas->monto, 2) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-9">
                                @if ($factura_m->forma_pago_id == 1)
                                    <div class="detalle_contado_general">
                                        <div class="row" style="padding: 0px 15px">
                                            <div class="col-sm-6">
                                                <h3 style="padding-right: 15px;">Detalle General
                                                </h3>
                                            </div>
                                            <div class="col-sm-6 text-right">
                                                <div style="display: flex;column-gap: 10px;justify-content: flex-end;">
                                                    <a href="{{ route('pagos.print_facturas_m_cuotas', $factura_m->id) }}"
                                                        target="_blank" class="btn btn-primary btn-sm"><i
                                                            class="fa fa-print fa-lg"></i></a>
                                                    <button class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                                        data-target="#factura_show">
                                                        <i class="fa fa-file"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row" style="padding: 8px 15px">
                                            <div class="col-sm-4">
                                                {{-- <div class="form-group">
                                                        <label for=""><strong>Número de Cuota</strong></label>
                                                        <p class="form-control" id="numero_cuota_{{ $cuota->id }}"
                                                            style="margin-bottom: 0px">{{ $cuota->numero_cuota }}</p>
                                                    </div> --}}
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for=""><strong>Monto Total</strong></label>
                                                    <p class="form-control" id="total_contado_{{ $factura_m->id }}"
                                                        style="margin-bottom: 0px">{{ $factura_m->total_precio }}</p>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for=""><strong>Fecha de Vencimiento</strong></label>
                                                    <p class="form-control" id="contado_vencimiento_{{ $factura_m->id }}"
                                                        style="margin-bottom: 0px">{{ $factura_m->fecha_vencimiento }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered"
                                                id="table-detalle-contado-{{ $factura_m->id }}">
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
                                @else
                                    <div id="detalle_cuotas_general">
                                        <div class="row" style="padding: 0px 15px">
                                            <div class="col-sm-6">
                                                <h3 style="padding-right: 15px;">Detalle de Cuota General
                                                </h3>
                                            </div>
                                            <div class="col-sm-6 text-right">
                                                <div style="display: flex;column-gap: 10px;justify-content: flex-end;">
                                                    <a href="{{ route('pagos.print_facturas_m_cuotas', $factura_m->id) }}"
                                                        target="_blank" class="btn btn-primary btn-sm"><i
                                                            class="fa fa-print fa-lg"></i></a>
                                                    <button class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                                        data-target="#factura_show">
                                                        <i class="fa fa-file"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="table-general-cuotas">
                                                <thead>
                                                    <tr>
                                                        <th>N°</th>
                                                        <th>Estado</th>
                                                        <th>Total</th>
                                                        <th>Pagado ({{ $factura_m->moneda->simbolo }} -
                                                            {{ $moneda_sec->simbolo }})</th>
                                                        <th>Saldo Restante</th>
                                                        <th>Fecha de Vencimiento</th>
                                                        {{-- <th>Acciones</th> --}}
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
                                        <div class="detalle_cuota_detallado d-none"
                                            id="cuota_detalla_{{ $f }}">
                                            <h3 style="padding-right: 15px;padding-left: 15px;">Detalle de Cuota N°
                                                {{ $cuota->numero_cuota }}</h3>
                                            <div class="row" style="padding: 8px 15px">
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for=""><strong>Número de Cuota</strong></label>
                                                        <p class="form-control" id="numero_cuota_{{ $cuota->id }}"
                                                            style="margin-bottom: 0px">{{ $cuota->numero_cuota }}</p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for=""><strong>Monto Total</strong></label>
                                                        <p class="form-control" id="total_cuota_{{ $cuota->id }}"
                                                            style="margin-bottom: 0px">{{ $cuota->monto_total_format }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group">
                                                        <label for=""><strong>Fecha de Vencimiento</strong></label>
                                                        <p class="form-control" id="vencimiento_{{ $cuota->id }}"
                                                            style="margin-bottom: 0px">{{ $cuota->fecha_pago_format }}</p>
                                                    </div>
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
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .pago_m {
            display: none;
        }

        .pago_m.m_pago_1 {
            display: block;
        }

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

        #factura_show>* {
            font-size: 90% !important;
        }

        .modal.dimmed {
            filter: brightness(0.5);
            pointer-events: none;
        }

        .form-control {
            min-height: 29px !important;
            /* height: 15px; */
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

    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
    <!-- Switchery -->
    <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <script src="{{ asset('js/plugins/pdfjs/pdf.js') }}"></script>

    @include('cobranzas._shared.facturas.modal_pago_all')
    {{-- @include('cobranzas.adelanto_view')
    @include('cobranzas.adelanto') --}}
    @include('cobranzas._shared.modal_detalle');
    @if ($factura_m->forma_pago_id == 1)
        {{-- Contado --}}
        <script>
            $(document).ready(function() {
                console.log("cargando contado");
                contado_table("{{ $factura_m->id }}", "{{ $factura_m->fecha_vencimiento }}");
            });
        </script>
    @endif
    <script>
        // $(document).ready(function() {
        //     $('.i-checks').iCheck({
        //         checkboxClass: 'icheckbox_square-green',
        //         radioClass: 'iradio_square-green',
        //     });
        // });
        $(document).ready(function() {
            $('#modal_pago_tipo_comprobante').val('factura_manual');
        });
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
                            2: `<span class="label label-success">Pagado Completo</span>`
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
                        var principal = `<span>` + full[3] + `</span>`;
                        var sec = `<small>` + full[4] + `</small>`;
                        return principal + " - " + sec;
                    }
                },
                {
                    'targets': [4],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        return full[5];
                    }
                },
                {
                    'targets': [5],
                    'orderable': false,
                    'render': function(data, type, full, meta) {
                        var fechaStr = full[6];
                        if (!fechaStr) return "";
                        var partes = fechaStr.split("-");
                        var fecha = new Date(partes[2], partes[1] - 1, partes[0]);

                        var hoy = new Date();

                        if (full[1] != 2) {
                            if (fecha < hoy) {
                                return `<span style="color:red; font-weight:bold;">${fechaStr}</span>`;
                            } else {
                                return `<span>${fechaStr}</span>`;
                            }
                        } else {
                            return `<span style="color:green; font-weight:bold;">${fechaStr}</span>`;
                        }
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
                // processing: true,
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
                                0: `<span class="label label-success">Pago</span>`,
                                1: `<span class="label label-warning">Adelantado</span>`
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
                            var fecha_pago = full[5]; // 13-12-2025
                            var cuota_ven = $('#vencimiento_' + id_cuota).html(); // 13-12-2025

                            // console.log(cuota_ven);
                            const toDate = (fecha) => {
                                const [d, m, y] = fecha.split('-');
                                return new Date(`${y}-${m}-${d}T00:00:00`);
                            };

                            if (full[1] != 2) {
                                if (toDate(fecha_pago) > toDate(cuota_ven)) {
                                    return `<span style="color:red; font-weight:bold;">${fecha_pago}</span>`;
                                } else {
                                    return `<span style="color:green; font-weight:bold;">${fecha_pago}</span>`;
                                }
                            } else {
                                return `<span>${fecha_pago}</span>`;
                            }
                            // return full[5];
                        }
                    },
                    {
                        targets: [6],
                        orderable: false,
                        render: function(data, type, full) {
                            return `<button class="btn btn-sm btn-primary" onclick="detalle_cuota_pago(` +
                                full[6] + `)">
                                <i class="fa fa-eye"></i>
                            </button>`;
                        }
                    }
                ]
            });
        }

        function detalle_cuota_pago(id_cuota) {
            $.ajax({
                url: "{{ route('cobranzas.show_detalle_pago') }}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "id_detalle": id_cuota
                },
                success: function(msg) {
                    console.log(msg);
                    clear_campos_detalle();
                    $('#detalle_pago_cheque, #detalle_pago_tarjeta, #detalle_pago_efectivo, #detale_pago_transferencia')
                        .hide();
                    // 
                    $('.button-comprobante').text('Ver Comprobante');
                    $('.button-comprobante').prop('disabled', false);
                    $('.button-comprobante').attr('data-target', '#modal_comprobante_view');
                    $('.button-comprobante').attr('data-toggle', 'modal');

                    $('#modal_detalle_pago').modal('show');
                    if ({{ $factura_m->forma_pago_id }} == 2) {
                        var total = msg.detalle.comprobante_pago_registros.cuota_credito.monto_total_format;
                        var estado = msg.detalle.comprobante_pago_registros.cuota_credito.estado_format;
                    } else {
                        var total = msg.detalle.monto_pagado_format;
                        var estado = msg.detalle.comprobante_pago.facturacion_m.estado_pago_text;
                    }
                    $('#monto_total_cuota').html(total);
                    $('#estado_cuota').html(estado);
                    switch (msg.detalle.tipo_pago) {
                        case 'cheque':
                            $('#detalle_tipo_pago').html("Cheque");

                            $('#detalle_pago_cheque').show();

                            $('#detalle_numero_cheque').html(msg.detalle.numero_input);
                            $('#detalle_fecha_cheque').html(msg.detalle.fechas_input_format);
                            $('#detalle_banco_emisor_cheque').html(msg.detalle.bancos_input);
                            $('#detalle_beneficiario_cheque').html(msg.detalle.persona_input);
                            $('#detalle_moneda_monto_cheque').html(msg.detalle.monto_pagado_format);
                            $('#detalle_tipo_cambio_cheque').html(msg.detalle.tipo_cambio);
                            if (msg.detalle.option_input == 0) {
                                $('#detalle_diferido_cheque').html("NO");
                            } else {
                                $('#detalle_diferido_cheque').html("SI");
                            }
                            $('#detalle_emision_cheque').html(msg.detalle.fecha_emision_format);
                            $('#detalle_banco_empresa_cheque').html(msg.detalle.banco_empresa.nombre_banco);
                            $('#detalle_cuenta_cheque').html(msg.detalle.numero_cuenta.tipo_cuenta + ' ' + msg
                                .detalle
                                .numero_cuenta
                                .nombre_cuenta);
                            // Falta el comprobante 
                            $('#detalle_observaciones_cheque').html(msg.detalle.notas_adicionales);
                            break;
                        case 'tarjeta':
                            $('#detalle_tipo_pago').html("Tarjeta");

                            $('#detalle_pago_tarjeta').show();
                            $('#detalle_titular_tarjeta').html(msg.detalle.titular_tarjeta);
                            $('#detalle_banco_tarjeta').html(msg.detalle.bancos_input);
                            $('#detalle_moneda_monto_tarjeta').html(msg.detalle.monto_pagado_format);
                            $('#detalle_tipo_cambio_tarjeta').html(msg.detalle.tipo_cambio);
                            $('#detalle_fecha_tarjeta').html(msg.detalle.fechas_input_format);
                            // Falta el comprobante
                            $('#detalle_observaciones_tarjeta').html(msg.detalle.notas_adicionales);
                            break;
                        case 'efectivo':
                            $('#detalle_tipo_pago').html("Efectivo");

                            $('#detalle_pago_efectivo').show();
                            $('#detalle_persona_efectivo').html(msg.detalle.persona_input);
                            $('#detalle_fecha_efectivo').html(msg.detalle.fechas_input_format);
                            $('#detalle_moneda_monto_efectivo').html(msg.detalle.monto_pagado_format);
                            $('#detalle_tipo_cambio_efectivo').html(msg.detalle.tipo_cambio);
                            // Falta el comprobante
                            $('#detalle_observaciones_efectivo').html(msg.detalle.notas_adicionales);
                            break;
                        case 'transferencia':
                            $('#detalle_tipo_pago').html("Transferencia");

                            $('#detalle_pago_transferencia').show();
                            $('#detalle_titular_transferencia').html(msg.detalle.persona_input);
                            $('#detalle_fecha_transferencia').html(msg.detalle.fechas_input_format);
                            $('#detalle_moneda_monto_transferencia').html(msg.detalle.monto_pagado_format);
                            $('#detalle_tipo_cambio_transferencia').html(msg.detalle.tipo_cambio);
                            $('#detalle_numero_operacion_transferencia').html(msg.detalle.numero_input);
                            // Falta el comprobante
                            $('#detalle_observaciones_transferencia').html(msg.detalle.persona_input);
                            break;
                        default:
                            break;
                    }

                    // Para otros detalles
                    if (msg.otros != null) {
                        $('#otros-nulos').hide();
                        $('.detalle-otros-pago').show();
                        $('#otros-comprobantes-registros').empty();
                        var suma_tot = 0;
                        $('#otros-comprobantes-registros').empty();
                        msg.otros.forEach(element => {
                            if (element.comprobante_pago_registros.cuota_credito != null) {
                                suma_tot += element.comprobante_pago_registros.cuota_credito.monto;
                                var total = element.comprobante_pago_registros.cuota_credito.monto.toFixed(2);
                                var codigo_fac = element.comprobante_pago_registros.cuota_credito
                                    .factura_m_ids.codigo_fac;
                                var n_cuota = element.comprobante_pago_registros.cuota_credito
                                    .numero_cuota;
                                var moneda = element.comprobante_pago_registros.cuota_credito
                                    .moneda_comprobante;
                            } else {
                                suma_tot += element.comprobante_pago.facturacion_m.total_precio_sin_forma;
                                var total = element.comprobante_pago.facturacion_m.total_precio_sin_forma.toFixed(2);
                                var codigo_fac = element.comprobante_pago.facturacion_m.codigo_fac;
                                var n_cuota = "1 (Contado)";
                                var moneda = element.comprobante_pago.facturacion_m.moneda.simbolo;
                            }
                            console.log(msg.otros);
                            var content = `
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for=""><strong>Comprobante</strong></label>
                                            <p class="form-control" id="comprobante_otro">` + codigo_fac + `</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for=""><strong>Cuota</strong></label>
                                            <p class="form-control" id="cuota_otro">Cuota N ` + n_cuota + `</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for=""><strong>Monto Total</strong></label>
                                        <div class="form-group">
                                            <div class="input-group  input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="moneda_simbolo_otro"
                                                        style="justify-content: center">` + moneda + `</span>
                                                </div>
                                                <label class="form-control form-control" id="total_otro"
                                                    aria-describedby="inputGroup-sizing-sm">` + total + `</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            $('#otros-comprobantes-registros').append(content);

                        });

                        $('#otros_tota_totas').html(suma_tot.toFixed(2));
                    }

                    // Comprobante de pago 
                    const BASE_PAGOS_URL = "{{ asset('archivos/pagos_sistema') }}";
                    if (msg.detalle.file_input != null) {
                        var url_comprobante = msg.detalle.file_input;
                        var extension = url_comprobante.split('.').pop().toLowerCase();
                        const fullUrl = `${BASE_PAGOS_URL}/${url_comprobante}`;
                        switch (extension) {
                            case 'pdf':
                                view_comprobante_pdf(fullUrl);
                                break;
                            case 'jpg':
                            case 'jpeg':
                            case 'png':
                            case 'gif':
                                view_comprobante_img(fullUrl);
                                break;
                            default:
                                view_comprobante_otros(fullUrl);
                                break;
                        }
                    } else {
                        $('.button-comprobante').text('Sin comprobante subido');
                        $('.button-comprobante').prop('disabled', true);
                    }
                }
            });
        }

        function clear_campos_detalle() {
            // Cheque
            $('#numero_cheque').val("");
            $('#fecha_cheque').val("");
            $('#banco_emisor_cheque').val("");
            $('#beneficiario_cheque').val("");
            $('#moneda_monto_cheque').val("");
            $('#tipo_cambio_cheque').val("");
            $('#diferido_cheque').val("");
            $('#emision_cheque').val("");
            $('#banco_empresa_cheque').val("");
            $('#emision_cheque').val("");
            // Falta el comprobante 
            $('#observaciones_cheque').val("");

            //Tarjeta
            $('#titular_tarjeta').val("");
            $('#banco_tarjeta').val("");
            $('#moneda_monto_tarjeta').val("");
            $('#tipo_cambio_tarjeta').val("");
            $('#fecha_tarjeta').val("");
            // Falta el comprobante 
            $('#observaciones_tarjeta').val("");

            // Efectivo
            $('#persona_efectivo').val("");
            $('#fecha_efectivo').val("");
            $('#moneda_monto_efectivo').val("");
            $('#tipo_cambio_efectivo').val("");
            $('#observaciones_efectivo').val("");

            //Transferencia
            $('#titular_transferencia').val("");
            $('#fecha_transferencia').val("");
            $('#moneda_monto_transferencia').val("");
            $('#tipo_cambio_transferencia').val("");
            $('#numero_operacion_transferencia').val("");
            // Falta el comprobante
            $('#observaciones_transferencia').val("");
        }

        function contado_table(id_factura_m, fecha_vencimiento) {
            const table_cuota = '#table-detalle-contado-' + id_factura_m;
            $(table_cuota).DataTable({
                "autoWidth": false,
                "serverSide": true,
                "ajax": {
                    url: "{{ route('api.get_detalle_pago_contado_table') }}",
                    method: "get",
                    data: function(d) {
                        d.tipo_documento = "factura_manual";
                        d.id_factura_manual = id_factura_m;
                    }
                },
                "columnDefs": [{
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
                                0: `<span class="label label-success">Pago</span>`,
                                1: `<span class="label label-warning">Adelantado</span>`
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
                            var fecha_pago = full[5]; // 13-12-2025
                            var cuota_ven = $('#contado_vencimiento_' + id_factura_m).html(); // 13-12-2025

                            // console.log(cuota_ven);
                            const toDate = (fecha) => {
                                const [d, m, y] = fecha.split('-');
                                return new Date(`${y}-${m}-${d}T00:00:00`);
                            };

                            if (full[1] != 2) {
                                if (toDate(fecha_pago) > toDate(cuota_ven)) {
                                    return `<span style="color:red; font-weight:bold;">${fecha_pago}</span>`;
                                } else {
                                    return `<span style="color:green; font-weight:bold;">${fecha_pago}</span>`;
                                }
                            } else {
                                return `<span>${fecha_pago}</span>`;
                            }
                            // return full[5];
                        }
                    },
                    {
                        targets: [6],
                        orderable: false,
                        render: function(data, type, full) {
                            return `<button class="btn btn-sm btn-primary" onclick="detalle_cuota_pago(` +
                                full[6] + `)">
                                <i class="fa fa-eye"></i>
                            </button>`;
                        }
                    }
                ]
            })
        }

        $('#modal_comprobante_view').on('show.bs.modal', function() {
            $('#modal_detalle_pago').addClass('dimmed');
        });

        $('#modal_comprobante_view').on('hidden.bs.modal', function() {
            $('#modal_detalle_pago').removeClass('dimmed');
        });

        function view_comprobante_pdf(url_comprobante) {
            $('#comprobante_pago_view_pdf').show();
            $('#comprobante_pago_view_imagen').hide();
            const iframe = document.getElementById('iframePdf');
            iframe.src = '';
            iframe.src = url_comprobante;
        }

        function view_comprobante_img(url_comprobante) {
            $('#comprobante_pago_view_pdf').hide();
            $('#comprobante_pago_view_imagen').show();
            $('#comprobante_image_viewer').attr('src', url_comprobante);
        }

        function view_comprobante_otros(url_comprobante) {
            $('.button-comprobante').text('Descargar Comprobante');
            $('.button-comprobante').removeAttr('data-target');
            $('.button-comprobante').removeAttr('data-toggle');
            $('.button-comprobante').attr('href', url_comprobante);
            $('.button-comprobante').attr('target', '_blank');
            $('.button-comprobante').attr('download', '');

        }
    </script>

    <script>
        function check_lote(id_factura, $id_cuota) {
            // 
            var cuotas_seleccionadas = document.querySelectorAll('.check_cuota:checked');
            var total_cuotas = cuotas_seleccionadas.length;
            if (total_cuotas > 0) {
                $('#pago_lote').attr('disabled', false);
            } else {
                $('#pago_lote').attr('disabled', true);
            }
        }

        $('#pago_lote').on('click', function() {
            $('#ids_divs_factura').empty();
            var cuotas_seleccionadas = document.querySelectorAll('.check_cuota:checked');
            var ids_cuotas = [];
            cuotas_seleccionadas.forEach(function(cuota) {
                ids_cuotas.push(cuota.value);
            });
            console.log(ids_cuotas);
            $('#ids_cuotas_lote').val(ids_cuotas.join(','));
            $('#todo_pago').modal('show');
            var id_factura = "{{ $factura_m->id }}";
            var only_id_fact = `
                <input type="hidden" name="id_factura_m[]" class="" id="id_factura_` + id_factura + `" value="` +
                id_factura + `">
            `;
            $('#ids_divs_factura').append(only_id_fact);
            // Funcion para mostrar las cuotas
            $('#div_facturas').empty();
            
            $('#tot_simbolo').empty();
            $.ajax({
                type: "post",
                url: "{{ route('pagos.lista_ajax_fact_m') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'ids_facturas[]': "{{ $factura_m->id }}",
                },
                success: function(msg) {
                    // console.log(msg[0])
                    var data_2 =
                        `<hr><div class="input-group-prepend"><label class="form-control disabled" id="simbolor_label" style="margin: 0px">` +
                        msg[0].factura_simbolo +
                        `</label></div><label class='form-control disabled' id='tota_totas'></label>`;
                    $('#tot_simbolo').append(data_2);
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
                            ` select2-selection--multiple" name="cuotas_precio_` + row
                            .factura_cod +
                            `[]" multiple="multiple" onchangue="select_2_(` + index + `)" required>
                                                        ` + row.cuotas_array.map(function(bar) {
                                if (bar.estado == 0) {
                                    var selected = ids_cuotas.includes(String(bar
                                        .id_cuota)) ?
                                        'selected' :
                                        '';
                                    return `
                                                <option value="${bar.id_cuota}_${bar.monto}" ${selected}>
                                                    N°-${bar.cuota_n}: ${bar.monto}
                                                </option>
                                            `;
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

                        const $select = $(`.select_2_multipl_${index}`);
                        $select.select2({
                            placeholder: "Seleccionar Cuotas"
                        });

                        $select.on('change', function() {
                            let totalFila = 0;
                            const selected = $(this).select2('data');
                            selected.forEach(item => {
                                let monto = parseFloat(item.text.replace(
                                    /N°-\d+: /g, ''));
                                totalFila += monto;
                            });
                            totalFila = Math.round(totalFila * 100) / 100;
                            $(`#total_cuotas_${index}`).val(totalFila);
                            $(`#lbl_tot_${index}`).html(totalFila);
                            recalcularGlobal();
                        });
                        $select.trigger('change');
                    });
                },
                error: function(eject) {
                    if (eject.status === 400) {
                        console.log(eject.responseJSON.error);
                    }
                },
                cache: true
            });
        });

        function recalcularGlobal() {
            let totalGeneral = 0;
            let simboloBase = $('#simbolor_label').html();

            $('[id^="total_cuotas_"]').each(function() {

                let montoFila = parseFloat($(this).val()) || 0;

                totalGeneral += montoFila;
            });

            totalGeneral = Math.round(totalGeneral * 100) / 100;

            $('#tota_totas').html(totalGeneral);

            $('#cheque_monto, #tarjeta_monto, #efectivo_monto, #transferencia_monto')
                .val(totalGeneral);

            $('#cheque_monto').attr('max', totalGeneral);
            $('#efectivo_pago').attr('min', totalGeneral);
        }

        $('#collapse-head-three').on('click', function() {
            $('#collapseThree').collapse('show');
            $('#collapseFour').collapse('hide');
        });
        $('#collapse-head-four').on('click', function() {
            $('#collapseFour').collapse('show');
            $('#collapseThree').collapse('hide');
        });
        //     var elem_2 = document.querySelector('.js-switch-pago');
        //     var switchery_2 = new Switchery(elem_2, {
        //         color: '#ED5565'
        //     });

        //     $(document).ready(function() {
        //         table = $('.dataTables-example').DataTable({
        //             pageLength: 25,
        //             responsive: true,
        //             dom: '<"html5buttons"B>lTfgitp',
        //             buttons: []
        //         });
        //         $('.dataTables-examaple').DataTable({
        //             pageLength: 25,
        //             responsive: true,
        //             dom: '<"html5buttons"B>lTfgitp',
        //             buttons: []
        //         });
        //         $('.footable').footable();

        //         $('#select_banco_pagos').select2({
        //             placeholder: "Seleccionar",
        //         });
        //         $('#select_cuenta_pago').select2({
        //             placeholder: "Seleccionar",
        //         });

        //         $('#select_banco_transf_pag').select2({
        //             placeholder: "Seleccionar",
        //         });
        //         $('#select_cuenta_adl_pag').select2({
        //             placeholder: "Seleccionar",
        //         });

        //         $('#id_factura').attr('name', 'id_factura_m[]');
        //         $('#cod_factura').attr('name', 'numero_factura_m[]');
        //     });

        //     function changue_bancos_pagos() {
        //         // $("#select_banco_adl").attr('disabled', false);
        //         console.log('a');
        //         var id_banc = $("#select_banco_pagos").val();
        //         $('#select_cuenta_pago').select2({
        //             placeholder: "Seleccionar",
        //             ajax: {
        //                 minimumInputLength: 1,
        //                 url: "{{ route('bancos.registros_search') }}",
        //                 dataType: 'json',
        //                 type: "POST",
        //                 data: function(params) {
        //                     return {
        //                         '_token': $('input[name=_token]').val(),
        //                         'id_bancos': id_banc
        //                     };
        //                 },
        //                 processResults: function(data) {
        //                     return {
        //                         results: $.map(data, function(item) {
        //                             return {
        //                                 id: item.id,
        //                                 text: item.tipo_cuenta + ' - ' + item.nombre_cuenta,
        //                             };
        //                         })
        //                     };
        //                 },
        //                 cache: true
        //             }
        //         });
        //     }

        //     function changue_bancos_pago_tr() {
        //         // $("#select_banco_adl").attr('disabled', false);
        //         console.log('a');
        //         var id_banc = $("#select_banco_transf_pag").val();
        //         $('#select_cuenta_adl_pag').select2({
        //             placeholder: "Seleccionar",
        //             ajax: {
        //                 minimumInputLength: 1,
        //                 url: "{{ route('bancos.registros_search') }}",
        //                 dataType: 'json',
        //                 type: "POST",
        //                 data: function(params) {
        //                     return {
        //                         '_token': $('input[name=_token]').val(),
        //                         'id_bancos': id_banc
        //                     };
        //                 },
        //                 processResults: function(data) {
        //                     return {
        //                         results: $.map(data, function(item) {
        //                             return {
        //                                 id: item.id,
        //                                 text: item.tipo_cuenta + ' - ' + item.nombre_cuenta,
        //                             };
        //                         })
        //                     };
        //                 },
        //                 cache: true
        //             }
        //         });
        //     }
        // 
    </script>
    <script>
        //     function detalle_cuota(item) {
        //         $('#detalle_pago').modal('show');
        //         $('#id_cuota').html(item);

        //         var data = item;
        //         $.ajax({
        //             type: "post",
        //             url: "{{ route('pagos.show_cuota') }}",
        //             data: {
        //                 '_token': $('input[name=_token]').val(),
        //                 'data': item,
        //             },
        //             success: function(msg) {
        //                 var numero = $(`#numero_` + item).val();
        //                 var monto = $(`#monto_` + item).val();
        //                 // var vencimiento = $(`#fecha_ven_` + item).val();
        //                 var estado = $(`#estado_` + item).val();
        //                 $('#n_cuota_header').html(`Cuota N° ` + numero);
        //                 $('#monto_cuota_header').html(monto);
        //                 $('#estado_cuota_header').html(estado);
        //                 $('#body_pago_detail').append(msg['html_end']);
        //             }
        //         });
        //     }
        //     $('#detalle_pago').on('hidden.bs.modal', function(e) {
        //         $('#body_pago_detail').empty();
        //     });

        //     function check_lote(num) {
        //         var count_check = document.querySelectorAll('.check_only');
        //         let checkboxesDesactivados = 0;

        //         // Recorrer los checkboxes y contar los desactivados
        //         count_check.forEach(function(checkbox) {
        //             if (checkbox.checked) {
        //                 checkboxesDesactivados++;
        //             }
        //         });
        //         // console.log(checkboxesDesactivados);
        //         if (checkboxesDesactivados > 0) {
        //             $('#pago_lote').attr('disabled', false);
        //         } else {
        //             $('#pago_lote').attr('disabled', true);
        //         }
        //     }


        //     $('#pago_lote').on('click', function() {
        //         $('.lote_pago_sect').remove();
        //         $('.input_check').remove();
        //         $('.cuota_prec_fact').remove();
        //         var total_c = 0;
        //         var count_check = document.querySelectorAll('.check_only');
        //         count_check.forEach(function(checkbox) {
        //             if (checkbox.checked) {
        //                 var id_cuot = checkbox.id;
        //                 let id_one = id_cuot.match(/\d+/g);
        //                 modal_pagos_lote(id_one[0]);
        //                 total_c += parseFloat($(`#total_` + id_one[0]).val());
        //                 // $(`#cuota_precio`+id_one[0]+``).val(id_one[0] + '_' + total_c);
        //             }
        //         });
        //         $('#efectivo_pago').attr('min', total_c);
        //         $('#total_cuota').val(total_c);
        //     });
    </script>

    @include('cobranzas._shared.js')
    @if (session('success'))
        <script>
            setTimeout(function() {
                toastr.success("{{ session('success') }}");
            }, 300);
        </script>
    @endif
@endsection
