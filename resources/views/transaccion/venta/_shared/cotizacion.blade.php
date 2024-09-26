<div class="panel-body">
    <div class="row">
        <div class="col-sm-4">
            <div class="input-group">
                <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                <input class="form-control" type="text" name="daterange"
                    value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}" />
                <span class="input-group-append">
                    <button type="button" class="btn btn-secondary" onclick="revert_select()">
                        <i class="fa fa-history"></i>
                    </button>
                </span>
                <span class="input-group-append">
                    <button type="button" class="btn btn-primary" onclick="limpiar_select()">
                        <i class="fa fa-eraser"></i>
                    </button>
                </span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="form-group row">
                <select class="form-control col-lg-12" name="" id="select_tipo_coti">
                    <option value="">Todos los comprobantes</option>
                    <option value="factura">Factura</option>
                    <option value="boleta">Boleta</option>
                    <option value="nota_venta">Nota de Venta</option>
                </select>
            </div>
        </div>
        <!---->
        <div class="col-sm-4">
            <div class="form-group row">
                <label class="col-lg-3 col-form-label"><strong>Buscar:</strong></label>
                <input type="search" class="form-control col-lg-8">
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered dataTables-example-cotizacion">
            <thead>
                <tr>
                    <th>
                        <input type="checkbox" class="i-checks" name="input[]">
                    </th>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Ruc/DNI</th>
                    <th>Cliente</th>
                    <th>Fecha Emisión</th>
                    <th>Forma</th>
                    <th style="display: none"></th>
                    <th>Importe T.</th>
                    <th>Acciones</th>
                    <th style="display: none">Tipo de Cotizacion</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            {{-- <tfoot>
                <tr>
                    <th>
                        <input type="checkbox" class="i-checks" name="input[]">
                    </th>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Ruc/DNI</th>
                    <th>Cliente</th>
                    <th>Fecha Emisión</th>
                    <th>Forma</th>
                    <th style="display: none"></th>
                    <th>Importe T.</th>
                    <th>Acciones</th>
                    <th style="display: none">Tipo de Cotizacion</th>
                </tr>
            </tfoot> --}}
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        var table = $('.dataTables-example-cotizacion').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('cotizacion_registers') }}",
                data: function(d) {
                    d.daterange = $('input[name="daterange"]').val();
                    d.tipo_coti = $('#select_tipo_coti').val();
                    d.search = $('#global_search').val();
                }
            },
            columns: [{
                    data: null,
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        return `<input type="checkbox" class="i-checks" name="input[]">`;
                    }
                },
                {
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'cod_cotizacion',
                    name: 'cod_cotizacion'
                },
                {
                    data: 'cliente.numero_documento',
                    name: 'cliente.numero_documento'
                },
                {
                    data: 'cliente.nombre',
                    name: 'cliente.nombre'
                },
                {
                    data: 'emision',
                    name: 'emision'
                },
                {
                    data: 'forma_pago.nombre',
                    name: 'forma_pago.nombre'
                },
                {
                    data: 'total_conv',
                    name: 'total_conv',
                    visible: false 
                },
                {
                    data: 'total',
                    name: 'total',
                },
                {
                    data: null,
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {
                        var url = '/cotizacion/' + row.id;
                        if(row.estado_proceso == "Sin Proceso"){
                            return `
                                <a href="${url}">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </a>
                                <button type="button" class="btn btn-warning"><i class="fa fa-clock-o"></i></button>
                            `;
                        }else{
                            return `
                                <a href="${url}">
                                    <button type="button" class="btn btn-primary">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </a>
                                <button type="button" class="btn btn-info"><i class="fa fa-check-circle"></i></button>
                            `;
                        }
                    }
                },
                {
                    data: 'tipo',
                    name: 'tipo',
                    visible: false
                },
            ],
            pageLength: 10,
            order: [
                [1, 'asc']
            ]
        });

        // Cuando cambia el rango de fechas
        $('input[name="daterange"]').on('change', function() {
            table.ajax.reload();
        });

        // Cuando se selecciona un tipo de cotización
        $('#select_tipo_coti').on('change', function() {
            table.ajax.reload();
        });

        // Buscar globalmente
        $('#global_search').on('keyup', function() {
            table.search(this.value).draw();
        });

        function limpiar_select() {
            $('input[name="daterange"]').val('');
            table.ajax.reload();
        }

        function revert_select() {
            $('input[name="daterange"]').val('{{ date('m/01/Y') }} - {{ date('m/t/Y') }}');
            table.ajax.reload();
        }
    });
    $(document).ready(function(){
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });



</script>
