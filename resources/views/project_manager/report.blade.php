@extends('layouts.app')
@push('css')
    {!! push_asset_once(asset('css/project_managers/gantt.css')) !!}
@endpush
@section('content')
    <x-content-app title="Lista de Proyectos" :buttons="$buttons">
        <div class="wrapper wrapper-content">
            
        </div>
</x-content-app>
@endsection
