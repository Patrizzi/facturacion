@extends('layout')
@section('href_accion', route('project_managers.index'))
@section('content')

    <!-- CSS del proyecto -->
    <link rel="stylesheet" href="{{ asset('css/project_managers/project_managers.css') }}">

    <!-- Contenido -->
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox" style="margin-bottom: 0px;">
                    <div class="ibox-content" style="padding: 15px 20px;">
                        <div class="button-container" style="display: flex; justify-content: center; gap: 10px;">
                            <x-btn-link url="{{ route('project_managers.index') }}" text="Proyectos" />
                            <x-btn-link url="{{ route('project_managers.index') }}" text="Carta de Gantt" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
