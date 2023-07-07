@extends('layout')
@section('title', 'Vehiculos')
@section('breadcrumb', 'Vehiculos')
@section('breadcrumb2', 'Vehiculos')
@section('content')

<!-- Modal Create  vehiculo-Publico -->
<div class="modal fade" id="agregar_vehiculo_publico" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Vehiculo Publico </h5>
            </div>
            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">
                    <form action="{{ route('vehiculo.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)"
                    >
                    @csrf
                    <fieldset >
                        <legend> Agregar Vehiculo Publico</legend>
                        <div>
                            <div class="panel-body" >
                                <div class="form-group  row">
                                    <div class="col-sm-12"><img src="{{asset('img/logos/camion.svg')}}" width="100px"></div>
                                </div>
                                <div class="form-group  row">
                                    <label class="col-sm-2 col-form-label">Nombre Empresa:</label>
                                    <div class="col-sm-4"><input type="text" class="form-control" name="nombre" required="" placeholder="Trasporte"></div>
                                    <label class="col-sm-2 col-form-label">Ruc:</label>
                                    <div class="col-sm-4"><input type="text" class="form-control" name="ruc"  required="" placeholder="2252415523"></div>
                                    <label class="col-sm-3 col-form-label">N° de MTC:</label>
                                    <div class="col-sm-7"><input type="text" class="form-control" name="n_mtc" id="" ></div>
                                    <label class="col-sm-2 col-form-label"><a href="https://www.mtc.gob.pe/tramitesenlinea/tweb_tLinea/tw_ConsultaDGTT/Frm_rep_intra_mercancia.aspx" target="_blank" style="margin: auto"><i class="fa fa-question-circle" style="cursor: pointer;font-size: 15px;transition: 1s;z-index:9999"></i></a></label>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                    <input type="hidden" value="create_publico" name="categoria" >
                    <button class="btn btn-primary" type="submit" id="boton">Grabar</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<!-- / Modal Create vehiculo-Publico  -->
