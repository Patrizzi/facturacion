@extends('layout')
@section('title', 'Tipo de cambio')

@if($consulta)
@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@else
@section('atributo_actu', 'hidden')
@section('href_accion', route('tipo_cambio.create'))
@section('value_accion', 'Agregar')
@endif

@section('content')
{{--
<div class="wrapper wrapper-content animated fadeInRight">
    @if(isset($error))
    <div>
      <div class="alert alert-danger">
        <div class="alert-link" href="#">
          <li style="color: red;">{{ $error }}</li>
      </div>
  </div>
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
                                <th>Item</th>
                                <th>Compra</th>
                                <th>Venta</th>
                                <th>Paralelo</th>
                                <th>Fecha de creacion</th>
                            </tr>
                        </thead>
                        <tbody>
                            <span hidden>{{$i=1}}</span>
                            @foreach($tipo_cambio as $tipo_cambios)
                            <tr class="gradeX">
                                <td>{{$i++}}</td>
                                <td>{{$tipo_cambios->compra}}</td>
                                <td>{{$tipo_cambios->venta}}</td>
                                <td>{{$tipo_cambios->paralelo}}</td>
                                <td>{{$tipo_cambios->created_at}}</td>
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
--}}
<div class="wrapper wrapper-content animated fadeInRight pb-0">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h4>Tipo de Cambio</h4>
                </div>
                <div class="ibox-content align-content-center">
                    <div class="row d-flex justify-content-around px-4 text-center">

                        <div class="col-auto">
                            <div class="border border-primary rounded-circle d-flex justify-content-center align-items-center circle-size">
                                <p class="m-0 p-4" style="font-size: 40px;"><i class="fa fa-file-text-o"></i></p>
                            </div><br>
                            <h4>Maximo de valor</h4>
                            <p> 13/03/2025</p>
                            <p class="text-primary"><b>S/***.**</b></p>
                        </div>
                        <div class="col-auto">
                            <div class="border border-success rounded-circle d-flex justify-content-center align-items-center circle-size">
                                <p class="m-0 p-4" style="font-size: 40px;"><i class="fa fa-file-text-o"></i></p>
                            </div><br>
                            <h4>Menor de valor</h4>
                            <p> 13/03/2025</p>
                            <p class="text-success"><b>S/***.**</b></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Base para agregar el tab para el los contenidos-->
<div class="wrapper wrapper-content animated fadeInRight pt-0">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-1"><span style="color: white; background-color: blue;" class="px-1">4</span> Tipo de Cambio
                                </a>
                            </li>
                        </ul>
                        <!-- Buscar y Botón agregar -->
                        <div class="py-2 d-flex align-items-center row-cols-12 pt-4 border-left border-right border-secondary-subtle" style="margin-left: 0.1px; margin-right: 0.1px;">
                            <div class="col-md-12 d-flex justify-content-md-start row-cols-12 py-2">
                                <div class="col-md-auto">
                                    <label for="inputBuscar" class="col-form-label">Buscar:</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="text" id="inputBuscar" class="form-control" aria-describedby="passwordHelpInline">
                                </div>
                                <div class="col-md-5">
                                    <button class="btn btn-primary" style="display: inline-block; margin-left: 10px;background-color:blue">Buscar</button>
                                </div>
                            </div>
                        </div>

                        <!-- Tablas y su contenido -->
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                <div class="panel-body table-responsive">
                                    <!-- CONTENIDO DENTRO DEL TAB - Boleta manual -->
                                    <table class="table table-striped text-md-center dataTables-tipo">
                                        <thead>
                                            <tr>
                                                <th>Item</th>
                                                <th>Compra</th>
                                                <th>Venta</th>
                                                <th>Paralelo C.</th>
                                                <th>Fecha Actualización</th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <span hidden>{{$i=1}}</span>
                                            @foreach($tipo_cambio as $tipo_cambios)
                                            <tr class="gradeX">
                                                <td>{{$i++}}</td>
                                                <td>{{$tipo_cambios->compra}}</td>
                                                <td>{{$tipo_cambios->venta}}</td>
                                                <td>{{$tipo_cambios->paralelo}}</td>
                                                <td>{{$tipo_cambios->created_at}}</td>
                                                <td>
                                                    <a data-toggle="modal" data-toggle="dropdown" class="fs-5" href="#editar"><i class="fa fa-edit text-primary"></i></a>
                                                </td>
                                                <div class="modal fade" id="editar" tabindex="-1" aria-labelledby="editar" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3 class="modal-title" id="editar">Editar</h3>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <!-- Modal Body -->
                                                            <div class="modal-body">
                                                                <form id="formNuevoUsuario">
                                                                    <div class="row mb-3">
                                                                        <strong for="Compra" class="col-sm-2 col-form-label fw-bold">Compra:</strong>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" class="form-control" id="Compra" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <strong for="Venta" class="col-sm-2 col-form-label fw-bold">Venta:</strong>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" class="form-control" id="Venta" autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <strong for="Paralelo" class="col-sm-2 col-form-label fw-bold">Paralelo:</strong>
                                                                        <div class="col-sm-10">
                                                                            <input type="text" class="form-control" id="Paralelo"  autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                    <div class="row mb-3">
                                                                        <strong for="Fecha" class="col-sm-2 col-form-label fw-bold">Fecha:</strong>
                                                                        <div class="col-sm-10">
                                                                            <input type="email" class="form-control" id="Fecha"  autocomplete="off">
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <!-- Modal Footer -->
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                                <button type="button" class="btn btn-primary" id="Guardar" style="background-color: blue;">Guardar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
    </div>
</div>

<style>
    .circle-size{
        min-height: 105px;
        min-width: 105px;
    }
    /* OCULTANDO LO DE ORGANIZAR*/
        /* Ver (números) */
        div.dataTables_length {
            display: none;
        }

        /* El Buscar */
        div.dataTables_filter {
            display: none;
        }

        /* CSV, Excel, PDF, Print */
        div.dt-buttons {
            display: none;
        }

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
        $('.dataTables-tipo').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [  ]
    });
    });
</script>
@endsection
