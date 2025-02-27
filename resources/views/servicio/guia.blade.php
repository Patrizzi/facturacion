@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('content')
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">





<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

<style>
#page-wrapper {
    position: inherit;
    padding-bottom: 50px;  /* Espacio adicional para no tapar el anuncio */
}




.boton-container {

    display: flex;
    border-bottom: 2px solid black;
}

.boton {
    padding: 8px 11px;
    border: 2px solid black;
    border-bottom: 1px solid black;
    background-color: white;
    color: gray;
    cursor: pointer;
    font-size: 16px;
    margin: 0 5px;
    position: relative;
}
    .boton:hover {
       color: black;
    }

    .numero1 {
        display: inline-block;
        width: 26px;
        height: 26px;
        font-size: 12px;
        color: black;
        background-color: rgb(128, 189, 37);
        text-align: center;
        line-height: 20px;
        border-radius: 3px;
    }
    .numero2 {

        display: inline-block;
        width: 26px;
        height: 26px;
        font-size: 12px;
        color: black;
        background-color: rgb(184, 95, 13);
        text-align: center;
        line-height: 20px;
        border-radius: 3px;
    }
    .numero3 {
    display: inline-block;
    width: 26px;
    height: 26px;
    font-size: 12px;
    color: black;
    background-color: rgb(13, 184, 127);
    text-align: center;
    line-height: 20px;
    border-radius: 3px;
    }

    .contenido {
        display: none;
    }

    .contenido.activo {
        display: block;
    }
.boton.activo {
    color: black; /* Texto negro cuando está activo */
    border-bottom: 2px solid white; /* Hace que parezca que no tiene borde abajo */
    font-weight: bold;
    margin-bottom: -2px; /* Para pegarlo a la línea negra */
}

</style>

<div class="boton-container">
    <button class="boton activo" onclick="mostrarSeccion('seccion1', this)">
        <span class="numero1">1</span> Guía de Ingreso
    </button>

    <button class="boton" onclick="mostrarSeccion('seccion2', this)">
        <span class="numero2">2</span> Guía de Salida
    </button>
    <button class="boton" onclick="mostrarSeccion('seccion3', this)">
        <span class="numero3">3</span> Informe tecnico
    </button>
</div>



