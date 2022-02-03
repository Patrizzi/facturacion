@extends('layout')
@section('title', 'Boleta')
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
    <form action="{{ route('boleta.create')}}" id="alm_adm_{{$almacens->id}}" enctype="multipart/form-data" method="post">
        @csrf
        <input type="text" value="{{$almacens->id}}" hidden="hidden" name="almacen">
    </form>
    <script>
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
    <form id="myform1" action="{{ route('boleta.create')}}" enctype="multipart/form-data" method="post">
        @csrf
        <input type="text" value="{{$almacen_primero->id}}" hidden="hidden" name="almacen">
    </form>
    <form id="myform2" action="{{ route('boleta.create')}}" enctype="multipart/form-data" method="post">
        @csrf
        <input type="text"  hidden="hidden" name="almacen"  value="{{$user_login->almacen_id}}">
    </form>
</span>
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
<div class="wrapper wrapper-content animated fadeInRight">
    @if (session('repite'))
    <div class="alert alert-danger">
        {{ session('repite') }}
    </div>
    @endif
    <div class="row">

        <div class="col-lg-12">
            <div class="ibox ">

                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Codigo de Boleta</th>
                                    <th>Cliente </th>
                                    <th>Ruc/DNI</th>
                                    <th>Fecha Vencimiento</th>
                                    <th></th>
                                    <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($boletas as $boleta)
                                <tr class="gradeX">
                                    <td>{{$boleta->id}}</td>
                                    <td>{{$boleta->codigo_boleta}}</td>
                                    @if(isset($boleta->cliente_id)) <!-- Nombre del cliente -->
                                    <td>{{$boleta->cliente->nombre}}</td>
                                    @else
                                    <td>{{$boleta->cotizacion->cliente->nombre}}</td>
                                    @endif
                                    @if(isset($boleta->cliente_id))<!-- documento del cliente -->
                                    <td>{{$boleta->cliente->numero_documento}}</td>
                                    @else
                                    <td>{{$boleta->cotizacion->cliente->numero_documento}}</td>
                                    @endif
                                    <td>{{$boleta->fecha_vencimiento }}</td>
                                    <td style="text-align:center">
                                        <a href="{{route('boleta.show',$boleta->id)}}"><button type="button" class="btn btn-success"><i class="fa fa-eye"></i></button></a>
                                    </td>
                                    <td style="text-align:center">
                                        @if($boleta->b_electronica=='1')
                                        <button class="btn btn-info btn-circle btn-ls"><i class="fa fa-check-circle"></i></button>
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


<style type="text/css">
    .a{width: 200px}
</style>



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
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });
</script>
@endsection
