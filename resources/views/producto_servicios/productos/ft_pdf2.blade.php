<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .header { border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 15px; }
        .title { font-size: 16px; font-weight: bold; margin: 0; }
        .sub { color: #555; margin: 3px 0 0; }

        .grid { width: 100%; border-collapse: collapse; margin-top: 10px; }
        .grid td { padding: 6px 8px; border: 1px solid #eee; vertical-align: top; }
        .label { width: 28%; font-weight: bold; background: #fafafa; }

        .img-box { width: 120px; height: 120px; border: 1px solid #eee; display: flex; align-items: center; justify-content: center; }
        .img-box img { max-width: 120px; max-height: 120px; }

        .section-title { margin-top: 14px; font-weight: bold; font-size: 13px; }
        .footer { position: fixed; bottom: 0; left: 0; right: 0; font-size: 10px; color: #777; border-top: 1px solid #eee; padding-top: 6px; }
    </style>
</head>
<body>

    <div class="header">
        <p class="title">FICHA TÉCNICA DEL PRODUCTO</p>
        <p class="sub">Generado: {{ $fecha }}</p>
    </div>

    <table style="width:100%;">
        <tr>
            <td style="width:75%;">
                <table class="grid">
                    <tr>
                        <td class="label">Código Producto</td>
                        <td>{{ $producto->codigo_producto }}</td>
                    </tr>
                    <tr>
                        <td class="label">Código Original</td>
                        <td>{{ $producto->codigo_original }}</td>
                    </tr>
                    <tr>
                        <td class="label">Nombre</td>
                        <td>{{ $producto->nombre }}</td>
                    </tr>
                    <tr>
                        <td class="label">Marca</td>
                        <td>{{ $producto->marcas_i_producto->nombre ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Unidad</td>
                        <td>{{ $producto->unidad_i_producto->medida ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Familia</td>
                        <td>{{ $producto->familia_i_producto->descripcion ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Subfamilia</td>
                        <td>{{ $producto->subfamilia_i_producto->descripcion ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Tipo Afectación</td>
                        <td>{{ $producto->tipo_afec_i_producto->informacion ?? 'N/A' }}</td>
                    </tr>
                </table>
            </td>

            <td style="width:25%; text-align:center;">
                <div class="img-box">
                    @if($fotoBase64)
                        <img src="{{ $fotoBase64 }}" alt="Foto">
                    @else
                        <span>Sin imagen</span>
                    @endif
                </div>
            </td>
        </tr>
    </table>

    <div class="section-title">Detalles</div>
    <table class="grid">
        <tr>
            <td class="label">Origen</td>
            <td>{{ $producto->origen ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Garantía</td>
            <td>{{ $producto->garantia ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Peso</td>
            <td>{{ $producto->peso ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Stock</td>
            <td>{{ $stock }}</td>
        </tr>
        <tr>
            <td class="label">Descripción</td>
            <td>{{ $producto->descripcion ?? '' }}</td>
        </tr>
        <tr>
            <td class="label">Detalle</td>
            <td>{{ $producto->detalle ?? '' }}</td>
        </tr>
    </table>

    <div class="footer">
        FT - {{ $producto->codigo_original }} | Página: {PAGE_NUM} / {PAGE_COUNT}
    </div>

</body>
</html>
