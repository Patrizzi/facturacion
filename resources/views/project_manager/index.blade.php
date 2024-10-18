@extends('layouts.app')
@push('css')
    @once
    <link rel="stylesheet" href="{{ asset('css/project_managers/project_managers.css') }}">  
    @endonce
@endpush
@section('content')
    <div class="wrapper wrapper-content">
        <x-content-app title="Proyectos" :buttons="$buttons">
            <x-project-manager.general-project-table :collection="$data" />
        </x-content-app>
    </div>
@endsection
