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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<div class= "Div-agregar">
    <h2 id= "titulo-guia-servicio">Guias servicio</h2>
    <button id="btn-agregar-guia">Agregar</button>
    <div id="productoModal" class="custom-modal">
        <form id="producto-form" method="POST" action="{{ route('sGuias.store') }}">
            @csrf
            <div class="custom-modal-content">
                <div class="custom-modal-header">
                    <h2 class="custom-modal-title">Gestión de Productos</h2>
                    <span class="custom-close">&times;</span>
                </div>

                <div class="custom-form-group">
                    <label class="custom-label">Cliente:</label>
                    <select class="custom-select" id="cliente-select" name="cliente_id" required>
                        <option value="">Seleccionar cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="productos-section">
                    <h3 class="productos-title">PRODUCTOS</h3>

                    <div id="formulario-producto">
                        <div class="producto-row">
                            <div style="flex: 1;">
                                <label class="custom-label">Nombre</label>
                                <input type="text" class="custom-input" id="producto-nombre" name="producto">
                            </div>
                            <div style="flex: 1;">
                                <label class="custom-label">Serie</label>
                                <input type="text" class="custom-input" id="producto-serie" name="serie">
                            </div>
                            <div style="flex: 1;">
                                <label class="custom-label">Observación</label>
                                <input type="text" class="custom-input" id="producto-observacion" name="observacion">
                            </div>
                            <div style="align-self: flex-end; margin-bottom: 2px;">
                                <button type="button" class="add-btn" id="btn-add-producto">+</button>
                            </div>
                        </div>
                    </div>

                    <!-- Contenedor para productos agregados -->
                    <div id="productos-agregados" class="productos-agregados-container"></div>
                </div>

                <div class="footer-buttons">
                    <button type="button" class="btn-cerrar" id="btn-cerrar">Cerrar</button>
                    <button type="submit" class="btn-guardar" id="btn-guardar">Guardar Cambios</button>
                </div>
            </div>
        </form>
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
         @foreach ($servicioGuias as $guia)
            <tr>
                <td>{{ $guia->nro_guia }}</td>
                <td>{{ $guia->cliente->nombre }}</td>
                <td>{{ $guia->orden_servicio ?? '-' }}</td>
                <td>{{ $guia->cliente->celular ?? '-' }}</td>
                <td>{{ $guia->fecha }}</td>
                <td class="text-center">
                    {{-- <a href="{{ route('cliente.guia', $guia->id) }}" class="btn btn-info btn-sm">
                        <i class="fa fa-file-alt"></i> Guía
                    </a> --}}
                </td>
            </tr>
        @endforeach
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
    $(document).ready(function() {
        $('#cliente-select').select2({
            placeholder: "Buscar cliente...",
            allowClear: true,
        });
    });
</script>

<script>
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
        const productoId = productoCount++;

        // Agregar el producto a la lista de productos
        const productoHTML = `
            <div class="producto-agregado" id="producto-${productoId}">
                <div class="producto-info">
                    <p class="producto-nombre"><span class="producto-label">Nombre:</span> ${nombre}</p>
                    <p class="producto-serie"><span class="producto-label">Serie:</span> ${serie}</p>
                    <p class="producto-observacion"><span class="producto-label">Observación:</span> ${observacion}</p>
                    <input type="hidden" name="sDetalleGuiaIngreso[${productoId}][producto]" value="${nombre}">
                    <input type="hidden" name="sDetalleGuiaIngreso[${productoId}][serie]" value="${serie}">
                    <input type="hidden" name="sDetalleGuiaIngreso[${productoId}][observacion]" value="${observacion}">
                </div>
                <div>
                    <button type="button" class="remove-btn" data-id="producto-${productoId}">X</button>
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

    // Validar formulario antes de enviar
    $("#producto-form").on('submit', function(e) {
        // Verificar si hay productos agregados
        if ($(".producto-agregado").length === 0) {
            alert("Por favor agregue al menos un producto");
            e.preventDefault();
            return false;
        }

        var cliente = $("#cliente-select").val();

        if (!cliente) {
            alert("Por favor seleccione un cliente");
            e.preventDefault();
            return false;
        }

        return true;
    });
});
</script>
@endsection

