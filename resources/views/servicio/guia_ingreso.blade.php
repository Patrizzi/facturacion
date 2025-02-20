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
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<style>
.boton-container {
    display: flex;
    border-bottom: 2px solid black; /* Línea horizontal larga */
}

.boton {
    padding: 10px 20px;
    border: 2px solid black; /* Borde negro en todos los lados */
    border-bottom: 1px solid black; /* Línea inferior más delgada */
    background-color: white;
    color: gray;
    cursor: pointer;
    font-size: 16px;
    margin: 0 5px;
    position: relative; /* Para controlar la línea de abajo */
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
</div>



<!-- Sección 1 - Guía de Ingreso -->
<div id="seccion1" class="contenido activo">
    <style>
        .wrappercontenedor {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px; /* Bajé el margen superior para acercar el título */
        }

        .containercontenedor {
            border: 2px solid #000;
            color: black;
            border-radius: 10px;
            padding: 20px;
            box-sizing: border-box;
        }

        .container-titlecontenedor {
            transform: translateY(-20px);
            text-align: center;
            font-weight: bold;
            font-size: 26px; /* Subí un poco el tamaño del título */
            margin-bottom: 20px; /* Reduje la separación del título */
        }

        .input-labelcontenedor {
            font-weight: bold; /* Ahora los textos están en negrita */
        }



        </style>

        <div class="wrappercontenedor">
            <!-- Contenedor izquierdo -->
            <div class="containercontenedor" style="align-self: flex-start;">
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
            <div class="containercontenedor" style="align-self: flex-end;">
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
            </div>


            <style>
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

            <div class="table-container table-bordered dataTables-example">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ITEM</th>
                            <th>Serie</th>
                            <th>Descripción</th>
                            <th>Observación</th>
                            <th>Tecnico de diagnostico</th>
                            <th>Fecha</th>
                            <th>Diagnostico</th>
                            <th>Estado de Aprobacion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>01</td>
                            <td>LKDO</td>
                            <td>laptop ph con lentitud</td>
                            <td>la primera vista del tecnico al producto donde nota cosas que el cliente no</td>
                            <td>Juana</td>
                            <td>10/10/23</td>
                            <td>Disco duro roto</td>
                            <td><button class="btn-estado">Aceptado</button></td>
                        </tr>
                        <tr>
                            <td>02</td>
                            <td>L10L</td>
                            <td>impresora epson no imprime</td>
                            <td>la primera vista del tecnico al producto donde nota cosas que el cliente no</td>
                            <td>Angel</td>
                            <td>10/10/23</td>
                            <td>Falta de refrigeranción</td>
                            <td><button class="btn-estado">Aceptado</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
</div>

<!-- Sección 2 - Guía de Salida -->
<div id="seccion2" class="contenido">
    <h2>Guía de Salida</h2>
    <p>Aquí va la información de la guía de salida...</p>
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

</script>


@endsection
