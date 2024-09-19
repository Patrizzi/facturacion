@extends('layout')
@section('title', 'Personal')
@section('href_accion', route('personal.index') )
@section('value_accion', 'Atras')
@section('content')

<body>
  <div class="ibox-content">
      <form id="form" action="#" class="wizard-big">
          <fieldset style="align-items: center;">
              <div class="row">
                  <div class="col-lg-2">
                      <img src="planilla/datos_generales/perfil.png" alt="Perfil" class="perfil" width="200" height="200">
                  </div>
                  <div class="col-lg-6">
                      <div class="form-group">
                          <label style="font-size: 50px; font-weight: bold; color: black;">Fabricio</label>
                      </div>
                      <div class="form-group">
                          <label style="font-size: 50px; font-weight: bold; color: black;">Yupanqui</label>
                      </div>
                  </div>
                  <div class="col-lg-4">
                      <select class="form-control m-b " name="nacionalidad">
                      <option style="font-weight: bold;">Nacionalidad</option>
                      <option style="font-weight: bold;">Peruano</option>
                      <option style="font-weight: bold;">Venezolano</option>
                      <option style="font-weight: bold;">Extranjero</option>
                  </select>
                  <select class="form-control m-b " name="estado">
                      <option style="font-weight: bold;">Estado</option>
                      <option style="font-weight: bold;">Interno</option>
                      <option style="font-weight: bold;">Externo</option>
                  </select>
                  </div>
              </div>
          </fieldset>
      </form>
  </div>
  <br>
  <p class="fw-bold bg-primary" style="font-size: 40px; color: white; padding: 10px; text-align: center;">DATOS GENERALES</p>
  <div class="parent" style="display: grid; grid-template-columns: repeat(4, 1fr); grid-template-rows: repeat(4, 1fr); gap: 8px;">
      <div class="div1" style="grid-column-start: 1; grid-row-start: 1; background-color: white; font-size: 20px; font-weight: bold;">DOCUMENTO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">DNI</option>
          <option value="opcion2">C. EXTRANJERO</option>
        </select>
      </div>
      <div class="div2" style="grid-column-start: 1; grid-row-start: 2; background-color: white; font-size: 20px; font-weight: bold;">GENERO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Hombre</option>
          <option value="opcion2">Mujer</option>
          <option value="opcion3">Inclusivo</option>
        </select>
      </div>
      <div class="div3" style="grid-column-start: 1; grid-row-start: 3; background-color: white; font-size: 20px; font-weight: bold;">CORREO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Correo</option>
        </select>
      </div>
      <div class="div4" style="grid-column-start: 1; grid-row-start: 4; background-color: white; font-size: 20px; font-weight: bold;">C. PROFECIONAL
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Ingenierio</option>
          <option value="opcion2">Tecnico</option>
        </select>
      </div>
      <div class="div5" style="grid-column-start: 2; grid-row-start: 1; background-color: white; font-size: 20px; font-weight: bold;">N. DOCUMENTO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">86593588</option>
        </select>
      </div>
      <div class="div6" style="grid-column-start: 2; grid-row-start: 2; background-color: white; font-size: 20px; font-weight: bold;">CELULAR
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">859685421</option>
        </select>
      </div>
      <div class="div7" style="grid-column-start: 2; grid-row-start: 3; background-color: white; font-size: 20px; font-weight: bold;">DIRECCION
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">centro de lima</option>
        </select>
      </div>
      <div class="div8" style="grid-column-start: 2; grid-row-start: 4; background-color: white; font-size: 20px; font-weight: bold;">ESTADO CIVIL
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Soltero</option>
          <option value="opcion2">Encadenado</option>
          <option value="opcion3">Otro</option>
        </select>
      </div>
      <div class="div9" style="grid-column-start: 3; grid-row-start: 1; background-color: white; font-size: 20px; font-weight: bold;">F. NACIMEINTO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Fecha</option>
        </select>
      </div>
      <div class="div10" style="grid-column-start: 3; grid-row-start: 2; background-color: white; font-size: 20px; font-weight: bold;">TELEFONO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">+51 859685421</option>
        </select>
      </div>
      <div class="div11" style="grid-column-start: 3; grid-row-start: 3; background-color: white; font-size: 20px; font-weight: bold;">NIVEL EDUCATIVO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Inicial</option>
          <option value="opcion2">Primaria</option>
          <option value="opcion3">Secundaria</option>
        </select>
      </div>
      <div class="div12" style="grid-column: span 2 / span 2; grid-row: span 4 / span 4; grid-column-start: 4; grid-row-start: 1; background-color: white; font-size: 20px; font-weight: bold;">IMAGEN PARA SUBIR FOTO</div>
  </div>
  <br>
  <p class="fw-bold bg-primary" style="font-size: 40px; color: white; padding: 10px; text-align: center; align-items: center;">DATOS LABORALES</p>
  <div class="parent" style="display: grid; grid-template-columns: repeat(4, 1fr); grid-template-rows: repeat(4, 1fr); gap: 8px;">
      <div class="div1" style="grid-column-start: 1; grid-row-start: 1; background-color: white; font-size: 20px; font-weight: bold; text-align:center;">AREA
        <select style="margin-top: 5px; width: 100%;">
            <option value="opcion1">Central</option>
            <option value="opcion2">Wilson</option>
        </select>
    </div>
      <div class="div2" style="grid-column-start: 1; grid-row-start: 2; background-color: white; font-size: 20px; font-weight: bold; text-align:center;">TURNO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Mañana</option>
          <option value="opcion2">Tarde</option>
          <option value="opcion3">Noche</option>
        </select>
      </div>
      <div class="div3" style="grid-column-start: 1; grid-row-start: 3; background-color: white; font-size: 20px; font-weight: bold;">FORMA DE PAGO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">BCP</option>
          <option value="opcion2">Interbanc</option>
          <option value="opcion3">Yape</option>
        </select>
      </div>
      <div class="div4" style="grid-column-start: 1; grid-row-start: 4; background-color: white; font-size: 20px; font-weight: bold;">T. CONTRATO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Fijo</option>
          <option value="opcion2">Temporada</option>
          <option value="opcion3">Practicante</option>
        </select>
      </div>
      <div class="div5" style="grid-column-start: 2; grid-row-start: 1; background-color: white; font-size: 20px; font-weight: bold;">CARGO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Supervisor</option>
          <option value="opcion2">Vendedor</option>
          <option value="opcion3">Jefe de area</option>
        </select>
      </div>
      <div class="div6" style="grid-column-start: 2; grid-row-start: 2; background-color: white; font-size: 20px; font-weight: bold;">SALARIO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">S/ 1200</option>
          <option value="opcion2">S/ 650</option>
          <option value="opcion3">eres practicante</option>
        </select>
      </div>
      <div class="div7" style="grid-column-start: 2; grid-row-start: 3; background-color: white; font-size: 20px; font-weight: bold;">BANCO ABONADO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">BCP</option>
          <option value="opcion2">Interbanc</option>
          <option value="opcion3">BBVA</option>
        </select>
      </div>
      <div class="div8" style="grid-column-start: 2; grid-row-start: 4; background-color: white; font-size: 20px; font-weight: bold;">R. PENSIONARIO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">RELLENAR</option>
          <option value="opcion2">RELLENAR</option>
          <option value="opcion3">RELLENAR</option>
        </select>
      </div>
      <div class="div9" style="grid-column-start: 3; grid-row-start: 1; background-color: white; font-size: 20px; font-weight: bold;">T. TRABAJO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Interno</option>
          <option value="opcion2">Externo</option>
        </select>
      </div>
      <div class="div10" style="grid-column-start: 3; grid-row-start: 2; background-color: white; font-size: 20px; font-weight: bold;">F. VINCULACION
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Fecha</option>
        </select>
      </div>
      <div class="div11" style="grid-column-start: 3; grid-row-start: 3; background-color: white; font-size: 20px; font-weight: bold;"># CUENTA
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">0-00-000000000000</option>
        </select>
      </div>
      <div class="div13" style="grid-column-start: 3; grid-row-start: 4; background-color: white; font-size: 20px; font-weight: bold;">L. CONDUCIR
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Vigente</option>
          <option value="opcion2">Cancelado</option>
        </select>
      </div>
      <div class="div15" style="grid-column-start: 4; grid-row-start: 3; background-color: white; font-size: 20px; font-weight: bold;">S. DE SALUD
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">ESSALUD</option>
          <option value="opcion2">SAN FELIPE</option>
          <option value="opcion3">JAVIER PRADO</option>
        </select>
      </div>
      <div class="div16" style="grid-column-start: 4; grid-row-start: 2; background-color: white; font-size: 20px; font-weight: bold;">F. RETIRO
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Fecha</option>
        </select>
      </div>
      <div class="div17" style="grid-column-start: 4; grid-row-start: 1; background-color: white; font-size: 20px; font-weight: bold;">SEDE
        <select style="margin-top: 5px; width: 100%;">
          <option value="opcion1">Central</option>
          <option value="opcion2">Tienda local</option>
        </select>
      </div>
  </div>
  <br>
  <p class="fw-bold bg-primary" style="font-size: 40px; color: white; padding: 10px; text-align: center; align-items: center;">GUARDAR DATOS</p>
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