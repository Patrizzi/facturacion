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
                <div role="tabpanel" id="tab-2" class="tab-pane active">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h1 class="text-bold" style="font-size: 38px; font-weight: 500; letter-spacing: 1px; text-transform: uppercase;">Dashboard de Servicios</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h5>Ventas Totales</h5>
                                        <h1 class="no-margins">S/ 120,200</h1>
                                        <div class="stat-percent font-bold text-navy">25% <i class="fa fa-bolt"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h5>Margen de Utilidad</h5>
                                        <h1 class="no-margins">S/ 15,000</h1>
                                        <div class="stat-percent font-bold text-navy">20% <i class="fa fa-level-up"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h5>Inversion Total</h5>
                                        <h1 class="no-margins">S/ 105,000</h1>
                                        <div class="stat-percent font-bold text-navy">12% <i class="fa fa-bolt"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h5>Servicio mas Solicitado</h5>
                                        <h1 class="no-margins">Producto 3</h1>
                                        <div class="stat-percent font-bold text-navy">35% <i class="fa fa-bolt"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="ibox ">
                                    <div class="ibox-title">
                                        <h5>Ingresos por Canales de Venta</h5>

                                    </div>
                                    <div class="ibox-content">
                                        <div>
                                            <canvas id="doughnutChart2" height="190"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="ibox ">
                                    <div class="ibox-title">
                                        <h5>Ventas Totales y Beneficios
                                        </h5>
                                    </div>
                                    <div class="ibox-content">
                                        <div>
                                            <canvas id="lineChart2" height="148"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="ibox ">
                                    <div class="ibox-title">
                                        <h5>Comparacion de Stock y Ventas por Producto </h5>
                                    </div>
                                    <div class="ibox-content">
                                        <div id="ct-chart7"  class="ct-perfect-fourth"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" id="tab-3" class="tab-pane">
                    <div class="panel-body">
                    <iframe title="power-tr1" width="100%" height="900" src="https://app.powerbi.com/view?r=eyJrIjoiOTJjZmRjZjktNDE2Ni00ZjY4LWIzMjktNDI1OTJmMGVjZGY4IiwidCI6ImI0YTQwNTQ1LTc3NzktNGIzOC1hZmY3LTFmMTczOGY4MDg0MCIsImMiOjR9" frameborder="0" allowFullScreen="true"></iframe>
                    </div>
                </div>
                <div role="tabpanel" id="tab-4" class="tab-pane">
                    <div class="panel-body">
                        <strong>Donec quam felis</strong>

                        <p>Thousand unknown plants are noticed by me: when I hear the buzz of the little world among the
                            stalks, and grow familiar with the countless indescribable forms of the insects
                            and flies, then I feel the presence of the Almighty, who formed us in his own image, and the
                            breath </p>

                        <p>I am alone, and feel the charm of existence in this spot, which was created for the bliss of
                            souls like mine. I am so happy, my dear friend, so absorbed in the exquisite
                            sense of mere tranquil existence, that I neglect my talents. I should be incapable of drawing a
                            single stroke at the present moment; and yet.</p>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <style>
        .tabs-container .panel-body{
            background-color: #f3f3f4;
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

    <!-- Chartist -->
    <script src="{{ asset('js/plugins/chartist/chartist.min.js') }}"></script>

    <!-- ChartJS-->
    <script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>




    <script>

    {{-----------------------------Inicio DE TABLA 2-----------------------------}}
    var doughnutOptions = {
        responsive: true
        };


        var doughnutData = {
            labels: ["Venta Fisica", "Venta Web", "Venta Online"],
            datasets: [{
                data: [300, 50, 100],
                backgroundColor: ["black", "yellow", "blue"]
            }]
        };
        var ctx4 = document.getElementById("doughnutChart2").getContext("2d");
        new Chart(ctx4, {
            type: 'doughnut',
            data: doughnutData,
            options: doughnutOptions
        });

        var lineOptions = {
        responsive: true
        };

        var lineData = {
            labels: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto","Setiembre","Octubre","Nobiembre","Diciembre"],
            datasets: [

                {
                    label: "Beneficios",
                    backgroundColor: 'rgba(26,179,148,0.5)',
                    borderColor: "rgba(26,179,148,0.7)",
                    pointBackgroundColor: "rgba(26,179,148,1)",
                    pointBorderColor: "#fff",
                    data: [28, 20, 26, 19, 16, 27, 30, 20, 22, 21, 23, 15]
                },{
                    label: "Ventas Totales",
                    backgroundColor: 'rgba(220, 220, 220, 0.5)',
                    pointBorderColor: "#fff",
                    backgroundColor: 'skyblue',
                    data: [65, 59, 80, 81, 56, 55, 40, 70, 89, 80, 95, 94]
                }
            ]
        };

        var ctx = document.getElementById("lineChart2").getContext("2d");
        new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});

        $(document).ready(function(){

        // Stocked horizontal bar

        new Chartist.Bar('#ct-chart7', {
            labels: ['Servicio 1', 'Servicio 2', 'Servicio 3', 'Servicio 4', 'Servicio 5', 'Servicio 6'],
            series: [
                [1, 32, 22, 40, 35, 20],
                [2, 28, 20, 30, 24, 8]
            ]
        }, {
            seriesBarDistance: 10,
            reverseData: true,
            horizontalBars: true,
            axisY: {
                offset: 70
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
            },
        });



        // Leyenda personalizada (agregamos esto después del gráfico)
        var legend = $('<div class="chart-legend">')
            .append('<div class="legend-item"><span class="legend-color" style="background-color: #000000;"></span> Servicios</div>') // Primer color de la serie
            .append('<div class="legend-item"><span class="legend-color" style="background-color: #03a9f4;"></span> Solicitados</div>'); // Segundo color de la serie

        // Adjuntamos la leyenda al contenedor del gráfico
        $('#ct-chart7').after(legend);
        });


    </script>


@endsection
