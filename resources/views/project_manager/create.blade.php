@extends('layout')
@section('title', 'Crear Proyecto')
@section('href_accion', route('inicio'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')


@section('content')
<link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/footable/footable.core.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/css/project_managers/formDinamico.css') }}">

    @if ($errors->any())
        <h3 class="alert alert-danger">{{ $errors->first() }}</h3>
    @endif
    <br>
    <div class="ibox">
        <div class="ibox-title">
            <h3>Crear Nuevo Proyecto</h3>
        </div>
        <div class="ibox-content">
            {{ html()->form('POST', route('project_managers.store'))->open() }}
            <div class="container-fluid">
                <div class="row m-t-md">
                    @include('project_manager.formDinamico')
                    {{ html()->a('cancelar')->text('Cancelar')->href(route('project_managers.index'))->class('btn btn-white btn-sm m-l-sm') }}
                    {{ html()->button('Crear')->class('btn btn-primary m-l-sm') }}
                </div>
            </div>
            {{ html()->form()->close() }}
        </div>
    </div>
    <style>
        .form-group {
            display: flex;
            flex-direction: column;
        }

        .select2-container--bootstrap {
            width: auto;
            flex: 1 1 auto;
        }

        .select2-container--bootstrap .select2-selection--single {
            height: 100%;
            line-height: inherit;
            padding: 0.5rem 1rem;
            border: 1px solid #e5e6e7;
        }

        .select2-results__option.select2-results__option--highlighted {
            background-color: #1c84c6 !important;
            color: white !important;
        }
    </style>
   <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
 <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
<script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>
<script src="{{ asset('js/plugins/ladda/spin.min.js') }}"></script>
<script src="{{ asset('js/plugins/ladda/ladda.min.js') }}"></script>
<script src="{{ asset('js/plugins/ladda/ladda.jquery.min.js') }}"></script>
<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<script src="{{ asset('js/inspinia.js') }}"></script>
    <script>
        $(".select").select2({
            theme: 'bootstrap',
            containerCssClass: ':all:'
        });
        // $(".datetime").datepicker()

        $(".client").on("change", (e) => {
            const select_element = $(e.target)
            const input_element = $(".ruc")

            const id = select_element.val()
            if (!id) return; // validation id
            const url = "{{ route('cliente.show', ':id') }}".replace(':id', id);
            $.ajax({
                    url: url,
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .done(function(data) {
                    input_element.val(data.numero_documento)
                    toastr.success("Datos del cliente obtenidos correctamente");
                })
                .fail(function(jqXHR, textStatus, errorThrown) {
                    console.error('Error:', textStatus, errorThrown);
                    toastr.error("Error al obtener los datos del cliente"); // Mensaje de error
                });
        })
    </script>
@endsection
