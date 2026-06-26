<script>
    $('#almacen_button').on('click', function() {
        $('#modal-almacen').modal('show');
        if (!$.fn.DataTable.isDataTable('.dataTables-almacen')) {
            datatable_alarma();
        } else {
            $('.dataTables-almacen').DataTable().ajax.reload();
        }
    });

    function datatable_alarma() {
        let table = $('.dataTables-almacen').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('api.get_almacen') }}",
                method: "get",
                data: function(d) {
                    d.value = $('#search_categoria').val();
                },
                dataSrc: function(json) {
                    permiso_estado = json.permiso_estado;
                    permiso_editar = json.permiso_editar;
                    return json.data;
                }
            },
            "pageLength": 8,
            "columnDefs": [{
                sortable: false,
                'targets': "_all"
            }, {
                'targets': [5],
                'className': 'button_estado_categoria',
                'render': function(data, type, full, meta) {
                    if (data == 0) {
                        if (permiso_estado == false) {
                            return `<div class="tooltip-demo"><button class="btn btn-info btn-circle" data-toggle="tooltip" data-placement="left" title="Activo" type="button" ><i class="fa fa-check"></i></button></div>`;
                        } else {
                            return `<div class="tooltip-demo"><button class="btn btn-info btn-circle change_status_categoria" data-toggle="tooltip" data-placement="left" title="Click para desactivar" value="${full[3]}" type="button" ><i class="fa fa-check"></i></button></div>`;
                        }

                    } else {
                        if (permiso_estado == false) {
                            return `<div class="tooltip-demo"><button class="btn btn-info btn-circle" data-toggle="tooltip" data-placement="left" title="Desactivado" type="button" ><i class="fa fa-check"></i></button></div>`;
                        } else {
                            return `<div class="tooltip-demo"><button class="btn btn-danger btn-circle change_status_categoria" value="${full[3]}" type="button" data-toggle="tooltip" data-placement="left" title="Click para activar" ><i class="fa fa-times"></i></button></div>`;
                        }
                    }
                }
            }]
        });
        table.on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip(); // Activa tooltips de Bootstrap
        });
    }
</script>
