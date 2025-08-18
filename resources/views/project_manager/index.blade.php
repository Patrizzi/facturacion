{{-- @extends('layouts.app') --}}
@extends('layout')
@section('title', 'Proyectos')
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

    <x-content-app title="Lista de proyectos" :buttons="$button">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="tabs-container">

                <ul class="nav nav-tabs" role="tablist">
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Proyectos</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-2">Gantt</a></li>
                    <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                        <a href="{{route('project_managers.create')}}" class="btn btn-sm btn-primary "><i class="fa fa-plus"></i></a>
                    </ul>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            @if ($data->isNotEmpty())
                                <x-project-manager.general-project-table :collection="$data" />
                            @else
                                <h5>No hay proyectos para mostrar.</h5>
                            @endif
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-2" class="tab-pane">
                        <div class="panel-body">
                            @if ($data->isNotEmpty())
                                <x-project-manager.gantt-project-view :collection="$data" type="oneProject" />
                            @else
                                <h5>No hay proyectos para mostrar.</h5>
                            @endif
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
@endsection
