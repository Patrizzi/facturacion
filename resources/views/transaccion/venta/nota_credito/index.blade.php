@extends('layout')

@section('title', 'Nota Credito')
@section('breadcrumb', 'Nota Credito')
@section('breadcrumb2', 'Nota Credito')
@section('data-toggle', 'modal')
@section('href_accion', '#modal-form')
@section('value_accion', 'Agregar')

@section('content')
@if($errors->any())
<div style="padding-top: 20px;">
    <div class="alert alert-danger">
        <a class="alert-link" href="#">
            @foreach ($errors->all() as $error)
            <li style="color: red">{{ $error }}</li>
            @endforeach
        </a>
    </div>
</div>
@endif
<div class="col-lg-12">
    <div id="modal-form" class="modal fade" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row" align="center">
                        <!--FACTURA-->
                        <div class="col-sm-6">
                            <a href="{{route('nota-credito.create')}}"><button class="btn btn-sm btn-info" type="button" id="dropdownMenuButton" >Factura</button></a> 
                        </div>
                        <!--BOLETA-->
                        <div class="col-sm-6">
                            <a href="{{route('nota-credito.create_boleta')}}"><button class="btn btn-sm btn-info" type="button" id="dropdownMenuButton" >Boleta</button></a>
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
                                    <th>Nota de Credito</th>
                                    <th>N° de Doc.</th>
                                    <th>Documento</th>
                                    <th>Cliente</th>
                                    <th>Fecha emision</th>
                                    <th>Ver</th>
                                    <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
                                    <th> Anular</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($notas_creditos as $nota_credito)
                                <tr class="gradeX tooltip-demo">
                                    <td>{{$nota_credito->id}}</td>
                                    <td>{{$nota_credito->codigo_n_c}}</td>
                                    @if($nota_credito->facturacion_id !=NULL)
                                        <td>{{$nota_credito->nota_i_facturacion->codigo_fac}}</td> 
                                        <td>Factura</td>
                                        <td>{{$nota_credito->nota_i_facturacion->cliente->nombre}}</td>
                                    @elseif($nota_credito->boleta_id !=NULL)
                                        <td>{{$nota_credito->nota_i_boleta->codigo_boleta}}</td> 
                                        <td>Boleta</td>
                                        <td>{{$nota_credito->nota_i_boleta->cliente->nombre}}</td>
                                    @elseif($nota_credito->boleta_m_id !=NULL)
                                        <td>{{$nota_credito->nota_i_boleta_manual->codigo_boleta}}</td> 
                                        <td>Boleta Manual</td>
                                        <td>{{$nota_credito->nota_i_boleta_manual->cliente->nombre}}</td>
                                    @else
                                        <td>{{$nota_credito->nota_i_fac_manual->codigo_fac}}</td> 
                                        <td>Factura Manual</td>
                                        <td>{{$nota_credito->nota_i_fac_manual->cliente->nombre}}</td>
                                    @endif
                                    {{-- <td>{{$nota_credito->cliente->id}}</td> --}}
                                    @if(isset($nota_credito->fecha_emision))
                                        <td>{{$nota_credito->fecha_emision}}</td>
                                    @else
                                        <td>{{$nota_credito->created_at}}</td>
                                    @endif
                                    <td>
                                        <a href="{{route('nota-credito.show',$nota_credito->id)}}"><button type="button" class="btn btn-w-m btn-primary">VER</button></a>
                                    </td>
                                    <td style="text-align:center;">
                                        @if($nota_credito->n_electronica==1) <!-- Nombre del cliente -->
                                            <button class="btn btn-info btn-circle btn-ls"  data-toggle="tooltip" data-placement="bottom" title="Aceptada"><i class="fa fa-check-circle"></i></button>
                                            <span hidden>Aceptada</span>
                                        @elseif($nota_credito->n_electronica==2)
                                            <button class="btn btn-danger btn-circle btn-ls" data-toggle="tooltip" data-placement="bottom" title="Anulada"><i class="fa fa-times-circle"></i></button>
                                            <span hidden>Anulada</span>
                                        @else
                                            <button class="btn btn-warning btn-circle btn-ls" data-toggle="tooltip" data-placement="bottom" title="En Espera"><i class="fa fa-check-circle"></i></button>
                                            <span hidden>En Espera</span>
                                        @endif
                                    </td>
                                    <td>
                                        <center>
                                            @if ($nota_credito->n_electronica == 0)
                                                {{-- <form action="{{route('nota_credito.anular')}}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id_nota_cre" value="{{$nota_credito->id}}">
                                                    <button class="btn btn-danger" type="submit">Anular</button>
                                                </form> --}}
                                                <button value="{{$nota_credito->codigo_n_c}}"  onclick="anular_nota(this.value, '{{$nota_credito->id}}' )" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCenter" >Anular</button>
                                            @else
                                                <button class="btn btn-secondary disabled" type="button"  data-toggle="tooltip" data-placement="bottom" title="Solo se puede Anular los pendientes a Enviar" >
                                                    <i class="fa fa-trash"></i>
                                                    {{-- Anular  --}}
                                                </button>
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
{{-- MODAL DE ANULACION DE NOTA DE CREDITO --}}
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    <form action="{{route('nota_credito.anular')}}" method="POST">
                        @csrf
                        <center>
                            <p>¿Desea Anular la Nota de credito N°<strong> <span id="strong_nota"> </span></strong> anidada al documento N° <strong><span id="string_doc"></span></strong>?</p>
                            <input type="hidden" name="id_nota_cre" value="" id="nota_credito_id">
                            <button class="btn btn-danger" type="submit">Anular</button>
                        </center>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
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

<!-- Jquery Validate -->
<script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>

<!-- Steps -->
<script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<!-- Page-Level Scripts -->
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
            responsive: true,
            order: [[0, "desc"]],
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'ExampleFile'},
                {extend: 'pdf', title: 'ExampleFile'},

                {extend: 'print', customize: function (win){
                    $(win.document.body).addClass('white-bg');
                    $(win.document.body).css('font-size', '10px');

                    $(win.document.body).find('table')
                    .addClass('compact')
                    .css('font-size', 'inherit');
                }}
            ]

        });
    });
    function anular_nota(a1,id){
        console.log(a1);
        // $('#strong_nota').val(strong_nota);
        var val = a1;
        document.getElementById("strong_nota").innerHTML=a1;
        $('#nota_credito_id').val(id);


        // document.getElementById.value 
        // console.log(codigo_n_c);
        $('#exampleModalCenter').modal('show');
    }

</script>
@endsection
