{{-- @extends('layouts.app') --}}
@extends('layout')
@section('title', 'Proyectos')
@section('href_accion', route('inicio'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('content')
    <x-content-app title="Lista de proyectos" :buttons="$button">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="tabs-container">

                <ul class="nav nav-tabs" role="tablist">
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Proyectos</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-2">Gantt</a></li>
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
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
