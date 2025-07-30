@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atras')
@section('atributo_actu', 'hidden')
@section('styles')
    <!-- Bootstrap 5 -->
    <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr"
    crossorigin="anonymous"
    />

    <!-- Estilos propios de la app (si no los carga ya tu layout) -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Estilos específicos de Servicio -->
    <link rel="stylesheet" href="{{ asset('css/servicio-tecnico/cliente.css') }}">

    <!-- Select2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"rel="stylesheet"/>

    <!-- SweetAlert -->
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet"/>

    <!-- DataTables -->
    <link href="{{ asset('css/plugins/dataTables/datatables.min.css') }}"rel="stylesheet"/>
    <link href="{{ asset('css/plugins/dataTables/dataTables.bootstrap5.min.css') }}" rel="stylesheet"/>

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
        data-bs-toggle="modal" 
        data-bs-target="#productoModal"
        >
        <i class="fa fa-plus"></i>
    </button>
</div>
<div id="productoModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <form id="producto-form" method="POST" action="{{ route('sGuias.store') }}" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Gestión de Servicios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                {{-- <span class="custom-close">&times;</span> --}}
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Cliente:</label>
                    <select id="cliente-select" name="cliente_id" class="form-select" required>
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
                <button type="button" class="btn btn-secondary" id="btn-cerrar">Cerrar</button>
                <button type="submit" class="btn btn-primary" id="btn-guardar">Guardar Cambios</button>
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
    <!-- jQuery (v3.6+) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Bootstrap 5 Bundle (Popper incluido) -->
    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q"
        crossorigin="anonymous"
    ></script>

    <!-- MetisMenu -->
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- Pace (barra de progreso) -->
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- Validación de formularios -->
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>

    <!-- Wizard / Steps -->
    <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>

    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <!-- DataTables -->
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap5.min.js') }}"></script>

    <!-- SweetAlert -->
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>

    <!-- Inspinia (scripts de la plantilla) -->
    <script src="{{ asset('js/inspinia.js') }}"></script>

    <script>
        $(function(){
        $('#cliente-select').select2({
            placeholder: 'Buscar cliente…',
            allowClear: true,
            dropdownParent: $('#productoModal')   // importantísimo
        });
        });
    </script>

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
    $(document).ready(function () {
        const $select = $('#cliente-select');

        const allOptions = $select.find('option').not(':first');
        const lastFive = allOptions.slice(-5);

        allOptions.each(function () {
            const $opt = $(this);
            if (!lastFive.is(this)) {
                $opt.attr('data-hide-initial', 'true');
            }
        });

        $select.select2({
            placeholder: "Buscar cliente...",
            allowClear: true,
        });

        $select.on('select2:open', function () {
            setTimeout(function () {
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

                const searchBox = document.querySelector('.select2-search__field');
                if (searchBox) {
                    searchBox.addEventListener('input', function () {
                        if (this.value.trim() === '') {
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
                        }
                    });
                }
            }, 0);
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
    $(document).ready(function() {
        $('#cliente-select').select2({
            placeholder: "Buscar cliente...",
            allowClear: true,
            width: '100%'
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

