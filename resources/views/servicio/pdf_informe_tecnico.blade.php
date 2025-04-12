<!DOCTYPE html>
<html>
<head>
    <title>Informe Técnico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 20px;
        }
        h2 {
            color: #2c5282;
            border-bottom: 1px solid #718096;
            padding-bottom: 10px;
            text-align: center;
        }
        .producto {
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
            page-break-inside: avoid;
        }
        .producto p {
            margin: 5px 0;
        }
        .producto strong {
            color: #4a5568;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header img {
            max-width: 150px;
            height: auto;
        }
        .fecha {
            text-align: right;
            margin-bottom: 20px;
            font-style: italic;
        }
        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 30px;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <!-- Si tienes un logo, puedes incluirlo así -->
        <!-- <img src="ruta/a/tu/logo.png" alt="Logo"> -->
        <h2>Informe Técnico</h2>
    </div>

    <div class="fecha">
        Fecha: <?php echo date('d/m/Y'); ?>
    </div>

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
                        <span style="color: #e53e3e;">Rechazado</span>
                    @elseif($detalle_s->estado_reparacion === 1)
                        <span style="color: #38a169;">Reparado</span>
                    @else
                        Sin dato
                    @endif
                </p>
            </div>
            @php $contadorProducto++; @endphp
        @endforeach
    @else
        <p>No hay datos disponibles para mostrar.</p>
    @endif

    <div class="footer">
        © <?php echo date('Y'); ?> Tu Empresa - Todos los derechos reservados
    </div>
</body>
</html>
