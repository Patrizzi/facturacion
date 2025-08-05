{{-- @extends('layouts.app') --}}
@extends('layout')
@section('title', 'Crear Proyecto')
@section('href_accion', route('inicio'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

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
    @once
        <script></script>
    @endonce
