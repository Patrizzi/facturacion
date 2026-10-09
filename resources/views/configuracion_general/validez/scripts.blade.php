    <script>
        //*  MOSTRAR MODAL DE VALIDEZ
        $('#validez_button').on('click', function() {
            $('#modal-validez').modal('show');
            if (!$.fn.DataTable.isDataTable('.dataTables-validez')) {
                datatable_validez();
            } else {
                $('.dataTables-validez').DataTable().ajax.reload();
            }
        });
        //  FUNCION PARA CARGAR DATATABLE DE VALIDEZ
        function datatable_validez() {
            let permiso_editar = false;
            let permiso_estado = false;
            let table = $('.dataTables-validez').DataTable({
                "serverSide": true,
                "ajax": {
                    url: "{{ route('api.get_validez') }}",
                    method: "get",
                    data: function(d) {
                        d.value = $('#search_validez').val();
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
                    'targets': [1],
                    'className': 'button_estado_validez',
                    'render': function(data, type, full, meta) {
                        if (data == 0) {
                            if (permiso_estado == false) {
                                return `<div class="tooltip-demo"><button class="btn btn-info btn-circle" data-toggle="tooltip" data-placement="left" title="Activo" type="button" ><i class="fa fa-check"></i></button></div>`;
                            } else {
                                return `<div class="tooltip-demo"><button class="btn btn-info btn-circle change_status_validez" data-toggle="tooltip" data-placement="left" title="Click para desactivar" value="${full[2]}" type="button" ><i class="fa fa-check"></i></button></div>`;
                            }
                        } else {
                            if (permiso_estado == false) {
                                return `<div class="tooltip-demo"><button class="btn btn-danger btn-circle " type="button" data-toggle="tooltip" data-placement="left" title="Desactivado" ><i class="fa fa-times"></i></button></div>`;
                            } else {
                                return `<div class="tooltip-demo"><button class="btn btn-danger btn-circle change_status_validez" value="${full[2]}" type="button" data-toggle="tooltip" data-placement="left" title="Click para activar" ><i class="fa fa-times"></i></button></div>`;

                            }
                        }

                    }
                }]
            });
            table.on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip(); // Activa tooltips de Bootstrap
            });
        }
        //  BUSQUEDA DE VALIDEZ
        $('#search_validez').keyup(function() {
            $('.dataTables-validez').DataTable().ajax.reload();
        });
        //  FUNCION PARA AGREGAR UNA NUEVA VALIDEZ
        $('#add_new_validez').on('click', function() {
            let form = document.getElementById('form_validez');
            if (!form.checkValidity()) {
                form.reportValidity(); // Muestra los mensajes nativos del navegador
                return; // Detiene la ejecución si hay errores
            }
            let formData = new FormData(form);
            $.ajax({
                url: "{{ route('validez.save_ajax') }}",
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    $('.dataTables-validez').DataTable().ajax.reload();
                    $('#form_validez')[0].reset();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
        //  CAMBIAR ESTADO DE VALIDEZ CON CLIC EN BOTON
        $(document).on('click', '.change_status_validez', function(event) {
            let id = $(this).val();
            $.ajax({
                url: "{{ route('validez.change_state') }}",
                method: "post",
                data: {
                    '_token': $('input[name=_token]').val(),
                    id: id
                },
                success: function(data) {
                    toastr.success('Validez actualizada correctamente');
                    $('.dataTables-validez').DataTable().ajax.reload();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
        //  EDITAR VALIDEZ CON UN CLICK EN EL ROW DEL DATATABLE
        $(document).on('click', '.dataTables-validez tbody tr', function() {
            $('#form_validez')[0].reset();
            let table = $('.dataTables-validez').DataTable();
            let data = table.row(this).data();
            let lastTd = $(this).find('td:last'); // Último td
            let secondLastTd = lastTd.prev(); // Penúltimo td

            if ($(event.target).is(lastTd) ||
                $(event.target).closest('td').is(lastTd)) {
                return;
            }
            $('#update_validez').css('display', 'inline-block');
            $('#add_new_validez').css('display', 'none');
            //  PASAR DATA AL FORMULARIO
            $('#descripcion_validez').val(data[0]);
            $('#id_validez_edit').val(data[2]);

        });
        //  ACTUALIZAR VALIDEZ
        $('#update_validez').on('click', function(event) {
            let table = $('.dataTables-validez').DataTable();
            let data = table.row(this).data();

            var id_validez = $('#id_validez_edit').val();
            edit_validez(id_validez);
        })
        //  FUNCION PARA EDITAR VALIDEZ
        function edit_validez(id) {
            let form = document.getElementById('form_validez');
            let formData = new FormData(form);
            $.ajax({
                url: "{{ route('validez.edit_ajax') }}",
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    $('.dataTables-validez').DataTable().ajax.reload();
                    $('#form_validez')[0].reset();
                    $('#update_validez').css('display', 'none');
                    $('#add_new_validez').css('display', 'inline-block');
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
        //  CANCELAR EDICION DE VALIDEZ Y RESETEAR FORMULARIO
        $('#cancel_validez').on('click', function() {
            $('#form_validez')[0].reset();
            if ($('#add_new_validez').css('display') == 'inline-block') {
                console.log('si');
                $('#add_new_validez').css('display', 'inline-block');
                $('#update_validez').css('display', 'none');
            } else {
                $('#update_validez').css('display', 'none');
                $('#add_new_validez').css('display', 'inline-block');
            }
        });
    </script>
