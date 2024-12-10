@extends('layout')
@section('title', 'Estadisticas')
@section('href_accion', route('estadisticas.index'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('content')

    @if ($errors->any())
        <div style="padding-top: 20px;">
            <div class="alert alert-danger">
                <a class="alert-link" href="#">
                    @foreach ($errors->all() as $error)
                        <li style="color: red">{{ $error }}</li>
                    @endforeach
                </a>
            </div>
        </div>
    @endif





    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="tabs-container">
            @include('estadisticas\_shared\tabs')
            <div class="tab-content">
                <div role="tabpanel" id="tab-4" class="tab-pane active">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="ibox">
                                    <div class="ibox-content" id="tarjetas">
                                        <h1 class="text-bold" style="font-size: 38px; font-weight: 500; letter-spacing: 1px; text-transform: uppercase;">Dashboard Empleados</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="ibox">
                                    <div class="ibox-content" id="tarjetas">
                                        <h5>Mayor Venta por Unidades</h5>
                                        <h1 class="no-margins">Empleado 1</h1>
                                        <div class="stat-percent font-bold text-navy">18% <i class="fa fa-bolt"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="ibox">
                                    <div class="ibox-content" id="tarjetas">
                                        <h5>Empleado mas Importante</h5>
                                        <h1 class="no-margins">Empleado 2</h1>
                                        <div class="stat-percent font-bold text-navy">42% <i class="fa fa-level-up"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="ibox">
                                    <div class="ibox-content" id="tarjetas">
                                        <h5>Mas venta por Rol de Empleado</h5>
                                        <h1 class="no-margins">Vendedor Interno</h1>
                                        <div class="stat-percent font-bold text-navy">40% <i class="fa fa-level-up"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="ibox ">
                                    <div class="ibox-title">
                                        <h5>Ranking por Unidades Vendidas</h5>
                                    </div>
                                    <div class="ibox-content">
                                        <div id="ct-chart" class="ct-perfect-fourth"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="ibox">
                                    <div class="ibox-title">
                                        <h5>Ranking por Utilidad</h5>
                                    </div>
                                    <div class="ibox-content">
                                        <div id="ct-chart2" class="ct-perfect-fourth"  ></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="ibox ">
                                    <div class="ibox-title">
                                        <h5>Ranking por Facturas Realizadas</h5>
                                    </div>
                                    <div class="ibox-content">
                                        <div id="ct-chart3" class="ct-perfect-fourth"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="ibox ">
                                    <div class="ibox-title">
                                        <h5>Ventas Totales por Rol</h5>
                                    </div>
                                    <div class="ibox-content">
                                        <div>
                                            <div id="pie"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <style>
         #tarjetas{
            border-radius: 10px 10px 10px 10px
        
        }
        .ibox-title{
            border-radius: 10px 10px 0px 0px
        }
        .ibox-content{
            border-radius: 0px 0px 10px 10px
        }


        .tabs-container .panel-body{
            background-color: #143ca4;
        }
        #ct-chart4 {
            width: 100% !important; /* Ajusta el ancho según necesites */
            height: 300px !important; /* Ajusta el alto según necesites */
        }
        #ct-chart5 {
            width: 100%; /* Ajusta el ancho según necesites */
            height: 550px; /* Ajusta el alto según necesites */
        }
        #ct-chart6 {
            width: 100%; /* Ajusta el ancho según necesites */
            height: 520px; /* Ajusta el alto según necesites */
        }
        #ct-chart7 {
            width: 100% !important; /* Ajusta el ancho según necesites */
            height: 300px !important; /* Ajusta el alto según necesites */
        }
        .ct-label.ct-vertical {
            font-size: 14px; /* Ajusta el tamaño según tu preferencia */
        }
        .chart-legend {
        display: flex;
        justify-content: center;
        margin-top: 10px;
        font-size: 14px;
        }

        .legend-item {
            margin: 0 15px;
            display: flex;
            align-items: center;
        }

        .legend-color {
            width: 20px;
            height: 20px;
            display: inline-block;
            margin-right: 5px;
        }
            /* Color para la serie A (Stock) */
        #ct-chart4 .ct-series-a .ct-bar {
            stroke: #8bc34a;
        }

        /* Color para la serie B (Ventas) */
        #ct-chart4 .ct-series-b .ct-bar {
            stroke: #03a9f4;
        }

        #ct-chart5 .ct-bar {
            stroke-width: 25px; /* Ajusta el ancho de las barras */
        }
        #ct-chart5 .ct-series-a .ct-bar {
            stroke: #4082fc;
        }
        /* Color para la serie A (Stock) */
        #ct-chart6 .ct-series-a .ct-bar {
        stroke: #5dcde4;
        }

        /* Color para la serie B (Ventas) */
        #ct-chart6 .ct-series-b .ct-bar {
            stroke: #ffa49d;
        }    /* Color para la serie c (Stock) */
        #ct-chart6 .ct-series-c .ct-bar {
            stroke: #9d90ff;
        }

        #ct-chart7 .ct-series-a .ct-bar {
            stroke: #8bc34a;
        }

        /* Color para la serie B (Ventas) */
        #ct-chart7 .ct-series-b .ct-bar {
            stroke: #03a9f4;
        }
        /* Cambia el color de la primera serie (serie 0) */
        .ct-series-a .ct-bar {
        stroke: #415cb3 !important; /* Azul */
        fill: #415cb3 !important;   /* Azul */
        }
        /* Cambia el color de la segunda serie (serie 1) */
        .ct-series-b .ct-bar {
            stroke: #ece9fe !important; /* Verde */
            fill: #ece9fe !important;   /* Verde */
        }
        .ct-label {
            font-size: 12px !important;

        }
        #ct-chart2 .ct-series-a .ct-bar {
            stroke: #a194fe !important;
        }
        #ct-chart2 .ct-bar {
            stroke-width: 25px; /* Ajusta el ancho de las barras */
        }


    </style>

    <link href="{{ asset('css/plugins/chartist/chartist.min.css') }}" rel="stylesheet">

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <script src="{{ asset('js/plugins/c3/c3.min.js') }}"></script>
    <script src="{{ asset('js/plugins/d3/d3.min.js') }}"></script>

    <!-- Chartist -->
    <script src="{{ asset('js/plugins/chartist/chartist.min.js') }}"></script>



    <!-- ChartJS-->
    <script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>




    <script>
        new Chartist.Bar('#ct-chart', {
        labels: ['Empleado1', 'Empleado2', 'Empleado3', 'Empleado4', 'Empleado5', 'Empleado6'],
        series: [
            [90, 80, 60, 50, 30, 15],
            [10, 20, 40, 50, 70, 85]
            ]
        }, {
            stackBars: true,
            axisY: {
                onlyInteger: true,  // Asegura que solo se muestren números enteros
                low: 0,             // Configura el valor mínimo del eje Y
                high: 100,          // Configura el valor máximo del eje Y
                ticks: [0, 20, 40, 60, 80, 100],  // Establece las marcas del eje Y en intervalos
            }
        }).on('draw', function(data) {
            if (data.type === 'bar') {
                data.element.attr({
                    style: 'stroke-width: 40px'
                });
            }
        });
        //Grafico 1

        $(document).ready(function(){

        // Stocked horizontal bar

        new Chartist.Bar('#ct-chart2', {
            labels: ['Empleado1', 'Empleado2', 'Empleado3', 'Empleado4', 'Empleado5', 'Empleado6'],
            series: [
                [20000, 15000, 14000, 7000, 4000, 3800]
            ]
        }, {
            seriesBarDistance: 10,
            reverseData: true,
            horizontalBars: true,
            axisY: {
                offset: 80
            },
            axisX: {
                labelInterpolationFnc: function(value, index) {
                    // Mostrar solo 5 etiquetas en el eje X, en intervalos uniformes
                    const numLabels = 10;
                    const totalLabels = 10; // Número total de valores del eje X
                    if (index % Math.ceil(totalLabels / numLabels) === 0) {
                        return Math.round(value); // Mostrar el valor redondeado
                    } else {
                        return null; // Ocultar otras etiquetas
                    }
                }
            }
        });
        });

        //Grafico 2

        new Chartist.Bar('#ct-chart3', {
        labels: ['Empleado1', 'Empleado2', 'Empleado3', 'Empleado4', 'Empleado5', 'Empleado6'],
        series: [
            [90, 80, 60, 50, 30, 15],
            [10, 20, 40, 50, 70, 85]
        ]
        }, {
        stackBars: true,
        axisY: {
            onlyInteger: true,  // Asegura que solo se muestren números enteros
            low: 0,             // Configura el valor mínimo del eje Y
            high: 100,          // Configura el valor máximo del eje Y
            ticks: [0, 20, 40, 60, 80, 100],  // Establece las marcas del eje Y en intervalos
        }
        }).on('draw', function(data) {
        if (data.type === 'bar') {
            data.element.attr({
                style: 'stroke-width: 40px'
            });
        }
        });
        //Grafico3

        $(document).ready(function () {

        c3.generate({
            bindto: '#pie',
            data:{
                columns: [
                    ['Gerente de Ventas', 30],
                    ['Asesor de Ventas', 50],
                    ['Ejecutivo de Ventas', 100],
                    ['Vendedor Interno', 120]
                ],
                colors:{
                    GerentedeVentas: '#1ab394',
                    AsesordeVentas: '#e90202',
                    EjecutivodeVentas: '#1adf29',
                    VendedorInterno: '#3654df'
                },
                type : 'pie'
            }
        });

        });
        //Grafico 4



    </script>


@endsection
