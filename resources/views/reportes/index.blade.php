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
                                            <td>S/ {{ $comprobante->monto_tot }}</td>
                                            <td>S/300</td>
                                            <td> --- </td>
                                            <td>Crédito Contado</td>
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
@endsection
