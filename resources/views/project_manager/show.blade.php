@extends('layouts.app')
@section('content')
<x-content-app title="Lista de proyectos" :buttons="$buttons">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="tabs-container">

            <ul class="nav nav-tabs" role="tablist">
                <li><a class="nav-link" href="{{ route("project_managers.index") }}">Proyectos</a></li>
                <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Actividades</a></li>
                <li><a class="nav-link" data-toggle="tab" href="#tab-2">Cards</a></li>
            </ul>

            <div class="tab-content">
                <div role="tabpanel" id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <x-project-manager.gantt-activities-view :collection="$activities" type="manyActivities" />
                    </div>
                </div>
                <div role="tabpanel" id="tab-2" class="tab-pane">
                    <div class="panel-body">
                        <x-project-manager.card-activities-view />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-content-app>
@endsection