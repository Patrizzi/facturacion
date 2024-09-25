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
        <table class="table table-striped table-bordered table-hover dataTables-example-cotizacion">
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
                @foreach ($cotizacion as $cotizacions)
                    <tr>
                        <td>
                            <input type="checkbox" class="i-checks" name="input[]">
                        </td>
                        <td>{{ $cotizacions->id }}</td>
                        <td>{{ $cotizacions->cod_cotizacion }}</td>
                        <td>{{ $cotizacions->cliente->numero_documento }}</td>
                        <td>{{ $cotizacions->cliente->nombre }}</td>
                        <td>{{ Carbon\Carbon::parse($cotizacions->created_at)->format('d-m-Y') }}</td>
                        <td>{{ $cotizacions->forma_pago->nombre }}</td>
                        <span hidden>
                            {{ $subtotal = $cotizacions->op_gravada + $cotizacions->op_inafecta + $cotizacions->op_exonerada }}
                        </span>
                        <span hidden>
                            @if ($cotizacions->moneda_id == 2)
                                {{-- Dolares --}}
                                {{ $total = round($subtotal + ($cotizacions->op_gravada * $igv->renta) / 100, 2) }}
                                {{ $total_conv = $total * $cotizacions->cambio }}
                            @else
                                {{ $total = round($subtotal + ($cotizacions->op_gravada * $igv->renta) / 100, 2) }}
                                {{ $total_conv = round($subtotal + ($cotizacions->op_gravada * $igv->renta) / 100, 2) }}
                            @endif

                        </span>
                        <td style="display:none">{{ $total_conv }}</td>
                        <td>{{ $cotizacions->moneda->simbolo }}
                            {{ number_format(round($total, 2), 2) }}
                        </td>
                        <td>
                            <a href="{{ route('cotizacion.show', $cotizacions->id) }}"><button type="button"
                                    class="btn btn-primary"><i class="fa fa-eye"></i></button></a>

                            @if ($cotizacions->estado == '0')
                                <button type="button" class="btn btn-info"><i class="fa fa-check-circle"></i></button>
                            @else
                                <button type="button" class="btn btn-warning"><i class="fa fa-clock-o"></i></button>
                            @endif

                        </td>
                        <td style="display: none">
                            {{ $cotizacions->tipo }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="7" class="text-right">Total General</th>
                    <th colspan="2"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        table = $('.dataTables-example-cotizacion').DataTable({
            pageLength: 10,
            order: [
                [0, "desc"]
            ],
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            footerCallback: function(tr, data, start, end, display) {
                var api = this.api(),
                    data;

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                total = api
                    .column(7)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total filtered rows on the selected column (code part added)
                var sumCol4Filtered = display.map(el => data[el][7]).reduce((a, b) => intVal(a) +
                    intVal(b), 0);

                // Update footer
                $(api.column(7).footer()).html(
                    'S/ ' + Math.round(sumCol4Filtered * 100) / 100
                );
            },
            buttons: []
        });

        revert_select();

        $(document).on('change', '#select_tipo_coti', function(event) {
            var nombre = $("#select_tipo_coti option:selected").val();
            // console.log(nombre);
            table.column(10).search(nombre).draw();
        });
        $('input[name="daterange"]').daterangepicker({
                "locale": {
                    "separator": " | ",
                    "applyLabel": "Guardar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "Desde",
                    "toLabel": "Hasta",
                    "customRangeLabel": "Custom",
                    "daysOfWeek": [
                        "Do",
                        "Lu",
                        "Ma",
                        "Mi",
                        "Ju",
                        "Vi",
                        "Sa"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                    "firstDay": 1
                }
            },
            function(start, end, label) {
                var dates = [];
                var currentDate = new Date(start);
                while (currentDate <= end) {
                    var day = ('0' + currentDate.getDate()).slice(-2);
                    var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                    var year = currentDate.getFullYear();

                    var formattedDate = day + '-' + month + '-' + year;
                    dates.push(formattedDate);

                    currentDate.setDate(currentDate.getDate() + 1);
                }
                var dateRangeString = dates.join('|');
                console.log(dateRangeString);
                table.column(4).search(dateRangeString, true, false).draw();
            }
        );
    });

    function limpiar_select() {
        table.column(4).search("").draw();
    }

    function revert_select() {
        table.column(4).search(`{{ date('m-Y') }}`).draw();
    }
</script>
