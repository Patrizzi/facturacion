@extends('layout')
@section('title', 'Boleta Manual')
@section('atributo_actu', 'hidden')
@section('href_accion', route('boleta_manual.create'))
@section('value_accion', 'Agregar')
@section('content')

{{-- obtener errores --}}
@if($errors->any())
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

{{-- obtener errores --}}
@if (Session::has('successMsg'))
<div style="padding-top: 20px;">
    <div class="alert alert-warning">
        <a class="alert-link" href="#">
            <li style="color: black">{{ Session::get('successMsg') }}</li>
        </a>
    </div>
</div>
@endif
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Codigo de Factura</th>
                                    <th>Cliente</th>
                                    <th>N°Documento</th>
                                    <th>Fecha Emision</th>
                                    <th>Importe T.</th>
                                    <th>Ver</th>
                                    <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($boleta as $boletas)
                                <tr class="gradeX">
                                    <td>{{$boletas->id}}</td>
                                    <td>{{$boletas->codigo_boleta}}</td>
                                    <td>{{$boletas->cliente->nombre}}</td>
                                    <td>{{$boletas->cliente->numero_documento}}</td>
                                    <td>{{$boletas->fecha_emision }}</td>
                                    <span hidden>{{$subtotal = $boletas->op_gravada + $boletas->op_inafecta + $boletas->op_exonerada }} </span>
                                    <td>{{$boletas->moneda->simbolo}} {{number_format(round(($subtotal+($boletas->op_gravada*$igv->renta/100)),2),2)}}</td>
                                    {{-- Ver --}}
                                    <td align="center">
                                        <a href="{{route('boleta_manual.show',$boletas->id)}}">
                                            <button type="button" class="btn btn-success"><i class="fa fa-eye"></i></button>
                                        </a>
                                    </td>
                                    {{-- Envio a Sunat --}}
                                    <td style="text-align:center;">
                                        @if($boletas->b_electronica==1) <!-- Nombre del cliente -->
                                            <button class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button>
                                        @elseif($boletas->b_electronica=='2')
                                            <button class="btn btn-danger btn-circle btn-ls"><i class="fa fa-times-circle"></i></button>
                                        @else
                                        <button class="btn btn-warning btn-circle btn-ls"><i class="fa fa-clock-o"></i></button>
                                        @endif
                                    </td>
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
<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            order: [[0, "desc"]],
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });

</script>

@stop