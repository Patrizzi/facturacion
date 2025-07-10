@extends('layout')
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('title', 'Reportes')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="box">
                <div role="tabpanel" id="tab-4" class="tab-pane">
                    <div class="panel-body">
                        <div class="table-responisve">
                            <table class="table table-striped table-bordered table-hover dataTables-example" >
                                <thead>
                                    <tr>
                                        <th>Fecha de emisión</th>
                                        <th>Comprobante</th>
                                        <th>Cliente</th>
                                        <th>RUC</th>
                                        <th>Importe Total</th>
                                        <th>Pagado</th>
                                        <th>Pendiente</th>
                                        <th>Forma de pago</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($comprobantes as $comprobante)
                                        <tr class="gradeX">
                                            <td>{{ $comprobante->fecha_emision }}</td>
                                            <td>{{ $comprobante->cod_comprobante }}</td>
                                            <td>{{ $comprobante->cliente_nombre }}</td>
                                            <td> {{ $comprobante->nro_documento }} </td>
                                            <td>S/ {{ number_format($comprobante->importe_total, 2) }}</td>
                                            <td>S/ {{ number_format($comprobante->monto_tot, 2) }}</td>
                                            <td>S/ {{ number_format($comprobante->pendiente_pago, 2) }}</td>
                                            <td>{{ $comprobante->forma_pago }}</td>
                                            <td>{{ $comprobante->estado_pago }}</td>
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
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 20,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [ ]
        });
    });
</script>
@endsection
