<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  {{--  <title>Imprimir Guías de Remisión</title>--}}
  <style>
    @page { size: A4; margin: 8mm 8mm; }
    html, body { font-family: Arial, Helvetica, sans-serif; color:#000; }
    body { font-size: 9px; line-height: 1.25; -webkit-print-color-adjust: exact; print-color-adjust: exact; }

    /* Botonera (oculta al imprimir) */
    .no-print { position: sticky; top: 0; z-index: 10; background: #fff; padding: 8px; border-bottom: 1px solid #ddd; }
    .btn { display:inline-block; padding:8px 12px; border:1px solid #111; border-radius:6px; text-decoration:none; color:#111; background:#f6f6f6; cursor:pointer; }
    .btn + .btn { margin-left:8px; }

    /* Página tipo hoja con pie pegado abajo */
    .sheet:last-child { page-break-after: auto; }

    .row { display:flex; gap:8px; }
    .col { flex:1 1 0; }

    .logo { max-height: 34px; }
    .ruc-box { border:1px solid #111; border-radius:6px; padding:8px 10px; text-align:center; min-width:210px; }
    .ruc-box .title, .ruc-box .serie { font-weight:700; font-size:12px; }
    .muted { color:#444; }

    .box { border:1px solid #111; border-radius:6px; padding:6px; }
    .box-title { font-weight:700; margin-bottom:4px; }
    .grid-2 { display:grid; grid-template-columns: 1fr 1fr; gap:8px; }
    .grid-gap { display:grid; gap:8px; }

    table { width:100%; border-collapse: collapse; table-layout: fixed; }
    th, td { border:1px solid #111; padding:4px 5px; vertical-align: top; }
    th { background:#f2f2f2; font-weight:700; }
    .tac { text-align:center; }
    .tar { text-align:right; }
    .desc-small { font-size: 8px; color:#333; margin-top:2px; }

    .footer { display:flex; align-items:flex-start; gap:10px; margin-top:10px; }
    .qr { width:90px; height:90px; border:1px solid #111; display:flex; align-items:center; justify-content:center; }

    /* Recuadro de firma vacío + texto afuera */
    .sign { width:130px; height:60px; border:1px solid #111; border-radius:8px; display:block; padding:0; }
    .sign-wrap { display:inline-flex; flex-direction:column; align-items:center; gap:6px; }
    .sign-caption { font-weight:700; line-height:1; text-align:center; font-size:10px; text-transform:uppercase; }

    @media print {
      body { font-size: 8.6px; }
      .no-print { display: none !important; }
    }
  </style>
      <style>
    @media print {
        body {
            margin: 0 !important;
            padding: 0 !important;
        }
        .avoid-break {
            page-break-inside: avoid;
        }
    }
    </style>
  <script>
    // Imprime automáticamente al abrir y cierra la ventana al terminar (si fue popup)
    window.addEventListener('load', function () {
      setTimeout(function () { window.focus(); window.print(); }, 150);
    });
    window.addEventListener('afterprint', function () {
      if (window.opener) { try { window.close(); } catch(e) {} }
    });
  </script>
</head>
<body>

@php
  $empresaRuc = optional($empresa)->ruc ?? '';
  $empresaNom = optional($empresa)->nombre ?? 'EMPRESA';
  $empresaDir = optional($empresa)->direccion ?? '';
  $consultaUrl = optional($empresa)->consulta_url ?? '—';
@endphp

@foreach($guiasData as $pack)
  @php
    /** @var \App\Guia_remision $g */
    $g = $pack['guia'];
    $items = $pack['registros'];

    // Peso total referencial = suma(peso * cantidad)
    $pesoTotal = $items->sum(fn($r) => (float)($r->peso ?? 0) * (float)($r->cantidad ?? 0));

    // Texto modalidad
    $transporteTxt = [0=>'Sin transporte',1=>'Transporte Público',2=>'Transporte Privado'][$g->tipo_transporte] ?? '—';

    // Conductor por DNI almacenado en conductor_id (si aplica)
    $conductor = null;
    if(!empty($g->conductor_id)){
      try { $conductor = \App\Personal::where('numero_documento', $g->conductor_id)->first(); } catch (\Throwable $th) { $conductor = null; }
    }
    $nombreConductor = trim(((string)optional($conductor)->nombres).' '.((string)optional($conductor)->apellidos));
  @endphp

  <div class="sheet">
    {{-- Encabezado --}}
    <div class="row" style="align-items:flex-start; margin-bottom:8px;">
      <div class="col">
        <div class="row" style="align-items:center; gap:10px;">
          @if(!empty(optional($empresa)->logo))
            <img class="logo" src="{{ asset($empresa->logo) }}" alt="logo">
          @else
            <div style="font-size:14px; font-weight:700;">{{ $empresaNom }}</div>
          @endif
        </div>
        <div class="muted" style="margin-top:4px;">{{ $empresaDir }}</div>
        <div class="muted">R.U.C.: {{ $empresaRuc }}</div>
      </div>

      <div class="ruc-box">
        <div style="font-weight:700;">R.U.C. N° {{ $empresaRuc }}</div>
        <div class="title">GUÍA DE REMISIÓN</div>
        <div class="serie">N°: {{ $g->cod_guia }}</div>
      </div>
    </div>

    {{-- Partida / Llegada --}}
    <div class="grid-2">
      <div class="box">
        <div class="box-title">PUNTO DE PARTIDA</div>
        <div><b>Dirección:</b> {{ optional($g->almacen)->direccion ?? $empresaDir }}</div>
        <div><b>Ubigeo:</b>    {{ optional($g->almacen)->cod_postal }}</div>
        <div><b>Código:</b>    {{ optional($g->almacen)->cod_postal }}</div>
      </div>
      <div class="box">
        <div class="box-title">PUNTO DE LLEGADA</div>
        <div><b>Dirección:</b> {{ $g->sucursal_cliente ?: optional($g->cliente)->direccion }}</div>
        <div><b>Ubigeo:</b>    {{ $g->cod_postal_cliente ?: optional($g->cliente)->cod_postal }}</div>
        <div><b>Código:</b>    {{ $g->cod_postal_cliente ?: optional($g->cliente)->cod_postal }}</div>
      </div>
    </div>

    {{-- Destinatario + Transporte / Envío --}}
    <div class="grid-gap" style="margin-top:8px;">
      <div class="box">
        <div class="box-title">DESTINATARIO</div>
        <div><b>Razón Social:</b> {{ optional($g->cliente)->nombre }}</div>
        <div><b>N° Identificación:</b> {{ optional($g->cliente)->numero_documento }}</div>
        <div><b>Dirección:</b> {{ $g->sucursal_cliente ?: optional($g->cliente)->direccion }}</div>
      </div>

      <div class="grid-2">
        <div class="box">
          <div class="box-title">DATOS DEL TRANSPORTISTA</div>
          @if((int)$g->tipo_transporte === 1)
            {{-- Público --}}
            <div><b>Razón Social:</b> {{ $g->vehiculo_publico ?? '-' }}</div>
            <div><b>N° Identidad / RUC:</b> -</div>
            <div><b>Placa vehículo principal:</b> -</div>
            <div><b>Conductor:</b> -</div>
            <div><b>N° Licencia:</b> -</div>
          @elseif((int)$g->tipo_transporte === 2)
            {{-- Privado --}}
            <div><b>Razón Social:</b> -</div>
            <div><b>N° Identidad / RUC:</b> -</div>
            <div><b>Placa vehículo principal:</b> {{ optional($g->vehiculo)->placa ?? '-' }}</div>
            <div><b>Conductor:</b> {{ $nombreConductor !== '' ? $nombreConductor : '-' }}</div>
            <div><b>N° Licencia:</b> {{ optional($conductor)->licencia ?? '-' }}</div>
          @else
            {{-- Sin transporte --}}
            <div><b>Razón Social:</b> -</div>
            <div><b>N° Identidad / RUC:</b> -</div>
            <div><b>Placa vehículo principal:</b> -</div>
            <div><b>Conductor:</b> -</div>
            <div><b>N° Licencia:</b> -</div>
          @endif
        </div>

        <div class="box">
          <div class="box-title">DATOS DE ENVÍO</div>
          <div><b>Motivo de traslado:</b> {{ $g->motivo_traslado }}</div>
          <div><b>Peso bruto total carga:</b> {{ number_format((float)$pesoTotal,2) }} kg</div>
          <div><b>N° Bultos o Pallets:</b> {{ $g->nro_bultos ?? '-' }}</div>
          <div><b>Modalidad:</b> {{ $transporteTxt }}</div>
          <div><b>Emisión:</b> {{ $g->fecha_emision }}</div>
          <div><b>Inicio traslado:</b> {{ $g->fecha_entrega }}</div>
        </div>
      </div>
    </div>

    {{-- Tabla de ítems --}}
    <div class="box" style="margin-top:8px;">
      <div class="box-title">BIENES A TRASLADAR</div>
      <table>
        <thead>
          <tr>
            <th style="width:28px" class="tac">N°</th>
            <th style="width:110px" class="tac">CÓDIGO</th>
            <th style="width:80px"  class="tac">CÓDIGO SUNAT</th>
            <th>DESCRIPCIÓN</th>
            <th style="width:60px"  class="tac">UNIDAD</th>
            <th style="width:60px"  class="tac">CANTIDAD</th>
          </tr>
        </thead>
        <tbody>
          @php($i=1)
          @forelse($items as $it)
            @php($prod = optional($it->producto))
            <tr>
              <td class="tac">{{ $i++ }}</td>
              <td class="tac">{{ $prod->codigo_producto ?? '-' }}</td>
              <td class="tac">{{ $prod->codigo_sunat ?? '-' }}</td>
              <td>
                {{ $prod->nombre ?? $it->descripcion }}
                @if(!empty($it->numero_serie) || !empty($it->descripcion))
                  <div class="desc-small">
                    {{ $it->numero_serie }}
                    @if(!empty($it->descripcion)) — {{ $it->descripcion }} @endif
                  </div>
                @endif
              </td>
              <td class="tac">{{ optional($prod->unidad_i_producto)->medida ?? 'NIU' }}</td>
              <td class="tac">{{ $it->cantidad }}</td>
            </tr>
          @empty
            <tr><td colspan="6" class="tac">Sin ítems.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pie fijo al fondo --}}
    <div class="footer-wrap">
      <div class="footer">
        <div class="col">
          <div class="desc-small">
            REPRESENTACIÓN IMPRESA DE GUÍA DE REMISIÓN. ESTA PUEDE SER CONSULTADA EN: {{ $consultaUrl }}.
            LA MERCADERÍA VIAJA POR RIESGO Y CUENTA DEL CLIENTE.
          </div>
          @if(!empty($g->observacion))
            <div class="desc-small" style="margin-top:6px;"><b>Observación:</b> {{ $g->observacion }}</div>
          @endif
        </div>
        <div class="qr">QR</div>
        <div class="sign-wrap">
          <div class="sign"></div>
          <div class="sign-caption">RECIBÍ<br>CONFORME</div>
        </div>
      </div>

      <div class="tar desc-small" style="margin-top:4px;">
        Página {{ $loop->iteration }} de {{ $loop->count }}
      </div>
    </div>
  </div>
@endforeach
</body>
</html>
