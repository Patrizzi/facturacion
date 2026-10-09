<tbody>
    @foreach ($facturas_m as $index => $f_sp)
        @if ($f_sp->estado_pago != 2)
            <tr>
                <td> {{ $f_sp->id }} </td>
                <td>
                    <input type="checkbox" name="" id="check_{{ $f_sp->id }}"
                        class="form-control check_only check_lost_{{ $index }} {{ $f_sp->moneda->nombre }}"
                        onclick="check_lote({{ $index }})">
                </td>
                <td class="tooltip-demo">
                    <span hidden>{{ $f_sp->estado_pago }}</span>
                    <center>
                        @if ($f_sp->estado_pago == 1)
                            <button id="parcial" disabled class="btn btn-warning btn-circle" data-toggle="tooltip"
                                data-placement="bottom" title="" data-original-title="Pagado Parcial"> <i
                                    class="fa fa-exclamation-circle"></i> </button>
                        @endif
                        @if ($f_sp->estado_pago == 0)
                            <button id="nulo" disabled class="btn btn-danger btn-circle" data-toggle="tooltip"
                                data-placement="bottom" title="" data-original-title="Sin Pago"> <i
                                    class="fa fa-times"></i> </button>
                        @endif
                    </center>
                </td>
                <td>{{ $f_sp->codigo_fac }}</td>
                <td>{{ $f_sp->cliente->nombre }}</td>
                <td>{{ Carbon\Carbon::parse($f_sp->fecha_emision)->format('d-m-Y') }}</td>
                <td>{{ $f_sp->forma_pago->nombre }}</td>
                <td>{{ $f_sp->moneda->simbolo }}
                    @if ($f_sp->forma_pago_id == 2)
                        {{-- CREDITO  --}}
                        {{ number_format($cuotas_all->where('facturacion_m_id', $f_sp->id)->sum('monto'), 2) }} |
                        {{ $cuotas_all->where('facturacion_m_id', $f_sp->id)->count() }}
                    @else
                        <span
                            hidden>{{ $subtotal = $f_sp->op_gravada + $f_sp->op_inafecta + $f_sp->op_exonerada }}</span>
                        {{ number_format(round($subtotal + ($f_sp->op_gravada * $igv->renta) / 100, 2), 2) }} | 1
                    @endif
                </td>
                <td>{{ $f_sp->moneda->simbolo }}
                    @if ($f_sp->estado_pago == 1)
                        {{-- ESTADO PAGADO PARCIAL / ADELANTO  --}}
                        {{-- SUMA DE TODOS LOS ADELANTOS + PAGOS --}}
                        <span hidden>{{ $exist = $adelantos->where('factura_m_id', $f_sp->id)->first() }}</span>
                        <div style="display: none">
                            @if (isset($exist))
                                <span hidden>{{ $precio_adelantado = $exist->precio_adelanto }}</span>
                            @else
                                <span hidden>{{ $precio_adelantado = 0 }}</span>
                            @endif
                            {{ $pago_cuota = $cuotas_all->where('facturacion_m_id', $f_sp->id)->where('estado', 2)->sum('monto') }}
                        </div>
                        {{ number_format(round($pago_cuota + $precio_adelantado, 2), 2) }}
                    @else
                        {{-- ESTADO SIN NINGUN TIPO DE PAGO --}}
                        0.00
                    @endif
                </td>
                <td>
                    @if ($f_sp->forma_pago_id == 2)
                        @if ($cuotas_all->where('facturacion_m_id', $f_sp->id)->where('estado', 1)->pluck('fecha_pago')->first() != null)
                            {{ date('d-m-Y', strtotime($cuotas_all->where('facturacion_m_id', $f_sp->id)->where('estado', 1)->pluck('fecha_pago')->first())) }}
                        @else
                            <strong>Pendiente</strong>
                        @endif
                    @else
                        {{ $f_sp->fecha_vencimiento }}
                    @endif
                </td>
                <td>
                    <a class="btn btn-primary"
                        href="{{ route('pagos.show_facturas_m', $f_sp->codigo_fac) }}">Detalles</a>
                </td>
                <td>
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle">Seleccionar</button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" class="btn btn-primary"
                                    onclick="pago_factura( {{ $f_sp->id }})">Pagar</a></li>
                            <li><a class="dropdown-item" class="btn btn-primary" data-toggle="modal"
                                    data-target="#myModal5"
                                    onclick="pago_adelanto_m({{ $f_sp->id }},'full','0')">Adelantar</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endif
    @endforeach
</tbody>
{{-- <tbody>
    {{$facturas_m->links()}}
</tbody> --}}
