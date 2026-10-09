@extends('layout')
@section('title', 'Personal')
@section('href_accion', route('personal.index') )
@section('value_accion', 'Atras')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<!-- Codigo aprobado -------------------------------------------------------------------------------------------------- -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tab-pane active">
                        <div class="panel-body">
                            <!-- Contenido de Nested Tab 1 -->
                            <div class="table-responsive">
                                        <!-- Fila oculta -->
                                        <tr class="details-row" style="display: none;">
                                            <td colspan="8">
                                                <div style="display: flex;">
                                                    <!-- Columna 1: Imagen -->
                                                    <div style="flex: 2; padding: 10px; text-align: center;">
                                                        <div class="text-center">
                                                            <div style="grid-column: span 2 / span 2; grid-row: span 4 / span 4; grid-column-start: 4; grid-row-start: 1; background-color: white; font-size: 20px; font-weight: bold; display: flex; align-items: center; justify-content: center; position: relative; width: 100%; /* Ancho del cuadro */
                                                            height: 400px; /* Altura del cuadro */ border: 2px dashed #ccc; /* Borde para indicar un espacio */ box-sizing: border-box; /* Incluir borde en el tamaño total */">
                                                            <i class="fas fa-upload"
                                                                style="font-size: 40px; color: #000; cursor: pointer;"
                                                                onclick="document.getElementById('file-input').click();">
                                                            </i>
                                                            <input type="file" id="file-input"
                                                                style="display: none;"
                                                                accept="image/*"
                                                                onchange="handleFileUpload(event)">
                                                            </div>
                                                            <br>

                                                            <button class="btn btn-success" style="margin-right: 10px;">Agregar Personal</button>
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
                                                                    <option value="opcion2">Técnico</option>
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
                                                                    <option value="opcion3">Jefe de área</option>
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
                            </div>

                        </div>






                    </div>
                </div>
            </div>
        </div>
    </div>
</div>










<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

@endsection
