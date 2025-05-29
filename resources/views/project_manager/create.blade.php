@extends('layouts.app')
@push('css')
    @once
        <link rel="stylesheet" href="{{ asset('/css/project_managers/formDinamico.css') }}">
    @endonce
@endpush
@section('content')
    @if ($errors->any())
        <h3 class="alert alert-danger">{{ $errors->first() }}</h3>
    @endif
    <div class="formEnvio">

        <div class="inbox-title">
            <h3>Crear Nuevo Proyecto</h3>
        </div>
        <div class="inbox-content">
            {{ html()->form('POST', route('project_managers.store'))->open() }}
            <div class="container-fluid">
                <div class="row m-t-md">
                    @include('project_manager.formDinamico')
                    {{ html()->a('cancelar')->text('Cancelar')->href('project_manager/index')->class('btn btn-white btn-sm m-l-sm') }}
                    {{ html()->button('Crear')->class('btn btn-primary m-l-sm') }}
                </div>
            </div>
            {{ html()->form()->close() }}
        </div>
    </div>
@endsection
@push('js')
    @once
        <script></script>
    @endonce
