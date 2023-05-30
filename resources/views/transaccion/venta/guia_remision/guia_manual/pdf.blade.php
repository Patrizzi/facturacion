<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Guia Remision Manual</title>{{--
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" > --}}
        <link href="{{ asset('css/estilos_pdf.css') }}" rel="stylesheet">
        <style type="text/css">
            .form-control, .single-line {
                background-color: #FFFFFF;
                background-image: none;
                border: 1px solid #808080;
                border-radius: 10px;
                color: inherit;
                display: block;
                padding: 6px 12px;
                transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
                width: 100%;
            }
            @page { 
                size: A4 ;
                font-size: 60% !important;
            }
        </style>
    </head>
    <body class="white-bg">
        <table style="width: 100%;border-collapse:separate;margin-bottom: -10px">
            <tr>
                @include('layout_cabecera_ventas_pdf')
                <td style="width: 30%; ;border: 1px #808080 solid;border-radius: 8px;margin-top: 0px" align="right">
                    <center>
                        <h3 style="text-align: center;margin: 1px"> R.U.C {{$empresa->ruc}}</h3>
                        <h2 style="font-size: 17px;text-align: center;margin: 1px" >GUIA REMISION ELECTRONICA</h2>
                        <h4 style="text-align: center;margin: 1px" >{{$guia_remision_m->cod_guia}}</h4>
                    </center>
                </td>
            </tr>
        </table>
        <table style="width: 100%;border-collapse:separate;margin-top: 0px">
            <tbody >
                <tr style="margin-bottom: 2px">
                    <td  style="border: 1px #3D3D3D solid;border-radius: 8px;width: 45%" >
                        <center><strong style="align-content: center;margin: 5px">Domicilio De Partida </strong></center><br>
                        &nbsp;{{$guia_remision_m->almacen->direccion}} -  {{$guia_remision_m->almacen->cod_postal}}<br>
                    </td>
                    <th style="width: 2%;border-color: white"></th>
                    <td  style="border: 1px #3D3D3D solid;border-radius: 8px;width: 45%">
                        <center><strong style="align-content: center;margin: 5px">Domicilio De Llegada </strong></center><br>
                        @if(isset($guia_remision->sucursal_cliente))
                            {{$guia_remision_m->sucursal_cliente}} - {{$guia_remision_m->cod_postal_cliente}}
                        @else
                            {{$guia_remision_m->cliente->direccion}} - {{$guia_remision_m->cliente->cod_postal}}
                        @endif <br>
                    </td>
                </tr>
            </tbody>
            <br style="margin: 50%">
            <tbody >
                <tr >
                    <td  style="border: 1px #3D3D3D solid;border-radius: 8px;width: auto" >
                        <center><strong style="align-content: center;margin: 5px">Destinario</strong></center><br>
                        <strong>Señor(es) :</strong>&nbsp;{{$guia_remision_m->cliente->nombre}}<br>
                        <strong>R.U.C / DNI :</strong>&nbsp; {{$guia_remision_m->cliente->numero_documento}}<br>
                        <strong>Fecha Emision :</strong>&nbsp;{{$guia_remision_m->fecha_emision}} <br>
                        <strong>Fecha Traslado :</strong>&nbsp;{{$guia_remision_m->fecha_entrega}} <br>
                    </td>
                    <th style="width: 2%;border-color: white"></th>
                    <td  style="border: 1px #3D3D3D solid;border-radius: 8px;width: auto">
                        <center><strong style="align-content: center;margin: 5px">Unidad de Transporte/Conductor</strong></center><br>
                        @if(isset($guia_remision_m->vehiculo_id))
                            <p>
                                <b>Placa del Vehiculo : </b>{{$guia_remision_m->vehiculo->placa}}<br>
                                <b>Marca del Vehiculo : </b>{{$guia_remision_m->vehiculo->marca}}<br>
                                <b>Conductor : </b>{{$guia_remision_m->personal->nombres}}
                            </p>
                        @elseif(isset($guia_remision_m->vehiculo_publico))
                            <p>
                                <b>Empresa:</b> {{$guia_remision_m->vehiculo_publicos->nombre}}<br>
                                <b>Ruc: </b> {{$guia_remision_m->vehiculo_publicos->ruc}}<br>
                                <b>Nota:</b>Esta Empresa es Publica

                            </p>
                        @else
                            <p>
                                <b>Placa del Vehiculo : </b>No Hay Vehiculo<br>
                                <b>Marca del Vehiculo : </b>No Hay Vehiculo<br>
                                @if(isset($guia_remision_m->conductor_id))
                                <b>Conductor : </b>{{$guia_remision_m->personal->nombres}}
                                @else
                                <b>Conductor : </b> No Hay Conductor
                                @endif
                            </p>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="">
            <table class="" style="border-top: 0px;width: 100%;max-width: 100%;table-layout:fixed;border-top: 0px white;" >
                <thead style="border-top: 0px white;">
                    <tr style="text-align: left;font-weight: bold;border-top: 0px white;vertical-align: bottom;">
                        <th  style=" width: 5%;border-top: 0px white">Item</th>
                        <th  style=" width: 10%;border-top: 0px white">Código</th>
                        <th  style=" width: 59%;border-top: 0px white">Marca / Descripcion</th>
                        <th style=" width: 10%;border-top: 0px white">Ud. de Medida</th>
                        <th style=" width: 8%;border-top: 0px white">Cantidad</th>
                        <th style=" width: 8%;border-top: 0px white">Peso</th>
                    </tr>
                </thead>
                <tbody style="width: 100%">
                    @foreach($guia_remision_m_reg as $guia_registros)
                        <tr style="border-bottom: 0px white;">
                            <td>{{$i++}}</td>
                            <td>{{$guia_registros->producto->codigo_producto}}</td>
                            <td>{{$guia_registros->producto->marcas_i_producto->nombre}} / {{$guia_registros->producto->nombre}} <strong>N/S: </strong><span style="overflow-wrap: break-word;
                                ">{{$guia_registros->numero_serie}} </span> <br> {{$guia_registros->descripcion}}  </td>
                            <td>{{$guia_registros->producto->unidad_i_producto->medida}}</td>
                            <td>{{$guia_registros->cantidad}}</td>
                            <td>{{$guia_registros->peso}} KG</td>
                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="5" align="right">Peso Total:</td>
                        <td>{{$guia_remision_m_reg->sum('peso')}} KGM</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <br>
        <table style="width: 100%;border-collapse:separate;">
            <tbody>
                <tr >
                    <td  style="border: 1px #3D3D3D solid;border-radius: 8px;width: auto" >
                        <center><strong style="align-content: center;margin: 5px">Observacion </strong></center><br>
                        &nbsp;{{$guia_remision_m->observacion}}<br>

                    </td>
                    <th style="width: 2%;border-color: white"></th>
                    <td  style="border: 1px #3D3D3D solid;border-radius: 8px;width: auto">
                        <center><strong style="align-content: center;margin: 5px">Motivo de Traslado</strong></center><br>{{$guia_remision_m->motivo_traslado}}<br>
                    </td>
                </tr>
            </tbody>
        </table>
        {{-- @include('layout_bancos_pdf') --}}

        <div style="height: 100px"></div>
        <table style="border:  0px solid white">
            <tr style="border:  0px solid white">
                <td>
                    <p><u>Centro de Atención: </u></p>
                    Telefono : {{$guia_remision_m->user_personal->personal->telefono }}<br>
                    Celular : {{$guia_remision_m->user_personal->personal->celular }}<br>
                    Email : {{$guia_remision_m->user_personal->personal->email }}<br>
                    Web : {{$empresa->pagina_web}} <br>
                </td>
                <td >
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <hr>
                    <center>{{$guia_remision_m->user_personal->personal->nombres }}</center>
                </td>
            </tr>
        </table>
    </body>
    <style type="text/css">
        
        *{
            color: black;
            font-family: apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji","Segoe UI Symbol"
        }
        .table-bordered .blanco {
            border: none;
        }
        .blanco{border: none;
            border-color: #808080 ;
        }
        .border {
            border-color: #3D3D3D;
            border-width: 1px;
            border-style: solid;
        }
        .table {
            /* width: 100%;
            max-width: 100%; */
            margin-bottom: 1rem;
            background-color: transparent;
            border-top-width: 0px;
            text-align: left;
        }
        .form-control {
            background-color: transparent !important;
        }
        .tr_table_item{
            border-top: 0px white;
            text-align: initial;
        }
    </style>
</html>