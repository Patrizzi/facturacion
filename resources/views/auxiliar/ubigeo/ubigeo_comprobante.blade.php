
<!-- Modal -->
<div class="modal fade" id="ComprobanteUbigeoModal" tabindex="-1" role="dialog" data-bs-backdrop="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Busqueda Manual de Codigo de Ubigeo para Comprobantes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="cod_ubigeo_comprobantes" id="cod_ubigeo_comprobantes">

                    <div class="form-group">
                        <label>Departamento</label>
                        <select name="departamento_ubigeo" id="departamento_ubigeo" class="form-control">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Provincia</label>
                        <select name="provincia_ubigeo" id="provincia_ubigeo" class="form-control" disabled>
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Distrito</label>
                        <select name="distrito_ubigeo" id="distrito_ubigeo" class="form-control" disabled>
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <button type="button" data-dismiss="modal" id="button_ubigeo_comprobante" class="btn btn-primary btn-block">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {

        // Cargar departamentos al inicio
        $.get("{{ route('pa.UbigeoDepartamento') }}", function(data) {
            let options = '<option value="">Seleccione...</option>';
            data.forEach(dep => {
                options += `<option value="${dep}">${dep}</option>`;
            });
            $('#departamento_ubigeo').html(options);
        });

        // Al cambiar Departamento -> cargar Provincias
        $('#departamento_ubigeo').on('change', function() {
            let departamento = $(this).val();
            $('#provincia_ubigeo').html('<option value="">Seleccione...</option>').prop('disabled', true);
            $('#distrito_ubigeo').html('<option value="">Seleccione...</option>').prop('disabled', true);
            $('#cod_ubigeo_comprobantes').val('');

            if (!departamento) return;

            $.get("{{ route('pa.UbigeoProvincia') }}", {
                departamento: departamento
            }, function(data) {
                let options = '<option value="">Seleccione...</option>';
                data.forEach(prov => {
                    options += `<option value="${prov}">${prov}</option>`;
                });
                $('#provincia_ubigeo').html(options).prop('disabled', false);
            });
        });

        // Al cambiar Provincia -> cargar Distritos
        $('#provincia_ubigeo').on('change', function() {
            let departamento = $('#departamento_ubigeo').val();
            let provincia = $(this).val();
            $('#distrito_ubigeo').html('<option value="">Seleccione...</option>').prop('disabled', true);
            $('#cod_ubigeo_comprobantes').val('');

            if (!provincia) return;

            $.get("{{ route('pa.UbigeoDistrito') }}", {
                departamento: departamento,
                provincia: provincia
            }, function(data) {
                let options = '<option value="">Seleccione...</option>';
                data.forEach(d => {
                    options += `<option value="${d.ubigeo}">${d.distrito}</option>`;
                });
                $('#distrito_ubigeo').html(options).prop('disabled', false);
            });
        });
        $('#distrito_ubigeo').on('change', function() {
            $('#cod_ubigeo_comprobantes').val($(this).val());
        });
        // Al elegir Distrito -> guardar el código ubigeo real
        // $('#button_search').on('click', function() {
        //     var ubigeo = $('#cod_ubigeo_comprobantes').val();
        //     $('#ubigeo_cli').val(ubigeo);
        //     // $('#UbigeoModal').modal('hide');
        //     // Toast para "cambio agregado"
        //     toastr.success('Codigo Ubigeo cambiado correctamente', ' ', { timeOut: 3000 });
        // });
    });
</script>
