@extends('layouts.app')
@push('css')
    {!! push_asset_once(asset('css/project_managers/gantt.css')) !!}
@endpush
@section('content')
    <x-content-app title="Lista de Proyectos">
        <div class="wrapper wrapper-content">
            <div class="ibox-title">
                <h1>Vista Gantt</h1>
            </div>
            <x-project-manager.gantt-project-view type="oneProject" />
        </div>
    </x-content-app>
@endsection