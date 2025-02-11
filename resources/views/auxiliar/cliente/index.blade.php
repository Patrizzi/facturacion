@extends('layout')

@section('title', 'Cliente')
@section('breadcrumb', 'Cliente')
@section('breadcrumb2', 'Cliente')
@section('data-toggle', 'modal')
@section('href_accion', '#ModalCliente')
@section('value_accion', 'Agregar')
@extends('layout_agregado_rapido')
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

@section('content')
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
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 13px" id="table_cliente" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Tipo Documento</th>
                                    <th>Nro Documento</th>
                                    <th>Correo</th>
                                    <th>Celular</th>
                                    <th>Ver</th>
                                </tr>
                            </thead>
                          {{--   <tbody>
                                @foreach($clientes as $cliente)
                                <tr class="gradeX">
                                    <td>{{$cliente->id}}</td>
                                    <td>{{$cliente->nombre}}</td>
                                    <td>{{$cliente->documento_identificacion}}</td>
                                    <td>{{$cliente->numero_documento}}</td>
                                    <td>{{$cliente->email}}</td>
                                    <td>{{$cliente->celular}}</td>
                                    <td><center><a href="{{ route('cliente.show', $cliente->id) }}" target="_blank"><button type="button" class="btn btn-s-m btn-primary">VER</button></a></center></td>
                                </tr>

                                @endforeach
                            </tbody> --}}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<tbody>
    {{--Base para agregar el tab para el los contenidos--}}
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
                            <li>
                                <a class="nav-link active show" data-toggle="tab" href="#tab-1"><span style="color: green;">&#9632; </span> CLIENTE
                                    {{-- link del tab 1 --}}
                                </a>
                            </li>
                            <li class="ml-auto">
                                <div class="btn-group mx-2">
                                    <div class="col-auto">
                                        <label for="inputBuscar" class="col-form-label">Buscar:</label>
                                    </div>
                                    <div class="col-md-7">
                                        <input type="text" id="inputBuscar" class="form-control" aria-describedby="passwordHelpInline">
                                    </div>
                                    <!-- Botón para abrir el modal -->
                                    <div class="btn-group mx-0"> <!-- Cambia mx-2 a mx-0 -->
                                        <button type="button" class="btn btn-default btn-sm bg-primary" style="color: white;" data-toggle="modal" data-target="#myModal">Agregar</button></div>
                                </div>
                            </li>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel"  style="color: blue; font-size: 18px; font-weight: bold;">Agregar nueva categoría</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 mb-3">
                            <div style="display: flex; justify-content: center; align-items: center;">
                                <img src="http://127.0.0.1:8000/img/logos/categoria.svg" width="100px" style="margin-right: 10px;">
                                <label for="descripcion" class="form-label" style="color: rgb(0, 0, 0); font-size: 18px; font-weight: bold;">Descripción:</label>
                            </div>
                            <textarea class="form-control" id="descripcion" rows="1" style="margin-top: 10px;"></textarea> <!-- Agrega margen superior -->
                        </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Bootstrap CSS y JS -->
