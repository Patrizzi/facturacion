@extends('layouts.app')
@push('css')
    @once
    <link rel="stylesheet" href="{{ asset('/css/project_managers/formDinamico.css') }}">
    @endonce
@endpush 
@section('content')
<div class="btn-volver">
    {{html()->a('volver')->text('Volver')->class('btn btn-outline-primary float-right m-t-n-xs')}}
</div>
<div class="formShow">
    <div class="container-fluid">
        <div class="row ">
            @include('project_manager.formDinamico',compact('data'),['esDisabled'=>True])
        </div>
    </div>
</div>
@endsection
@push('js')
@once
    <script>
    </script>
@endonce