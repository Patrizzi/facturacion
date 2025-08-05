{{-- @extends('layouts.app') --}}
@extends('layout')
@section('title', 'Gantt')
@section('href_accion', route('inicio'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

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
