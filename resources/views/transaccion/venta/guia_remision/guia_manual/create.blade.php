@extends('layout')

@section('title', 'Agregar Guia de Remision Manual')
@section('breadcrumb', 'Agregar Guia de Remision Manual')
@section('breadcrumb2', 'Agregar Guia de Remision Manual')

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $(".pro").keypress(function(e) {
            if (e.which == 13) {
                setTimeout(function() {
                    e.target.value += ' | ';
                }, 4);
                e.preventDefault();
            }
        });
    });
</script>
@section('content')

@include('layout_agregado_rapido')
<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o" aria-hidden="true"></i>cliente </a>
</div>
<form action="{{route('guia_remision_manual.store')}}" method="POST" enctype="multipart/form-data"  class="pro">
    @csrf
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                    <div class="row">
                        <div class="col-sm-4 text-left" align="left">
                            <address class="col-sm-4" align="left">
                                <img src="{{asset('img/logos/')}}//{{$empresa->foto}}" alt="" width="300px">
                            </address>
                        </div>
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4 ">
                            <div class="form-control ruc" style="height: 125px">
                                <center>
                                    <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                                    <h2 style="font-size: 19px">GUIA REMISION ELECTRONICA</h2>
                                    <h5 id="cod_guia">{{$codigo_guia}}</h5>
                                </center>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6" >
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Cliente:</label>
                                <div class="col-sm-10">
                                    <select class="select2_demo_client" name="cliente" id="cliente" required=""></select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Almacen:</label>
                                <div class="col-sm-10">
                                    <select class="select2_demo_almacen" name="almacen" id="almacen" required="" onchange="almacen_cod()">
                                        @foreach($almacen as $almacenes)
                                            <option value="{{$almacenes->id}}">{{$almacenes->abreviatura}} - {{$almacenes->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <label class="col-sm-2">Motivo Traslado:</label>
                                <div class="col-sm-10">
                                    <select name="motivo_traslado"  class="form-control m-b">
                                        @foreach($motivo_traslado as $motivo_traslad)
                                            <option id="{{$motivo_traslad->id}}">{{$motivo_traslad->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <label class="col-sm-2">F. Emision:</label>  
                                <div class="col-sm-4">
                                    <input type="text" style="font-size: 12px" name="fecha_emision" class="form-control" value="{{date("d/m/Y")}}" readonly="readonly">
                                </div>
                                <label class="col-sm-2">F. Entrega:</label>
                                <div class="col-sm-4">
                                    <input type="date" class="form-control" name="fecha_entrega" id="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <label class="col-sm-2">Tipo de Transporte:</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="tipo_transporte" autocomplete="off" onchange="test(this)" id="select_id">
                                        <option value="0">Sin Transporte</option>
                                        <option value="1">Transporte Público</option>
                                        <option value="2">Transaporte Privado</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" id="transporte_publico" hidden="hidden">
                            <div class="row">
                              <label class="col-sm-2">Vehiculo Público:</label>
                                <div class="col-sm-10">
                                      <select class="form-control m-b" name="vehiculo_publico" autocomplete="off" id="vehiculo_publico">
                                        <option value="">Ningún Vehículo</option>
                                        @foreach($transporte_publico as $transporte_publicos)
                                        <option value="{{$transporte_publicos->id}}">{{$transporte_publicos->nombre}} /{{$transporte_publicos->ruc}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="transporte_privado" hidden="hidden">
                        <div class="col-sm-6">
                            <div class="row">
                                <label class="col-sm-2">Vehiculo Privado:</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="vehiculo" autocomplete="off" id="vehiculo_privado">
                                        <option value="">Ningún Vehículo</option>
                                        @foreach($vehiculo as $vehiculos)
                                        <option value="{{$vehiculos->id}}">{{$vehiculos->placa}} /{{$vehiculos->marca}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <label class="col-sm-2">Conductor:</label>
                                <div class="col-sm-10">
                                    <select class="form-control m-b" name="conductor" autocomplete="off" id="conductor">
                                        <option value="">Ningún Conductor</option>
                                        <option disabled="disabled">------------------------------</option>
                                        @foreach($personal as $ersonals)
                                        <option value="{{$ersonals->id}}">{{$ersonals->nombres}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <label class="col-sm-1">Observaciones:</label>
                                <div class="col-sm-11">
                                    <textarea name="observacion" class="form-control">Guía Electrónica Emitida para el Cliente  </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="table-responsive">
                            <table cellspacing="0" class="tables table">
                                <thead>
                                    <tr>
                                        <th style="width:2em">
                                            <button type="button" class="addmore btn btn-primary" id="addmore">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </th>
                                        <th style="font-size: 13px;">Articulo</th>
                                        <th style="font-size: 13px; width:10%">Cantidad</th>
                                        <th style="font-size: 13px; width:16%">N° de Serie</th>
                                        <th style="font-size: 13px; width:11%">Peso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <button type="button" class='delete borrar e btn btn-danger'><i class="fa fa-trash" aria-hidden="true"></i></button>
                                        </td>
                                        <td>
                                            <select class="select2_demo_productos" name="articulo[]" id="articulo" style="width: 100%;" onchange="ajax(0);" required></select>
                                            <textarea class="form-control" name="descripcion[]" placeholder="Detalle del Producto" id="" rows="1" style="margin-top: 5px"></textarea>
                                        </td>
                                        <td>
                                            <input type="text" name="cantidad[]" id="cantidad" class="form-control" required onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                        </td>
                                        <td>
                                            <input type="text" name="serie[]" id="n_serie" class="form-control serie_pace" required>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" name="peso[]" step="0.01"  id="peso0" class="form-control" required onkeypress="return event.charCode >= 46 && event.charCode <= 57" onkeyup="peso_view_p(0);sum_total()">
                                                <div class="input-group-append">
                                                    <span class="input-group-addon">KG</span>
                                                </div>
                                                <input type="hidden" name="peso_view" id="peso_view0" onkeyup="sum_total()">
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="4" align="right"><span style="font-size: 0.8em">Peso Total(KGM):</span></td>
                                        <td>
                                            <input type="text" class="form-control" id="peso_total" disabled value="0">
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">

                        </div>
                        <div class="col-sm-6" align="right">
                            <button class="ladda-button btn btn-primary" type="submit" id="boton" name="boton" ></i>Guardar</button>&nbsp;
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<style>
    label.col-form-label::marker{
        list-style:none;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        font-size: 12px;
    }
    .select2-container--default .select2-selection--single {
        border: none;
    }
    span.select2.select2-container.select2-container--default{
        width: 100%!important;
        background-color: #FFFFFF;
        background-image: none;
        border-radius: 1px;
        display: block;
        padding: 3px 12px;
        border: 1px solid #e5e6e7;
    }
    .select2-hidden-accessible{
        width: auto !important;
        
    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] { -moz-appearance:textfield; }
</style>
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
<script>
    $(document).ready(function() {
        articlesSelect2();
        $('.select2_demo_almacen').select2();
    });
    
    $(".select2_demo_client").select2({
        placeholder: "Seleccionar Cliente",
        ajax: {
            minimumInputLength: 1,
            url: "{{ route('pa.clients') }}",
            dataType: 'json',
            type: "POST",
            delay: 10,
            data: function (params) {
                return {
                    _token: "{{ csrf_token() }}",
                    search: params.term // search term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.id,
                            text: item.nombre + ' | ' +  item.numero_documento,
                        };
                    })
                };
            },
            cache: true
        }
    });
    function articlesSelect2() {
        $(".select2_demo_productos").select2({
            placeholder: "Seleccionar Producto",
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('pa.ajax_remision') }}",
                dataType: 'json',
                type: "POST",
                // delay: 1500,
                data: function (params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        id: params.id,
                        search: params.term, // search term 
                        tipo_doc: 'manual'
                        
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id:  item.id + " | " + item.cod_prod + " | " + item.cod_origi + " | " + item.nombre,
                                text: item.id + " | " + item.cod_prod + " | " + item.cod_origi + " | " + item.nombre,
                            };
                        })
                    };
                },
                cache: true,
                passive: true
            }
        });
        
    }
    function ajax(a){
        if(a==0){
            var articulo = document.getElementById(`articulo`).value;
        }else{
            var articulo = document.getElementById(`articulo${a}`).value;
        }
        $.ajax({
            type: "post",
            url: "{{ route('remision_m.peso_ajax') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'articulo': articulo
            },
            success: function (msg) {
                $(`#peso${a}`).val(msg);
                sum_total();
            },
            error: function(eject) {
                if(eject.status===400){
                    console.log(eject.responseJSON.error);
                }
            },
            cache:true
        });
        
    }
    //
    var i = 2;
    $(".addmore").on('click', function () {
        var data = `[
            <tr>
                <td>
                    <button type="button" class='delete borrar e btn btn-danger'><i class="fa fa-trash" aria-hidden="true"></i></button>
                </td>
                <td>
                    <select class="select2_demo_productos" name="articulo[]" id="articulo${i}" style="width: 100%;" onchange="ajax(${i})" required></select>
                    <textarea class="form-control" name="descripcion[]" placeholder="Detalle del Producto" id="" rows="1" style="margin-top: 5px"></textarea>
                </td>
                <td>
                    <input type="text" name="cantidad[]" id="cantidad${i}" class="form-control" required onkeypress="return event.charCode >= 46 && event.charCode <= 57">
                </td>
                <td>
                    <input type="text" name="serie[]" id="n_serie${i}" class="form-control serie_pace" required>
                </td>
                <td>
                    <div class="input-group">
                        <input type="text" name="peso[]" id="peso${i}" class="form-control" required step="0.01" onkeypress="return event.charCode >= 48 && event.charCode <= 57" onkeyup="peso_view_p(${i});sum_total()" >
                        <div class="input-group-append">
                            <span class="input-group-addon">KG</span>
                        </div>
                        <input type="hidden" name="peso_view" id="peso_view${i}" onkeyup="sum_total()">
                    </div>
                </td>
            </tr>
        ]`;
        $('.tables').append(data);
        articlesSelect2();
        i++
    });
    $(document).on('click', '.borrar', function (event) {
        event.preventDefault();
        var e = document.getElementsByClassName("e").length;
        var fila = $(this).parents("tr");
        // ELIMINAR TR
        if (e>1) {
            fila.closest('tr').remove();
            $(".borrar").prop("disabled", false);
            $(".addmore").prop("disabled", false);
        }else{
            $(".borrar").prop("disabled", true);
            $(".addmore").prop("disabled", false);
        }
    });
    function test(a) {
        var x = (a.value || a.options[a.selectedIndex].value);  //crossbrowser solution =)
        if (x ==2)/*Transaporte Privado*/
        {
            document.getElementById("transporte_privado").removeAttribute("hidden");
            document.getElementById("transporte_publico").setAttribute("hidden", "hidden");

            document.getElementById("vehiculo_privado").setAttribute("required", "required");
            document.getElementById("conductor").setAttribute("required", "required");
            document.getElementById("vehiculo_publico").removeAttribute("required");

        }
        if(x==0)/*Sin Transporte*/
        {
            document.getElementById("transporte_privado").setAttribute("hidden", "hidden");
            document.getElementById("transporte_publico").setAttribute("hidden", "hidden");

            document.getElementById("vehiculo_publico").removeAttribute("required");
            document.getElementById("vehiculo_privado").removeAttribute("required");
            document.getElementById("conductor").removeAttribute("required");


        }
        if(x==1)/*Transporte Público*/
        {
            document.getElementById("transporte_publico").removeAttribute("hidden");
            document.getElementById("transporte_privado").setAttribute("hidden", "hidden");

            document.getElementById("vehiculo_publico").setAttribute("required", "required");
            document.getElementById("vehiculo_privado").removeAttribute("required");
            document.getElementById("conductor").removeAttribute("required");
        }
    }
    function almacen_cod(){
        var almacen = $('#almacen').val();
        console.log(almacen);
        $.ajax({
            type: "post",
            url: "{{ route('remision_m.almacen_remision_m') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'almacen': almacen
            },
            success: function (msg) {
                $('#cod_guia').html(msg);
            },
            error: function(eject) {
                if(eject.status===400){
                    console.log(eject.responseJSON.error);
                }
            },
            cache:true
        });
        
    }
    function peso_view_p(a){
        var peso = $(`#peso${a}`).val();
        console.log(peso);
        $(`#peso_view${a}`).val(peso);
    }
    function sum_total(){
        var total_t = 0;
        var totalInp = $('[name="peso_view"]');
        console.log(totalInp)
        // console.log(totalInp);
        totalInp.each(function(){
            if (!isNaN(parseFloat($(this).val()))) {
            total_t += parseFloat($(this).val());
            }
        });
        var tot = total_t;
        console.log(tot);
        $('#peso_total').val(tot);
        
    }
</script>
@endsection