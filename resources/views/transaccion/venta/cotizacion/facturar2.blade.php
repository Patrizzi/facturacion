 @extends('layout')

 @section('title', 'Facturar Cotización')
 @section('breadcrumb', 'Facturar')
 @section('breadcrumb2', 'Facturar')
 @section('href_accion', route('cotizacion.show',$cotizacion->id))
 @section('value_accion', 'Atrás')

 @section('content')
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
 <head>
    <script type="text/javascript">
        $(document).ready(function() {

            $("form").keypress(function(e) {
                if (e.which == 13) {
                    setTimeout(function() {
                        e.target.value += ' | ';
                    }, 4);
                    e.preventDefault();
                }
            });


        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            if({{$cotizacion->forma_pago_id}} == 1){
                document.getElementById('credito_pago').style.display = "none";
                document.getElementById('colum-col').className = "col-sm-5";
                document.getElementById('ven_1p').style.visibility = "initial";
                document.getElementById('ven_3p').style.visibility = "initial";
                document.getElementById('fecha_vencimiento').removeAttribute('disabled');
                
            }else{
                document.getElementById('credito_pago').style.display = "block";
                document.getElementById('ven_1p').style.visibility = "hidden";
                document.getElementById('ven_3p').style.visibility = "hidden";
                document.getElementById('fecha_vencimiento').setAttribute('disabled', 'true');
            }

        }); 
    </script>
