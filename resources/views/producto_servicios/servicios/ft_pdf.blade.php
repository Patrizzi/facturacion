{{-- resources/views/producto_servicios/servicios/ft_pdf.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha Técnica - {{ $servicio->codigo_servicio ?? 'Servicio' }}</title>

    <style>
        * {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        body {
            margin: 20px;
            color: #111;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: top;
        }

        .label {
            width: 28%;
            font-weight: bold;
            background: #f5f5f5;
        }

        .value {
            width: 42%;
        }

        .img-cell {
            width: 30%;
            text-align: center;
            vertical-align: middle;
        }

        .img-box {
            width: 100%;
            height: 220px;
            border: 1px dashed #ccc;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .img-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }

        .muted {
            color: #666;
            font-style: italic;
        }

    </style>
</head>

<body>
    <div class="title">
        Ficha Técnica - {{ $servicio->nombre ?? 'Servicio' }}
    </div>

    <table>
        <tr>
            <td class="label">Nombre del Servicio</td>
            <td class="value">{{ $servicio->nombre ?? '-' }}</td>

            <td class="img-cell" rowspan="8">
                <div class="img-box">
                    @if(!empty($fotoBase64))
                    <img src="{{ $fotoBase64 }}" alt="Imagen del Servicio">
                    @else
                    <span class="muted">Sin imagen</span>
                    @endif
                </div>
            </td>
        </tr>

        <tr>
            <td class="label">Código Servicio</td>
            <td class="value">{{ $servicio->codigo_servicio ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">Código Original</td>
            <td class="value">{{ $servicio->codigo_original ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">Familia</td>
            <td class="value">{{ optional($servicio->familia)->descripcion ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">Subfamilia</td>
            <td class="value">{{ optional($servicio->subfamilia)->descripcion ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">Marca</td>
            <td class="value">{{ optional($servicio->marca)->descripcion ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">Descripción</td>
            <td class="value">{{ $servicio->descripcion ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">Estado</td>
            <td class="value">
                {{ (string)($servicio->estado_anular ?? '0') === '0' ? 'Activo' : 'Anulado' }}
            </td>
        </tr>

        <tr>
            <td class="label">Precio (Nacional)</td>
            <td class="value">{{ $servicio->precio_nacional ?? '-' }}</td>
            <td class="label" style="display:none;"></td>
        </tr>

        <tr>
            <td class="label">Precio (Extranjero)</td>
            <td class="value">{{ $servicio->precio_extranjero ?? '-' }}</td>
            <td class="label" style="display:none;"></td>
        </tr>

        <tr>
            <td class="label">Moneda</td>
            <td class="value">{{ optional($servicio->moneda)->descripcion ?? '-' }}</td>
            <td class="label" style="display:none;"></td>
        </tr>

        <tr>
            <td class="label">Tipo Afectación</td>
            <td class="value">{{ optional($servicio->tipo_afectacion)->descripcion ?? '-' }}</td>
            <td class="label" style="display:none;"></td>
        </tr>

        <tr>
            <td class="label">Fecha de creación</td>
            <td class="value">{{ $servicio->fecha_creacion ?? '-' }}</td>
            <td class="label" style="display:none;"></td>
        </tr>
    </table>
</body>
</html>
