@extends('layout')

@section('title', 'Personal')
@section('breadcrumb', 'Personal')
@section('breadcrumb2', 'Personal')
@section('href_accion', route('personal.create'))
@section('value_accion', 'Agregar')

@section('content')

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
                                                <th>Nombre</th>
                                                <th>Apellido</th>
                                                <th>N° Documento</th>
                                                <th>Celular</th>
                                                <th>Correo</th>
                                                <th>Estado</th>
                                                <th>Foto</th>
                                                <th>Ver</th>
                                            </tr>
                                        </thead>
                                    <tbody>
                                        @foreach($personales as $personal)
                                            <tr class="gradeX">
                                                <td>{{$i++}}</td>
                                                <td>{{$personal->nombres}}</td>
                                                <td>{{$personal->apellidos}}</td>
                                                <td>{{$personal->numero_documento}}</td>
                                                <td>{{$personal->celular}}</td>
                                                <td>{{$personal->email}}</td>
                                                <td>{{$personal->estado_trabajador_laboral}}</td>
                                                <td><img src="
                                                    {{ asset('/profile/images/')}}/{{$personal->foto}}" style="width: 45px;">
                                                </td>
                                                <td><center><a href="{{ route('personal.show', $personal->id) }}"><button type="button" class="btn btn-s-m btn-primary">VER</button></a></center></td>{{--
                                                <td><center><a href="{{ route('personal.edit', $personal->id) }}" ><button type="button" class="btn btn-s-m btn-success">Editar</button></a></center></td> --}}
                                                {{--  <td>
                                                    <center>
                                                        <form action="{{ route('personal.destroy', $personal->id)}}" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit" class="btn btn-s-m btn-danger">Eliminar</button>
                                                        </form>
                                                    </center>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    </table>
                                </div>
<!-- CODIGO PERSONAL----------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                                <div class="tab-pane active">
                                    <!-- Título centrado -->
                                    <h2 style="text-align: center; margin-bottom: 20px;">PERSONAL</h2>
                                    <!-- linea azul -->
                                    <hr style="border: 2px solid #007BFF;">
                                    <div class="panel-body">
                                        <!-- Contenido de Nested Tab 1 -->
                                        <div class="search-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                            <div class="btn-group">
                                                <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    SEDE
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">J&P</a>
                                                    <a class="dropdown-item" href="#">WILSON</a>
                                                    <a class="dropdown-item" href="#">CREAWORD</a>
                                                </div>
                                            </div>
                                            <div class="btn-group">
                                                <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    CARGO
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">SUPERVISOR</a>
                                                    <a class="dropdown-item" href="#">CAPACITADOR</a>
                                                    <a class="dropdown-item" href="#">PRACTICANTE</a>
                                                    <a class="dropdown-item" href="#">DESPEDIDO</a>
                                                </div>
                                            </div>
                                            <!-- Barra de búsqueda y botón Buscar -->
                                            <div style="flex-grow: 1;">
                                                <input type="text" class="form-control" placeholder="Buscar..." style="width: 50%; display: inline-block;">
                                                <button class="btn btn-primary" style="display: inline-block; margin-left: 10px;">Buscar</button>
                                            </div>
                                            <!-- Botones Agregar y Descarga -->
                                            <div>
                                                <a href="{{route('personal2.create2')}}"class="btn btn-success" style="margin-right: 10px;">Agregar</a>

                                                <!-- Botón de Descarga con menú desplegable -->
                                                <div class="btn-group">
                                                    <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Descarga
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
                                        <br>














                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>ID </th>
                                                        <th>NOMBRE </th>
                                                        <th>APELLIDO </th>
                                                        <th>N° DOCUMENTO</th>
                                                        <th>CELULAR</th>
                                                        <th>CORREO</th>
                                                        <td>ACCIONES</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input type="checkbox" checked class="i-checks" name="input[]"></td>
                                                        <td>01</td>
                                                        <td>Carlos Daniel</td>
                                                        <td>Roman Berru</td>
                                                        <td>73588510</td>
                                                        <td>936292675</td>
                                                        <td>danielrberru@gmail.com</td>
                                                        <td>
                                                            <div>
                                                                <a href="#" class="check-link" style="font-size: 25px;"><i class="fa fa-check-square"></i></a>
                                                                <button class="btn btn-xs btn-primary  toggle-row"><i class="fa fa-plus"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <!-- Fila oculta -->
                                                    <tr class="details-row" style="display: none;">
                                                        <td colspan="8">
                                                            <div style="display: flex;">
                                                                <!-- Columna 1: Imagen -->
                                                                <div style="flex: 2; padding: 10px; text-align: center;">
                                                                    <div class="text-center">
                                                                        <div style="border: 2px solid white; border-radius: 30px">
                                                                            <img alt="image" class="rounded m-t-xs img-fluid" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRoa2kf0g2zsme6Q8VC0_Wo3BZamOchTvihOg&s">
                                                                        </div>
                                                                        <br>
                                                                        <br>
                                                                        <div class="form-group row"><label class="col-lg-3 col-form-label">Nombre:</label>
                                                                            <div class="col-lg-9"><input type="nombre" placeholder="Carlos Daniel" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group row"><label class="col-lg-3 col-form-label">Apellido:</label>
                                                                            <div class="col-lg-9"><input type="apellido" placeholder="Roman Berru" class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <button class="btn btn-success" style="margin-right: 10px;">Actualizar Datos</button>

                                                                    </div>
                                                                </div>
                                                                <!-- Columna 2: Datos -->
                                                                <div style="flex: 10; padding: 10px;">
                                                                    <div>
                                                                        <p class="" style="color: white; text-align: center; align-items: center; padding: 7px; font-weight: bold; background-color: #007bff">DATOS GENERALES</p>
                                                                    </div>
                                                                    <div class="parent" style="display: grid; grid-template-columns: repeat(5, 1fr); grid-template-rows: repeat(3, 1fr); gap: 8px;">
                                                                        <div class="div1" style="grid-column-start: 1; grid-row-start: 1; background-color: white; font-weight: bold; padding: 5px;">DOCUMENTO>
                                                                            <select style="margin-top: 5px; width: 100%;">
                                                                                <option value="opcion1">DNI</option>
                                                                                <option value="opcion2">C. EXTRANJERO</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="div2" style="grid-column-start: 2; grid-row-start: 1; background-color: white; font-weight: bold; padding: 5px;">N. DOCUMENTO
                                                                            <input type="tel" placeholder="Numero de documento" style="margin-top: 5px; width: 100%; padding: 5px;">
                                                                        </div>
                                                                        <div class="div3" style="grid-column-start: 3; grid-row-start: 1; background-color: white; font-weight: bold; padding: 5px;">F. NACIMEINTO
                                                                            <input type="date" style="margin-top: 5px; width: 100%; padding: 5px;">
                                                                        </div>
                                                                        <div class="div4" style="grid-column-start: 4; grid-row-start: 1; background-color: white; font-weight: bold; padding: 5px;">GENERO
                                                                            <select style="margin-top: 5px; width: 100%;">
                                                                                <option value="opcion1">Hombre</option>
                                                                                <option value="opcion2">Mujer</option>
                                                                                <option value="opcion3">Inclusivo</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="div5" style="grid-column-start: 5; grid-row-start: 1; background-color: white; font-weight: bold; padding: 5px;"> CELULAR
                                                                            <input type="tel" placeholder="Escribe tu número" style="margin-top: 5px; width: 100%; padding: 5px;">
                                                                        </div>
                                                                        <div class="div6" style="grid-column-start: 1; grid-row-start: 2; background-color: white; font-weight: bold; padding: 5px;">TELEFONO
                                                                            <input type="tel" placeholder="Telefono fijo" style="margin-top: 5px; width: 100%; padding: 5px;">
                                                                        </div>
                                                                        <div class="div7" style="grid-column-start: 2; grid-row-start: 2; background-color: white; font-weight: bold; padding: 5px;"> CORREO
                                                                            <input type="email" placeholder="Escribe tu correo" style="margin-top: 5px; width: 100%; padding: 5px;">
                                                                        </div>
                                                                        <div class="div8" style="grid-column-start: 3; grid-row-start: 2; background-color: white; font-weight: bold; padding: 5px;">DIRECCION
                                                                            <input type="email" placeholder="Direccion de domicilio" style="margin-top: 5px; width: 100%; padding: 5px;">
                                                                        </div>
                                                                        <div class="div9" style="grid-column-start: 4; grid-row-start: 2; background-color: white; font-weight: bold; padding: 5px;">NIVEL EDUCATIVO
                                                                            <select style="margin-top: 5px; width: 100%;">
                                                                                <option value="opcion1">Inicial</option>
                                                                                <option value="opcion2">Primaria</option>
                                                                                <option value="opcion3">Secundaria</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="div10" style="grid-column-start: 5; grid-row-start: 2; background-color: white; font-weight: bold; padding: 5px;">C. PROFECIONAL
                                                                            <select style="margin-top: 5px; width: 100%;">
                                                                                <option value="opcion1">Ingenierio</option>
                                                                                <option value="opcion2">Tecnico</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="div11" style="grid-column-start: 1; grid-row-start: 3; background-color: white; font-weight: bold; padding: 5px;">ESTADO CIVIL
                                                                            <select style="margin-top: 5px; width: 100%;">
                                                                                <option value="opcion1">Soltero</option>
                                                                                <option value="opcion2">Encadenado</option>
                                                                                <option value="opcion3">Otro</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <p class="" style="color: white; text-align: center; align-items: center; padding: 7px; font-weight: bold; background-color: #007bff">DATOS LABORALES</p>
                                                                    </div>
                                                                    <div class="parent" style="display: grid; grid-template-columns: repeat(5, 1fr); grid-template-rows: repeat(3, 1fr); gap: 8px;">
                                                                        <div class="div1" style="grid-column-start: 1; grid-row-start: 1; background-color: white; font-weight: bold; text-align:center; padding: 5px;">AREA
                                                                            <select style="margin-top: 5px; width: 100%;">
                                                                                <option value="opcion1">Central</option>
                                                                                <option value="opcion2">Wilson</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="div2" style="grid-column-start: 2; grid-row-start: 1; background-color: white; font-weight: bold; padding: 5px;">CARGO
                                                                            <select style="margin-top: 5px; width: 100%;">
                                                                                <option value="opcion1">Supervisor</option>
                                                                                <option value="opcion2">Vendedor</option>
                                                                                <option value="opcion3">Jefe de area</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="div3" style="grid-column-start: 3; grid-row-start: 1; background-color: white; font-weight: bold; padding: 5px;">T. TRABAJO
                                                                            <select style="margin-top: 5px; width: 100%;">
                                                                                <option value="opcion1">Interno</option>
                                                                                <option value="opcion2">Externo</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="div4" style="grid-column-start: 4; grid-row-start: 1; background-color: white; font-weight: bold; padding: 5px;">SEDE
                                                                            <select style="margin-top: 5px; width: 100%;">
                                                                                <option value="opcion1">Central</option>
                                                                                <option value="opcion2">Tienda local</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="div5" style="grid-column-start: 5; grid-row-start: 1; background-color: white; font-weight: bold; padding: 5px;">TURNO
                                                                            <select style="margin-top: 5px; width: 100%;">
                                                                                <option value="opcion1">Mañana</option>
                                                                                <option value="opcion2">Tarde</option>
                                                                                <option value="opcion3">Noche</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="div6" style="grid-column-start: 1; grid-row-start: 2; background-color: white; font-weight: bold; padding: 5px;">SALARIO
                                                                            <select style="margin-top: 5px; width: 100%;">
                                                                                <option value="opcion1">S/ 1200</option>
                                                                                <option value="opcion2">S/ 650</option>
                                                                                <option value="opcion3">eres practicante</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="div7" style="grid-column-start: 2; grid-row-start: 2; background-color: white; font-weight: bold; padding: 5px;">F. VINCULACION
                                                                            <input type="date" style="margin-top: 5px; width: 100%; padding: 5px;">
                                                                        </div>
                                                                        <div class="div8" style="grid-column-start: 3; grid-row-start: 2; background-color: white; font-weight: bold; padding: 5px;">F. RETIRO
                                                                            <input type="date" style="margin-top: 5px; width: 100%; padding: 5px;">
                                                                        </div>
                                                                        <div class="div9" style="grid-column-start: 4; grid-row-start: 2; background-color: white; font-weight: bold; padding: 5px;">FORMA DE PAGO
                                                                            <select style="margin-top: 5px; width: 100%;">
                                                                                <option value="opcion1">BCP</option>
                                                                                <option value="opcion2">Interbanc</option>
                                                                                <option value="opcion3">Yape</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="div10" style="grid-column-start: 5; grid-row-start: 2; background-color: white; font-weight: bold; padding: 5px;">BANCO ABONADO
                                                                            <select style="margin-top: 5px; width: 100%;">
                                                                                <option value="opcion1">BCP</option>
                                                                                <option value="opcion2">Interbanc</option>
                                                                                <option value="opcion3">BBVA</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="div11" style="grid-column-start: 1; grid-row-start: 3; background-color: white; font-weight: bold; padding: 5px;"># CUENTA
                                                                            <input type="tel" placeholder="Numero de cuenta" style="margin-top: 5px; width: 100%; padding: 5px;">
                                                                        </div>
                                                                        <div class="div12" style="grid-column-start: 2; grid-row-start: 3; background-color: white; font-weight: bold; padding: 5px;">S. DE SALUD
                                                                            <select style="margin-top: 5px; width: 100%;">
                                                                                <option value="opcion1">ESSALUD</option>
                                                                                <option value="opcion2">SAN FELIPE</option>
                                                                                <option value="opcion3">JAVIER PRADO</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="div13" style="grid-column-start: 3; grid-row-start: 3; background-color: white; font-weight: bold; padding: 5px;">T. CONTRATO
                                                                            <select style="margin-top: 5px; width: 100%;">
                                                                                <option value="opcion1">Fijo</option>
                                                                                <option value="opcion2">Temporada</option>
                                                                                <option value="opcion3">Practicante</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="div14" style="grid-column-start: 4; grid-row-start: 3; background-color: white; font-weight: bold; padding: 5px;">R. PENSIONARIO
                                                                            <select style="margin-top: 5px; width: 100%;">
                                                                                <option value="opcion1">Sin regimen</option>
                                                                                <option value="opcion2">Privado</option>
                                                                                <option value="opcion3">Nacional</option>
                                                                            </select>
                                                                        </div>
                                                                        <div class="div15" style="grid-column-start: 5; grid-row-start: 3; background-color: white; font-weight: bold; padding: 5px;">L. CONDUCIR
                                                                            <select style="margin-top: 5px; width: 100%;">
                                                                                <option value="opcion1">Vigente</option>
                                                                                <option value="opcion2">Cancelado</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><input type="checkbox" checked class="i-checks" name="input[]"></td>
                                                        <td>02</td>
                                                        <td>Christopher Javier</td>
                                                        <td>Huaman Guevara</td>
                                                        <td>74894537</td>
                                                        <td>934361536</td>
                                                        <td>christojhg@gmail.com</td>
                                                        <td>
                                                            <div>
                                                                <a href="#" class="check-link" style="font-size: 25px;"><i class="fa fa-check-square"></i></a>
                                                                <button class="btn btn-xs btn-primary  toggle-row"><i class="fa fa-plus"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <!-- Fila oculta -->
                                                    <tr class="details-row" style="display: none;">
                                                        <td colspan="8">
                                                            <div style="display: flex;">
                                                                <!-- Columna 1: Imagen -->
                                                                <div style="flex: 4; padding: 10px; text-align: center;">
                                                                    <img src="https://via.placeholder.com/100" alt="Foto" style="max-width: 100%; height: auto;">
                                                                </div>
                                                                <!-- Columna 2: Datos -->
                                                                <div style="flex: 8; padding: 10px;">
                                                                    <table class="table table-bordered">
                                                                        <tr>
                                                                            <th>Detalle 1</th>
                                                                            <td>Valor 1</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Detalle 2</th>
                                                                            <td>Valor 2</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <th>Detalle 3</th>
                                                                            <td>Valor 3</td>
                                                                        </tr>
                                                                    </table>
                                                                </div>
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






                                </div>





















<!-- FIN DE CODIGO PERSONAL----------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                                hola mundo
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
    <!-- Despliegue de la tabla para editar -->
    <script>
        // Selecciona todos los botones con la clase toggle-row
        document.querySelectorAll('.toggle-row').forEach((button) => {
            button.addEventListener('click', () => {
                // Encuentra la fila oculta siguiente a la fila actual
                const detailsRow = button.closest('tr').nextElementSibling;

                // Alterna la visibilidad de la fila
                if (detailsRow.style.display === 'none') {
                    detailsRow.style.display = 'table-row';
                } else {
                    detailsRow.style.display = 'none';
                }
            });
        });
    </script>

@endsection
