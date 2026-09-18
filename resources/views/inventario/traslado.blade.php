@extends('layout')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <!-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
    <!-- Sección de Inventario -->
    <div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-content">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs" role="tablist">
                                    @include('inventario.tabs1')
                                </ul>
                                <div class="tab-content">
                                    <!-- Contenido de Tab 1 -->
                                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                                        <div class="panel-body">
                                            <!-- ANIDAMOS MÁS TABS AQUÍ -->
                                            <div class="tabs-container">
                                                <ul class="nav nav-tabs" role="tablist">
                                                    @include('inventario.tabs2')
                                                </ul>

                                                <div class="tab-content">
                                                    <div role="tabpanel" id="contenido-tab-1" class="tab-pane ">
                                                    </div>

                                                    <div role="tabpanel" id="contenido-tab-2" class="tab-pane ">
                                                    </div>

                                                    <div role="tabpanel" id="contenido-tab-3" class="tab-pane active show">
                                                        <div class="panel-body">
                                                        <div class="row align-items-center">
                                                                <div class="col-md-10 mb-2">
                                                                <div class="input-group">
                                                                    <input type="search" id="search" class="form-control" placeholder="Buscar...">
                                                                    <div class="input-group-append">
                                                                        <button class="btn btn-primary" type="button" style="background-color: blue; border-color:blue;">Buscar</button>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                                <div class="col-md-2 mb-2 d-flex justify-content-end">
                                                                    <button class="btn btn-success mr-2" style="background-color: blue; border-color:blue;"><i class="fa fa-plus"></i></button>
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-cloud-download"></i></button>
                                                                        <div class="dropdown-menu dropdown-menu-right">
                                                                            <a class="dropdown-item" href="#">Copy</a>
                                                                            <a class="dropdown-item" href="#">CSV</a>
                                                                            <a class="dropdown-item" href="#">Excel</a>
                                                                            <a class="dropdown-item" href="#">PDF</a>
                                                                            <a class="dropdown-item" href="#">Print</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-hover text-center datatables-traslado">
                                                                    <thead>
                                                                    <tr>
                                                                        <th><input type="checkbox"  checked class="i-checks" name="input[]"></th>
                                                                        <th>ID </th>
                                                                        <th>Código</th>
                                                                        <th>Almacén - Emisor</th>
                                                                        <th>Almacén - Receptor</th>
                                                                        <th>Acciones</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody><span hidden="hidden">{{$i=0}}</span>
                                                                    @foreach($kardex_distribucion as $kardex_distribuciones)
                                                                    <tr>
                                                                        <td> {{$i=$i+1}}</td>
                                                                        <td>{{$kardex_distribuciones->codigo_guia}}</td>
                                                                        <td>{{$kardex_distribuciones->almacen_emisor->nombre}}</td>
                                                                        <td>{{$kardex_distribuciones->almacen_receptor->nombre}}</td>
                                                                        <td>
                                                                            <a href="{{ route('kardex-entrada-Traslado-almacen.show', $kardex_distribuciones->id) }}">
                                                                                <button type="button" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></button>
                                                                            </a>
                                                                                <button type="button" class="btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    
                                                    <div role="tabpanel" id="contenido-tab-4" class="tab-pane">
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- FIN DE LOS TABS ANIDADOS -->
                                        </div>
                                    </div>

                                    <!-- Contenido de Tab 2 -->
                                    <div role="tabpanel" id="tab-2" class="tab-pane"> 
                                    </div>
                                    <!-- Contenido de Tab 3 -->
                                    <div role="tabpanel" id="tab-3" class="tab-pane">
                                    </div>
                                    <!-- Contenido de Tab 4 -->
                                    <div role="tabpanel" id="tab-4" class="tab-pane">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- check -->
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('js/icheck.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });

    });

</script>

<style>
    #DataTables_Table_0_length{
        display:none;
    }
    #DataTables_Table_0_filter{
        display: none;
    }
    div.dt-buttons{
        display: none;
    }
</style>

<script>
    $(document).ready(function () {
        $('#trasladotab').addClass('active show');

        $('.datatables-traslado').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });  
    });  

    </script>

@endsection

