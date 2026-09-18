<script>
    // MOSTRAR MODAL DE FAMILIAS
    $('#familia_button').on('click', function() {
        $('#modal-familia').modal('show');
        if (!$.fn.DataTable.isDataTable('.dataTables-familias')) {
            datatable_familias();
        } else {
            $('.dataTables-familias').DataTable().ajax.reload();
        }
    });

    //FUNCION PARA CARGAR DATATABLE DE FAMILIA
    function datatable_familias() {
        let permiso_estado = false;
        let permiso_ver = false;
        let permiso_editar = false;
        let table = $('.dataTables-familias').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('api.get_familias') }}",
                method: "get",
                data: function(d) {
                    d.value = $('#search_familia').val();
                },
                dataSrc: function(json) {
                    permiso_estado = json.permiso_estado;
                    permiso_editar = json.permiso_editar;
                    permiso_ver = json.permiso_ver;
                    return json.data;
                }
            },
            "pageLength": 8,
            "columnDefs": [{
                    sortable: false,
                    'targets': "_all"
                },
                {
                    'targets': [4],
                    'render': function(data, type, full, meta) {
                        if (permiso_ver == true) {
                            const url = `{{ route('familia.show', '__ID__') }}`.replace('__ID__',
                                data);
                            return `
                                <a href="${url}" class="btn btn-success btn-sm">
                                    <i class="fa fa-eye"></i>
                                    </a>`;
                        } else {
                            return ``;
                        }
                    }
                },
                {
                    'targets': [5],
                    'className': 'button_estado_familia',
                    'render': function(data, type, full, meta) {
                        if (data == 0) {
                            if (permiso_estado == false) {
                                return `
                                        <div class="tooltip-demo">
                                            <button class="btn btn-info btn-circle change_status_familia"
                                            data-toggle="tooltip" data-placement="left"
                                            title="Activo" type="button">
                                            <i class="fa fa-check"></i>
                                            </button>
                                        </div>`;
                            } else {
                                return `
                                        <div class="tooltip-demo">
                                            <button class="btn btn-info btn-circle change_status_familia"
                                            data-toggle="tooltip" data-placement="left"
                                            title="Click para desactivar" value="${full[4]}" type="button">
                                            <i class="fa fa-check"></i>
                                            </button>
                                        </div>`;
                            }
                        } else {
                            if (permiso_estado == false) {
                                return `
                                        <div class="tooltip-demo">
                                            <button class="btn btn-info btn-circle"
                                            data-toggle="tooltip" data-placement="left"
                                            title="Desactivado" type="button">
                                            <i class="fa fa-check"></i>
                                            </button>
                                        </div>`;
                            } else {
                                return `
                                        <div class="tooltip-demo">
                                            <button class="btn btn-danger btn-circle change_status_familia"
                                                value="${full[4]}" type="button"
                                                data-toggle="tooltip" data-placement="left"
                                                title="Click para activar">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>`;
                            }
                        }
                    }
                }
            ]
        });

        table.on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip(); // Activa tooltips de Bootstrap
        });
    }

    //BUSQUEDA DE FAMILIA
    $('#search_familia').keyup(function() {
        $('.dataTables-familias').DataTable().ajax.reload();
    });
    // CAMBIAR ESTADO DE FAMILIA CON CLIC EN BOTON
    $(document).on('click', '.change_status_familia', function(event) {
        let id = $(this).val();
        $.ajax({
            url: "{{ route('familias.change_state') }}",
            method: "post",
            data: {
                '_token': $('input[name=_token]').val(),
                id: id
            },
            success: function(data) {
                console.log(data);
                toastr.success('Familia actualizada correctamente');
                $('.dataTables-familias').DataTable().ajax.reload();
            },
            error: function(data) {
                toastr.danger('Hubo un error al actualizar la Familia');
            }
        });
    });

    //  FUNCION PARA AGREGAR UNA NUEVA FAMILIA
    $('#add_new_familia').on('click', function() {
        let form = document.getElementById('form_familia');
        if (!form.checkValidity()) {
            form.reportValidity(); // Muestra los mensajes nativos del navegador
            return; // Detiene la ejecución si hay errores
        }
        let formData = new FormData(form);
        $.ajax({
            url: "{{ route('familias.save_ajax') }}",
            method: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                toastr.success('Se añadió una nueva familia al registro');
                $('.dataTables-familias').DataTable().ajax.reload();
                $('#form_familia')[0].reset();
            },
            error: function(data) {
                console.log(data);
            }
        });
    });

    //  EDITAR FAMILIA CON UN CLCIK EN EL ROW DEL DATATABLE
    @can('familia.editar')
        $(document).on('click', '.dataTables-familias tbody tr', function() {
            $('#form_familia')[0].reset();
            let table = $('.dataTables-familias').DataTable();
            let data = table.row(this).data();
            let lastTd = $(this).find('td:last'); // Último td
            let secondLastTd = lastTd.prev(); // Penúltimo td

            if ($(event.target).is(lastTd) || $(event.target).is(secondLastTd) ||
                $(event.target).closest('td').is(lastTd) || $(event.target).closest('td').is(secondLastTd)) {
                return;
            }
            $('#update_familia').css('display', 'inline-block');
            $('#add_new_familia').css('display', 'none');
            //  PASAR DATA AL FORMULARIO
            $('#id_familia_edit').val(data[4]);
            $('#descripcion_familia').val(data[1]);
            $('#ubicacion_familia').val(data[2]);
        });
        //  ACTUALIZAR FAMILIA
        $('#update_familia').on('click', function(event) {
            let table = $('.dataTables-familias').DataTable();
            let data = table.row(this).data();

            var id_familia = $('#id_familia_edit').val();
            edit_familia(id_familia);
        })
    @endcan

    //  FUNCION PARA EDITAR FAMILIA
    function edit_familia(id) {
        let form = document.getElementById('form_familia');
        let formData = new FormData(form);
        $.ajax({
            url: "{{ route('familias.edit_ajax') }}",
            method: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                toastr.success('Se editó la Familia correctamente');
                $('.dataTables-familias').DataTable().ajax.reload();
                $('#form_familia')[0].reset();
                $('#update_familia').css('display', 'none');
                $('#add_new_familia').css('display', 'inline-block');
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    //  CANCELAR EDICION DE FAMILIA  Y RESETEAR FORMULARIO
    $('#cancel_familia').on('click', function() {
        $('#form_familia')[0].reset();
        if ($('#add_new_familia').css('display') == 'inline-block') {
            console.log('si');
            $('#add_new_familia').css('display', 'inline-block');
            $('#update_familia').css('display', 'none');
        } else {
            $('#update_familia').css('display', 'none');
            $('#add_new_familia').css('display', 'inline-block');
        }
    });
</script>
