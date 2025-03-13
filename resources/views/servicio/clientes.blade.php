@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atras')
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
<link rel="stylesheet" href="{{ asset('css/servicio-tecnico/cliente.css') }}">
<style>
    /* Estilos personalizados para el modal */
    .custom-modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .custom-modal-content {
        background-color: white;
        margin: 5% auto; /* Reducido de 10% a 5% para mejor centrado vertical */
        padding: 20px;
        border-radius: 5px;
        width: 80%;
        max-width: 700px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .custom-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    .custom-modal-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
    }

    .custom-close {
        font-size: 1.5rem;
        font-weight: bold;
        cursor: pointer;
        color: #aaa;
    }

    .custom-close:hover {
        color: #333;
    }

    .custom-form-group {
        margin-bottom: 15px;
    }

    .custom-label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    .custom-select, .custom-input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .productos-section {
        margin-top: 20px;
    }

    .productos-title {
        font-size: 1.2rem;
        font-weight: bold;
        margin-bottom: 15px;
    }

    .producto-row {
        display: flex;
        gap: 10px;
        margin-bottom: 10px;
    }

    .add-btn {
        background-color: #28a745;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 8px 12px;
        cursor: pointer;
    }

    .remove-btn {
        background-color: #dc3545;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 8px 12px;
        cursor: pointer;
    }

    .footer-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid #eee;
    }

    .btn-cerrar {
        background-color: #6c757d;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 8px 18px;
        cursor: pointer;
    }

    .btn-guardar {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        padding: 8px 18px;
        cursor: pointer;
    }

    /* Estilo para productos agregados */
    .producto-agregado {
        display: flex;
        border-left: 3px solid #007bff;
        padding: 10px;
        margin-bottom: 8px;
        background-color: #f8f9fa;
        border-radius: 0 4px 4px 0;
    }

    .producto-info {
        flex: 1;
    }

    .producto-nombre, .producto-serie, .producto-observacion {
        margin-bottom: 0;
    }

    .producto-label {
        font-weight: bold;
    }

    .productos-agregados-container {
        margin-top: 15px;
        margin-bottom: 15px;
    }
</style>
<div class= "Div-agregar">
    <h2 id= "titulo-guia-servicio">Guias servicio</h2>
    <button id="btn-agregar-guia">Agregar</button>
    <div id="productoModal" class="custom-modal">
        <div class="custom-modal-content">
            <div class="custom-modal-header">
                <h2 class="custom-modal-title">Gestión de Productos</h2>
                <span class="custom-close">&times;</span>
            </div>

            <div class="custom-form-group">
                <label class="custom-label">Cliente:</label>
                <select class="custom-select" id="cliente-select">
                    <option value="">Seleccionar cliente</option>
                    <option value="1">Cliente Ejemplo 1</option>
                    <option value="2">Cliente Ejemplo 2</option>
                </select>
            </div>

            <div class="productos-section">
                <h3 class="productos-title">PRODUCTOS</h3>

                <div id="formulario-producto">
                    <div class="producto-row">
                        <div style="flex: 1;">
                            <label class="custom-label">nombre</label>
                            <input type="text" class="custom-input" id="producto-nombre">
                        </div>
                        <div style="flex: 1;">
                            <label class="custom-label">serie</label>
                            <input type="text" class="custom-input" id="producto-serie">
                        </div>
                        <div style="flex: 1;">
                            <label class="custom-label">observacion</label>
                            <input type="text" class="custom-input" id="producto-observacion">
                        </div>
                        <div style="align-self: flex-end; margin-bottom: 2px;">
                            <button class="add-btn" id="btn-add-producto">+</button>
                        </div>
                    </div>
                </div>

                <!-- Contenedor para productos agregados -->
                <div id="productos-agregados" class="productos-agregados-container"></div>
            </div>

            <div class="footer-buttons">
                <button class="btn-cerrar" id="btn-cerrar">Cerrar</button>
                <button class="btn-guardar" id="btn-guardar">Guardar Cambios</button>
            </div>
        </div>
    </div>

</div>
<table id="clientesTabla" class="table table-bordered dataTables-example">
    <thead>
        <tr>
            <th>NRO GUIA</th>
            <th>CLIENTE</th>
            <th>ORDEN DE SERVICIO</th>
            <th>CELULAR</th>
            <th>FECHA</th>
            <th>ACCIONES</th>
        </tr>
    </thead>
    <tbody>
        {{--  @foreach ($ as $)
            <tr>
                <td>{{ $-> }}</td>
                <td>{{ $->}}</td>
                <td>{{ $-> }}</td>
                <td>{{ $-> }}</td>
                <td>{{ $-> }}</td>
                <td>{{ $-> }}</td>
                <td>{{ $-> }}</td>
                <td class="text-center">
                    @if(in_array($->id, $clientesConGuias))
                        <a href="{{ route('cliente.guia', $->) }}" class="btn btn-info btn-sm">
                            <i class="fa fa-file-alt"></i> Guía
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach--}}
    </tbody>
