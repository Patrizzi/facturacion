{{-- MODAL AGREGAR --}}
<div class="modal fade" id="nuevoProveedorModal" tabindex="-1" aria-labelledby="nuevoProveedorModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h3 class="modal-title" id="nuevoProveedorModalLabel">
                    Nuevo
                    Proveedor</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
                <form id="formNuevoProveedor">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row mb-3">
                        <strong class="col-sm-2 col-form-label fw-bold">N°
                            Ruc:</strong>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <input type="text" class="form-control" id="ruc_prov" name="ruc"
                                    placeholder="Ingrese el RUC del Proveedor" required>
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button" id="btn-validar-ruc">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <strong class="col-sm-2 col-form-label fw-bold">Empresa:</strong>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="razon_social_prov" name="nombre"
                                placeholder="Ingrese Nombre de la Empresa">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <strong class="col-sm-2 col-form-label fw-bold">Dirección:</strong>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="direccion_prov" name="direccion"
                                placeholder="Ingrese la Dirección">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <strong class="col-sm-2 col-form-label fw-bold">Teléfono:</strong>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="telefono" name="telefono"
                                placeholder="Ingrese el número de Teléfono">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <strong class="col-sm-2 col-form-label fw-bold">Correo:</strong>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="correo" name="correo"
                                placeholder="Ingrese el Correo">
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <strong class="col-sm-2 col-form-label fw-bold">Contacto:</strong>
                        <div class="col-sm-10">
                            <input type="text" name="contacto_provedor" id="" class="form-control"
                                placeholder="Ingrese el nombre del contacto">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <strong class="col-sm-2 col-form-label fw-bold">Celular:</strong>
                        <div class="col-sm-10">
                            <input type="text" name="celular_provedor" id="" class="form-control"
                                placeholder="Ingrese el celular del contacto">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <strong class="col-sm-2 col-form-label fw-bold">Correo:</strong>
                        <div class="col-sm-10">
                            <input type="email" name="email_provedor" id="" class="form-control"
                                placeholder="Ingrese el correo del contacto">
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <strong class="col-sm-2 col-form-label fw-bold">Observacion:</strong>
                        <div class="col-sm-10">
                            <input type="text" name="observacion" id="" class="form-control"
                                placeholder="Ingrese una observación">
                        </div>
                    </div>
                </form>
            </div>
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btn-agregar-usuario" style="">Guardar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#btn-agregar-usuario').on('click', function(e) {
        e.preventDefault();
        var formData = $('#formNuevoProveedor').serialize();

        $.ajax({
            type: 'POST',
            url: '{{ route('provedor.store') }}',
            data: formData,
            success: function(response) {
                $('#nuevoProveedorModal').modal('hide');
                $('.dataTables-example').DataTable().ajax.reload();
            },
            error: function(xhr) {
                console.error(xhr);
                alert('Error al agregar el proveedor. Por favor, inténtelo de nuevo.');
            }
        });
    });

    $('#btn-validar-ruc').on('click', function() {
        var ruc = $('#ruc_prov').val();
        if (ruc) {
            $.ajax({
                url: '{{ url('provedorruc') }}',
                type: 'GET',
                data: {
                    ruc: ruc    
                },
                success: function(data) {
                    console.log(data);
                    if (data.length > 0) {
                        $('#razon_social_prov').val(data[1]);
                        $('#direccion_prov').val(data[2]);
                    } else {
                        toastr.error("No se encontró información para el RUC proporcionado.",
                            'Verifique el RUC', {
                                timeOut: 3000
                            });
                    }
                },
                error: function() {
                    toastr.error("Error al validar el RUC.",
                        'Verifique el RUC', {
                            timeOut: 3000
                        });
                }
            });
        } else {
            toastr.warning("Por favor, ingrese un RUC válido.",
                'Verifique el RUC', {
                    timeOut: 3000
                });
        }
    });
</script>
