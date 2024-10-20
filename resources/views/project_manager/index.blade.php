@extends('layouts.app')
@push('css')
    {!! push_asset_once('css/project_managers/gantt.css') !!}
@endpush
@section('content')
    {{-- {{ dd($button) }} --}}
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
                            <x-project-manager.general-project-table :collection="$data" />
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-2" class="tab-pane">
                        <div class="panel-body">
                            <x-project-manager.gantt-project-view :collection="$data" type="oneProject" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-content-app>
@endsection
