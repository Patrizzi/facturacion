{{-- @extends('layouts.app') --}}
@extends('layout')
@section('title', 'Editar Proyecto')
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

<div class="ibox-title">

</div>
<div class="ibox-content"
    {{ html()->modelForm($user,'PUT','/update-url')->open() }}
        <div class="form-group row">
            {{html()->label('Nombre:')->class('col-form-label')}}
            <div class='col-sm-10'>
                {{html()->text('name')->placeholder('Ingrese el Nombre')->class('form-control')}}
            </div>
        </div>

        {{html()->label('Email:')->class('col-lg-2 col-form-label')}}
        {{html()->email('email')->placeholder('Ingrese el Gmail')->class('form-control')}}

        {{html()->label('Personal:')->class('col-lg-2 col-form-label')}}
        {{html()->number('personal_id')->placeholder('Ingrese al Personal')->class('form-control')}}

        {{html()->label('Estado:')->class('col-lg-2 col-form-label')}}
        {{html()->number('personal_id')->placeholder('Ingrese el Estado')->class('form-control')}}

        {{html()->label('COnfic:')->class('col-lg-2 col-form-label')}}
        {{html()->number('confi_id')->placeholder('Ingrese la ')->class('form-control')}}

        {{html()->label('Email Creado:')->class('col-lg-2 col-form-label')}}
        {{html()->number('email_creado')->placeholder('Ingrese al Email Creado')->class('form-control')}}

        {{html()->label('Almacen:')->class('col-lg-2 col-form-label')}}
        {{ html()->number('almacen_id')->placeholder('Ingrese el Almacen')->class('form-control') }}

        {{html()->button('Enviar')->class('btn btn-sm btn-primary float-right m-t-n-xs')}}

    {{html()->closeModelForm()}}
</div>

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

