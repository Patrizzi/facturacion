<div class="modal fade bd-example-modal-lg" id="todo_pago" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
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
                            <div class="text-left">
                                <strong>Señor(es):</strong> {{ $factura_m->cliente->nombre }}<br>
                                <strong>{{ $factura_m->cliente->documento_identificacion }}:</strong>
                                {{ $factura_m->cliente->numero_documento }} <br>
                                <strong>Dirección:</strong> {{ $factura_m->cliente->direccion }}<br>
                                <div style="display: flex;column-gap: 15px">
                                    <div>
                                        <strong>Teléfono:</strong>
                                        {{ $factura_m->cliente->telefono }}
                                    </div>
                                    <div>
                                        <strong>Celular:</strong> {{ $factura_m->cliente->celular }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-control">
                            <div class="text-center">
                                <h3>Información de la Factura Manual</h3>
                                <div class="text-left">
                                    <div style="display: flex;column-gap: 15px">
                                        <div>
                                            <strong>Orden de Compra:</strong> {{ $factura_m->orden_compra }}
                                        </div>
                                        <div>
                                            <strong>Guia Remisión:</strong> {{ $factura_m->guia_remision }}
                                        </div>
                                    </div>
                                    <div style="display: flex;column-gap: 15px">
                                        <div>
                                            <strong>Condicion Pago:</strong> {{ $factura_m->forma_pago->nombre }}
                                        </div>
                                        <div>
                                            <strong>Moneda:</strong> {{ $factura_m->moneda->nombre }}
                                        </div>
                                    </div>
                                    <strong>F. Emision:</strong> {{ $factura_m->fecha_emision }} <br>
                                    <strong>F. Vencimiento:</strong> {{ $factura_m->fecha_vencimiento }} <br>
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
                                <th>Item</th>
                                <th>Código de Producto</th>
                                <th>Descripción</th>
                                <th>Cantidad</th>
                                <th>Valor unitario</th>
                                <th>Valor Venta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($factura_m->registros_m as $item => $registros)
                                <tr>
                                    <td>{{ $item + 1 }}</td>
                                    <td>{{ $registros->producto->codigo_producto }}</td>
                                    <td>{{ $registros->producto->nombre }}</td>
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
                        <h3 align="left">
                            <?php use Luecano\NumeroALetras\NumeroALetras;
                            $v = new NumeroALetras();
                            $letra = $v->toInvoice($end, 2);
                            // $letra = $v->convertirEurosEnLetras($end);
                            // $letra_final = ucfirst(strstr($letra, 'soles', true));
                            // $end_final_point = strstr($end2, '.', false);
                            // $end_final = str_replace('.', '', $end_final_point);
                            ?>
                            Son : {{ ucfirst(mb_strtolower($letra, 'UTF-8')) }} {{ $factura_m->moneda->nombre }}
                            {{-- {{$end2}} --}}
                        </h3>
                    </div>
                    <div class="col-lg-4">
                        {{-- <div class="col-sm-4 form-control" > --}}
                        <div class="form-control">
                            <div style="display: flex;column-gap: 15px;justify-content: space-between">
                                <div>
                                    <strong>Op. Gravada:</strong>
                                </div>
                                <div>
                                    {{ $factura_m->moneda->simbolo }}{{ number_format($factura_m->op_gravada, 2) }}
                                </div>
                            </div>
                            <div style="display: flex;column-gap: 15px;justify-content: space-between">
                                <div>
                                    <strong>Op. Inafecta:</strong>
                                </div>
                                <div>
                                    {{ $factura_m->moneda->simbolo }}{{ number_format($factura_m->op_inafecta, 2) }}
                                </div>
                            </div>
                            <div style="display: flex;column-gap: 15px;justify-content: space-between">
                                <div>
                                    <strong>Op. Exonerada:</strong>
                                </div>
                                <div>
                                    {{ $factura_m->moneda->simbolo }}{{ number_format($factura_m->op_exonerada, 2) }}
                                </div>
                            </div>
                            <div style="display: flex;column-gap: 15px;justify-content: space-between">
                                <div>
                                    <strong>I.G.V:</strong>
                                </div>
                                <div>
                                    {{ $factura_m->moneda->simbolo }}{{ number_format($igv_p, 2) }}
                                </div>
                            </div>
                            <div style="display: flex;column-gap: 15px;justify-content: space-between">
                                <div>
                                    <strong>Importe Total:</strong>
                                </div>
                                <div>
                                    {{ $factura_m->moneda->simbolo }}{{ number_format($end, 2) }}
                                </div>
                            </div>
                            {{-- <span style=""> Sub Total:</span>
                                    <span style=";">
                                        {{ $simbologia = $factura_m->moneda->simbolo }}
                                        {{ number_format($sub_total, 2) }}</span>
                                    <br>
                                    <span style=""> Op. Agravada: </span>
                                    <span style="">{{ $simbologia }}
                                        {{ number_format($factura_m->op_gravada, 2) }}</span><br>
                                    <span style=""> Op. Inafecta: </span>
                                    <span style="">{{ $simbologia }}
                                        {{ number_format($factura_m->op_inafecta, 2) }}</span><br>
                                    <span style=""> Op. Exonerada: </span>
                                    <span style="">{{ $simbologia }}
                                        {{ number_format($factura_m->op_exonerada, 2) }} </span><br>
                                    <span style=""> I.G.V.: </span>
                                    <span style="">{{ $factura_m->moneda->simbolo }}
                                        {{ number_format(round($igv_p, 2), 2) }}</span><br>
                                    <span style=""> Importe Total: </span>
                                    <span style="">{{ $factura_m->moneda->simbolo }}
                                        {{ number_format(round($end, 2), 2) }}</span> --}}
                        </div>

                    </div>
                </div>
                <br>
                <div class="row">
                    {{-- @if ($detraccion == 'not')
                                <div class="col-sm-12 form-control" style="height:  100px">
                                    <strong>Observaciones:</strong><br>
                                    {{ $factura_m->observacion }}
                                </div>
                            @else
                                <div class="col-sm-6 ">
                                    <div class="form-control" style="height: 100% !important">
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
                                        {{ $facturacion->observacion }}
                                    </div>
                                </div>
                            @endif --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </div>
    </div>
</div>
