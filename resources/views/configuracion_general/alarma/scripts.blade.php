    <script>
        // MOSTRAR MODAL DE ALARMA
        $('#alarma_button').on('click', function() {
            $('#modal-alarma').modal('show');
            if (!$.fn.DataTable.isDataTable('.dataTables-alarma')) {
                datatable_alarma();
            } else {
                $('.dataTables-alarma').DataTable().ajax.reload();
            }
        });
        //  FUNCION PARA CARGAR DATATABLE DE ALARMA
        function datatable_alarma() {
            let table = $('.dataTables-alarma').DataTable({
                "serverSide": true,
                "ajax": {
                    url: "{{ route('api.get_alarma') }}",
                    method: "get",
                    data: function(d) {
                        d.value = $('#search_alarma').val();
                    },
                    dataSrc: function(json) {
                        return json.data;
                    }
                },
                "pageLength": 8,
                "columnDefs": [{
                    sortable: false,
                    'targets': "_all"
                }, {
                    'targets': [1],
                    'className': 'button_estado_alarma',
                    'render': function(data, type, full, meta) {
                        if (data == 0) {
                            return `<div class="tooltip-demo"><button class="btn btn-info btn-circle change_status_alarma" data-toggle="tooltip" data-placement="left" title="Click para desactivar" value="${full[3]}" type="button" ><i class="fa fa-check"></i></button></div>`;
                        }
                        return `<div class="tooltip-demo"><button class="btn btn-danger btn-circle change_status_alarma" value="${full[3]}" type="button" data-toggle="tooltip" data-placement="left" title="Click para activar" ><i class="fa fa-times"></i></button></div>`;
                    }
                }]
            });
            table.on('draw.dt', function() {
                $('[data-toggle="tooltip"]').tooltip(); // Activa tooltips de Bootstrap
            });
        }
        //  BUSQUEDA DE ALARMA
        $('#search_alarma').keyup(function() {
            $('.dataTables-alarma').DataTable().ajax.reload();
        });
        //  FUNCION PARA AGREGAR UNA NUEVA ALARMA
        $('#add_new_alarma').on('click', function() {
            let form = document.getElementById('form_alarma');
            if (!form.checkValidity()) {
                form.reportValidity(); // Muestra los mensajes nativos del navegador
                return; // Detiene la ejecución si hay errores
            }
            let formData = new FormData(form);
            $.ajax({
                url: "{{ route('alarma.save_ajax') }}",
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    $('.dataTables-alarma').DataTable().ajax.reload();
                    $('#form_alarma')[0].reset();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
        //  CAMBIAR ESTADO DE ALARMA CON CLIC EN BOTON
        $(document).on('click', '.change_status_alarma', function(event) {
            let id = $(this).val();
            $.ajax({
                url: "{{ route('alarma.change_state') }}",
                method: "post",
                data: {
                    '_token': $('input[name=_token]').val(),
                    id: id
                },
                success: function(data) {
                    console.log(data);
                    $('.dataTables-alarma').DataTable().ajax.reload();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
        //  EDITAR ALARMA CON UN CLICK EN EL ROW DEL DATATABLE
        $(document).on('click', '.dataTables-alarma tbody tr', function() {
            $('#form_alarma')[0].reset();
            let table = $('.dataTables-alarma').DataTable();
            let data = table.row(this).data();
            let lastTd = $(this).find('td:last'); // Último td
            let secondLastTd = lastTd.prev(); // Penúltimo td

            if ($(event.target).is(lastTd) ||
                $(event.target).closest('td').is(lastTd)) {
                return;
            }
            $('#update_alarma').css('display', 'inline-block');
            $('#add_new_alarma').css('display', 'none');
            //  PASAR DATA AL FORMULARIO
            $('#descripcion_alarma').val(data[0]);
            $('#tipo').val(data[1]);
            $('#alarma').val(data[2]);
            $('#alarma').val(data[2]);
            $('#id_alarma_edit').val(data[5]);

        });
        //  ACTUALIZAR ALARMA
        $('#update_alarma').on('click', function(event) {
            let table = $('.dataTables-alarma').DataTable();
            let data = table.row(this).data();

            var id_alarma = $('#id_alarma_edit').val();
            edit_alarma(id_alarma);
        })
        //  FUNCION PARA EDITAR ALARMA
        function edit_alarma(id) {
            let form = document.getElementById('form_alarma');
            let formData = new FormData(form);
            $.ajax({
                url: "{{ route('alarma.edit_ajax') }}",
                method: "post",
                data: formData,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                    $('.dataTables-alarma').DataTable().ajax.reload();
                    $('#form_alarma')[0].reset();
                    $('#update_alarma').css('display', 'none');
                    $('#add_new_alarma').css('display', 'inline-block');
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
        //  CANCELAR EDICION DE ALARMA Y RESETEAR FORMULARIO
        $('#cancel_alarma').on('click', function() {
            $('#form_alarma')[0].reset();
            if ($('#add_new_alarma').css('display') == 'inline-block') {
                console.log('si');
                $('#add_new_alarma').css('display', 'inline-block');
                $('#update_alarma').css('display', 'none');
            } else {
                $('#update_alarma').css('display', 'none');
                $('#add_new_alarma').css('display', 'inline-block');
            }
        });
    </script>
