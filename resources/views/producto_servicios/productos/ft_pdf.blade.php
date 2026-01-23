<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <style>
        /* Diseño tipo ficha (como la imagen) */
        .ft {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }

        .ft td,
        .ft th {
            border: 1px solid #000;
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
            background: #f2f2f2;
        }

        .ft .label {
            font-weight: bold;
            white-space: nowrap;
            width: 22%;
        }

        .ft .value {
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
            border: 1px solid #000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ft .img-box img {
            max-width: 100%;
            max-height: 190px;
        }

    </style>

    <table class="ft">
        <tr>
            <th colspan="6" class="title">FICHA TÉCNICA DEL PRODUCTO</th>
        </tr>

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
            <td class="label">GENERADO</td>
            <td class="value" colspan="3">{{ $fecha }}</td>
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

            <td class="label">DESCRIPCIÓN</td>
            <td class="value" colspan="3">{{ $producto->descripcion ?? '' }}</td>
        </tr>

        <tr>
            <td class="label">DETALLE</td>
            <td class="value" colspan="5">{{ $producto->detalle ?? '' }}</td>
        </tr>
    </table>

    <div class="footer">
        FT - {{ $producto->codigo_original }} | Página: {PAGE_NUM} / {PAGE_COUNT}
    </div>

    </body>

</html>
