@extends('layouts.app')
@push('css')
    @once
    <link rel="stylesheet" href="{{ asset('/css/project_managers/formDinamico.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @endonce
@endpush
@section('content')
    <link rel="stylesheet" href="css/project_managers/form.css">

    <div class="btnVolver">
        <a href="{{route('project_managers.index')}}">Volver</a>
    </div>
    <div class="formShow">
        @include('project_manager.formDinamico',compact('data'),['esDisabled'=>True])
    </div>
@endsection
@push('js')
@once
    <script>
    </script>
@endonce