@extends('layout')
@section('title', 'Facturación')
@section('atributo_actu', 'hidden')

@if($conteo_almacen==1)
@section('value_accion', 'Agregar')
@section('onclick1', 'Enviar_create()')
@else
@section('atributo_1', 'hidden')
@section('boton_opcional')
@if($user_login->name=='Administrador')
<span class="dropdown ">
  <button  class="btn btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown" >Agregar</button>
  <ul class="dropdown-menu animated fadeInRight m-t-xs">
    <span style="margin-left:12px;"><b>Almacenes:</b></span>
    @foreach($almacen as $almacens)
    <li><a class="dropdown-item" onclick="alm_adm_{{$almacens->id}}()">{{$almacens->nombre}}</a></li>
    <form action="{{ route('facturacion.create')}}" id="alm_adm_{{$almacens->id}}" enctype="multipart/form-data" method="post">
        @csrf
        <input type="text" value="{{$almacens->id}}" hidden="hidden" name="almacen">
    </form>
    <script>
        console.log({{$almacens->id}});
        function alm_adm_{{$almacens->id}}(){document.getElementById('alm_adm_{{$almacens->id}}').submit();}
    </script>
    @endforeach
</ul>
</span>
@elseif($user_login->name=='Colaborador')
<button  class="btn btn-primary" type="button" onclick="Enviar_create2()">Agregar</button>
@endif
@endsection
@endif

@section('content')
<span hidden>
    <script>
        function Enviar_create(){document.getElementById('myform1').submit();}
        function Enviar_create2(){document.getElementById('myform2').submit();}
    </script>
    <form id="myform1" action="{{ route('facturacion.create')}}" enctype="multipart/form-data" method="post">
        @csrf
        <input type="text" value="{{$almacen_primero->id}}" hidden="hidden" name="almacen">
    </form>
    <form id="myform2" action="{{ route('facturacion.create')}}" enctype="multipart/form-data" method="post">
        @csrf
        <input type="text"  hidden="hidden" name="almacen"  value="{{$user_login->almacen_id}}">
    </form>
</span>
@if($errors->any())
<div class="alert alert-danger" style="margin-top: 10px;margin-bottom: 0px;">
    <a class="alert-link" href="#">
        @foreach ($errors->all() as $error)
        <li class="error" style="color: red">{{ $error }}</li>
        @endforeach
    </a>
</div>
@endif
<style> .dropdown-menu{left: 70px; padding: 20px 0;}</style>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">

        <div class="col-lg-12">
            @if (session('repite'))
            <div class="alert alert-danger">
                {{ session('repite') }}
            </div>
            @endif
            @if (session('campo'))
            <div class="alert alert-success">
                {{ session('campo') }}
            </div>
            @endif
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Código de Factura</th>
                                    <th>Cliente</th>
                                    <th>Ruc/DNI</th>
                                    <th>Fecha de Emision</th>
                                    <th>Importe T.</th>
                                    <th></th>
                                    <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($facturacion as $index => $facturacions)
                                <tr class="gradeX tooltip-demo">
                                    <td>{{$facturacions->id}}</td>
                                    <td>{{$facturacions->codigo_fac}}</td>
                                    @if(empty($facturacions->id_cotizador)) <!-- Nombre del cliente -->
                                    <td>{{$facturacions->cliente->nombre}}</td>
                                    <td>{{$facturacions->cliente->numero_documento}}</td>
                                    @else
                                    <td>{{$facturacions->cotizacion->cliente->nombre}}</td>
                                    <td>{{$facturacions->cotizacion->cliente->numero_documento}}</td>
                                    @endif
                                    <td>{{$facturacions->fecha_emision }}</td>
                                    <span hidden>{{$subtotal = $facturacions->op_gravada + $facturacions->op_inafecta + $facturacions->op_exonerada }} </span>
                                    <td>{{$facturacions->moneda->simbolo}} {{number_format(round(($subtotal+($facturacions->op_gravada*$igv->renta/100)),2),2)}}</td>
                                    <td align="center">
                                        <a href="{{route('facturacion.show',$facturacions->id)}}">
                                          <button type="button" class="btn btn-success"><i class="fa fa-eye"></i></button>
                                      </a>
                                  </td>
                                  <td style="text-align:center;">
                                    @if($facturacions->f_electronica==1) <!-- Nombre del cliente -->
                                        <button class="btn btn-info btn-circle btn-ls"  data-toggle="tooltip" data-placement="bottom" title="Aceptada"><i class="fa fa-check-circle"></i></button>
                                        <span hidden>Aceptada</span>
                                        @if ($facturacions->nota_credito != 0 )
                                            @if ($nota_credito[$index]->n_electronica == 1)
                                                <button class="btn btn-info btn-circle btn-ls "  data-toggle="tooltip" data-placement="bottom" title="Nota de Credito:  Aceptada"><i style="font-weight: 700">NC</i></button>
                                            @else
                                                <button class="btn btn-warning btn-circle btn-ls "  data-toggle="tooltip" data-placement="bottom" title="Nota de Credito: En Espera"><i style="font-weight: 700">NC</i></button>
                                            @endif
                                            <span hidden>Nota de Credito</span>
                                        @endif
                                        @if ($facturacions->nota_debito != 0 )
                                            @if ($nota_debito[$index]->n_electronica == 1)
                                                <button class="btn btn-info btn-circle btn-ls "  data-toggle="tooltip" data-placement="bottom" title="Nota de Debito:  Aceptada"><i style="font-weight: 700">ND</i></button>
                                            @else
                                                <button class="btn btn-warning btn-circle btn-ls "  data-toggle="tooltip" data-placement="bottom" title="Nota de Debito: En Espera"><i style="font-weight: 700">ND</i></button>
                                            @endif
                                            <span hidden>Nota de Debito</span>
                                        @endif
                                    @elseif($facturacions->f_electronica==2)
                                        <button class="btn btn-danger btn-circle btn-ls" data-toggle="tooltip" data-placement="bottom" title="Anulada"><i class="fa fa-times-circle"></i></button>
                                        <span hidden>Anulada</span>
                                    @else
                                        <button class="btn btn-warning btn-circle btn-ls" data-toggle="tooltip" data-placement="bottom" title="En Espera"><i class="fa fa-check-circle"></i></button>
                                        <span hidden>En Espera</span>
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

{{-- ESTILOS --}}
<style type="text/css">
    .a{width: 200px}
    .nota_credit{
        /* background-color: red;
        border: red; */
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

<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- Page Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 15,
            order: [[0, "desc"]],
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });
</script>
@endsection
