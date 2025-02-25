@extends('layout')
@section('title', 'Provedor')
@section('breadcrumb', 'Provedor')
@section('breadcrumb2', 'Provedor')

@section('data-toggle', 'modal')
@section('href_accion', '#ModalProvedor')
@section('value_accion', 'Agregar')

<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
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
                        <table class="table table-striped table-bordered table-hover dataTables-example" style="font-size: 13px" >
                            <thead>
                                <tr >
                                    <th>ID</th>
                                    <th>RUC</th>
                                    <th>Empresa</th>
                                    <th>Direccion</th>
                                    <th>Telefonos</th>
                                    <th>Correo</th>
                                    <th style="width: 50px;">Editar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($provedores as $provedor)
                                <tr class="gradeX"  id="vista{{$provedor->id}}">
                                    <td>{{$provedor->id}}</td>
                                    <td>{{$provedor->ruc}}</td>
                                    <td>{{$provedor->empresa}}</td>
                                    <td>{{$provedor->direccion}}</td>
                                    <td>{{$provedor->telefonos}}</td>
                                    <td>{{$provedor->email}}</td>
                                    <td><div style="box-shadow: none;" onclick="divAuto{{$provedor->id}}()">
                                        <a class="btn  btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-edit" style="color: white"></i>  </a>
                                    </div></td>
                                </tr>
                                <tr hidden id="forma{{$provedor->id}}">
                                    <form action="{{ route('provedor.update',$provedor->id) }}"  enctype="multipart/form-data" method="post">
                                        @csrf
                                        @method('PATCH')
                                        <td>{{$provedor->id}}</td>
                                        <td><input class="form-control" name="" value="{{$provedor->ruc}}" readonly=""  type="text"></td>
                                        <td><input class="form-control" name="empresa" value="{{$provedor->empresa}}" type="text"></td>
                                        <td><input class="form-control" name="direccion" value="{{$provedor->direccion}}" type="text"></td>
                                        <td><input class="form-control" name="telefonos" value="{{$provedor->telefonos}}" type="text"></td>
                                        <td><input class="form-control" name="correo_provedor" value="{{$provedor->email}}" type="text"></td>
                                        <td > {{-- <div  style="box-shadow: none;" onclick="divAuto{{$provedor->id}}()">
                                            <a class="btn  btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-edit" style="color: white"></i></a>
                                        </div> --}} <input class="btn  btn-success" type="submit"> </td>
                                    </form>
                                </tr>
                                <script>
                                    var clic = 1;
                                    function divAuto{{$provedor->id}}(){
                                        if(clic==1){
                                             // document.getElementById("div-mostrar").style.height = "50px";
                                             document.getElementById("forma{{$provedor->id}}").removeAttribute("hidden", "");
                                             document.getElementById("vista{{$provedor->id}}").setAttribute("hidden", "");
                                             clic = clic + 1;
                                         } else{
                                            // document.getElementById("div-mostrar").style.height = "0px";
                                            document.getElementById("vista{{$provedor->id}}").removeAttribute("hidden", "");
                                            document.getElementById("forma{{$provedor->id}}").setAttribute("hidden", "");
                                            clic = 1;
                                        }
                                    }
                                </script>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <!-- Sección de Proveedor  ------->
                    <div class="tab-pane active">
                        <!-- Título centrado -->
                        <h2 style="text-align: center; margin-bottom: 20px;">PROVEEDOR</h2>
                        <div class="panel-body">
                            <div class="search-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                <div style="flex-grow: 1; display: flex; align-items: center;">
                                    <input type="text" class="form-control" placeholder="Buscar..." style="width: 50%; margin-right: 10px;">
                                    <button class="btn btn-primary">Buscar</button>
                                </div>
                                <div style="margin-left: 10px;">    
                                    <button class="btn btn-success" data-toggle="modal" href="#ModalProvedor">
                                        Agregar
                                    </button>
                                </div>
                                <div style="margin-left: 10px;">    
                                    <button class="btn btn-success" data-toggle="modal" href="#nuevoProveedorModal" style="background-color: blue;">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <div style="margin-left: 10px;">    
                                    <div class="btn-group">
                                        <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-download"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#">Copy</a>
                                            <a class="dropdown-item" href="#">CSV</a>
                                            <a class="dropdown-item" href="#">Excel</a>
                                            <a class="dropdown-item" href="#">PDF</a>
                                            <a class="dropdown-item" href="#">Print</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                            <div class="table-responsive">
                                <table class="table table-striped  table-hover text-md-center dataTables-pro">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ruc</th>
                                        <th>Empresa </th>
                                        <th>Dirección</th>
                                        <th>Telefono</th>
                                        <th>Correo</th>
                                        <th>Acciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($provedores as $provedor)
                                    <tr>
                                        <td>{{$provedor->id}}</td>
                                        <td>{{$provedor->ruc}}</td>
                                        <td>{{$provedor->empresa}}</td>
                                        <td>{{$provedor->direccion}}</td>
                                        <td>{{$provedor->telefonos}}</td>
                                        <td>{{$provedor->email}}</td>
                                        <!--Agregar el estado y que se cambie mediante el switch y se visualice por los botones-->
                                        <td>
                                            <button style="box-shadow: none;" onclick="divAuto{{$provedor->id}}()" class="btn  btn-success" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Enviar a"><i class="fa fa-edit"></i></button> 

                                            <button type="button" class="btn btn-info"><i class="fa fa-check-circle"></i></button> 

                                        </td>
                                    </tr>
                                    <tr hidden id="forma{{$provedor->id}}">
                                        <form action="{{ route('provedor.update',$provedor->id) }}"  enctype="multipart/form-data" method="post">
                                            @csrf
                                            @method('PATCH')
                                            <td>{{$provedor->id}}</td>
                                            <td><input class="form-control" name="" value="{{$provedor->ruc}}" readonly=""  type="text"></td>
                                            <td><input class="form-control" name="empresa" value="{{$provedor->empresa}}" type="text"></td>
                                            <td><input class="form-control" name="direccion" value="{{$provedor->direccion}}" type="text"></td>
                                            <td><input class="form-control" name="telefonos" value="{{$provedor->telefonos}}" type="text"></td>
                                            <td><input class="form-control" name="correo_provedor" value="{{$provedor->email}}" type="text"></td>
                                            <td><input class="btn  btn-success" type="submit"></td>
                                        </form>
                                    </tr>
                                    <script>
                                        var clic = 1;
                                        function divAuto{{$provedor->id}}(){
                                            if(clic==1){
                                                 // document.getElementById("div-mostrar").style.height = "50px";
                                                 document.getElementById("forma{{$provedor->id}}").removeAttribute("hidden", "");
                                                 document.getElementById("vista{{$provedor->id}}").setAttribute("hidden", "");
                                                 clic = clic + 1;
                                             } else{
                                                // document.getElementById("div-mostrar").style.height = "0px";
                                                document.getElementById("vista{{$provedor->id}}").removeAttribute("hidden", "");
                                                document.getElementById("forma{{$provedor->id}}").setAttribute("hidden", "");
                                                clic = 1;
                                            }
                                        }
                                    </script>
                                    @endforeach
                                    </tbody>
                                </table>
                                    <div class="modal fade" id="nuevoProveedorModal" tabindex="-1" aria-labelledby="nuevoProveedorModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <!-- Modal Header -->
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="nuevoProveedorModalLabel">Nuevo Proveedor</h3>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <!-- Modal Body -->
                                                <div class="modal-body">
                                                    <form id="formNuevoProveedor">
                                                        <div class="row mb-3">
                                                            <strong for="personal" class="col-sm-2 col-form-label fw-bold">N° Ruc:</strong>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" id="personal" placeholder="Ingrese el número de Ruc">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <strong for="cargo" class="col-sm-2 col-form-label fw-bold">Empresa:</strong>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" id="cargo" placeholder="Ingrese Nombre de la Empresa">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <strong for="correo" class="col-sm-2 col-form-label fw-bold">Dirección:</strong>
                                                            <div class="col-sm-10">
                                                                <input type="email" class="form-control" id="correo" placeholder="Ingrese la Dirección">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <strong for="celular" class="col-sm-2 col-form-label fw-bold">Teléfono:</strong>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" id="celular" placeholder="Ingrese el número de Teléfono">
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <strong for="almacen" class="col-sm-2 col-form-label fw-bold">Correo:</strong>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" id="almacen" placeholder="Ingrese el Correo">
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <!-- Modal Footer -->
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                                    <button type="button" class="btn btn-primary" id="btn-agregar-usuario" style="background-color: blue;">Agregar Proveedor</button>
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

