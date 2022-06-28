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
                                <th>Anular</th>
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
                            @if($servicio->estado_anular==1) <td>Anulado</td>
                            @else <td>Activo</td>@endif
                            <td>
                                @if($servicio->foto == "defecto.png" || $servicio->foto == "servicio.png" )
                                    <img src="{{ asset('/archivos/imagenes/servicios/servicio.png')}}" style="width: 45px;">    
                                @else
                                    <img src="{{ asset('/archivos/imagenes/servicios/')}}/{{$servicio->foto}}" style="width: 45px;">
                                @endif
                            </td>
                            <td><center><a href="{{ route('servicios.show', $servicio->id) }}" target="_blank"><button type="button" class="btn btn-s-m btn-primary"><i class="fa fa-eye"></i></button></a></center></td>
                            <td>
                                <center>
                                    {{-- <input type="hidden" name="servicio_id" id="servicio_id" value="{{$servicio->id}}"> --}}
                                    <input type="hidden" name="servicio_nombre_{{$servicio->id}}" id="servicio_nombre_{{$servicio->id}}" value="{{$servicio->nombre}}"/>
                                    @if($servicio->estado_anular == 1)
                                    <button type="button" class="btn btn-s-m btn-secondary">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                    @else
                                    <button type="button" class="btn btn-s-m btn-danger" onclick="abrir_modal( {{$servicio->id}} )">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
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

<div class="modal fade" id="servicio_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="margin-top: 12%; border-radius: 20px">
        <div class="modal-content" >
            <div class="modal-body" style="padding: 0px;">
                <div class="ibox-content float-e-margins">
                        <h3 class="font-bold col-lg-12" align="center">
                            ¿Esta Seguro que Deseas Anular el Servicio:<br><span id="serv_nombre"> </span>? <br>
                            <h4 align="center"> <strong>Nota: Una vez Anulado no hay opción de devolver la acción </strong></h4>
                        </h3>
                    <p align="center">
                        <form action="{{ route('servicios.destroy')}}" method="POST">
                            @csrf
                            <input type="hidden" name="id_servicio" id="serv_id_form" value="">
                            <center>
                                <button type="submit" class="btn btn-w-m btn-primary">Anular</button>
                            </center>
                        </form>
                    </p>
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
    function abrir_modal(a){
        // var nomb_id = 'servicio_nombre_'+id;
        var nombre = document.getElementById(`servicio_nombre_${a}`).value;
        document.getElementById(`serv_nombre`).innerHTML = nombre;
        document.getElementById(`serv_id_form`).value = a;
        // console.log(nombre);
        
        $('#servicio_modal').modal('show');
        
    }
</script>
@endsection