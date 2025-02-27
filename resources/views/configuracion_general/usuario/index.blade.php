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
</div>
</div>
</div>
</div>
</div>



<!-- Sección de USUARIO ---------->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <!-- Sección de Proveedor  ------------------------------------------------------------------------------------  -->
                    <div class="tab-pane active">
                        <!-- Título centrado -->
                        <h2 style="text-align: center; margin-bottom: 20px;">USUARIO</h2>
                        <div class="panel-body">
                            <!-- Contenido de Nested Tab 1 -->
                            <div class="search-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                <!-- Barra de búsqueda y botón Buscar -->
                                <div style="flex-grow: 1;">
                                    <input type="text" class="form-control" placeholder="Buscar..." style="width: 50%; display: inline-block;">
                                    <button class="btn btn-primary" style="display: inline-block; margin-left: 10px;background-color:blue">Buscar</button>
                                </div>
                                <button class="btn btn-success" data-toggle="modal" href="#nuevoUsuarioModal " style="background-color: blue;">
                                <i class="fa fa-plus" ></i>
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover text-md-center dataTables-usu">
                                    <thead>
                                    <tr>
                                        <th>ID </th>
                                        <th>Personal </th>
                                        <th>Cargo </th>
                                        <th>Correo</th>
                                        <th>Celular</th>
                                        <th>Almacén </th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <span hidden>{{$i=1}}</span>
                                    @foreach($usuarios as $usuario)
                                    <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$usuario->personal->nombres}}</td>
                                    <td>{{$usuario->name}}</td>
                                    <td>{{$usuario->email}}</td>
                                    <td>{{$usuario->celular}}</td>
                                    <td>{{$usuario->almacen->nombre}}</td>
                                    <td>
                                        @if($usuario->estado == 1)
                                        <button type="button" class="btn btn-info"><i class="fa fa-check-circle"></i></button>
                                    @elseif($usuario->estado == 0)
                                        <button type="button" class="btn btn-danger"><i class="fa fa-times-circle"></i></button>
                                    @endif
                                    <button style="box-shadow: none;" onclick="divAuto{{$usuario->id}}()" class="btn  btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-edit"></i></button>
                                    </td>
                                    </tr>
                                    <tr hidden id="forma{{$usuario->id}}">
                                        <form action="{{ route('usuario.update',$usuario->id) }}"  enctype="multipart/form-data" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <td>{{$usuario->id}}</td>
                                            <td>{{$usuario->personal->nombres}}</td>
                                            <td>{{$usuario->name}}</td>
                                            <td><input class="form-control" name="correo" value="{{$usuario->email}}" type="text"></td>
                                            <td><input class="form-control" name="celular" value="{{$usuario->celular}}" type="text"></td>
                                            <td><input class="form-control" name="almacen" value="{{$usuario->almacen->nombre}}" type="text"></td>
                                            <td><input class="btn  btn-success" type="submit"> </td>
                                            <!-- Agregar sobre el editar  -->
                                        </form>
                                    </tr>
                                    <script>
                                        var clic = 1;
                                        function divAuto{{$usuario->id}}(){
                                            if(clic==1){
                                                 // document.getElementById("div-mostrar").style.height = "50px";
                                                 document.getElementById("forma{{$usuario->id}}").removeAttribute("hidden", "");
                                                 document.getElementById("vista{{$usuario->id}}").setAttribute("hidden", "");
                                                 clic = clic + 1;
                                             } else{
                                                // document.getElementById("div-mostrar").style.height = "0px";
                                                document.getElementById("vista{{$usuario->id}}").removeAttribute("hidden", "");
                                                document.getElementById("forma{{$usuario->id}}").setAttribute("hidden", "");
                                                clic = 1;
                                            }
                                        }
                                    </script>

                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="modal fade" id="nuevoUsuarioModal" tabindex="-1" aria-labelledby="nuevoUsuarioModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="nuevoUsuarioModalLabel">Nuevo Usuario</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <!-- Modal Body -->
                                    <div class="modal-body">
                                        <form id="formNuevoUsuario">
                                            <div class="row mb-3">
                                                <strong for="personal" class="col-sm-2 col-form-label fw-bold">Personal:</strong>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="personal" placeholder="Ingrese nombre personal">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <strong for="cargo" class="col-sm-2 col-form-label fw-bold">Cargo:</strong>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="cargo" placeholder="Ingrese Cargo">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <strong for="correo" class="col-sm-2 col-form-label fw-bold">Correo:</strong>
                                                <div class="col-sm-10">
                                                    <input type="email" class="form-control" id="correo" placeholder="Ingrese Correo">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <strong for="celular" class="col-sm-2 col-form-label fw-bold">Celular:</strong>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="celular" placeholder="Ingrese número de celular">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <strong for="almacen" class="col-sm-2 col-form-label fw-bold">Almacén:</strong>
                                                <div class="col-sm-10">
                                                    <input type="text" class="form-control" id="almacen" placeholder="Ingrese almacén">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- Modal Footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-primary" id="btn-agregar-usuario" style="background-color: blue;">Agregar Usuario</button>
                                    </div>
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
    // Mostrar el formulario de agregar usuario
    document.getElementById("btn-agregar").onclick = function() {
        var formContainer = document.getElementById("form-container");
        formContainer.style.display = formContainer.style.display === "none" ? "block" : "none";
    };
</script>
<script>
    // Mostrar el formulario de editar usuario
    document.getElementById("show-form-button").onclick = function() {
        var formContainer = document.getElementById("edit-form-container");
        formContainer.style.display = formContainer.style.display === "none" ? "block" : "none";
    };
</script>


<style>
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
<script>
    $(document).ready(function(){
        $('.dataTables-usu').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });
</script>

@endsection
