<script>
    //*  MOSTRAR MODAL DE CATEGORIAS
    $('#categorias_button').on('click', function() {
        $('#modal-categorias').modal('show');
        if (!$.fn.DataTable.isDataTable('.dataTables-categorias')) {
            datatable_categorias();
        } else {
            $('.dataTables-categorias').DataTable().ajax.reload();
        }
    });
    //  FUNCION PARA CARGAR DATATABLE DE CATEGORIAS
    function datatable_categorias() {
        let permiso_estado = false;
        let permiso_editar = false;
        let table = $('.dataTables-categorias').DataTable({
            "serverSide": true,
            "ajax": {
                url: "{{ route('api.get_categorias') }}",
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
                'targets': [2],
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
    //  BUSQUEDA DE CATEGORIA
    $('#search_categoria').keyup(function() {
        $('.dataTables-categorias').DataTable().ajax.reload();
    });
    //  FUNCION PARA AGREGAR UNA NUEVA CATEGORIA
    $('#add_new_categoria').on('click', function() {
        let form = document.getElementById('form_categoria');
        if (!form.checkValidity()) {
            form.reportValidity(); // Muestra los mensajes nativos del navegador
            return; // Detiene la ejecución si hay errores
        }
        let formData = new FormData(form);
        $.ajax({
            url: "{{ route('categorias.save_ajax') }}",
            method: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                $('.dataTables-categorias').DataTable().ajax.reload();
                $('#form_categoria')[0].reset();
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
    //  CAMBIAR ESTADO DE CATEGORIA CON CLIC EN BOTON
    $(document).on('click', '.change_status_categoria', function(event) {
        let id = $(this).val();
        $.ajax({
            url: "{{ route('categorias.change_state') }}",
            method: "post",
            data: {
                '_token': $('input[name=_token]').val(),
                id: id
            },
            success: function(data) {
                console.log(data);
                $('.dataTables-categorias').DataTable().ajax.reload();
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
    //  EDITAR CATEGORIA CON UN CLCIK EN EL ROW DEL DATATABLE
    $(document).on('click', '.dataTables-categorias tbody tr', function() {
        $('#form_categoria')[0].reset();
        let table = $('.dataTables-categorias').DataTable();
        let data = table.row(this).data();
        let lastTd = $(this).find('td:last'); // Último td
        let secondLastTd = lastTd.prev(); // Penúltimo td

        if ($(event.target).is(lastTd) ||
            $(event.target).closest('td').is(lastTd)) {
            return;
        }
        $('#update_categoria').css('display', 'inline-block');
        $('#add_new_categoria').css('display', 'none');
        //  PASAR DATA AL FORMULARIO
        $('#codigo_categoria_edit').val(data[0]);
        $('#descripcion_categoria').val(data[1]);
        $('#id_categoria_edit').val(data[3]);

    });
    //  ACTUALIZAR CATEGORIA
    $('#update_categoria').on('click', function(event) {
        let table = $('.dataTables-categorias').DataTable();
        let data = table.row(this).data();

        var id_categoria = $('#codigo_categoria_edit').val();
        edit_categoria(id_categoria);
    })
    //  FUNCION PARA EDITAR CATEGORIA
    function edit_categoria(id) {
        let form = document.getElementById('form_categoria');
        let formData = new FormData(form);
        $.ajax({
            url: "{{ route('categorias.edit_ajax') }}",
            method: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                console.log(data);
                $('.dataTables-categorias').DataTable().ajax.reload();
                $('#form_categoria')[0].reset();
                $('#update_categoria').css('display', 'none');
                $('#add_new_categoria').css('display', 'inline-block');
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
    //  CANCELAR EDICION DE CATEGORIA Y RESETEAR FORMULARIO
    $('#cancel_categoria').on('click', function() {
        $('#form_categoria')[0].reset();
        if ($('#add_new_categoria').css('display') == 'inline-block') {
            console.log('si');
            $('#add_new_categoria').css('display', 'inline-block');
            $('#update_categoria').css('display', 'none');
        } else {
            $('#update_categoria').css('display', 'none');
            $('#add_new_categoria').css('display', 'inline-block');
        }
    });
</script>
