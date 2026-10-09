<script>
    $('.select2-responsable_edit').select2({
        placeholder: "Seleccionar Responsable"
    });
    $('.select2-responsable_create').select2({
        placeholder: "Seleccionar Responsable"
    });

    $(document).ready(function() {
        limpiarErrorEditValidacion();
        limpiarErrorCreateValidacion();
    });

    function limpiarErrorEditValidacion() {
        $('#form_edit').on('input change', '.is-invalid', function() {
            $(this).removeClass('is-invalid');
        });
    }

    function limpiarErrorCreateValidacion() {
        $('#form_create').on('input change', '.is-invalid', function() {
            $(this).removeClass('is-invalid');
        });
    }

    $('#almacen_button').on('click', function() {
        $('#modal-almacen').modal('show');
        if (!$.fn.DataTable.isDataTable('.dataTables-almacen')) {
            datatable_almacen();
        } else {
            $('.dataTables-almacen').DataTable().ajax.reload();
        }
    });

    function datatable_almacen() {
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
                    'targets': [5],
                    'className': 'buttons_acciones',
                    'render': function(data, type, full, meta) {
                        var buttons =
                        `<div class="tooltip-demo" style="display: flex;column-gap: 5px">`;

                        if (permiso_ver != false) {
                            buttons += `<button class="btn btn-sm btn-primary" 
                                data-id="${full[7]['id']}"
                                data-nombre="${full[7]['nombre']}"
                                data-abreviatura="${full[7]['abreviatura']}"
                                data-cod_postal="${full[7]['cod_postal']}"
                                data-direccion="${full[7]['direccion']}"
                                data-descripcion="${full[7]['descripcion']}"
                                data-principal="${full[7]['principal']}"
                                data-estado="${full[7]['estado']}"
                                data-responsable="${full[4]}"
                                id="almacen_ver"><i class="fa fa-eye"></i></button>`;
                        }
                        if (permiso_editar != false) {
                            buttons += `<button class="btn btn-warning btn-sm" 
                                data-id="${full[7]['id']}"
                                data-nombre="${full[7]['nombre']}"
                                data-abreviatura="${full[7]['abreviatura']}"
                                data-cod_postal="${full[7]['cod_postal']}"
                                data-direccion="${full[7]['direccion']}"
                                data-descripcion="${full[7]['descripcion']}"
                                data-principal="${full[7]['principal']}"
                                data-estado="${full[7]['estado']}"
                                data-responsable="${full[7]['responsable']}"
                                id="almacen_edit"><i class="fa fa-pencil"></i></button>`;
                        }

                        buttons += `</div>`;
                        return buttons;
                    }
                },
                {
                    'targets': [6],
                    'className': 'button_estado_categoria',
                    'render': function(data, type, full, meta) {
                        if(full[8] == 1){
                            return `<div class="tooltip-demo"><button class="btn btn-info btn-circle" disabled data-toggle="tooltip" data-placement="left" title="Activo" type="button" ><i class="fa fa-check"></i></button></div>`;
                        }
                        // Si estado == 0
                        if (data == 0) {
                            if (permiso_estado == false) {
                                return `<div class="tooltip-demo"><button class="btn btn-info btn-circle" data-toggle="tooltip" data-placement="left" title="Activo" type="button" ><i class="fa fa-check"></i></button></div>`;
                            } else {
                                return `<div class="tooltip-demo"><button class="btn btn-info btn-circle change_status_almacen" data-toggle="tooltip" data-placement="left" title="Click para desactivar" value="${full[0]}" type="button" ><i class="fa fa-check"></i></button></div>`;
                            }

                        } else {
                            if (permiso_estado == false) {
                                return `<div class="tooltip-demo"><button class="btn btn-info btn-circle" data-toggle="tooltip" data-placement="left" title="Desactivado" type="button" ><i class="fa fa-check"></i></button></div>`;
                            } else {
                                return `<div class="tooltip-demo"><button class="btn btn-danger btn-circle change_status_almacen" value="${full[0]}" type="button" data-toggle="tooltip" data-placement="left" title="Click para activar" ><i class="fa fa-times"></i></button></div>`;
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

    $(document).on('click', '.change_status_almacen', function(event) {
        let id = $(this).val();
        $.ajax({
            url: "{{ route('almacen.change_state') }}",
            method: "post",
            data: {
                '_token': $('input[name=_token]').val(),
                id: id
            },
            success: function(data) {
                console.log(data);
                $('.dataTables-almacen').DataTable().ajax.reload();
            },
            error: function(data) {
                console.log(data);
            }
        });
    });

    $(document).on('click', '#almacen_edit', function() {
        $('#tab3-tab').click();
        
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        const abreviatura = $(this).data('abreviatura');
        const cod_postal = $(this).data('cod_postal');
        const direccion = $(this).data('direccion');
        const descripcion = $(this).data('descripcion');
        const principal = $(this).data('principal');
        const estado = $(this).data('estado');
        const responsable_id = $(this).data('responsable');

        // Datos principales del almacen
        $('#almacen_id_edit').val(id);
        $('#almacen_nombre_edit').val(nombre);
        $('#almacen_abreviatura_edit').val(abreviatura);
        $('#almacen_ubigeo_edit').val(cod_postal);
        $('#almacen_direccion_edit').val(direccion);
        $('#almacen_descripcion_edit').val(descripcion);
        $('#almacen_principal_edit').val(principal);
        $('#almacen_estado').val(estado);
        $('#almacen_list').css('display', 'none');
        $('#almacen_edit_div').css('display', 'block');
        // Activar select2 de responsable y seleccionar automaticamente
        $('#almacen_responsable_edit')
            .val(responsable_id)
            .trigger('change');
        if(principal == 1){
            $('#titulo_almacen_edit').html('Almacen Principal')
        }else{
            $('#titulo_almacen_edit').html('Almacen Secundario')
        }
        // Datos de codigo de Sunat
        $.ajax({
            url: "{{ route('almacen.cod_sunat', ':id') }}".replace(':id', id),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            dataType: 'json',
            success: function(response) {
                // console.log('Respuesta:', response);
                actualizarDocumento(
                    response.config.cod_factura,
                    response.last_factura,
                    '#sunat_factura_edit',
                    '#correlativo_factura_edit',
                    response.config.serie_factura,
                );
                actualizarDocumento(
                    response.config.cod_boleta,
                    response.last_boleta,
                    '#sunat_boleta_edit',
                    '#correlativo_boleta_edit',
                    response.config.serie_boleta,
                );
                actualizarDocumento(
                    response.config.cod_remision,
                    response.last_remision,
                    '#sunat_remision_edit',
                    '#correlativo_remision_edit',
                    response.config.serie_remision,
                );
                actualizarDocumento(
                    response.config.cod_factura_m,
                    response.last_factura_m,
                    '#sunat_factura_m_edit',
                    '#correlativo_factura_m_edit',
                    response.config.serie_factura_m
                );
                actualizarDocumento(
                    response.config.cod_boleta_m,
                    response.last_boleta_m,
                    '#sunat_boleta_m_edit',
                    '#correlativo_boleta_m_edit',
                    response.config.serie_boleta_m
                );
                actualizarDocumento(
                    response.config.cod_remision_m,
                    response.last_remision_m,
                    '#sunat_remision_m_edit',
                    '#correlativo_remision_m_edit',
                    response.config.serie_remision_m
                );
                actualizarDocumento(
                    response.config.cod_nota_credito,
                    response.last_credito_f,
                    '#sunat_credit_fact_edit',
                    '#correlativo_credit_fact_edit',
                    response.config.serie_nota_credito
                );
                actualizarDocumento(
                    response.config.cod_nota_credito_b,
                    response.last_credito_b,
                    '#sunat_credit_bol_edit',
                    '#correlativo_credit_bol_edit',
                    response.config.serie_nota_credito_b
                );
                actualizarDocumento(
                    response.config.cod_nota_debito,
                    response.last_debito,
                    '#sunat_debito_edit',
                    '#correlativo_debito_edit',
                    response.config.serie_nota_debito
                );
                const cod_sunat = response.config.cod_sunat;
                $('#almacen_sunat_edit').val(cod_sunat);
            },
            error: function(xhr) {
                console.error('Error:', xhr);

                if (xhr.responseJSON) {
                    console.error(xhr.responseJSON);
                    // toastr.error(xhr.responseJSON.message ?? 'Ocurrió un error.');
                } else {
                    console.error(xhr.responseText);
                    // toastr.error('Error inesperado.');
                }
            },
        });
    });

    $('#cancel_button_edit').on('click', function() {
        $('#almacen_list').css('display', 'block');
        $('#almacen_edit_div').css('display', 'none');
    })

    $(document).on('click', '.save_edit', function(e) {
        e.preventDefault();

        const id = $('#almacen_id_edit').val();
        $.ajax({
            url: "{{ route('almacen.update', ':id') }}".replace(':id', id),
            type: "PUT",
            data: $('#form_edit').serialize(),
            success: function(response) {
                toastr.success("Almacen editado correctamente");
                $('#form_edit')[0].reset();
                $('#almacen_list').css('display', 'block');
                $('#almacen_edit_div').css('display', 'none');
                $('.dataTables-almacen').DataTable().ajax.reload();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(campo, mensajes) {
                        const input = $('#form_edit').find('[name="' + campo + '"]');
                        input.addClass('is-invalid');
                        toastr.warning('' + mensajes + '');
                    });

                } else {
                    toastr.error('No se pudo actualizar el registro');
                }
            }
        });
    });

    function actualizarDocumento(codigo, ultimo, serieId, correlativoId, serie_empty) {
        $(serieId).prop('disabled', false);
        $(correlativoId).prop('disabled', false);
        // console.log(ultimo);
        if (codigo === 'NN') {
            $(serieId).prop('disabled', true).val('');
            $(correlativoId).prop('disabled', true).val('');
        }
        if (ultimo.serie == null) {
            $(serieId).val(serie_empty);
            $(serieId).prop('disabled', false);
        } else {
            $(serieId).val(ultimo.serie);
        }
        if (ultimo.correlativo == null) {
            $(correlativoId).val(codigo);
            $(correlativoId).prop('disabled', false);
        } else {
            $(correlativoId).val(ultimo.correlativo);
        }
    }

    // CREAR

    $(document).on('click', '#almacen_create', function() {
        $('#tab5-tab').click();
        $('#almacen_list').css('display', 'none');
        $('#almacen_create_div').css('display', 'block');
        // tab_1_sunat_create
    });

    $(document).on('click', '.save_create', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('almacen.store') }}",
            type: "POST",
            data: $('#form_create').serialize(),
            success: function(response) {
                toastr.success("Almacen agregado correctamente");
                $('#form_create')[0].reset();
                $('#almacen_list').css('display', 'block');
                $('#almacen_create_div').css('display', 'none');
                $('.dataTables-almacen').DataTable().ajax.reload();
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(campo, mensajes) {
                        const input = $('#form_create').find('[name="' + campo + '"]');
                        input.addClass('is-invalid');
                        toastr.warning('' + mensajes + '');
                    });

                } else {
                    toastr.error('No se pudo actualizar el registro');
                }
            }
        });
    });

    $('#cancel_button_create').on('click', function() {
        $('#almacen_list').css('display', 'block');
        $('#almacen_create_div').css('display', 'none');
    })

    // VER

    $(document).on('click', '#almacen_ver', function() {
        $('#tab6-tab').click();
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        const abreviatura = $(this).data('abreviatura');
        const cod_postal = $(this).data('cod_postal');
        const direccion = $(this).data('direccion');
        const descripcion = $(this).data('descripcion');
        const principal = $(this).data('principal');
        const estado = $(this).data('estado');
        const responsable = $(this).data('responsable');
        if(principal == 1){
            $('#titulo_almacen_edit').html('Almacen Principal')
        }else{
            $('#titulo_almacen_edit').html('Almacen Secundario')
        }
        // Datos principales del almacen
        $('#almacen_id_show').val(id);
        $('#almacen_nombre_show').val(nombre);
        $('#almacen_abreviatura_show').val(abreviatura);
        $('#almacen_ubigeo_show').val(cod_postal);
        $('#almacen_direccion_show').val(direccion);
        $('#almacen_descripcion_show').val(descripcion);
        $('#almacen_principal_show').val(principal);
        $('#almacen_estado').val(estado);
        $('#almacen_list').css('display', 'none');
        $('#almacen_show_div').css('display', 'block');
        // Activar select2 de responsable y seleccionar automaticamente
        $('#almacen_responsable_show')
            .val(responsable);

        // Datos de codigo de Sunat
        $.ajax({
            url: "{{ route('almacen.cod_sunat', ':id') }}".replace(':id', id),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            method: 'POST',
            dataType: 'json',
            success: function(response) {
                // console.log('Respuesta:', response);
                VerSunatDocumento(
                    response.config.cod_factura,
                    response.last_factura,
                    '#sunat_factura_show',
                    '#correlativo_factura_show',
                    response.config.serie_factura,
                );
                VerSunatDocumento(
                    response.config.cod_boleta,
                    response.last_boleta,
                    '#sunat_boleta_show',
                    '#correlativo_boleta_show',
                    response.config.serie_boleta,
                );
                VerSunatDocumento(
                    response.config.cod_remision,
                    response.last_remision,
                    '#sunat_remision_show',
                    '#correlativo_remision_show',
                    response.config.serie_remision,
                );
                VerSunatDocumento(
                    response.config.cod_factura_m,
                    response.last_factura_m,
                    '#sunat_factura_m_show',
                    '#correlativo_factura_m_show',
                    response.config.serie_factura_m
                );
                VerSunatDocumento(
                    response.config.cod_boleta_m,
                    response.last_boleta_m,
                    '#sunat_boleta_m_show',
                    '#correlativo_boleta_m_show',
                    response.config.serie_boleta_m
                );
                VerSunatDocumento(
                    response.config.cod_remision_m,
                    response.last_remision_m,
                    '#sunat_remision_m_show',
                    '#correlativo_remision_m_show',
                    response.config.serie_remision_m
                );
                VerSunatDocumento(
                    response.config.cod_nota_credito,
                    response.last_credito_f,
                    '#sunat_credit_fact_show',
                    '#correlativo_credit_fact_show',
                    response.config.serie_nota_credito
                );
                VerSunatDocumento(
                    response.config.cod_nota_credito_b,
                    response.last_credito_b,
                    '#sunat_credit_bol_show',
                    '#correlativo_credit_bol_show',
                    response.config.serie_nota_credito_b
                );
                VerSunatDocumento(
                    response.config.cod_nota_debito,
                    response.last_debito,
                    '#sunat_debito_show',
                    '#correlativo_debito_show',
                    response.config.serie_nota_debito
                );
                const cod_sunat = response.config.cod_sunat;
                $('#almacen_sunat_show').val(cod_sunat);
            },
            error: function(xhr) {
                console.error('Error:', xhr);

                if (xhr.responseJSON) {
                    console.error(xhr.responseJSON);
                    // toastr.error(xhr.responseJSON.message ?? 'Ocurrió un error.');
                } else {
                    console.error(xhr.responseText);
                    // toastr.error('Error inesperado.');
                }
            },
        });
    });

    function VerSunatDocumento(codigo, ultimo, serieId, correlativoId, serie_empty) {
        $(serieId).prop('disabled', false);
        $(correlativoId).prop('disabled', false);
        // console.log(ultimo);
        if (codigo === 'NN') {
            $(serieId).val('');
            $(correlativoId).val('');
        }
        if (ultimo.serie == null) {
            $(serieId).val(serie_empty);
        } else {
            $(serieId).val(ultimo.serie);
        }
        if (ultimo.correlativo == null) {
            $(correlativoId).val(codigo);
        } else {
            $(correlativoId).val(ultimo.correlativo);
        }
    }
    $('#cancel_button_show').on('click', function() {
        $('#almacen_list').css('display', 'block');
        $('#almacen_show_div').css('display', 'none');
    })
</script>