</head>
<div class="wrapper wrapper-content animated fadeInRight">
   <form action="{{route('cotizacion.facturar_store')}}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)">
    @csrf
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-content p-xl" style=" margin-bottom: 20px;padding-bottom: 50px;">
                <div class="row">
                    <div class="col-sm-4 text-left" align="left">
                        <address class="col-sm-4" align="left">
                            <img src="{{asset('img/logos')}}/{{$empresa->foto}}" alt="" width="300px">
                        </address>
                    </div>
                    <div class="col-sm-4 text-center" style="font-size: 13px"><br>
                         <strong>{{$empresa->razon_social}}</strong>
                         <br>
                         Tel.: {{$empresa->telefono}} / Móvil: {{$empresa->movil}} 
                        <br>
                         {{$empresa->correo}}
                         <br>
                          {{$empresa->calle}} - {{$empresa->ciudad}} - {{$empresa->region_provincia}} - {{$empresa->pais}}
                         

                    </div>
                    <div class="col-sm-4 ">
                        <div class="form-control ruc" style="height: 125px">
                            <center>
                                <h3 style="padding-top:10px ">R.U.C {{$empresa->ruc}}</h3>
                                <h2>FACTURA ELECTRÓNICA</h2>
                                <input type="text" value="{{$cotizacion->id}}" name="id_cotizador" hidden="hidden">
                                <p>{{$cod_fac}}</p>
                                <input type="text" value="{{$cotizacion->comisionista_id}}" name="id_comisionista" hidden="hidden">
                            </center>
                        </div>
                    </div>
                </div><br>
                <!-- Body -->
                <div class="row">
                    <div class="col-sm-6" align="center">
                        <div class="form-control">
                            <div align="left">
                                <div class="row ">
                                    <div class="col-sm-2"><strong>Cliente:</strong></div>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="" value="  {{$cotizacion->cliente->nombre}}" readonly></div>
                                    <br>
                                    <div class="col-sm-2"><strong>R.U.C:</strong></div>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="" value="  {{$cotizacion->cliente->numero_documento}}" readonly></div>
                                    <br>
                                    <div class="col-sm-2"><strong>Dirección:</strong></div>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="" value="  {{$cotizacion->cliente->direccion}}" readonly></div>
                                    <br>
                                    <div class="col-sm-2"><strong>Condiciones de Pago:</strong></div>
                                        <div class="col-sm-3" id="colum-col">
                                            <select class="form-control" name="forma_pago"  id ="forma_pago" onchange="seleccionado_fp()">
                                                {{-- <option value="{{$cotizacion->forma_pago->id}}">{{$cotizacion->forma_pago->nombre}}</option>
                                                <option disabled>--------------------</option> --}}
                                                @foreach($forma_pagos as $forma_pago)
                                                    <option value="{{$forma_pago->id}}" @if($cotizacion->forma_pago_id == $forma_pago->id) selected @endif>{{$forma_pago->nombre}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-2" id="credito_pago" style="display: none;">
                                            <button  type="button" class='cuota_modal btn btn-info' id="cuota_modal"  data-toggle="modal" data-target="#cuotas_modal">Cuotas</button>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade bd-example-modal-lg" id="cuotas_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                          <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                              <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Registrar cuotas</h5>
                                                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert"   id="alert_campos" style="display: none">
                                                  <strong style="font-size:11px">Rellenar todos los campos</strong>
                                                  <button type="button" class="close_model_rc close" onclick="cerrar_but_rc()" style="padding: 6;">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert"  id="suma_campos" style="display: none" >
                                                  <strong style="font-size:11px">La suma de las cuotas es diferente del monto total</strong>
                                                  <button type="button" class="close_model_mt close" onclick="cerrar_but_mt()" style="padding: 6;">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="row_number">
                                                    <div class="pago_modal row">
                                                        <div class="col-sm-1"><label>Fecha:</label></div>
                                                        <div class="col-sm-4">
                                                            <input type="date" name="fecha_pago[]" id="fecha_pago0"  class="fecha_pago form-control"  min="{{$fecha_1}}" >
                                                        </div>
                                                        <div class="col-sm-1"><label>Monto:</label></div>
                                                        <div class="col-sm-4">
                                                            <div class="input-group mb-3" style="padding-right:15px">
                                                              <div class="input-group-prepend">
                                                                <span class="input-group-text" id="basic-addon3">{{$cotizacion->moneda->simbolo}}</span>
                                                              </div>
                                                              <input type="text" name="monto_pago[]" id="monto_pago0" class="monto_pago form-control" onkeypress="return filterFloat(event,this);"   >
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <label ><button type="button"  aria-hidden="true" id="add_pago" class="add_pago btn btn-success"><i class="fa fa-plus-square-o fa-lg" > </i></button></label>
                                                    </div>
                                                    </div>
                                                </div>
                                              </div>
                                              <div class="modal-footer" style="display: block">
                                                <div class="row">
                                                    <div class="col-sm-6" style="">
                                                        <label for=""><strong>Precio Total: &nbsp;</strong>{{$cotizacion->moneda->simbolo}}&nbsp;</label><label id="cuotas_footer"></label>
                                                    </div>
                                                    <div class="col-sm-6" align="right">
                                                        <button type="button" id="button_cuotas_save" class="btn btn-primary">Guardar</button>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <strong>Tipo de Moneda:</strong>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" value="{{$cotizacion->moneda->nombre}}" name="" readonly>
                                            <input type="text" name="tipo_moneda" value="{{$cotizacion->moneda->id }}" hidden="hidden">
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6" align="center">
                        <div class="form-control" >
                            <div align="left">
                                <div class="row">
                                    <div class="col-sm-2"><strong>Orden de Compra:</strong></div>
                                    <div class="col-sm-10"><input type="text" class="form-control" value="0" name="orden_compra"></div>
                                    <br>
                                    <div class="col-sm-2"><strong>Guía de Remisión:</strong></div>
                                    <div class="col-sm-10"><input type="text" class="form-control" name="guia_remision" value="0"  ></div>
                                    <br>
                                    <div class="col-sm-2"><strong>Fecha de Emisión:</strong></div>
                                    <div class="col-sm-10"><input type="date" class="form-control" value="{{date("Y-m-d")}}"  readonly="readonly" name=fecha_emision></div>
                                    
                                    <div class="col-sm-2" id="ven_1p" style="visibility: initial;">
                                        <strong>Fecha de Vencimiento:</strong>
                                    </div>
                                    <div  class="col-sm-10"  id="ven_3p" style="visibility: initial;">
                                        <input type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" value="{{date("Y-m-d")}}">
                                    </div>
                                    <br>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row"> -->
                    <div class="col-sm-12 " style="height:  120px">
                        <div class="form-control">
                            <strong>Observaciones:</strong><br>
                            <textarea class="form-control" name="observacion">{{$cotizacion->observacion}}</textarea>
                        </div>
                    </div>
            <!-- </div> -->
                </div>

                    <br>
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th style="width:10%">Código de Item</th>
                                    <th style="width:10%">Cantidad</th>
                                    <th>Descripción</th>
                                    <th>Stock</th>
                                    <th style="width:10%">Valor Unitario</th>
                                    <th style="width: 10%">Valor Venta </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cotizacion_registros as $index => $cotizacion_registro)
                                {{-- @if($validor[$index]==1) --}}
                                <tr>
                                    @if(isset($cotizacion_registro->producto_id))
                                        <td>{{$cotizacion_registro->producto->codigo_producto}}</td>
                                        <td>{{$cotizacion_registro->cantidad}}</td>
                                        <td>
                                            {{$cotizacion_registro->producto->nombre}}
                                            {{-- <span style="font-size: 10px">{{$cotizacion_registro->producto->descripcion}}</span>  --}}
                                            <textarea class="form-control" name="descripcion_item[]" placeholder="Descripción del item" rows="2" cols="2">{{$cotizacion_registro->descripcion_item}}</textarea>
                                            <input type="text" class="form-control col-sm-4" name="numero_serie[{{$index}}]" placeholder="N° Serie">
                                        </td>
                                    @else
                                    <td>{{$cotizacion_registro->servicio->codigo_servicio}}</td>
                                    <td>{{$cotizacion_registro->cantidad}}</td>
                                    <td>
                                        {{$cotizacion_registro->servicio->nombre}}
                                        {{-- <span style="font-size: 10px">{{$cotizacion_registro->servicio_id}}</span> --}}
                                            <textarea class="form-control" name="descripcion_item[]" placeholder="Descripción del item" rows="2" cols="2">{{$cotizacion_registro->descripcion_item}}</textarea>

                                        <input type="text" class="form-control col-sm-4" name="numero_serie[{{$index}}]" placeholder="N° de Serie">
                                    </td>
                                    @endif
                                    
                                    <td>{{$array_cantidad[$index]}}</td>
                                    {{-- <td>{{$array[$index]}}</td> --}}
                                    {{-- MODIFICAR ESTA PARTE CON LOGICA DE REPROGRAMACION PARA UN NUEVO PRODUCTO DIRECTAMENTE DESDE KARDEX --}}
                                    <td style="display: none;">
                                        {{$desc_array=round($array[$index]-($array_promedio[$index]*$cotizacion_registro->descuento/100),2)}}
                                        {{$comis_array= round($desc_array+($desc_array*($comi/100)),2)}}
                                    </td>
                                    <td>{{$cotizacion->moneda->simbolo}} {{round($comis_array,2)}}</td>
                                    <td style="text-align: right;">{{$cotizacion->moneda->simbolo}} {{number_format(round($comis_array*$cotizacion_registro->cantidad,2),2)}}</td>

                                    <td style="display: none">
                                        {{$sub_total=($cotizacion->op_gravada)+($cotizacion->op_exonerada)+($cotizacion->op_inafecta)}}
                                        {{$sub_total_gravado=($cotizacion->op_gravada)}}
                                        S/.{{$igv_p=round($sub_total_gravado, 2)*($igv->igv_total/100)}}
                                        {{$end=round($sub_total, 2)+round($igv_p, 2)}}
                                        {{$end2=number_format(round($sub_total, 2)+round($igv_p, 2),2)}}
                                    </td>
                                </tr>
                                {{-- @endif --}}
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div align="left">
                                <h3 >
                                    <?php use Luecano\NumeroALetras\NumeroALetras;
                                    $v=new NumeroALetras() ;
                                    $letra=($v->toInvoice($end, 2));
                                    // $end_final_point=strstr($end2, '.',false);
                                    // $end_final=str_replace('.', '',$end_final_point);
                                    ?>
                                    Son : {{ucfirst(strtolower($letra))}} {{$cotizacion->moneda->nombre}}
                                    <!-- {{-- {{$end2}} --}} -->
                                </h3>
                            </div>
                        </div>
                        <!-- {{-- <div class=""> --}} -->
                        <div class="col-sm-4 form-control" >
                            <span style="display: block;float: left"> Subtotal:</span>
                            <span style="display: block;float: right;"> {{$simbologia = $cotizacion->moneda->simbolo}} {{number_format(round($sub_total, 2),2)}}</span><br>
                            <input type="text" hidden="" name="sub_total_sin_igv" value="{{number_format(round($sub_total, 2),2)}}" >
                            <span style="display: block;float: left"> Op. Agravada: </span>
                            <span style="display: block;float: right">{{$simbologia}} {{number_format($cotizacion->op_gravada,2)}}</span><br>
                            <span style="display: block;float: left"> Op. Inafecta: </span>
                            <span style="display: block;float: right">{{$simbologia}} {{ number_format($cotizacion->op_inafecta,2)}}</span><br>
                            <span style="display: block;float: left"> Op. Exonerada: </span>
                            <span style="display: block;float: right">{{$simbologia}} {{number_format($cotizacion->op_exonerada,2)}}</span><br>
                            {{-- <input type="text" value="{{$end}}" hidden="hidden" name="precio_final_igv"> --}}
                            <span style="display: block;float: left"> I.G.V.: </span>
                            <span style="display: block;float: right">{{$cotizacion->moneda->simbolo}} {{number_format(round($igv_p, 2),2)}}</span><br>
                            {{-- <input type="text" value="{{$end}}" hidden="hidden" name="precio_final_igv"> --}}
                            <span style="display: block;float: left"> Importe Total: </span>
                            <span style="display: block;float: right">{{$cotizacion->moneda->simbolo}} {{number_format($end,2)}}</span>
                            <input type="text" value="{{$end}}" hidden="hidden" name="precio_final_igv" id="total">
                            <br>
                        </div>
                        <!-- {{-- </div> --}} -->
                    </div>

                     <input type="text" name="name" maxlength="50" hidden="" value="{{$cotizacion->cod_cotizacion}}"  >
                    <input type="text" name="id" maxlength="50" hidden="" value="{{$cotizacion->id}}"  >
                    <input type="text" name="remitente" hidden=""  value="{{$cotizacion->cliente->email}}"  >
                    <div class="row" align="center" >

                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-4">
                        </div>
                        <!-- @if(auth()->user()->email_creado == 1)
                        <div class="  col-sm-6 alert alert-info" >
                            <input type="hidden" name="verificacion" value="1" id="">
                            <p style="margin-bottom: 0px">!Al momento de Facturar se le enviará una copia al correo del cliente!</p>
                        </div>
                        @else -->
                        <!-- <div class="  col-sm-6 alert alert-info" > -->
                            <input type="hidden" name="verificacion" value="0" id="">
                            <!-- <p style="margin-bottom: 0px">!Solo se guardará la factura!</p> -->
                        <!-- </div> -->
                        <!-- @endif -->
                        <div class="col-sm-4" align="center" >
                            <button class="btn btn-primary boton_submit" style="margin-top: 5px" type="button"  id="boton"><i class="fa fa-cloud-upload" aria-hidden="true" >Guardar</i></button>&nbsp;
                            <button type="submit" hidden id="submit_button">Guardar DB</button>
                        </div>
                    </div>
                    <br>
                    
                    @include('layout_bancos')
                </div>
            </div>
        </div>
    </form>