<!-- Sección 1 - Guía de Ingreso -->
<div id="seccion1" class="contenido activo">
    <style>
        .wrappercontenedor {
            display: flex;
            justify-content: center;
            gap: 80px; /* Mayor separación entre los contenedores */
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .containercontenedor {
            border: 2px solid #000;
            border-radius: 10px;
            padding: 5px;
            box-sizing: border-box;
            background-color: #f9f9f9;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.1);
            width: 620px; /* Aumenté el ancho para mejor visualización */
            height: 220px; /* Un poco más alto para mayor comodidad */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .containercontenedor2 {
            border: 2px solid #000;
            border-radius: 10px;
            padding: 20px;
            box-sizing: border-box;
            background-color: #f9f9f9;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.1);
            width: 620px; /* Aumenté el ancho para mejor visualización */
            height: 210px; /* Un poco más alto para mayor comodidad */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin-top: -40px;
            transform: translateY(-30px)
        }
        .containercontenedor1 {
            border: 2px solid #000;
            border-radius: 10px;
            padding: 20px;
            box-sizing: border-box;
            background-color: #f9f9f9;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.1);
            width: 620px; /* Aumenté el ancho para mejor visualización */
            height: 280px; /* Un poco más alto para mayor comodidad */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .containercontenedor3 {
            border: 2px solid #000;
            border-radius: 10px;
            padding: 20px;
            box-sizing: border-box;
            background-color: #f9f9f9;
            box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.1);
            width: 620px; /* Aumenté el ancho para mejor visualización */
            height: 130px; /* Un poco más alto para mayor comodidad */
            display: flex;
            flex-direction: column;
            margin-top: 40px;
            justify-content: space-between;
        }

        .container-titlecontenedor {
            text-align: center;
            font-weight: bold;
            font-size: 25px;
            margin-bottom: 2px;
            color: #333;
            border-bottom: 2px solid #000;
            padding-bottom: 3px;
        }

        .input-groupcontenedor {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px; /* Más espacio entre filas */
            width: 100%;
        }

        .input-labelcontenedor {
            font-weight: bold;
            font-size: 14px; /* Aumenté el tamaño para mejor lectura */
            color: #444;
            padding: 5px;
        }

        .input-fieldcontenedor {
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
            font-size: 11px;
            width: 35%;
        }

        .input-fieldcontenedor.full-widthcontenedor {
            width: 100%;
        }

        .input-fieldcontenedor:focus {
            border-color: #000;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }
    </style>

    <div class="wrappercontenedor">

        <!-- Contenedor izquierdo -->
        <div class="containercontenedor">

            <h2 class="container-titlecontenedor">Cliente</h2>

            <div class="input-groupcontenedor">
                <label for="dni" class="input-labelcontenedor">DNI/RUC:</label>
                <input type="number" id="dni" name="dni" class="input-fieldcontenedor" placeholder="Ingrese DNI/RUC" required>

                <label for="nombre" class="input-labelcontenedor">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="input-fieldcontenedor" placeholder="Ingrese Nombre" required>
            </div>

            <div class="input-groupcontenedor">
                <label for="direccion" class="input-labelcontenedor">Dirección:</label>
                <input type="text" id="direccion" name="direccion" class="input-fieldcontenedor full-widthcontenedor" placeholder="Ingrese Dirección" required>
            </div>

            <div class="input-groupcontenedor">
                <label for="contacto" class="input-labelcontenedor">Contacto:</label>
                <input type="text" id="contacto" name="contacto" class="input-fieldcontenedor" placeholder="Ingrese Contacto" required>

                <label for="telefono" class="input-labelcontenedor">Teléfono:</label>
                <input type="number" id="telefono" name="telefono" class="input-fieldcontenedor" placeholder="Ingrese Teléfono" required>
            </div>
        </div>

        <!-- Contenedor derecho -->
        <div class="containercontenedor3">
            <h2 class="container-titlecontenedor">Datos Generales</h2>

            <div class="input-groupcontenedor">
                <label for="recepcionista" class="input-labelcontenedor">Recepcionista:</label>
                <input type="text" id="recepcionista" name="recepcionista" class="input-fieldcontenedor" placeholder="Ingrese Recepcionista" required>

                <label for="fecha_ingreso" class="input-labelcontenedor">Fecha Ingreso:</label>
                <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="input-fieldcontenedor" required>
            </div>
        </div>
    </div>
    <!-- CSS DE VIÑETA -->
    <style>

        .accordion {
            margin-top: 50px;
        }
        .accordion-button {
            background-color: lightblue;
            color: black;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-right: 20px;
            padding-left: 15px;
            border: none;
        }
        .accordion-button::after {
            content: none;
        }
        .accordion-button:focus {
            box-shadow: none;
        }
        .accordion-button:hover {
            background-color: lightskyblue;
        }
        .accordion-body {
            background-color: mintcream;
            color: darkslategray;
            font-size: 1.1em;
            padding: 15px;
        }
        .accordion-toggle-btn {
            font-size: 1.5em;
            font-weight: bold;
            transition: transform 0.3s;
        }
        .accordion-button:not(.collapsed) .accordion-toggle-btn {
            transform: rotate(45deg);
        }
        .accordion-button .btn {
            margin-left: 10px;
        }
        .flex-container {
            align-items: center;
        }

        .bton1{
            width: 200px;
            height: 45px;
            background-color: #007bff;
            color: white;
            font-size: 20px;
            font-weight: bold;
            border: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .bton1:hover {
            background-color: #0056b3;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .bton1:active {
            background-color: #004085;
            transform: translateY(0);
            box-shadow: none;
        }

        #page-wrapper {
               position: inherit;
               padding-bottom: 50px;
            }

</style>

    <!-- Viñeta de ingreso -->
    <div class="accordion accordion-flush" id="accordionFlushExample1">
        <div class="accordion-item">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne1" aria-expanded="false" aria-controls="flush-collapseOne1">
               Garantías de {{ $cliente->nombre }}
              <span class="accordion-toggle-btn">+</span> <!-- "+" al final del botón -->
            </button>
          </h2>
          <div id="flush-collapseOne1" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample1">
            <div class="accordion-body">
                <div class="search-container">
                    <form class="search-form" action="index.php?ruta=store/buscar_productos" method="POST">
                        <div class="input-group">
                            <input type="search" class="form-control search-input" name="search" placeholder="Buscar Producto" required>
                            <button class="btn btn-primary search-btn" type="submit">
                                <i class="bi bi-search">Buscar</i>
                            </button>
                        </div>
                    </form>
                </div>
                <!-- CSS de las tablas de ingreso -->
                        <style>
                        .search-container{
                            justify-content: center;
                            display:flex;
                        }
                        .custom-search {
                            max-width: 500px; /* Puedes ajustar el tamaño aquí */
                            width: 100%; /* O puedes usar un porcentaje si prefieres que sea relativo */
                        }

                        .table-container {
                            margin-top: 40px; /* Baja la tabla 40px */
                        }
                        .table thead {
                            background-color: white;
                            color: #15338a;
                            text-align: center;
                        }

                        .table {
                            border: 2px solid black;
                        }

                        .table th, .table td {
                            border: 1px solid black !important;
                            padding: 10px;
                            text-align: center;
                            font-size: 14px;
                        }

                        .table tbody tr:nth-child(even) {
                            background-color: #f2f2f2;
                        }

                        .btn-estado {
                            background-color: #15338a;
                            color: white;
                            border: none;
                            padding: 5px 10px;
                            cursor: pointer;
                            border-radius: 5px;
                        }
                        </style>
                        <!-- tablas de ingreso -->
                        <div class="table-container table-bordered dataTables-example">
                            @if($guias->isEmpty())
        <div class="alert alert-warning text-center">
            No hay garantías disponibles para este cliente.
        </div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ITEM</th>
                    <th>Serie</th>
                    <th>Descripción</th>
                    <th>Observación</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($guias as $guia)
                    <tr>
                        <td>{{ $guia->ITEM }}</td>
                        <td>{{ $guia->Serie }}</td>
                        <td>{{ $guia->Descripción }}</td>
                        <td>{{ $guia->Observación }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
                        </div>
                </div>
            </div>
          </div>
        </div>
      </div>






<!-- Sección 2 - Guía de Salida -->
<div id="seccion2" class="contenido">
    <div >
        <!-- CLIENTES -->
        <div class="wrappercontenedor">
            <!-- Contenedor izquierdo -->
            <div class="containercontenedor1" style="align-self: flex-start;">
                <h2 class="container-titlecontenedor">Cliente</h2>

                <div class="input-groupcontenedor">
                    <label for="dni" class="input-labelcontenedor">DNI/RUC:</label>
                    <input type="number" id="dni" name="dni" class="input-fieldcontenedor" placeholder="Ingrese DNI/RUC" required>
                    <label for="nombre" class="input-labelcontenedor">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="input-fieldcontenedor" placeholder="Ingrese Nombre" required>
                </div>

                <div class="input-groupcontenedor full-widthcontenedor">
                    <label for="direccion" class="input-labelcontenedor">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" class="input-fieldcontenedor full-widthcontenedor" placeholder="Ingrese Dirección" required>
                </div>

                <div class="input-groupcontenedor">
                    <label for="contacto" class="input-labelcontenedor">Contacto:</label>
                    <input type="text" id="contacto" name="contacto" class="input-fieldcontenedor" placeholder="Ingrese Contacto" required>
                    <label for="telefono" class="input-labelcontenedor">Teléfono:</label>
                    <input type="number" id="telefono" name="telefono" class="input-fieldcontenedor" placeholder="Ingrese Teléfono" required>
                </div>

                <div class="input-groupcontenedor full-widthcontenedor">
                    <label for="sucursal" class="input-labelcontenedor">Sucursal:</label>
                    <input type="text" id="sucursal" name="sucursal" class="input-fieldcontenedor full-widthcontenedor" placeholder="Ingrese Sucursal" required>
                </div>
            </div>

            <!-- Contenedor derecho -->
            <div class="containercontenedor2" style="align-self: flex-end;">
                <h2 class="container-titlecontenedor">Datos Generales</h2>

                <div class="input-groupcontenedor">
                    <label for="recepcionista" class="input-labelcontenedor">Recepcionista:</label>
                    <input type="text" id="recepcionista" name="recepcionista" class="input-fieldcontenedor" placeholder="Ingrese Recepcionista" required>
                    <label for="fecha_ingreso" class="input-labelcontenedor">Fecha Ingreso:</label>
                    <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="input-fieldcontenedor" required>
                </div>

                <div class="input-groupcontenedor">
                    <label for="orden_servicio" class="input-labelcontenedor">Orden de servicio:</label>
                    <input type="text" id="orden_servicio" name="orden_servicio" class="input-fieldcontenedor" placeholder="Ingrese Orden" required>
                    <label for="fecha_estimada" class="input-labelcontenedor">Fecha Estimada:</label>
                    <input type="date" id="fecha_estimada" name="fecha_estimada" class="input-fieldcontenedor" required>
                </div>
            </div>

            <button class="crearbtn">CREAR</button>
<style>
    .crearbtn {
    width: 200px;
    height: 50px;
    background-color: rgb(210, 120, 30);
    color: white;
    font-size: 1.2em;
    font-weight: bold;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.crearbtn:hover {
    background-color:#9b5f23;
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

</style>




            </div>



            <!-- VIÑETA DE SALIDA -->
            <div class="accordion accordion-flush" id="accordionFlushExample3">
                <button class="bton1">mas</button>
                <div class="accordion-item">
                  <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne3" aria-expanded="false" aria-controls="flush-collapseOne3">
                      GUIA
                      <span class="accordion-toggle-btn">+</span> <!-- "+" al final del botón -->
                    </button>
                  </h2>
                  <div id="flush-collapseOne3" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample3">
                    <div class="accordion-body">


<!-- BÚSQUEDA DE PRODUCTOS -->
<div class="search-container">
    <form class="search-form" action="index.php?ruta=store/buscar_productos" method="POST">
        <div class="input-group">
            <input type="search" class="form-control search-input" name="search" placeholder="Buscar Producto" required>
            <button class="btn btn-primary search-btn" type="submit">
                <i class="bi bi-search">Buscar</i>
            </button>
        </div>
    </form>
</div>

<style>
/* Contenedor para alinear a la izquierda */
.search-container {
    display: flex;
    justify-content: center; /* Alineado a la izquierda */
    margin: 15px 0;
}

/* Formulario compacto y estilizado */
.search-form {
    width: 580px; /* Ancho controlado para que no sea muy grande */
}

/* Campo de búsqueda con diseño atractivo */
.search-input {
    border-radius: 20px 0 0 20px;
    border: 1px solid #ccc;
    padding: 8px 12px;
    font-size: 14px;
    box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
}

/* Botón de búsqueda compacto y elegante */
.search-btn {
    border-radius: 0 20px 20px 0;
    border: none;
    padding: 8px 15px;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Ajuste para icono de búsqueda */
.search-btn i {
    font-size: 16px;
}
</style>





        <!-- TABLA DE REGISTROS -->
            <div class="table-container table-bordered dataTables-example">
                <table class="table">
                    <thead class="text-black">
                        <tr>
                            <th>ITEM</th>
                            <th>SERIE</th>
                            <th>DESCRIPCIÓN</th>
                            <th>OBSERVACIÓN</th>
                            <th>FECHA</th>
                            <th>DIAGNÓSTICO</th>
                            <th>ESTADO DE APROBACIÓN</th>
                            <th>TÉCNICO DE REPARACIÓN</th>
                            <th>ESTADO DE REPARACIÓN</th>
                            <th>RECOMENDACIONES</th>
                            <th>AÑADIR IMAGEN</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>001</td>
                            <td>SN-2024X001</td>
                            <td>Laptop Dell Inspiron 15</td>
                            <td>La pantalla parpadea intermitentemente</td>
                            <td>2025-02-12</td>
                            <td>Falla en la conexión del cable flex de la pantalla</td>
                            <td>Aprobado</td>
                            <td>Pedro Gómez</td>
                            <td>Reparado</td>
                            <td>Reemplazo del cable flex y prueba de estabilidad</td>
                            <td><button class="btn btn-primary btn-sm">
                                <i class='bx bxs-cloud-upload'></i> Subir</button></td>
                            <td>
                                <select class="form-select form-select-sm" onchange="mostrarModalEditar(this)">
                                    <option selected disabled>Seleccione</option>
                                    <option value="ver">👁️ Ver</option>
                                    <option value="eliminar">🗑️ Eliminar</option>
                                    <option value="editar">✏️ Editar</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
       </div>
      </div>
    </div>
  </div>
</div>

<!-- Sección3  - informe tecnico -->
<div id="seccion3" class="contenido">
    <div >
        <!-- CLIENTES -->
        <div class="wrappercontenedor">
            <!-- Contenedor izquierdo -->
            <div class="containercontenedor1" style="align-self: flex-start;">
                <h2 class="container-titlecontenedor">Cliente</h2>

                <div class="input-groupcontenedor">
                    <label for="dni" class="input-labelcontenedor">DNI/RUC:</label>
                    <input type="number" id="dni" name="dni" class="input-fieldcontenedor" placeholder="Ingrese DNI/RUC" required>
                    <label for="nombre" class="input-labelcontenedor">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="input-fieldcontenedor" placeholder="Ingrese Nombre" required>
                </div>

                <div class="input-groupcontenedor full-widthcontenedor">
                    <label for="direccion" class="input-labelcontenedor">Dirección:</label>
                    <input type="text" id="direccion" name="direccion" class="input-fieldcontenedor full-widthcontenedor" placeholder="Ingrese Dirección" required>
                </div>

                <div class="input-groupcontenedor">
                    <label for="contacto" class="input-labelcontenedor">Contacto:</label>
                    <input type="text" id="contacto" name="contacto" class="input-fieldcontenedor" placeholder="Ingrese Contacto" required>
                    <label for="telefono" class="input-labelcontenedor">Teléfono:</label>
                    <input type="number" id="telefono" name="telefono" class="input-fieldcontenedor" placeholder="Ingrese Teléfono" required>
                </div>

                <div class="input-groupcontenedor full-widthcontenedor">
                    <label for="sucursal" class="input-labelcontenedor">Sucursal:</label>
                    <input type="text" id="sucursal" name="sucursal" class="input-fieldcontenedor full-widthcontenedor" placeholder="Ingrese Sucursal" required>
                </div>
            </div>

            <!-- Contenedor derecho -->
            <div class="containercontenedor2" style="align-self: flex-end;">
                <h2 class="container-titlecontenedor">Datos Generales</h2>

                <div class="input-groupcontenedor">
                    <label for="recepcionista" class="input-labelcontenedor">Recepcionista:</label>
                    <input type="text" id="recepcionista" name="recepcionista" class="input-fieldcontenedor" placeholder="Ingrese Recepcionista" required>
                    <label for="fecha_ingreso" class="input-labelcontenedor">Fecha Ingreso:</label>
                    <input type="date" id="fecha_ingreso" name="fecha_ingreso" class="input-fieldcontenedor" required>
                </div>

                <div class="input-groupcontenedor">
                    <label for="orden_servicio" class="input-labelcontenedor">Orden de servicio:</label>
                    <input type="text" id="orden_servicio" name="orden_servicio" class="input-fieldcontenedor" placeholder="Ingrese Orden" required>
                    <label for="fecha_estimada" class="input-labelcontenedor">Fecha Estimada:</label>
                    <input type="date" id="fecha_estimada" name="fecha_estimada" class="input-fieldcontenedor" required>
                </div>
            </div>

            <button class="crearbtn2">CREAR</button>
<style>
    .crearbtn2 {
    width: 200px;
    height: 50px;
    background-color: rgb(42, 188, 108);
    color: white;
    font-size: 1.2em;
    font-weight: bold;
    border: none;
    border-radius: 30px;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.crearbtn2:hover {
    background-color:#418818;
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
}

</style>




</div>



     <!-- VIÑETA DE tecnico -->
    <div class="accordion accordion-flush" id="accordionFlushExample3">
        <div class="accordion-item">
            <h2 class="accordion-header">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOnetecnico1" aria-expanded="false"
            aria-controls="flush-collapseOnetecnico1">
                GUIA
                <span class="accordion-toggle-btn">+</span> <!-- "+" al final del botón -->
            </button>
                </h2>
        <div id="flush-collapseOnetecnico1" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExampletecnico1">
    <div class="accordion-body">


<!-- BÚSQUEDA DE PRODUCTOS -->
<div class="search-container">
    <form class="search-form" action="index.php?ruta=store/buscar_productos" method="POST">
        <div class="input-group">
            <input type="search" class="form-control search-input" name="search" placeholder="Buscar Producto" required>
            <button class="btn btn-primary search-btn" type="submit">
                <i class="bi bi-search">Buscar</i>
            </button>
        </div>
    </form>
</div>

        <!-- TABLA DE REGISTROS -->
            <div class="table-container table-bordered dataTables-example">
            <table class="table">
                    <thead class="text-black">
                        <tr>
                            <th>ITEM</th>
                            <th>SERIE</th>
                            <th>DESCRIPCIÓN</th>
                            <th>OBSERVACIÓN</th>
                            <th>FECHA</th>
                            <th>DIAGNÓSTICO</th>
                            <th>ESTADO DE APROBACIÓN</th>
                            <th>TÉCNICO DE REPARACIÓN</th>
                            <th>ESTADO DE REPARACIÓN</th>
                            <th>RECOMENDACIONES</th>
                            <th>AÑADIR IMAGEN</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>001</td>
                            <td>SN-2024X001</td>
                            <td>Laptop Dell Inspiron 15</td>
                            <td>La pantalla parpadea intermitentemente</td>
                            <td>2025-02-12</td>
                            <td>Falla en la conexión del cable flex de la pantalla</td>
                            <td>Aprobado</td>
                            <td>Pedro Gómez</td>
                            <td>Reparado</td>
                            <td>Reemplazo del cable flex y prueba de estabilidad</td>
                            <td><button class="btn btn-primary btn-sm">
                                <i class='bx bxs-cloud-upload'></i> Subir</button></td>
                            <td>
                                <select class="form-select form-select-sm" onchange="mostrarModalEditar(this)">
                                    <option selected disabled>Seleccione</option>
                                    <option value="ver">👁️ Ver</option>
                                    <option value="eliminar">🗑️ Eliminar</option>
                                    <option value="editar">✏️ Editar</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
       </div>
      </div>
    </div>
  </div>
</div>

{{-- Modal al seleccionar la opcion de editar en accione --}}

<div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarLabel">Editar Registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Estado de aprobacion</th>
                            <th>Técnico de reparacion</th>
                            <th>Estado de reparacion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="text" class="form-control" value=""></td>
                            <td><input type="text" class="form-control" value=""></td>
                            <td><input type="text" class="form-control" value=""></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

<script>
    function mostrarSeccion(id, boton) {
        document.querySelectorAll('.contenido').forEach(seccion => {
            seccion.classList.remove('activo');
        });

        document.getElementById(id).classList.add('activo');

        document.querySelectorAll('.boton').forEach(b => {
            b.classList.remove('activo');
        });

        boton.classList.add('activo');
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector(".boton").classList.add("activo");
    });

    function mostrarModalEditar(select) {
        if (select.value === "editar") {
            var modal = new bootstrap.Modal(document.getElementById('modalEditar'));
            modal.show();
            select.value = "Seleccione";
        }
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@endsection
