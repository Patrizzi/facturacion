@extends('layouts.app')
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

@endsection

