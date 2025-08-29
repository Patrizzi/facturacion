@extends('layout')

@section('title', 'Comprobantes | Guia de Remision Manual')

@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h4>Resumen de {{ Str::ucfirst(Carbon\Carbon::now()->translatedFormat('F Y')) }}</h4>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            @include('transaccion\comprobantes\_shared\statistics')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                                @include('transaccion\comprobantes\_shared\tabs')
                                {{-- Almacen --}}
                                <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                    {{-- ALMACEN --}}
                                    <a class="btn btn-success" href="{{ route('guia_remision_manual.create') }}"><i
                                            class="fa fa-plus"></i></a>
                                    <button type="button" id="btn-imprimir-seleccion-grm" class="btn btn-success" title="Imprimir">
                                        <i class="fa fa-print"></i>
                                    </button>
                                    <button type="button" id="btn-exportar-grm" class="btn btn-success" title="Exportar a Excel">
                                        <i class="fa fa-upload"></i>
                                    </button>
                                </ul>

                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-5" class="tab-pane active show">
                                    <br> {{-- FILTRADO DE DATOS --}}
                                    <div class="search-responsive">
                                        <div class="row">
                                            <div class="col-lg-4 col-md-6 col-sm-12">
                                                <div class="input-group">
                                                    <input class="form-control" type="text" name="daterange"
                                                        id="data_range_filter"
                                                        value="{{ date('01/m/Y') }} - {{ date('t/m/Y') }}"
                                                        readonly="readonly" />
                                                    <span class="input-group-append">
                                                        <button type="button" class="btn btn-secondary" id="revert_select">
                                                            <i class="fa fa-history"></i>
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
                                            {{-- <div class="col-lg-3 col-md-6 col-sm-12">
                                                <select class="form-control" name="" id="select_tipo_coti">
                                                    <option value="" selected>Todos los comprobantes</option>
                                                    <option value="factura">Factura</option>
                                                    <option value="factura_manual">factura Manual</option>
                                                    <option value="boleta">Boleta</option>
                                                    <option value="boleta_manual">Boleta Manual</option>
                                                </select>
                                            </div> --}}
                                            <div class="col-lg-3 col-md-6 col-sm-12">
                                                <input type="search" class="form-control" placeholder="Buscar:"
                                                    id="search_all_column">
                                            </div>

                                            <div class="col-lg-2 col-md-6 col-sm-12">
                                                <button type="button" class="btn btn-block btn-primary"
                                                    id="filter_buttons">Buscar</button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>{{--  Tabla de Cotizacion Manual   --}}
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered dataTables-example-guia-remision">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <input type="checkbox" class="i-checks" name="input[]">
                                                    </th>
                                                    <th>ID</th>
                                                    <th>Código</th>
                                                    <th>RUC</th>
                                                    <th>Cliente</th>
                                                    <th>Fecha Emisión</th>
                                                    <th>Fecha de Entrega</th>
                                                    <th>Ver</th>
                                                    <th style="width: 0.5vmax !important">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>

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
@include('transaccion\comprobantes\_shared\js_shared')
<script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // "ACTIVA EL TAB DE GUIA DE REMISION MANUAL"
        $('#tab-8-tab').addClass('active');
    });

    // {{-- SCRIPTS PARA DATATABLE --}}
    var coti_table = $('.dataTables-example-guia-remision').DataTable({
        "serverSide": true,
        "ajax": {
            url: "{{ route('comprobantes.guiaRemisionM_registers') }}",
            method: "get",
            data: function(d) {
                d.daterange = $('#data_range_filter').val();
                d.tipo_comprobante = $('#select_tipo_coti').val();
                d.value = $('#search_all_column').val();
            }
        },
        "columnDefs": [{
                'width': '1vmax',
                'targets': [0],
                'orderable': false,
                render: function (data, type, full, meta) {
                    return '<input type="checkbox" name="select_row" value="'+ full[0] +'" class="i-checks-boleta">';
                }
            },
            {
                'width': '0.5vmax',
                'targets': [3]
            },
            {
                'width': '0.5vmax',
                'targets': [7],
                'orderable': false,
                'render': function(data, type, full, meta) {
                    var url = '{{ route('guia_remision_manual.show', ':id') }}';
                    url = url.replace(':id', full[0]);
                    return `<a href="${url}">
                                <button type="button" class="btn btn-primary">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </a> `;
                }
            },
            {
                'targets': [8], // Configuración para otra columna (como la de acciones)
                'orderable': false,
                'render': function(data, type, full, meta) {
                    const estados = {
                        0: {
                            texto: "Sin Enviar",
                            clase: "btn-warning",
                            icono: "fa fa-clock-o"
                        },
                        1: {
                            texto: "Enviado",
                            clase: "btn-info",
                            icono: "fa fa-check-circle"
                        },
                        2: {
                            texto: "Anulado",
                            clase: "btn-danger",
                            icono: "fa fa-check-circle"
                        }
                    };

                    let end = "";
                    const estadoSunat = parseInt(full[8]);
                    const e0 = estados[estadoSunat];
                    end += `<button class="btn ${e0.clase} btn-circle btn-ls" title=" ${e0.texto}">
                                <i class="${e0.icono}"></i>
                            </button> `;
                    return end;
                }
            }
        ],
        drawCallback: function() {
            $('[data-toggle="tooltip"]').tooltip();
            $('.i-checks-boleta').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        }
    });
    
    $('input[name="daterange"]').daterangepicker({
        "locale": {
            "separator": " | ",
            "applyLabel": "Guardar",
            "cancelLabel": "Cancelar",
            "fromLabel": "Desde",
            "toLabel": "Hasta",
            "customRangeLabel": "Custom",
            "daysOfWeek": [
                "Do",
                "Lu",
                "Ma",
                "Mi",
                "Ju",
                "Vi",
                "Sa"
            ],
            "monthNames": [
                "Enero",
                "Febrero",
                "Marzo",
                "Abril",
                "Mayo",
                "Junio",
                "Julio",
                "Agosto",
                "Septiembre",
                "Octubre",
                "Noviembre",
                "Diciembre"
            ],
            "firstDay": 1
        }
    });
    
    $(`#filter_buttons`).on('click', function() {
        coti_table.ajax.reload();
    });

    // Función para exportar
    $(document).on('click', '#btn-exportar-grm', function (e) {
        e.preventDefault();

        // Validar que haya registros con los filtros actuales
        var info = coti_table.page.info();
        if (info.recordsDisplay === 0) {
            swal({
                title: "No hay registros",
                text: "No hay registros para exportar con los filtros aplicados.",
                type: "warning",
                confirmButtonText: "Entendido"
            });
            return;
        }

        // Construir la URL de exportación con los filtros actuales
        var daterange = $('#data_range_filter').val();
        var value     = $('#search_all_column').val();

        var params = new URLSearchParams();
        if (daterange) params.append('daterange', daterange);
        if (value)     params.append('value', value);

        // Disparar la descarga
        window.location.href = "{{ route('guias.manual.exportar') }}?" + params.toString();
    });

    // Script para selección masiva
    $(document).ready(function() {
        // Variables globales
        var allSelectedIds = [];
        var masterChecked = false;
        
        // Inicializar iCheck
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

        // Función para obtener TODOS los IDs mediante AJAX
        function getAllIds(callback) {
            $.ajax({
                url: "{{ route('comprobantes.guiaRemisionM_registers') }}",
                method: "GET",
                data: {
                    daterange: $('#data_range_filter').val(),
                    value: $('#search_all_column').val(),
                    get_all_ids: true // Parámetro especial
                },
                success: function(response) {
                    var ids = [];
                    if (response.data && response.data.length > 0) {
                        response.data.forEach(function(row) {
                            if (row[0]) { // El ID está en la columna 0
                                ids.push(row[0].toString());
                            }
                        });
                    }
                    console.log('IDs encontrados:', ids);
                    callback(ids);
                },
                error: function(xhr, status, error) {
                    console.error('Error obteniendo IDs:', error);
                    callback([]);
                }
            });
        }

        // Checkbox del header - seleccionar/deseleccionar todos
        $('thead input[type="checkbox"]').on('ifChecked ifUnchecked', function(event) {
            if (event.type === 'ifChecked') {
                masterChecked = true;
                console.log('Master checkbox marcado - obteniendo todos los IDs...');
                
                // Obtener TODOS los IDs mediante AJAX
                getAllIds(function(ids) {
                    allSelectedIds = ids;
                    console.log('IDs seleccionados:', allSelectedIds);
                    
                    // Marcar todos los checkboxes visibles en la página actual
                    $('.dataTables-example-guia-remision tbody input[name="select_row"]').iCheck('check');
                });
            } else {
                masterChecked = false;
                allSelectedIds = [];
                console.log('Master checkbox desmarcado - allSelectedIds limpio');
                $('.dataTables-example-guia-remision tbody input[name="select_row"]').iCheck('uncheck');
            }
        });

        // Checkboxes individuales
        $(document).on('ifChecked ifUnchecked', '.dataTables-example-guia-remision tbody input[name="select_row"]', function(event) {
            var rowId = $(this).val();
            
            if (event.type === 'ifChecked') {
                if (!allSelectedIds.includes(rowId)) {
                    allSelectedIds.push(rowId);
                }
            } else {
                allSelectedIds = allSelectedIds.filter(function(id) {
                    return id !== rowId;
                });
                
                // Si se desmarca uno, desmarcar el master
                masterChecked = false;
                $('thead input[type="checkbox"]').iCheck('uncheck');
            }
            
            console.log('allSelectedIds después de checkbox individual:', allSelectedIds);
        });

        // Cuando se redibuje la tabla (cambio de página, etc.)
        coti_table.on('draw', function() {
            // Reinicializar checkboxes
            $('.dataTables-example-guia-remision tbody input[name="select_row"]').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });

            // Si master está marcado, marcar todos los checkboxes de esta página
            if (masterChecked) {
                setTimeout(function() {
                    $('.dataTables-example-guia-remision tbody input[name="select_row"]').iCheck('check');
                }, 100);
            } else {
                // Marcar solo los seleccionados individualmente
                setTimeout(function() {
                    $('.dataTables-example-guia-remision tbody input[name="select_row"]').each(function() {
                        var rowId = $(this).val();
                        if (allSelectedIds.includes(rowId)) {
                            $(this).iCheck('check');
                        }
                    });
                }, 100);
            }
        });

        // Función para imprimir guías seleccionadas
        $('#btn-imprimir-seleccion-grm').on('click', function(e) {
            e.preventDefault();
            
            console.log('IDs seleccionados:', allSelectedIds);
            
            if (allSelectedIds.length === 0) {
                swal({
                    title: "Sin selección",
                    text: "Por favor, selecciona al menos una guía para imprimir.",
                    type: "warning",
                    confirmButtonText: "Entendido"
                });
                return;
            }

            if (allSelectedIds.length > 60) {
                swal({
                    title: "Demasiadas guías",
                    text: "Selecciona máximo 60 por PDF.",
                    type: "warning",
                    confirmButtonText: "OK"
                });
                return;
            }

            swal({
                title: "Confirmar impresión",
                text: `¿Deseas imprimir ${allSelectedIds.length} guía(s) seleccionada(s)?`,
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Sí, imprimir",
                cancelButtonText: "Cancelar"
            }, function(isConfirm) {
                if (isConfirm) {
                    var url = '{{ route("guia_remision_manual.print.multiple") }}';
                    var params = new URLSearchParams();
                    
                    allSelectedIds.forEach(function(id) {
                        params.append('guia_ids[]', id);
                    });
                    
                    console.log('URL completa:', url + '?' + params.toString());
                    
                    var printWindow = window.open(
                        url + '?' + params.toString(), 
                        '_blank'
                    );
                    
                    if (printWindow) {
                        printWindow.focus();
                    } else {
                        alert('Por favor, permite ventanas emergentes para imprimir');
                    }

                    swal({
                        title: "Procesando",
                        text: "Las guías de remisión se están imprimiendo...",
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            });
        });
    });
</script>

<!-- check -->
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('js/icheck.min.js') }}"></script>
@endsection
