@extends('layouts.app')
@push('css')
    @once
    <link rel="stylesheet" href="{{ asset('/css/project_managers/formDinamico.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @endonce
@endpush
@section('content')
    <form action="{{route('project_managers.store')}}" class="formEnvio" method="POST">
        @csrf
            @include('project_manager.formDinamico')

            <div class="btnEnvioForm">
                <button type="submit">Crear</button>
            </div>
            <div class="btnCancelar">
                <a href="{{route('project_managers.index')}}">Cancelar</a>
            </div>
    </form>
@endsection
@push('js')
@once
    <script>
    </script>
@endonce