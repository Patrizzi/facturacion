@extends('layout')
@section('title', 'Provedor')
@section('breadcrumb', 'Provedor')
@section('breadcrumb2', 'Provedor')

@section('data-toggle', 'modal')
@section('href_accion', '#ModalProvedor')
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
                    <!-- Sección de Proveedor -->
                    <div>
                        <!-- Título centrado -->
                        <div>
                            <h1 style="text-align: center; margin-bottom: 20px; font-weight: bold;">PROVEEDOR</h1>
                        </div>
                        <div class="search-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <!-- Botones Agregar y Actualizar -->
                            <div>
                                <button class="btn btn-success" style="margin-right: 10px;">Agregar</button>
                                <button class="btn btn-primary">Actualizar</button>
                                <button style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;" id="btn-agregar" onclick="toggleForm()">
                                    AGREGAR
                                </button>
                            </div>
                            <br>
                            <!-- Boton Para Descargar -->
                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <select class="form-select" aria-label="Default select example">
                                    <option selected style="font-weight: bold; color: white; background-color: #007bff;">F. Descarga</option>
                                    <option value="1">Copy</option>
                                    <option value="2">CSV</option>
                                    <option value="3">Excel</option>
                                    <option value="4">PDF</option>
                                    <option value="5">Print</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="search-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                            <div style="flex-grow: 1;">
                                <input type="text" class="form-control" placeholder="Buscar..." style="width: 50%; display: inline-block;">
                                <button class="btn btn-primary" style="display: inline-block; margin-left: 10px;">Buscar</button>
                            </div>
                        </div>
                        <!-- ----------------------------------------------------------------------------------- -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox ">
                                    <div class="ibox-content">
                                        <br>
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                <tr>
                                                    <th style="background-color: #007bff;color: white;">ID </th>
                                                    <th style="background-color: #007bff;color: white;">RUC </th>
                                                    <th style="background-color: #007bff;color: white;">EMPRESA</th>
                                                    <th style="background-color: #007bff;color: white;">DIRECCION</th>
                                                    <th style="background-color: #007bff;color: white;">TELEFONO</th>
                                                    <th style="background-color: #007bff;color: white;">CORREO</th>
                                                    <th style="background-color: #007bff;color: white;">EDITAR</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>20215632845</td>
                                                    <td>GASOLINA SAC</td>
                                                    <td>SMP</td>
                                                    <td>958624785</td>
                                                    <td>gasolinasac@gmail.com</td>
                                                    <td><a href="#" class="edit-icon"><i class="fas fa-edit"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>20359644128</td>
                                                    <td>INVERSIONES OMAR</span></td>
                                                    <td>BREÑA</td>
                                                    <td>526348519</td>
                                                    <td>inversionesomar@gmail.com</td>
                                                    <td><a href="#" class="edit-icon"><i class="fas fa-edit"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>20156874256</td>
                                                    <td>MYTHAJAT</td>
                                                    <td>P. PIEDRA</td>
                                                    <td>526841975</td>
                                                    <td>mythajat@gmail.com</td>
                                                    <td><a href="#" class="edit-icon"><i class="fas fa-edit"></i></a></td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>20356327847</td>
                                                    <td>IMPORTACIONES ZM</td>
                                                    <td>AREQUIPA</td>
                                                    <td>526874935</td>
                                                    <td>importacioneszm@gmail.com</td>
                                                    <td><a href="#" class="edit-icon"><i class="fas fa-edit"></i></a></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-white"><i class="fa fa-chevron-left"></i></button>
                                        <button class="btn btn-white">1</button>
                                        <button class="btn btn-white  active">2</button>
                                        <button class="btn btn-white">3</button>
                                        <button class="btn btn-white">4</button>
                                        <button type="button" class="btn btn-white"><i class="fa fa-chevron-right"></i> </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- Formulario oculto -->
                        <div id="form-proveedor" class="form-proveedor" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; border: 1px solid #ccc; padding: 20px; border-radius: 5px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); z-index: 1000;">
                            <h2>AGREGAR PROVEEDOR</h2>

                            <label for="ruc" style="display: block;">Introducir RUC (inestable):</label>
                            <input type="text" id="ruc" placeholder="Buscar RUC" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 20px;">

                            <div style="background-color: blue; color: white; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                                <strong>1. Datos Personales</strong>
                            </div>

                            <div class="form-fields" style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;">
                                <div style="display: flex; flex-direction: column;">
                                    <label for="nombre" style="display: block;">Nombre:</label>
                                    <input type="text" id="nombre" placeholder="Ingrese nombre" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

                                    <label for="direccion" style="display: block;">Dirección:</label>
                                    <input type="text" id="direccion" placeholder="Ingrese dirección" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

                                    <label for="celular" style="display: block;">Celular:</label>
                                    <input type="text" id="celular" placeholder="Ingrese celular" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                                </div>

                                <div style="display: flex; flex-direction: column;">
                                    <label for="documento" style="display: block;">Documentos:</label>
                                    <input type="text" id="documento" placeholder="Ingrese documentos" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

                                    <label for="correo" style="display: block;">Correo:</label>
                                    <input type="email" id="correo" placeholder="Ingrese correo" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">

                                    <div style="display: flex; justify-content: space-between; margin-top: 20px;">
                                        <button id="btn-previus" class="blue-button" style="background-color: blue; color: white; border: none; border-radius: 5px; padding: 10px; cursor: pointer; flex: 1; margin-right: 5px;">PREVIUS</button>
                                        <button id="btn-finish" class="blue-button" style="background-color: blue; color: white; border: none; border-radius: 5px; padding: 10px; cursor: pointer; flex: 1;">FINISH</button>
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

    @endsection
