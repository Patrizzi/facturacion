@extends('layout')

@section('title', 'Nota Credito Devolucion por Item')
@section('breadcrumb', 'Nota Credito Devolucion por Item')
@section('breadcrumb2', 'Nota Credito Devolucion por Item')
@section('href_accion', route('nota-credito.index'))
@section('value_accion', 'atras')

@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12" style="margin-top: -5px;">
            <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                <div class="row">
                    <div class="col-sm-4 text-left" align="left">
                        <address class="col-sm-4" align="left">
                            <img src="{{asset('img/logos/')}}/{{$empresa->foto}}" alt="" width="300px">
                        </address>
                    </div>
                    <div class="col-sm-4">
                    </div>
                    <div class="col-sm-4 ">
                        <div class="form-control ruc" style="height: 125px">
                            <center>
                                <h3 style="padding-top:10px ">R.U.C : {{$empresa->ruc}}</h3>
                                <h2>NOTA DE CREDITO</h2>
                                {{-- <h5> {{$boleta->codigo_fac}}</h5> --}}
                            </center>
                        </div>
                    </div>
                </div><br>
                <form action="{{route('nota-credito.store_boleta',$boleta->id)}}"  enctype="multipart/form-data" method="post" >
                    @csrf
                    <input type="hidden" name="tipo" value="{{$tipo}}">
                    <div class="row" align="center" style="padding-bottom: 5px">
                        <div class="col-sm-6" align="center">
                            <div class="form-control">
                                <h3> Datos Generales</h3>
                                <div align="left">
                                    <strong>Cliente:</strong>
                                    @if(isset($boleta->cliente_id)){{$boleta->cliente->nombre}}
                                    @else{{$boleta->cotizacion->cliente->nombre}}
                                    @endif <br>
                                    <strong>D.N.I:</strong>
                                    @if(isset($boleta->cliente_id)){{$boleta->cliente->numero_documento}}
                                    @else{{$boleta->cotizacion->cliente->numero_documento}}
                                    @endif <br>
                                    <strong>Direccion:</strong>
                                    @if(isset($boleta->cliente_id)){{$boleta->cliente->direccion}}
                                    @else{{$boleta->cotizacion->cliente->direccion}}
                                    @endif <br>
                                    <strong>Condiciones de Pago:</strong>
                                    @if(isset($boleta->cliente_id)){{$boleta->forma_pago->nombre }}
                                    @else{{$boleta->cotizacion->forma_pago->nombre }}
                                    @endif  <br>
                                    <strong>Tipo de Moneda:</strong>
                                    @if(isset($boleta->cliente_id)){{$boleta->moneda->nombre }}
                                    @else{{$boleta->cotizacion->moneda->nombre }}
                                    @endif <br>

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" align="center">
                            <div class="form-control" >
                                <h3>Condiciones Generales</h3>
                                <div align="left">
                                    <strong>Orden de Compra:</strong>
                                    {{$boleta->orden_compra}} <br>
                                    <strong>Guia de Remision:</strong>
                                    {{$boleta->guia_remision}} <br>
                                    <strong>Fecha Emision:</strong>
                                    {{$fecha_emision}} <br>
                                    <input type="hidden" name="fecha_emision" id="fecha_emision" value="{{$fecha_emision}}">
                                    <strong>Fecha de Vencimiento:</strong>
                                    {{$fecha_emision}}  <br>

                                    <strong>Tipo de nota de credito:</strong>
                                    <input required="required" class="form-control" type="text" id="motivo" name="motivo" value="{{$tipo_nota_credito}}" readonly style="display: none">
                                    Devolucion por Item <br>

                                    <strong>Motivo o Sustento:</strong>
                                    <input required="required" class="form-control" type="text" id="sustento" name="sustento" value="{{$sustento}}" readonly style="display: none">
                                    {{$sustento}} <br>
                                
                                    <strong>Número de la Nueva boleta Electrónica:</strong>
                                    <input required="required" class="form-control" type="text" id="nueva_boleta" name="nueva_boleta" value="{{$nueva_boleta}}" readonly style="display: none">
                                    {{$nueva_boleta}} <br>
                                
                                    <strong>Descuento Global:</strong>
                                    <input required="required" class="form-control" type="text" id="descuento_global" name="descuento_global" value="{{$descuento_global}}" readonly style="display: none">
                                    {{$descuento_global}} <br>
                                        

                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" align="center">
                            <div class="form-control" style="border: none;height: auto" >
                                <div align="left">
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="table-responsive">  
                        <table class="table ">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>Codigo Producto</th>

                                        {{-- <th style="width:30px">Cantidad Nueva</th> --}}
                                        <th>item</th>
                                        <th style="width:30px">Cantidad</th>
                                        <th>Precio unitario</th>
                                        {{-- <th >Nuevo Precio</th> --}}
                                        {{-- <th >Nuevo Descuento</th> --}}
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <span hidden="hidden">{{ $u = 0 }} </span>
                                    {{-- <tr> --}}
                                    @foreach ($boleta_registro as $e => $boleta_registros)
                                        <tr>
                                            <td>
                                                <button class="btn e btn-danger delete_item" type="button"><i
                                                        class="fa fa-trash"></i></button>
                                            </td>
                                            <td>{{ $u++ }}</td>
                                            @if (isset($boleta_registros->producto_id))
                                                <td>{{ $boleta_registros->producto->codigo_producto }}
                                                    <input type="hidden" name="tipo_afec[]"
                                                        id="tipo_afec{{ $e }}"
                                                        value="{{ $boleta_registros->producto->tipo_afec_i_producto->informacion }}">
                                                    <input type="hidden" name="tipo_item[]"
                                                        value="producto | {{ $boleta_registros->producto_id }}">
                                                    <input hidden="hidden" class="celda">
                                                </td>
                                            @elseif(isset($boleta_registros->servicio_id))
                                                <td>{{ $boleta_registros->servicio->codigo_servicio }}
                                                    <input type="hidden" name="tipo_afec[]"
                                                        id="tipo_afec{{ $e }}"
                                                        value="{{ $boleta_registros->servicio->tipo_afec_i_serv->informacion }}">
                                                    <input type="hidden" name="tipo_item[]"
                                                        value="servicio | {{ $boleta_registros->servicio_id }}">
                                                    <input hidden="hidden" class="celda">
                                                </td>
                                            @endif

                                            <td>
                                                @if (isset($boleta_registros->producto_id))
                                                    <input required="required" class="form-control" type="text"
                                                        id="input_descripcion_{{ $e }}"
                                                        name="input_descripcion[]"
                                                        value="{{ $boleta_registros->producto->nombre }}" hidden>
                                                    <p>{{ $boleta_registros->producto->nombre }}</p>
                                                    {{-- Cambiar po select2 --}}
                                                @elseif(isset($boleta_registros->servicio_id))
                                                    <input required="required" class="form-control" type="text"
                                                        id="input_descripcion_{{ $e }}"
                                                        name="input_descripcion[]"
                                                        value="{{ $boleta_registros->servicio->nombre }}" hidden>
                                                    <p>{{ $boleta_registros->servicio->nombre }}</p>
                                                    {{-- Cambiar po select2 --}}
                                                @endif
                                            </td>
                                            {{-- <td>{{$boleta_registros->cantidad}}</td> Cantidad --}}
                                            <td><input required="required" class="form-control" type="number"
                                                    id="input_cantidad_{{ $e }}" name="input_cant[]"
                                                    value="{{ $boleta_registros->cantidad }}"
                                                    max="{{ $boleta_registros->cantidad }}"
                                                    onkeyup="multi({{ $e }})"></td>
                                            {{-- Cantidad Nueva --}}
                                            @if ($tipo == 'boleta_origi')
                                                <td><input class="form-control"
                                                        value="{{ $boleta_registros->precio_unitario_comi }}"
                                                        type="text" id="input_precio_{{ $e }}"
                                                        max="{{ $boleta_registros->precio_unitario_comi }}"
                                                        onkeyup="multi({{ $e }})" name="input_precio[]"></td>
                                                {{-- Precio TOTAL --}}
                                                <td><input required="required" class="form-control" type="text"
                                                        id="input_precio_tot_{{ $e }}" name="input_precio_tot"
                                                        value="{{ $boleta_registros->precio_unitario_comi * $boleta_registros->cantidad }}"
                                                        readonly
                                                        max="{{ $boleta_registros->precio_unitario_comi * $boleta_registros->cantidad }}"
                                                        onkeyup="multi({{ $e }})">
                                                    <input type="text" id="afectacion_{{ $e }}"
                                                        name="afectacion" class="form-control" hidden="" required
                                                        autocomplete="off"
                                                        value="{{ $boleta_registros->precio_unitario_comi * $boleta_registros->cantidad }}" />
                                                </td>
                                            @else
                                                <td><input type="text" class="form-control"
                                                        value="{{ $boleta_registros->precio }}"
                                                        max="{{ $boleta_registros->precio }}"
                                                        id="input_precio_{{ $e }}" name="input_precio[]" onkeyup="multi({{ $e }})"></td>
                                                {{-- Precio TOTAL --}}
                                                <td><input required="required" class="form-control" type="text"
                                                        id="input_precio_tot_{{ $e }}" name="input_precio_tot"
                                                        value="{{ $boleta_registros->precio * $boleta_registros->cantidad }}"
                                                        max="{{ $boleta_registros->precio * $boleta_registros->cantidad }}"
                                                        readonly onkeyup="multi({{ $e }})">
                                                    <input type="text" id="afectacion_{{ $e }}"
                                                        name="afectacion" class="form-control" hidden="" required
                                                        autocomplete="off"
                                                        value="{{ $boleta_registros->precio * $boleta_registros->cantidad }}" />
                                                </td>
                                            @endif
                                            <td style="display: none">
                                                {{$sub_total=($boleta_registros->boleta_i->op_gravada)+($boleta_registros->boleta_i->op_inafecta)+($boleta_registros->boleta_i->op_exonerada)}}
                                                {{$sub_total_gravado=($boleta_registros->boleta_i->op_gravada)}}
                                                {{$igv_p=round($sub_total_gravado, 2)*$igv->igv_total/100}}
                                                {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tbody>
                                    <tr style="background-color: #f5f5f500;" align="center">
                                        <td colspan="5"></td>
                                        <td>Subtotal :</td>
                                        <td colspan="">
                                            @if ($tipo == 'boleta_origi')
                                                <input id='sub_total' disabled="disabled" class="form-control" required
                                                    value="{{ $sub_total }}" />
                                                <input id='subtotal_gravado' disabled="disabled" hidden=""
                                                    class="form-control" required />
                                            @else
                                                <input id='sub_total' disabled="disabled" class="form-control" required
                                                    value="{{ $sub_total }}" />
                                                <input id='subtotal_gravado' disabled="disabled" hidden=""
                                                    class="form-control" required />
                                            @endif
                                            <input id='subtotal_gravado' disabled="disabled" hidden=""
                                                class="form-control" required />
                                        </td>
                                    </tr>
                                    <tr style="background-color: #f5f5f500;" align="center">
                                        <td colspan="5"></td>
                                        <td>IGV :</td>
                                        <td colspan=""><input id='igv' disabled="disabled"
                                                class="form-control" required value="{{ round($igv_p, 2) }}" />
                                        </td>
                                    </tr>
                                    <tr align="center">
                                        <td colspan="5"></td>
                                        <td>Total :</td>
                                        <td colspan=""><input id='total_final' disabled="disabled"
                                                class="form-control" required value="{{ round($end, 2) }}" /></td>
                                    </tr>
                                </tbody>
                            </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <button type="submit" class="btn btn-w-m btn-primary">Guardar</button>
                        </div>
                    </div>
                    <br><br><br><br>
                </form>
            </div>
        </div>
    </div>
</div>
<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
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
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

<script>
    // var estado = 1;
    // $('.select2').select2();

    // function change_variables(val) {
    //     var cantidad = $(`#input_cantidad_` + val).val();
    //     var precio = $(`#input_precio_` + val).val();
    //     console.log(cantidad)
    // }

    function multi(a) {
        var total = 1;
        var totales = 0;
        var change = false; //
        // $(`.monto${a}`).each(function() {
        //     if (!isNaN(parseFloat($(this).val()))) {
        //         change = true;
        //         total *= parseFloat($(this).val());
        //     }
        // });
        // total = (change) ? total : 0;

        var cantidad = document.querySelector(`#input_cantidad_${a}`).value;
        var precio = document.querySelector(`#input_precio_${a}`).value;
        var afec = document.querySelector(`#tipo_afec${a}`).value;
        var multiplier = 100;
        var igv_valor = {{ $igv->renta }};

        var end = parseFloat(precio) * cantidad;
        var final_igv_round = Math.round(end * multiplier) / multiplier;

        if (afec.includes("Gravado")) {
            document.getElementById(`afectacion_${a}`).value = final_igv_round;
        }
        // console.log(final_igv_round);

        document.getElementById(`input_precio_tot_${a}`).value = Math.round(final_igv_round * multiplier) / multiplier;

        var totalInp = $('[name="input_precio_tot"]');
        var total_t = 0;

        totalInp.each(function() {
            total_t += parseFloat($(this).val());
        });

        var multiplier2 = 100;
        var total_tt = Math.round(total_t * multiplier2) / multiplier2;

        $('#sub_total').val(total_tt);

        //SOLO GRAVADO
        var totalInpG = $('[name="afectacion"]');
        var total_tg = 0;

        totalInpG.each(function() {
            total_tg += parseFloat($(this).val());
        });
        console.log(totalInpG);
        var multiplier3 = 100;
        var total_ttg = Math.round(total_tg * multiplier3) / multiplier3;
        // console.log(totalInpG);
        $('#subtotal_gravado').val(total_ttg);

        var subtotal = document.querySelector(`#sub_total`).value;
        var subtotal_gravado = document.querySelector(`#subtotal_gravado`).value;

        var igv_valor = {{ $igv->renta }};

        var igv = subtotal_gravado * igv_valor / 100;
        var igv_decimal = Math.round(igv * multiplier2) / multiplier2;
        var end = parseFloat(subtotal) + igv_decimal;
        var end2 = Math.round(end * multiplier2) / multiplier2;

        document.getElementById("igv").value = igv_decimal;
        document.getElementById("total_final").value = end2;

    }
    $(document).on('click', '.delete_item', function(event) {
        event.preventDefault();
        var e = document.getElementsByClassName("e").length;
        var fila = $(this).parents("tr");
        var input_text_opt = fila.find('input[class="celda"]').val();
        $('option[value="' + input_text_opt + '"]').prop("disabled", false);
        $(".addmore").prop("disabled", false);

        // ELIMINAR TR
        if (e > 1) {
            fila.closest('tr').remove();
            $(".borrar").prop("disabled", false);
            $(".addmore").prop("disabled", false);
        } else {
            $(".borrar").prop("disabled", true);
            $(".addmore").prop("disabled", false);
        }

        console.log(e);

        var totalInp = $('[name="input_precio_tot"]');
        var total_t = 0;

        totalInp.each(function() {
            total_t += parseFloat($(this).val());
        });

        var multiplier2 = 100;
        var total_tt = Math.round(total_t * multiplier2) / multiplier2;

        $('#sub_total').val(total_tt);

        //SOLO GRAVADO
        var totalInpG = $('[name="afectacion"]');
        var total_tg = 0;

        totalInpG.each(function() {
            total_tg += parseFloat($(this).val());
        });
        console.log(totalInpG);
        var multiplier3 = 100;
        var total_ttg = Math.round(total_tg * multiplier3) / multiplier3;
        // console.log(totalInpG);
        $('#subtotal_gravado').val(total_ttg);
        console.log(total_ttg);
        var subtotal = document.querySelector(`#sub_total`).value;
        var subtotal_gravado = document.querySelector(`#subtotal_gravado`).value;

        var igv_valor = {{ $igv->renta }};

        var igv = subtotal_gravado * igv_valor / 100;
        var igv_decimal = Math.round(igv * multiplier2) / multiplier2;
        var end = parseFloat(subtotal) + igv_decimal;
        var end2 = Math.round(end * multiplier2) / multiplier2;
        console.log(igv_decimal);
        document.getElementById("igv").value = igv_decimal;
        document.getElementById("total_final").value = end2;

    });
</script>
@endsection
