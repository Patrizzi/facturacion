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
            <h3>Editar Proyecto</h3>
        </div>
        <div class="inbox-content">
            {{ html()->modelForm($project_manager,'PUT',route('project_managers.update', $project_manager->id))->open() }}
                <div class="container-fluid">
                    <div class="row ">
                        @include('project_manager.formDinamico',compact('project_manager'))
                        <div class="w-50 p-1">
                            {{html()->button('Editar')->class('btn btn-primary float-right m-t-n-xs ')}}
                        </div>
                        <div class="w-65 p-1">
                            {{html()->a('cancelar')->text('Cancelar')->href('project_manager/index')->class('btn btn-lightfloat-right m-t-n-xs border border-primary')}}
                        </div>
                    </div>
                </div>
            {{ html()->closeModelForm() }}
        </div>
    </div>
@endsection
@push('js')
@once
    <script>
    </script>
@endonce