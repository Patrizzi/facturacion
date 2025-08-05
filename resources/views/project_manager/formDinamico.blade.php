<div class="form-group col-lg-4">
    {{ html()->label('Nombre') }}
    {{ html()->text('nombre')->placeholder('Ingrese el Nombre')->class('form-control')->value(old('nombre', $project_manager->nombre ?? '')) }}
</div>
<div class="form-group col-lg-3">
    {{ html()->label('Centro de Costo') }}
    {{ html()->text('centro_costo')->placeholder('Ingrese el Centro de Costo')->class('form-control')->value(old('centro_costo', $project_manager->centro_costo ?? '')) }}
</div>
<div class="form-group col-lg-3">
    {{ html()->label('Servicio') }}
    {{ html()->select('service_id', $servicios)->placeholder('Ingrese el Servicio')->class('form-control select')->value(old('service_id', $project_manager->service_id ?? '')) }}
</div>
<div class="form-group col-lg-2">
    {{ html()->label('Prioridad') }}
    {{ html()->select('prioridad', $priorities)->placeholder('Ingrese la Prioridad')->class('form-control select')->value(old('prioridad', $project_manager->prioridad ?? '')) }}
</div>
<div class="form-group col-lg-6">
    {{ html()->label('Cliente') }}
    {{ html()->select('cliente_id', $clients)->placeholder('Ingrese al Cliente')->class('form-control select client')->value(old('cliente_id', $project_manager->cliente_id ?? '')) }}
</div>
<div class="form-group col-lg-6">
    {{ html()->label('Administrador') }}
    {{ html()->select('administrador_id', $administradores)->placeholder('Ingrese al Administrador')->class('form-control select')->value(old('administrador_id', $project_manager->administrador_id ?? '')) }}
</div>
<div class="form-group col-lg-6">
    {{ html()->label('Ruc') }}
    {{ html()->text('ruc')->placeholder('Ingrese el ruc')->class('form-control ruc')->readonly()->value(old('ruc', $project_manager->ruc ?? '')) }}
</div>
<div class="form-group col-lg-6">
    {{ html()->label('Responsable') }}
    {{ html()->select('responsable_id', $responsables)->placeholder('Ingrese al Responsable')->class('form-control select')->value(old('responsable_id', $project_manager->responsable_id ?? '')) }}
</div>
<div class="form-group col-lg-6">
    {{ html()->label('Fecha de Inicio') }}
    {{ html()->datetime('fecha_inicio')->placeholder('Ingrese la Fecha de Inicio')->class('form-control datetime')->value(old('fecha_inicio', $project_manager->fecha_inicio ?? '')) }}
</div>
<div class="form-group col-lg-6">
    {{ html()->label('Fecha de Cierre') }}
    {{ html()->datetime('fecha_cierre')->placeholder('Ingrese la Fecha de Cierre')->class('form-control datetime')->value(old('fecha_cierre', $project_manager->fecha_cierre ?? '')) }}
</div>
@push('js')
    @once
     <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
        <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
        <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
        <script>

            $(".select").select2({
                containerCssClass: ':all:'
            });
            // $(".datetime").datepicker()

            $(".client").on("change", (e) => {
                const select_element = $(e.target)
                const input_element = $(".ruc")

                const id = select_element.val()
                if (!id) return; // validation id
                const url = "{{ route('cliente.show', ':id') }}".replace(':id', id);
                $.ajax({
                        url: url,
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .done(function(data) {
                        input_element.val(data.numero_documento)
                        toastr.success("Datos del cliente obtenidos correctamente");
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        console.error('Error:', textStatus, errorThrown);
                        toastr.error("Error al obtener los datos del cliente"); // Mensaje de error
                    });
            })
        </script>
    @endonce
@endpush
