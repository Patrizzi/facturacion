@extends('layout')

@section('title', 'Guia de Remision Manual')
@section('breadcrumb', 'Guia de Remision Manual')
@section('breadcrumb2', 'Guia de Remision Manual')
@section('href_accion', route('guia_remision_manual.create'))
@section('value_accion', 'Agregar')

@section('content')
@if($valor_error == 1)
<div class="alert alert-danger" style="margin-top: 10px;margin-bottom: 0px;">
    <a class="alert-link" href="../vehiculos">
        <li class="error" style="color: red">{{ $message }}</li>
    </a>
</div>
@endif
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Lista de Guias R. Manual</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Codigo de Guia</th>
                                    <th>Cliente</th>
                                    <th>Ruc/DNI</th>
                                    <th>Fecha emision</th>
                                    <th>Ver</th>
                                    <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($guia_remision as $guias_remision)
                                <tr class="gradeX">
                                    <td>{{$guias_remision->id}}</td>
                                    <td>{{$guias_remision->cod_guia}}</td>
                                    <td>{{$guias_remision->cliente->nombre}}</td>
                                    <td>{{$guias_remision->cliente->numero_documento}}</td>
                                    <td>{{$guias_remision->fecha_emision}}</td>
                                    <td>
                                        <center>
                                            <a href="{{route('guia_remision_manual.show' , $guias_remision->id)}}"><button type="button" class="btn btn-w-m btn-primary">VER</button></a>
                                        </center>
                                    </td>
                                    <td style="text-align:center;">
                                        @if($guias_remision->g_electronica==1) <!-- Nombre del cliente -->
                                            <button class="btn btn-info btn-circle btn-ls"  data-toggle="tooltip" data-placement="bottom" title="Aceptada"><i class="fa fa-check-circle"></i></button>
                                            <span hidden>Aceptada</span>
                                        @elseif($guias_remision->g_electronica==2)
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
    var clic = 1;
    function divAuto(){
       if(clic==1){
           document.getElementById("div-mostrar").style.height = "50px";
           document.getElementById("texto").style.opacity = "1";
           clic = clic + 1;
       } else{
        document.getElementById("div-mostrar").style.height = "0px";
        document.getElementById("texto").style.opacity = "0";

        clic = 1;
    }
}
</script>
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
@endsection