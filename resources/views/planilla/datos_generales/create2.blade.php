@extends('layout')
@section('title', 'Personal')
@section('href_accion', route('personal.index') )
@section('value_accion', 'Atras')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<body>
<div class="ibox-content">
  <form id="form" action="#" class="wizard-big">
    <fieldset style="align-items: center;">
      <div class="row" style="display: flex; align-items: center;">
        <!-- Columna 1: Imagen -->
        <div class="col-lg-2" style="text-align: center;">
          <img src="planilla/datos_generales/perfil.png" alt="Perfil" class="perfil" width="200" height="200" style="border-radius: 50%;">
        </div>
        
        <!-- Columna 2: Nombre -->
        <div class="col-lg-6" style="text-align: center;">
          <div class="form-group">
            <label style="font-size: 50px; font-weight: bold; color: black;">Fabricio</label>
          </div>
          <div class="form-group">
            <label style="font-size: 50px; font-weight: bold; color: black;">Yupanqui</label>
          </div>
        </div>

        <!-- Columna 3: Selectores de opciones -->
        <div class="col-lg-4" style="display: flex; flex-direction: column; align-items: center;">
          <select class="form-control m-b" name="nacionalidad" style="width: 100%; font-size: 20px; font-weight: bold; text-align: center; margin-bottom: 20px; padding: 10px; height: 50px;">
            <option style="font-weight: bold;">Peruano</option>
            <option style="font-weight: bold;">Venezolano</option>
            <option style="font-weight: bold;">Extranjero</option>
          </select>
          <select class="form-control m-b" name="estado" style="width: 100%; font-size: 20px; font-weight: bold; text-align: center; padding: 10px; height: 50px;">
            <option style="font-weight: bold;">Interno</option>
            <option style="font-weight: bold;">Externo</option>
          </select>
        </div>
      </div>
    </fieldset>
  </form>
