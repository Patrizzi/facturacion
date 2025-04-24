<!DOCTYPE html>
<html>
    <link rel="stylesheet" href="css/servicio-tecnico/pdf_informe_tecnico.css">
<head>
    <title>Informe Técnico</title>
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
                <p><strong>Serie:</strong> {{ $detalle_s->detalle_guia_ingreso->serie ?? 'Sin dato' }}</p>
                <p><strong>Descripción:</strong> {{ $detalle_s->detalle_guia_ingreso->producto ?? 'Sin dato' }}</p>
                <p><strong>Observación:</strong> {{ $detalle_s->detalle_guia_ingreso->observacion ?? 'Sin dato' }}</p>
                <p><strong>Técnico:</strong> {{ $detalle_s->user ? $detalle_s->user->personal->nombres . ' ' .
                    $detalle_s->user->personal->apellidos : 'Sin asignar' }}</p>
                <p><strong>Diagnóstico:</strong> {{ $detalle_s->diagnostico ?? '' }}</p>
                <p><strong>Estado de reparación:</strong>
                    @if($detalle_s->estado_reparacion === 0)
                        <span style="color: #e53e3e;">Rechazado</span>
                    @elseif($detalle_s->estado_reparacion === 1)
                        <span style="color: #1538A0;">Reparado</span>
                    @else
                        Sin dato
                    @endif
                </p>
            </div>

            <div class="imagen-container">
                <div class="imagen-descripcion">
                    <p><strong>Descripción de imagen:</strong> {{ $imagenesProducto[$detalle_s->id]->descripcion ?? 'Sin descripción' }}</p>
                </div>
                <div class="imagen-foto">
                    @if(isset($imagenesProducto[$detalle_s->id]) && $imagenesProducto[$detalle_s->id]->foto)
                        <img src="{{ $imagenesProducto[$detalle_s->id]->foto }}" alt="Imagen del producto">
                    @else
                        <p>No hay imagen disponible</p>
                    @endif
                </div>
            </div>

            @php $contadorProducto++; @endphp
        @endforeach
    @else
        <p>No hay datos disponibles para mostrar.</p>
    @endif

    <div class="footer">
        © <?php echo date('Y'); ?> J & P PERIFERICOS - Todos los derechos reservados
    </div>
</body>
</html>
