@extends('layout')

@section('title', 'Apariencia')
@section('breadcrumb', 'Apariencia')
@section('breadcrumb2', 'Apariencia')
@section('button2', 'Inicio')
@section('config', route('Configuracion'))

@section('content')

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
    </div>
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

@endsection
