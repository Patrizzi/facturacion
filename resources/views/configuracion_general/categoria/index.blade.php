@extends('layout')

@section('title', 'Categoría')
@section('data-toggle', 'modal')
@section('href_accion', '#exampleModal')
@section('value_accion', 'Agregar')
@section('content')
@section('button2', 'Atrás')
@section('config',route('Configuracion'))

<!-- Modal Create  -->
@if($errors->any())
<div class="alert alert-danger" style="margin-top: 10px;margin-bottom: 0px;">
    <a class="alert-link" href="#">
        @foreach ($errors->all() as $error)
        <li class="error" style="color: red">{{ $error }}</li>
        @endforeach
    </a>
</div>
@endif
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                    <form action="{{ route('categoria.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
                        @csrf
                        <div>
                            <div class="panel-body" >
                                <div class="row">
                                    <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/categoria.svg')}}" width="100px"></div>
                                    <label class="col-sm-2 col-form-label">Descripción:</label>
                                    <div class="col-sm-10"> <input type="text" class="form-control" name="descripcion" required> </div>
                                </div>
                            </div>
                        </div>
                        <button class="ladda-button btn btn-primary" type="submit" id="boton">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- / Modal Create  -->

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
                                    <th>Código</th>
                                    <th>Descripción</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categorias as $categoria)
                                <tr class="gradeX">
                                    <td>@if($categoria->estado==0) <i class="fa fa-circle" style="color: green;"></i>@else
                                       <i class="fa fa-circle"></i>@endif {{$categoria->id}}</td>
                                       <td>{{$categoria->codigo}}</td>
                                       <td>{{$categoria->descripcion}}</td>
                                       <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$categoria->id}}"><i class="fa fa-edit"></i></button>
                                        <div class="modal fade" id="exampleModal{{$categoria->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div style="padding-left: 15px;padding-right: 15px;">
                                                        {{-- ccccccccccccccccc --}}
                                                        <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                                                            <form action="{{ route('categoria.update',$categoria->id) }}"  enctype="multipart/form-data" method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                <fieldset >
                                                                    <div>
                                                                        <div class="panel-body" >
                                                                            <div class="row">
                                                                             <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{asset('img/logos/categoria.svg')}}" width="100px"></div>
                                                                             <label class="col-sm-3 col-form-label">Descripcion:</label>
                                                                             <div class="col-sm-9">
                                                                                <input type="text" class="form-control" readonly="readonly" value="{{$categoria->descripcion}}">
                                                                            </div>
                                                                            @if($conteo > 1 || $categoria->estado==1 )
                                                                            <div class="col-sm-12" align="center" style="padding-top: 10px">
                                                                             <input type="checkbox" class="js-switch_{{$categoria->id}}" name="estado"  @if($categoria->estado==0) checked="" @endif />
                                                                         </div>
                                                                         @endif
                                                                     </div>
                                                                 </div>
                                                             </div>
                                                         </fieldset>
                                                         <button class="ladda-button btn btn-primary" type="submit" >Grabar</button>
                                                     </form>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <!-- / Modal Create  -->

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
                                <a class="nav-link active show" data-toggle="tab" href="#tab-1"><span style="color: green;">&#9632; </span> CATEGORIA
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
                                        <button type="button" class="btn btn-default btn-sm bg-primary" style="color: white;" data-bs-toggle="modal" data-bs-target="#myModal">Agregar</button>                                    </div>
                                </div>
                            </li>
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel"  style="color: blue; font-size: 18px; font-weight: bold;">Agregar nueva categoría</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Bootstrap CSS y JS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
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
                        <th><div class="icheckbox_square-green checked" style="position: relative;"><input type="checkbox" checked="" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></th>
                        <th >ID</th>
                        <th >Código</th>
                        <th >Descripción</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
                    <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                    <td>1</td>
                    <td>0001</td>
                    <td>PRODUCTOS</td>
                    <td>
                        <!-- Botón para abrir el modal -->
                        <a href="#" 
                           style="display:inline-block; padding:10px; background-color:blue; border-radius:5px; margin-right:2px;" 
                           data-bs-toggle="modal" 
                           data-bs-target="#modaluno"> <!-- Cambiado a modaluno -->
                            <i class="fa fa-edit" style="color:white;"></i>
                        </a>
                    </td>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="modaluno" tabindex="-1" aria-labelledby="modalunoLabel" aria-hidden="true"> <!-- Cambiado a modaluno -->
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modalunoLabel" style="color: blue; font-size: 18px; font-weight: bold;">Editar Categoría</h5> <!-- Cambiado a "Editar Categoría" -->
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-primary">Guardar cambios</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
            </td>
        </tr>
    <tr>
                    <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                    <td>2</td>
                    <td>0002</td>
                    <td>GARANTIAS</td>
                    <td>  
                        <a href="#" 
                           style="display:inline-block; padding:10px; background-color:blue; border-radius:5px; margin-right:2px;" 
                           data-bs-toggle="modal" 
                           data-bs-target="#modaldos"> <!-- Cambiado a modaldos -->
                            <i class="fa fa-edit" style="color:white;"></i>
                        </a>
                    </td>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="modaldos" tabindex="-1" aria-labelledby="modaldosLabel" aria-hidden="true"> <!-- Cambiado a modaldos -->
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modaldosLabel" style="color: blue; font-size: 18px; font-weight: bold;">Editar Categoría</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-primary">Guardar cambios</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </tr>
                    <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                    <td>3</td>
                    <td>0001</td>
                    <td>SERVICIOS</td>
                    <td>
                        <a href="#" 
                           style="display:inline-block; padding:10px; background-color: blue; border-radius:5px; margin-right:2px;" 
                           data-bs-toggle="modal" 
                           data-bs-target="#modaltres"> <!-- Cambiado a modaltres -->
                            <i class="fa fa-edit" style="color:white;"></i>
                        </a>
                    </td>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="modaltres" tabindex="-1" aria-labelledby="modaltresLabel" aria-hidden="true"> <!-- Cambiado a modaltres -->
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="modaltresLabel" style="color: blue; font-size: 18px; font-weight: bold;">Editar categoría</h5> <!-- Cambiado a "Editar categoría" -->
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
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

<!-- Switchery -->
<link href="{{asset('css/plugins/switchery/switchery.css')}}" rel="stylesheet">
<script src="{{asset('js/plugins/switchery/switchery.js')}}"></script>
@foreach($categorias as $categoria)
<script>
    var elem_2 = document.querySelector('.js-switch_{{$categoria->id}}');
    var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });
</script>
@endforeach
@foreach($categorias as $categoria)
<script>
    var elem_2 = document.querySelector('.js-switch_vehiculo{{$categoria->id}}');
    var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });
</script>
@endforeach

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

