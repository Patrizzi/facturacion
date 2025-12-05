@foreach ($clientes as $index3 => $clie)
                                                @if ( count($facturas_m->where('cliente_id', $clie->id)) >= 1)
                                                    <div class="display: none">
                                                        <div style="display: none">
                                                            {{ $cal_sol = 0 }} {{ $cal_dol = 0 }} {{ $count_fact_pag = 0 }}
                                                            {{ $prom_tc = 0 }} {{ $cant = 1 }}
                                                        </div>
                                                        @foreach ($facturas_m->where('cliente_id', $clie->id) as $facturas_norma)
                                                            <div style="display: none">
                                                                {{ $std_cuot = $cuotas_all->where('facturacion_m_id', $facturas_norma->id)->where('estado', 1)->count() }}
                                                                {{ $std_cuot2 = $cuotas_all->where('facturacion_m_id', $facturas_norma->id)->count() }}
                                                                {{ $simbolo_mon_sol = 'S/.' }}
                                                                {{ $simbolo_mon_dol = '$' }}
                                                            </div>
                                                            @if ($std_cuot == $std_cuot2)
                                                                <div style="display: none">
                                                                    {{ $prom_tc += $facturas_norma->cambio }}
                                                                    {{ $cant += 1 }}
                                                                </div>
                                                                {{-- {{$facturas_norma->moneda->nombre}} --}}
                                                                @if ($facturas_norma->moneda->nombre == 'soles')
                                                                    {{-- CONVERTIR EN SOLES MONT TOTAL / TIPO CAMBIO EN ESE DIA --}}
                                                                    <div style="display: none">
                                                                        {{ $cal_sol += $cuotas_all->where('facturacion_m_id', $facturas_norma->id)->sum('monto') }}
                                                                        {{ $cal_dol += $cuotas_all->where('facturacion_m_id', $facturas_norma->id)->sum('monto') / $facturas_norma->cambio }}
                                                                    </div>
                                                                @endif
                                                                @if ($facturas_norma->moneda->nombre == 'Dolares')
                                                                    {{-- CONVERTIR EN DOLARES MONT TOTAL * TIPO CAMBIO EN ESE DIA --}}
                                                                    <div style="display: none">
                                                                        {{ $cal_dol += $cuotas_all->where('facturacion_m_id', $facturas_norma->id)->sum('monto') }}
                                                                        {{ $cal_sol += $cuotas_all->where('facturacion_m_id', $facturas_norma->id)->sum('monto') * $facturas_norma->cambio }}
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                    {{-- COLUMNAS PARA MONTO SOLES Y MONTO DOLARES, COLUMNA ADICIONAL CON LOS 2 PRECIO TOTALES POR CLIENTE --}}
                                                    <tr>
                                                        <td>{{ $index++ }}</td>
                                                        <td>{{ $clie->nombre }}</td>
                                                        <td>{{ $clie->numero_documento }}</td>
                                                        {{-- <td></td>
                                                        <td></td> --}}
                                                        <td>
                                                            {{ $clie->cantidad_fact }}
                                                        </td>
                                                        <td>
                                                            {{ $facturas_m->where('cliente_id', $clie->id)->where('estado_pago', 2)->count() }}
                                                        </td>
                                                        <td>
                                                            {{ $simbolo_mon_sol }} {{ $var_precio_tot[$index3]['tot'] }}
                                                        </td>
                                                        {{-- <td>
                                                            {{ number_format($prom_tc / $cant, 2) }}
                                                        </td> --}}
                                                        <td>
                                                            {{ $simbolo_mon_dol }} {{ $var_precio_tot[$index3]['tot_dol'] }}
                                                        </td>
                                                        <td>
                                                            {{-- <button class="btn btn-secondary">Ver detalles</button> --}}
                                                            <a href="{{ route('pagos.show_cliente_factura_m', $clie->numero_documento) }}"
                                                                class="btn btn-secondary">Ver Detalles</a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach