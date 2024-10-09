@extends('layouts.app')
@push('css')
    @once
    <link rel="stylesheet" href="{{ asset('/css/project_managers/formDinamico.css') }}">
    @endonce
@endpush 
@section('content')

<div class="formEnvio">
    {{ html()->modelForm($data->id,'PUT','/project_managers.update')->open() }}
        <div class="container-fluid">
            <div class="row ">
                @include('project_manager.formDinamico',compact('data'))
                <div class="w-50 p-1">
                    {{html()->button('Editar')->class('btn btn-primary float-right m-t-n-xs ')}}
                </div>
                <div class="w-65 p-1">
                    {{html()->a('cancelar')->text('Cancelar')->class('btn btn-lightfloat-right m-t-n-xs border border-primary')}}
                </div>
            </div>
        </div>
    {{html()->closeModelForm()}}
</div>
@endsection
@push('js')
@once
    <script>
    </script>
@endonce