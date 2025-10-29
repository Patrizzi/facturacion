@extends('layout')


@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">
        
        {{-- RESUMEN (si lo necesitas) --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h4>Resumen de {{ Str::ucfirst(Carbon\Carbon::now()->translatedFormat('F Y')) }}</h4>
                    </div>
                    <div class="ibox-content">
                        {{-- Tu resumen aquí --}}
                    </div>
                </div>
            </div>
        </div>

        {{-- TABS Y CONTENIDO --}}
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-content">
                        
                        {{-- TABS --}}
                        <ul class="nav nav-tabs" role="tablist">
                            @include('transaccion\venta\_shared\tabs')
                        </ul>

                        {{-- CONTENIDO DE LOS TABS --}}
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active">
                                <br>
                                {{-- Aquí va tu contenido --}}
                                <div class="table-responsive">
                                    <table class="table">
                                        {{-- Tu tabla --}}
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS AL FINAL --}}
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

@endsection
