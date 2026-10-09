<li class="dropdown"
    @if ($hasSunatPendingDocuments) data-toggle="popover" data-placement="left" data-content="Tiene documentos pendientes de enviar a SUNAT" @endif
    id="btn_popover">
    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
        <i class="fa fa-bell" style="font-size: 18px; {{ $hasSunatPendingDocuments ? 'color: red' : '' }}"></i>
    </a>
    <ul class="dropdown-menu dropdown-alerts">
        @if ($hasInvoices)
            <li>
                <a href="{{ route('facturacion_electronica.index') }}" class="dropdown-item">
                    <div>
                        Tiene <strong>{{ $invoices[\App\Facturacion::class] }} Facturas</strong> y
                        <strong>{{ $invoices[\App\Facturacion_m::class] }} Facturas Manuales</strong> pendientes de
                        enviar a SUNAT
                    </div>
                </a>
            </li>
        @endif
        <!-- Añadir bloques similares para otros documentos pendientes -->
        {{-- @foreach ($invoices as $model => $count)
            @if ($count > 0 && !in_array($model, [\App\Facturacion::class, \App\Facturacion_m::class]))
                <li>
                    <a href="#" class="dropdown-item">
                        <div>
                            Tiene <strong>{{ $count }}</strong> documentos pendientes de enviar a SUNAT ({{ class_basename($model) }})
                        </div>
                    </a>
                </li>
            @endif
        @endforeach --}}
    </ul>
</li>
