@extends('layout')
@section('title', 'Kardex Traslado Almacen')
@if(count($almacen) == 0)
    @section('value_accion', '#')
    @section('href_accion', '#')
@else
    @section('data-toggle', 'modal')
    {{-- @section('href_accion', '#CreateTraslado')<!-- #Modal_Select_Almacen --> --}}
    @section('href_accion', '#Modal_Select_Almacen')<!-- #Modal_Select_Almacen -->
    @section('value_accion', 'Agregar')
@endif
@section('content')

{{-- modal redireccion --}}
<div class="modal fade" id="Modal_Select_Almacen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" >
        <div class="modal-content" >
            <div>
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center" onsubmit="return valida(this)">
                    <form action="{{route('kardex-entrada-Traslado-almacen.create')}}"  enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group  row">
                            <div class="col-sm-12" style="padding-bottom: 15px"><img src="{{ asset('/archivos/imagenes/kardex_img/2795451.svg')}}" width="150px"></div>
                                <label class="col-sm-4 col-form-label">Almacen Emisor:</label>
                                <div class="col-sm-6">
                                    <select class="form-control" name="almacen" id="select">
                                        @foreach($almacen as $almacenes)
                                        <option value="{{$almacenes->id}}">{{$almacenes->nombre}}  </option>
                                </div>
                                    @endforeach
                                    </select>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit" name="action" id="boton">Ir</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Agregar Traslado - 29/05/2025-->
<div id="CreateTraslado" class="modal fade" style="display: none;" aria-modal="true" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="TituloProducto">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex align-items-center">
                <h2 class="model-title" id="TituloProducto"><b>KARDEX TRASLADO ALMACÉN</b></h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h2>{{date('d/m/Y')}}</h2>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="" class="col-form-label col-lg-3">Motivo</label>
                            <div class="col-lg-9">
                                <select name="" id="" class="form-control">
                                    <option value="">Selecciona motivo</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="" class="col-form-label col-lg-3">Proveedor</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="" class="col-form-label col-lg-3">N°Factura</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="" class="col-form-label col-lg-3">G.Remisión</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="" class="col-form-label col-lg-3">Transporte</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="" class="col-form-label col-lg-3">Información</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="" class="col-form-label col-lg-3">Categoría</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="" class="col-form-label col-lg-3">Moneda</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="" class="col-form-label col-lg-3">F.Compra</label>
                            <div class="col-lg-9">
                                <input type="date" class="form-control" value="2025-05-29" >
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="" class="col-form-label col-lg-3">Activo</label>
                            <div class="col-lg-9">
                                <input type="text" class="form-control" value="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Fin Agregar Traslado - 29/05/2025-->


<div class="wrapper wrapper-content animated fadeInRight">
    @if (session('repite'))
    <div class="alert alert-danger">
        {{ session('repite') }}
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist" style="align-items: center;">
                            @include('inventario.kardex.entrada.entrada_producto.shared.tabs')
                            <ul class="ml-auto d-flex" style="gap: 10px; align-items: center;">
                                <button class="btn btn-sm btn-primary" id="openUploadModal">
                                    <i class="fa fa-upload text-secondary"
                                        style="cursor: pointer;color: white !important"></i>
                                </button>
                                <div class="btn btn-sm btn-primary dropdown" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    <i class="fa fa-download text-secondary"
                                            style="cursor: pointer;color: white !important"></i>

                                    <div class="dropdown-menu dropdown-menu-right">
                                        <button class="dropdown-item" onclick="exportarTodo(event)"
                                            style="width: 100%;">
                                                <i class="fa fa-file-excel mr-2"></i>
                                                Exportar Todo
                                        </button>
                                        <button class="dropdown-item" id="exportSelected" style="width: 100%;">
                                                <i class="fa fa-file-pdf mr-2"></i>
                                                Exportar Selecionados
                                        </button>
                                    </div>
                                </div>

                                {{-- forms ocultos exportar productos --}}
                                <form id="formExportProdAll" action="{{ route('export.excel') }}" method="GET"
                                        style="display: none;">
                                </form>

                               <button
                                    class="btn btn-sm btn-primary"
                                    data-toggle="modal"
                                    data-target="#Modal_Select_Almacen"
                                >
                                   <i class="fa fa-plus"></i>
                                </button>
                            </ul>
                        </ul>
                        <div class="tabs-content">
                            <div class="tab-pane active show" id="tab-1">
                                <br>
                                <div class="search-responsive" style="padding-right: 15px;padding-left: 15px;">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 col-sm-12">
                                            <div class="input-group">
                                                <input class="form-control" type="text" name="daterange"
                                                        id="data_range_filter" value="" readonly="readonly" />
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-secondary" id="revert_select">
                                                            <i class="fa fa-history"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        {{-- <div class="col-lg-3 col-md-6 col-sm-12">
                                            <select class="form-control" name="" id="estado_anular">
                                                <option value="" selected>Todos los servicios</option>
                                                <option value="0">Activos</option>
                                                <option value="1">Anulados</option>
                                            </select>
                                        </div> --}}
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <input type="search" class="form-control" placeholder="Buscar:"
                                                    id="search_all_column">
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-sm-12">
                                            <button type="button" class="btn btn-block btn-primary"
                                                    id="filter_buttons">Buscar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover dataTables-example" >
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Codigo</th>
                                                <th>Almacen Emisor</th>
                                                <th>Almacen Receptor</th>
                                                <th>Ver</th>
                                                <th>Anular</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <span hidden="hidden">
                                                {{$i=0}}
                                            </span>
                                                @foreach($kardex_distribucion as $kardex_distribuciones)
                                                    <tr class="gradeX">
                                                        <td> {{$i=$i+1}}</td>
                                                        <td>{{$kardex_distribuciones->codigo_guia}}</td>
                                                        <td>{{$kardex_distribuciones->almacen_emisor->nombre}}</td>
                                                        <td>{{$kardex_distribuciones->almacen_receptor->nombre}}</td>
                                                        <td><a href="{{ route('kardex-entrada-Traslado-almacen.show', $kardex_distribuciones->id) }}"><button type="button" class="btn btn-s-m btn-info">VER</button></a></td>
                                                        <td><button class="btn btn-secondary">Anular</button></td>
                                                    </tr>
                                                @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.table {
    width: 100% !important;
}

.nav-link.active,
.nav.nav-tabs>.nav-custom {
    /* border-bottom: none; */
}

.tab-pane.active.show {
    border-right: 1px solid #e7eaec;
    border-left: 1px solid #e7eaec;
    border-bottom: 1px solid #e7eaec;
}

.pie-md {
    max-width: 17%; /*270*/
    max-height: 50%; /*400*/
}

div.dataTables_length {
    display: none;
}

/* El Buscar */
div.dataTables_filter {
    display: none;
}

/* CSV, Excel, PDF, Print */
div.dt-buttons {
    display: none;
}

/* Tamaño de los botones del index */
.tam {
    min-width: 150px;
    min-height: 150px;
}

input#fotoIntupEdit,
input#archivoInputCreate {
    position: absolute;
    top: 0px;
    left: 0px;
    right: 0px;
    bottom: 0px;
    width: 100%;
    /*height:100%;*/
    opacity: 0;
    padding: 30px;
}

#visorArchivoEdit,
#visorArchivoCreate {
    width: 100%;
    height: auto;
    min-height: 250px;
    padding: 10px;
    background-color: #f8f9fa;
    border: 2px solid #ced4da;
    border-radius: 6px;
    overflow: hidden;
    display: flex;
    justify-content: center;
    align-items: center;
}

#visorArchivoEdit img[name="foto"],
#visorArchivoCreate img[name="foto"] {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: transform 0.3s ease-in-out;
}

.btn-circle {
    width: 25px;
    height: 25px;
    padding: 3px 0;
}

.icon-estado {
    text-align: center;
}
</style>

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [{
                customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
                }
            }]
        });

        $('#tab-1').addClass('active');
        $('.scroll_content').slimscroll({
            height: '450px'
        });
    });

</script>
@endsection
