
<!-- Modal -->
<div class="modal fade" id="UbigeoModal" tabindex="-1" role="dialog" data-bs-backdrop="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Busqueda Manual de Codigo de Ubigeo para Clientes</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="cod_ubigeo" id="cod_ubigeo">

                    <div class="form-group">
                        <label>Departamento</label>
                        <select name="departamento" id="departamento" class="form-control">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Provincia</label>
                        <select name="provincia" id="provincia" class="form-control" disabled>
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Distrito</label>
                        <select name="distrito" id="distrito" class="form-control" disabled>
                            <option value="">Seleccione...</option>
                        </select>
                    </div>
                    <button type="button" data-dismiss="modal" id="button_search" class="btn btn-primary btn-block">Guardar</button>
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
            $('#departamento').html(options);
        });

        // Al cambiar Departamento -> cargar Provincias
        $('#departamento').on('change', function() {
            let departamento = $(this).val();
            $('#provincia').html('<option value="">Seleccione...</option>').prop('disabled', true);
            $('#distrito').html('<option value="">Seleccione...</option>').prop('disabled', true);
            $('#cod_ubigeo').val('');

            if (!departamento) return;

            $.get("{{ route('pa.UbigeoProvincia') }}", {
                departamento: departamento
            }, function(data) {
                let options = '<option value="">Seleccione...</option>';
                data.forEach(prov => {
                    options += `<option value="${prov}">${prov}</option>`;
                });
                $('#provincia').html(options).prop('disabled', false);
            });
        });

        // Al cambiar Provincia -> cargar Distritos
        $('#provincia').on('change', function() {
            let departamento = $('#departamento').val();
            let provincia = $(this).val();
            $('#distrito').html('<option value="">Seleccione...</option>').prop('disabled', true);
            $('#cod_ubigeo').val('');

            if (!provincia) return;

            $.get("{{ route('pa.UbigeoDistrito') }}", {
                departamento: departamento,
                provincia: provincia
            }, function(data) {
                let options = '<option value="">Seleccione...</option>';
                data.forEach(d => {
                    options += `<option value="${d.ubigeo}">${d.distrito}</option>`;
                });
                $('#distrito').html(options).prop('disabled', false);
            });
        });
        $('#distrito').on('change', function() {
            $('#cod_ubigeo').val($(this).val());
        });
        // Al elegir Distrito -> guardar el código ubigeo real
        $('#button_search').on('click', function() {
            var ubigeo = $('#cod_ubigeo').val();
            $('#ubigeo_cli').val(ubigeo);
            // $('#UbigeoModal').modal('hide');
            // Toast para "cambio agregado"
            toastr.success('Codigo Ubigeo cambiado correctamente', ' ', { timeOut: 3000 });
        });
    });
</script>
