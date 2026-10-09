<style>
    .circle-size {
        min-height: 105px;
        min-width: 105px;
    }

    /* OCULTANDO LO DE ORGANIZAR*/
    /* Ver (números) */
    div.dataTables_length {
        display: none;
    }

    /* El Buscar */
    div.dataTables_filter {
        display: none;
    }

    /* CSV, Excel, PDF, Print */
    div.dt-buttons {
        display: none;
    }

    #modal-tipo_cambio {
        z-index: 1050;
    }

    #modal-tipo_cambio-editar {
        z-index: 1060;
    }

    .modal-backdrop-2 {
        z-index: 1055 !important;
    }
</style>

<script src="{{ asset('js/plugins/morris/raphael-2.1.0.min.js') }}"></script>
<script src="{{ asset('js/plugins/morris/morris.js') }}"></script>

<script>
    // MOSTRAR MODAL DE TIPO_CAMBIO
    $('#tipo_cambio_button').on('click', function() {
        $('#modal-tipo_cambio').modal('show');
        if (!$.fn.DataTable.isDataTable('.dataTables-tipo_cambio')) {
            datatable_tipo_cambio();
        } else {
            $('.dataTables-tipo_cambio').DataTable().ajax.reload();
        }
    });
    let tabletc;
    let permiso_tc = false;
    //  FUNCION PARA CARGAR DATATABLE DE TIPO_CAMBIO
    function datatable_tipo_cambio() {
        tabletc = $('.dataTables-tipo_cambio').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('api.get_tipo_cambio') }}",
                method: "get",
                data: function(d) {
                    d.date_filter = $('#search_tipo_cambio').val();
                },
                dataSrc: function(json) {
                    permiso_tc = json.permiso_tc;
                    return json.data;
                }
            },
            "pageLength": 7,
            "columnDefs": [{
                    sortable: false,
                    'targets': "_all"
                },
                {
                    'targets': [0],
                    'render': function(data, type, full, meta) {
                        return `${full[4]}`;
                    }
                },
                {
                    'targets': [4],
                    'render': function(data, type, full, meta) {
                        var fecha_hoy_tc = `${full[4]}`;
                        const hoy = new Date();
                        const fecha =
                            String(hoy.getDate()).padStart(2, '0') + '-' +
                            String(hoy.getMonth() + 1).padStart(2, '0') + '-' +
                            hoy.getFullYear();

                        console.log(fecha_hoy_tc);
                        console.log(fecha);
                        if (fecha_hoy_tc == fecha && permiso_tc == true) {
                            return `<button class="btn btn-primary btn-sm" id="edit_tc" data-id="${full[0]}" data-fecha="${full[4]}" data-compra="${full[1]}" data-venta="${full[2]}" data-paralelo="${full[3]}" ><i class="fa fa-pencil"></i></button>`;
                        }
                        return `<button class="btn btn-primary btn-sm" disabled><i class="fa fa-pencil"></i></button>`;
                    }
                }
            ]
        });

        // Activar tooltips de Bootstrap después de dibujar la tabla
        tabletc.on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        // Configuración del rango de fechas
        $('input[name="daterange_tipo_cambio"]').daterangepicker({
            "locale": {
                "separator": " | ",
                "applyLabel": "Guardar",
                "cancelLabel": "Cancelar",
                "fromLabel": "Desde",
                "toLabel": "Hasta",
                "customRangeLabel": "Personalizado",
                "daysOfWeek": ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                "monthNames": [
                    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
                    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
                ],
                "firstDay": 1
            }
        }, function(start, end) {
            var dates = [];
            var currentDate = new Date(start);
            var dateRangeString = dates.join('|');
            $('.dataTables-tipo_cambio').DataTable().ajax.reload();
            //    tabletc.column(3).search(dateRangeString, true, false).draw();
        });
    }
    // Función para restaurar el filtro de fecha al mes actual
    function limpiar_select_tc() {
        $('input[name="daterange_tipo_cambio"]').val(`{{ date('01/m/Y') }} - {{ date('t/m/Y') }}`);
        $('.dataTables-tipo_cambio').DataTable().ajax.reload();
    }
    $(document).on('click', '#edit_tc', function() {
        const id = $(this).data('id');
        const fecha = $(this).data('fecha');
        const compra = $(this).data('compra');
        const venta = $(this).data('venta');
        const paralelo = $(this).data('paralelo');

        $('#id_tc_ed').val(id);
        $('#fecha_tc_ed').val(fecha);
        $('#compra_tc_ed').val(compra);
        $('#venta_tc_ed').val(venta);
        $('#paralelo_tc_ed').val(paralelo);
        $('#modal-tipo_cambio-editar').modal('show');

    });

    $('#modal-tipo_cambio-editar').on('shown.bs.modal', function() {
        $('<div class="modal-backdrop fade show modal-backdrop-2"></div>')
            .appendTo(document.body);

        $('.modal-backdrop-2').css('z-index', 1055);
        $('#modal-tipo_cambio-editar').css('z-index', 1060);
    });

    $('#modal-tipo_cambio-editar').on('hidden.bs.modal', function() {
        $('.modal-backdrop-2').remove();
    });

    $('#guardar_form').on('click', function() {

        $.ajax({
            url: `{{ url('tipo_cambio') }}/${$('#id_tc_ed').val()}`,
            type: 'PUT',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: $('#id_tc_ed').val(),
                fecha: $('#fecha_tc_ed').val(),
                compra: $('#compra_tc_ed').val(),
                venta: $('#venta_tc_ed').val(),
                paralelo: $('#paralelo_tc_ed').val()
            },
            beforeSend: function() {
                $('#guardar_form')
                    .prop('disabled', true)
                    .html('<i class="fa fa-spinner fa-spin"></i> Guardando...');
            },
            success: function(response) {
                $('#modal-tipo_cambio-editar').modal('hide');
                $('.dataTables-tipo_cambio').DataTable().ajax.reload();
                toastr.success('Tipo de cambio actualizado correctamente');
            },
            error: function(xhr) {
                toastr.error('Ocurrió un error al actualizar');
                console.log(xhr.responseJSON);
            },
            complete: function() {
                $('#guardar_form')
                    .prop('disabled', false)
                    .html('Guardar');
            }
        });

    });

    $('#modal-tipo_cambio').on('shown.bs.modal', function() {
        $('#morris-one-line-chart').empty();

        const datos = @json($tipo_cambio_estaditica['data']);
        const minY = {{ $tipo_cambio_estaditica['minY'] }};
        const maxY = {{ $tipo_cambio_estaditica['maxY'] }};

        Morris.Line({
            element: 'morris-one-line-chart',
            data: datos,
            xkey: 'dia_str',
            ykeys: ['Monto'],
            labels: ['Valor'],
            resize: true,
            lineWidth: 4,
            lineColors: ['#1ab394'],
            pointSize: 5,
            ymin: minY,
            ymax: maxY,
            yLabelFormat: function(y) {
                return y.toFixed(2);
            }
        });
    });
</script>
