@extends('layout')

@section('title', 'Nota Debito')
@section('breadcrumb', 'Nota Debito')
@section('breadcrumb2', 'Nota Debito')
@section('data-toggle', 'modal')
@section('href_accion', '#modal-form')
@section('value_accion', 'Agregar')

@section('content')

<div class="col-lg-12">
    <div id="modal-form" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row" align="center">
                        <!--FACTURA-->
                        <div class="col-sm-6">
                            <a href="{{route('nota-debito.create')}}"><button class="btn btn-sm btn-info" type="button" id="dropdownMenuButton" >Factura</button></a>
                        </div>
                        <!--BOLETA-->
                        <div class="col-sm-6">
                            <a href="{{route('nota-debito.create_boleta')}}"><button class="btn btn-sm btn-info" type="button" id="dropdownMenuButton" >Boleta</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>DOC</th>
                                    <th>Tipo</th>
                                    <th>Fecha emisión</th>
                                    <th>Ver</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($notas_debitos as $nota_debitos)
                                <tr class="gradeX">
                                    <td>{{$nota_debitos->id}}</td>
                                    <td>
                                        @if($nota_debitos->facturacion_id != NULL)
                                            Factura
                                        @elseif($nota_debitos->boleta_id != NULL)
                                            Boleta
                                        @elseif($nota_debitos->facturacion_m_id!=NULL)
                                            Factura Manual
                                        @else
                                            Boleta Manual
                                        @endif
                                    </td>
                                    <td>{{$nota_debitos->tipo}}</td>
                                    <td>{{$nota_debitos->fecha_emision}}</td>
                                    <td><center><a href="{{route('nota-debito.show',$nota_debitos->id)}}"><button type="button" class="btn btn-w-m btn-primary">VER</button></a></center></td>
                                    <td>
                                        <center>
                                            @if($nota_debitos->n_electronica==1)
                                                <button class="btn btn-info btn-circle btn-ls"  data-toggle="tooltip" data-placement="bottom" title="Aceptada"><i class="fa fa-check-circle"></i></button>
                                                <span hidden>Aceptada</span>
                                            @elseif($nota_debitos->n_electronica==2)
                                                <button class="btn btn-danger btn-circle btn-ls" data-toggle="tooltip" data-placement="bottom" title="Anulada"><i class="fa fa-times-circle"></i></button>
                                                <span hidden>Anulada</span>
                                            @else
                                                <button class="btn btn-warning btn-circle btn-ls" data-toggle="tooltip" data-placement="bottom" title="En Espera"><i class="fa fa-check-circle"></i></button>
                                                <span hidden>En Espera</span>
                                            @endif
                                        </center>
                                    </td>
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
            pageLength: 15,
            order: [[0, "desc"]],
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'ExampleFile'},
            {extend: 'pdf', title: 'ExampleFile'},

            {extend: 'print',
            customize: function (win){
                $(win.document.body).addClass('white-bg');
                $(win.document.body).css('font-size', '10px');

                $(win.document.body).find('table')
                .addClass('compact')
                .css('font-size', 'inherit');
            }
        }
        ]

    });

    });

</script>
@endsection
