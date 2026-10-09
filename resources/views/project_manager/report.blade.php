{{-- @extends('layouts.app') --}}
@extends('layout')
@section('title', 'Reportes')
@section('href_accion', route('inicio'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')


@section('content')
<link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/footable/footable.core.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/project_managers/project_managers.css') }}">
    {!! push_asset_once(asset('css/project_managers/gantt.css')) !!}
    <link rel="stylesheet" href="{{ asset('css/project_managers/report.css') }}">


    <x-content-app title="Lista de Proyectos" :buttons="$buttons">
        <div class="wrapper wrapper-content" style="overflow-y: auto; scrollbar-width: none;">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h3 style="margin-left: 10px;">Reporte del Proyecto - {{ $project_manager->nombre }}</h3>
                            <div class="ibox-tools">
                                <a class="close-link">
                                    <i class="fa fa-times"></i>
                                </a>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="row-box status-box">
                                @foreach ($dataReport['estados'] as $key => $estado)
                                    <div class="col-md-3">
                                        <div class="widget style1 navy-bg box">
                                            <p>{{ $estado }}</p>
                                            <h2 class="font-bold">{{ $dataReport['actividadesPorEstado'][$key] }}</h2>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row-box">
                                <div class="box">
                                    <x-project-manager.gantt-project-table :collection="$dataReport['actividadesDelProyecto']" />
                                </div>
                                <div class="box">
                                    <iframe class="chartjs-hidden-iframe"
                                        style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; inset: 0px;"></iframe>
                                    <canvas id="doughnutChart" height="225" width="484"
                                        style="display: block; width: 40vw; height: 30vh;"></canvas>
                                </div>
                            </div>
                            <div class="row-box">
                                <div class="box">
                                    <div id="table-gantt-content" class="ibox-content">
                                        <div class="table-data">
                                            <x-project-manager.custom-project-table :collection="$dataReport['actividadesDelProyecto']"
                                                headers-and-methods="activitiesReport" />
                                        </div>
                                        <div class="table-gantt">
                                            <x-project-manager.gantt-project-table :collection="$dataReport['actividadesDelProyecto']" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="pagination-wrapper">
                                {{ $dataReport['actividadesDelProyecto']->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-content-app>

      <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
<script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>
<script src="{{ asset('js/plugins/ladda/spin.min.js') }}"></script>
<script src="{{ asset('js/plugins/ladda/ladda.min.js') }}"></script>
<script src="{{ asset('js/plugins/ladda/ladda.jquery.min.js') }}"></script>
<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<script src="{{ asset('js/inspinia.js') }}"></script>


        <script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>
        <script>
            // Chart.js
            // Crear arrays para cada datos del doughnut
            var labels = [];
            var data = [];
            var backgroundColors = [];

            // Rellenar los arrays con los datos
            @foreach ($dataReport['actividadesDoughnut'] as $activity)
                labels.push("{{ $activity['nombre'] }}");
                data.push(10);
                backgroundColors.push("{{ $activity['color'] }}");
            @endforeach

            // Porcentaje Vacio
            labels.push("Vacio");
            data.push(100 - data.reduce((a, b) => a + b, 0));
            backgroundColors.push("#f3f3f3");

            // Pasar datos al doughnut
            var doughnutData = {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: backgroundColors
                }]
            };

            // Opciones del doughnut
            var doughnutOptions = {
                responsive: true,
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return data.datasets[0].data[tooltipItem.index] + "%";
                        }
                    }
                }
            };

            // Crear el doughnut
            var ctx4 = document.getElementById("doughnutChart").getContext("2d");
            new Chart(ctx4, {type: 'doughnut', data: doughnutData, options: doughnutOptions});
        </script>
@endsection


