@extends('layout')
@section('title', 'Nota Venta')
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
    <form action="{{ route('nota_venta.create')}}" id="alm_adm_{{$almacens->id}}" enctype="multipart/form-data" method="post">
        @csrf
        <input type="hidden" class="dropdown-item" name="almacen"  value="{{$almacens->id}}">
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
    <form id="myform1" action="{{ route('nota_venta.create')}}" enctype="multipart/form-data" method="post">
        @csrf
        <input type="text" value="{{$almacen_primero->id}}" hidden="hidden" name="almacen">
    </form>
    <form id="myform2" action="{{ route('nota_venta.create')}}" enctype="multipart/form-data" method="post">
        @csrf
        <input type="text"  hidden="hidden" name="almacen"  value="{{$user_login->almacen_id}}">
    </form>
</span>
<!-- modal -->
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
<div class="row">
    <div class="col-lg-12">
        <div id="modal-form" class="modal fade" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row" align="center">
                            <div class="col-sm-12 b-r"><h3 class="m-t-none m-b">Elegir Almacen</h3>
                            </div>
                            <!--FACTURA-->
                            <div class="col-sm-12">
                                {{-- @if($conteo_almacen==1) --}}

                                {{-- @else --}}
                                @if($user_login->name=='Administrador')
                                <div class="dropdown ">
                                  <button class="btn btn-sm btn-info" type="button" id="dropdownMenuButton" data-toggle="dropdown" >Factura</button>
                                  <div class="dropdown-menu"  aria-labelledby="dropdownMenuButton">
                                    @foreach($almacen as $almacens)
                                    <form action="{{ route('nota_venta.create')}}" enctype="multipart/form-data" method="post">
                                        @csrf
                                        <input type="hidden" class="dropdown-item" name="almacen"  value="{{$almacens->id}}">
                                        <input type="submit" class="dropdown-item" value="{{$almacens->nombre}}">
                                    </form>
                                    @endforeach
                                </div>
                            </div>
                            @elseif($user_login->name=='Colaborador')
                            <form action="{{ route('nota_venta.create')}}" enctype="multipart/form-data" method="post">
                                @csrf
                                <input type="text"  hidden="hidden" name="almacen"  value="{{$user_login->almacen_id}}">
                                <input type="submit" class="btn btn-sm btn-info"  value="Crear una cotizacion factura">
                            </form>
                            @endif
                            {{-- @endif --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</div>
{{-- fimodal --}}
<div class="wrapper wrapper-content animated fadeInRight">

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Codigo</th>
                                    <th>Almacen</th>
                                    <th>Fecha Emision</th>
                                    <th>Usuario Registrado</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($nota_venta as $nota_ventas)
                                <tr class="gradeX">
                                    <td>{{$nota_ventas->id}}</td>
                                    <td>{{$nota_ventas->cod_nota_venta}}</td>
                                    <td>{{$nota_ventas->almacen->nombre}}</td>
                                    <td>{{$nota_ventas->fecha_emision}}</td>
                                    <td>{{$nota_ventas->user->personal->nombres}}</td>
                                    <td><center><a href="{{route('nota_venta.show',$nota_ventas->id)}}"><button type="button" class="btn btn-success"><i class="fa fa-eye"></i></button></a></center></td>
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
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });
</script>
@endsection
