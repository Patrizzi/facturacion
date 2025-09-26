@extends('layout')
@section('title', 'Servicio Técnico')
@section('href_accion', route('servicio.index'))
@section('value_accion', 'Atras')
@section('atributo_actu', 'hidden')

@section("content")
<link rel="stylesheet" href="{{ asset('css/servicio-tecnico/servicios/servicio_guia/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/plugins/toastr/toastr.min.css') }}">
<!-- Ladda style -->
<link href="{{ asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                            @include('servicio_tecnico.servicios.servicio-guia._shared.tabs')

                            @if($servicioGuia->estado == 0 || $servicioGuia->estado == 1)
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    <button
                                        type="button"
                                        id="btn-agregar-equipo"
                                        class="btn btn-primary"
                                        data-placement="bottom"
                                        data-toggle="modal"
                                        data-target="#add-equipo"
                                    >
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </ul>

                            {{-- si el servicioGuia tiene todo reparado(4) o esta entregado(5), crear informe tecnico --}}
                            @elseif($servicioGuia->estado == 4 || $servicioGuia->estado == 5)
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    <form action="{{ route('servicio-guias.store-it') }}" method="POST" id="form-crear-it-{{ $servicioGuia->id }}">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" name="servicio_g_id" value="{{ $servicioGuia->id }}">
                                    </form>
                                    <button
                                        type="button"
                                        id="btn-informe-{{ $servicioGuia->id }}"
                                        class="btn btn-success ladda-button"
                                        data-placement="bottom"
                                        data-toggle="tooltip"
                                        title="Crear Informe Técnico"
                                        onclick="storeInformeTecnico({{ $servicioGuia->id }})"
                                    >
                                        <i class="fa fa-archive"></i>
                                    </button>
                                </ul>
                            @endif
                        </ul>

                        {{-- inicio modal agregar equipos --}}
                        <div class="modal fade" id="add-equipo" tabindex="-1" aria-labelledby="add-equipoLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <form action="{{ route('servicio-guias.agregarEquipos') }}" method="POST" id="form-agregar-equipos">
                                        @csrf
                                        @method('POST')

                                        <input type="hidden" name="servicio_guia_id" value="{{ $servicioGuia->id }}">

                                        <div class="modal-header">
                                            <h5 class="modal-title" id="add-equipoLabel">Agregar Equipos</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <table cellspacing="0" class="table tables">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10px">
                                                            <button
                                                                type="button"
                                                                class="btn btn-sm btn-info"
                                                                id="agregar-equipo"
                                                            >
                                                                <i class="fa fa-plus-square"></i>
                                                            </button>
                                                        </th>
                                                        <th style="width: 80%">Equipos</th>
                                                        <th style="width:20%">Nro. Serie</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tabla-equipos">
                                                    <tr>
                                                        <td>
                                                            <button
                                                                type="button"
                                                                class='btn btn-sm btn-danger borrar-equipo'
                                                            >
                                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                                            </button>
                                                        </td>
                                                        <td class="td_selected">
                                                            <input
                                                                type="text"
                                                                placeholder="Nombre Equipo"
                                                                class="form-control"
                                                                name="nombre_equipo[]">
                                                            <textarea
                                                                name='observacion[]'
                                                                placeholder="Observación"
                                                                class="form-control"
                                                                autocomplete="off"
                                                                style="margin-top: 5px;"></textarea>
                                                        </td>
                                                        <td>
                                                            <input
                                                                style="width: 520px"
                                                                type='text'
                                                                name='nro_serie[]'
                                                                class="form-control"
                                                                placeholder="Número Serie"
                                                            />
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" id="btn-guardar-modal" class="btn btn-primary ladda-button">Guardar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- fin modal agregar equipos --}}

                        <div class="tab-content">
                            {{-- servicio ingresos --}}
                            <div class="tab-pane fade show active" id="tab-ingresos" role="tabpanel">
                                @include('servicio_tecnico.servicios.servicio-guia.servicio_ingreso')
                            </div>

                            {{-- servicio egresos --}}
                            <div class="tab-pane fade" id="tab-egresos" role="tabpanel">
                                @include('servicio_tecnico.servicios.servicio-guia.servicio_egreso')
                            </div>

                            {{-- informe tecnico --}}
                            <div class="tab-pane fade" id="tab-informe" role="tabpanel">
                                @include('servicio_tecnico.servicios.servicio-guia.servicio_informe_tecnico')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- scripts --}}
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
<script src="{{ asset('js/toastr-config.js') }}"></script>
<!-- Ladda -->
<script src="{{ asset('js/plugins/ladda/spin.min.js') }}"></script>
<script src="{{ asset('js/plugins/ladda/ladda.min.js') }}"></script>
<script src="{{ asset('js/plugins/ladda/ladda.jquery.min.js') }}"></script>

