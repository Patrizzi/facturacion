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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
  



<!-- CODIGO PERSONAL----------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
                                
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-content">
                            <div class="tab-pane active">
                                    <!-- Título centrado -->
                                    <h2 style="text-align: center; margin-bottom: 20px;">PERSONAL</h2>
                                    <div class="panel-body">
                                        <div class="search-bar" style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                                            <!-- Botón Sede -->
                                            <div class="btn-group">
                                                <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Sede
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">J&P</a>
                                                    <a class="dropdown-item" href="#">WILSON</a>
                                                    <a class="dropdown-item" href="#">CREAWORD</a>
                                                </div>
                                            </div>

                                            <!-- Botón Cargo -->
                                            <div class="btn-group">
                                                <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Cargo
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">SUPERVISOR</a>
                                                    <a class="dropdown-item" href="#">CAPACITADOR</a>
                                                    <a class="dropdown-item" href="#">PRACTICANTE</a>
                                                    <a class="dropdown-item" href="#">DESPEDIDO</a>
                                                </div>
                                            </div>

                                            <!-- Barra de búsqueda -->
                                            <div style="flex-grow: 1; display: flex; align-items: center;">
                                                <input type="text" class="form-control" placeholder="Buscar..." style="width: 100%; margin-right: 10px;">
                                                <button class="btn btn-primary">Buscar</button>
                                            </div>
                                            <!--<a href="{{ route('personal2.create2') }}" class="btn btn-success" style="margin-right: 10px;">Agregar</a>-->
                                            <!-- Botón de Descarga -->
                                            <div>
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

                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover text-md-center">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox" checked class="i-checks" name="input[]"></th>
                                                        <th>ID </th>
                                                        <th>Nombre </th>
                                                        <th>Apellidos </th>
                                                        <th>N° Documento</th>
                                                        <th>Celular</th>
                                                        <th>Correo</th>
                                                        <td>Acciones</td>
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
                                                            <button type="button" class="btn btn-info"><i class="fa fa-check-circle"></i></button> 
                                                            <button type="button" class="btn btn-success  toggle-row"><i class="fa fa-sort-down"></i></button>
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
                                                                        <div class="div1" style="grid-column-start: 1; grid-row-start: 1; background-color: white; font-weight: bold; padding: 5px;">DOCUMENTO
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
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="1">
                                                            <!-- Botón para mostrar/ocultar la vista de Agregar -->
                                                            <button class="btn btn-success" id="toggleButton" style="background-color: blue;">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <!-- Vista oculta que se despliega -->
                                                    <tr class="agregar-row" id="agregarRow" style="display: none;">
                                                        <td colspan="8">
                                                            <div style="display: flex;">
                                                                <!-- Columna 1: Imagen -->
                                                                <div style="flex: 2; padding: 10px; text-align: center;">
                                                                    <div class="text-center">
                                                                        <div style="grid-column: span 2 / span 2; grid-row: span 4 / span 4; grid-column-start: 4; grid-row-start: 1; background-color: white; font-size: 20px; font-weight: bold; display: flex; align-items: center; justify-content: center; position: relative; width: 100%; /* Ancho del cuadro */
                                                                        height: 400px; /* Altura del cuadro */ border: 2px dashed #ccc; /* Borde para indicar un espacio */ box-sizing: border-box; /* Incluir borde en el tamaño total */">
                                                                            <i class="fas fa-upload" style="font-size: 40px; color: #000; cursor: pointer;" onclick="document.getElementById('file-input').click();"></i>
                                                                            <input type="file" id="file-input" style="display: none;" accept="image/*" onchange="handleFileUpload(event)">
                                                                        </div>
                                                                        <br>
                                                                        <button class="btn btn-success" style="margin-right: 10px;">Agregar Personal</button>
                                                                    </div>
                                                                </div>
                                                                <!-- Columna 2: Datos -->
                                                                <div style="flex: 10; padding: 10px;">
                                                                    <!-- DATOS GENERALES -->
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
                                                </tfoot>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

  
<!-- FIN DE CODIGO PERSONAL----------------------------------------------------------------------------------------------------------------------------------------------------------------- -->



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
                if (detailsRow.style.display === 'none' || detailsRow.style.display === '') {
                    detailsRow.style.display = 'table-row';
                    // Cambia el ícono al caret-up
                    button.innerHTML = '<i class="fa fa-caret-up"></i>';
                } else {
                    detailsRow.style.display = 'none';
                    // Cambia el ícono al sort-down
                    button.innerHTML = '<i class="fa fa-sort-down"></i>';
                }
            });
        });
    </script>

    <script>
        document.getElementById('toggleButton').addEventListener('click', function () {
            const agregarRow = document.getElementById('agregarRow');
            if (agregarRow.style.display === 'none' || agregarRow.style.display === '') {
                agregarRow.style.display = 'table-row'; // Muestra la vista
            } else {
                agregarRow.style.display = 'none'; // Oculta la vista
            }
        });
    </script>

@endsection
