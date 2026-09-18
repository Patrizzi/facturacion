@extends('layout')
@section('title', 'Servicio')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atras')
@section('atributo_actu', 'hidden')

@section('content')
<link rel="stylesheet" href="{{ asset('css/servicio-tecnico/cliente.css') }}">

<div class="wrapper wrapper-content animated fadeInRight">
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
                                                <th>Servicio Tec.</th>
                                                <th>Cliente</th>
                                                {{-- <th>Orden de servicio</th> --}}
                                                <th>Celular</th>
                                                <th>Fecha</th>
                                                <th>Acciones</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($servicioGuias as $guia)
                                                <tr class="gradeX">
                                                    <td>{{ $guia->nro_guia }}</td>
                                                    <td>{{ $guia->cliente->nombre }}</td>
                                                    {{-- <td>{{ $guia->orden_servicio ?? '-' }}</td> --}}
                                                    <td>{{ $guia->cliente->celular ?? '-' }}</td>
                                                    <td>{{ $guia->fecha }}</td>
                                                    <td class="d-flex justify-content-center text-center" style="gap: 5px;">
                                                        @if($guia->cotizado == 0)
                                                            {{-- ver servicio guia --}}
                                                            <form
                                                                id="form-show-guia-{{ $guia->id }}"
                                                                method="GET"
                                                                action="{{ route('sGuia.show', ['guia_id' => $guia->id]) }}"
                                                                style="display: none;"
                                                            >
                                                            </form>
                                                            <button
                                                                class="btn btn-primary"
                                                                onclick="verGuia({{ $guia->id }})"
                                                                type="button"
                                                                title="Ver"
                                                                data-toggle="tooltip"
                                                            >
                                                                <i class="fa fa-eye"></i>
                                                            </button>

                                                            {{-- cotizar servicio guia --}}
                                                            <form
                                                                method="GET"
                                                                id="form-cotizar-{{ $guia->id }}"
                                                                action="{{ route('cotizacionSGuia.create', $guia->id) }}">

                                                            </form>
                                                            <button
                                                                type="button"
                                                                class="btn btn-primary"
                                                                data-toggle="tooltip"
                                                                data-placement="bottom"
                                                                title="Cotizar"
                                                                onclick="cotizarGuia({{ $guia->id }})"
                                                            >
                                                                <i class="fa fa-file-text"></i>
                                                            </button>

                                                        @elseif($guia->cotizado == 1)
                                                            <form
                                                                id="form-show-guia-{{ $guia->id }}"
                                                                method="GET"
                                                                action="{{ route('sGuia.show', ['guia_id' => $guia->id]) }}"
                                                                style="display: none;"
                                                            >
                                                            </form>

                                                            <button
                                                                class="btn btn-primary"
                                                                onclick="verGuia({{ $guia->id }})"
                                                                type="button"
                                                                title="Ver"
                                                                data-toggle="tooltip"
                                                            >
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{-- falta cotizar servicio tecnico --}}
                                                        @if($guia->cotizado == 0)
                                                             {{-- <button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Falta Cotizar">
                                                               Cotizar
                                                            </button> --}}
                                                             <button type="button" class="btn btn-warning" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Falta Cotizar">
                                                                <i class="fa fa-clock-o"></i>
                                                            </button>

                                                        {{-- ya cotizado servicio tecnico --}}
                                                        @elseif($guia->cotizado == 1)
                                                            {{-- <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Cotizado">
                                                                Cotizado
                                                            </button> --}}
                                                            <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Cotizado">
                                                                <i class="fa fa-check-circle"></i>
                                                            </button>
                                                        @endif
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

