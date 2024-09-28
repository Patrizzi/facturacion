 @extends('layout')

 @section('title', 'Configuración Sistema')
 @section('atributo_actu', 'hidden')
 @section('atributo_1', 'hidden')

 @section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content d-flex justify-content-center">
                    <div class="row d-flex justify-content-between p-4">
                        <!-- Elementos de la fila -->
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button" >
                                <a href="{{ route('almacen.index') }}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/almacen.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">ALMACÉN</p>
                                </a>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <a href="{{route('apariencia.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/apariencia.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">APARIENCIA</p>
                                </a>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <a href="{{route('categoria.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/categoria.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">CATEGORÍAS</p>
                                </a>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <a href="{{route('familia.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/familia.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">FAMILIAS</p>
                                </a>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <a href="{{route('garantia.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/garantia.png')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">GARANTÍA</p>
                                </a>
                            </button>
                        </div>

                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <a href="{{route('marca.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/marca.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">MARCAS</p>
                                </a>
                            </button>
                        </div>

                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <a href="{{route('motivo.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/motivo.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">MOTIVO</p>
                                </a>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <a href="{{route('tipo_cambio.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/tipo-cambio.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">TIPO CAMBIO</p>
                                </a>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <a href="{{route('unidad-medida.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/unidad_medida.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">U. DE MEDIDA</p>
                                </a>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <a href="{{route('usuarios.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/usuarios.svg')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">USUARIOS</p>
                                </a>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <button class="btn btn-success dim tam pt-4" type="button">
                                <a href="{{route('validez.index')}}">
                                    <img class="rounded bg-white p-2" src="{{asset('img/logos/validez.png')}}" width="50px" alt="">
                                    <p class="pt-md-3 display-6 fs-4 text-white">VALIDEZ</p>
                                </a>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                            <!-- ELEMENTO FANTASMA - RELLENO -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" >
                            <thead>
                                <tr>
                                    <th>Tema</th>
                                    <th>Tipo de configuración</th>
                                    <th>Ver</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/almacen.svg')}}" width="20px" alt=""></td>
                                    <td>Almacén</td>
                                    <td><a class="btn btn-primary" href="{{ route('almacen.index') }}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/apariencia.svg')}}" width="20px" alt=""></td>
                                    <td>Apariencia</td>
                                    <td><a class="btn btn-primary" href="{{route('apariencia.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/categoria.svg')}}" width="20px" alt=""></td>
                                    <td>Categorías</td>
                                    <td><a class="btn btn-primary" href="{{route('categoria.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/familia.svg')}}" width="20px" alt=""></td>
                                    <td>Familias</td>
                                    <td><a class="btn btn-primary" href="{{route('familia.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                 <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/garantia.png')}}" width="20px" alt=""></td>
                                    <td>Garantia</td>
                                    <td><a class="btn btn-primary" href="{{route('garantia.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/marca.svg')}}" width="20px" alt=""></td>
                                    <td>Marcas</td>
                                    <td><a class="btn btn-primary" href="{{route('marca.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/motivo.svg')}}" width="20px" alt=""></td>
                                    <td>Motivo</td>
                                    <td><a class="btn btn-primary" href="{{route('motivo.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/tipo-cambio.svg')}}" width="20px" alt=""></td>
                                    <td>Tipo de Cambio</td>
                                    <td><a class="btn btn-primary" href="{{route('tipo_cambio.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/unidad_medida.svg')}}" width="20px" alt=""></td>
                                    <td>Unidades de Medidas</td>
                                    <td><a class="btn btn-primary" href="{{route('unidad-medida.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/usuarios.svg')}}" width="20px" alt=""></td>
                                    <td>Usuarios</td>
                                    <td><a class="btn btn-primary" href="{{route('usuarios.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                 <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/validez.png')}}" width="20px" alt=""></td>
                                    <td>Validez</td>
                                    <td><a class="btn btn-primary" href="{{route('validez.index')}}"><i class="fa fa-gear"></i></a></td>
                                </tr>
                                {{-- <tr class="gradeX">
                                    <td><img src="{{asset('img/logos/backup_mail.svg')}}" width="20px" alt=""></td>
                                    <td>Backup de Email</td>
                                    <td><a class="btn btn-primary" href="{{route('email_backup')}}"><i class="fa fa-gear"></i></a></td>
                                </tr> --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
-->

<style>
    /*Para el tamaño de los botones*/
    .tam{
        min-width: 150px;
        min-height: 150px;
    }
</style>

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
@stop
