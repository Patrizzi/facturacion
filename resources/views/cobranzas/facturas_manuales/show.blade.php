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
                                                @switch($factura_m->estado)
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
                                            {{ $factura_m->total_precio }}
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
                                                        {{ $factura_m->moneda->simbolo }}
                                                        {{ number_format($cuotas->monto, 2) }}
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
                                        <div class="detalle_cuota_detallado d-none" id="cuota_detalla_{{ $f }}">
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
                                                        <p class="form-control" id="numero_cuota_{{ $cuota->id }}"
                                                            style="margin-bottom: 0px">{{ $cuota->monto_total_format }}</p>
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
    @include('cobranzas.facturas_manuales.modal_detalle');
    @if ($factura_m->forma_pago_id == 1) {{-- Contado--}}
        <script>
            $(document).ready(function() {
                console.log("cargando contado");
                contado_table("{{ $factura_m->id }}");
            });
        </script>
    @endif
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
                // {
                //     'targets': [6],
                //     'orderable': false,
                //     'render': function(data, type, full, meta) {
                //         var button =
                //             `<button class="btn btn-sm btn-primary"><i class="fa fa-eye" ></i></button>`;
                //         return button;
                //     }
                // }
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
                    clear_campos_detalle();
                    $('#pago_cheque, #pago_tarjeta, #pago_efectivo, #pago_transferencia').hide();
                    $('#modal_detalle_pago').modal('show');
                    $('#monto_total_cuota').html(msg.detalle.comprobante_pago_registros.cuota_credito
                        .monto_total_format);
                    $('#estado_cuota').html(msg.detalle.comprobante_pago_registros.cuota_credito.estado_format);
                    switch (msg.detalle.tipo_pago) {
                        case 'cheque':
                            $('#tipo_pago').html("Cheque");

                            $('#pago_cheque').show();

                            $('#numero_cheque').html(msg.detalle.numero_input);
                            $('#fecha_cheque').html(msg.detalle.fechas_input_format);
                            $('#banco_emisor_cheque').html(msg.detalle.bancos_input);
                            $('#beneficiario_cheque').html(msg.detalle.persona_input);
                            $('#moneda_monto_cheque').html(msg.detalle.monto_pagado_format);
                            $('#tipo_cambio_cheque').html(msg.detalle.tipo_cambio);
                            if (msg.detalle.option_input == 0) {
                                $('#diferido_cheque').html("NO");
                            } else {
                                $('#diferido_cheque').html("SI");
                            }
                            $('#emision_cheque').html(msg.detalle.fecha_emision_format);
                            $('#banco_empresa_cheque').html(msg.detalle.banco_empresa.nombre_banco);
                            $('#cuenta_cheque').html(msg.detalle.numero_cuenta.tipo_cuenta + ' ' + msg.detalle
                                .numero_cuenta
                                .nombre_cuenta);
                            // Falta el comprobante 
                            $('#observaciones_cheque').html(msg.detalle.notas_adicionales);
                            break;
                        case 'tarjeta':
                            $('#tipo_pago').html("Tarjeta");

                            $('#pago_tarjeta').show();
                            $('#titular_tarjeta').html(msg.detalle.titular_tarjeta);
                            $('#banco_tarjeta').html(msg.detalle.bancos_input);
                            $('#moneda_monto_tarjeta').html(msg.detalle.monto_pagado_format);
                            $('#tipo_cambio_tarjeta').html(msg.detalle.tipo_cambio);
                            $('#fecha_tarjeta').html(msg.detalle.fechas_input_format);
                            // Falta el comprobante
                            $('#observaciones_tarjeta').html(msg.detalle.notas_adicionales);
                            break;
                        case 'efectivo':
                            $('#tipo_pago').html("Efectivo");

                            $('#pago_efectivo').show();
                            $('#persona_efectivo').html(msg.detalle.persona_input);
                            $('#fecha_efectivo').html(msg.detalle.fechas_input_format);
                            $('#moneda_monto_efectivo').html(msg.detalle.monto_pagado_format);
                            $('#tipo_cambio_efectivo').html(msg.detalle.tipo_cambio);
                            // Falta el comprobante
                            $('#observaciones_efectivo').html(msg.detalle.notas_adicionales);
                            break;
                        case 'transferencia':
                            $('#tipo_pago').html("Transferencia");

                            $('#pago_transferencia').show();
                            $('#titular_transferencia').html(msg.detalle.persona_input);
                            $('#fecha_transferencia').html(msg.detalle.fechas_input_format);
                            $('#moneda_monto_transferencia').html(msg.detalle.monto_pagado_format);
                            $('#tipo_cambio_transferencia').html(msg.detalle.tipo_cambio);
                            $('#numero_operacion_transferencia').html(msg.detalle.numero_input);
                            // Falta el comprobante
                            $('#observaciones_transferencia').html(msg.detalle.persona_input);
                            break;
                        default:
                            break;
                    }

                    // Para otros detalles
                    if (msg.otros != null) {
                        $('#otros-nulos').hide();
                        $('#detalle-otros-pago').show();
                        var suma_tot = 0;
                        msg.otros.forEach(element => {
                            suma_tot = +element.comprobante_pago_registros.cuota_credito.monto;
                            var content = `
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for=""><strong>Comprobante</strong></label>
                                            <p class="form-control" id="comprobante_otro">` + element
                                .comprobante_pago_registros.cuota_credito.factura_m_ids.codigo_fac + `</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label for=""><strong>Cuota</strong></label>
                                            <p class="form-control" id="cuota_otro">Cuota N ` + element
                                .comprobante_pago_registros.cuota_credito.numero_cuota + `</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <label for=""><strong>Cuota</strong></label>
                                        <div class="form-group">
                                            <div class="input-group  input-group-sm">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="moneda_simbolo_otro"
                                                        style="justify-content: center">` + element
                                .comprobante_pago_registros.cuota_credito.moneda_comprobante + `</span>
                                                </div>
                                                <label class="form-control form-control" id="total_otro"
                                                    aria-describedby="inputGroup-sizing-sm">` + element
                                .comprobante_pago_registros.cuota_credito.monto.toFixed(2) + `</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            $('#otros-comprobantes-registros').append(content);

                        });

                        $('#tota_totas').html(suma_tot.toFixed(2));
                    }
                    console.log(msg.detalle);
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

        function contado_table(id_factura_m) {
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
                                2: `<span class="label label-primary">Pagado Completo</span>`
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
                    // {
                    //     'targets': [6],
                    //     'orderable': false,
                    //     'render': function(data, type, full, meta) {
                    //         var button =
                    //             `<button class="btn btn-sm btn-primary"><i class="fa fa-eye" ></i></button>`;
                    //         return button;
                    //     }
                    // }
                ]
            })
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