{{-- modal productos --}}
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
                    <label class="form-label"><strong>Cliente:</strong></label>
                    <div class="input-group">
                        <select class="select2-clientes" name="cliente_id" id="cliente" required value="{{ old('nombre') }}">
                            <option value="" disabled selected>Seleccionar cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <a href="#" class="btn btn-secondary btn-rounded" id="add_cliente">
                                <i class="fa fa-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="productos-section">
                    <h5 class="mb-3">PRODUCTOS</h5>

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
    $(document).ready(function () {
            $('#clientesTabla').DataTable({
                dom: '<"top"lf>rt<"bottom"ip><"clear">',
                lengthMenu: [
                    [10, 25, 50, 100, -1],
                    [10, 25, 50, 100, "Todo"]
                ],
                pageLength: 10,
                order: [[0, 'desc']],
                language: {
                    lengthMenu: "",
                    search: "",
                    info: "",
                    infoFiltered: "(filtrado de _MAX_ registros totales)",
                    paginate: {
                        previous: "Anterior",
                        next: "Siguiente"
                    }
                }
            });
            $('.dataTables_filter input').css('display', 'none');
            $('#tab-1').addClass('active');
            $('.scroll_content').slimscroll({
                height: '450px'
            });
        });

    $('#productoModal').on('shown.bs.modal', function () {
        $('.select2-clientes').select2({
            dropdownParent: $('#productoModal'),
            width: '100%'
        });
    });

    $(document).ready(function() {
        let productoCount = 0;

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

            if ($(".producto-agregado").length > 3) {
                $("#productos-agregados").addClass("productos-scroll");
            }

            $("#producto-nombre, #producto-serie, #producto-observacion").val('');
            $("#producto-nombre").focus();
        });

        $(document).on('click', '.remove-btn', function() {
            const productoId = $(this).data('id');
            $(`#${productoId}`).remove();

            if ($(".producto-agregado").length <= 3) {
                $("#productos-agregados").removeClass("productos-scroll");
            }
        });

        $("#producto-form").on('submit', function(e) {
            if ($(".producto-agregado").length === 0) {
                swal("Error", "Por favor agregue al menos un producto", "error");
                e.preventDefault();
                return false;
            }

            return true;
        });
    });

    $(document).on('click', '.producto-agregado p[data-field]', function() {
        const $this = $(this);
        const fieldType = $this.data('field');

        if ($this.find('input, textarea').length > 0) {
            return;
        }

        const fullText = $this.text();
        const labelMatch = fullText.match(/^([^:]+:\s*)(.*)/);
        if (!labelMatch) return;

        const label = labelMatch[1];
        const currentValue = labelMatch[2];

        $this.data('original-html', $this.html());

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

        $this.html(`<strong>${label}</strong>`).append($input);
        $input.focus().select();

        function saveEdit() {
            const newValue = $input.val().trim();
            const $card = $this.closest('.producto-agregado');
            const productoId = $card.attr('id');

            $this.html(`<strong>${label}</strong>${newValue}`);

            $card.find(`input[name*="[${fieldType}]"]`).val(newValue);
        }

        function cancelEdit() {
            $this.html($this.data('original-html'));
        }

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

    $(document).ready(function() {
        $('#add_cliente').on('click', function(e) {
            e.preventDefault();

            if ($('#modal_create_cliente').length > 0) {
                $('#productoModal').modal('hide');
                $('#modal_create_cliente').modal('show');

                $('#modal_create_cliente').off('hidden.bs.modal.returnToProduct').on('hidden.bs.modal.returnToProduct', function() {
                    $('#productoModal').modal('show');
                });
            } else {
                console.warn('Modal de crear cliente no encontrado');
                swal("Información", "La funcionalidad de agregar cliente no está disponible", "info");
            }
        });
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

<script>
    function verGuia(guiaId) {
        const form = document.getElementById(`form-show-guia-${guiaId}`)
        if(form) {
            form.submit()
        }
    }

    function cotizarGuia(guiaId) {
        const form = document.getElementById(`form-cotizar-${guiaId}`)
        if(form) {
            form.submit()
        }
    }
</script>

@include('transaccion.venta.clientes.modal_create')

@endsection
