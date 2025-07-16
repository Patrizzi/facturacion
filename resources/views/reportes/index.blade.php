@extends('layout')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('title', 'Reportes')

@section('content')
<style>
    .content-filtros {
        display: flex;
        justify-content: space-between;
        align-items: end;
        width: 100%;
    }

    .content-div {
        display: flex;
        align-items: end;
        width: 100%;
    }

    .select2-selection__rendered {
        width: 85% !important;
    }

    .select2-selection {
        width: 85% !important;
    }
</style>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div role="tabpanel" id="tab-4" class="tab-pane">
                    <div class="panel-body">

                        <div class="row content-filtros">
                            <div class="">
                                <form method="GET" action="{{ route('reportes.index') }}" class="form-inline content-div">
                                    <div class="form-group mr-2">
                                        <label for="filtro" class="mr-2">Filtrar por tipo:</label>
                                        <select name="filtro[]" id="filtro" class="form-control" multiple>
                                            <option value="todos" {{ in_array('todos', (array) request()->get('filtro', [])) ? 'selected' : '' }}>Todos</option>
                                            <option value="facturas" {{ in_array('facturas', (array) request()->get('filtro', [])) ? 'selected' : '' }}>Facturas</option>
                                            <option value="facturas_manuales" {{ in_array('facturas_manuales', (array) request()->get('filtro', [])) ? 'selected' : '' }}>Facturas Manuales</option>
                                            <option value="boletas" {{ in_array('boletas', (array) request()->get('filtro', [])) ? 'selected' : '' }}>Boletas</option>
                                            <option value="boletas_manuales" {{ in_array('boletas_manuales', (array) request()->get('filtro', [])) ? 'selected' : '' }}>Boletas Manuales</option>
                                            <option value="notas_venta" {{ in_array('notas_venta', (array) request()->get('filtro', [])) ? 'selected' : '' }}>Notas de Venta</option>
                                        </select>
                                    </div>

                                    <div class="form-group mr-2">
                                        <label for="estado" class="mr-2">Estado:</label>
                                        <select name="estado[]" id="estado" class="form-control" multiple>
                                            <option value="todos" {{ in_array('todos', (array) request()->get('estado', [])) ? 'selected' : '' }}>Todos</option>
                                            <option value="0" {{ in_array('0', (array) request()->get('estado', [])) ? 'selected' : '' }}>Sin pago</option>
                                            <option value="1" {{ in_array('1', (array) request()->get('estado', [])) ? 'selected' : '' }}>Adelantado</option>
                                            <option value="2" {{ in_array('2', (array) request()->get('estado', [])) ? 'selected' : '' }}>Pagado</option>
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Filtrar</button>
                                </form>
                            </div>
                        </div>

                        {{-- registros comprobantes --}}
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="comprobantesTable">
                                <thead>
                                    <tr>
                                        <th style="display: none;">Guía Remisión</th>
                                        <th>Comprobante</th>
                                        <th>Cliente</th>
                                        <th>RUC</th>
                                        <th >Importe / SubTotal</th>
                                        <th>IGV</th>
                                        <th>Importe Total</th>
                                        <th>Fecha de emisión</th>
                                        <th>Fecha de vencimiento</th>
                                        <th>Estado</th>
                                        <th>Forma de pago</th>
                                        <th>Monto Cancelación</th>
                                        <th style="display: none;">Banco</th>
                                        <th style="display: none;">Nro. Operación</th>
                                        <th>Tipo Cambio</th>
                                        <th>Saldo</th>
                                        <th>Fecha pago</th>
                                        <th style="display: none;">Observación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($comprobantes as $comprobante)
                                        <tr class="gradeX">
                                            @if($comprobante->guia_remision == 0)
                                                <td></td>
                                            @else
                                                <td>{{ $comprobante->guia_remision }}</td>
                                            @endif
                                            <td style="display: none;">{{ $comprobante->codigo }}</td>
                                            <td>{{ $comprobante->cliente_nombre }}</td>
                                            <td>{{ $comprobante->nro_documento }} </td>
                                            <td>{{$comprobante->subTotal }}</td>
                                            <td >{{ $comprobante->igv }}</td>
                                            <td>{{ $comprobante->importe_total }}</td>
                                            <td>{{ $comprobante->fecha_emision }}</td>
                                            <td>{{ $comprobante->fecha_vencimiento }}</td>
                                            <td>{{ $comprobante->estado }}</td>
                                            <td>{{ $comprobante->forma_pago_nombre }}</td>
                                            <td>{{ $comprobante->pagos }}</td>
                                            <td style="display: none;">{{ $comprobante->bancos }}</td>
                                            <td style="display: none;">{{ $comprobante->nro_operacion }}</td>
                                            <td>S/ {{ number_format($comprobante->cambio, 2) }}</td>
                                            <td>{{ $comprobante->saldo }}</td>
                                            <td>{{ $comprobante->fecha_pago }}</td>
                                            <td style="display: none;">{{ $comprobante->observacion }}</td>
                                        </tr>
                                    @endforeach
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

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

{{-- select2 --}}
<link rel="stylesheet" href="{{ asset('css/plugins/select2/select2.min.css') }}">
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#filtro').select2({
            placeholder: "Selecciona tipos de comprobante",
            width: '100%'
        });

        $('#estado').select2({
            placeholder: "Selecciona estados",
            width: '100%'
        });

        $('#comprobantesTable').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'csv', className: 'btn btn-sm btn-primary' },
                { extend: 'excel', title: 'Reportes_Comprobantes', className: 'btn btn-sm btn-primary' },
            ],
            language: {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            },
            columnDefs: [
                {
                    targets: [4, 5, 6],
                    className: 'text-right'
                },
                {
                    targets: [0],
                    type: 'date'
                }
            ],
            order: [[0, 'desc']]
        });
    });
</script>

@endsection
