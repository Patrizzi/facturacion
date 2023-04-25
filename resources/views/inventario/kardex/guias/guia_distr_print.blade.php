<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Facturación/Print</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- <script src="@yield('vue_js', '#')" defer></script> -->

    <link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{asset('css/plugins/steps/jquery.steps.css')}}" rel="stylesheet">

    <link href="{{asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
    {{-- FUNCION CERRAR AUTOMATICAMENTE --}}
    <SCRIPT LANGUAGE="JavaScript">
        function cerrar() {
            window.close();
        }
    </SCRIPT>

</head>
<body class="white-bg" onLoad="setTimeout('cerrar()',1*1000)">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">

    <div class="row">
        <div class="col-sm-4 text-left" align="left">
            <address class="col-sm-4" align="left">
                <img src="{{asset('img/logos/')}}/{{$mi_empresa->foto}}" alt="" width="300px">
            </address>
        </div>
        <div class="col-sm-4">
        </div>
        <div class="col-sm-4 ">
            <div class="form-control" align="center" style="height: auto;">
                <h3 style="padding-top:10px ">R.U.C {{$mi_empresa->ruc}}</h3>
                <h2 style="font-size: 19px">GUIA REMISION ELECTRONICA</h2>
                <h5>{{$guia_r_traslado->cod_guia}} </h5>
            </div>
        </div>
    </div>
    <br>
    <div class="row" align="center" style="padding-bottom: 5px">
        <div class="col-sm-6" align="center">
            <div class="form-control"><h3>Domicilio De Partida</h3>
                <div align="left" style="font-size: 13px">
                    <p>{{$guia_r_traslado->almc_emisor->nombre}}</p>
                    <p>{{$guia_r_traslado->almc_emisor->direccion}} - {{$guia_r_traslado->almc_emisor->cod_postal}}</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6" align="center" >
            <div class="form-control" ><h3>Domicilio De Llegada</h3>
                <div align="left" style="font-size: 13px">
                    <p>{{$guia_r_traslado->almc_receptor->nombre}}</p>
                    <p>{{$guia_r_traslado->almc_receptor->direccion}} - {{$guia_r_traslado->almc_receptor->cod_postal}}</p>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row" align="center" style="padding-bottom: 5px">
        <div class="col-sm-6" align="center">
            <div class="form-control"><h3>Datos de Transporte</h3>
                <div align="left" style="font-size: 13px">
                    @if ($guia_r_traslado->tipo_transporte == 1)
                        <b>Empresa:</b> {{$guia_r_traslado->vehiculo_publicos->nombre}}<br>
                        <b>Ruc: </b> {{$guia_r_traslado->vehiculo_publicos->ruc}}<br>
                        <b>Nota:</b>Esta Empresa es Publica
                    @else
                        @if(isset($guia_r_traslado->vehiculo_id))
                            <b>Placa del Vehiculo : </b>{{$guia_r_traslado->vehiculo->placa}}<br>
                            <b>Marca del Vehiculo : </b>{{$guia_r_traslado->vehiculo->marca}}<br>
                            <b>Conductor : </b>{{$guia_r_traslado->personal->nombres}}
                        @else
                            <b>Placa del Vehiculo : </b>No Hay Vehiculo<br>
                            <b>Marca del Vehiculo : </b>No Hay Vehiculo<br>
                            <b>Conductor : </b> No Hay Conductor
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Codigo Producto </th>
                    <th>Marca / Descripcion</th>
                    <th>Unid.Medida</th>
                    <th>Cantidad</th>
                    <th>Peso</th>
                </tr>
            </thead>
            <span hidden>{{$z=1}}</span>
            <tbody>
                @foreach ($guia_r_tras_reg as $guia_reg)
                    <tr>
                        <td>{{$z++}}</td>
                        <td>{{$guia_reg->producto->codigo_original}}</td>
                        <td>{{$guia_reg->producto->marcas_i_producto->nombre}} / {{$guia_reg->producto->nombre}} <strong>N/S: </strong>{{$guia_reg->numero_serie}}
                        <br>
                        {{$guia_reg->descripcion}}
                        </td>
                        <td>{{$guia_reg->producto->unidad_i_producto->medida}}</td>
                        <td>{{$guia_reg->cantidad}}</td>
                        <td>{{$guia_reg->producto->peso}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    </div>
</div>
    
    

</body>

<style type="text/css">
    .form-control{border-radius: 10px; height: auto; border-color: #3D3D3D}
    .ibox-tools a{color: white !important}
    .a{height: 30px; margin:0;border-radius: 0px;text-align: center;}
    .table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {border-top-width: 0px;border-color: #3D3D3D}
    #watermark {
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 0;
    }
    #watermark p {
        position: absolute;
        color:   rgba(120, 120, 120, 0.31);
        font-family: Cambria, Cochin, Georgia, Times, 'Times New Roman', serif !important;
        font-weight: bolder;
        font-size: 95px;
        pointer-events: none;
        -webkit-transform: rotate(-45deg);
        -moz-transform: rotate(-45deg);
        top: 35%;
        right: 35%;
        z-index: 0;
    }
    .form-control {
        background-color: transparent !important;
    }
    *{
        color: black;
    }
    p.form-control{
                        border-color: #3D3D3D;
                    }
</style>

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

{{-- IMPRIMIR --}}
<script type="text/javascript">
    window.print();
</script>

</html>