    <!DOCTYPE html>
<html lang="es">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{ asset('/archivos/imagenes/servicios/') }}/@yield('3', auth()->user()->config->foto_icono)" rel="shortcut icon" />
    <title>@yield('title', 'Inicio')/@yield('3', auth()->user()->name)</title>

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    {{-- <script src="@yield('vue_js', '#')" defer></script> --}}
    
    <link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/footable/footable.core.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/blueimp/css/blueimp-gallery.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/slick/slick.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/slick/slick-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/plugins/c3/c3.min.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('main.css') }}" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="{{ asset('img/icono.svg') }}" sizes="any">
    <link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/side-bar/side-bar.css') }}">
    @yield('styles')
    <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

</head>


{{-- <body class="mini-navbar"> --}}
<body class="" style="margin: 0px !important;">
    <div id="wrapper" style="">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu"
                    style="height:90vh !important; overflow-y: auto;  display: block; top: 0px">
                    <li class="first-element" style="background-color: white;width: 100% !important;">
                        <a href="{{ route('usuario.index') }}" class="head-nav-logo" style=" padding: 20px 0px;">
                            <img alt="image" class="rounded-circle"
                                src="{{ asset('/archivos/imagenes/layout/Leonosoft.png') }}"
                                style="width: 60px; height: 60px;" />
                            <span class="nav-label"
                                style="color: #2641f8; font-size: 18px; font-weight: bold;">LEONO</span><span
                                style="color: gray; font-size: 18px; font-weight: bold;">SOFT</span>
                        </a>
                    </li>
                    @foreach($menus as $menu)
                        @if($menu['type'] === 'single')
                            <li>
                                <a href="{{ $menu['route'] }}">
                                    <i class="{{ $menu['icon'] }} fa-lg text-white"></i>
                                    <span class="nav-label">{{ $menu['label'] }}</span>
                                </a>
                            </li>
                        @endif

                        @if($menu['type'] === 'tree')
                            <li>
                                <a href="#">
                                    <i class="{{ $menu['icon'] }}"></i>
                                    <span class="nav-label">{{ $menu['label'] }}</span>
                                </a>

                                <ul class="nav nav-second-level">
                                    @foreach($menu['children'] as $child)
                                        @if(isset($child['children']))
                                            <li>
                                                <a href="#">{{ $child['label'] }}</a>
                                                <ul class="nav nav-third-level">
                                                    @foreach($child['children'] as $sub)
                                                        <li>
                                                            <a href="{{ $sub['route'] }}">
                                                                {{ $sub['label'] }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{ $child['route'] }}">
                                                    {{ $child['label'] }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        @endif

                    @endforeach
                </ul>
                <div style="max-height: 70px;" class="nav-last-footer">
                    <div 
                        class="" style="width: 100%">
                        <div class="nav-label"  style="display: flex;flex-direction: row;align-items: center;white-space: initial !important;justify-content: space-between;">
                            <a href="{{route('usuario.perfil')}}" style="display: flex;flex-direction: row;align-items: center;" >
                                <img alt="image" class="rounded-circle"
                                    src="{{ asset('/profile/images/') }}/@yield('foto', auth()->user()->avatar)"
                                    style="border: 1px solid black;background-color: white;height:45px;width: 45px" />
                                <div class="nav-label" style="margin-left: 10px;">
                                    <span class="block m-t-xs font-bold spans"
                                        style="font-size: 14px;color: white">{{$empresa->nombre}}</span>
                                    <span class="block m-t-xs text-white font-bold mr-3">@yield('area', auth()->user()->name)</span>
                                </div>
                            </a>
                            <div class="nav-label" style="">
                                <i class="fa fa-ellipsis-v" id="menuIcon"
                                    style="color: white; font-size: 19px; margin-right: 15px; cursor: pointer;"></i>
                                <!-- Menú desplegable -->
                                <div id="dropdownMenu"
                                    style="display: none; position: absolute; bottom: 50px; right: 0; background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); border-radius: 5px; padding: 10px; width: 150px;">
                                    @canany(['perfil_usuario.ver', 'perfil_usuario.editar'])
                                        <a href="{{ route('usuario.perfil') }}" class="dropdown-item"
                                            style="display: block; color: black; padding: 8px; text-decoration: none;">
                                            <i class="fa fa-user-circle-o fa-lg"></i> Mi perfil</a>
                                    @endcan
                                    @canany(['empresa.ver','empresa.editar'])
                                        <a href="{{ route('empresa.index') }}" class="dropdown-item"
                                            style="display: block; color: black; padding: 8px; text-decoration: none;">
                                            <i class="fa fa-university "></i> Mi Empresa</a>
                                    @endcan
                                    @canany(['almacen.listar','apariencia.ver','familia.listar','subfamilia.ver', 'garantia_doc.listar', 'marcas.listar', 'motivos.listar', 'tipo_cambio.listar', 'unidad_m.listar', 'usuarios.listar', 'roles.listar','validez.listar', 'validez.crear', 'alarma.listar'])
                                        <a href="{{ route('configuracion.general') }}" class="dropdown-item"
                                            style="display: block; color: black; padding: 8px; text-decoration: none;">
                                            <i class="fa fa-cog fa-lg"></i> Configuración</a>
                                    @endcan
                                    <a href="#" class="dropdown-item"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                        style="display: block; color: black; padding: 8px; text-decoration: none;">
                                        <i class="fa fa-sign-out fa-lg"></i> Cerrar Sesión
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                        </form>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </nav>
        {{-- Menu Superior --}}
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top bg-white" role="navigation" style="margin-bottom: 0">
                    <div class="container-fluid">
                        <div class="start-header">
                            <div class="navbar-center">
                                <div class="col-lg-12">
                                        <div class="row tipo_cambio">
                                            @if (isset($tipo_cambio->fecha))
                                                <div class="col-sm-4">
                                                    <div style="color: black" class="text-center">
                                                        <strong>Compra:</strong>
                                                        <div><span>{{ $tipo_cambio->compra }}</span></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div style="color: black" class="text-center">
                                                        <strong>Venta:</strong>
                                                        <div><span>{{ $tipo_cambio->venta }}</span></div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div style="color: black" class="text-center">
                                                        <strong>Paralelo:</strong>
                                                        <div><span id="tc_paralelo">{{ $tipo_cambio->paralelo }}</span></div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                            </div>
                        </div>

                        <div class="mensajes1">
                            @php $mostrar = false; @endphp
                            <div class="custom-container">
                                <div class="left-side left">
                                    <i class="fa fa-bell mx-3"></i>
                                    <div class="left-side-slider">
                                        @once @php $x = 0; @endphp @endonce
                                        <div class="slides">
                                            @canany(['factura.emitir','factura_m.emitir'])
                                                @if ($fact_view_count > 0 || $fact_m_view_count > 0)
                                                    <span class="span_slide" style="--i:{{ $x }}">{{ (int) $fact_view_count + (int) $fact_m_view_count ?? '0' }}
                                                        &nbsp; &nbsp;Facturas</span>
                                                    @php $x++ @endphp
                                                    @php $mostrar = true; @endphp
                                                @endif
                                            @endcan
                                            @canany(['boleta.emitir','boleta_m.emitir'])
                                                @if ($bol_view_count > 0 || $bol_m_view_count > 0)
                                                    <span class="span_slide" style="--i:{{ $x }}">{{ (int) $bol_view_count + (int) $bol_m_view_count ?? '0' }}
                                                        &nbsp; &nbsp;Boletas</span>
                                                    @php $x++ @endphp
                                                    @php $mostrar = true; @endphp
                                                @endif
                                            @endcan
                                            @canany(['guia_remision.emitir','guia_remision_m.emitir'])
                                                @if ($guia_view_count > 0 || $guia_m_view_count > 0)
                                                    <span class="span_slide" style="--i:{{ $x }}">{{ (int) $guia_view_count + (int) $guia_m_view_count ?? '0' }}
                                                        &nbsp; &nbsp;Guías R.</span>
                                                    @php $x++ @endphp
                                                    @php $mostrar = true; @endphp
                                                @endif
                                            @endcan
                                            @can('nota_credito.emitir')
                                                @if ($n_credito_view_count > 0)
                                                    <span class="span_slide" style="--i:{{ $x }}">{{ $n_credito_view_count ?? '0' }} &nbsp; &nbsp;Nota C.</span>
                                                    @php $x++ @endphp
                                                    @php $mostrar = true; @endphp
                                                @endif
                                            @endcan
                                            @can('nota_debito.emitir')
                                                @if ($n_debito_view_count > 0)
                                                    <span class="span_slide" style="--i:{{ $x }}">{{ $n_debito_view_count ?? '0' }} &nbsp; &nbsp; Nota D.</span>
                                                    @php $x++ @endphp
                                                    @php $mostrar = true; @endphp
                                                @endif
                                            @endcan
                                            @if (! $mostrar)
                                                <span class="span_slide" style="--i:{{ $x }}">0 &nbsp; &nbsp;Ningún doc.</span>
                                                @php $x++ @endphp
                                            @endif
                                        </div>
                                        <style>
                                            :root {
                                                --top_marg: {{$x}};
                                            }

                                        </style>
                                        @if($x > 0)
                                        <style>
                                            .left-side.left > i {
                                                animation: scalePulse 1.2s ease-in-out infinite;
                                                will-change: transform;         /* sugiere al navegador optimizar */
                                                backface-visibility: hidden;    /* evita parpadeo */
                                                transform-origin: center center;
                                            }

                                        </style>
                                        @endif
                                    </div>

                                </div>
                                <div class="right-side">
                                    {{-- <i class="fa fa-bell mx-3"></i> --}}
                                    <div class="left-side-slider">
                                        <div class="slides2">

                                            @if ($fact_view_count > 0 || $fact_m_view_count > 0)
                                                <a class="link span_slide2" href="{{route('facturacion_electronica.index')}}">Enviar a Sunat</a>

                                            @endif
                                            @if ($bol_view_count > 0 || $bol_m_view_count > 0)
                                                <a class="link span_slide2" href="{{route('facturacion_electronica.index_boleta')}}">Enviar a Sunat</a>

                                            @endif
                                            @if ($guia_view_count > 0 || $guia_m_view_count > 0)
                                                <a class="link span_slide2" href="{{route('facturacion_electronica.index_guia_remision')}}">Enviar a Sunat</a>

                                            @endif
                                            @if ($n_credito_view_count > 0)
                                                <a class="link span_slide2" href="{{route('facturacion_electronica.index_nota_credito')}}">Enviar a Sunat</a>

                                            @endif
                                            @if ($n_debito_view_count > 0)
                                                <a class="link span_slide2" href="{{route('facturacion_electronica.index_nota_debito')}}">Enviar a Sunat</a>

                                            @endif
                                            @if (! $mostrar)
                                                <a class="link span_slide2 disabled" href="javascript:void(0)">Enviar a Sunat</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mensajes2">
                            <div class="custom-container">
                                <div class="left-side">
                                    <i class="fa fa-exclamation-circle fa-2x mx-3"></i>
                                    <span>0 de 0</span>
                                </div>
                                <div class="right-side">
                                    <a class="link">Mensajes</a>
                                </div>
                            </div>
                        </div>
                        <div class="mensajes2-mobile">
                            <li>
                                <a href=""  class="count-info">
                                    <i class="fa fa-bell fa-lg fa-3x" style="color: #1a3bb3;"></i><span class="label label-warning">0</span>
                                </a>
                            </li>
                        </div>

                        <div class="calendar-none">
                            <li class="">
                                <a href="{{ route('eventos.user_indes') }}" class="count-info">
                                    <i class="fa fa-calendar fa-lg fa-3x " style="color: #1a3bb3"></i>
                                    {{-- @if ($count_eventos != 0) --}}
                                        <span class="label label-warning">{{ $count_eventos }}</span>
                                    {{-- @endif --}}
                                </a>
                            </li>
                        </div>
                        {{-- @can('')
                            <div>
                                <li class="">
                                    <a href="{{ route('email.index') }}" class="count-info">
                                        <i class="fa fa-envelope fa-lg fa-3x " style="color: #1a3bb3"></i>
                                    </a>
                                </li>
                            </div>
                        @endcan --}}
                    </div>
            </div>

            {{-- <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-sm-4">
                    <h2>@yield('title', 'Inicio')</h2>
                </div>
                <div class="col-sm-8">
                    <div class="title-action">
                        <a style="visibility:@yield('visibility', 'hidden')"href="@yield('ruta', '')"
                            class="btn btn-primary">@yield('name', '')</a>

                        @yield('boton_opcional')

                        <a data-toggle="@yield('data-toggle', '')" onclick="@yield('onclick1', '')" href="@yield('href_accion', '#')"
                            class="btn btn-primary" @yield('atributo_1', '')>@yield('value_accion', '#')</a>

                        <a id="actualizar" data-toggle="@yield('data-config', '')" onclick="@yield('onclick', '')"
                            href="@yield('config', '')" class="@yield('class', 'btn btn-primary')"
                            @yield('atributo_actu', '')>@yield('button2', 'Actualizar')</a>
                    </div>
                </div>
            </div> --}}

            @yield('content')


            <div class="footer">
                <div class="float-right">
                    Visitanos: &nbsp;&nbsp; <a href="https://www.facebook.com/JYPPERIFERICOSSAC" target="_blank"><i
                            class="fa fa-facebook-square" aria-hidden="true"></i></a>&nbsp;
                    <a href="https://api.whatsapp.com/send?phone=51946201443&text=Hola!%20Necesito%20Ayuda%20con%20el%20sistema%20de%20Facturación,%20Gracias!%20"
                        target="_blank"><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
                </div>
                <div>
                    <strong>Copyright </strong> &nbsp;<a href="http://www.jypsac.com" target="_blank"> JyP
                        Periféricos</a>&nbsp; &copy; 2019-{{ date('Y') }}
                </div>

            </div>


            {{-- <ul class="nav navbar-top-links navbar-right" >
                    <li class="dropdown" style="margin: 0px 50px" @if ($fact_view_count > 0 || $fact_m_view_count > 0 || $bol_view_count > 0 || $bol_m_view_count > 0 || $n_credito_view_count || $n_debito_view_count)  data-toggle="popover" data-placement="left" data-content="Tiene documentos pendientes de enviar a SUNAT"  @endif  id="btn_popover">
                        <a class="dropdown-toggle count-info " data-toggle="dropdown" href="#" style="">
                            <i class="fa fa-bell " style="font-size: 18px; @if ($fact_view_count > 0 || $fact_m_view_count > 0 || $bol_view_count > 0 || $bol_m_view_count > 0 || $n_credito_view_count || $n_debito_view_count) color: red @endif"></i>
                        </a> --}}
            {{-- SI HAY PARA ENVIAR --}}
            {{-- <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell"></i> <span class="label label-primary">Cantidad de Facturas</span>
                        </a> --}}
            {{-- <ul class="dropdown-menu dropdown-alerts" style="padding: 1px">
                            @if ($fact_view_count > 0 || $fact_m_view_count > 0)
                            <li>
                                <a href="{{route('facturacion_electronica.index')}}" class="dropdown-item">
                                    <div>
                                        Tiene @if ($fact_view_count > 0) <strong>{{$fact_view_count}} Facturas</strong>  @endif @if ($fact_m_view_count > 0 && $fact_view_count > 0) y @endif  @if ($fact_m_view_count > 0) <strong>{{$fact_m_view_count}} Facturas Manuales</strong> @endif pendientes de enviar a SUNAT
                                    </div>
                                </a>
                            </li>
                            @endif
                            @if ($bol_view_count > 0 || $bol_m_view_count > 0)
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a href="{{route('boletas_electronicas.index_boleta')}}" class="dropdown-item">
                                        <div>
                                            Tiene @if ($bol_view_count > 0) <strong>{{$bol_view_count}} Boletas</strong>  @endif @if ($bol_m_view_count > 0 && $bol_view_count > 0) y @endif  @if ($bol_m_view_count > 0) <strong>{{$bol_m_view_count}} Boletas Manuales</strong> @endif pendientes de enviar a SUNAT
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if ($guia_view_count > 0 || $guia_m_view_count > 0)
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a href="{{route('guias_electronicas.index_guia_remision')}}" class="dropdown-item">
                                        <div>
                                            Tiene @if ($guia_view_count > 0) <strong>{{$guia_view_count}} Guia R.</strong>  @endif @if ($guia_m_view_count > 0 && $guia_view_count > 0) y @endif  @if ($guia_m_view_count > 0) <strong>{{$guia_m_view_count}} Guias R. Manuales</strong> @endif pendientes de enviar a SUNAT
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if ($n_credito_view_count > 0)
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a href="{{route('facturacion_electronica.index_nota_credito')}}" class="dropdown-item">
                                        <div>
                                            Tiene @if ($n_credito_view_count > 0) <strong>{{$n_credito_view_count}} Nota Credito</strong>  @endif pendientes de enviar a SUNAT
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if ($n_debito_view_count > 0)
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a href="{{route('facturacion_electronica.index_nota_debito')}}" class="dropdown-item">
                                        <div>
                                            Tiene @if ($n_debito_view_count > 0) <strong>{{$n_debito_view_count}} Nota Debito</strong>  @endif   pendientes de enviar a SUNAT
                                        </div>
                                    </a>
                                </li>
                            @endif
                            @if ($fact_view_count == 0 && $fact_m_view_count == 0 && $bol_view_count == 0 && $bol_m_view_count == 0 && $n_credito_view_count == 0 && $n_credito_view_count == 0)
                                <li>
                                    <a href="#">
                                        <div>
                                            Sin envios Pendientes a SUNAT
                                        </div>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                </div>
            </ul> --}}
            {{-- <div class="hide-on2">
                                <div class="dropdown profile-element d-flex align-items-center justify-content-center" style="padding: 0;">
                                    <a href="{{ route('usuario.index') }}" class="d-flex align-items-center text-center">
                                        <span class="block m-t-xs text-black font-bold mr-3 ">@yield('area', auth()->user()->name)</span>
                                        <img alt="image" class="rounded-circle " src="{{ asset('/profile/images/') }}/@yield('foto', auth()->user()->avatar)" style="width: 70px; height: 70px; border: 3px solid black;" />
                                    </a>
                                </div>
                            </div> --}}

            {{-- <div>
                            <li class=" mr-5" >
                                    <a href="{{ route('logout') }}" class="logout-btn"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">

                                    <i class="fa fa-sign-out fa-lg"></i> Cerrar Sesión
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>

                                    </a>
                            </li>
                        </div> --}}
        </div>
        </nav>
    </div>
    </div>
    </div>
    </div>




</body>

<!-- Ladda -->
<script src="{{ asset('js/plugins/ladda/spin.min.js') }}"></script>
<script src="{{ asset('js/plugins/ladda/ladda.min.js') }}"></script>
<script src="{{ asset('js/plugins/ladda/ladda.jquery.min.js') }}"></script>

<!-- Ladda style -->
<link href="{{ asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
<!-- Toastr script -->
<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const slides = document.querySelector(".slides");
        const items = slides.querySelectorAll(".span_slide");

        if (items.length > 1) {
            const itemHeight = items[0].offsetHeight;
            console.log(itemHeight);
            const totalItems = items.length;

            slides.style.setProperty("--items", totalItems);
            slides.style.setProperty("--move", `${itemHeight * totalItems}px`);
            slides.style.setProperty("--duration", `${totalItems * 2}s`); // 2s por item
        }

        const slides2 = document.querySelector(".slides2");
        const items2 = slides2.querySelectorAll(".span_slide2");

        if (items2.length > 1) {
            const itemHeight2 = items2[0].offsetHeight;
            const totalItems2 = items2.length;

            slides2.style.setProperty("--items2", totalItems2);
            slides2.style.setProperty("--move2", `${itemHeight2 * totalItems2}px`);
            slides2.style.setProperty("--duration2", `${totalItems2 * 2}s`); // 2s por item
        }
    });
    $(document).ready(function() {
        Ladda.bind('.ladda-button', {
            timeout: 8000
        });
        $('#btn_popover').click();

        setTimeout(function() {
            $('#btn_popover').popover('hide');
        }, 10);

        function applyMenuBehavior() {
            if (window.matchMedia("(min-width: 768px)").matches) {

                $('body').addClass('mini-navbar');
                $('.navbar-minimalize').off('click');

                $('.navbar-static-side').hover(
                    function() {
                        $('body').removeClass('mini-navbar');
                    },
                    function() {
                        $('body').addClass('mini-navbar');
                    }
                );
            } else {
                $('body').addClass('mini-navbar');
                $('.navbar-static-side').off('mouseenter mouseleave click');
            }
        }

        applyMenuBehavior();

        $(window).resize(function() {
            applyMenuBehavior();
        });
    });
    // Mostrar/ocultar menú desplegable
    document.getElementById("menuIcon").addEventListener("click", function(event) {
        event.stopPropagation(); // Evita que el evento se propague al hacer clic en otros lugares
        const menu = document.getElementById("dropdownMenu");
        menu.style.display = menu.style.display === "none" ? "block" : "none";
    });

    // Cerrar el menú si se hace clic fuera de él
    document.addEventListener("click", function(event) {
        const menu = document.getElementById("dropdownMenu");
        const menuIcon = document.getElementById("menuIcon");
        if (menu.style.display === "block" && !menu.contains(event.target) && event.target !== menuIcon) {
            menu.style.display = "none";
        }
    });


</script>
@yield('scripts')

</html>
