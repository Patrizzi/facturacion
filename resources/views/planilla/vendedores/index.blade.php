@extends('layout')

@section('title', 'Vendedores')
@section('breadcrumb', 'Vendedores')
@section('breadcrumb2', 'Vendedores')
@section('data-toggle', 'modal')
@section('href_accion', '#create')
@section('value_accion', 'Agregar')

@section('content')

@if($errors->any())

<div style="padding-top: 20px;">
 <div class="alert alert-danger">
  <a class="alert-link" href="#">
    @foreach ($errors->all() as $error)
    <li class="error">{{ $error }}</li>
    @endforeach
  </a>
</div>
</div>
@endif
<style type="text/css">
  .error{color: red}
</style>

<!-- Vendedor Modal -->
<div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content" style="width: 550px">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Vendedor</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {{-- Form create --}}
        <form action="{{ route('vendedores.store') }}"  enctype="multipart/form-data" method="post">
            @csrf
          <div align="left">
            <div class="container" style=" background: white;">
              <div class="row marketing">
                <div class="col-lg-6">
                  <h4>Codigo Vendedor</h4>
                  <input type="text" class="form-control" name="cod_vendedor" value="VE00{{$suma}}" readonly='readonly'>
                </div>
                <div class="col-lg-6">
                  <h4>Nombre Vendedor:</h4>
                  <select class="form-control" name="id_personal" required="required">
                    @foreach($personal as $personals)
                    <option value="{{$personals->id}}">{{$personals->personal_l->nombres}} - {{$personals->tipo_trabajador}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-lg-6">
                  <h4>Tipo de Comision</h4>
                  <input type="text" class="form-control" value="Porcentaje de Venta" readonly="readonly">
                </div>
                <div class="col-lg-6">
                  <h4> Comision</h4>
                  <input type="text" class="form-control" name="comision" value="" required="required"></p>
                </div>
                <div class="col-lg-6" >
                  <h4 style="color: white">Grabar</h4>
                  <button  class="btn btn-primary"  type="submit">Grabar</button>
                </div>
              </div>
            </div>
          </div>
        </form>
        {{--  Fin Form Edit--}}
      </div>
    </div>
  </div>
</div>{{--Fin Modal --}}
<div class="fh-breadcrumb">
  <div class="fh-column">
    <div class="full-height-scroll">
     <ul class="list-group elements-list">
       @foreach($vendedores as $vendedor)
       <li class="list-group-item">
        <a  onclick="myFunction{{$vendedor->id}}()" class="nav-link" data-toggle="tab" href="#tab-{{$vendedor->id}}" style="padding-top: 5px;padding-bottom: 5px;">
          <strong style="font-size: 10px">{{$vendedor->cod_vendedor}}- {{$vendedor->personal->personal_l->nombres}} {{$vendedor->personal->personal_l->apellidos}}</strong>
          <div class="small m-t-xs">
            <p class="m-b-xs">
              {{$vendedor->personal->personal_l->documento_identificacion}}: {{$vendedor->personal->personal_l->numero_documento}} <br>
              Correo: {{$vendedor->personal->personal_l->email}}
            </p>
            <p class="m-b-none">
              <i class="fa fa-user"></i> {{$vendedor->personal->tipo_trabajador}}<span class="float-right text-muted">{{$vendedor->tipo_comision}}:{{$vendedor->comision}}</span>
            </p>
          </div>
        </a>
      </li>
      @endforeach
    </ul>
  </div>
</div>
<div class="full-height">
  <div class="full-height-scroll white-bg border-left">
    <div >
      <div class="tab-content">
       @foreach($vendedores as $vendedor)
       <div id="tab-{{$vendedor->id}}" class="tab-pane">
         {{-- tabla de vendedor --}}
         <div >
          <div class="row">
            <div class="col-lg-12">
              <div class="ibox ">
                {{-- PArte superior --}}
                <div class="ibox-title" style="padding-right: 3.1%;padding-left:  3.1%">
                  <div class="row tooltip-demo">

                   <div class="col-sm-6" >
                    <span>Saldo a Pagar:&nbsp;&nbsp; </span>
                    <a class="btn btn-default procesado" style="width: 80px" id="extranjera{{$vendedor->id}}" >0</a>
                    <a class="btn btn-default procesado" style="color: inherit !important; width: 80px; transition: 1s" id="nacional{{$vendedor->id}}" >0</a>
                  </div>
                  <div class="col-sm-6" align="right">
                   <!-- Vendedor modal -->
                   <button aling='lefth' type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal{{$vendedor->id}}">Editar Vendedor</button>

                   <!-- Vendedor Modal -->
                   <div class="modal fade" id="exampleModal{{$vendedor->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content" style="width: 550px">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Edit Vendedor</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          {{-- Form Edit --}}
                          <form action="{{ route('vendedores.update',$vendedor->id) }}"  enctype="multipart/form-data" method="post">
                            @csrf
                            @method('PATCH')
                            <div align="left">
                              <div class="container" style=" background: white;">
                                <div class="row marketing">
                                  <div class="col-lg-6">
                                    <h4>Codigo Vendedor</h4>
                                    <input type="text" name="cod_vendedor" class="form-control" value="{{ $vendedor->cod_vendedor }}" disabled="disabled">
                                  </div>
                                  <div class="col-lg-6">
                                    <h4>Nombre Vendedor:</h4>
                                    <input type="text" name="nombre" class="form-control" value=" {{$vendedor->personal->personal_l->nombres}} - {{$vendedor->personal->tipo_trabajador}}" disabled="">
                                  </div>
                                  <div class="col-lg-6">
                                    <h4>Tipo de Comision</h4>
                                    <input type="text" class="form-control" value=" {{$vendedor->tipo_comision }}" disabled="disabled">
                                  </div>
                                  <div class="col-lg-6">
                                    <h4> Comision</h4>
                                    <input type="text" class="form-control" name="comision" value="{{$vendedor->comision }}">
                                  </div>
                                  <div class="col-lg-6">
                                    <h4> Estado </h4>
                                    <select name="estado" class="form-control">
                                      @if($vendedor->estado==0)
                                      <option value="0">Activo</option>
                                      <option value="1">Desactivo</option>
                                      @elseif($vendedor->estado==1)
                                      <option value="1">Desactivo</option>
                                      <option value="0">Activo</option>
                                      @endif
                                    </select>
                                  </div>
                                  <div class="col-lg-6" >
                                    <h4 style="color: white">Grabar</h4>
                                    <button  class="btn btn-primary"  type="submit">Grabar</button>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </form>
                          {{--  Fin Form Edit--}}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>{{--Fin Modal --}}
              </div>
            </div>
            <div class="ibox-content">
              <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover dataTables-example {{$vendedor->id}}" >
                  <thead>
                    <tr>
                      <th>Item</th>
                      <th>Cod Cotizador</th>
                      <th>Cod Boleta/Factura</th>
                      <th>Estado de Boleta/factura</th>
                      <th>Costo Total</th>
                      <th>Comision</th>
                      <th>Liquidacion</th>
                      <th>Observacion</th>
                    </tr>
                  </thead>
                  <tbody>
                    <span hidden="hidden">{{$i=1}}</span>
                    @foreach($lista as $listas)
                    @if($listas->comisionista ==  $vendedor->id)
                    <tr>
                      <td>{{$i++}}</td>
                      <td>{{-- Codigo de Cotizacion- Producto o servicio --}}
                        @if(isset($listas->id_coti_produc))
                        <a href="{{ route('cotizacion.show', $listas->cotizacion_pro->id) }} " target="_blank">{{$listas->cotizacion_pro->cod_cotizacion}}</a>
                        @elseif((isset($listas->id_coti_servicio)))
                        <a href="{{ route('cotizacion_servicio.show', $listas->cotizacion_servi->id) }} " target="_blank">{{$listas->cotizacion_servi->cod_cotizacion}}</a>
                        @else No Tiene Cotizador
                        @endif
                      </td>
                      <td>{{-- Codigo de Factura o Boleta --}}
                        @if(isset($listas->id_fac)){{$listas->id_facturacion->codigo_fac}}
                        @elseif((isset($listas->id_bol))){{$listas->id_boleta->codigo_boleta}}
                        @endif
                      </td>
                      <td>{{-- En caso se anule la boleta o Factura --}}
                       @if($listas->estado_anular_fac_bol==0)Procesado
                       @elseif($listas->estado_anular_fac_bol==1)Anulado
                       @endif
                     </td>
                     <td>{{$listas->moneda->simbolo}}{{$listas->monto_final_fac_bol}}</td>
                     <td>{{$listas->moneda->simbolo}}{{round($listas->monto_comision, 2)}}
                     </td>
                     <td>
                       @if($listas->estado_pagado==0)Pagar
                       @elseif($listas->estado_pagado==1)Guia Pagada
                       @endif
                     </td>
                     <td>{{$listas->observacion}}</td>
                   </tr>
                   {{-- Calculo de precios de comisiones --}}
                   <span hidden="hidden">{{$monto_moneda_extranjera=$lista->where('comisionista','=',$listas->comisionista)->where('tipo_moneda','=',2)->where('estado_pagado','=',0)->sum('monto_comision')}} </span>

                   <span hidden="hidden">{{$monto_moneda_nacional=$lista->where('comisionista','=',$listas->comisionista)->where('tipo_moneda','=',1)->where('estado_pagado','=',0)->sum('monto_comision')}} </span>
                   <script>
                    function myFunction{{$vendedor->id}}() {
                      document.getElementById("extranjera{{$vendedor->id}}").innerHTML ="{{$moneda_extranjera->simbolo}}{{ round($monto_moneda_extranjera, 1)}}";
                      document.getElementById("nacional{{$vendedor->id}}").innerHTML ="{{$moneda_nacional->simbolo}}{{ round($monto_moneda_nacional,1)}}";}
                    </script>
                   {{-- Calculo de precios de comisiones --}}
                   @endif
                   @endforeach
                 </tbody>
               </table>
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
   {{-- fin de tabla vendedor --}}
 </div>
  @endforeach
<!-- NUEVO FRONT-END SOLO VISTA FLAVIA -->
<div style="background: #fff; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.03); margin: 40px 0; padding: 32px; font-family: 'Outfit', sans-serif;">
  <div style="border-bottom: 1px solid #e7eaec; margin-bottom: 18px; display: flex; align-items: center; justify-content: space-between;">
    <div style="display: flex; align-items: center;">
      <a href="#" style="text-decoration: none; margin-right: 20px;">
        <i class="fa fa-arrow-left" style="font-size: 24px; color: black;"></i>
      </a>
      <h2 style="font-family: 'Outfit', sans-serif; font-weight: bold; margin: 0; color: #000;">Vendedor</h2>
    </div>
    <i class="fa fa-user-circle" style="font-size: 28px; color: #222;"></i>
  </div>
  <div style="color: #6e6e6e; font-size: 1rem; margin-bottom: 18px; font-weight: 600;">
    <strong>10/06/2025</strong>
  </div>
  <div class="row mb-2" style="margin-bottom: 18px;">
    <div class="col-md-6 d-flex align-items-center mb-2">
      <span style="font-weight:600; color:#000; min-width:120px;">Saldo a Pagar:</span>
      <a class="btn btn-default procesado ms-2" style="width: 80px; margin-left:10px; background:#f3f3f4; color:#000; font-weight:600; border-radius:12px;">S/150.0</a>
      <a class="btn btn-default procesado ms-2" style="width: 80px; margin-left:10px; background:#f3f3f4; color:#000; font-weight:600; border-radius:12px;">US$80.0</a>
    </div>
    <div class="col-md-6 d-flex align-items-center justify-content-end mb-2">
      <button type="button" class="btn btn-info" style="border-radius: 8px; font-weight:600; padding: 6px 22px;" onclick="this.nextElementSibling.style.display='flex'">Editar Vendedor</button>
      <!-- MODAL SOLO FRONT-END, SIN FUNCIONES -->
      <div id="modalEditarVendedor" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.35); z-index:9999; align-items:center; justify-content:center;" onclick="this.style.display='none'">
        <div style="background:#fff; border-radius:18px; max-width:540px; width:95vw; margin:auto; box-shadow:0 4px 24px rgba(0,0,0,0.10); padding:32px 32px 18px 32px; position:relative;" onclick="event.stopPropagation()">
          <button onclick="document.getElementById('modalEditarVendedor').style.display='none'" style="position:absolute; top:18px; right:18px; background:none; border:none; font-size:28px; color:#888; cursor:pointer;">&times;</button>
          <h3 style="font-family:'Outfit',sans-serif; font-weight:700; color:#222; margin-bottom:18px;">Editar Vendedor</h3>
          <form onsubmit="event.preventDefault(); alert('Simulación de envío');">
            <div class="container" style="padding:0; background:transparent;">
              <div class="row marketing">
                <div class="col-lg-6 mb-3">
                  <label style="font-weight:600; color:#222;">Codigo Vendedor</label>
                  <input type="text" class="form-control" value="VEN001" disabled style="background:#f3f3f4; border-radius:12px; font-weight:500;">
                </div>
                <div class="col-lg-6 mb-3">
                  <label style="font-weight:600; color:#222;">Nombre Vendedor:</label>
                  <input type="text" class="form-control" value="Juan Pérez - Empleado" readonly style="background:#f3f3f4; border-radius:12px; font-weight:500;">
                </div>
                <div class="col-lg-6 mb-3">
                  <label style="font-weight:600; color:#222;">Tipo de Comision</label>
                  <select class="form-control" required style="border-radius:12px;">
                    <option value="Porcentaje de Venta">Porcentaje de Venta</option>
                    <option value="Monto Fijo">Monto Fijo</option>
                  </select>
                </div>
                <div class="col-lg-6 mb-3">
                  <label style="font-weight:600; color:#222;">Comision</label>
                  <input type="text" class="form-control" value="5%" style="border-radius:12px;">
                </div>
                <div class="col-lg-12 d-flex justify-content-end mt-2">
                  <button class="btn btn-primary" type="submit" style="border-radius:8px; font-weight:600; padding:8px 32px;">Grabar</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <!-- Cerrar modal haciendo click fuera del contenido -->
    </div>
  </div>
  <div class="table-responsive">
    <table class="table" style="width:100%; border-collapse:separate; border-spacing:0 8px;">
      <thead style="background: none;">
        <tr style="background: none;">
          <th style="font-weight:700; color:#222; background: none; border:none;">Item</th>
          <th style="font-weight:700; color:#222; background: none; border:none;">Cod Cotizador</th>
          <th style="font-weight:700; color:#222; background: none; border:none;">Cod Boleta/Factura</th>
          <th style="font-weight:700; color:#222; background: none; border:none;">Estado de Boleta/factura</th>
          <th style="font-weight:700; color:#222; background: none; border:none;">Costo Total</th>
          <th style="font-weight:700; color:#222; background: none; border:none;">Comision</th>
          <th style="font-weight:700; color:#222; background: none; border:none;">Liquidacion</th>
          <th style="font-weight:700; color:#222; background: none; border:none;">Observacion</th>
        </tr>
      </thead>
      <tbody>
        <tr style="background: #f3f3f4; border-radius: 12px; box-shadow: 0 1px 2px rgba(0,0,0,0.01);">
          <td style="border:none; border-radius: 12px 0 0 12px; font-weight:500;">1</td>
          <td style="border:none;">
            <a href="#" target="_blank" style="color:#2563eb; font-weight:600; text-decoration:underline;">COT-001</a>
          </td>
          <td style="border:none;">FAC-1001</td>
          <td style="border:none;">
            <span style="color:#22bb33; font-weight:600;">Procesado</span>
          </td>
          <td style="border:none;">S/1000.00</td>
          <td style="border:none;">S/50.00</td>
          <td style="border:none;">
            <span style="color:#2563eb; font-weight:600;">Pagar</span>
          </td>
          <td style="border:none; border-radius: 0 12px 12px 0;">Sin observaciones</td>
        </tr>
        <tr style="background: #f3f3f4; border-radius: 12px; box-shadow: 0 1px 2px rgba(0,0,0,0.01);">
          <td style="border:none; border-radius: 12px 0 0 12px; font-weight:500;">2</td>
          <td style="border:none;">
            <a href="#" target="_blank" style="color:#2563eb; font-weight:600; text-decoration:underline;">COT-002</a>
          </td>
          <td style="border:none;">BOL-2002</td>
          <td style="border:none;">
            <span style="color:#d32f2f; font-weight:600;">Anulado</span>
          </td>
          <td style="border:none;">US$500.00</td>
          <td style="border:none;">US$30.00</td>
          <td style="border:none;">
            <span style="color:#5c2d91; font-weight:600;">Guia Pagada</span>
          </td>
          <td style="border:none; border-radius: 0 12px 12px 0;">Pago realizado</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
<!-- FIN FRONT-END SOLO VISTA FLAVIA -->
</div>
<h1></h1>
</div>
</div>
</div>
</div>
<style>
  .form-control{border-radius: 4px}
  a{text-decoration: none;color: black}
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
<!-- Page-Level Scripts -->
@foreach($vendedores as $vendedor)
<script>
  $(document).ready(function(){
    $('.{{$vendedor->id}}').DataTable({
      pageLength: 10,
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
@endforeach
@endsection
