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



    </script>


@endsection
