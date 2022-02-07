@extends('layout')
@section('title', 'Inicio')
@section('atributo_actu', 'hidden')
@section('atributo_1', 'hidden')

@section('foto', auth()->user()->avatar)
@section('nombre', auth()->user()->personal->nombres)
@section('area', auth()->user()->name)
@section('content')
<style>
    ul{padding-left: 0px;}
</style>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5 style="color:#0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                     <div class="col-lg-3">
                        <div class="ibox ">
                            <div class="ibox-title" style="border-top:none">
                                <span class="label label-success float-right">18%</span>
                                <h5>IGV </h5>
                            </div>
                            <div class="ibox-content" align="center">
                                <h1>{{$moneda_nacional->simbolo.round($igv_nacional,2)}}</h1>
                                <small >Calculo aproximado del impuesto a pagar</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox ">
                            <div class="ibox-title" style="border-top:none" >
                                <span class="label label-info float-right">{{strftime('%B')}}</span>
                                <h5>Facturas del Mes</h5>
                            </div>
                            <div class="ibox-content" align="center">
                                <h1 > {{$coun_fac_mes}} </h1>
                                <small>Calculo Exacto de Facturas Creadas</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox ">
                            <div class="ibox-title" style="border-top:none">
                                <span class="label label-info float-right">{{strftime('%B')}}</span>
                                <h5>Boletas Del Mes</h5>
                            </div>
                            <div class="ibox-content" align="center">
                                <h1>{{$coun_bol_mes}}</h1>
                                <small>Calculo Exacto de Boletas Creadas</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox ">
                            <div class="ibox-title" style="border-top:none">
                                <span class="label label-success float-right">{{date('d-m-Y')}}</span>
                                <h5>Tipo de Cambio</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-sm-6"><small>Compra :</small><h1>{{$consulta->compra}}</h1> </div>
                                    <div class="col-sm-6"><small>Venta :</small><h1>{{$consulta->venta}}</h1></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-4">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Alertas</h5>
            </div>
            <div class="ibox-content">
                <div>
                    <div class="ibox-content no-padding" align="center" style="border-top-width: 0px;">
                    <span class="m-r-sm text-muted welcome-message" ><img src="{{asset('img/logos/'.$empresa->foto)}}" height="50px"></span>
                </div>
                <div class="ibox-content profile-content">
                    <h4><strong> {{$empresa->nombre}}</strong></h4>
                    <p><i class="fa fa-map-marker"></i>{{$empresa->calle}}</p>
                    <h5>Sobre mi:</h5>
                    <p>{{$empresa->descripcion}}</p>
                       {{--  <div class="row m-t-lg">
                            <div class="col-md-4">
                                <span class="bar">5,3,9,6,5,9,7,3,5,2</span>
                                <h5><strong>169</strong> Posts</h5>
                            </div>
                            <div class="col-md-4">
                                <span class="line">5,3,9,6,5,9,7,3,5,2</span>
                                <h5><strong>28</strong> Following</h5>
                            </div>
                            <div class="col-md-4">
                                <span class="bar">5,3,2,-1,-3,-2,2,3,5,2</span>
                                <h5><strong>240</strong> Followers</h5>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">

        <div class="row">

            <div class="col-lg-6">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Destacados (próximamente)</h5>
                    </div>
                    <div class="ibox-content">

                     <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">

                                <div class="ibox-content text-center">
                                    <h1>Producto mas vendido del Día</h1>
                                    <div class="m-b-sm">
                                        <img alt="image" style="width:250px; height: 200px;padding: 20px; border:3px solid #2196f3; border-radius: 5px;"  src="https://definicion.de/wp-content/uploads/2009/06/producto.png">
                                    </div>
                                    <p class="font-bold">Producto1</p>

                                    <div class="text-center">
                                        <span   class="btn btn-xs btn-white">5 veces vendido  </span>
                                        <span  class="btn btn-xs btn-primary">S/.50 aproximados</span>
                                    </div>
                                </div>
                            </div>
                            <div class="carousel-item">
                              <div class="ibox-content text-center">
                                <h1>Producto mas vendido del Mes</h1>
                                <div class="m-b-sm">
                                    <img alt="image" style="width:250px; height: 200px;padding: 20px; border:3px solid #f39f21; border-radius: 5px;"  src="https://definicion.de/wp-content/uploads/2009/06/producto.png">
                                </div>
                                <p class="font-bold">Producto 2</p>

                                <div class="text-center">
                                    <span   class="btn btn-xs btn-white">30 veces vendido</span>
                                    <span class="btn btn-xs btn-primary">S/.800 aproximados</span>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="ibox-content text-center">
                                <h1>Servicio mas vendido del Mes</h1>
                                <div class="m-b-sm">
                                    <img alt="image" style="width:250px; height: 200px;padding: 20px; border:3px solid #21f3c3; border-radius: 5px;"  src="https://www.estrategiaynegocios.net/csp/mediapool/sites/dt.common.streams.StreamServer.cls?STREAMOID=1YbfCffBXOPF85InC$mO7M$daE2N3K4ZzOUsqbU5sYs6IYaZ64t25ttE0D51pJSc6FB40xiOfUoExWL3M40tfzssyZqpeG_J0TFo7ZhRaDiHC9oxmioMlYVJD0A$3RbIiibgT65kY_CSDiCiUzvHvODrHApbd6ry6YGl5GGOZrs-&CONTENTTYPE=image/jpeg">
                                </div>
                                <p class="font-bold">Servicio 1</p>

                                <div class="text-center">
                                    <span class="btn btn-xs btn-white">30 veces vendido</span>
                                    <span class="btn btn-xs btn-primary">S/.3000 aproximados</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Usuario Activo</h5>
            </div>
            <div class="ibox-content table-responsive">
                <div class="widget-head-color-box navy-bg p-lg text-center" style="background:#23c6c8 !important">
                    <div class="m-b-md">
                        <h3 class="font-bold no-margins">{{ auth()->user()->personal->nombres}} {{ auth()->user()->personal->apellidos}} </h3>
                        <small>Asuario interacuando en el sistema</small></div>
                        {{-- <img src="img/a4.jpg" class="rounded-circle circle-border m-b-md" alt="profile"> --}}
                        <img alt="image" class="rounded-circle circle-border m-b-md" src=" {{ asset('/profile/images/')}}/{{auth()->user()->avatar}} " />
                        <div class="row">
                            <div class="col-lg-4">
                                <span> {{ auth()->user()->personal->fecha_nacimiento}}</span><br><small>F.Nacimiento</small>
                            </div>
                            <div class="col-lg-4">
                                <span> {{ auth()->user()->personal->celular}}</span><br><small>Celular</small>
                            </div>
                            <div class="col-lg-4">
                                <span> {{ auth()->user()->personal->telefono}}</span><br><small>Telefono</small>
                            </div>

                        </div>
                    </div>
                    <div class="widget-text-box">
                        <h4 class="media-heading"><span> {{ auth()->user()->personal->nombres}}</span></h4>
                        <p>Usuario Activo en la Empresa {{$empresa->nombre}}.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .carousel-control-prev-icon, .carousel-control-next-icon {
        background-color: rgba(0, 0, 0, 0.3);
        border-radius: 5px;
    }
</style>
<script type="text/javascript">
    $('.carousel').carousel({
      interval: 2000
  })
</script>
@endsection
@include('partials.page_script_general')