</div>
  <br>
  <p class="" style="font-size: 40px; color: white; padding: 10px; text-align: center; background-color: #007bff">DATOS GENERALES</p>
  <div class="parent" style="display: grid; grid-template-columns: repeat(4, 1fr); grid-template-rows: repeat(4, 1fr); gap: 20px;">
      <div class="div1" style="grid-column-start: 1; grid-row-start: 1; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">DOCUMENTO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">DNI</option>
          <option value="opcion2">C. EXTRANJERO</option>
        </select>
      </div>
      <div class="div2" style="grid-column-start: 1; grid-row-start: 2; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">GENERO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Hombre</option>
          <option value="opcion2">Mujer</option>
          <option value="opcion3">Inclusivo</option>
        </select>
      </div>
      <div class="div3" style="grid-column-start: 1; grid-row-start: 3; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;"> CORREO
        <input type="email" placeholder="Escribe tu correo" style="margin-top: 5px; width: 100%; padding: 5px;">
      </div>
      <div class="div4" style="grid-column-start: 1; grid-row-start: 4; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">C. PROFECIONAL
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Ingenierio</option>
          <option value="opcion2">Tecnico</option>
        </select>
      </div>
      <div class="div5" style="grid-column-start: 2; grid-row-start: 1; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">N. DOCUMENTO
        <input type="tel" placeholder="Numero de documento" style="margin-top: 5px; width: 100%; padding: 5px;">
      </div>
      <div class="div6" style="grid-column-start: 2; grid-row-start: 2; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;"> CELULAR
        <input type="tel" placeholder="Escribe tu número" style="margin-top: 5px; width: 100%; padding: 5px;">
      </div>
      <div class="div7" style="grid-column-start: 2; grid-row-start: 3; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">DIRECCION
        <input type="email" placeholder="Direccion de domicilio" style="margin-top: 5px; width: 100%; padding: 5px;">
      </div>
      <div class="div8" style="grid-column-start: 2; grid-row-start: 4; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">ESTADO CIVIL
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Soltero</option>
          <option value="opcion2">Encadenado</option>
          <option value="opcion3">Otro</option>
        </select>
      </div>
      <div class="div9" style="grid-column-start: 3; grid-row-start: 1; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">F. NACIMEINTO
        <input type="date" style="margin-top: 5px; width: 100%; padding: 5px;">
      </div>
      <div class="div10" style="grid-column-start: 3; grid-row-start: 2; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">TELEFONO
        <input type="tel" placeholder="Telefono fijo" style="margin-top: 5px; width: 100%; padding: 5px;">
      </div>
      <div class="div11" style="grid-column-start: 3; grid-row-start: 3; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">NIVEL EDUCATIVO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Inicial</option>
          <option value="opcion2">Primaria</option>
          <option value="opcion3">Secundaria</option>
        </select>
      </div>

      <div class="div12" style="grid-column: span 2 / span 2; grid-row: span 4 / span 4; grid-column-start: 4; grid-row-start: 1; background-color: white; font-size: 20px; font-weight: bold; display: flex; align-items: center; justify-content: center; position: relative;">
        <i class="fas fa-upload" style="font-size: 40px; color: #000; cursor: pointer;" onclick="document.getElementById('file-input').click();"></i>
        <input type="file" id="file-input" style="display: none;" accept="image/*" onchange="handleFileUpload(event)">
      </div>

  </div>
  <br>
  <p class="" style="font-size: 40px; color: white; padding: 10px; text-align: center; align-items: center; background-color: #007bff">DATOS LABORALES</p>
  <div class="parent" style="display: grid; grid-template-columns: repeat(4, 1fr); grid-template-rows: repeat(4, 1fr); gap: 20px;">
      <div class="div1" style="grid-column-start: 1; grid-row-start: 1; background-color: white; font-size: 20px; font-weight: bold; text-align:center; padding: 10px;">AREA
        <select style="margin-top: 5px; width: 100%;">
            <option value="opcion1">Central</option>
            <option value="opcion2">Wilson</option>
        </select>
    </div>
      <div class="div2" style="grid-column-start: 1; grid-row-start: 2; background-color: white; font-size: 20px; font-weight: bold; text-align:center; padding: 10px;">TURNO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Mañana</option>
          <option value="opcion2">Tarde</option>
          <option value="opcion3">Noche</option>
        </select>
      </div>
      <div class="div3" style="grid-column-start: 1; grid-row-start: 3; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">FORMA DE PAGO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">BCP</option>
          <option value="opcion2">Interbanc</option>
          <option value="opcion3">Yape</option>
        </select>
      </div>
      <div class="div4" style="grid-column-start: 1; grid-row-start: 4; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">T. CONTRATO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Fijo</option>
          <option value="opcion2">Temporada</option>
          <option value="opcion3">Practicante</option>
        </select>
      </div>
      <div class="div5" style="grid-column-start: 2; grid-row-start: 1; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">CARGO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Supervisor</option>
          <option value="opcion2">Vendedor</option>
          <option value="opcion3">Jefe de area</option>
        </select>
      </div>
      <div class="div6" style="grid-column-start: 2; grid-row-start: 2; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">SALARIO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">S/ 1200</option>
          <option value="opcion2">S/ 650</option>
          <option value="opcion3">eres practicante</option>
        </select>
      </div>
      <div class="div7" style="grid-column-start: 2; grid-row-start: 3; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">BANCO ABONADO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">BCP</option>
          <option value="opcion2">Interbanc</option>
          <option value="opcion3">BBVA</option>
        </select>
      </div>
      <div class="div8" style="grid-column-start: 2; grid-row-start: 4; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">R. PENSIONARIO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Sin regimen</option>
          <option value="opcion2">Privado</option>
          <option value="opcion3">Nacional</option>
        </select>
      </div>
      <div class="div9" style="grid-column-start: 3; grid-row-start: 1; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">T. TRABAJO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Interno</option>
          <option value="opcion2">Externo</option>
        </select>
      </div>
      <div class="div10" style="grid-column-start: 3; grid-row-start: 2; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">F. VINCULACION
        <input type="date" style="margin-top: 5px; width: 100%; padding: 5px;">
      </div>
      <div class="div11" style="grid-column-start: 3; grid-row-start: 3; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;"># CUENTA
        <input type="tel" placeholder="Numero de cuenta" style="margin-top: 5px; width: 100%; padding: 5px;">
      </div>
      <div class="div13" style="grid-column-start: 3; grid-row-start: 4; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">L. CONDUCIR
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Vigente</option>
          <option value="opcion2">Cancelado</option>
        </select>
      </div>
      <div class="div15" style="grid-column-start: 4; grid-row-start: 3; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">S. DE SALUD
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">ESSALUD</option>
          <option value="opcion2">SAN FELIPE</option>
          <option value="opcion3">JAVIER PRADO</option>
        </select>
      </div>
      <div class="div16" style="grid-column-start: 4; grid-row-start: 2; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">F. RETIRO
        <input type="date" style="margin-top: 5px; width: 100%; padding: 5px;">
      </div>
      <div class="div17" style="grid-column-start: 4; grid-row-start: 1; background-color: white; font-size: 20px; font-weight: bold; padding: 10px;">SEDE
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Central</option>
          <option value="opcion2">Tienda local</option>
        </select>
      </div>
  </div>
  <br>
  <p class="" style="font-size: 40px; color: white; padding: 10px; text-align: center; align-items: center; background-color: #007bff">GUARDAR DATOS</p>
  <br>

  
</body>
</html>










<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/plugins/metisMenu/jquery.metisMenu.js"></script>
<script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>

<!-- Custom and plugin javascript -->
<script src="js/inspinia.js"></script>
<script src="js/plugins/pace/pace.min.js"></script>

@endsection