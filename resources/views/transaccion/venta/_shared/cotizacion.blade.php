<div class="panel-body">

</div>
<script>
    // $(document).ready(function() {
    //     var table = $('.dataTables-example-cotizacion').DataTable({
    //         processing: true,
    //         serverSide: true,
    //         ajax: {
    //             url: "{{ route('cotizacion_registers') }}",
    //             data: function(d) {
    //                 d.daterange = $('input[name="daterange"]').val();
    //                 d.tipo_coti = $('#select_tipo_coti').val();
    //                 d.search = $('#global_search').val();
    //             }
    //         },
    //         columns: [{
    //                 data: null,
    //                 name: 'action',
    //                 orderable: false,
    //                 searchable: false,
    //                 render: function(data, type, row) {
    //                     return `<input type="checkbox" class="i-checks" name="input[]">`;
    //                 }
    //             },
    //             {
    //                 data: 'id',
    //                 name: 'id'
    //             },
    //             {
    //                 data: 'cod_cotizacion',
    //                 name: 'cod_cotizacion'
    //             },
    //             {
    //                 data: 'cliente.numero_documento',
    //                 name: 'cliente.numero_documento'
    //             },
    //             {
    //                 data: 'cliente.nombre',
    //                 name: 'cliente.nombre'
    //             },
    //             {
    //                 data: 'emision',
    //                 name: 'emision'
    //             },
    //             {
    //                 data: 'forma_pago.nombre',
    //                 name: 'forma_pago.nombre'
    //             },
    //             {
    //                 data: 'total_conv',
    //                 name: 'total_conv',
    //                 visible: false
    //             },
    //             {
    //                 data: 'total',
    //                 name: 'total',
    //             },
    //             {
    //                 data: null,
    //                 name: 'action',
    //                 orderable: false,
    //                 searchable: false,
    //                 render: function(data, type, row) {
    //                     var url = '/cotizacion/' + row.id;
    //                     if (row.estado_proceso == "Sin Proceso") {
    //                         return `
    //                             <a href="${url}">
    //                                 <button type="button" class="btn btn-primary">
    //                                     <i class="fa fa-eye"></i>
    //                                 </button>
    //                             </a>
    //                             <button type="button" class="btn btn-warning"><i class="fa fa-clock-o"></i></button>
    //                         `;
    //                     } else {
    //                         return `
    //                             <a href="${url}">
    //                                 <button type="button" class="btn btn-primary">
    //                                     <i class="fa fa-eye"></i>
    //                                 </button>
    //                             </a>
    //                             <button type="button" class="btn btn-info"><i class="fa fa-check-circle"></i></button>
    //                         `;
    //                     }
    //                 }
    //             },
    //             {
    //                 data: 'tipo',
    //                 name: 'tipo',
    //                 visible: false
    //             },
    //         ],
    //         order: [
    //             [1, 'desc']
    //         ]
    //     });
    //     $('input[name="daterange"]').daterangepicker({
    //         "locale": {
    //             "separator": " | ",
    //             "applyLabel": "Guardar",
    //             "cancelLabel": "Cancelar",
    //             "fromLabel": "Desde",
    //             "toLabel": "Hasta",
    //             "customRangeLabel": "Custom",
    //             "daysOfWeek": [
    //                 "Do",
    //                 "Lu",
    //                 "Ma",
    //                 "Mi",
    //                 "Ju",
    //                 "Vi",
    //                 "Sa"
    //             ],
    //             "monthNames": [
    //                 "Enero",
    //                 "Febrero",
    //                 "Marzo",
    //                 "Abril",
    //                 "Mayo",
    //                 "Junio",
    //                 "Julio",
    //                 "Agosto",
    //                 "Septiembre",
    //                 "Octubre",
    //                 "Noviembre",
    //                 "Diciembre"
    //             ],
    //             "firstDay": 1
    //         }
    //     });
    //     // Cuando cambia el rango de fechas
    //     $('input[name="daterange"]').on('change', function() {
    //         table.ajax.reload();
    //     });

    //     // Cuando se selecciona un tipo de cotización
    //     $('#select_tipo_coti').on('change', function() {
    //         table.ajax.reload();
    //     });

    //     // Buscar globalmente
    //     $('#global_search').on('keyup', function() {
    //         table.search(this.value).draw();
    //     });

    //     $('#revert_select').on('click', function() {
    //         $('input[name="daterange"]').val('{{ date('01/m/Y') }} - {{ date('t/m/Y') }}');
    //         table.search(this.value).draw();
    //     });
    // });

    // $(document).ready(function() {
    //     $('.i-checks').iCheck({
    //         checkboxClass: 'icheckbox_square-green',
    //         radioClass: 'iradio_square-green',
    //     });
    // });
</script>
