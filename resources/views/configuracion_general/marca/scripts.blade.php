<script>
    //*  MOSTRAR MODAL DE MARCAS
    $('#marcas_button').on('click', function() {
        $('#modal-marcas').modal('show');
        if (!$.fn.DataTable.isDataTable('.dataTables-marcas')) {
            datatable_marcas();
        } else {
            $('.dataTables-marcas').DataTable().ajax.reload();
        }
    });
    //  FUNCION PARA CARGAR DATATABLE DE MARCAS
    function datatable_marcas() {
        let permiso_estado = false;
        let permiso_editar = false;
        let table = $('.dataTables-marcas').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('api.get_marcas') }}",
                method: "get",
                data: function(d) {
                    d.value = $('#search_marca').val();
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
                'targets': [4],
                'render': function(data, type, full, meta) {
                    if (!data || data.trim() === "") {
                        return `<center><i>Sin Imagen</i></center>`;
                    }
                    return `<div class="lightBoxGallery">
                                   <a href="{{ asset('archivos/imagenes/marcas/') }}/${data}" data-gallery=""><button class="btn btn-primary btn-sm "><i class="fa fa-eye"></i></button></a></div>`;
                }
            }, {
                'targets': [5],
                'className': 'button_estado_marca',
                'render': function(data, type, full, meta) {
                    if (data == 0) {
                        if (permiso_editar == false) {
                            return `<div class="tooltip-demo"><button class="btn btn-info btn-circle" data-toggle="tooltip" data-placement="left" title="Activo" type="button" ><i class="fa fa-check"></i></button></div>`;
                        } else {
                            return `<div class="tooltip-demo"><button class="btn btn-info btn-circle change_status_marca" data-toggle="tooltip" data-placement="left" title="Click para desactivar" value="${full[6]}" type="button" ><i class="fa fa-check"></i></button></div>`;
                        }
                    } else {
                        if (permiso_editar == false) {
                            return `<div class="tooltip-demo"><button class="btn btn-danger btn-circle" data-toggle="tooltip" data-placement="left" title="Desactivado" type="button" ><i class="fa fa-times"></i></button></div>`;
                        } else {
                            return `<div class="tooltip-demo"><button class="btn btn-danger btn-circle change_status_marca" value="${full[6]}" type="button" data-toggle="tooltip" data-placement="left" title="Click para activar" ><i class="fa fa-times"></i></button></div>`;
                        }
                    }
                }
            }]
        });
        table.on('draw.dt', function() {
            $('[data-toggle="tooltip"]').tooltip(); // Activa tooltips de Bootstrap
        });
    }
    //  BUSQUEDA DE MARCA
    $('#search_marca').keyup(function() {
        $('.dataTables-marcas').DataTable().ajax.reload();
    });
    // AGREGAR IMAGEN A INPUT FILE DE MARCA
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
    //  FUNCION PARA AGREGAR UNA NUEVA MARCA
    $('#add_new_marca').on('click', function() {
        let form = document.getElementById('form_marca');
        if (!form.checkValidity()) {
            form.reportValidity(); // Muestra los mensajes nativos del navegador
            return; // Detiene la ejecución si hay errores
        }
        let formData = new FormData(form);
        $.ajax({
            url: "{{ route('marcas.save_ajax') }}",
            method: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                $('.dataTables-marcas').DataTable().ajax.reload();
                $('#form_marca')[0].reset();
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
    @can('familias.editar')
        //  CAMBIAR ESTADO DE MARCA CON CLIC EN BOTON
        $(document).on('click', '.change_status_marca', function(event) {
            let id = $(this).val();
            $.ajax({
                url: "{{ route('marcas.change_state') }}",
                method: "post",
                data: {
                    '_token': $('input[name=_token]').val(),
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('.dataTables-marcas').DataTable().ajax.reload();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
        //  EDITAR MARCA CON UN CLCIK EN EL ROW DEL DATATABLE
        $(document).on('click', '.dataTables-marcas tbody tr', function() {
            $('#form_marca')[0].reset();
            let table = $('.dataTables-marcas').DataTable();
            let data = table.row(this).data();
            let lastTd = $(this).find('td:last'); // Último td
            let secondLastTd = lastTd.prev(); // Penúltimo td

            if ($(event.target).is(lastTd) || $(event.target).is(secondLastTd) ||
                $(event.target).closest('td').is(lastTd) || $(event.target).closest('td').is(secondLastTd)) {
                return;
            }
            $('#update_marca').css('display', 'inline-block');
            $('#add_new_marca').css('display', 'none');
            //  PASAR DATA AL FORMULARIO
            $('#abreviatura_marca').prop('disabled', true);
            $('#id_marca_edit').val(data[6]);
            $('#nombre_marca').val(data[0]);
            $('#abreviatura_marca').val(data[1]);
            $('#telefono_marca').val(data[2]);
            $('#descripcion_marca').val(data[3]);
            $('#file_marca').val(data[4]);
            $('#empresa_marca').val(data[7]);
            if (data[4] != null) {
                $('.custom-file-label').html('Cambiar Foto');
            } else {
                $('.custom-file-label').html('Agregar Foto');
            }
        });
        //  ACTUALIZAR MARCA
        $('#update_marca').on('click', function(event) {
            let table = $('.dataTables-marcas').DataTable();
            let data = table.row(this).data();

            var id_marca = $('#id_marca_edit').val();
            edit_marca(id_marca);
        })
    @endcan
    //  FUNCION PARA EDITAR MARCA
    function edit_marca(id) {
        let form = document.getElementById('form_marca');
        let formData = new FormData(form);
        $.ajax({
            url: "{{ route('marcas.edit_ajax') }}",
            method: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                $('.dataTables-marcas').DataTable().ajax.reload();
                $('#form_marca')[0].reset();
                $('#abreviatura_marca').prop('disabled', false);
                $('#update_marca').css('display', 'none');
                $('#add_new_marca').css('display', 'inline-block');
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    //  CANCELAR EDICION DE MARCA Y RESETEAR FORMULARIO
    $('#cancel_marca').on('click', function() {
        $('#form_marca')[0].reset();
        $('#abreviatura_marca').prop('disabled', false);
        if ($('#add_new_marca').css('display') == 'inline-block') {
            console.log('si');
            $('#add_new_marca').css('display', 'inline-block');
            $('#update_marca').css('display', 'none');
        } else {
            $('#update_marca').css('display', 'none');
            $('#add_new_marca').css('display', 'inline-block');
        }
    });
</script>
