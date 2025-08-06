@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atras')
@section('atributo_actu', 'hidden')

    <!-- Estilos propios de la app -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Estilos de Servicio Técnico -->
    <link rel="stylesheet" href="{{ asset('css/servicio-tecnico/cliente.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-4-theme/1.5.2/select2-bootstrap.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('css/plugins/dataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plugins/dataTables/dataTables.bootstrap4.min.css') }}">
    <!-- Pace (barra de carga) -->
    <link rel="stylesheet" href="{{ asset('css/plugins/pace/pace-theme-minimal.css') }}">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@extends('layout_agregado_rapido')
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@section('content')
<div class="px-4 py-4 d-flex justify-content-between align-items-center bg-white">
    <h2 class="fw-semibold m-0">GUÍA DE SERVICIO</h2>
    <button class="btn btn-primary" id="btn-agregar-guia" style="background: #2641f8" data-toggle="modal" data-target="#productoModal">
        <i class="fa fa-plus"></i>
    </button>
</div>
<div id="productoModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" style="overflow: visible;">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="overflow: visible;">
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
                        <button type="button" id="add_cliente" class="btn btn-primary">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <select id="cliente-select" name="cliente_id" class="custom-select" required>
                        <option value="" disabled selected>Seleccionar cliente</option>
                        @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="productos-section">
                    <h5 class="mb-3">PRODUCTOS</h5>

                    <div id="formulario-producto" class="row g-3 align-items-end">
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
                            <textarea class="form-control" id="producto-observacion" name="observacion" style="resize: vertical; height: 40px; overflow-y: hidden;"></textarea>
                        </div>
                        <div class="col-md-1 text-end">
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

<div class="table-responsive bg-white p-3">
    <table id="clientesTabla" class="table table-borderless table-hover text-center bg-white">
        <thead class="bg-white">
            <tr>
                <th scope="col">Código</th>
                <th scope="col">Nombre</th>
                <th scope="col">Orden de servicio</th>
                <th scope="col">Celular</th>
                <th scope="col">Fecha</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($servicioGuias as $guia)
                <tr class="border-bottom">
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

