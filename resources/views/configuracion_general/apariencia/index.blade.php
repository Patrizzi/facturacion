@extends('layout')

@section('title', 'Apariencia')
@section('breadcrumb', 'Apariencia')
@section('breadcrumb2', 'Apariencia')
@section('button2', 'Inicio')
@section('config', route('Configuracion'))

@section('content')
    <!--
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Configuracion de Apariencia </h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-wrench"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="#" class="dropdown-item">Config option 1</a>
                                </li>
                                <li><a href="#" class="dropdown-item">Config option 2</a>
                                </li>
                            </ul>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    @foreach ($config as $configs)
                        <div class="ibox-content">
                            <form action="{{ route('apariencia.update', $configs->id) }}" enctype="multipart/form-data"
                                method="post">

                                @csrf
                                @method('PATCH')
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h2><strong>Perfil</strong></h2>
                                        <div class="ibox-content">
                                            <div class="">
                                                <div class="content">
                                                    <div class="row">
                                                        <div class="col-lg-4">
                                                            <h4>Fondo de Perfil: </h4>
                                                            <select name="fondo_perfil" class="form-control m-b">
                                                                <option value="{{ $configs->fondo_perfil }}">
                                                                    {{ $configs->fondo_perfil }}</option>
                                                                <option value="gris.png">gris.png</option>
                                                                <option value="azul_claro.png">azul_claro.png</option>
                                                                <option value="azul.jfif">azul.jfif</option>
                                                                <option value="naranja.png">naranja.png</option>
                                                                <option value="paisaje_atardecer.jpg">paisaje_atardecer.jpg
                                                                </option>
                                                                <option value="paisaje_noche.jpg">paisaje_noche.jpg</option>
                                                                <option value="paisaje.jpg">paisaje.jpg</option>
                                                            </select>
                                                            <hr>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <h4>Borde del Perfil: </h4>
                                                            <select name="borde_foto" class="form-control m-b">
                                                                <option value="{{ $configs->borde_foto }}">
                                                                    {{ $configs->borde_foto }}</option>
                                                                <option value="0px">0px</option>
                                                                <option value="1px">1px</option>
                                                                <option value="2px">2px</option>
                                                                <option value="3px">3px</option>
                                                                <option value="4px">4px</option>
                                                            </select>
                                                            <hr>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <h4>Color del Borde del Perfil: </h4>
                                                            <input type="color" class="form-control m-b"
                                                                style="height: 33px" name="color_borde_foto"
                                                                value="{{ $configs->color_borde_foto }}">
                                                            <hr>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <h4>Color del Nombre: </h4>
                                                            <input type="color" class="form-control m-b"
                                                                style="height: 33px" name="color_nombre"
                                                                value="{{ $configs->color_nombre }}">
                                                            <hr>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <h4>Sombras del Nombre: </h4>
                                                            <input type="color" class="form-control m-b"
                                                                style="height: 33px" name="color_sombra_nombre"
                                                                value="{{ $configs->color_sombra_nombre }}">
                                                            <hr>
                                                        </div>
                                                        <div class="col-lg-4">
                                                            <h4>Letra de Nombre: </h4>
                                                            <select name="tamano_letra_perfil" class="form-control">
                                                                <option value="{{ $configs->tamano_letra_perfil }}">
                                                                    {{ $configs->tamano_letra_perfil }}</option>
                                                                <option value="12px">12px</option>
                                                                <option value="15px">15px</option>
                                                                <option value="18px">18px</option>
                                                            </select>
                                                            <hr>
                                                        </div>
                                                        <div class="col-lg-12 text-right">
                                                            <button type="sumbit" class="btn btn-success"><i
                                                                    class="fa fa-refresh" aria-hidden="true"></i>
                                                                Guardar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> {{-- col-sm-6 --}}
                                    <div class="col-lg-6">
                                        <h2><strong>Otros</strong></h2>
                                        <div class="ibox-content">
                                            <div class="">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <h4>Iconografía: </h4>
                                                        <select name="foto_icono" class="form-control m-b">
                                                            <option value="{{ $configs->foto_icono }}">
                                                                {{ $configs->foto_icono }}</option>
                                                        </select>
                                                        <hr>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <h4>Tamaño de Fuente: </h4>
                                                        <select name="tamano_letra" class="form-control">
                                                            <option value="x-small" @if ($configs->tamano_letra == 'x-small') selected @endif>x-small</option>
                                                            <option value="smaller" @if ($configs->tamano_letra == 'smaller') selected @endif>smaller</option>
                                                            <option value="" @if ($configs->tamano_letra == '') selected @endif>100%*</option>
                                                            <option value="medium" @if ($configs->tamano_letra == 'medium') selected @endif>medium</option>
                                                            <option value="large" @if ($configs->tamano_letra == 'large') selected @endif>large</option>
                                                            <option value="x-large" @if ($configs->tamano_letra == 'x-large') selected @endif>x-large</option>
                                                        </select>
                                                        <hr>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <h4>Tipo de Fuente: </h4>
                                                        <select name="letra" class="form-control">
                                                            <option value="{{ $configs->letra }}">
                                                                {{ $configs->letra }}</option>
                                                            <option value="cursive">cursive</option>
                                                            <option value=" sans-serif">sans-serif</option>
                                                            <option value="none">none</option>
                                                        </select>
                                                        <hr>
                                                    </div>
                                                    <div class="col-lg-6 text-right">
                                                        <br>
                                                        <button type="sumbit" class="btn btn-success"><i
                                                            class="fa fa-refresh" aria-hidden="true"></i>
                                                        Cambiar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <h2><strong>Comprobantes</strong></h2>
                                        <div class="ibox-content">
                                            <div class="">
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <h4>Firma en Guia de Remision</h4>
                                                        <strong>Ocultar&nbsp;</strong><input type="checkbox" class="js-switch" name="remision_firma" @if(Auth::user()->config->guia_remision_firma == 0) checked @endif/><strong>&nbsp;Mostrar</strong>
                                                        <hr>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <h4>Firma en Cotizacion</h4>
                                                        <strong>Ocultar&nbsp;</strong><input type="checkbox" class="js-switch-coti" name="coti_firma" @if(Auth::user()->config->cotizacion_firma == 0) checked @endif/><strong>&nbsp;Mostrar</strong>
                                                        <hr>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <h4>Firma en Nota Venta</h4>
                                                        <strong>Ocultar&nbsp;</strong><input type="checkbox" class="js-switch-nventa" name="nventa_firma" @if(Auth::user()->config->nventa_firma == 0) checked @endif/><strong>&nbsp;Mostrar</strong>
                                                        <hr>
                                                    </div>
                                                    <div class="col-lg-12 text-right">
                                                        <br>
                                                        <button type="sumbit" class="btn btn-success"><i
                                                            class="fa fa-refresh" aria-hidden="true"></i>
                                                        Cambiar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>{{-- row --}}
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>-->

    <div class="container-fluid">
        <div class="content m-4">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Configuración de apariencia</h5>
                            <div class="ibox-tools">
                                <a class="collapse-link" href="">
                                    <i class="fa fa-chevron-up"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li><a href="#" class="dropdown-item">Config option 1</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs d-flex justify-content-end">
                                    <li>
                                        <a class="nav-link active" data-toggle="tab" href="#tab-10">
                                        Perfil
                                        </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="tab-10" class="tab-pane active">
                                        <div class="panel-body">
                                            <div class="row">
                                                <!-- Primera columna de la fila - Perfil -->
                                                <div class="col-6 px-3">
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Fondo de perfil:</label>
                                                        <select class="form-control col m-b" name="account">
                                                            <option>noche_oscura.png</option>
                                                            <option>option 2</option>
                                                            <option>option 3</option>
                                                            <option>option 4</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-lg-3 col-form-label">Borde de perfil:</label>
                                                        <select class="form-control col m-b" name="account">
                                                            <option>0px</option>
                                                            <option>3px</option>
                                                            <option>5px</option>
                                                            <option>8px</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group row">
                                                        <p class="col-lg-3 col-form-label">Tamaño de Nombre:</p>
                                                        <div class="col-lg-9 p-0 pt-2">
                                                            <div id="basic_slider2"></div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!-- Segunda columna de la fila - Perfil -->
                                                <div class="col-6 px-5">
                                                    <div class="row">
                                                        <label class="col-lg-3 col-form-label">Color de Nombre:</label>
                                                        <a data-color="rgb(255, 255, 255)" id="demo_apidemo" class="btn btn-white btn-block colorpicker-element col-lg-9" href="#">Paleta de colores</a>
                                                    </div>
                                                    <div class="form-group row pt-4">
                                                        <label class="col-lg-12 col-form-label">Color:</label>
                                                        <div class="col-lg-12 ml-3 row d-flex justify-content-between">
                                                            <a href="#" class="col-auto rounded-circle bg-danger circle-size my-md-2"></a>
                                                            <a href="#"  class="col-auto rounded-circle bg-warning circle-size my-md-2"></a>
                                                            <a href="#" class="col-auto rounded-circle bg-primary circle-size my-md-2"></a>
                                                            <a href="#" class="col-auto rounded-circle bg-success circle-size my-md-2"></a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <!-- Segundo tab - Comprobantes -->
                                <div class="tabs-container col-6">
                                    <ul class="nav nav-tabs">
                                        <li>
                                            <a class="nav-link active" data-toggle="tab" href="#tab-2">
                                            Comprobante
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="tab-2" class="tab-pane active">
                                            <div class="panel-body">
                                                <div class="row m-3">
                                                    <div class="col-1 switch mx-3">
                                                        <div class="onoffswitch">
                                                            <input type="checkbox" checked="" class="onoffswitch-checkbox" id="example1">
                                                            <label class="onoffswitch-label" for="example1">
                                                                <span class="onoffswitch-inner"></span>
                                                                <span class="onoffswitch-switch"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <label class="col-10 pt-0 px-4">Mostrar firma en Guía de Remisión</label>
                                                </div>
                                                <div class="row m-3">
                                                    <div class="col-1 switch mx-3">
                                                        <div class="onoffswitch">
                                                            <input type="checkbox" checked="" class="onoffswitch-checkbox" id="example2">
                                                            <label class="onoffswitch-label" for="example2">
                                                                <span class="onoffswitch-inner"></span>
                                                                <span class="onoffswitch-switch"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <label class="col-10 pt-0 px-4">Mostrar firma en Cotización</label>
                                                </div>
                                                <div class="row m-3">
                                                    <div class="col-1 switch mx-3">
                                                        <div class="onoffswitch">
                                                            <input type="checkbox" checked="" class="onoffswitch-checkbox" id="example3">
                                                            <label class="onoffswitch-label" for="example3">
                                                                <span class="onoffswitch-inner"></span>
                                                                <span class="onoffswitch-switch"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <label class="col-10 pt-0 px-4">Mostrar firma en Nota Venta</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Tercer tab - Otros -->
                                <div class="tabs-container col-6">
                                    <ul class="nav nav-tabs">
                                        <li>
                                            <a class="nav-link active" data-toggle="tab" href="#tab-3">
                                                Otros
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="tab-3" class="tab-pane active">
                                            <div class="panel-body">

                                                <div class="form-group row px-3">
                                                    <p class="col-lg-3 col-form-label">Tamaño de Fuente:</p>
                                                    <div class="col-lg-9 p-0 pt-2">
                                                        <div id="basic_slider"></div>
                                                    </div>
                                                </div>

                                                <div class="form-group row px-3">
                                                    <label class="col-lg-3 col-form-label">Fuente:</label>
                                                    <select class="form-control col m-b" name="account">
                                                        <option>Times New Roman</option>
                                                        <option>option 2</option>
                                                        <option>option 3</option>
                                                        <option>option 4</option>
                                                    </select>
                                                </div>

                                                <div class="form-group row px-3">
                                                    <label class="col-lg-3 col-form-label">Color de fondo:</label>
                                                    <select class="form-control col m-b" name="account">
                                                        <option>Claro</option>
                                                        <option>Oscuro</option>
                                                        <option>option 3</option>
                                                        <option>option 4</option>
                                                    </select>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-4">
                                <button class="btn btn-success col-auto" type="button">Guardar cambios</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="colorPicker" class="colorpicker dropdown-menu" style="display: none;">
        <div class="colorpicker-saturation" style="background-color: rgb(6, 1, 1);">
            <i style="top: 97.6001px; left: 88.2px;"><b></b></i>
        </div>
        <div class="colorpicker-hue">
            <i style="top: 100px;"></i>
        </div>
        <div class="colorpicker-alpha" style="background-color: rgb(6, 1, 1);">
            <i style="top: 0px;"></i>
        </div>
        <div class="colorpicker-color" style="background-color: rgb(6, 1, 1);">
            <div style="background-color: rgb(6, 1, 1);"></div>
        </div>
    </div>

    <style>
        .circle-size{
            min-height: 110px;
            min-width: 110px;
        }
    </style>

    <style>
        .form-control {
            border-radius: 10px
        }

        .text_des {
            border-radius: 10px;
            border: 1px solid #e5e6e7;
            width: 80px;
            padding: 6px 12px;
        }

        .check {
            -webkit-appearance: none;
            height: 34px;
            background-color: #ffffff00;
            -moz-appearance: none;
            border: none;
            appearance: none;
            width: 80px;
            border-radius: 10px;
        }

        .div_check {
            position: relative;
            top: -33px;
            left: 0px;
            background-color: #ffffff00;
            top: -35;
        }

        .check:checked {
            background: #0375bd6b;
        }
    </style>

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <link href="{{asset('css/plugins/switchery/switchery.css')}}" rel="stylesheet">
    <!-- Switchery -->
    <script src="{{asset('js/plugins/switchery/switchery.js')}}"></script>

    <!-- Color Picker -->
    <script src="{{ asset('js/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
    <!-- Chosen -->
    <script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>

    <!-- JSKnob -->
    <script src="{{ asset('js/plugins/jsKnob/jquery.knob.js') }}"></script>

    <!-- Input Mask-->
    <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>

    <script src="{{ asset('js/plugins/nouslider/jquery.nouislider.min.js') }}"></script>

    <link href="{{ asset('css/plugins/nouslider/jquery.nouislider.css') }}" rel="stylesheet">

    <link href="{{ asset('css/plugins/colorpicker/bootstrap-colorpicker.min.css') }}" rel="stylesheet">

    <script>
        $(document).ready(function() {

            // Add slimscroll to element
            $('.scroll_content').slimscroll({
                height: '200px'
            })

        });
        var elem_2 = document.querySelector('.js-switch');
        var switchery_2 = new Switchery(elem_2, { color: '#ED5565' });

        var elem_3 = document.querySelector('.js-switch-coti');
        var switchery_3 = new Switchery(elem_3, { color: '#ED5565' });

        var elem_4 = document.querySelector('.js-switch-nventa');
        var switchery_4 = new Switchery(elem_4, { color: '#ED5565' });

    </script>


    <script>
        var basic_slider = document.getElementById('basic_slider');

        noUiSlider.create(basic_slider, {
            start: 40,
            behaviour: 'tap',
            connect: 'upper',
            range: {
                'min':  20,
                'max':  80
            }
    });
        var basic_slider2 = document.getElementById('basic_slider2');

        noUiSlider.create(basic_slider2, {
            start: 40,
            behaviour: 'tap',
            connect: 'upper',
            range: {
                'min':  20,
                'max':  80
            }
    });
    </script>

    <script>
        $(document).ready(function() {
            /*
            $('#demo_apidemo').on('click', function(event) {
                event.preventDefault();
                $('#colorPicker').toggle();
            });*/


            $(document).on('click', function(event) {
                if (!$(event.target).closest('#colorPicker').length && !$(event.target).is('#demo_apidemo')) {
                    $('#colorPicker').hide();
                }
            });

            // Inicializa el color picker
            $('#demo_apidemo').colorpicker();
        });
    </script>


@endsection