</div>


<style type="text/css">
    .ruc{border-radius: 10px; height: 150px;}
    .form-control{border-radius: 10px;margin-bottom: 1em;}
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
 {{-- Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
<script>
    function valida(f) {
        var boton=document.getElementById("boton");
        var completo = true;
        var incompleto = false;
        if( f.elements[0].value == "" )
           { alert(incompleto); }
       else{boton.type = 'button';}
   }
</script>
{{-- FIN Validar Formulario / No doble insercion de datos(Gente desdesperada) --}}
<script type="text/javascript">
    function most_tot(){
       var monto_0 = document.getElementById("monto_pago0").value;
        if(monto_0.length == 0){
            var total_final = document.getElementById('total').value;
            document.getElementById("monto_pago0").value = total_final;
        }
    }
</script>
{{-- <script type="text/javascript">
    $(document).ready(function() {
    // show the alert
    setTimeout(function() {
        $(".alert").alert('close');
    }, 2000);
});
</script> --}}
<script>
        var total = document.getElementById('total').value;
        var x = 1;
        $(".add_pago").on('click', function () {
        var total = document.getElementById('total').value;
        var data = `
        <div class="delete_modal${x} row">
        <div class="col-sm-1"><label>Fecha:</label></div>
        <div class="col-sm-4">
            <input type="date" name="fecha_pago[]" id="fecha_pago${x}" class="fecha_pago form-control" min="{{$fecha_1}}" >
        </div>
        <div class="col-sm-1"><label>Monto:</label></div>
        <div class="col-sm-4">
            <div class="input-group mb-3" style="padding-right:15px">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">{{$cotizacion->moneda->simbolo}}</span>
              </div>
              <input type="text" name="monto_pago[]" class="monto_pago form-control" id="monto_pago${x}" onkeypress="return filterFloat(event,this);"    >
            </div>
        </div>
        <div class="col-sm-2">
            <label ><button type="button"  class="xd btn btn-danger" onclick="eliminar(${x})"><i class="fa fa-trash-o fa-lg" > </i></button></label>
        </div>
        </div>`;
        $('.row_number').append(data);

        var inp_mont = document.getElementsByClassName('monto_pago').length;

       // document.getElementById(`monto_pago${x}`).value = (total/inp_mont);

        x++;
        if(inp_mont>6){
            $('.add_pago').attr('disabled');
        }
        var multiplier2 = 100;
        var monto_c = document.getElementsByClassName('monto_pago');
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        for (var i = 0; i < inp_mont; i++) {
            var monto = monto_c[i].id;
            var fin = (total/inp_mont)
                document.getElementById("monto_pago0").value = '';
                // document.getElementById(`${monto}`).value = Math.round(fin * multiplier2)/ multiplier2;
        }
        var inp_mont = document.getElementsByClassName('monto_pago').length;
        if(inp_mont>5){
            document.getElementById('add_pago').setAttribute('disabled', "true");
        }else{
            document.getElementById('add_pago').removeAttribute('disabled');
        }
        });
    </script>
    <script type="text/javascript">
        // $(".delete_pago").on('click', function () {
        function eliminar(x){
            $(`.delete_modal${x}`).remove();
            var monto_c = document.getElementsByClassName('monto_pago');
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            var multiplier2 = 100;

            for (var i = 0; i < inp_mont; i++) {
                var monto = monto_c[i].id;
                var total = document.getElementById('total').value;
                var fin = (total/inp_mont)
                document.getElementById("monto_pago0").value = '' ;
                // document.getElementById(`${monto}`).value = Math.round(fin * multiplier2)/ multiplier2;
            }
            if(inp_mont>5){
                document.getElementById('add_pago').setAttribute('disabled', "true");
            }else if(inp_mont == 1){
                document.getElementById("monto_pago0").value = total;
            }else{
                document.getElementById('add_pago').removeAttribute('disabled');
            }
        };
    </script>
    <script>
        $("#boton").on(" click",function(buton){
            var l = Ladda.create(document.querySelector('.boton_submit'));
            var forma_pago = $("#forma_pago option:selected").val();
            if(forma_pago == 2){
                var monto_c = document.getElementsByClassName('monto_pago');
                var monto_fc = document.getElementsByClassName('fecha_pago');
                var inp_mont = document.getElementsByClassName('monto_pago').length;
                var total =  $("#cuotas_footer").html();
                var fin = 0.00;
                var comp = 0;
                for (var i = 0; i < inp_mont; i++) {
                    fin = parseFloat(fin) + parseFloat(monto_c[i].value);
                }
                var fin_r = Math.round(fin * 100) / 100;
                // console.log(total);
                for (var i = 0; i < inp_mont; i++) {
                    var fecha = monto_fc[i].id;
                    var monto = monto_c[i].id;
        
                    var input_text = document.getElementById(`${monto}`).value;
                    var date_text = document.getElementById(`${fecha}`).value;
                    if( input_text.length  == 0 || date_text.length  == 0){
                        $('#cuotas_modal').modal('show');
                        document.getElementById('alert_campos').style.display = "flex";                    
                        setTimeout(mostrarMensaje, 3000);
                        return;
                    }
                }
                if(fin_r != total){
                    $('#cuotas_modal').modal('show');
                    document.getElementById('suma_campos').style.display = "flex";
                    setTimeout(mostrarMensaje, 3000);
                }else{
                    // console.log('e')
                    l.start();
                    document.getElementById('submit_button').click();
                }
            // buton.preventDefault();
            }else{
                l.start();
                document.getElementById('submit_button').click();
            }
        });

    </script>
    <script >
        function cerrar_but_rc(){
            document.getElementById('alert_campos').style.display = "none";
        }
        function cerrar_but_mt(){
            document.getElementById('suma_campos').style.display = "none";
        }
    </script>
    <script type="text/javascript">
        function seleccionado_fp(){
            var opt = $('#forma_pago').val();
                if(opt=="1"){
                    // $('#consulta_p_input').prop('disabled', false);

                    document.getElementById('credito_pago').style.display = "none";
                    document.getElementById('colum-col').className = "col-sm-5";
                    document.getElementById('ven_1p').style.visibility = "initial";
                    document.getElementById('ven_3p').style.visibility = "initial";
                    document.getElementById('fecha_vencimiento').removeAttribute('disabled');
                }else{
                    document.getElementById('credito_pago').style.display = "block";
                    document.getElementById('colum-col').className = "col-sm-3";
                    document.getElementById('ven_1p').style.visibility = "hidden";
                    document.getElementById('ven_3p').style.visibility = "hidden";
                    document.getElementById('fecha_vencimiento').setAttribute('disabled', 'true');
                }
        }
    </script>
    <script type="text/javascript">
       $(document).ready(function() {             
            var total = document.getElementById('total').value;
            document.getElementById("monto_pago0").value = total
            $("#cuotas_footer").html(total);
        }); 
    </script>
    <script>
        $(document).on('click','#button_cuotas_save', function(event){    
            var monto_c = document.getElementsByClassName('monto_pago');
            var monto_fc = document.getElementsByClassName('fecha_pago');
            console.log(monto_c)
            var inp_mont = document.getElementsByClassName('monto_pago').length;
            var total =  $("#cuotas_footer").html();
            var fin = 0.00;
            var comp = 0;
            for (var i = 0; i < inp_mont; i++) {
                fin = parseFloat(fin) + parseFloat(monto_c[i].value);
            }
            var fin_r = Math.round(fin * 100) / 100;
            // console.log(total);
            for (var i = 0; i < inp_mont; i++) {
                var fecha = monto_fc[i].id;
                var monto = monto_c[i].id;
    
                var input_text = document.getElementById(`${monto}`).value;
                var date_text = document.getElementById(`${fecha}`).value;
                if( input_text.length  == 0 || date_text.length  == 0){
                    console.log("a");
                    document.getElementById('alert_campos').style.display = "flex";                    
                    setTimeout(mostrarMensaje, 3000);
                    return;
                }
            }
            if(fin_r != total){
                document.getElementById('suma_campos').style.display = "flex";
                setTimeout(mostrarMensaje, 3000);

            }else{
                // console.log('e')
                $('#cuotas_modal').modal('hide');
            }
            
        });

        function mostrarMensaje(){
            // $("#alert_campos").show(200);
            $("#alert_campos").hide(3000);
            $("#suma_campos").hide(3000);
        }
        function filterFloat(evt,input){
            var key = window.Event ? evt.which : evt.keyCode;    
            var chark = String.fromCharCode(key);
            var tempValue = input.value+chark;

            if(key >= 48 && key <= 57){
                if(filter(tempValue)=== false){
                    return false;
                }else{       
                    return true;
                }
            }else{
                if(key == 8 || key == 13 || key == 0) {     
                    return true;              
                }else if(key == 46){
                    if(filter(tempValue)=== false){
                        return false;
                    }else{       
                        return true;
                    }
                }else{
                    return false;
                }
            }
        }
        function filter(__val__){
            var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
            if(preg.test(__val__) === true){
                return true;
            }else{
            return false;
            }   
        }
    </script>
@endsection
