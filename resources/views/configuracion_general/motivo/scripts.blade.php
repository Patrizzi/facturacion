<script>
    // MOSTRAR MODAL DE MOTIVOS
    $('#motivos_button').on('click', function() {
        $('#modal-motivos').modal('show');
        if (!$.fn.DataTable.isDataTable('.dataTables-motivos')) {
            datatable_motivos();
        } else {
            $('.dataTables-motivos').DataTable().ajax.reload();
        }
    });
    //  FUNCION PARA CARGAR DATATABLE DE MOTIVOS
    function datatable_motivos() {
        let permiso_estado = false;
        let permiso_editar = false;
        let table = $('.dataTables-motivos').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('api.get_motivos') }}",
                method: "get",
                data: function(d) {
                    d.value = $('#search_motivos').val();
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
                'targets': [2],
                'className': 'button_estado_motivos',
                'render': function(data, type, full, meta) {
                    if (data == 0) {
                        if (permiso_estado == false) {
                            return `<div class="tooltip-demo"><button class="btn btn-info btn-circle" data-toggle="tooltip" data-placement="left" title="Activo" type="button" ><i class="fa fa-check"></i></button></div>`;
                        } else {
                            return `<div class="tooltip-demo"><button class="btn btn-info btn-circle change_status_motivos" data-toggle="tooltip" data-placement="left" title="Click para desactivar" value="${full[3]}" type="button" ><i class="fa fa-check"></i></button></div>`;
                        }
                    } else {
                        if (permiso_estado == false) {
                            return `<div class="tooltip-demo"><button class="btn btn-danger btn-circle "  type="button" data-toggle="tooltip" data-placement="left" title="Desactivo" ><i class="fa fa-times"></i></button></div>`;

                        } else {
                            return `<div class="tooltip-demo"><button class="btn btn-danger btn-circle change_status_motivos" value="${full[3]}" type="button" data-toggle="tooltip" data-placement="left" title="Click para activar" ><i class="fa fa-times"></i></button></div>`;
                        }
                    }
                }
            }]
        });
        table.on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip(); // Activa tooltips de Bootstrap
        });
    }
    //  BUSQUEDA DE MOTIVOS
    $('#search_motivos').keyup(function() {
        $('.dataTables-motivos').DataTable().ajax.reload();
    });
    //  FUNCION PARA AGREGAR UN NUEVO MOTIVO
    $('#add_new_motivos').on('click', function() {
        let form = document.getElementById('form_motivos');
        if (!form.checkValidity()) {
            form.reportValidity(); // Muestra los mensajes nativos del navegador
            return; // Detiene la ejecución si hay errores
        }
        let formData = new FormData(form);
        $.ajax({
            url: "{{ route('motivos.save_ajax') }}",
            method: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                $('.dataTables-motivos').DataTable().ajax.reload();
                $('#form_motivos')[0].reset();
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
    //  CAMBIAR ESTADO DE MOTIVOS CON CLIC EN BOTON
    $(document).on('click', '.change_status_motivos', function(event) {
        let id = $(this).val();
        $.ajax({
            url: "{{ route('motivos.change_state') }}",
            method: "post",
            data: {
                '_token': $('input[name=_token]').val(),
                id: id
            },
            success: function(data) {
                console.log(data);
                $('.dataTables-motivos').DataTable().ajax.reload();
            },
            error: function(data) {
                console.log(data);
            }
        });
    });

    @can('motivos.editar')
        //  EDITAR MARCA CON UN CLCIK EN EL ROW DEL DATATABLE
        $(document).on('click', '.dataTables-motivos tbody tr', function() {
            $('#form_motivos')[0].reset();
            let table = $('.dataTables-motivos').DataTable();
            let data = table.row(this).data();
            let lastTd = $(this).find('td:last'); // Último td
            let secondLastTd = lastTd.prev(); // Penúltimo td

            if ($(event.target).is(lastTd) ||
                $(event.target).closest('td').is(lastTd)) {
                return;
            }
            $('#update_motivos').css('display', 'inline-block');
            $('#add_new_motivos').css('display', 'none');
            //  PASAR DATA AL FORMULARIO
            $('#id_motivos_edit').val(data[3]);
            $('#nombre_motivos_edit').val(data[0]);
            $('#select_motivos').val(data[1]);
        });
        //  ACTUALIZAR MOTIVOS
        $('#update_motivos').on('click', function(event) {
            let table = $('.dataTables-motivos').DataTable();
            let data = table.row(this).data();

            var id_motivo = $('#id_motivos_edit').val();
            edit_motivos(id_motivo);
        })
    @endcan
    //  FUNCION PARA EDITAR MOTIVOS
    function edit_motivos(id) {
        let form = document.getElementById('form_motivos');
        let formData = new FormData(form);
        $.ajax({
            url: "{{ route('motivos.edit_ajax') }}",
            method: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                $('.dataTables-motivos').DataTable().ajax.reload();
                $('#form_motivos')[0].reset();
                $('#update_motivos').css('display', 'none');
                $('#add_new_motivos').css('display', 'inline-block');
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

    //  CANCELAR EDICION DE MOTIVOS Y RESETEAR FORMULARIO
    $('#cancel_motivos').on('click', function() {
        $('#form_motivos')[0].reset();
        if ($('#add_new_motivos').css('display') == 'inline-block') {
            console.log('si');
            $('#add_new_motivos').css('display', 'inline-block');
            $('#update_motivos').css('display', 'none');
        } else {
            $('#update_motivos').css('display', 'none');
            $('#add_new_motivos').css('display', 'inline-block');
        }
    });
</script>