<script>
    $(document).ready(function () {
        // Crear instancias de Ladda para cada botón individualmente
        var laddaButtons = {};
        $('.ladda-button').each(function() {
            var buttonId = this.id || 'btn-' + Math.random().toString(36).substr(2, 9);
            if (!this.id) this.id = buttonId;
            laddaButtons[buttonId] = Ladda.create(this);
        });

        const dataTableConfig = {
            dom: '<"top"lf>rt<"bottom"ip><"clear">',
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "Todo"]
            ],
            pageLength: 10,
            order: [],
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
        };

        $('#servicio-guias-ingresos').DataTable(dataTableConfig);
        $('#servicio-guias-egresos').DataTable(dataTableConfig);
        $('#servicio-informes').DataTable(dataTableConfig);

        $('.dataTables_filter input').css('display', 'none');

        $('.scroll_content').slimscroll({
            height: '450px'
        });

        // tooltip btn-agregar-equipo para evitar conflictos con el modal
        $('#btn-agregar-equipo').tooltip({
            placement: 'bottom',
            title: 'Agregar equipo',
            trigger: 'manual'
        });
        $('#btn-agregar-equipo').on('mouseenter', function() {
            $(this).tooltip('show');
        });
        $('#btn-agregar-equipo').on('mouseleave click', function() {
            $(this).tooltip('hide');
        });

        // inicializa el tooltip a todos los registros que son unicos para diagnosticar
        $('[id^="btn-diagnosticar-equipo-"]').tooltip({
            placement: 'bottom',
            title: 'Diagnosticar',
            trigger: 'manual'
        });
        $('[id^="btn-diagnosticar-equipo-"]').on('mouseenter', function() {
            $(this).tooltip('show');
        });
        $('[id^="btn-diagnosticar-equipo-"]').on('mouseleave click', function() {
            $(this).tooltip('hide');
        });

        $('#servicio-tabs a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

        // inicializa el tooltip a todos los registros que son unicos para reparar
        $('[id^="btn-reparar-equipo-"]').tooltip({
            placement: 'bottom',
            title: 'Reparar',
            trigger: 'manual'
        });
        $('[id^="btn-reparar-equipo-"]').on('mouseenter', function() {
            $(this).tooltip('show');
        });
        $('[id^="btn-reparar-equipo-"]').on('mouseleave click', function() {
            $(this).tooltip('hide');
        });

        $('#servicio-tabs a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });

        // permanecer en el mismo tab al recargar la pag.
        var activeTab = localStorage.getItem('activeTab');
        if (activeTab) {
            $('.nav-tabs .nav-link').removeClass('active');
            $('.tab-content .tab-pane').removeClass('show active');

            $(activeTab + '-link').addClass('active');
            $(activeTab).addClass('show active');
        }
        $('a[data-toggle="tab"]').on('click', function() {
            var tabId = $(this).attr('href');
            localStorage.setItem('activeTab', tabId);
        });

        $('[data-toggle="tooltip"]').tooltip();

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            $.fn.dataTable.tables({ visible: true, api: true }).columns.adjust();
            $($(this).attr('href')).find('[data-toggle="tooltip"]').tooltip();
        });

        // Variable para controlar envío del modal
        var procesandoModal = false;

        // Manejar envío del formulario del modal
        $('#form-agregar-equipos').on('submit', function(e) {
            e.preventDefault();

            if (procesandoModal) {
                return;
            }

            var submitButton = $('#btn-guardar-modal');
            var laddaModal = Ladda.create(submitButton[0]);

            // Validar que hay al menos un equipo
            var nombresEquipos = $(this).find('input[name="nombre_equipo[]"]');
            var hayEquipoValido = false;

            nombresEquipos.each(function() {
                if ($(this).val().trim() !== '') {
                    hayEquipoValido = true;
                    return false;
                }
            });

            if (!hayEquipoValido) {
                toastr.error('Por favor ingresa al menos un equipo', '', {
                    timeOut: 3000
                });
                return;
            }

            procesandoModal = true;
            laddaModal.start();

            // Enviar formulario
            setTimeout(() => {
                this.submit();
            }, 500);
        });
    });
