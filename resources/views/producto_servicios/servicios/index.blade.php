@extends('layout')
@section('atributo_actu', 'hidden')
@section('title', 'Servicios')
@section('value_accion', 'Agregar')
@section('href_accion', route('servicios.create'))

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                            <tr><!--
                                <th>COD. GENERAL</th> -->
                                <th>N° Registro</th>
                                <th>Código Servicio</th>
                                <th>Código Original</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Estado</th>
                                <th>Foto</th>
                                <th>Ver</th>
                            </tr>
                        </thead>
                        <tbody>
                         @foreach($servicios as $servicio)
                         <tr class="gradeX">
                            <td>{{$servicio->id}}</td>
                            <td>{{$servicio->codigo_servicio}}</td>
                            <td>{{$servicio->codigo_original}}</td>
                            <td>{{$servicio->nombre}}</td>
                            <td>{{$servicio->categoria}}</td>
                            @if($servicio->estado_activo==0) <td>Activo</td>
                            @else <td>Desactivo</td>@endif
                            <td><img src="
                                {{ asset('/archivos/imagenes/servicios/')}}/{{$servicio->foto}}" style="width: 45px;">
                            </td>
                            <td><center><a href="{{ route('servicios.show', $servicio->id) }}" target="_blank"><button type="button" class="btn btn-s-m btn-primary"><i class="fa fa-eye"></i></button></a></center></td>
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
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });

</script>
@endsection