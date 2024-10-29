@extends('layouts.app')
@push('css')
    {!! push_asset_once(['css/project_managers/project_managers.css']) !!}
@endpush
@section('content')
    <x-content-app title="Lista de proyectos" :buttons="$buttons">
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="tabs-container">
                <ul class="nav nav-tabs" role="tablist">
                    <li><a class="nav-link " href="{{ route('project_managers.index') }}">Proyectos</a></li>
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Actividades</a></li>
                    <li><a class="nav-link" data-toggle="tab"
                            href="#tab-2">Tarjetas</a></li>
                    <li><a class="nav-link" data-toggle="tab"
                            href="#tab-3">Reporte</a></li>
                </ul>
                <div class="modals">
                    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">

                        </div>
                    </div>
                    <div class="modal fade" id="chatModal" tabindex="-1" role="dialog" aria-labelledby="chatModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">

                        </div>
                    </div>
                </div>
                <div class="tab-content">
                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            @if ($activities->isNotEmpty())
                                <x-project-manager.gantt-activities-view :collection="$activities" type="manyActivities" />
                            @else
                                <h5>No hay actividades en este proyecto.</h5>
                            @endif
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-2" class="tab-pane">
                        <div class="panel-body">
                            @if ($activities->isNotEmpty())
                                <x-project-manager.card-activities-view :collection="$activities" />
                            @else
                            <h5>No hay Tarjetas en este proyecto.</h5>
                            @endif
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-3" class="tab-pane">
                        <div class="panel-body">
                            @if ($activities->isNotEmpty())
                                <x-project-manager.report-activities-view :pagActivities="$activities" :allActivities="$allActivities" />
                            @else
                                <h5>No hay actividades para generar el reporte.</h5>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-content-app>
@endsection
@push('js')
    @once
        <script>
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}");
                @endforeach
            @endif

            var lastUrls = {};
            $('[data-toggle="modal"]').on('click', function(event) {
                event.preventDefault();

                var button = $(this);
                var modalTarget = button.data('target');
                var url = button.data('url');
                var modal = $(modalTarget);

                var currentModal = button.closest('.modal');

                if (currentModal.length > 0) {
                    currentModal.modal('hide');
                }

                if (url !== lastUrls[modalTarget]) {
                    modal.find('.modal-dialog').load(url, function() {
                        lastUrls[modalTarget] = url;
                        modal.modal('show');
                    });
                } else {
                    modal.modal('show');
                }
            });

            // Mostrar confirmación del delete
            function deleteItem(id) {
                const form = document.getElementById(`delete-item-form-${id}`);

                swal({
                    title: '¿Estás seguro?',
                    text: "Esta acción no se puede deshacer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, borrar',
                    cancelButtonText: 'Cancelar'},
                    function (isConfirm) {
                        if (isConfirm) {
                            form.submit();
                        }
                    }
                );
            }
        </script>
    @endonce
@endpush