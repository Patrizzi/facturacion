@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atras')
@section('atributo_actu', 'hidden')

@section('content')
<link rel="stylesheet" href="{{ asset('css/servicio-tecnico/cliente.css') }}">

<div class="wrapper wrapper-conten animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                            @include('servicio._shared.second-tabs')
                            <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                <button class="btn btn-primary" id="btn-agregar-guia" data-toggle="modal" data-target="#productoModal">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </ul>
                        </ul>

                        <div class="tabs-content">
                            <div class="tab-pane active show" id="tab-1">
                                <br>
                                <div class="search-responsive" style="padding-right: 15px;padding-left: 15px;">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="daterange"
                                                            id="data_range_filter" value="" readonly="readonly" />
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-secondary" id="revert_select">
                                                                <i class="fa fa-history"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <input type="search" class="form-control" placeholder="Buscar:"
                                                        id="search_all_column">
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-sm-12">
                                            <button type="button" class="btn btn-block btn-primary"
                                                        id="filter_buttons">Buscar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="clientesTabla" class="table table-striped table-bordered table-hover">
                                        <thead class="bg-white">
                                            <tr>
                                                <th>Código</th>
                                                <th>Nombre</th>
                                                <th>Orden de servicio</th>
                                                <th>Celular</th>
                                                <th>Fecha</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($servicioGuias as $guia)
                                                <tr class="gradeX">
                                                    <td>{{ $guia->nro_guia }}</td>
                                                    <td>{{ $guia->cliente->nombre }}</td>
                                                    <td>{{ $guia->orden_servicio ?? '-' }}</td>
                                                    <td>{{ $guia->cliente->celular ?? '-' }}</td>
                                                    <td>{{ $guia->fecha }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('sGuia.show', ['guia_id' => $guia->id]) }}"
                                                            class="btn btn-sm btn-primary" style="background:#2641f8">
                                                            Ver Guía
                                                        </a>
                                                    </td>
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
        </div>
    </div>
</div>

