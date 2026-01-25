<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Ficha Técnica - {{ $servicio->codigo_servicio ?? 'Servicio' }}</title>

    <style>
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

        body {
            font-family: "DejaVu Sans", sans-serif !important;
            font-size: 12px;
            color: #111;
            margin: 0;
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
            line-height: 1.25;
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

        .two-col {
            width: 100%;
        }

        .two-col td {
            width: 50%;
        }

        .img-box {
            width: 100%;
            height: 190px;
            border: 1px solid #000;
            border-radius: 8px;
            overflow: hidden;
            text-align: center;
            line-height: 190px;
            background: #fff;
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

        .spacer {
            height: 10px;
        }

    </style>
</head>

<body>
    <div class="wrap">
        <div class="card">

            <div class="top">
                <p class="title">FICHA TÉCNICA DEL SERVICIO</p>
                <div class="meta">
                    <div><b>Generado:</b> {{ $fecha ?? now('America/Lima')->format('d/m/Y H:i') }}</div>
                    <div class="muted">{{ $servicio->codigo_servicio ?? ($servicio->codigo_original ?? '') }}</div>
                </div>
            </div>

            <div class="bar">DATOS GENERALES</div>

            <table class="grid">
                <tr>
                    <td class="label">CÓDIGO SERVICIO</td>
                    <td class="value">{{ $servicio->codigo_servicio ?? '-' }}</td>

                    <td class="label">CÓDIGO ORIGINAL</td>
                    <td class="value">{{ $servicio->codigo_original ?? '-' }}</td>
                </tr>

                <tr>
                    <td class="label">NOMBRE</td>
                    <td class="value" colspan="3">{{ $servicio->nombre ?? '-' }}</td>
                </tr>

                <tr>
                    <td class="label">FAMILIA</td>
                    <td class="value">{{ optional($servicio->familia)->descripcion ?? '-' }}</td>

                    <td class="label">SUBFAMILIA</td>
                    <td class="value">
                        {{ optional($servicio->subfamilia_i_serv)->descripcion
                            ?? optional($servicio->subfamilia_i_serv)->informacion
                            ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <td class="label">MARCA</td>
                    <td class="value">
                        {{ optional($servicio->marca)->descripcion
                            ?? optional($servicio->marca)->nombre
                            ?? '-' }}
                    </td>

                    <td class="label">CATEGORÍA</td>
                    <td class="value">{{ $servicio->categoria ?? '-' }}</td>
                </tr>

                <tr>
                    <td class="label">ESTADO</td>
                    <td class="value">
                        {{ (string)($servicio->estado_anular ?? '0') === '0' ? 'Activo' : 'Anulado' }}
                    </td>

                    <td class="label">MONEDA</td>
                    <td class="value">
                        {{ optional($servicio->moneda)->codigo
                            ?? optional($servicio->moneda)->descripcion
                            ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <td class="label">TIPO AFECTACIÓN</td>
                    <td class="value" colspan="3">
                        {{ optional($servicio->tipo_afec_i_serv)->informacion
                            ?? optional($servicio->tipo_afec_i_serv)->descripcion
                            ?? '-' }}
                    </td>
                </tr>
            </table>

            <div class="spacer"></div>

            <table class="two-col">
                <tr>
                    <td style="padding-right:10px; vertical-align:top;">
                        <div class="bar">DETALLES</div>

                        <table class="grid">
                            <tr>
                                <td class="label">PRECIO (NACIONAL)</td>
                                <td class="value">{{ $servicio->precio_nacional ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="label">PRECIO (EXTRANJERO)</td>
                                <td class="value">{{ $servicio->precio_extranjero ?? '-' }}</td>
                            </tr>
                        </table>
                    </td>

                    <td style="padding-left:10px; vertical-align:top;">
                        <div class="bar">IMAGEN</div>

                        <div class="img-box">
                            @if(!empty($fotoBase64))
                            <img src="{{ $fotoBase64 }}" alt="Imagen del Servicio">
                            @else
                            <span class="muted">Sin imagen</span>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>

            <div class="spacer"></div>

            <table style="width:100%; border-collapse:separate; border-spacing:0;">
                <tr>
                    <td style="vertical-align:top;">
                        <div class="block">
                            <p class="block-title">DESCRIPCIÓN</p>
                            <div class="small">{{ $servicio->descripcion ?? '-' }}</div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
