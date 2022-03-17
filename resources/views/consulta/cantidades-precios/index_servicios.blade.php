@extends('layout')
@section('title', 'Consulta de Servicios')
@section('breadcrumb', 'Consulta de Servicios')
@section('breadcrumb2', 'Consulta de Servicios')

@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Cantidades y Precios de Servicios</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-wrench"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="#" class="dropdown-item">Config option 1</a>
                            </li>
                            <li><a href="#" class="dropdown-item">Config option 2</a>
                            </li>
                        </ul>
                        <a class="close-link">
                            <i class="fa fa-times"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <input type="text" class="form-control form-control-sm m-b-xs" id="filter"
                        placeholder="Buscar">
                        <table class="footable table table-stripped toggle-arrow-tiny" data-page-size="25" data-filter=#filter>
                            <thead>
                                <tr>
                                    <th data-toggle="true">Id</th>
                                    <th>Nombre del Servicio</th>
                                    <th>Codigo Orig.</th>
                                    <th>Precio Nac. Venta</th>
                                    <th>/I.G.V</th>
                                    <th>Precio Ex. Venta</th>
                                    <th>/I.G.V</th>
                                    <th data-hide="all" >Codigo Serv.</th>
                                    <th data-hide="all">Descripcion</th>
                                    <th data-hide="all">Marca</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($servicio as $index => $servicios)
                                @if($servicio_count == 0 )

                                @else
                                <tr class="gradeX">
                                    <td>{{$id_t1++}}</td>
                                    <td>
                                        <a href="{{ route('servicios.show', $servicios->id) }}" target="_blank">
                                            {{$servicios->nombre}}
                                        </a>
                                    </td>
                                    <td >{{$servicios->codigo_original}}</td>
                                    <td>{{$moneda_nacional->simbolo}}. {{$precio_nacional[$index] }}</td>
                                    <td>{{$moneda_nacional->simbolo}}. {{round($precio_nacional[$index] + ($precio_nacional[$index] * ($igv->igv_total/100)),2)}}</td>
                                    <td>{{$moneda_extranjera->simbolo}}. {{$precio_extranjero[$index] }}</td>
                                    <td>{{$moneda_extranjera->simbolo}}. {{round($precio_extranjero[$index] + ($precio_extranjero[$index] * ($igv->igv_total/100)),2)}}</td>
                                    <td>{{$servicios->codigo_servicio}}</td>
                                    <td>{{$servicios->descripcion}} </td>
                                    <td>{{$servicios->marca->nombre}}</td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="7">
                                        <ul class="pagination float-right"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .footable > thead > tr > th.null > span.footable-sort-indicator{
        display: none;
        padding: 0px 0px 0px 0px;
    }
    .table-responsive{
        display: revert;
    }
    .form-table-input {
    background-image: none;
    border: 1px solid #e5e6e7;
    border-radius: 5px;
    background-color: #FFFFFF;
    color: inherit;
    /*display: block;*/
    padding: 3px 6px;
    transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
    width: 100px;
    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
    }

    input[type=number] { -moz-appearance:textfield; }
</style>
<!-- Mainly scripts -->

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- Page-Level Scripts -->
<script>
    function myFunction() {
        var element = document.getElementById("null footable-sortable");
        element.classList.remove("null footable-sort-indicator");
    }
    function mostrar_check() {
        var arr = $('[name="producto_id[]"]:checked').map(function(){
          return this.value;
        }).get();
        if(arr.length == 0){
            $('#miBoton').hide();
            $('input[type=number]').attr('disabled','true');
            $('input[type=number]').val('');
        }else{

            for (var i = 0 ; i < arr.length; i++) {
                $('#miBoton').show();
                $('#nuevo_stock'+arr[i]).prop('disabled', false);
            };

        }
        var arr2 = $('[name="producto_id[]"]:not(:checked)').map(function(){
          return this.value;
        }).get();
        // console.log(arr2);
        if(arr2.length == 0){
            // $('#miBoton').hide();
            // $('input[type=number]').attr('disabled','true');
            // $('input[type=number]').val('');
        }else{
            for (var i = 0 ; i < arr2.length; i++) {
                // $('#miBoton').hide();
                $('#nuevo_stock'+arr2[i]).prop('disabled', true);
                $('#nuevo_stock'+arr2[i]).prop('value', '');
            };

        }
    }
    function display_check(){
        //Siempre que salgamos de un campo de texto, se chequeará esta función
        // $('#filter2').keyup(function() {
             if($('#filter2').val().length > 0) {
                $('#select_all_cheak').attr('disabled', true);
            }else{
                $('#select_all_cheak').attr('disabled', false);
            }

        // });

    };

</script>
<script>
    $(document).ready(function(){
        $('.dataTables-example').DataTable({
            pageLength: 25,
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
<script>
    $(document).ready(function() {

        $('.footable').footable();
        $('.footable3').footable();

    });

</script>
<script>
        $(document).ready(function () {
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });
</script>
<script>
    function select_all() {
        $('input[class=case]:checkbox').each(function () {
            if ($('input[class=check_all]:checkbox:checked').length == 0) {
                $(this).prop("checked", false);
            } else {
                $(this).prop("checked", true);
            }

            var elementos = $('input.check_all');
            var algunoMarcado = elementos.toArray().find(function(elemento) {
             return $(elemento).prop('checked');
            });

          if(algunoMarcado) {
            $('#miBoton').show();
          } else {
            $('#miBoton').hide();
          }

          var arr = $('[name="producto_id[]"]:checked').map(function(){
            return this.value;
            }).get();
            if(arr.length == 0){
                $('#miBoton').hide();
                $('input[type=number]').attr('disabled',true);
                $('input[type=number]').val('');
            }else{
                for (var i = 0 ; i < arr.length; i++) {
                    $('#miBoton').show();
                    $('#nuevo_stock'+arr[i]).prop('disabled', false);
                };
            }
        });


    }
</script>

@endsection