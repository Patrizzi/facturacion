@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atras')
@section('atributo_actu', 'hidden')
@section('styles')
    <!-- Bootstrap 4 -->
    <link
        rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNVnAC+6mMLFF+E7xQE4x1pDm1z0iQp2BUMF0hCJn6mQAu9Oi9gM"
        crossorigin="anonymous"
    />

    <!-- Estilos propios de la app (si no los carga ya tu layout) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Estilos específicos de Servicio -->
    <link rel="stylesheet" href="{{ asset('css/servicio-tecnico/cliente.css') }}">

    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet"/>

    <!-- SweetAlert -->
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet"/>

    <!-- DataTables -->
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}"rel="stylesheet"/>
    <link href="{{ asset('css/plugins/dataTables/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>

    <!-- Pace (barra de carga) -->
    <link href="{{ asset('css/plugins/pace/pace-theme-minimal.css') }}" rel="stylesheet"/>

    <!-- jQuery Steps (si lo usas) -->
    <link href="{{ asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet"/>

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"rel="stylesheet"/>
@endsection
{{-- @extends('layout_agregado_rapido') --}}
@section('content')

{{-- <div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o" aria-hidden="true"></i>cliente </a>
</div> --}}

<div class="px-4 py-4 d-flex justify-content-between align-items-center bg-white">
    <h2 class="fs-4 fw-semibold m-0">GUÍA DE SERVICIO</h2>
    <button
    class="btn btn-primary"
    id="btn-agregar-guia"
    data-toggle="modal"
    data-target="#productoModal"
    >
        <i class="fa fa-plus"></i>
    </button>
</div>
<div id="productoModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <form id="producto-form" method="POST" action="{{ route('sGuias.store') }}" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Gestión de Servicios</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{-- <span class="custom-close">&times;</span> --}}
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Cliente:</label>
                        <select id="cliente-select" name="cliente_id" class="form-control" required>
                            <option value="">Seleccionar cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="productos-section">
                        <h5 class="mb-3">PRODUCTOS</h5>

                        <div id="formulario-producto" class="row g-3 align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="producto-nombre" name="producto">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Serie</label>
                                <input type="text" class="form-control" id="producto-serie" name="serie">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Observación</label>
                                <textarea class="form-control" id="producto-observacion" name="observacion" style="resize: vertical; height: 40px; overflow-y: hidden;"></textarea>
                            </div>
                            <div class="col-12 text-end">
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
                    <a href="{{ route('sGuia.show', ['guia_id' => $guia->id]) }}">
                        <button class="btn-ver-guia">Ver Guía</button>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
@section('scripts')
    <!-- 1. jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- 2. Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <!-- 3. Bootstrap 4 JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- MetisMenu -->
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <!-- Slimscroll -->
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- Pace (barra de progreso) -->
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- Validación de formularios -->
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>

    <!-- Wizard / Steps -->
    <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>

    <!-- Select2 -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
        integrity="sha384-8+4LEdUNc8O/o4iJ0C1t+6iBSxxs4HAfFZ8Qn3tvM0kD8TQd7G9ycXA1vaYnS0EU"
        crossorigin="anonymous"
    ></script>

    <!-- DataTables -->
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- SweetAlert -->
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Inspinia (scripts de la plantilla) -->
    <script src="{{ asset('js/inspinia.js') }}"></script>

    <script>
        $(document).ready(function () {
        $('.dataTables-example').DataTable({
            dom: '<"top"lf>rt<"bottom"ip><"clear">',
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "Todo"]
            ],
            pageLength: 10,
            order: [[0, 'desc']],
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
        $('.dataTables_filter input').css('width', '330px');

    });
    </script>

    <script>
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

    $(document).ready(function () {
        const $select = $('#cliente-select');

        // Guardar las primeras 4 opciones
        const allOptions = $select.find('option').not(':first');
        const firstFour = allOptions.slice(0, 4);

        allOptions.each(function () {
            const $opt = $(this);
            if (!firstFour.is(this)) {
                $opt.attr('data-hide-initial', 'true');
            }
        });

        $select.select2({
            placeholder: "Buscar cliente...",
            allowClear: true,
            dropdownParent: $('#productoModal'),
            width: '100%'
        });

        $select.on('select2:open', function () {
            const searchBox = document.querySelector('.select2-search__field');

            function filtrarResultados() {
                if (searchBox.value.trim() === '') {
                    // Solo mostrar las primeras 4
                    $('.select2-results__option').each(function () {
                        const $result = $(this);
                        const text = $result.text().trim();

                        const match = $select.find('option').filter(function () {
                            return $(this).text().trim() === text;
                        });

                        if (match.attr('data-hide-initial') === 'true') {
                            $result.hide();
                        } else {
                            $result.show();
                        }
                    });
                } else {
                    // Mostrar todos al escribir
                    $('.select2-results__option').show();
                }
            }

            // Ejecutar el filtrado al inicio
            setTimeout(filtrarResultados, 0);

            // Evitar registrar múltiples veces
            if (!searchBox.dataset.listener) {
                searchBox.addEventListener('input', filtrarResultados);
                searchBox.dataset.listener = true;
            }
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

            // Aplicar scroll y agrandar el espacio si hay más de 3 productos
            if ($(".producto-agregado").length > 3) {
                $("#productos-agregados").css({"max-height": "300px", "overflow-y": "auto"});
            }

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

            // Quitar scroll si quedan 3 o menos productos
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

@endsection

