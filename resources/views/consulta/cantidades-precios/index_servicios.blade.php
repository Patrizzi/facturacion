@extends('layout')
@section('title', 'Consulta de Servicios')
@section('atributo_actu', 'hidden')
@section('atributo_1', 'hidden')
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
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
<script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>


<script>
    $(document).ready(function() {

        $('.footable').footable();
        $('.footable3').footable();

    });

</script>
@endsection