</li>
</ul>
<!-- Tablas y su contenido -->
<div class="tab-content">
    <div role="tabpanel" id="tab-1" class="tab-pane active show">
        <div class="panel-body">
            <!-- CONTENIDO DENTRO DEL TAB  -->
            <table class="table table-striped text-md-center">
                <thead>
                    <tr>
                        <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>
                        <th >ID</th>
                        <th >Nombre</th>
                        <th >Tipo Documento</th>
                        <th>Nro Documento</th>
                        <th>Correo</th>
                        <th>Celular</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>
                    <td>1</td>
                    <td>Sr soluciones sac</S></td>
                    <td>RUC</td>
                    <td>20545122551</td>
                    <td>julioflores@srsc.com</td>
                    <td>946201443</td>
                    <td>
                        <!-- Botón para abrir el modal -->
                    <div>
                        <button style="display:inline-block; padding:10px; background-color:green; border-radius:5px; margin-right:2px; border:none;">
                            <i class="fa fa-eye" style="color:white;"></i>
                        </button>
                        <a href="#"
                        style="display:inline-block; padding:10px; background-color:blue; border-radius:5px; margin-right:2px;"
                        data-toggle="modal"
                        data-target="#modaluno"> <!-- Cambiado a modaluno -->
                            <i class="fa fa-edit" style="color:white;"></i>
                        </a>
                        <button style="display:inline-block; padding:10px; background-color:green; border-radius:66px; margin-right:2px; border:none;">
                            <i class="fa fa-check" style="color:white;"></i>
                        </button></div>
                    </td>

                    <!-- Modal -->
                    <div class="modal fade" id="modaluno" tabindex="-1" aria-labelledby="modalunoLabel" aria-hidden="true"> <!-- Cambiado a modaluno -->
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalunoLabel" style="color: blue; font-size: 18px; font-weight: bold;">Editar Categoría</h5> <!-- Cambiado a "Editar Categoría" -->
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-md-12 mb-3">
                                        <div style="display: flex; justify-content: center; align-items: center;">
                                            <img src="http://127.0.0.1:8000/img/logos/categoria.svg" width="100px" style="margin-right: 10px;">
                                            <label for="descripcion" class="form-label" style="color: rgb(0, 0, 0); font-size: 18px; font-weight: bold;">Descripción:</label>
                                        </div>
                                        <textarea class="form-control" id="descripcion" rows="1" style="margin-top: 10px;"></textarea> <!-- Agrega margen superior -->
                                    </div>
                                    <div class="modal-footer" style="display: flex; justify-content: space-between; align-items: center;">
                                        <div style="position: relative;">
                                            <label>
                                                <input type="checkbox" id="toggleSwitch">
                                                Activar/Desactivar
                                            </label>
                                        </div>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-primary">Guardar cambios</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </td>
        </tr>
    <tr>
                    <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>
                    <td>2</td>
                    <td>Susana baca</td>
                    <td>DNI</td>
                    <td>47878758</td>
                    <td>notiene@correo.com</td>
                    <td>987789985</td>
                    <td>
                        <div>
                            <button style="display:inline-block; padding:10px; background-color:green; border-radius:5px; margin-right:2px; border:none;">
                                <i class="fa fa-eye" style="color:white;"></i>
                            </button>
                            <a href="#"
                        style="display:inline-block; padding:10px; background-color:blue; border-radius:5px; margin-right:2px;"
                        data-toggle="modal"
                        data-target="#modaldos"> <!-- Cambiado a modaldos -->
                            <i class="fa fa-edit" style="color:white;"></i>
                        </a>
                        <button style="display:inline-block; padding:10px; background-color:green; border-radius:66px; margin-right:2px; border:none;">
                            <i class="fa fa-check" style="color:white;"></i>
                        </button></div>
                    </td>
                    <!-- Modal -->
                    <div class="modal fade" id="modaldos" tabindex="-1" aria-labelledby="modaldosLabel" aria-hidden="true"> <!-- Cambiado a modaldos -->
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modaldosLabel" style="color: blue; font-size: 18px; font-weight: bold;">Editar Categoría</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-md-12 mb-3">
                                        <div style="display: flex; justify-content: center; align-items: center;">
                                            <img src="http://127.0.0.1:8000/img/logos/categoria.svg" width="100px" style="margin-right: 10px;">
                                            <label for="descripcion" class="form-label" style="color: rgb(0, 0, 0); font-size: 18px; font-weight: bold;">Descripción:</label>
                                        </div>
                                        <textarea class="form-control" id="descripcion" rows="1" style="margin-top: 10px;"></textarea> <!-- Agrega margen superior -->
                                    </div>
                                    <div class="modal-footer" style="display: flex; justify-content: space-between; align-items: center;">
                                        <div style="position: relative;">
                                            <label>
                                                <input type="checkbox" id="toggleSwitch">
                                                Activar/Desactivar
                                            </label>
                                        </div>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-primary">Guardar cambios</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </tr>
                    <th><input class="check_all_remi" type="checkbox" style="transform: scale(1.5); -webkit-transform: scale(1.5);"></th>
                    <td>3</td>
                    <td>Kepler Ramirez</td>
                    <td>DNI</td>
                    <td>00000000</td>
                    <td>zona0protm@gmail.com</td>
                    <td>994170533</td>
                    <td>
                        <div>
                            <button style="display:inline-block; padding:10px; background-color:green; border-radius:5px; margin-right:2px; border:none;">
                                <i class="fa fa-eye" style="color:white;"></i>
                            </button>
                            <a href="#"
                        style="display:inline-block; padding:10px; background-color:blue; border-radius:5px; margin-right:2px;"
                        data-toggle="modal"
                        data-target="#modaldos"> <!-- Cambiado a modaldos -->
                            <i class="fa fa-edit" style="color:white;"></i>
                        </a>
                        <button style="display:inline-block; padding:10px; background-color:red; border-radius:66px; border:none; cursor:pointer;">
                            <i class="fa fa-arrows-alt" style="color:white;"></i>
                        </button></div>
                    </td>
                    <!-- Modal -->
                    <div class="modal fade" id="modaltres" tabindex="-1" aria-labelledby="modaltresLabel" aria-hidden="true"> <!-- Cambiado a modaltres -->
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modaltresLabel" style="color: blue; font-size: 18px; font-weight: bold;">Editar categoría</h5> <!-- Cambiado a "Editar categoría" -->
                                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="col-md-12 mb-3">
                                        <div style="display: flex; justify-content: center; align-items: center;">
                                            <img src="http://127.0.0.1:8000/img/logos/categoria.svg" width="100px" style="margin-right: 10px;">
                                            <label for="descripcion" class="form-label" style="color: rgb(0, 0, 0); font-size: 18px; font-weight: bold;">Descripción:</label>
                                        </div>
                                        <textarea class="form-control" id="descripcion" rows="1" style="margin-top: 10px;"></textarea> <!-- Agrega margen superior -->
                                    </div>
                                    <div class="modal-footer" style="display: flex; justify-content: space-between; align-items: center;">
                                        <div style="position: relative;">
                                            <label>
                                                <input type="checkbox" id="toggleSwitch">
                                                Activar/Desactivar
                                            </label>
                                        </div>
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-primary">Guardar cambios</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </tbody>
        </table>
</div>
</div>
        </div>
    </div>
    <div role="tabpanel" id="tab-2" class="tab-pane">
        <div class="panel-body">
</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</tbody>



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

<!-- Jquery Validate -->
<script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>

<!-- Steps -->
<script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>
{{-- scritp de modal agregar --}}

    <!-- Page-Level Scripts -->
<script>
$(document).ready(function(){
    $('#table_cliente').DataTable({
        "serverSide":true,
        "ajax":"{{url('api/clientes')}}",
        "columns":[
            {data : 'id'},
            {data : 'nombre'},
            {data : 'documento_identificacion'},
            {data : 'numero_documento'},
            {data : 'email'},
            {data : 'celular'},
            {
                name: '',
                data: null,
                sortable: false,
                searchable: false,
                render: function (data) {
                    var actions = '';
                    actions += '<a href="{{ route('cliente.show',':id') }}" target="_blank"><span class="btn btn-success" >VER</span></a>';
                    return actions.replace(/:id/g, data.id);
                }
            }
        ]
    });
});

</script>


    @endsection
