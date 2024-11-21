<div class="panel-body">
    <div class="row">
        <div class="col-sm-6">
            <div class="input-group">
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

        <div class="col-sm-6">
            <div class="form-group row">
                <label class="col-lg-4 col-form-label" for=""><strong>Buscar:</strong></label>
                <input type="search" class="form-control col-lg-6">
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover dataTables-example-nota_venta">
            <thead>
                <tr>
                    <th><input type="checkbox" class="i-checks" name="input[]"></th>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Ruc/DNI</th>
                    <th>Cliente</th>
                    <th>Fecha Emisión</th>
                    <th>Forma</th>
                    <th style="display: none"></th>
                    <th>Importe T.</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($nota_venta as $index => $nota_ventas)
                    <tr>
                        <td>
                            <input type="checkbox" class="i-checks" name="input[]">
                        </td>
                        <td>{{ $nota_ventas->id }}</td>
                        <td>{{ $nota_ventas->cod_nota_venta }}</td>
                        <td>{{ $nota_ventas->cliente->numero_documento }}</td>
                        <td>{{ $nota_ventas->cliente->nombre }}</td>
                        {{-- <td>{{$nota_ventas->almacen->nombre}}</td> --}}
                        <td>{{ $nota_ventas->fecha_emision }}</td>
                        <td>
                            @if ($nota_ventas->forma_pago == 1)
                                Contado
                            @else
                                Credito
                            @endif
                        </td>
                        <td style="display:none">{{ $total_conv }}</td>
                        <span hidden>
                            {{ $subtotal = $nota_ventas->op_gravada + $nota_ventas->op_inafecta + $nota_ventas->op_exonerada }}
                        </span>
                        <span hidden>
                            @if ($nota_ventas->moneda_id == 2)
                                {{-- Dolares --}}
                                {{ $total = round($subtotal + ($nota_ventas->op_gravada * $igv->renta) / 100, 2) }}
                                {{ $total_conv = $total * $nota_ventas->cambio }}
                            @else
                                {{ $total = round($subtotal + ($nota_ventas->op_gravada * $igv->renta) / 100, 2) }}
                                {{ $total_conv = round($subtotal + ($nota_ventas->op_gravada * $igv->renta) / 100, 2) }}
                            @endif
                        </span>
                        <td>{{ $nota_ventas->moneda->simbolo }} {{ number_format(round($totales[$index], 2), 2) }}
                        </td>
                        <td>
                            <a href="{{ route('nota_venta.show', $nota_ventas->id) }}"><button type="button"
                                    class="btn btn-success"><i class="fa fa-eye"></i></button></a>
                            @if ($nota_ventas->estado == 0)
                                <button class="btn btn-danger" data-toggle="modal"
                                    data-target="#exampleModal{{ $nota_ventas->id }}"><i class="fa fa-trash"></i>
                                </button>
                            @else
                                <button class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom"
                                    title="" data-original-title="Ya está Anulada"><i class="fa fa-trash"></i>
                                </button>
                            @endif
                            <div class="modal fade" id="exampleModal{{ $nota_ventas->id }}" tabindex="-1"
                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <form action="{{ route('nota_venta.anulacion', $nota_ventas->id) }}"
                                            method="post">
                                            @csrf
                                            <div class="modal-header">
                                                {{-- <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> --}}
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <strong>¿Esta seguro de anula la Nota de Venta N~
                                                    {{ $nota_ventas->cod_nota_venta }}?</strong>
                                                <strong>Observacion:</strong><br>
                                                <textarea name="observacion" id="observacion" cols="30" rows="5" class="form-control">{{ $nota_ventas->observacion }}</textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Confirmar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
        table = $('.dataTables-example-nota_venta').DataTable({
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
