<div class="modal fade bd-example-modal-lg" id="factura_show" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $factura->codigo_fac }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-control">
                            <div class="text-center">
                                <h3>Datos del Cliente</h3>
                            </div>
                            <div class="text-left" style="font-size: 85% !important">
                                <strong>Señor(es):</strong> <span> {{ $factura->cliente->direccion }}</span><br>
                                <strong><span>{{ $factura->cliente->documento_identificacion }}:</span></strong>
                                {{ $factura->cliente->numero_documento }} <br>
                                <strong>Dirección:</strong><span> {{ $factura->cliente->direccion }}</span><br>
                                <div style="display: flex;column-gap: 15px">
                                    <div>
                                        <strong>Teléfono:</strong>
                                        <span>{{ $factura->cliente->telefono }}</span>
                                    </div>
                                    <div>
                                        <strong>Celular:</strong> <span>{{ $factura->cliente->celular }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-control">
                            <div class="text-center">
                                <h3>Información de la Factura </h3>
                                <div class="text-left" style="font-size: 85% !important">
                                    <div style="display: flex;column-gap: 15px">
                                        <div>
                                            <strong>Orden de Compra:</strong> <span>{{ $factura->orden_compra }}</span>
                                        </div>
                                        <div>
                                            <strong>Guia Remisión:</strong> <span>{{ $factura->guia_remision }}</span>
                                        </div>
                                    </div>
                                    <div style="display: flex;column-gap: 15px">
                                        <div>
                                            <strong>Condicion Pago:</strong><span> {{ $factura->forma_pago->nombre }}</span>
                                        </div>
                                        <div>
                                            <strong>Moneda:</strong> <span>{{ $factura->moneda->nombre }}</span>
                                        </div>
                                    </div>
                                    <strong>F. Emision:</strong> <span>{{ $factura->fecha_emision }} </span><br>
                                    <strong>F. Vencimiento:</strong> <span>{{ $factura->fecha_vencimiento }}</span> <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th style="width: 5%">Item</th>
                                <th style="width: 10%">Código</th>
                                <th style="width: 50%">Descripción</th>
                                <th>Cantidad</th>
                                <th>Valor unitario</th>
                                <th>Valor Venta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($factura->registros as $item => $registros)
                                <tr>
                                    <td>{{ $item + 1 }}</td>
                                    @if (isset($registros->producto))
                                        <td>{{ $registros->producto->codigo_producto }}</td>
                                        <td>{{ $registros->producto->nombre }}
                                            {{ $registros->descripcion_item }} @if (isset($registros->numero_serie))
                                                <br><strong>N/S:</strong> {{ $registros->numero_serie }}
                                            @endif
                                        </td>
                                    @else
                                        <td>{{ $registros->servicio->codigo_servicio }}</td>
                                        <td>{{ $registros->servicio->nombre }}
                                            {{ $registros->descripcion_item }} @if (isset($registros->numero_serie))
                                                <br><strong>N/S:</strong> {{ $registros->numero_serie }}
                                            @endif
                                        </td>
                                    @endif
                                    <td>{{ $registros->cantidad }}</td>
                                    <td>{{ number_format($registros->precio, 2) }}</td>
                                    <td>{{ number_format(round($registros->cantidad * $registros->precio, 2), 2) }}
                                    </td>
                                    <td style="display: none">
                                        {{ $sub_total = $registros->factura_ids->op_gravada + $registros->factura_ids->op_inafecta + $registros->factura_ids->op_exonerada }}
                                        {{ $sub_total_gravado = $registros->factura_ids->op_gravada }}
                                        {{ $igv_p = (round($sub_total_gravado, 2) * $igv->igv_total) / 100 }}
                                        {{ $end = round($sub_total, 2) + round($igv_p, 2) }}
                                        {{ $end2 = number_format(round($sub_total, 2) + round($igv_p, 2), 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <h3 align="left" style="font-size: 90%">
                            <?php use Luecano\NumeroALetras\NumeroALetras;
                            $v = new NumeroALetras();
                            $letra = $v->toInvoice($end, 2);
                            ?>
                            Son : {{ ucfirst(mb_strtolower($letra, 'UTF-8')) }} {{ $factura->moneda->nombre }}
                        </h3>
                    </div>
                    <div class="col-lg-4">
                        {{-- <div class="col-sm-4 form-control" > --}}
                        <div class="form-control" style="font-size: 95%">
                            <div style="display: flex;column-gap: 15px;justify-content: space-between;">
                                <div>
                                    <strong>Op. Gravada:</strong>
                                </div>
                                <div>
                                    {{ $factura->moneda->simbolo }}{{ number_format($factura->op_gravada, 2) }}
                                </div>
                            </div>
                            <div style="display: flex;column-gap: 15px;justify-content: space-between">
                                <div>
                                    <strong>Op. Inafecta:</strong>
                                </div>
                                <div>
                                    {{ $factura->moneda->simbolo }}{{ number_format($factura->op_inafecta, 2) }}
                                </div>
                            </div>
                            <div style="display: flex;column-gap: 15px;justify-content: space-between">
                                <div>
                                    <strong>Op. Exonerada:</strong>
                                </div>
                                <div>
                                    {{ $factura->moneda->simbolo }}{{ number_format($factura->op_exonerada, 2) }}
                                </div>
                            </div>
                            <div style="display: flex;column-gap: 15px;justify-content: space-between">
                                <div>
                                    <strong>I.G.V:</strong>
                                </div>
                                <div>
                                    {{ $factura->moneda->simbolo }}{{ number_format($igv_p, 2) }}
                                </div>
                            </div>
                            <div style="display: flex;column-gap: 15px;justify-content: space-between">
                                <div>
                                    <strong>Importe Total:</strong>
                                </div>
                                <div>
                                    {{ $factura->moneda->simbolo }}{{ number_format($end, 2) }}
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <br>
                <div class="row">
                    @if ($factura->detraccion_id == null)
                        <div class="col-sm-12 form-control" style="height: 100px;font-size: 95%">
                            <strong>Observaciones:</strong><br>
                            {{ $factura->observacion }}
                        </div>
                    @else
                        <div class="col-sm-6">
                            <div class="form-control" style="height: 100% !important;font-size: 85%">
                                <strong>Informacion de Detraccion:</strong><br>
                                <strong>Tipo de Detraccion:</strong>
                                {{ $detraccion->tipo_detraccion->descripcion }} -
                                {{ $detraccion->porcentaje_detraccion }} %<br>
                                <strong>Medio de Pago:</strong>
                                {{ $detraccion->medio_pago->descripcion }} <br>
                                <strong>Monto de Detraccion:</strong>
                                S/. {{ number_format($detraccion->monto_detraccion, 2) }} <br>
                            </div>
                        </div>
                        <div class="col-sm-6 ">
                            <div class="form-control" style="height: 100% !important">
                                <strong>Observaciones:</strong><br>
                                {{ $factura->observacion }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer" style="justify-content: space-between">
                <div class="text-left">
                    <form class="btn" style="text-align: none;padding: 0 0 0 0"
                        action="{{ route('pdf_fac', $factura->id) }}">
                        <input type="text" name="name" maxlength="50" hidden=""
                            value="{{ $factura->codigo_fac }}">
                        <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom"
                            title="" data-original-title="Descargar PDF"><i class="fa fa-file-pdf-o fa-lg"></i>
                        </button>
                    </form>
                    <input type="text" value="{{ $factura->id }}" name="id" id="id" hidden="">
                    <a class="btn btn-success" href="{{ route('facturacion.print', $factura->id) }}" target="_blank"
                        class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title=""
                        data-original-title="Imprimir"><i class="fa fa-print fa-lg"></i></a>
                </div>
                <div class="text-right">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
