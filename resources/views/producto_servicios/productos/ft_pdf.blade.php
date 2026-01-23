<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .header { border-bottom: 1px solid #ddd; padding-bottom: 10px; margin-bottom: 15px; }
        .title { font-size: 16px; font-weight: bold; margin: 0; }
        .sub { color: #555; margin: 3px 0 0; font-size: 12px }
        /* Diseño tipo ficha (como la imagen) */
        .ft {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        .ft td,
        .ft th {
            border: 1px solid black;
            padding: 5px 6px;
            vertical-align: top;
        }

        .ft .title {
            text-align: center;
            font-weight: bold;
            font-size: 13px;
        }

        .ft .section {
            text-align: center;
            font-weight: bold;
            background: white;
        }

        .ft .label {
            font-size: 14px;
            font-weight: bold;
            white-space: nowrap;
            width: 22%;
        }

        .ft .value {
            font-size: 13px;
            width: 28%;
        }

        .ft .img-cell {
            text-align: center;
            vertical-align: middle;
            width: 34%;
        }

        .ft .img-box {
            width: 100%;
            height: 190px;
            border: 1px solid black;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ft .img-box img {
            max-width: 100%;
            max-height: 190px;
        }
    </style>
</head>

<body>
    <div class="header">
        <p class="title">FICHA TÉCNICA DEL PRODUCTO</p>
        <p class="sub">Generado: {{ $fecha }}</p>
    </div>
    <table class="ft">

        <!-- FILA 1: Códigos + Imagen -->
        <tr>
            <td class="label">CÓDIGO PRODUCTO</td>
            <td class="value">{{ $producto->codigo_producto }}</td>

            <td class="label">CÓDIGO ORIGINAL</td>
            <td class="value">{{ $producto->codigo_original }}</td>

            <td class="img-cell" colspan="2" rowspan="6">
                <div class="img-box">
                    @if ($fotoBase64)
                        <img src="{{ $fotoBase64 }}" alt="Foto">
                    @else
                        <span>Sin imagen</span>
                    @endif
                </div>
            </td>
        </tr>

        <!-- FILA 2 -->
        <tr>
            <td class="label">NOMBRE</td>
            <td class="value" colspan="3">{{ $producto->nombre }}</td>
        </tr>

        <!-- FILA 3 -->
        <tr>
            <td class="label">MARCA</td>
            <td class="value">{{ $producto->marcas_i_producto->nombre ?? 'N/A' }}</td>

            <td class="label">UNIDAD</td>
            <td class="value">{{ $producto->unidad_i_producto->medida ?? 'N/A' }}</td>
        </tr>

        <!-- FILA 4 -->
        <tr>
            <td class="label">FAMILIA</td>
            <td class="value">{{ $producto->familia_i_producto->descripcion ?? 'N/A' }}</td>

            <td class="label">SUBFAMILIA</td>
            <td class="value">{{ $producto->subfamilia_i_producto->descripcion ?? 'N/A' }}</td>
        </tr>

        <!-- FILA 5 -->
        <tr>
            <td class="label">TIPO AFECTACIÓN</td>
            <td class="value" colspan="3">{{ $producto->tipo_afec_i_producto->informacion ?? 'N/A' }}</td>
        </tr>

        <!-- FILA 6 -->
        <tr>
            <td class="label">CATEGORÍA</td>
            <td class="value" colspan="3">{{ $producto->categoria_i_producto->descripcion ?? 'N/A' }}</td>
        </tr>

        <!-- SECCIÓN DETALLES -->
        <tr>
            <th colspan="6" class="section">DETALLES</th>
        </tr>

        <tr>
            <td class="label">ORIGEN</td>
            <td class="value">{{ $producto->origen ?? 'N/A' }}</td>

            <td class="label">GARANTÍA</td>
            <td class="value">{{ $producto->garantia ?? 'N/A' }}</td>

            <td class="label">PESO</td>
            <td class="value">{{ $producto->peso ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td class="label">STOCK</td>
            <td class="value">{{ $stock }}</td>

            <td class="label">DETALLE</td>
            <td class="value" colspan="3">{{ $producto->detalle ?? '-' }}</td>
        </tr>

        <tr>
            <td class="label">DESCRIPCIÓN</td>
            <td class="value" colspan="5">{{  $producto->descripcion ?? ''}}</td>
        </tr>
    </table>

    <div class="footer">
    </div>
</body>

</html>
