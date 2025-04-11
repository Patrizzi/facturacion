<!DOCTYPE html>
<html>
<head>
    <title>Informe Técnico</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .producto { margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px; }
    </style>
</head>
<body>
    <h2>Informe Técnico</h2>

    @php $contadorProducto = 1; @endphp
    @if (!empty($salida) && count($salida) > 0)
        @foreach ($salida as $detalle_s)
            <div class="producto">
                <p><strong>Producto {{ $contadorProducto }}</strong></p>
                <p><strong>Item:</strong> {{ $detalle_s->id }}</p>
                <p><strong>Serie:</strong> {{ $detalle_s->detalle_guia_ingreso->serie ?? 'Sin dato' }}</p>
                <p><strong>Descripción:</strong> {{ $detalle_s->detalle_guia_ingreso->producto ?? 'Sin dato' }}</p>
                <p><strong>Observación:</strong> {{ $detalle_s->detalle_guia_ingreso->observacion ?? 'Sin dato' }}</p>
                <p><strong>Técnico:</strong> {{ $detalle_s->user ? $detalle_s->user->personal->nombres . ' ' . $detalle_s->user->personal->apellidos : 'Sin asignar' }}</p>
                <p><strong>Diagnóstico:</strong> {{ $detalle_s->diagnostico ?? '' }}</p>
                <p><strong>Estado de reparación:</strong>
                    @if($detalle_s->estado_reparacion === 0)
                        Rechazado
                    @elseif($detalle_s->estado_reparacion === 1)
                        Reparado
                    @else
                        Sin dato
                    @endif
                </p>
            </div>
            @php $contadorProducto++; @endphp
        @endforeach
    @endif

    
</body>
</html>