</table>

<script>
    $(document).ready(function () {
    $('.dataTables-example').DataTable({
        dom: '<"top"lf>rt<"bottom"ip><"clear">',
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "Todo"]
        ],
        pageLength: 10,
        language: {
            lengthMenu: "Mostrar _MENU_ registros por página",
            search: "Buscar:",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoFiltered: "(filtrado de _MAX_ registros totales)",
            paginate: {
                previous: "Anterior",
                next: "Siguiente"
            }
        }
    });
});
</script>
<script>
    // JavaScript para manejar el modal y agregar productos
    $(document).ready(function() {
        // Abrir modal
        $("#btn-agregar-guia").click(function() {
            $("#productoModal").fadeIn(300);
        });

        // Cerrar modal
        $(".custom-close, #btn-cerrar").click(function() {
            $("#productoModal").fadeOut(200);
        });

        // Cerrar modal haciendo clic fuera del contenido
        $(window).click(function(e) {
            if ($(e.target).is(".custom-modal")) {
                $("#productoModal").fadeOut(200);
            }
        });

        // Contador para IDs únicos
        let productoCount = 0;

        // Agregar nuevo producto
        $("#btn-add-producto").click(function() {
            const nombre = $("#producto-nombre").val();
            const serie = $("#producto-serie").val();
            const observacion = $("#producto-observacion").val();

            // Validación básica
            if (!nombre || !serie) {
                alert("Por favor ingrese al menos nombre y serie del producto");
                return;
            }

            // Crear ID único para este producto
            const productoId = 'producto-' + productoCount++;

            // Agregar el producto a la lista de productos
            const productoHTML = `
                <div class="producto-agregado" id="${productoId}">
                    <div class="producto-info">
                        <p class="producto-nombre"><span class="producto-label">Nombre:</span> ${nombre}</p>
                        <p class="producto-serie"><span class="producto-label">Serie:</span> ${serie}</p>
                        <p class="producto-observacion"><span class="producto-label">Observación:</span> ${observacion}</p>
                        <input type="hidden" name="productos[${productoId}][nombre]" value="${nombre}">
                        <input type="hidden" name="productos[${productoId}][serie]" value="${serie}">
                        <input type="hidden" name="productos[${productoId}][observacion]" value="${observacion}">
                    </div>
                    <div>
                        <button class="remove-btn" data-id="${productoId}">X</button>
                    </div>
                </div>
            `;

            $("#productos-agregados").append(productoHTML);

            // Limpiar el formulario para el siguiente producto
            $("#producto-nombre").val('');
            $("#producto-serie").val('');
            $("#producto-observacion").val('');
            $("#producto-nombre").focus();
        });

        // Eliminar producto (delegación de eventos)
        $(document).on('click', '.remove-btn', function() {
            const productoId = $(this).data('id');
            $(`#${productoId}`).remove();
        });

        // Guardar cambios
        $("#btn-guardar").click(function() {
            // Recoger los productos
            var productos = [];
            $(".producto-agregado").each(function() {
                const id = $(this).attr('id');
                const nombre = $(`input[name="productos[${id}][nombre]"]`).val();
                const serie = $(`input[name="productos[${id}][serie]"]`).val();
                const observacion = $(`input[name="productos[${id}][observacion]"]`).val();

                productos.push({
                    nombre: nombre,
                    serie: serie,
                    observacion: observacion
                });
            });

            // Obtener el cliente seleccionado
            var cliente = $("#cliente-select").val();

            // Aquí tendrías todos los datos para enviar
            var datos = {
                cliente: cliente,
                productos: productos
            };

            console.log("Datos a guardar:", datos);

            // Aquí podrías hacer una llamada AJAX para guardar los datos
            // Por ejemplo:
            /*
            $.ajax({
                url: 'tu-endpoint-de-guardado',
                type: 'POST',
                data: JSON.stringify(datos),
                contentType: 'application/json',
                success: function(response) {
                    alert('Datos guardados correctamente');
                    $("#productoModal").fadeOut(200);
                },
                error: function(error) {
                    alert('Error al guardar los datos');
                    console.error(error);
                }
            });
            */

            // Por ahora solo mostramos un mensaje y cerramos el modal
            alert("Datos guardados correctamente");
            $("#productoModal").fadeOut(200);
        });
    });
</script>
@endsection