<!-- Jquery Validate -->
<script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>

<!-- Steps -->
<script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>
@include('layout_agregado_rapido')
{{-- scritp de modal agregar --}}
<script>
    $(document).ready(function(){
        $("#wizard").steps();
        $("#form1").steps({
            bodyTag: "fieldset",
            onStepChanging: function (event, currentIndex, newIndex)
            {
                    // ¡Siempre permita retroceder incluso si el paso actual contiene campos no válidos!
                    if (currentIndex > newIndex)
                    {
                        return true;
                    }

                    // Prohibir suprimir el paso "Advertencia" si el usuario es demasiado joven
                    if (newIndex === 3 && Number($("#age").val()) < 18)
                    {
                        return false;
                    }

                    var form = $(this);

                    // Limpie si el usuario retrocedió antes
                    if (currentIndex < newIndex)
                    {
                        // Para eliminar estilos de error
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    }

                    // Deshabilite la validación en los campos que están deshabilitados u ocultos.
                    form.validate().settings.ignore = ":disabled,:hidden";

                    // Iniciar validación; Evite avanzar si es falso
                    return form.valid();
                },
                onStepChanged: function (event, currentIndex, priorIndex)
                {
                    // Suprima (omita) el paso "Advertencia" si el usuario tiene edad suficiente.
                    if (currentIndex === 2 && Number($("#age").val()) >= 18)
                    {
                        $(this).steps("next");
                    }

                    // Suprima (omita) el paso "Advertencia" si el usuario tiene la edad suficiente y quiere el paso anterior.
                    if (currentIndex === 2 && priorIndex === 3)
                    {
                        $(this).steps("previous");
                    }
                },
                onFinishing: function (event, currentIndex)
                {
                    var form = $(this);

                    // Deshabilita la validación en los campos que están deshabilitados.
                    // En este punto, se recomienda hacer una verificación general (significa ignorar solo los campos deshabilitados)
                    form.validate().settings.ignore = ":disabled";

                    // Iniciar validación; Evitar el envío del formulario si es falso
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                    var form = $(this);

                    // Enviar entrada de formulario
                    form.submit();
                }
            }).validate({
                errorPlacement: function (error, element)
                {
                    element.before(error);
                },
                rules: {
                    confirm: {
                        equalTo: "#password"
                    }
                }
            });
        });
    </script>
    {{-- / --}}

    <!-- Page-Level Scripts -->
    <script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print',
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
                }
            }
            ]

        });

        });

    </script>
    <script>
        function toggleForm() {
        const form = document.getElementById('form-proveedor');
        form.style.display = form.style.display === 'none' ? 'block' : 'none';
    }
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
        $('.dataTables-pro').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });
</script>

    @endsection
