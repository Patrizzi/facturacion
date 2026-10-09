<script>
    // MOSTRAR MODAL DE UNIDAD MEDIDA
    $('#medida_button').on('click', function() {
        $('#modal-medida').modal('show');
        if (!$.fn.DataTable.isDataTable('.dataTables-medidas')) {
            datatable_medida();
        } else {
            $('.dataTables-medidas').DataTable().ajax.reload();
        }
    });

    //FUNCION PARA CARGAR DATATABLE DE UNIDAD MEDIDA
    let permiso_editar = false;
    let permiso_estado = false;

    function datatable_medida() {
        let table = $('.dataTables-medidas').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('api.get_unidad_medida') }}",
                method: "get",
                data: function(d) {
                    d.value = $('#search_medida').val();
                },
                dataSrc: function(json) {
                    permiso_editar = json.permiso_editar;
                    permiso_estado = json.permiso_estado;
                    return json.data;
                }
            },
            "pageLength": 8,
            "columnDefs": [{
                    sortable: false,
                    'targets': "_all"
                },
                {
                    'targets': [3],
                    'render': function(data, type, full, meta) {
                        if (data == 0) {
                            // ACTIVO
                            if (permiso_estado == false) {
                                return `
                                        <div class="tooltip-demo">
                                            <button class="btn btn-info btn-circle"
                                            data-toggle="tooltip" data-placement="left"
                                            title="Activo" type="button">
                                            <i class="fa fa-check"></i>
                                            </button>
                                        </div>`;
                            } else {
                                return `
                                        <div class="tooltip-demo">
                                            <button class="btn btn-info btn-circle change_status_u_medida"
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
                                            <button class="btn btn-danger btn-circle"
                                            data-toggle="tooltip" data-placement="left"
                                            title="Desactivado" type="button">
                                            <i class="fa fa-check"></i>
                                            </button>
                                        </div>`;
                            } else {
                                return `
                                        <div class="tooltip-demo">
                                            <button class="btn btn-danger btn-circle change_status_u_medida"
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
    //BUSQUEDA DE UNIDAD MEDIDA
    $('#search_medida').keyup(function() {
        $('.dataTables-medidas').DataTable().ajax.reload();
    });

    //  FUNCION PARA AGREGAR UNA NUEVA UNIDAD MEDIDA
    $('#add_new_medida').on('click', function() {
        let form = document.getElementById('form_medida');
        if (!form.checkValidity()) {
            form.reportValidity(); // Muestra los mensajes nativos del navegador
            return; // Detiene la ejecución si hay errores
        }
        let formData = new FormData(form);
        $.ajax({
            url: "{{ route('unidad_medida.save_ajax') }}",
            method: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                $('.dataTables-medidas').DataTable().ajax.reload();
                $('#form_medida')[0].reset();
            },
            error: function(data) {
                console.log(data);
            }
        });
    });

    //  EDITAR UNIDAD MEDIDA CON UN CLCIK EN EL ROW DEL DATATABLE
    $(document).on('click', '.dataTables-medidas tbody tr', function() {
        $('#form_medida')[0].reset();
        let table = $('.dataTables-medidas').DataTable();
        let data = table.row(this).data();
        let lastTd = $(this).find('td:last'); // Último td
        let secondLastTd = lastTd.prev(); // Penúltimo td

        if ($(event.target).is(lastTd) || $(event.target).is(secondLastTd) ||
            $(event.target).closest('td').is(lastTd) || $(event.target).closest('td').is(secondLastTd)) {
            return;
        }
        $('#update_medida').css('display', 'inline-block');
        $('#add_new_medida').css('display', 'none');
        //  PASAR DATA AL FORMULARIO
        $('#id_medida_edit').val(data[4]);
        $('#nombre_medida').val(data[1]);
        $('#simbolo_medida').val(data[0]);
        $('#unidad_medida').val(data[2]);
    });
    //  ACTUALIZAR UNIDAD MEDIDA
    $('#update_medida').on('click', function(event) {
        let table = $('.dataTables-medidas').DataTable();
        let data = table.row(this).data();

        var id_medida = $('#id_medida_edit').val();
        edit_medida(id_medida);
    })

    //  FUNCION PARA EDITAR UNIDAD MEDIDA
    function edit_medida(id) {
        let form = document.getElementById('form_medida');
        let formData = new FormData(form);
        $.ajax({
            url: "{{ route('unidad_medida.edit_ajax') }}",
            method: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                $('.dataTables-medidas').DataTable().ajax.reload();
                $('#form_medida')[0].reset();
                $('#update_medida').css('display', 'none');
                $('#add_new_medida').css('display', 'inline-block');
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    //  CANCELAR EDICION DE UNIDAD MEDIDA  Y RESETEAR FORMULARIO
    $('#cancel_medida').on('click', function() {
        $('#form_medida')[0].reset();
        if ($('#add_new_medida').css('display') == 'inline-block') {
            console.log('si');
            $('#add_new_medida').css('display', 'inline-block');
            $('#update_medida').css('display', 'none');
        } else {
            $('#update_medida').css('display', 'none');
            $('#add_new_medida').css('display', 'inline-block');
        }
    });
    // CAMBIAR ESTADO DE UNIDAD DE FAMILIA
    $(document).on('click', '.change_status_u_medida', function(event) {
        let id = $(this).val();
        $.ajax({
            url: "{{ route('unidad_medida.change_state') }}",
            method: "post",
            data: {
                '_token': $('input[name=_token]').val(),
                id: id
            },
            success: function(data) {
                console.log(data);
                toastr.success('Unidad de Medida actualizada correctamente');
                $('.dataTables-medidas').DataTable().ajax.reload();
            },
            error: function(data) {
                toastr.danger('Hubo un error al actualizar la Unidad de Medida');
            }
        });
    });
</script>
