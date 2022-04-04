@extends('layout')
@section('title', 'Nota de Venta')
@section('href_accion', route('nota_venta.index') )
@section('value_accion', 'Atras')
@section('atributo_actu', 'hidden')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <form action="{{route('nota_venta.store')}}"  enctype="multipart/form-data" method="post">
                       @csrf
                       {{-- Cabecera --}}
                       <div class="row">
                        <div class="col-sm-4 text-left" align="left">
                            <address class="col-sm-4" align="left">
                                <img src="{{asset('img/logos/'.$empresa->foto)}}" alt="" width="300px">
                            </address>
                        </div>
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">

                         <div class="form-control" align="center" style="height: auto;">
                            <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                            <h2 style="font-size: 19px">NOTA DE VENTA</h2>
                            <h5>{{$cod_nota_venta}}</h5>
                        </div>
                    </div>
                </div>
                <br>
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Cliente</td>
                            <td>:</td>
                            <td>

                                <select class="select2_demo_3 " name="cliente" required=""  autocomplete="off">
                                    @foreach($clientes as $index => $cliente)
                                    <option value=""></option>
                                    <option value="{{$cliente->id}}">{{$cliente->numero_documento}} - {{$cliente->nombre}}</option>
                                    @endforeach
                                </select>
                            </td>

                            <td>Forma de pago</td>
                            <td>:</td>
                            <td>
                                <select class="form-control" name="forma_pago" required="required">
                                    @foreach($forma_pagos as $forma_pago)
                                    <option value="{{$forma_pago->id}}">{{$forma_pago->nombre}}</option>
                                    @endforeach
                                    <select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Almacen</td>
                                    <td>:<input type="text" class="form-control" value="{{$almacen->id}}" name="almacen" hidden></td>
                                    <td><input type="text" class="form-control" value="{{$almacen->nombre}}" disabled></td>

                                    <td>Garantia</td>
                                    <td>:</td>
                                    <td><select class="form-control" name="garantia">
                                      @foreach($garantia as $garantias)
                                      <option value="{{$garantias->descripcion}}">{{$garantias->descripcion}}</option>
                                      @endforeach
                                  </select></td>
                              </tr>

                              <tr>
                                <td>Moneda</td>
                                <td>:</td>
                                <td>
                                   <select name="moneda" class="form-control" required >
                                    <option value="">Seleccione Moneda</option>
                                    @foreach($moneda as $monedas)
                                    <option value="{{$monedas->id}}">{{$monedas->nombre}}</option>
                                    @endforeach
                                </select>

                            </td>
                            <td>Fecha de Emision</td>
                            <td>:</td>
                            <td>
                                <input type="text" name="fecha_emision" class="form-control" value="{{date("d-m-Y")}}" readonly="readonly">
                            </td>
                        </tr>
                        <tr>
                            <td>Observacion</td>
                            <td>:</td>
                            <td colspan="4">
                                <textarea class="form-control" name="observacion" id="observacion"  rows="2"  >Emitimos la siguiente Nota de Venta a vuestra solicitud</textarea>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <div id="resultado_moneda"></div>

                <div class="table-responsive">
                    <table cellspacing="0" class="table tables  " >
                        <thead>
                            <tr>
                                <th style="width: 10px"><input class='check_all' type='checkbox' onclick="select_all()" /></th>
                                <th >Articulo</th>
                                <th style="width:100px">Cantidad</th>
                                <th style="width:100px">Precio</th>
                                <th style="width:100px">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type='checkbox' class="case"></td>
                                <td><input  class="form-control " list="browsers2" name="articulo[]" class="monto0 form-control" required autocomplete="off">
                                 <datalist id="browsers2" >
                                    @foreach($productos as $index)
                                    <option>{{$index->nombre}} / {{$index->descripcion}}</option>
                                    @endforeach
                                    @foreach($servicios as $servicio)
                                    <option>{{$servicio->nombre}} / {{$servicio->descripcion}}</option>
                                    @endforeach
                                </td>
                                <td>
                                    <input style="width: 76px" type='text' id='cantidad0' name='cantidad[]' max="" class="monto0 form-control"  onkeyup="multi(0)"  required  autocomplete="off" />
                                </td>
                                <td>
                                    <input style="width: 76px" type='text' id='precio0' name='precio[]'  class="monto0 form-control" onkeyup="multi(0)" required  autocomplete="off" />
                                </td>

                                <td>
                                    <input style="width: 76px"  type='text' id='total0' name='total' disabled="disabled" class="total form-control " required  autocomplete="off" />
                                </td>
                                <span id="spTotal"></span>
                            </tr>

                        </tbody>
                        <tbody>


                            <tr  align="center">
                                <td></td>
                                <td></td>
                                <td>Total :</td>
                                <td colspan="2">
                                    <input id='sub_total' hidden name="costo_sub_total"  readonly="readonly" class="form-control" required />
                                    <input id='total_final' name="costo_total"  readonly="readonly" class="form-control" required /></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button type="button" class='delete btn btn-danger'  > <i class="fa fa-trash" aria-hidden="true"></i> </button>&nbsp;
                            <button type="button" class='addmore btn btn-success' > <i class="fa fa-plus-square" aria-hidden="true"></i> </button>&nbsp;
                        </div>
                        <div class="col-sm-6" align="right">
                            <button type="submit" class='delete btn btn-info'>Guardar</button>&nbsp;

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<style>
    .form-control{border-radius: 10px}
    .text_des{border-radius: 10px;border: 1px solid #e5e6e7;width: 80px;padding: 6px 12px;}
    .a{color: red}
    .select2.select2-container.select2-container--default{width:100%!important}
    .select2-selection.select2-selection--single{border: 1px solid #c5c5c5;height: 33px;}
</style>
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<!-- Steps -->
<script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

<script type="text/javascript">
    $(".select2_demo_3").select2({
        placeholder: "Seleccionar Cliente",
    });
</script>

<script>
    var i = 2;
    $(".addmore").on('click', function () {
        var data = `[
        <tr>
        <td>
        <input type='checkbox' class='case'/>
        </td>";
        <td>
        <input  class="form-control " list="browsers2" name="articulo[]" class="monto0 form-control" required autocomplete="off">
        </td>
        <td>
        <input type='text' style="width: 76px"  id='cantidad${i}' name='cantidad[]' class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
        </td>
        <td>
        <input type='text' style="width: 76px"  id='precio${i}' name='precio[]' class="monto${i} form-control" onkeyup="multi(${i})" required  autocomplete="off"/>
        </td>
        <td>
        <input type='text' id='total${i}'  style="width: 76px"  name='total' disabled="disabled" class="total form-control "  required  autocomplete="off"/>
        </td>

        </tr>
        `;
                        // $(`.monto${a}`).each(function(){

                            $('.tables').append(data);
                            i++;
                        });
                    </script>
                    <script>
                        function multi(a){
                            var total = 1;
                            var totales=0;
            var change= false; //
            $(`.monto${a}`).each(function(){
                if (!isNaN(parseFloat($(this).val()))) {
                    change= true;

                    total *= parseFloat($(this).val());
                }
            });
            total = (change)? total:0;

            var cantidad = document.querySelector(`#cantidad${a}`).value;
            var precio = document.querySelector(`#precio${a}`).value;
            var multiplier = 100;
            var final=precio*cantidad;
            var final_decimal = Math.round(final * multiplier) / multiplier;
            console.log(final_decimal);
            document.getElementById(`total${a}`).value = final_decimal;

            var totalInp = $('[name="total"]');
            var total_t = 0;

            totalInp.each(function(){
                total_t += parseFloat($(this).val());
            });

            var multiplier2 = 100;
            var total_tt = Math.round(total_t * multiplier2) / multiplier2;

            $('#sub_total').val(total_tt);

            var igv_valor=0;
            var subtotal = document.querySelector(`#sub_total`).value;
            var igv=subtotal*igv_valor/100;

            var igv_decimal = Math.round(igv * multiplier2) / multiplier2;
            var end=igv_decimal+parseFloat(subtotal);

            var end2 = Math.round(end * multiplier2) / multiplier2;

            // document.getElementById("igv").value = igv_decimal;
            document.getElementById("total_final").value = end2;

        }
    </script>

    <script>
        $(".delete").on('click', function () {
            $('.case:checkbox:checked').parents("tr").remove();
            var totalInp = $('[name="total"]');
            var total_t = 0;

            totalInp.each(function(){
                total_t += parseFloat($(this).val());
            });
            $('#sub_total').val(total_t);

            var igv_valor=18;
            var subtotal = document.querySelector(`#sub_total`).value;
            var igv=parseFloat(subtotal)*igv_valor/100;
            var end=parseFloat(igv)+parseFloat(subtotal);

            // console.log(typeof igv);
            // console.log(typeof end);
            document.getElementById("igv").value = igv;
            document.getElementById("total_final").value = end;
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
            });
        }
    </script>
    @stop
