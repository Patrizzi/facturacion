 @foreach ($facturas_m as $index => $f_sp)
     @if ($f_sp->estado_pago == 2)
         <tr>
             <td>{{ $f_sp->id }}</td>
             <td>
                 @if ($cuotas_all->where('facturacion_m_id', $f_sp->id)->where('estado', 0)->count() == 0)
                     <button id="cancelado" class="btn btn-primary" disabled><strong>PAGADO</strong></button>
                 @elseif(
                     $cuotas_all->where('facturacion_m_id', $f_sp->id)->where('estado', 0)->count() <
                         $cuotas_all->where('facturacion_m_id', $f_sp->id)->count())
                     <button id="parcial" class="btn btn-warning" disabled><strong>PARCIAL</strong></button>
                 @else
                     <button id="nulo" class="btn btn-danger" disabled><strong>SIN PAGO</strong></button>
                 @endif
             </td>
             <td>{{ $f_sp->codigo_fac }}</td>
             <td>{{ $f_sp->cliente->nombre }}</td>
             <td>{{ $f_sp->forma_pago->nombre }}</td>
             <td>
                 {{ $f_sp->moneda->simbolo }}
                 @if ($f_sp->forma_pago_id == 2)
                     {{ number_format($cuotas_all->where('facturacion_m_id', $f_sp->id)->where('estado', 2)->sum('monto'), 2) }}
                 @else
                     <span hidden>{{ $subtotal = $f_sp->op_gravada + $f_sp->op_inafecta + $f_sp->op_exonerada }}
                     </span>
                     {{ number_format(round($subtotal + ($f_sp->op_gravada * $igv->renta) / 100, 2), 2) }}
                 @endif
             </td>
             <td>
                 {{-- @if ($f_sp->forma_pago_id == 2)
                                                                @if ($cuotas_all)
                                                                    {{$last_pagos->where('factuacion_m_id', $f_sp->id)->sortByDesc('created_at')->pluck('fecha_registro')->first()}}
                                                                @else
                                                                    <strong>Pendiente</strong>
                                                                @endif
                                                            @else
                                                                {{$f_sp->fecha_vencimiento}}
                                                            @endif --}}
                 {{ $last_pagos->where('factuacion_m_id', $f_sp->id)->sortByDesc('created_at')->pluck('fecha_registro')->first() }}
             </td>
             <td>
                 <a class="btn btn-primary" href="{{ route('pagos.show_facturas_m', $f_sp->codigo_fac) }}">Detalles</a>
             </td>
         </tr>
     @endif
 @endforeach
