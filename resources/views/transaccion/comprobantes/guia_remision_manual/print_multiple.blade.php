<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Impresión múltiple - Guías de Remisión Manual</title>
    <style>
        @page { size: A4; margin: 14mm 10mm; }
        body { font-family: Arial, Helvetica, sans-serif; font-size: 12px; }
        .page { page-break-after: always; }
        .page:last-child { page-break-after: auto; }
        .header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:10px; }
        .h1 { font-size:16px; margin:0; }
        .box { border:1px solid #333; padding:8px; margin-bottom:8px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #333; padding:4px 6px; vertical-align: top; }
        th { background:#f5f5f5; }
        .small { font-size:11px; }
    </style>
    <script>window.onload = function(){ window.print(); };</script>
</head>
<body>
@foreach($guiasData as $pack)
    @php($g = $pack['guia'])
    @php($items = $pack['registros'])

    <div class="page">
        <div class="header">
            <div>
                <div class="h1">{{ $empresa->nombre ?? 'Empresa' }}</div>
                <div class="small">{{ $empresa->direccion ?? '' }}</div>
                <div class="small">RUC: {{ $empresa->ruc ?? '' }}</div>
            </div>
            <div class="box">
                <strong>GUÍA DE REMISIÓN (Manual)</strong><br>
                <strong>{{ $g->cod_guia }}</strong>
            </div>
        </div>

        <div class="box">
            <strong>Cliente:</strong> {{ optional($g->cliente)->nombre }}<br>
            <strong>Documento:</strong> {{ optional($g->cliente)->numero_documento }}<br>
            <strong>Sucursal cliente:</strong> {{ $g->sucursal_cliente }}<br>
            <strong>Código postal:</strong> {{ $g->cod_postal_cliente }}
        </div>

        <div class="box">
            <strong>Fecha emisión:</strong> {{ $g->fecha_emision }} &nbsp;&nbsp;
            <strong>Fecha entrega:</strong> {{ $g->fecha_entrega }}<br>
            <strong>Transporte:</strong>
            @switch($g->tipo_transporte)
                @case(1) Público ({{ $g->vehiculo_publico }}) @break
                @case(2) Privado — Vehículo: {{ optional($g->vehiculo)->placa }} — Conductor: {{ trim((optional($g->personal)->nombres ?? '').' '.(optional($g->personal)->apellidos ?? '')) }} @break
                @default Sin transporte
            @endswitch
            <br>
            <strong>Motivo de traslado:</strong> {{ $g->motivo_traslado }}<br>
            <strong>Observación:</strong> {{ $g->observacion }}
        </div>

        <table>
            <thead>
            <tr>
                <th style="width:60px;">Cant.</th>
                <th>Descripción</th>
                <th style="width:120px;">Serie/N°</th>
                <th style="width:80px;">Peso</th>
            </tr>
            </thead>
            <tbody>
            @forelse($items as $it)
                <tr>
                    <td>{{ $it->cantidad }}</td>
                    <td>
                        {{ optional($it->producto)->nombre }}<br>
                        <span class="small">
                            {{ optional($it->producto)->codigo_producto }}
                            {{ optional($it->producto)->codigo_original ? ' / '.optional($it->producto)->codigo_original : '' }}
                        </span>
                    </td>
                    <td>{{ $it->numero_serie }}</td>
                    <td>{{ $it->peso }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="small">Sin ítems.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endforeach
</body>
</html>