</script>

<script>
    document.getElementById('agregar-equipo').addEventListener('click', function() {
        var tr = document.createElement('tr');

        var tdBoton = document.createElement('td');
        var btnEliminar = document.createElement('button');
        btnEliminar.type = 'button';
        btnEliminar.className = 'btn btn-sm btn-danger borrar-equipo';
        btnEliminar.innerHTML = '<i class="fa fa-trash" aria-hidden="true"></i>';
        tdBoton.appendChild(btnEliminar);

        var tdEquipos = document.createElement('td');
        tdEquipos.className = 'td_selected';

        var inputNombre = document.createElement('input');
        inputNombre.type = 'text';
        inputNombre.placeholder = 'Nombre Equipo';
        inputNombre.className = 'form-control';
        inputNombre.name = 'nombre_equipo[]';

        var textareaObs = document.createElement('textarea');
        textareaObs.name = 'observacion[]';
        textareaObs.placeholder = 'Observación';
        textareaObs.className = 'form-control';
        textareaObs.autocomplete = 'off';
        textareaObs.style.marginTop = '5px';

        tdEquipos.appendChild(inputNombre);
        tdEquipos.appendChild(textareaObs);

        var tdSerie = document.createElement('td');
        var inputSerie = document.createElement('input');
        inputSerie.type = 'text';
        inputSerie.name = 'nro_serie[]';
        inputSerie.placeholder = 'Número Serie';
        inputSerie.className = 'form-control';
        inputSerie.style.width = '520px';
        tdSerie.appendChild(inputSerie);

        tr.appendChild(tdBoton);
        tr.appendChild(tdEquipos);
        tr.appendChild(tdSerie);

        document.querySelector('#tabla-equipos').appendChild(tr);

        btnEliminar.onclick = function() {
            this.closest('tr').remove();
        }
    });

    function eliminarFila() {
        var btnDelete = document.querySelectorAll('.borrar-equipo');
        btnDelete.forEach(function(btn) {
            btn.onclick = function() {
                this.closest('tr').remove();
            }
        });
    }

    eliminarFila();
</script>

<script>
    $(document).ready(function () {
        @if(session('success'))
            toastr.success("{{ session('success') }}", '', {
                timeOut: 3000
            });
        @endif

        @if(session('error'))
            toastr.error("{{ session('error') }}", '', {
                timeOut: 3000
            });
        @endif

        @if(session('warning'))
            toastr.warning("{{ session('warning') }}", '', {
                timeOut: 3000
            });
        @endif

        @if(session('info'))
            toastr.info("{{ session('info') }}", '', {
                timeOut: 3000
            });
        @endif
    });
</script>

<script>
    // Variable para controlar creación de informe técnico
    var procesandoInforme = false;

    function storeInformeTecnico(servicioGuiaId) {
        if (procesandoInforme) {
            return;
        }

        procesandoInforme = true;

        // Buscar el botón que activó la función
        var button = document.getElementById(`btn-informe-${servicioGuiaId}`);
        var laddaInforme = Ladda.create(button);
        laddaInforme.start();

        const form = document.getElementById(`form-crear-it-${servicioGuiaId}`);
        if (form) {
            setTimeout(() => {
                form.submit();
            }, 500);
        } else {
            procesandoInforme = false;
            laddaInforme.stop();
            toastr.error('Error: Formulario no encontrado', '', {
                timeOut: 3000
            });
        }
    }
</script>
@endsection
