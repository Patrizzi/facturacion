@extends('layout')
@section('title', 'Facturacion2')
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
                <input type="text" value="{{$almacen_primero->id}}" hidden="hidden" name="almacen">
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
                                    <th>Codigo de Factura</th>
                                    <th>Cliente</th>
                                    <th>Ruc/DNI</th>
                                    <th>Fecha Vencimiento</th>
                                    <th>Ver</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($facturacion as $facturacions)
                                <tr class="gradeX">
                                    <td>{{$facturacions->id}}</td>
                                    <td>{{$facturacions->codigo_fac}}</td>


                                    @if(isset($facturacions->cliente_id)) <!-- Nombre del cliente -->
                                    <td>{{$facturacions->cliente->nombre}}</td>
                                    @else
                                    <td>{{$facturacions->cotizacion->cliente->nombre}}</td>
                                    @endif

                                    @if(isset($facturacions->cliente_id))<!-- documento del cliente -->
                                    <td>{{$facturacions->cliente->numero_documento}}</td>
                                    @else
                                    <td>{{$facturacions->cotizacion->cliente->numero_documento}}</td>
                                    @endif

                                    <td>{{$facturacions->fecha_vencimiento }}</td>
                                    <td>
                                        @if($facturacions->tipo=='servicio')
                                        <a href="{{route('facturacion_servicio.show',$facturacions->id)}}">
                                          <button type="button" class="btn btn-success"><i class="fa fa-eye"></i></button>
                                      </a>
                                      @elseif($facturacions->tipo=='producto')
                                      <a href="{{route('facturacion.show',$facturacions->id)}}">
                                        <button type="button" class="btn btn-success"><i class="fa fa-eye"></i></button>
                                    </a>
                                    @endif

                                </center>
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
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });
</script>
@endsection