{{-- Modal de productos CORREGIDO --}}
<div id="productoModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <form id="producto-form" method="POST" action="{{ route('sGuias.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Gestión de Servicios</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <label for="cliente-select" class="mb-0 font-weight-bold">Cliente:</label>
                        <button type="button" id="add_cliente" class="btn btn-sm btn-primary">
                            <i class="fa fa-plus"></i> Cliente
                        </button>
                    </div>
                    <select id="cliente-select" name="cliente_id" class="form-control" required>
                        <option value="" disabled selected>Seleccionar cliente</option>
                        @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="productos-section">
                    <h5 class="mb-3">PRODUCTOS</h5>

                    {{-- CORREGIDO: Bootstrap 4 classes --}}
                    <div id="formulario-producto" class="row align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="producto-nombre" name="producto">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Serie</label>
                            <input type="text" class="form-control" id="producto-serie" name="serie">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Observación</label>
                            <textarea class="form-control producto-observacion-input" id="producto-observacion" name="observacion"></textarea>
                        </div>
                        <div class="col-md-1 text-right">
                            <button type="button" class="btn btn-success" id="btn-add-producto">+</button>
                        </div>
                    </div>

                    <!-- Contenedor para productos agregados -->
                    <div id="productos-agregados" class="mt-3"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

<script>
// Inicialización de DataTable
$(document).ready(function(){
    $('#clientesTabla').DataTable({
        pageLength: 25,
        responsive: true,
        dom: '<"html5buttons"B>lTfgitp',
        buttons: [{
            customize: function (win){
                $(win.document.body).addClass('white-bg');
                $(win.document.body).css('font-size', '10px');
                $(win.document.body).find('table')
                .addClass('compact')
                .css('font-size', 'inherit');
            }
        }]
    });

    $('#tab-1').addClass('active');
    $('.scroll_content').slimscroll({
        height: '450px'
    });
});

$('#productoModal').on('shown.bs.modal', function () {

    const select = $('#cliente-select');

    // Destruir instancia anterior
    if ($select.hasClass('select2-hidden-accessible')) {
        $select.select2('destroy');
    }

    select.select2({
        placeholder: "Seleccionar cliente",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#productoModal')
    });

});

$(document).ready(function() {
    let productoCount = 0;

    // Agregar nuevo producto
    $("#btn-add-producto").click(function() {
        const nombre = $("#producto-nombre").val().trim();
        const serie = $("#producto-serie").val().trim();
        const observacion = $("#producto-observacion").val().trim();

        // Validación
        if (!nombre || !serie) {
            swal("Error", "Por favor ingrese al menos nombre y serie del producto", "error");
            return;
        }

        const productoId = productoCount++;

        // CORREGIDO: Template con data attributes para identificar campos
        const productoHTML = `
            <div class="card shadow-sm mb-2 producto-agregado" id="producto-${productoId}">
                <div class="card-body d-flex justify-content-between align-items-start">
                    <div class="producto-info">
                        <p class="mb-1" data-field="producto"><strong>Nombre:</strong> ${nombre}</p>
                        <p class="mb-1" data-field="serie"><strong>Serie:</strong> ${serie}</p>
                        <p class="mb-0" data-field="observacion"><strong>Observación:</strong> ${observacion}</p>
                        <input type="hidden" name="sDetalleGuiaIngreso[${productoId}][producto]" value="${nombre}">
                        <input type="hidden" name="sDetalleGuiaIngreso[${productoId}][serie]" value="${serie}">
                        <input type="hidden" name="sDetalleGuiaIngreso[${productoId}][observacion]" value="${observacion}">
                    </div>
                    <button type="button" class="btn btn-danger btn-sm remove-btn" data-id="producto-${productoId}">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
        `;

        $("#productos-agregados").append(productoHTML);

        // Aplicar scroll si hay más de 3 productos
        if ($(".producto-agregado").length > 3) {
            $("#productos-agregados").addClass("productos-scroll");
        }

        // Limpiar formulario
        $("#producto-nombre, #producto-serie, #producto-observacion").val('');
        $("#producto-nombre").focus();
    });

    // Eliminar producto
    $(document).on('click', '.remove-btn', function() {
        const productoId = $(this).data('id');
        $(`#${productoId}`).remove();

        if ($(".producto-agregado").length <= 3) {
            $("#productos-agregados").removeClass("productos-scroll");
        }
    });

    // Validar formulario
    $("#producto-form").on('submit', function(e) {
        if ($(".producto-agregado").length === 0) {
            swal("Error", "Por favor agregue al menos un producto", "error");
            e.preventDefault();
            return false;
        }

        const cliente = $("#cliente-select").val();
        if (!cliente) {
            swal("Error", "Por favor seleccione un cliente", "error");
            e.preventDefault();
            return false;
        }

        return true;
    });
});

// CORREGIDO: Funcionalidad de edición inline completamente reescrita
$(document).on('click', '.producto-agregado p[data-field]', function() {
    const $this = $(this);
    const fieldType = $this.data('field');

    // Prevenir múltiples ediciones simultáneas
    if ($this.find('input, textarea').length > 0) {
        return;
    }

    // Extraer el valor actual
    const fullText = $this.text();
    const labelMatch = fullText.match(/^([^:]+:\s*)(.*)/);
    if (!labelMatch) return;

    const label = labelMatch[1];
    const currentValue = labelMatch[2];

    // Guardar contenido original
    $this.data('original-html', $this.html());

    // Crear elemento de edición
    let $input;
    if (fieldType === 'observacion') {
        $input = $('<textarea>')
            .addClass('form-control edit-inline')
            .val(currentValue)
            .css({
                'min-height': '60px',
                'width': '100%',
                'margin-top': '5px'
            });
    } else {
        $input = $('<input>')
            .attr('type', 'text')
            .addClass('form-control edit-inline')
            .val(currentValue)
            .css({
                'width': '100%',
                'margin-top': '5px'
            });
    }

    // Reemplazar contenido
    $this.html(`<strong>${label}</strong>`).append($input);
    $input.focus().select();

    // Manejar guardado
    function saveEdit() {
        const newValue = $input.val().trim();
        const $card = $this.closest('.producto-agregado');
        const productoId = $card.attr('id');

        // Actualizar vista
        $this.html(`<strong>${label}</strong>${newValue}`);

        // Actualizar input oculto
        $card.find(`input[name*="[${fieldType}]"]`).val(newValue);
    }

    // Manejar cancelación
    function cancelEdit() {
        $this.html($this.data('original-html'));
    }

    // Event listeners
    $input.on('blur', saveEdit);

    $input.on('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            saveEdit();
        } else if (e.key === 'Escape') {
            e.preventDefault();
            cancelEdit();
        }
    });
});

// CORREGIDO: Gestión de modales de cliente (solo si el modal existe)
$(document).ready(function() {
    $('#add_cliente').on('click', function(e) {
        e.preventDefault();

        // Verificar si el modal de cliente existe antes de intentar mostrarlo
        if ($('#modal_create_cliente').length > 0) {
            $('#productoModal').modal('hide');
            $('#modal_create_cliente').modal('show');

            // Listener para volver al modal de productos
            $('#modal_create_cliente').off('hidden.bs.modal.returnToProduct').on('hidden.bs.modal.returnToProduct', function() {
                $('#productoModal').modal('show');
            });
        } else {
            console.warn('Modal de crear cliente no encontrado');
            swal("Información", "La funcionalidad de agregar cliente no está disponible", "info");
        }
    });
});

// Limpiar modal al cerrarse
$('#productoModal').on('hidden.bs.modal', function () {
    // Limpiar formulario
    $('#producto-form')[0].reset();
    $('#productos-agregados').empty().removeClass('productos-scroll');

    // Destruir Select2
    if ($('#cliente-select').hasClass('select2-hidden-accessible')) {
        $('#cliente-select').select2('destroy');
    }
});
</script>

@include('transaccion.venta.clientes.modal_create')

@endsection