<!-- Steps -->
    <script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>

    <script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js')}}"></script>

    <script>
    $(document).ready(function () {
        var table = $('#clientesTabla').DataTable({
            dom: '<"d-flex justify-content-between align-items-center mb-3"f>rt<"d-flex justify-content-between align-items-center mt-3"lip>',
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "Todo"]
            ],
            pageLength: 10,
            order: [[0, 'desc']],
            pagingType: "simple",
            language: {
                lengthMenu: "Mostrar _MENU_ servicios",
                search: "",
                searchPlaceholder: "Buscar",
                info: "Mostrando _START_ a _END_ de _TOTAL_ servicios",
                infoFiltered: "(filtrado de _MAX_ servicios totales)",
                paginate: {
                    previous: '<button class="btn btn-sm font-weight-bold" style="background:#2641f8;color:white;border-radius:8px;">Atrás</button>',
                    next: '<button class="btn btn-sm font-weight-bold" style="background:#2641f8;color:white;border-radius:8px;">Siguiente</button>'
                }
            }
        });

        // Quitar estilos inline de los botones de paginación (DataTables los agrega por defecto)
        $('#clientesTabla').on('draw.dt', function () {
            $('.dataTables_paginate .paginate_button').removeAttr('style');
        });

        // Ícono de lupa en el buscador y alineación a la derecha
        $('.dataTables_filter input').addClass('form-control ml-2').css('width', '300px');
        $('.dataTables_filter').prepend('<i class="fa fa-search mr-2"></i>');
        $('.dataTables_filter').addClass('ml-auto d-flex justify-content-end align-items-center');
    });
    </script>

    <script>

    // Cada vez que se abra el modal, (re)inicializamos el select2
    $('#productoModal').on('shown.bs.modal', function () {
        const $select = $('#cliente-select');

        // Volvemos a marcar las opciones que hay que ocultar
        const allOptions = $select.find('option').not(':first');
        const lastFive   = allOptions.slice(-5);
        allOptions.each(function () {
        $(this).attr('data-hide-initial',
            lastFive.is(this) ? null : 'true'
        );
        });

        // Si ya tenía Select2, destrúyelo para reiniciar
        if ($select.hasClass('select2-hidden-accessible')) {
        $select.select2('destroy');
        }

        // Inicializamos Select2 **dentro** del modal, con dropdownParent
        $select.select2({
        placeholder: "Buscar cliente…",
        allowClear: true,
        width: '100%',
        dropdownParent: $('#productoModal'),
        minimumResultsForSearch: 0
        });

        // Cuando se abre el Select2, aplicamos tu filtro de "solo los 5 últimos"
        $select.off('select2:open').on('select2:open', function () {
        const $results   = $('.select2-results__option');
        const searchBox  = document.querySelector('.select2-search__field');

        function filtrar() {
            if (!searchBox.value.trim()) {
            $results.each(function () {
                const txt   = $(this).text().trim();
                const hide  = $select.find(`option`).filter(function(){
                                return $(this).text().trim() === txt;
                            }).attr('data-hide-initial') === 'true';
                $(this).toggle(!hide);
            });
            } else {
            $results.show();
            }
        }

        // Filtra nada más abrir
        setTimeout(filtrar, 0);

        // Añade listener una sola vez
        if (!searchBox.dataset._listener) {
            searchBox.dataset._listener = '1';
            searchBox.addEventListener('input', filtrar);
        }
        });
    });
    </script>

    <script>
    $(document).ready(function() {
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

            // Plantilla con diseño Bootstrap
            const productoHTML = `
                <div class="card shadow-sm mb-2 producto-agregado" id="producto-${productoId}">
                    <div class="card-body d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1"><strong>Nombre:</strong> ${nombre}</p>
                            <p class="mb-1"><strong>Serie:</strong> ${serie}</p>
                            <p class="mb-0"><strong>Observación:</strong> ${observacion}</p>
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

            // Scroll si hay más de 3 productos
            if ($(".producto-agregado").length > 3) {
                $("#productos-agregados").css({"max-height": "300px", "overflow-y": "auto"});
            }

            // Limpiar el formulario para el siguiente producto
            $("#producto-nombre").val('');
            $("#producto-serie").val('');
            $("#producto-observacion").val('');
            $("#producto-nombre").focus();
        });

        // Eliminar producto
        $(document).on('click', '.remove-btn', function() {
            const productoId = $(this).data('id');
            $(`#${productoId}`).remove();

            if ($(".producto-agregado").length <= 3) {
                $("#productos-agregados").css({"max-height": "", "overflow-y": ""});
            }
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

    $(document).on('click', '.producto-agregado p', function() {
        const $this = $(this);
        const currentText = $this.text();
        const fieldName = $this.attr('class').split(' ')[0];

        const labelElement = $this.find('.producto-label');
        const label = labelElement.text();
        const value = currentText.replace(label, '').trim();

        if ($this.find('input, textarea').length > 0) {
            return;
        }

        let $input;
        const labelWidth = labelElement.outerWidth() + 10;

        if (fieldName === 'producto-observacion') {
            $this.data('original-content', $this.html());

            $this.html(labelElement.clone());

            $input = $('<textarea>')
                .val(value)
                .addClass('edit-inline')
                .css({
                    'display': 'inline-block',
                    'vertical-align': 'middle',
                    'width': 'calc(100% - ' + labelWidth + 'px)',
                    'padding': '3px',
                    'border': '1px solid #007bff',
                    'border-radius': '3px',
                    'margin-left': '5px',
                    'resize': 'vertical',
                    'height': '38px',
                    'overflow-y': 'hidden'
                });
        } else {
            $this.data('original-content', $this.html());

            $this.html(labelElement.clone());

            $input = $('<input>')
                .attr('type', 'text')
                .val(value)
                .addClass('edit-inline')
                .css({
                    'display': 'inline-block',
                    'vertical-align': 'middle',
                    'width': 'calc(100% - ' + labelWidth + 'px)',
                    'padding': '3px',
                    'border': '1px solid #007bff',
                    'border-radius': '3px',
                    'margin-left': '5px'
                });
        }

        $this.append($input);
        $input.focus();

        const productoId = $this.closest('.producto-agregado').attr('id');
        const inputName = fieldName.replace('producto-', '');

        if (fieldName === 'producto-observacion') {
            $input.on('input', function() {
                this.style.height = '38px';
                this.style.height = (this.scrollHeight) + 'px';
            });
            $input.trigger('input');
        }

        $input.on('blur keypress', function(e) {
            if (e.type === 'blur' || (e.type === 'keypress' && e.which === 13 && !$input.is('textarea'))) {
                const newValue = $(this).val();

                $this.html(`<span class="producto-label">${label}</span> ${newValue}`);

                $(`#${productoId} input[name$="[${inputName}]"]`).val(newValue);

                if (e.type === 'keypress') {
                    e.preventDefault();
                }
            } else if (e.type === 'keypress' && e.which === 13 && e.ctrlKey && $input.is('textarea')) {
                const newValue = $(this).val();
                $this.html(`<span class="producto-label">${label}</span> ${newValue}`);
                $(`#${productoId} input[name$="[${inputName}]"]`).val(newValue);
                e.preventDefault();
            }
        });
    });

    $("<style>")
        .prop("type", "text/css")
        .html(`
        .producto-agregado p {
            cursor: pointer;
            padding: 3px;
            }
            .producto-agregado p:hover {
                background-color: #f0f0f0;
                border-radius: 3px;
                }
                `)
                .appendTo("head");
    </script>
    <script>
        // Cuando pulsan “+ Cliente”
        $('#add_cliente').on('click', function(e) {
            e.preventDefault();
            // Oculta el modal de productos usando Bootstrap
            $('#productoModal').modal('hide');
            // Muestra el modal de creación de cliente
            $('#modal_create_cliente').modal('show');
        });

        // Al cerrar el modal de cliente, vuelve a mostrar el de productos
        $('#modal_create_cliente').on('hidden.bs.modal', function() {
            $('#productoModal').modal('show');
        });
    </script>

    @include('transaccion.venta.clientes.modal_create')

@endsection

