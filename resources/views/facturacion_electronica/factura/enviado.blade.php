@extends('layout')
@section('title', 'Facturacion Electronica')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('content')

    <!-- Modal para Mesajen  Factura  -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="exampleModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enviando Facturas a Sunat</h5>
                </div>
                <div class="modal-body">
                    <div id="msg_c_bol">
                        {{-- Contenido del ajax --}}
                    </div>
                </div>
                <div class="modal-footer" style="display: none;">
                    <div class="row">
                        <div class="col-sm-6">
                            *En caso de algún error al enviar la Factura, por favor comunicarse de manera inmediata.
                        </div>
                        <div class="col-sm-6" style="padding-right: 30px;text-align: right">
                            <button type="button" class="btn btn-primary" id="cerrar_factura">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Factura Manual -->
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="exampleModalManual">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Enviando Facturas Manuales a Sunat</h5>
                </div>
                <div class="modal-body">
                    <div id="msg_c_fac_m">
                        {{-- Contenido del ajax --}}
                    </div>
                </div>
                <div class="modal-footer" style="display: none;">
                    <div class="row">
                        <div class="col-sm-6">
                            *En caso de algún error al enviar la Factura, por favor comunicarse de manera inmediata.
                        </div>
                        <div class="col-sm-6" style="padding-right: 30px;text-align: right">
                            <button type="button" class="btn btn-primary" id="cerrar_factura_m">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                @include('facturacion_electronica.factura.stadistics')
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">

            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
            {{-- CONTENIDO DE TABS --}}
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="">
                            <div class="tabs-container">
                                @include('facturacion_electronica.factura.shared.tabs')
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    <button class="btn btn-success" type="button">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </ul>
                                
                            </div>
                        </div>
                        <!-- Tablas y su contenido -->
                        <div class="tab-content">
                            {{-- TAB 5 PARA LA FACTURAS NORMALES --}}

                            <div role="tabpanel" id="tab-6" class="tab-pane active">
                                <div class="panel-body ">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="input-group">
                                                <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                                <input class="form-control" type="text" name="daterange-factura_env"
                                                    value="{{ date('m/01/2010') }} - {{ date('m/t/Y') }}"
                                                    id="daterange-factura_env" />
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-secondary"
                                                        onclick="revert_select_fact_env()">
                                                        <i class="fa fa-history"></i>
                                                    </button>
                                                </span>
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-primary"
                                                        onclick="limpiar_select_fact_env()">
                                                        <i class="fa fa-eraser"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-5 ">
                                            <div class="input-group">
                                                <label for="inputBuscar"
                                                    class="col-lg-2 col-form-label "><strong>Buscar:</strong></label>
                                                <input type="text" id="inputBuscar" class="form-control"
                                                    aria-describedby="passwordHelpInline">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-primary  btn-block">Buscar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  2 -->
                                    <table class="table table-striped dataTables-fact_enviadas">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks-facturas_env" name="input[]">
                                                </th>
                                                <th>Item</th>
                                                <th>Código</th>
                                                <th>Cliente</th>
                                                <th>N° Doc</th>
                                                <th>Fecha de emisión</th>
                                                <th>Precio Total</th>
                                                <th style="text-align:center;color: #0073c1"><img
                                                        src="{{ asset('sunat.png') }}" width="25px">SUNAT</th>
                                                <th>XML</th>
                                                <th>ZIP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- <span hidden>{{ $a = 1 }}</span>
                                            @foreach ($facturas_enviadas as $factura_enviada)
                                                <tr>
                                                    <td><input type="checkbox" class="i-checks-facturas_env"
                                                            name="input[]"></td>
                                                    <td>{{ $a++ }}</td>
                                                    <td>{{ $factura_enviada->codigo_fac }}</td>
                                                    @if (isset($factura_enviada->cliente_id))
                                                        <!-- Nombre del cliente -->
                                                        <td>{{ $factura_enviada->cliente->nombre }}</td>
                                                        <td>{{ $factura_enviada->cliente->numero_documento }}</td>
                                                    @else
                                                        <td>{{ $factura_enviada->cotizacion->cliente->nombre }}</td>
                                                        <td>{{ $factura_enviada->cotizacion->cliente->numero_documento }}
                                                        </td>
                                                    @endif
                                                    <td>{{ $factura_enviada->created_at }}</td>

                                                    <td style="align: center"><button type="button"
                                                            class="btn btn-info btn-circle btn-ls"><i
                                                                class="fa fa-check-circle"></i></button></td>
                                                    <td style="align: center">
                                                        <a href="{{ asset('facturas_electronicas/') }}/{{ $empresa->ruc }}-01-{{ $factura_enviada->codigo_fac }}.xml"
                                                            download><img src="{{ asset('xml.png') }}"
                                                                width="25px"></a>
                                                    </td>
                                                    <td style="align: center">
                                                        <a href="{{ asset('facturas_electronicas/') }}/R-{{ $empresa->ruc }}-01-{{ $factura_enviada->codigo_fac }}.zip"
                                                            download><img src="{{ asset('zip.png') }}"
                                                                width="25px"></a>
                                                    </td>
                                                </tr>
                                            @endforeach --}}
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- <div role="tabpanel" id="tab-7" class="tab-pane">
                                <div class="d-flex justify-content-md-start row mx-3 mt-4">
                                    <div class="input-group col-md-4 mx-5">
                                        <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                        <input class="form-control" type="text" name="daterange4"
                                            value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-secondary"
                                                onclick="revert_select_fact_manual()">
                                                <i class="fa fa-history"></i>
                                            </button>
                                        </span>
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-primary"
                                                onclick="limpiar_select_fact_manual()">
                                                <i class="fa fa-eraser"></i>
                                            </button>
                                        </span>
                                    </div>

                                    <div class="row g-3 col-md-5">
                                        <div class="col-auto">
                                            <label for="inputBuscar" class="col-form-label">Buscar:</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="inputBuscar" class="form-control"
                                                aria-describedby="passwordHelpInline">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  3 -->
                                    <table class="table table-striped dataTables-fact_manual">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                <th>Item</th>
                                                <th>Código</th>
                                                <th>Cliente</th>
                                                <th>N° Doc</th>
                                                <th>Fecha de Vencimiento</th>
                                                <th style="text-align: center; color: rgb(0, 115, 193); width: 0px;"
                                                    class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                    rowspan="1" colspan="1"><img src="{{ asset('sunat.png') }}"
                                                        width="15px">SUNAT
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <span hidden>{{ $a = 1 }}</span>
                                            @foreach ($facturacion_m as $facturaciones_m)
                                                <tr>
                                                    <th><input type="checkbox" class="i-checks" name="input[]"
                                                            value="{{ $facturaciones_m->codigo_fac }}"></th>
                                                    <td>{{ $a++ }}</td>
                                                    <td>{{ $facturaciones_m->codigo_fac }}</td>
                                                    @if (isset($facturaciones_m->cliente_id))
                                                        <!-- Nombre del cliente -->
                                                        <td>{{ $facturaciones_m->cliente->nombre }}</td>
                                                        <td>{{ $facturaciones_m->cliente->numero_documento }}</td>
                                                    @else
                                                        <td>{{ $facturaciones_m->cotizacion->cliente->nombre }}</td>
                                                        <td>{{ $facturaciones_m->cotizacion->cliente->numero_documento }}
                                                        </td>
                                                    @endif
                                                    <td>{{ $facturaciones_m->fecha_vencimiento }}</td>
                                                    <td><button type="button"
                                                            class="btn btn-success btn-circle btn-ls factura_ind"
                                                            id="factura_ind" value="{{ $facturaciones_m->codigo_fac }}"
                                                            onclick="envio_factura_manual(this)"><i
                                                                class="fa fa-check-circle"></i></button></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfooter>
                                            <td colspan="6" align="right" style="padding-right: 2em"></td>
                                            <td align="center"><button type="button" class="btn btn-primary"
                                                    id="fac_m_elec_all">Enviar</button></td>
                                        </tfooter>
                                    </table>
                                </div>
                            </div> --}}

                            {{-- <div role="tabpanel" id="tab-8" class="tab-pane">
                                <div class="d-flex justify-content-md-start row mx-3 mt-4">
                                    <div class="input-group col-md-4 mx-5">
                                        <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                        <input class="form-control" type="text" name="daterange5"
                                            value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-secondary"
                                                onclick="revert_select_fact_manual_env()">
                                                <i class="fa fa-history"></i>
                                            </button>
                                        </span>
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-primary"
                                                onclick="limpiar_select_fact_manual_env()">
                                                <i class="fa fa-eraser"></i>
                                            </button>
                                        </span>
                                    </div>

                                    <div class="row g-3 col-md-5">
                                        <div class="col-auto">
                                            <label for="inputBuscar" class="col-form-label">Buscar:</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="inputBuscar" class="form-control"
                                                aria-describedby="passwordHelpInline">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  3 -->
                                    <table class="table table-striped dataTables-factura_m_env">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                <th>Item</th>
                                                <th>Código</th>
                                                <th>Cliente</th>
                                                <th>N° Doc</th>
                                                <th>Fecha de emisión</th>
                                                <th style="text-align: center; color: rgb(0, 115, 193); width: 0px;"
                                                    class="sorting" tabindex="0" aria-controls="DataTables_Table_1"
                                                    rowspan="1" colspan="1"
                                                    aria-label="SUNAT: activate to sort column ascending"><img
                                                        src="{{ asset('sunat.png') }}" width="15px">SUNAT
                                                </th>
                                                <th>XML</th>
                                                <th>ZIP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <span hidden>{{ $a = 1 }}</span>
                                            @foreach ($facturacion_enviada_m as $facturaciones_m)
                                                <tr>
                                                    <td><input type="checkbox" class="i-checks" name="input[]"></td>
                                                    <td>{{ $a++ }}</td>
                                                    <td>{{ $facturaciones_m->codigo_fac }}</td>
                                                    @if (isset($facturaciones_m->cliente_id))
                                                        <!-- Nombre del cliente -->
                                                        <td>{{ $facturaciones_m->cliente->nombre }}</td>
                                                        <td>{{ $facturaciones_m->cliente->numero_documento }}</td>
                                                    @else
                                                        <td>{{ $facturaciones_m->cotizacion->cliente->nombre }}</td>
                                                        <td>{{ $facturaciones_m->cotizacion->cliente->numero_documento }}
                                                        </td>
                                                    @endif
                                                    <td>{{ $facturaciones_m->created_at }}</td>
                                                    <td align="center">
                                                        <button type="button" class="btn btn-info btn-circle btn-ls"><i
                                                                class="fa fa-check-circle"></i></button>
                                                    </td>
                                                    <td align="center">
                                                        <a href="{{ asset('facturas_electronicas/') }}/{{ $empresa->ruc }}-01-{{ $facturaciones_m->codigo_fac }}.xml"
                                                            download><img src="{{ asset('xml.png') }}"
                                                                width="25px"></a>
                                                    </td>
                                                    <td align="center">
                                                        <a href="{{ asset('facturas_electronicas/') }}/R-{{ $empresa->ruc }}-01-{{ $facturaciones_m->codigo_fac }}.zip"
                                                            download><img src="{{ asset('zip.png') }}"
                                                                width="25px"></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div> --}}

                            {{-- <div role="tabpanel" id="tab-9" class="tab-pane">
                                <div class="d-flex justify-content-md-start row mx-3 mt-4">
                                    <div class="input-group col-md-4 mx-5">
                                        <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                        <input class="form-control" type="text" name="daterange6"
                                            value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-secondary"
                                                onclick="revert_select_detraccion()">
                                                <i class="fa fa-history"></i>
                                            </button>
                                        </span>
                                        <span class="input-group-append">
                                            <button type="button" class="btn btn-primary"
                                                onclick="limpiar_select_detraccion()">
                                                <i class="fa fa-eraser"></i>
                                            </button>
                                        </span>
                                    </div>

                                    <div class="row g-3 col-md-5">
                                        <div class="col-auto">
                                            <label for="inputBuscar" class="col-form-label">Buscar:</label>
                                        </div>
                                        <div class="col-md-7">
                                            <input type="text" id="inputBuscar" class="form-control"
                                                aria-describedby="passwordHelpInline">
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  3 -->
                                    <table class="table table-striped dataTables-detraccion">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" class="i-checks" name="input[]"></th>
                                                <th>ID</th>
                                                <th>N° de Doc</th>
                                                <th>Tipo</th>
                                                <th>Fecha de Emisión</th>
                                                <th>Monto total</th>
                                                <th>Monto Detracción</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($detraccion_facturas as $fact_det)
                                                <tr>
                                                    <td></td>
                                                    @if ($fact_det->factura_id != null)
                                                        <td>{{ $fact_det->id }}</td>
                                                        <td>{{ $fact_det->factura->codigo_fac }}</td>
                                                        <td>Factura</td>
                                                        <td>{{ Carbon\Carbon::parse($fact_det->factura->fecha_emision)->format('d-m-Y') }}
                                                        </td>
                                                        <td>{{ $fact_det->factura->moneda->simbolo }} |
                                                            {{ $fact_det->factura->moneda->nombre }}</td>
                                                        <td>S/. {{ $fact_det->monto_detraccion }}</td>
                                                        <td>
                                                            <a class="btn btn-secondary"
                                                                href="{{ route('facturacion.show', $fact_det->factura->id) }}"><i
                                                                    class="fa fa-eye"></i></a>
                                                        </td>
                                                    @else
                                                        <td>{{ $fact_det->id }}</td>
                                                        <td>{{ $fact_det->factura_m->codigo_fac }}</td>
                                                        <td>Factura M.</td>
                                                        <td>{{ Carbon\Carbon::parse($fact_det->factura_m->fecha_emision)->format('d-m-Y') }}
                                                        </td>
                                                        <td>{{ $fact_det->factura_m->moneda->simbolo }} |
                                                            {{ $fact_det->factura_m->moneda->nombre }}</td>
                                                        <td>S/. {{ $fact_det->monto_detraccion }}</td>
                                                        <td>
                                                            <a class="btn btn-secondary"
                                                                href="{{ route('facturacion_manual.show', $fact_det->factura_m->id) }}"><i
                                                                    class="fa fa-eye"></i></a>
                                                        </td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .dropdown-menu {
            left: 70px;
            padding: 20px 0;
        }
        .model-footer {
            > :not(:last-child) {
                margin-right: .0rem;
            }
        }

        /* OCULTANDO LO DE ORGANIZAR*/
        /* Ver (números) */
        div.dataTables_length {
            display: none;
        }

        /* El Buscar */
        div.dataTables_filter {
            display: none;
        }

        /* CSV, Excel, PDF, Print */
        div.dt-buttons {
            display: none;
        }

        #alert_one_factura {
            margin-bottom: 0px !important;
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
    <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>

    <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- check -->
    <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>


    {{-- <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.time.js') }}"></script> --}}


    {{-- <script src="{{ asset('js/icheck.min.js') }}"></script> --}}

    <!-- Seleccionar todos los check -->
    {{-- 
    <script>
        $('')
    </script> --}}

    <script>
        $(document).ready(function() {
            // "ACTIVA EL TAB DE FACTURAS "
            $('#tab_fact_env').addClass('active');

            // {{-- Datatable Facturas Enviadas  --}}
            var table_factura_enviada = $('.dataTables-fact_enviadas').DataTable({
                "serverSide": true,
                "ajax": {
                    url: "{{ route('facturas_electronicas.enviadas_lst') }}",
                    method: "get",
                    data: function(d) {
                        // Aquí añades los parámetros que quieres enviar junto con la petición AJAX
                        d.daterange = $('#daterange-factura_env')
                            .val(); // Supongamos que tienes un select para el tipo de cotización
                        d.value = $('#inputBuscar').val();
                    },
                    dataSrc: function(json) {
                        return json.data;
                    }
                },
                "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                    $(nRow).addClass('tooltip-demo');
                    return nRow;
                },
                "columnDefs": [{
                        'width': '1vmax',
                        'targets': [0], // Aplica a la primera columna (index 0)
                        'orderable': false, // Deshabilitar ordenación en esta columna
                        'render': function(data, type, full, meta) {
                            // Renderizar el checkbox en la primera columna
                            return '<input type="checkbox" name="select_row" value="' + full[0] +
                                '" class="i-checks-facturas_env">';
                        }
                    },
                    {
                        'width': '30%',
                        'targets': [4]
                    },
                    {
                        'targets': [7], // Estado
                        'orderable': false,
                        'render': function(data, type, full, meta) {
                            var end = ``;
                            if (full[7] == 1) {
                                end +=
                                    `<button type="button" class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button> `;
                            } else {
                                end +=
                                    `<button type="button" class="btn btn-danger btn-circle btn-ls"><i class="fa fa-times-circle"></i></button> `;
                            }
                            // NOTA DE CREDITO
                            if (full[9] != 0 ) {
                                if (full[9] == 1) {
                                    end +=
                                        `<button class="btn btn-info btn-circle btn-ls"  data-toggle="tooltip" data-placement="bottom" title="Nota de Credito:  Aceptada"><i style="font-weight: 700">NC</i></button> `;
                                } else {
                                    end +=
                                        `<button class="btn btn-warning btn-circle btn-ls "  data-toggle="tooltip" data-placement="bottom" title="Nota de Credito: En Espera"><i style="font-weight: 700">NC</i></button> `;
                                }
                            }
                            // NOTA DE DEBITO
                            if (full[10] != 0) {
                                if (full[10] == 1) {
                                end +=
                                    `<button class="btn btn-info btn-circle btn-ls "  data-toggle="tooltip" data-placement="bottom" title="Nota de Debito:  Aceptada"><i style="font-weight: 700">ND</i></button>`;
                            } else {
                                end +=
                                    `<button class="btn btn-warning btn-circle btn-ls "  data-toggle="tooltip" data-placement="bottom" title="Nota de Debito: En Espera"><i style="font-weight: 700">ND</i></button>`;
                            }
                            }

                            return end;
                        }
                    },
                    {
                        'targets': [8], // Descargar XML
                        'orderable': false,
                        'render': function(data, type, full, meta) {
                            var url =
                                `{{ asset('facturas_electronicas/') }}/{{ $empresa->ruc }}-01-${full[2]}.xml`;
                            return `<a href="${url}" download ><img src="{{ asset('xml.png') }}" width="25px"></i></a>`;
                        }
                    },
                    {
                        'targets': [9],
                        'orderable': false,
                        'render': function(data, type, full, meta) {
                            var url =
                                `{{ asset('facturas_electronicas/') }}/{{ $empresa->ruc }}-01-${full[2]}.zip`;
                            return `<a href="${url}" download ><img src="{{ asset('zip.png') }}" width="25px"></i></a>`;
                        }
                    }
                ],
                drawCallback: function() {
                    $('[data-toggle="tooltip"]').tooltip();
                    $('.i-checks-facturas_env').iCheck({
                        checkboxClass: 'icheckbox_square-green',
                        radioClass: 'iradio_square-green',
                    });
                }
            });



            
            // $('input[name="daterange3"]').daterangepicker({

            //         "locale": {
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
            //         console.log(dateRangeString);
            //         table_factura_enviada.column(5).search(dateRangeString, true, false).draw();
            //     }
            // );
            // {{-- Datatable Facturas Enviadas --}}
            table_fact_manual = $('.dataTables-fact_manual').DataTable({
                pageLength: 15,
                order: [
                    [0, "desc"]
                ],
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [],
                aoColumnDefs: [{
                    'bSortable': false,
                    'aTargets': [0]
                }]
            });
            // $('input[name="daterange4"]').daterangepicker({
            //         "locale": {
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
            //         console.log(dateRangeString);
            //         table_fact_manual.column(5).search(dateRangeString, true, false).draw();
            //     }
            // );
            // {{-- Datatable Facturas Manual --}}
            table_fact_manual_env = $('.dataTables-factura_m_env').DataTable({
                pageLength: 15,
                order: [
                    [0, "desc"]
                ],
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [],
                aoColumnDefs: [{
                    'bSortable': false,
                    'aTargets': [0]
                }]
            });
            // $('input[name="daterange5"]').daterangepicker({

            //         "locale": {
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
            //         console.log(dateRangeString);
            //         table_fact_manual_env.column(5).search(dateRangeString, true, false).draw();
            //     }
            // );
            // {{-- Datatable Facturas Manual Enviadas --}}
            table_detraccion = $('.dataTables-detraccion').DataTable({
                pageLength: 15,
                order: [
                    [0, "desc"]
                ],
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [],
                aoColumnDefs: [{
                    'bSortable': false,
                    'aTargets': [0]
                }]
            });
            // $('input[name="daterange6"]').daterangepicker({
            //         "locale": {
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
            //         console.log(dateRangeString);
            //         table_detraccion.column(4).search(dateRangeString, true, false).draw();
            //     }
            // );

        });

        // Facturas
        function limpiar_select_factura() {
            table_factura.column(5).search("").draw();
        }

        function revert_select_factura() {
            table_factura.column(5).search(`{{ date('m-Y') }}`).draw();
        }
        // Facturas Enviadas
        function limpiar_select_fact_env() {
            table_fact_enviada.column(5).search("").draw();
        }

        function revert_select_fact_env() {
            table_fact_enviada.column(5).search(`{{ date('m-Y') }}`).draw();
        }
        // Factuas Manuales
        function limpiar_select_fact_manual() {
            table_fact_manual.column(5).search("").draw();
        }

        function revert_select_fact_manual() {
            table_fact_manual.column(5).search(`{{ date('m-Y') }}`).draw();
        }

        // Manual Enviados 
        function limpiar_select_fact_manual_env() {
            table_fact_manual_env.column(5).search("").draw();
        }

        function revert_select_fact_manual_env() {
            table_fact_manual_env.column(5).search(`{{ date('m-Y') }}`).draw();
        }
        // Detraccion 
        function limpiar_select_detraccion() {
            table_detraccion.column(4).search("").draw();
        }

        function revert_select_detraccion() {
            table_detraccion.column(4).search(`{{ date('m-Y') }}`).draw();
        }
    </script>
    <script>
        // CHECKS FACTURAS
        $('thead input[class="i-checks-facturas"]').on('ifChecked ifUnchecked', function(event) {
            var table = $(this).closest('table'); // Limita el control de checkboxes a la tabla actual
            if (event.type === 'ifChecked') {
                // Selecciona 
                table.find('tbody input[class="i-checks-facturas"]').iCheck('check');
            } else {
                // Deselecciona 
                table.find('tbody input[class="i-checks-facturas"]').iCheck('uncheck');
            }
        });

        // Si todos los checkboxes de tbody de la tabla visible están seleccionados, selecciona el checkbox del thead, y si no, deselecciónalo
        $('tbody input[class="i-checks-facturas"]').on('ifChanged', function(event) {
            var table = $(this).closest('table'); // Limita el control a la tabla visible
            if (table.find('tbody input[class="i-checks-facturas"]').filter(':checked').length === table.find(
                    'tbody input[class="i-checks-facturas"]').length) {
                table.find('thead input[class="i-checks-facturas"]').iCheck('check');
            } else {
                table.find('thead input[class="i-checks-facturas"]').iCheck('uncheck');
            }
        });

        // $(document).ready(function() {
        //     $('.i-checks').iCheck({
        //         checkboxClass: 'icheckbox_square-green',
        //         radioClass: 'iradio_square-green',
        //     });

        //     // Controlar el checkbox del thead 
        //     $('thead input[type="checkbox"]').on('ifChecked ifUnchecked', function(event) {
        //         var table = $(this).closest('table'); // Limita el control de checkboxes a la tabla actual
        //         if (event.type === 'ifChecked') {
        //             // Selecciona 
        //             table.find('tbody input[type="checkbox"]').iCheck('check');
        //         } else {
        //             // Deselecciona 
        //             table.find('tbody input[type="checkbox"]').iCheck('uncheck');
        //         }
        //     });

        //     // Si todos los checkboxes de tbody de la tabla visible están seleccionados, selecciona el checkbox del thead, y si no, deselecciónalo
        //     $('tbody input[type="checkbox"]').on('ifChanged', function(event) {
        //         var table = $(this).closest('table'); // Limita el control a la tabla visible
        //         if (table.find('tbody input[type="checkbox"]').filter(':checked').length === table.find(
        //                 'tbody input[type="checkbox"]').length) {
        //             table.find('thead input[type="checkbox"]').iCheck('check');
        //         } else {
        //             table.find('thead input[type="checkbox"]').iCheck('uncheck');
        //         }
        //     });

        //     // Detectar cuando se cambia de tab 
        //     $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
        //         // Restablecer el estado de los checkboxes 
        //         var activeTab = $(e.target).attr('href'); // ID del tab activo
        //         $(activeTab).find('.i-checks').iCheck('update');
        //     });
        // });
    </script>
    <!-- Page Scripts -->
    <script>
        // $(function() {
        //     $('[data-toggle="popover"]').popover()
        // })

        // function toggle() {
        //     $(function() {
        //         $('[data-toggle="popover"]').popover()
        //     })
        // }
    </script>
    <script>
        //FUNCIONES PARA FACTURA NORMAL
        //FACTURAS INDIVIVUALES
        function inv_close() {
            $(document).ready(function() {
                $("#myAlert").bind('closed.bs.alert', function() {
                    location.reload();
                })
            });
            $('[data-toggle="popover"]').popover();
            const myTimeout = setTimeout(click, 5000);
        }

        function click() {
            console.log("click");
            $('[data-toggle="popover"]').popover();
            $('#cerrar_popup').trigger('click');
        }
        // ENVIO DE FACTURA INDIVIDUAL
        function envio_factura(codigo) {
            // console.log(codigo.val());
            $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
            $('.nav-link').addClass('disabled');
            var value_check = codigo.value;
            console.log(value_check);
            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.factura_elec_all') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'codigo_fac': value_check,
                },
                success: function(response) {
                    var salt = response.replace(/(\r\n|\n|\r)/gm, "")
                    var result = salt.substr(0, 13);
                    // console.log(result);
                    if (result == "Codigo Error:") {
                        var data = `
                        <div id="alert_one_factura" class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert"  data-toggle="popover" data-placement="left" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">&times;</a>
                            <span class="alert-link" id="` + value_check + `">Error N°  ` + value_check + ' <br> ' +
                            response + `</span>
                        </div>
                    `;
                        codigo.prop('disabled', true);
                        $(`input[value="${value_check}"]`).prop('disabled', true);
                    } else {
                        var data = `
                        <div id="alert_one_factura" class=" alert alert-success" >
                            <a id="cerrar_popup" class="close"  data-container="body" data-trigger="click" data-toggle="popover"  data-placement="bottom" data-content="Haga click para cerrar esta notificación." style="color:#d4edda;width: 0">&times;</a>
                            <a class="close" data-dismiss="alert">&times;</a>
                            <span class="alert-link" id="` + value_check + `">` + response + `</span>
                        </div>
                    `;
                    }
                    // revision(value_check, response, 'factura');
                    // inv_close();
                    $('#alert_factura').append(data);
                    // $("#success-alert").show();
                }
            });
        }

        function envio_factura_manual(codigo) {
            // console.log(codigo.val());
            $('#ibox2').children('.ibox-content').toggleClass('sk-loading');
            $('.nav-link').addClass('disabled');
            var value_check = codigo.value;
            console.log(value_check);
            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.fac_elec_man_all') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'codigo_fac': value_check,
                },
                success: function(response) {
                    var salt = response.replace(/(\r\n|\n|\r)/gm, "")
                    var result = salt.substr(0, 13);
                    // console.log(result);
                    if (result == "Codigo Error:") {
                        var data = `
                        <div id="myAlert" class="alert alert-danger">
                            <a href="#" class="close" data-dismiss="alert"  data-toggle="popover" data-placement="left" data-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus.">&times;</a>
                            <span class="alert-link" id="` + value_check + `">Error N°  ` + value_check + ' <br> ' +
                            response + `</span>
                        </div>
                    `;
                    } else {
                        var data = `
                        <div id="myAlert" class=" alert alert-success" >
                            <a id="cerrar_popup" class="close"  data-container="body" data-trigger="click" data-toggle="popover"  data-placement="bottom" data-content="Haga click para cerrar esta notificación." style="color:#d4edda;width: 0">&times;</a>
                            <a class="close" data-dismiss="alert">&times;</a>
                            <span class="alert-link" id="` + value_check + `">` + response + `</span>
                        </div>
                    `;
                    }
                    revision(value_check, response, 'factura_manual');
                    inv_close();
                    $('#msg_individual').append(data);
                    $("#success-alert").show();
                }
            });
        }
        //  FUNCION PARASELECCION MUILTIPLE
        function select_all_fact() {
            $('input[class=case]:checkbox').each(function() {
                // console.log($('input[class=check_all]:checkbox:checked'));
                if ($('input[class=check_all]:checkbox:checked').length == 0) {
                    // console.log("a");
                    $(this).prop("checked", false);
                } else {
                    // console.log("b");
                    $(this).prop("checked", true);
                }
            });
        }
        //Facturas masivas
        function submit_factura_click(repetir, maximo) {
            if (repetir < maximo) {
                var value_check = $('input[class=i-checks-facturas]:checkbox:checked')[repetir].value;
                $.ajax({
                    type: "post",
                    url: "{{ route('facturacion_electronica.factura_elec_all') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'codigo_fac': value_check,
                    },
                    success: function(response) {
                        var salt = response.replace(/(\r\n|\n|\r)/gm, "")
                        var result = salt.substr(0, 13);
                        // console.log(result);
                        if (result == "Codigo Error:") {
                            var data = `
                            <div class="alert alert-danger">
                                <a class="alert-link" href="#" id="` + value_check + `">Error N°  ` + value_check +
                                ' <br> ' + response + `</a>
                            </div>`;
                        } else {
                            var data = `
                            <div class="alert alert-success">
                                <a class="alert-link" href="#" id="` + value_check + `">` + response + `</a>
                            </div>`;
                        }
                        revision(value_check, response, 'factura');
                        $('#msg_c_bol').append(data);
                        repetir++;
                        submit_factura_click(repetir, maximo);
                    }
                });
                $('#exampleModal').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            } else {
                $('.modal-footer').removeAttr('style');
            }
        }

        $('#fac_elec_all').on('click', function() {
            var cant_checks = $('input[class=i-checks-facturas]:checkbox:checked').length;
            if (cant_checks != 0) {
                // $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
                submit_factura_click(0, cant_checks);
            }
        });

        $('#cerrar_factura').on('click', function() {
            location.reload();
        });

        function revision(codigo, msg, tipo) {
            $.ajax({
                type: "post",
                url: "{{ route('facturacion_electronica.validacion_sunat') }}",
                data: {
                    '_token': $('input[name=_token]').val(),
                    'tipo': tipo,
                    'codigo_fac': codigo,
                    'msg': msg,
                },
                success: function(response) {
                    // console.log(response);
                    var data2 = `<p style="margin-bottom: 0px">` + response + `</p>`
                    $(`#` + codigo + ``).append(data2);
                }
            });
        }
        //

        //FUNCIONES PARA FACTURA MANUAL
        function select_all_fact_man() {
            $('input[class=case_m]:checkbox').each(function() {
                // console.log($('input[class=check_all]:checkbox:checked'));
                if ($('input[class=check_all_fac_m]:checkbox:checked').length == 0) {
                    // console.log("a");
                    $(this).prop("checked", false);
                } else {
                    // console.log("b");
                    $(this).prop("checked", true);
                }
            });
        }

        function submit_factura_manual_click(repetir, maximo) {
            if (repetir < maximo) {
                var value_check = $('input[class=case_m]:checkbox:checked')[repetir].value;
                $.ajax({
                    type: "post",
                    url: "{{ route('facturacion_electronica.fac_elec_man_all') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'codigo_fac': value_check,
                    },
                    success: function(response) {
                        var salt = response.replace(/(\r\n|\n|\r)/gm, "")
                        var result = salt.substr(0, 13);
                        console.log(result);
                        if (result == "Codigo Error:") {
                            var data = `
                            <div class="alert alert-danger">
                                <a class="alert-link" href="#">Error N°  ` + value_check + ' <br> ' + response + `</a>
                            </div>
                        `;
                        } else {
                            var data = `
                            <div class="alert alert-success">
                                <a class="alert-link" href="#">` + response + `</a>
                            </div>
                        `;
                        }
                        revision(value_check, response, 'factura_manual');
                        $('#msg_c_fac_m').append(data);
                        repetir++;
                        submit_factura_manual_click(repetir, maximo);
                    }
                });
            } else {
                $('.modal-footer').removeAttr('style');
            }
        }
        $('#fac_m_elec_all').on('click', function() {
            var cant_checks = $('input[class=case_m]:checkbox:checked').length;
            console.log(cant_checks)
            // var max_menos = cant_checks -1;
            if (cant_checks == 0) {
                console.log("ninguno marcado");
            } else {
                $('#exampleModalManual').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $("#exampleModalManual").modal("show");
                $('#ibox1').children('.ibox-content').toggleClass('sk-loading');
                submit_factura_manual_click(0, cant_checks);
            }

        });
        $('#cerrar_factura_m').on('click', function() {
            location.reload();
        });
        // Mensaje para que cierre x
    </script>


@endsection
