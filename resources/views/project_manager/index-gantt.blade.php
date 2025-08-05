@extends('layouts.app')
@push('css')
    {!! push_asset_once(asset('css/project_managers/gantt.css')) !!}
    <link rel="stylesheet" href="{{ asset('css/project_managers/project_managers.css') }}">
@endpush
@section('content')
    <x-content-app title="Lista de Proyectos" :buttons="$buttons">
        <div class="wrapper wrapper-content">
            <div class="ibox-title">
                <h1>Vista Gantt</h1>
                <x-project-manager.gantt-project-view :collection="$data" type="oneProject" />
            </div>
        </div>
    </x-content-app>
@endsection
