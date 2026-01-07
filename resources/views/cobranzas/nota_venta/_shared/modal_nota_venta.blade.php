<div class="modal fade bd-example-modal-lg" id="nota_venta_show" tabindex="-1" role="dialog"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-width: 900px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ $nota_venta->codigo_fac }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <?php use Luecano\NumeroALetras\NumeroALetras; ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-control">
                            <div class="text-center">
                                <h3>Datos del Cliente</h3>
                            </div>
                            <div class="text-left" style="font-size: 85% !important">
                                <strong>Señor(es):</strong> <span> {{ $nota_venta->cliente->direccion }}</span><br>
                                <strong><span>{{ $nota_venta->cliente->documento_identificacion }}:</span></strong>
                                {{ $nota_venta->cliente->numero_documento }} <br>
                                <strong>Dirección:</strong><span> {{ $nota_venta->cliente->direccion }}</span><br>
                                <div style="display: flex;column-gap: 15px">
                                    <div>
                                        <strong>Teléfono:</strong>
                                        <span>{{ $nota_venta->cliente->telefono }}</span>
                                    </div>
                                    <div>
                                        <strong>Celular:</strong> <span>{{ $nota_venta->cliente->celular }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-control">
                            <div class="text-center">
                                <h3>Información de la Nota de Venta </h3>
                                <div class="text-left" style="font-size: 85% !important">
                                    <div style="display: flex;column-gap: 15px">
                                        <div>
                                            <strong>Orden de Compra:</strong> <span>{{ $nota_venta->orden_compra }}</span>
                                        </div>
                                        <div>
                                            <strong>Guia Remisión:</strong> <span>{{ $nota_venta->guia_remision }}</span>
                                        </div>
                                    </div>
                                    <div style="display: flex;column-gap: 15px">
                                        <div>
                                            <strong>Condicion Pago:</strong><span> {{ $nota_venta->forma_pago }}</span>
                                        </div>
                                        <div>
                                            <strong>Moneda:</strong> <span>{{ $nota_venta->moneda->nombre }}</span>
                                        </div>
                                    </div>
                                    <strong>F. Emision:</strong> <span>{{ $nota_venta->fecha_emision }} </span><br>
                                    <strong>F. Vencimiento:</strong> <span>{{ $nota_venta->fecha_vencimiento }}</span> <br>
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
                                {{-- <th style="width: 10%">Código</th> --}}
                                <th style="width: 50%">Descripción</th>
                                <th>Cantidad</th>
                                <th>Valor unitario</th>
                                <th>Valor Venta</th>
                            </tr>
                        </thead>
                        <span hidden>{{ $i = 1 }}{{ $sume = 0 }}</span>
                        <tbody>
                            @foreach ($nota_venta->notaventa_registros as $item => $registros)
                                <tr>
                                    <td>{{ $item++ }} </td>
                                    <td>{{ $registros->producto }}<br>{{ $registros->descripcion }}</td>
                                    <td>{{ $registros->cantidad }}</td>
                                    <td>{{ $nota_venta->moneda->simbolo }} {{ round($registros->precio_nacional, 2) }}</td>
                                    <td>{{ $nota_venta->moneda->simbolo }}
                                        {{ round($registros->cantidad * $registros->precio_nacional, 2) }}
                                    </td>
                                    <span
                                        hidden>{{ $sume = round($registros->cantidad * $registros->precio_nacional + $sume, 2) }}</span>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <h3 align="left" class="">
                            <?php
                            $end = round($sume, 2);
                            $v = new NumeroALetras();
                            $letra = $v->toInvoice($end, 2);
                            ?>
                            <span>Son : {{ ucfirst(mb_strtolower($letra,'UTF-8')) }} {{ $nota_venta->moneda->nombre }}</span>
                        </h3>
                    </div>
                     <div class="col-sm-4">
                        <div class="form-control" align="center">
                            <p class=" a"> <strong>Importe Total</strong></p>
                            <span>{{ $nota_venta->moneda->simbolo }}</span>
                            <span class="">{{ number_format($end, 2) }}</span>
                            {{-- <input type="text" name="impor_t" id="impor_t" value="" readonly class="form-control-plaintext" style="width: 60%"> --}}
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    @if ($nota_venta->detraccion_id == null)
                        <div class="col-sm-12 form-control" style="height: 100px;font-size: 95%">
                            <strong>Observaciones:</strong><br>
                            {{ $nota_venta->observacion }}
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
                                {{ $nota_venta->observacion }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="modal-footer" style="justify-content: space-between">
                <div class="text-left">
                    <form class="btn" style="text-align: none;padding: 0 0 0 0"
                        action="{{ route('pdf_fac', $nota_venta->id) }}">
                        <input type="text" name="name" maxlength="50" hidden=""
                            value="{{ $nota_venta->codigo_fac }}">
                        <button type="submit" class="btn btn-success" data-toggle="tooltip" data-placement="bottom"
                            title="" data-original-title="Descargar PDF"><i class="fa fa-file-pdf-o fa-lg"></i>
                        </button>
                    </form>
                    <input type="text" value="{{ $nota_venta->id }}" name="id" id="id" hidden="">
                    <a class="btn btn-success" href="{{ route('facturacion.print', $nota_venta->id) }}" target="_blank"
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
