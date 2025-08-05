{{-- @extends('layouts.app') --}}
@extends('layout')
@section('title', 'Editar Proyecto')
@section('href_accion', route('inicio'))
@section('value_accion', 'Atrás')
@section('atributo_actu', 'hidden')

@section('content')
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
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@endsection