<!-- Modal Create  vehiculo-Privado -->
<div class="modal fade" id="agregar_vehiculo_privado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Vehiculo Privado </h5>
            </div>
            <div style="padding-left: 15px;padding-right: 15px;">
                {{-- ccccccccccccccccc --}}
                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">
                    <form action="{{ route('vehiculo.store') }}"  enctype="multipart/form-data" method="post" onsubmit="return valida(this)"
                    >
                    @csrf
                    <fieldset >
                        <legend> Agregar Vehiculo  Privado </legend>
                        <div>
                            <div class="panel-body" >
                                <div class="form-group  row">
                                    <div class="col-sm-12"><img src="{{asset('img/logos/camion.svg')}}" width="100px"></div>
                                </div>
                                <div class="form-group row" style="margin-bottom: 0px">
                                    <label class="col-sm-3 col-form-label">Tipo de Vehiculo:</label>
                                    <div class="col-sm-9">
                                        <select class="form-control" name="tipo_vehiculo" id="">
                                            <option value="L">Categoría L (Vehículo con menos de cuatro ruedas) </option> {{-- VEHICULOS L --}}
                                            <option value="M">Categoría M (Vehículo de 3 o 4 ruedas y es utilizado para el transporte de pasajeros)</option>  {{-- VEHICULOS M --}}
                                            <option value="M1">Categoría M1 (Autos, taxis y SUV)</option>  {{-- VEHICULOS M --}}
                                            <option value="N">Categoría N (Vehículo de 4 ruedas y sea para transporte de carga.)</option> {{-- VEHICULOS N --}}
                                            <option value="O">Categoría O (Semirremolques y volquetes)</option>{{-- VEHICULOS O --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group  row">
                                    <label class="col-sm-2 col-form-label">Placa:</label>
                                    <div class="col-sm-4"><input type="text" class="form-control" name="placa" required="" placeholder="AT4234"></div>
                                    <label class="col-sm-2 col-form-label">Marca:</label>
                                    <div class="col-sm-4"><input type="text" class="form-control" name="marca"  required="" placeholder="Toyota"></div>
                                </div>

                                <div class="form-group  row">
                                    <label class="col-sm-2 col-form-label">Modelo:</label>
                                    <div class="col-sm-4"><input type="text" class="form-control" required="" name="modelo" placeholder="RAV4"></div>

                                    <label class="col-sm-2 col-form-label">Año:</label>
                                    <div class="col-sm-4"><input type="text" class="form-control" required="" name="año" placeholder="2020"></div>
                                </div>
                                <div class="form-group  row">
                                    <label class="col-sm-3 col-form-label">Certificado de Inscripcion:</label>
                                    <div class="col-sm-9"><input type="text" class="form-control" required="" name="certificado_inscripcion" ></div>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                    <input type="hidden" value="create_privado" name="categoria" >
                    <button class="btn btn-primary" type="submit" id="boton">Grabar</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
<!-- / Modal Create vehiculo-Privado  -->
<!-- / Transporte Publico  -->




<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs" role="tablist">
                    <li>
                        <a href="#tab-1" class="nav-link active" data-toggle="tab">Transporte Público
                            
                        </a>
                    </li>
                    <li><a href="#tab-2" class="nav-link" data-toggle="tab">Transporte Privado</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="tab-1">
                        <div class="panel-body">
                            <div class="nav-link" style="    position: absolute;top: -43px;right: -15px;" >
                                <span class="btn btn-primary" data-toggle="modal" data-target="#agregar_vehiculo_publico">
                                    <span style="cursor: pointer;" >Agregar</span>
                                </span>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                        <tr>
                                            <th>ITEM</th>
                                            <th>Empresa</th>
                                            <th>Ruc</th>
                                            <th>N° del MTC</th>
                                            <th>Estado</th>
                                            <th>Editar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transporte_publico as $transporte_publicos)
                                        <tr>
                                            <td>{{$transporte_publicos->id}}</td>
                                            <td>{{$transporte_publicos->nombre}}</td>
                                            <td>{{$transporte_publicos->ruc}}</td>
                                            <td>
                                                @if (isset($transporte_publicos->numero_mtc))
                                                    {{$transporte_publicos->numero_mtc}}
                                                @else
                                                    <span style="font-style: italic">Sin registro</span>
                                                @endif
                                                
                                            </td>
                                            <td>
                                                @if($transporte_publicos->estado==0)Activo
                                                @elseif($transporte_publicos->estado==1)Desactivado
                                                @endif
                                            </td>
                                            <td>
                                                <a href="#exampleModal{{$transporte_publicos->id}}" data-toggle="modal" class="btn btn-info">Editar</a>
                                                {{-- Modal de editar --}}
                                                <div class="modal fade" id="exampleModal{{$transporte_publicos->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel"> Vehiculo</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div style="padding-left: 15px;padding-right: 15px;">
                                                                {{----}}
                                                                <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">
                                                                    <form action="{{route('vehiculo.update',$transporte_publicos->id)}}"  enctype="multipart/form-data" method="post">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <fieldset >
                                                                        <legend> Editar Vehiculo Publico</legend>
                                                                        <div>
                                                                            <div class="panel-body" style="border: none" >
                                                                                <div class="form-group  row">
                                                                                    <div class="col-sm-12"><img src="{{asset('img/logos/camion.svg')}}" width="100px"></div>
                                                                                </div>
                                                                                <div class="form-group  row">
                                                                                    <label class="col-sm-2 col-form-label">Empresa:</label>
                                                                                    <div class="col-sm-4"><input type="text" class="form-control" name="nombre" value="{{$transporte_publicos->nombre}}" placeholder="AT4-234"></div>
                                                                                    <label class="col-sm-2 col-form-label">Ruc:</label>
                                                                                    <div class="col-sm-4"><input type="text" class="form-control" name="ruc" value="{{$transporte_publicos->ruc}}" placeholder="Toyota"></div>
                                                                                </div>
                                                                                <div class="form-group row">
                                                                                    <label class="col-sm-3 col-form-label">N° de MTC:</label>
                                                                                    <div class="col-sm-7"><input type="text" class="form-control" name="n_mtc" value="{{$transporte_publicos->numero_mtc}}"></div>
                                                                                    <label class="col-sm-2 col-form-label"><a href="https://www.mtc.gob.pe/tramitesenlinea/tweb_tLinea/tw_ConsultaDGTT/Frm_rep_intra_mercancia.aspx" target="_blank" style="margin: auto"><i class="fa fa-question-circle" style="cursor: pointer;font-size: 15px;transition: 1s;z-index:9999"></i></a></label>
                                                                                </div>
                                                                                <div class="form-group  row">
                                                                                    <div class="col-sm-6" align="right">
                                                                                        <label class="col-form-label">Desactivo/Activo:</label>
                                                                                    </div>
                                                                                    <div class="col-sm-6">
                                                                                        <input type="checkbox" class="js-switch_{{$transporte_publicos->id}}" name="estado"  @if($transporte_publicos->estado==0) checked="" @endif />
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row " style="text-align: center">
                                                                                    <div class="col-sm-12">
                                                                                        <input type="hidden" value="update_publico" name="categoria" >
                                                                                        <button class="btn btn-primary" type="submit">Grabar</button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </fieldset>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" role="tabpanel" id="tab-2">
                        <div class="panel-body">
                            <div class="nav-link" style="    position: absolute;top: -43px;right: -15px;" >
                                <span class="btn btn-primary" data-toggle="modal" data-target="#agregar_vehiculo_privado">
                                    <span style="cursor: pointer;" >Agregar</span>
                                </span>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover dataTables-example" >
                                    <thead>
                                        <tr>
                                            <th >ITEM</th>
                                            <th>Placa</th>
                                            <th>Marca</th>
                                            <th>Modelo</th>
                                            <th >Tipo de Vehículo</th>
                                            <th>Año</th>
                                            <th>Certificado</th>
                                            <th>Activo/desactivo</th>
                                            <th>Editar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($vehiculo as $vehiculos)
                                        <tr>
                                        <td>{{$vehiculos->id}}</td>
                                        <td>{{$vehiculos->placa}}</td>
                                        <td>{{$vehiculos->marca}}</td>
                                        <td>{{$vehiculos->modelo}}</td>
                                        <td>
                                            @switch($vehiculos->tipo_vehiculo)
                                                @case('L')
                                                    <strong>Categoría L</strong> (Vehículo con menos de cuatro ruedas)
                                                    @break
                                                @case('M')
                                                    <strong>Categoría M</strong> (Vehículo de 3 o 4 ruedas y es utilizado para el transporte de pasajeros)        
                                                    @break
                                                @case('N')
                                                    <strong>Categoría N</strong> (Vehículo de 4 ruedas y sea para transporte de carga.)
                                                    @break
                                                @case('O')
                                                    <strong>Categoría O</strong> (Semirremolques y volquetes)
                                                    @break
                                                @default
                                                    <span style="font-style: italic">Sin registro</span>
                                            @endswitch
                                        </td>
                                        <td>{{$vehiculos->año}}</td>
                                        <td>{{$vehiculos->certificado_inscripcion}}</td>
                                        <td>
                                            @if($vehiculos->estado_activo==0)Activo
                                            @elseif($vehiculos->estado_activo==1)Desactivado
                                            @endif
                                        </td>
                                        <td>
                                            <a href="#editar_privado{{$vehiculos->id}}" data-toggle="modal" class="btn btn-info">Editar</a>
                                            <!-- Modal Update  -->
                                            <div class="modal fade" id="editar_privado{{$vehiculos->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel"> Vehiculo</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div style="padding-left: 15px;padding-right: 15px;">
                                                            {{-- ccccccccccccccccc --}}
                                                            <div class="ibox-content" style="padding-left: 0px;padding-right: 0px;" align="center">
                                                                <form action="{{route('vehiculo.update',$vehiculos->id)}}"  enctype="multipart/form-data" method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                <fieldset >
                                                                    <legend> Editar Vehiculo Privado</legend>
                                                                    <div>
                                                                        <div class="panel-body" style="border: none" >
                                                                            <div class="form-group  row">
                                                                                <div class="col-sm-12"><img src="{{asset('img/logos/camion.svg')}}" width="100px"></div>
                                                                            </div>
                                                                            <div class="form-group row" style="margin-bottom: 0px">
                                                                                <label class="col-sm-3 col-form-label">Tipo de Vehiculo:</label>
                                                                                <div class="col-sm-9">
                                                                                    <select class="form-control" name="tipo_vehiculo" id="" >
                                                                                        <option @if($vehiculos->tipo_vehiculo  == "L") selected @endif value="L">Categoría L (Vehículo con menos de cuatro ruedas) </option> {{-- VEHICULOS L --}}
                                                                                        <option @if($vehiculos->tipo_vehiculo  == "M") selected @endif value="M">Categoría M (Vehículo de 3 o 4 ruedas y es utilizado para el transporte de pasajeros)</option>  {{-- VEHICULOS M --}}
                                                                                        <option @if($vehiculos->tipo_vehiculo  == "M1") selected @endif value="M1">Categoría M1 (Autos, taxis y SUV)</option>  {{-- VEHICULOS M --}}

                                                                                        <option @if($vehiculos->tipo_vehiculo  == "N") selected @endif value="N">Categoría N (Vehículo de 4 ruedas y sea para transporte de carga.)</option> {{-- VEHICULOS N --}}
                                                                                        <option @if($vehiculos->tipo_vehiculo  == "O") selected @endif value="O">Categoría O (Semirremolques y volquetes)</option>{{-- VEHICULOS O --}}
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group  row">
                                                                                <label class="col-sm-2 col-form-label">Placa:</label>
                                                                                <div class="col-sm-4"><input type="text" class="form-control" name="placa" value="{{$vehiculos->placa}}" placeholder="AT4-234"></div>
                                                                                <label class="col-sm-2 col-form-label">Marca:</label>
                                                                                <div class="col-sm-4"><input type="text" class="form-control" name="marca" value="{{$vehiculos->marca}}" placeholder="Toyota"></div>
                                                                            </div>

                                                                            <div class="form-group  row">
                                                                                <label class="col-sm-2 col-form-label">Modelo:</label>
                                                                                <div class="col-sm-4"><input type="text" class="form-control" name="modelo" value="{{$vehiculos->modelo}}" placeholder="RAV4"></div>

                                                                                <label class="col-sm-2 col-form-label">Año:</label>
                                                                                <div class="col-sm-4"><input type="text" class="form-control" name="año" value="{{$vehiculos->año}}" placeholder="2020"></div>
                                                                            </div>
                                                                            <div class="form-group  row">
                                                                                <label class="col-sm-3 col-form-label">Certificado de Inscripcion:</label>
                                                                                <div class="col-sm-9"><input type="text" class="form-control" required="" value="{{$vehiculos->certificado_inscripcion}}" name="certificado_inscripcion" ></div>
                                                                            </div>
                                                                            <div class="form-group  row">
                                                                                <div class="col-sm-6" align="right">
                                                                                    <label class="col-form-label">Desactivo / Activo:</label>
                                                                                </div>
                                                                                <div class="col-sm-6">
                                                                                    <input type="checkbox" class="js-switch_vehiculo{{$vehiculos->id}}" name="estado"  @if($vehiculos->estado_activo==0) checked="" @endif />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                                <input type="hidden" value="update_privado" name="categoria" >
                                                                <button class="btn btn-primary" type="submit">Grabar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- / Modal Update  -->
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
            pageLength: 10,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
        });
    });

</script>

<link href="{{asset('css/plugins/switchery/switchery.css')}}" rel="stylesheet">
<!-- Switchery -->
<script src="{{asset('js/plugins/switchery/switchery.js')}}"></script>

@foreach($transporte_publico as $transporte_publicos)
<script>
    var elem_2 = document.querySelector('.js-switch_{{$transporte_publicos->id}}');
    var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });
</script>
@endforeach
@foreach($vehiculo as $vehiculos)
<script>
    var elem_2 = document.querySelector('.js-switch_vehiculo{{$vehiculos->id}}');
    var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });
</script>
@endforeach
@endsection
