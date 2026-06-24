<!-- modal - Tipo de Cambio-->
<div id="modal-tipo_cambio-create" class="modal fade " style="display: none;" aria-hidden="true" data-backdrop="static"
    data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="staticBackdropLabel">Agregar Tipo de Cambio</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form_tipo_cambio" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="alert alert-warning">
                        <p>Moneda Principal:<b> {{ $moneda_principal->nombre }}</b></p>
                    </div>
                    <div class="form-group  row"><label class="col-sm-2 col-form-label">Compra:</label>

                        <div class="col-sm-10">
                            @if (isset($compra))
                                <input type="text" class="form-control" name="compra" id="compra"
                                    value="{{ $compra }}" required="">
                            @else
                                <input type="text" class="form-control" name="compra" id="compra" required="">
                            @endif
                        </div>
                    </div>

                    <div class="form-group  row"><label class="col-sm-2 col-form-label">Venta:</label>
                        <div class="col-sm-10">
                            @if (isset($venta))
                                <input type="text" class="form-control" name="venta" id="venta"
                                    value="{{ $venta }}" required="">
                            @else
                                <input type="text" class="form-control" name="venta" id="venta" required="">
                            @endif
                        </div>
                    </div>

                    <div class="form-group  row"><label class="col-sm-2 col-form-label">Paralelo:</label>
                        <div class="col-sm-10">
                            @if (isset($paralelo_recomendado))
                                <input type="text" class="form-control" name="paralelo" id="paralelo"
                                    value="{{ $paralelo_recomendado }}" required="">
                            @else
                                <input type="text" class="form-control" name="paralelo" id="paralelo"
                                    required="">
                            @endif
                        </div>
                    </div>

                    <button class="btn" style="background:#0073c1;color:white;margin-right: 10px;"
                        type="submit" id="btn_guardar">Guardar</button>
                    <button type="button" class="btn" id='myajax' style="color: #0073c1;font-weight:bold"><img
                            src="{{ asset('logo_sunat.png') }}" width="20px">SUNAT</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#form_tipo_cambio').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('tipo_cambio.store') }}",
            type: "POST",
            data: $(this).serialize(),
            beforeSend: function() {
                $('#btn_guardar')
                    .prop('disabled', true)
                    .html('<i class="fa fa-spinner fa-spin"></i> Guardando...');
            },
            success: function(response) {
                toastr.success(response.message);

                // Opcional: limpiar formulari
                $('#form_tipo_cambio')[0].reset();
                $('#modal-tipo_cambio-create').modal('hide');

            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        toastr.error(value[0]);
                    });
                } else {
                    toastr.error('Ocurrió un error al guardar.');
                    console.log(xhr.responseText);
                }
            },
            complete: function() {
                $('#btn_guardar')
                    .prop('disabled', false)
                    .html('Guardar');
            }
        });
    });

    $('#myajax').click(function() {
        $.ajax({
            url: "{{ url('sunat_cambio') }}",
            data: {
                'name': "luis"
            },
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                var datos = eval(response);
                $('#compra').val(datos[0]);
                $('#venta').val(datos[1]);
                $('#paralelo').val(datos[2]);
            },
            statusCode: {
                404: function() {
                    alert('web not found');
                }
            },
            error: function(x, xs, xt) {
                window.open(JSON.stringify(x));
            }
        });
    });
</script>
