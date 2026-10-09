@extends('layout')
@section('title', 'Inicio')
@section('atributo_actu', 'hidden')
@section('atributo_1', 'hidden')

{{-- @section('foto', auth()->user()->avatar)
@section('nombre', auth()->user()->personal->nombres)
@section('area', auth()->user()->name) --}}
@section('content')
    <style>
        ul {
            padding-left: 0px;
        }
    </style>
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5 style="color:#0073c1">Control de Eventos</h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="ibox">
                                    <div class="ibox-title" style="border-top:none">
                                        <h5>Compra</h5>
                                        <span class="label label-success float-right">{{ ucfirst(strftime('%B')) }}</span>
                                    </div>
                                    <div class="ibox-content" align="center">
                                        <strong>Entrada por kardex</strong>
                                        <h1>{{ $return_kardex }}</h1>
                                        {{-- <h1>{{$return_kardex_ext}}</h1>  --}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="ibox">
                                    <div class="ibox-title" style="border-top:none">
                                        <img src="{{ asset('sunat.png') }}" width="25px">
                                        <h5>Ventas</h5>
                                        <span class="label label-success float-right">{{ ucfirst(strftime('%B')) }}</span>
                                    </div>
                                    <div class="ibox-content" align="center">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <strong>Facturas</strong>
                                                <h1>{{ $return_tot_fact }}</h1>
                                                <small>*Incluye Facturas Manuales</small>
                                            </div>
                                            <div class="col-sm-6">
                                                <strong>Boletas</strong>
                                                <h1>{{ $return_tot_bol }}</h1>
                                                <small>*Incluye Boletas Manuales</small>
                                            </div>
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
                                <span class="m-r-sm text-muted welcome-message"><img
                                        src="{{ asset('img/logos/' . $empresa->foto) }}" height="50px"></span>
                            </div>
                            <div class="ibox-content profile-content">
                                <h4><strong> {{ $empresa->nombre }}</strong></h4>
                                <p><i class="fa fa-map-marker"></i>{{ $empresa->calle }}</p>
                                <h5>Sobre mi:</h5>
                                <p>{{ $empresa->descripcion }}</p>
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
                                <h5>Los 5 productos más vendidos del mes </h5><small> Solo Facturas </small>
                            </div>
                            <div class="ibox-content">
                                @if ($array_prod_all[0]['cantidad'] != 0)
                                    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                                        <div class="carousel-inner">
                                            @foreach ($array_prod_all as $item => $array_prod)
                                                @if ($item == 0)
                                                    <div class="carousel-item active">
                                                    @else
                                                        <div class="carousel-item">
                                                @endif
                                                <div class=" text-center">
                                                    <img src="{{ asset('/archivos/imagenes/productos/') }}/{{ $array_prod_all[$item]['imagen'] }}"
                                                        style="width:200px; height: 200px;padding: 20px; border:3px solid #2196f3; border-radius: 5px;">
                                                </div>
                                                <center>
                                                    <p class="font-bold">{{ $array_prod_all[$item]['nombre'] }}</p>
                                                </center>
                                                <div class="text-center">
                                                    <span
                                                        class="btn btn-xs btn-white">{{ $array_prod_all[$item]['cantidad'] }}
                                                        veces vendido </span><br><br>
                                                    <span
                                                        class="btn btn-xs btn-primary">{{ $array_prod_all[$item]['precio'] }}
                                                        aproximados</span>
                                                </div>
                                        </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleControls" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    @else
                        <div class="">
                            <h3>No hay Facturas creadas este mes</h3>
                        </div>
                        @endif
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
                                <h3 class="font-bold no-margins">{{ auth()->user()->personal->nombres }}
                                    {{ auth()->user()->personal->apellidos }} </h3>
                                <small>Usuario interacuando en el sistema</small>
                            </div>
                            {{-- <img src="img/a4.jpg" class="rounded-circle circle-border m-b-md" alt="profile"> --}}
                            <img alt="image" class="rounded-circle circle-border m-b-md"
                                src=" {{ asset('/profile/images/') }}/{{ auth()->user()->avatar }} " />
                            <div class="row">
                                <div class="col-lg-4">
                                    <span>
                                        {{ auth()->user()->personal->fecha_nacimiento }}</span><br><small>F.Nacimiento</small>
                                </div>
                                <div class="col-lg-4">
                                    <span> {{ auth()->user()->personal->celular }}</span><br><small>Celular</small>
                                </div>
                                <div class="col-lg-4">
                                    <span> {{ auth()->user()->personal->telefono }}</span><br><small>Telefono</small>
                                </div>

                            </div>
                        </div>
                        <div class="widget-text-box">
                            <h4 class="media-heading"><span> {{ auth()->user()->personal->nombres }}</span></h4>
                            <p>Usuario Activo en la Empresa {{ $empresa->nombre }}.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- {{ session('check_tipo_cambio') }} --}}
    <style>
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.3);
            border-radius: 5px;
        }
    </style>
    @include('partials.page_script_general')


    <script type="text/javascript">
        $('.carousel').carousel({
            interval: 2000
        })
    </script>

    <script>
        $(document).ready(function() {
            @if (session('success'))
                toastr.success("{{ session('success') }}", '', {
                    timeOut: 3000
                });
            @endif

            @if (session('error'))
                toastr.error("{{ session('error') }}", '', {
                    timeOut: 3000
                });
            @endif

            @if (session('warning'))
                toastr.warning("{{ session('warning') }}", '', {
                    timeOut: 3000
                });
            @endif

            @if (session('info'))
                toastr.info("{{ session('info') }}", '', {
                    timeOut: 3000
                });
            @endif
        });
    </script>

    @include('configuracion_general.tipo_cambio.modal_create')

    @if (isset($check_tipo_cambio) &&
            $check_tipo_cambio &&
            auth()->user()->can('tipo_cambio.crear') &&
            !isset($tipo_cambio->fecha))
        <script>
            $(document).ready(function() {
                $('#myajax').click();
                $('#modal-tipo_cambio-create').modal('show');
            })
        </script>
    @else
        <script>
            $(document).ready(function() {
                iniciarConsultaTipoCambio();
            });

            const fecha = '{{ now()->format('Y-m-d') }}';
            let intervaloTipoCambio = null;

            function iniciarConsultaTipoCambio() {
                if (intervaloTipoCambio !== null) {
                    return;
                }
                intervaloTipoCambio = setInterval(function() {
                    $.get('{{ route('tipo_cambio.busqueda_tipo_cambio') }}', {
                            fecha: fecha
                        })
                        .done(function(response) {
                            if (response.success) {
                                detenerConsultaTipoCambio();
                                toastr.clear();
                                $('#modal-espera').modal('hide');
                                $('#modal-principal').modal('show');
                                toastr.success("El administrador ingresó el Tipo de Cambio del día.", '', {
                                    showDuration: 0,
                                    hideDuration: 0,
                                    timeOut: 0,
                                    extendedTimeOut: 0,
                                });
                            }
                        })
                        .fail(function(xhr) {
                            if (xhr.status === 404) {
                                toastr.warning(
                                    "Espere a que un administrador ingrese el Tipo de Cambio Diario",
                                    '', {
                                        timeOut: 5000,
                                        extendedTimeOut: 0,
                                        closeButton: true
                                    }
                                );
                            }
                        });
                }, 5000);
            }

            function detenerConsultaTipoCambio() {
                if (intervaloTipoCambio !== null) {
                    clearInterval(intervaloTipoCambio);
                    intervaloTipoCambio = null;
                }
            }
        </script>
    @endif
@endsection
