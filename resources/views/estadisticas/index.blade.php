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
            <ul class="nav nav-tabs" role="tablist">
                <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Ventas</a></li>
                <li><a class="nav-link" data-toggle="tab" href="#tab-2">Servicios</a></li>
                <li><a class="nav-link" data-toggle="tab" href="#tab-3">Clientes</a></li>
                <li><a class="nav-link" data-toggle="tab" href="#tab-4">Empleados</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h5>Ventas Totales</h5>
                                        <h1 class="no-margins">S/ 120,200</h1>
                                        <div class="stat-percent font-bold text-navy">25% <i class="fa fa-bolt"></i></div>                                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h5>Margen de Utilidad</h5>
                                        <h1 class="no-margins">S/ 15,000</h1>
                                        <div class="stat-percent font-bold text-navy">20% <i class="fa fa-level-up"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h5>Inversion Total</h5>
                                        <h1 class="no-margins">S/ 105,000</h1>
                                        <div class="stat-percent font-bold text-navy">12% <i class="fa fa-bolt"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="ibox">
                                    <div class="ibox-content">
                                        <h5>Producto mas vendido</h5>
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
                                            <canvas id="doughnutChart" height="120"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="ibox ">
                                    <div class="ibox-title">
                                        <h5>Ventas Totales y Beneficios por mes
                                        </h5>
                                    </div>
                                    <div class="ibox-content">
                                        <div>
                                            <canvas id="lineChart" height="110"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="ibox ">
                                    <div class="ibox-title">
                                        <h5>Venta por Productos </h5>
                                    </div>
                                    <div class="ibox-content">
                                        <div id="ct-chart4" class="ct-perfect-fourth"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" id="tab-2" class="tab-pane">
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
                <div role="tabpanel" id="tab-3" class="tab-pane">
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
        },
        #ct-chart4 {
            width: 100%; /* Ajusta el ancho según necesites */
            height: 400px; /* Ajusta el alto según necesites */
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
    <script src="{{ asset('js/demo/chartjs-demo.js') }}"></script> 

    

    <script>
         var doughnutOptions = {
        responsive: true
    };


        var doughnutData = {
            labels: ["Venta Fisica", "Venta Web", "Venta Online"],
            datasets: [{
                data: [300, 50, 100],
                backgroundColor: ["green", "red", "blue"]
            }]
        };
        var ctx4 = document.getElementById("doughnutChart").getContext("2d");
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
                    label: "Ingresos",
                    backgroundColor: 'rgba(220, 220, 220, 0.5)',
                    pointBorderColor: "#fff",
                    backgroundColor: 'skyblue',
                    data: [65, 59, 80, 81, 56, 55, 40, 70, 89, 80, 95, 94]
                }
            ]
        };

        var ctx = document.getElementById("lineChart").getContext("2d");
        new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});
        

        $(document).ready(function(){

        // Stocked horizontal bar

        new Chartist.Bar('#ct-chart4', {
            labels: ['Producto 1', 'Producto 2', 'Producto 3', 'Producto 4', 'Producto 5', 'Producto 6'],
            series: [
                [5, 4, 3, 7, 5, 10, 3],
                [3, 2, 9, 5, 4, 6, 4]
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
                    const numLabels = 3;
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
        
    </script>
    

@endsection
