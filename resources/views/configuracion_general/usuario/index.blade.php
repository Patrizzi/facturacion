@extends('layout')
@section('title', 'Usuario')
@section('href_accion', route('usuario.lista'))
@section('value_accion', 'Agregar')
@section('button2', 'Atras')
@section('config',route('Configuracion'))
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    @if($errors->any())
    <div style="padding-top: 20px;">
     <div class="alert alert-danger">
        <a class="alert-link" href="#">
          @foreach ($errors->all() as $error)
          <li class="error">{{ $error }}</li>
          @endforeach
      </a>
  </div>
</div>
@endif
@if(isset($errores))
<div>
  <div class="alert alert-danger">
    <div class="alert-link" href="#">
      <li style="color: red;">{{ $errores }}</li>
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
                                <th>ID</th>
                                <th>Personal</th>
                                <th>Cargo</th>
                                <th>Correo</th>
                                <th>Celular</th>
                                <th>Almacen Asignado</th>
                                <th>Activo/desactivo</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <span hidden>{{$i=1}}</span>
                            @foreach($usuarios as $usuario)
                            <tr class="gradeX">
                                <td>{{$i++}}</td>
                                <td>{{$usuario->personal->nombres}}</td>
                                <td>{{$usuario->name}}</td>
                                <td>{{$usuario->email}}</td>
                                <td>{{$usuario->celular}}</td>
                                <td>{{$usuario->almacen->nombre}}</td>
                                @if($usuario->estado == 1)
                                <td>Activo</td>
                                @elseif($usuario->estado == 0)
                                <td>Desactivo</td>
                                @endif
                                @if($usuario->estado_validacion == 1)
                                <td>
                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$usuario->id}}">Editar</button> <i class="fa fa-check" aria-hidden="true"></i>
                                    <div class="modal fade" id="exampleModal{{$usuario->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div style="padding-left: 15px;padding-right: 15px;">
                                                    {{-- ccccccccccccccccc --}}
                                                    <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">
                                                        <form action="{{ route('usuario.update',$usuario->id) }}"  enctype="multipart/form-data" method="post">
                                                            @csrf
                                                            @method('PATCH')
                                                                    <img src=" {{ asset('/profile/images/')}}/{{$usuario->avatar}}" style="width: 200px;height: 200px;  border-radius: 5px">
                                                                <p style="font-size: 15px">{{$usuario->name}}</p>
                                                                <div>
                                                                    <div class="panel-body" >
                                                                        <div class="row">
                                                                            <label class="col-sm-3 col-form-label">Correo:</label>
                                                                            <div class="col-sm-9"><input type="text" class="form-control" name="correo" value="{{$usuario->email}}"></div>

                                                                            <label class="col-sm-3 col-form-label">Almacen Asignado:</label>
                                                                            <div class="col-sm-4">
                                                                                <select class="form-control" name="almacen_id">
                                                                                    <option value="{{$usuario->almacen->id}}">{{$usuario->almacen->nombre}}</option>
                                                                                    <option value="" disabled="">-------------</option>
                                                                                    @foreach($almacen as $almacens)
                                                                                    <option value="{{$almacens->id}}">{{$almacens->nombre}}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>

                                                                            <label class="col-sm-1 col-form-label">Desactivado</label>
                                                                            <div class="col-sm-2">
                                                                                @if($usuario->estado == 1)
                                                                                <div class="switch-button">
                                                                                    <input type="checkbox" name="estado" id="switch-label{{$usuario->id}}" class="switch-button__checkbox" checked="">
                                                                                    <label for="switch-label{{$usuario->id}}" class="switch-button__label"></label>
                                                                                </div>
                                                                                @else
                                                                                <div class="switch-button">
                                                                                    <input type="checkbox" name="estado" id="aswitch-label{{$usuario->id}}" class="switch-button__checkbox" >
                                                                                    <label for="aswitch-label{{$usuario->id}}" class="switch-button__label"></label>
                                                                                </div>
                                                                                @endif

                                                                            </div>
                                                                            <label class="col-sm-2 col-form-label">Activado:</label>
                                                                            <div class="col-sm-12">
                                                                                {{-- Boton 2do modal --}}
                                                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#2do_modal{{$usuario->id}}">Guardar</button>
                                                                                <div class="modal fade" id="2do_modal{{$usuario->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                                    <div class="modal-dialog" role="document">
                                                                                        <div class="modal-content">
                                                                                            <div class="modal-header">
                                                                                                <h5 class="modal-title" id="exampleModalLabel"> Confirmar Contraseña para Realizar Cambios</h5>
                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                    <span aria-hidden="true">&times;</span>
                                                                                                </button>
                                                                                            </div>
                                                                                            <div style="padding-left: 15px;padding-right: 15px;">
                                                                                                {{-- ccccccccccccccccc --}}
                                                                                                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">
                                                                                                    <fieldset >
                                                                                                        <div>
                                                                                                            <div class="panel-body" >
                                                                                                                <div class="row">
                                                                                                                    <label class="col-sm-3 col-form-label">Contraseña Usuario:</label>
                                                                                                                    <div class="col-sm-9">
                                                                                                                        <input required="required" type="password" class="form-control" name="contrasena_confirmar" placeholder="******" autocomplete="off">
                                                                                                                        <input type="text" name="contrasena_adm" value="{{auth()->user()->password}}" hidden="">
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>

                                                                                                    </fieldset>
                                                                                                    <button class="btn btn-primary" type="submit">Guardar</button>
                                                                                                    {{--   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- / Modal Create  -->


                                                                                {{--  --}}
                                                                                {{-- <button class="btn btn-primary" type="submit">Grabar</button> --}}
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </fieldset>

                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- / Modal Create  -->

                    </td>
                    @elseif($usuario->estado_validacion == 0)
                    <td>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{$usuario->id}}">Editar</button> <i class="fa fa-times" aria-hidden="true"></i>
                        <div class="modal fade" id="exampleModal{{$usuario->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content" style="width: 550px">
                                    <div style="padding-left: 15px;padding-right: 15px;">
                                        {{-- ccccccccccccccccc --}}
                                        <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">

                                            <form action="{{ route('usuario.envio_codigo',$usuario->id) }}"  enctype="multipart/form-data" method="post">
                                                @csrf
                                                <fieldset >
                                                    <legend style="height: 240px;"> <img src="
                                                        {{ asset('/profile/images/')}}/{{$usuario->avatar}}" style="width: 200px;height: 200px;border-radius: 5px"> <br>{{$usuario->personal->nombres}} {{$usuario->personal->apellidos}}
                                                        <p style="font-size: 15px">{{$usuario->name}}</p></legend>
                                                        <div>
                                                            <div class="panel-body" >
                                                                <div class="row">
                                                                    <label class="col-sm-3 col-form-label">Correo:</label>
                                                                    <div class="col-sm-6"><input type="text" class="form-control" name="correo" value="{{$usuario->email}}"></div>
                                                                    <div class="col-sm-3" style="padding-bottom: 15px"> <input type="submit" name="accion" class="btn btn-s-m btn-info" value="Cambiar Correo"></div>
                                                                    <label class="col-sm-3 col-form-label">Codigo de Confirmacion:</label>
                                                                    <div class="col-sm-3"><input type="text" class="form-control" name="cod_1" maxlength="3"></div>
                                                                    <div class="col-sm-3"><input type="text" class="form-control" name="cod_2"  maxlength="3"></div>
                                                                    <div class="col-sm-3"><input type="text" class="form-control" name="cod_3"  maxlength="3"></div>

                                                                    <div class="col-sm-12">
                                                                        <p>No me ha llegado el Codigo de confirmacion<input type="submit" name="accion" class="reenviar"  value="Reenviar Codigo" style="border: none;background: #ff000000;"> </p>
                                                                    </div>
                                                                    <div class="col-sm-12">
                                                                     <input type="submit" name="accion" class="btn btn-s-m btn-info" value="Validar">
                                                                 </div>
                                                             </div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>

                                         </fieldset>

                                     </form>
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <!-- / Modal Create  -->

             </td>
             @endif


         </tr>
         @endforeach
     </tbody>
 </table>
</div>
<!-- Sección de USUARIO------------------------------------------------------------------------------------------------------------------------- -->
<div class="tab-pane active">
    <!-- Título centrado -->
    <h2 style="text-align: center; margin-bottom: 20px;">USUARIO</h2>
    <div class="panel-body">
        <!-- Contenido de Nested Tab 1 -->
        <div class="search-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <!-- Barra de búsqueda y botón Buscar -->
            <div style="flex-grow: 1;">
                <input type="text" class="form-control" placeholder="Buscar..." style="width: 50%; display: inline-block;">
                <button class="btn btn-primary" style="display: inline-block; margin-left: 10px;">Buscar</button>
            </div>

            <!-- Botones Agregar, Actualizar y Descarga -->
            <div>
                <button class="btn btn-success" id="btn-agregar" onclick="toggleForm()" style="margin-right: 10px;">Agregar</button>
            </div>
        </div>
        <br>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>ID </th>
                    <th>PERSONAL </th>
                    <th>CARGO </th>
                    <th>CORREO</th>
                    <th>CELULAR</th>
                    <th>ALMACEN ASIGNADO</th>
                    <td>ACCIONES</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>01</td>
                    <td>FABRICIO</td>
                    <td>PRACTICANTE</td>
                    <td>SMITELEVELUP632@GMAIL.COM</td>
                    <td>983719672</td>
                    <td>GSO@CENTRAL</td>
                    <td>
                        <div>
                            <button style="padding: 5px 5px; background-color: #007bff;border: none; border-radius: 5px;">
                                <div class="infont col-md-3 col-sm-4"><a href="#"><i class="fa fa-check" style="color: white"></i></a></div>
                            </button>
                            <button style="padding: 5PX 5px; border: none; border-radius: 5px;">
                                <a class="btn  btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-edit" style="color: white"></i>  </a>
                            </button>
                        </div>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
        <br>
        <div class="btn-group">
            <button type="button" class="btn btn-white"><i class="fa fa-chevron-left"></i></button>
            <button class="btn btn-white">1</button>
            <button class="btn btn-white  active">2</button>
            <button class="btn btn-white">3</button>
            <button class="btn btn-white">4</button>
            <button type="button" class="btn btn-white"><i class="fa fa-chevron-right"></i> </button>
        </div>
    </div>
    <!-- Formulario oculto -->
    <div id="form-container" class="form-container" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; border: 1px solid #ccc; padding: 20px; border-radius: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); z-index: 1000;">
        <div class="modal-content">
            <h2>NUEVO USUARIO</h2>

            <div class="button-container" style="display: flex; justify-content: space-between; margin-bottom: 20px;">
                <button id="btn-descargar" class="blue-button" style="background-color: blue; color: white; border: none; border-radius: 5px; padding: 10px; cursor: pointer; flex: 1; margin-right: 5px;">Descargar</button>
                <button id="btn-agregar-form" class="blue-button" style="background-color: blue; color: white; border: none; border-radius: 5px; padding: 10px; cursor: pointer; flex: 1;">Agregar</button>
            </div>

            <div class="form-fields" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-top: 20px; text-align: left;">
                <div style=" flex-direction: column;">
                    <label for="id" style="display: block;">ID:</label>
                    <input type="text" id="id" placeholder="Ingrese ID" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

                    <label for="personal" style="display: block;">PERSONAL:</label>
                    <input type="text" id="personal" placeholder="Ingrese nombre personal" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

                    <label for="activar" style="display: block;">ACTIVAR:</label>
                    <input type="checkbox" id="activar" style="margin-top: 10px;">
                </div>

                <div style="flex-direction: column;">
                    <label for="busqueda" style="display: block;">BÚSQUEDA:</label>
                    <input type="text" id="busqueda" placeholder="Buscar..." style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

                    <label for="nombre" style="display: block;">NOMBRE:</label>
                    <input type="text" id="nombre" placeholder="Ingrese nombre" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

                    <label for="correo" style="display: block;">CORREO:</label>
                    <input type="email" id="correo" placeholder="Ingrese correo" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>
            </div>
        </div>
    </div>
</div>
<br>
</div>
</div>
</div>
</div>
</div>

<style>
    .reenviar{transition: 0.2s;color: #f72f2f}
    .reenviar:hover{color: #676a6c}
    .col-sm-9{padding-bottom: 15px}
    .form-control{border-radius: 5px}
    :root {
        --color-button: #fdffff;
    }
    .switch-button {
        display: inline-block;
        /* padding-top: 9px;
        padding-right: 30px; */
        padding: 9px 40px;
    }
    .switch-button .switch-button__checkbox {
        display: none;
    }
    .switch-button .switch-button__label {
        background-color:#1f1f1f66;
        width: 2rem;
        height: 1rem;
        border-radius: 3rem;
        display: inline-block;
        position: relative;
    }
    .switch-button .switch-button__label:before {
        transition: .6s;
        display: block;
        position: absolute;
        width: 1rem;
        height: 1rem;
        background-color: var(--color-button);
        content: '';
        border-radius: 50%;
        box-shadow: inset 0px 0px 0px 1px black;
    }
    .switch-button .switch-button__checkbox:checked + .switch-button__label {
        background-color: #1c84c6;

    }
    .switch-button .switch-button__checkbox:checked + .switch-button__label:before {
        transform: translateX(1rem);
    }
</style>
<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src  ="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
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
<script>
    // Mostrar el formulario de usuario
    document.getElementById("btn-agregar").onclick = function() {
        var formContainer = document.getElementById("form-container");
        formContainer.style.display = formContainer.style.display === "none" ? "block" : "none";
    };
</script>
@endsection
