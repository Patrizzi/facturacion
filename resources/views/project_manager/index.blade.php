@extends('layout')
@section('title', 'Proyectos')
@section('content')

    <!-- CSS del proyecto -->
    <link rel="stylesheet" href="{{ asset('css/project_managers/project_managers.css') }}">

    <!-- Contenido -->
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="button-container">
                            <x-ProjectManager.BtnLink url="{{ route('project_managers.index') }}" text="Proyectos"  active="true" />
                            <x-ProjectManager.BtnLink url="{{ route('project_managers.gantt.index') }}" text="Carta Gantt" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
