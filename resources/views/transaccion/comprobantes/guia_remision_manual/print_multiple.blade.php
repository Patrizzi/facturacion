<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Impresión de GR Manual (ultra-compacta)</title>
  <style>
    /* Página y tipografía: mínimo razonable */
    @page { size: A4; margin: 4mm 4mm; }
    html, body { font-family: Arial, Helvetica, sans-serif; font-size: 7px !important; line-height: 1.05 !important; }
    * { box-sizing: border-box; -webkit-print-color-adjust: exact; print-color-adjust: exact; color:#000; }

    /* Estructura */
    .page { page-break-after: always; }
    .page:last-child { page-break-after: auto; }

    .header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:3px; }
    .h1 { font-size:7.5px !important; font-weight:700; margin:0 0 1px 0; }
    .small { font-size:6px !important; }

    .box { border:0.4px solid #333; padding:2px !important; margin-bottom:3px !important; border-radius:1px; }

    /* Tabla ultracompacta */
    table { width:100%; border-collapse:collapse !important; table-layout:fixed; }
    th, td {
      border:0.4px solid #333;
      padding:1px 2px !important;
      vertical-align:top;
      word-break:break-word;
      hyphens:auto;
      font-size:7px !important;
    }
    th { background:#f5f5f5; }
    tr { page-break-inside: avoid; }

    /* Anchos mínimos de columnas */
    th.col-cant { width:34px; text-align:center; }
    th.col-serie{ width:68px; text-align:center; }
    th.col-peso { width:44px; text-align:center; }
    td.tac { text-align:center; }

    /* “Shrink to fit” en impresión */
    @media print {
      /* Chrome / Edge */
      body { zoom: 0.72; }                 /* si aún se desborda, baja a 0.68 */

      /* Firefox (zoom no funciona): escalar contenedor */
      body:not(:-webkit-any(*)) #print-area {
        transform: scale(0.78);            /* ajusta 0.72–0.85 según necesites */
        transform-origin: top left;
        width: 128%;                        /* compensa el scale para aprovechar el ancho */
      }
    }
  </style>
  <script>
    window.addEventListener('load', function(){ window.print(); });
  </script>
</head>
<body>
<div id="print-area">
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
      <div class="box" style="text-align:center;">
        <div style="font-weight:700; font-size:7.2px;">GUÍA DE REMISIÓN (Manual)</div>
        <div style="font-weight:700; font-size:7.2px;">{{ $g->cod_guia }}</div>
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
        <th class="col-cant">Cant.</th>
        <th>Descripción</th>
        <th class="col-serie">Serie/N°</th>
        <th class="col-peso">Peso</th>
      </tr>
      </thead>
      <tbody>
      @forelse($items as $it)
        <tr>
          <td class="tac">{{ $it->cantidad }}</td>
          <td>
            {{ optional($it->producto)->nombre }}
            <div class="small">
              {{ optional($it->producto)->codigo_producto }}
              {{ optional($it->producto)->codigo_original ? ' / '.optional($it->producto)->codigo_original : '' }}
            </div>
          </td>
          <td class="tac">{{ $it->numero_serie }}</td>
          <td class="tac">{{ $it->peso }}</td>
        </tr>
      @empty
        <tr><td colspan="4" class="small">Sin ítems.</td></tr>
      @endforelse
      </tbody>
    </table>
  </div>
@endforeach
</div>
</body>
</html>
