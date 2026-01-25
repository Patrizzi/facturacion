<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <style>
        body {
            font-size: 12px;
            color: #111;
            margin: 0;
            font-family: "DejaVu Sans", sans-serif !important;
            color: #111;
        }

        .wrap {
            padding: 18px 20px;
        }

        .card {
            border: 1px solid #000;
            border-radius: 10px;
            padding: 14px 14px 10px;
        }

        .top {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
            margin-bottom: 12px;
        }

        .top .title {
            font-size: 16px;
            font-weight: 700;
            margin: 0;
        }


        .top .meta {
            font-size: 10.5px;
            color: #333;
            text-align: right;
        }

        .bar {
            margin: 10px 0 8px;
            padding: 6px 10px;
            border: 1px solid #000;
            border-radius: 8px;
            font-weight: 700;
            text-align: center;
            letter-spacing: .5px;
            background: #f4f4f4;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .grid td {
            border: 1px solid #000;
            padding: 7px 8px;
            vertical-align: top;
        }

        .grid .label {
            font-weight: 700;
            width: 18%;
            background: #fbfbfb;
            white-space: nowrap;
        }

        .grid .value {
            width: 32%;
        }

        .img-box {
            width: 100%;
            height: 190px;
            border: 1px solid #000;
            border-radius: 8px;
            overflow: hidden;
            text-align: center;
            line-height: 190px;
        }

        .img-box img {
            max-width: 100%;
            max-height: 190px;
            vertical-align: middle;
            display: inline-block;
            line-height: normal;
        }


        .muted {
            color: #555;
        }

        .two-col td {
            width: 50%;
        }

        .block {
            border: 1px solid #000;
            border-radius: 8px;
            padding: 8px 10px;
            min-height: 66px;
        }

        .block-title {
            font-weight: 700;
            margin: 0 0 6px;
            font-size: 11px;
        }

        .small {
            font-size: 10.5px;
            line-height: 1.25;
        }

        @font-face {
            font-family: "DejaVu Sans";
            font-style: normal;
            font-weight: normal;
            src: local("DejaVu Sans"), local("DejaVuSans");
        }

        @font-face {
            font-family: "DejaVu Sans";
            font-style: normal;
            font-weight: bold;
            src: local("DejaVu Sans Bold"), local("DejaVuSans-Bold");
        }

        * {
            font-family: "DejaVu Sans", sans-serif !important;
        }

    </style>
</head>
<body>
    <div class="wrap">
        <div class="card">
            <div class="top">
                <p class="title">FICHA TÉCNICA DEL PRODUCTO</p>
                <div class="meta">
                    <div><b>Generado:</b> {{ $fecha }}</div>
                    <div class="muted">{{ $producto->codigo_original }}</div>
                </div>
            </div>

            <div class="bar">DATOS GENERALES</div>

            <table class="grid">
                <tr>
                    <td class="label">CÓDIGO PRODUCTO</td>
                    <td class="value">{{ $producto->codigo_producto }}</td>

                    <td class="label">CÓDIGO ORIGINAL</td>
                    <td class="value">{{ $producto->codigo_original }}</td>
                </tr>
                <tr>
                    <td class="label">NOMBRE</td>
                    <td class="value" colspan="3">{{ $producto->nombre }}</td>
                </tr>
                <tr>
                    <td class="label">MARCA</td>
                    <td class="value">{{ $producto->marcas_i_producto->nombre ?? 'N/A' }}</td>

                    <td class="label">UNIDAD</td>
                    <td class="value">{{ $producto->unidad_i_producto->medida ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">FAMILIA</td>
                    <td class="value">{{ $producto->familia_i_producto->descripcion ?? 'N/A' }}</td>

                    <td class="label">SUBFAMILIA</td>
                    <td class="value">{{ $producto->subfamilia_i_producto->descripcion ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="label">AFECTACIÓN</td>
                    <td class="value">{{ $producto->tipo_afec_i_producto->informacion ?? 'N/A' }}</td>

                    <td class="label">CATEGORÍA</td>
                    <td class="value">{{ $producto->categoria_i_producto->descripcion ?? 'N/A' }}</td>
                </tr>
            </table>

            <div style="height:10px;"></div>

            <table class="two-col">
                <tr>
                    <td style="padding-right:10px; vertical-align:top;">
                        <div class="bar">DETALLES</div>
                        <table class="grid">
                            <tr>
                                <td class="label">ORIGEN</td>
                                <td class="value">{{ $producto->origen ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="label">GARANTÍA</td>
                                <td class="value">{{ $producto->garantia ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="label">PESO</td>
                                <td class="value">{{ $producto->peso ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td class="label">STOCK</td>
                                <td class="value">{{ $stock }}</td>
                            </tr>
                        </table>
                    </td>

                    <td style="padding-left:10px; vertical-align:top;">
                        <div class="bar">IMAGEN</div>
                        <div class="img-box">
                            @if ($fotoBase64)
                            <img src="{{ $fotoBase64 }}" alt="Foto">
                            @else
                            <span class="muted">Sin imagen</span>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>

            <div style="height:10px;"></div>

            <table style="width:100%; border-collapse:separate; border-spacing:0;">
                <tr>
                    <td style="padding-right:10px;">
                        <div class="block">
                            <p class="block-title">DETALLE</p>
                            <div class="small">{{ $producto->detalle ?? '-' }}</div>
                        </div>
                    </td>
                    <td style="padding-left:10px;">
                        <div class="block">
                            <p class="block-title">DESCRIPCIÓN</p>
                            <div class="small">{{ $producto->descripcion ?? '' }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
