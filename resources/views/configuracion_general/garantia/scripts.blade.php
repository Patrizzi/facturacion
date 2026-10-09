<script>
    //*  MOSTRAR MODAL DE GARANTIA
    $('#garantia_button').on('click', function() {
        $('#modal-garantia').modal('show');
        if (!$.fn.DataTable.isDataTable('.dataTables-garantia')) {
            datatable_garantia();
        } else {
            $('.dataTables-garantia').DataTable().ajax.reload();
        }
    });

    //  FUNCION PARA CARGAR DATATABLE DE GARANTIA
    function datatable_garantia() {
        let permiso_editar = false;
        let permiso_estado = false;
        let table = $('.dataTables-garantia').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('api.get_garantias') }}",
                method: "get",
                data: function(d) {
                    d.value = $('#search_garantia').val();
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
            }, {
                'targets': [1],
                'width': "5%",
                'className': 'button_estado_garantia',
                'render': function(data, type, full, meta) {
                    if (data == 0) {
                        if (permiso_estado == false) {
                            return `<div class="tooltip-demo"><button class="btn btn-info btn-circle" data-toggle="tooltip" data-placement="left" title="Activo" type="button" ><i class="fa fa-check"></i></button></div>`;
                        } else {
                            return `<div class="tooltip-demo"><button class="btn btn-info btn-circle change_status_garantia" data-toggle="tooltip" data-placement="left" title="Click para desactivar" value="${full[2]}" type="button" ><i class="fa fa-check"></i></button></div>`;
                        }
                    } else {
                        if (permiso_estado == false) {
                            return `<div class="tooltip-demo"><button class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="left" title="Desactivado" type="button" ><i class="fa fa-times"></i></button></div>`;
                        } else {
                            return `<div class="tooltip-demo"><button class="btn btn-danger btn-circle change_status_garantia" value="${full[2]}" type="button" data-toggle="tooltip" data-placement="left" title="Click para activar" ><i class="fa fa-times"></i></button></div>`;
                        }
                    }

                }
            }]
        });
        table.on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip(); // Activa tooltips de Bootstrap
        });
    }
    //  BUSQUEDA DE GARANTIA
    $('#search_garantia').keyup(function() {
        $('.dataTables-garantia').DataTable().ajax.reload();
    });
    //  FUNCION PARA AGREGAR UNA NUEVA GARANTIA
    $('#add_new_garantia').on('click', function() {
        let form = document.getElementById('form_garantia');
        if (!form.checkValidity()) {
            form.reportValidity(); // Muestra los mensajes nativos del navegador
            return; // Detiene la ejecución si hay errores
        }
        let formData = new FormData(form);
        $.ajax({
            url: "{{ route('garantia.save_ajax') }}",
            method: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                toastr.success('Se añadió una nueva Garantia al registro');
                $('.dataTables-garantia').DataTable().ajax.reload();
                $('#form_garantia')[0].reset();
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
    //  CAMBIAR ESTADO DE GARANTIA CON CLIC EN BOTON
    $(document).on('click', '.change_status_garantia', function(event) {
        let id = $(this).val();
        $.ajax({
            url: "{{ route('garantia.change_state') }}",
            method: "post",
            data: {
                '_token': $('input[name=_token]').val(),
                id: id
            },
            success: function(data) {
                toastr.success('Garantia actualizada correctamente');
                $('.dataTables-garantia').DataTable().ajax.reload();
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
    @can('garantia_doc.editar')
        //  EDITAR GARANTIA CON UN CLICK EN EL ROW DEL DATATABLE
        $(document).on('click', '.dataTables-garantia tbody tr', function() {
            $('#form_garantia')[0].reset();
            let table = $('.dataTables-garantia').DataTable();
            let data = table.row(this).data();
            let lastTd = $(this).find('td:last'); // Último td
            let secondLastTd = lastTd.prev(); // Penúltimo td

            if ($(event.target).is(lastTd) ||
                $(event.target).closest('td').is(lastTd)) {
                return;
            }
            $('#update_garantia').css('display', 'inline-block');
            $('#add_new_garantia').css('display', 'none');
            //  PASAR DATA AL FORMULARIO
            $('#descripcion_garantia').val(data[0]);
            $('#id_garantia_edit').val(data[2]);

        });
        //  ACTUALIZAR GARANTIA
        $('#update_garantia').on('click', function(event) {
            let table = $('.dataTables-garantia').DataTable();
            let data = table.row(this).data();

            var id_garantia = $('#id_garantia_edit').val();
            edit_garantia(id_garantia);
        })
    @endcan
    //  FUNCION PARA EDITAR GARANTIA
    function edit_garantia(id) {
        let form = document.getElementById('form_garantia');
        let formData = new FormData(form);
        $.ajax({
            url: "{{ route('garantia.edit_ajax') }}",
            method: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                toastr.success('Se editó la Garantia correctamente');
                $('.dataTables-garantia').DataTable().ajax.reload();
                $('#form_garantia')[0].reset();
                $('#update_garantia').css('display', 'none');
                $('#add_new_garantia').css('display', 'inline-block');
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    //  CANCELAR EDICION DE GARANTIA Y RESETEAR FORMULARIO
    $('#cancel_garantia').on('click', function() {
        $('#form_garantia')[0].reset();
        if ($('#add_new_garantia').css('display') == 'inline-block') {
            $('#add_new_garantia').css('display', 'inline-block');
            $('#update_garantia').css('display', 'none');
        } else {
            $('#update_garantia').css('display', 'none');
            $('#add_new_garantia').css('display', 'inline-block');
        }
    });
</script>
