@extends('layout')
@section('title', 'Facturación')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

@section('content')

<!-- Base para Agregar recuadro blanco donde deberia ir el contenido general de lo nuevo que se agrega-->

<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <!-- Acá iria el titulo -->
                    <h4>Resumen de Febrero 2024</h4>
                </div>
                <div class="ibox-content">
                    <!-- Acá iria el tema del contenido -->
                    <div class="row d-flex justify-content-between px-4 text-center">
                        @for ($i = 1; $i <=5; $i++)
                            <div class="col-auto">
                                <div class="border {{ $i==1 ? 'border-danger' : ($i==2 ? 'border-warning' : ($i==3 ? 'border-primary' : ($i==4 ? 'border-success' : 'border-dark'))) }} rounded-circle">
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                </div>
                                @if($i==1)
                                    <h4>Boleta Manual</h4>
                                @elseif ($i==2)
                                    <h4>Factura Manual</h4>
                                @elseif ($i==3)
                                    <h4>Nota de crédito</h4>
                                @elseif ($i==4)
                                    <h4>Nota débito</h4>
                                @else
                                    <h4>Guía de remisión manual</h4>
                                @endif

                                <p>4 documentos</p>

                                <p class="{{ $i == 1 ? 'text-danger' : ($i == 2 ? 'text-warning' : ($i == 3 ? 'text-primary' : ($i == 4 ? 'text-success' : 'text-dark'))) }}"><b>S/***.**</b></p>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--Base para agregar el tab para el los contenidos-->

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="tabs-container">
                        <ul class="nav nav-tabs" role="tablist">
<!--
                            @for ($i=1 ; $i<=5 ; $i++)
                                <li>
                                    <a class="nav-link {{ $i==2 ? 'active show' : '' }}" data-toggle="tab" href="{{ $i == 1 ? '#tab-1' : ( $i == 2 ? '#tab-2' : ( $i == 3 ? '#tab-3' : ( $i == 4 ? '#tab-4' : '#tab-5') )) }}">
                                        @if($i==1)
                                            Boleta manual
                                        @elseif($i==2)
                                            Factura manual
                                        @elseif($i==3)
                                            Nota de crédito
                                        @elseif($i==4)
                                            Nota débito
                                        @else
                                            Guía de remisión manual
                                        @endif

                                    </a>
                                </li>
                            @endfor
                            <li class="">
                                <button class="btn btn-primary btn-lg px-3 mx-3" type="button"><i class="fa fa-plus"></i></i>
                                </button>
                            </li>
                            <li>
                                <button class="btn btn-primary btn-lg" type="button"><i class="fa fa-cloud-download"></i></i>
                                </button>
                            </li>-->

                            <li>
                                <a class="nav-link active show" data-toggle="tab" href="#tab-1">
                                    Boleta manual
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-2">
                                    Factura manual
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-3">
                                    Nota de crèdito
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-4">
                                    Nota dèdito
                                </a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#tab-5">
                                    Guìa de remisiòn manual
                                </a>
                            </li>
                        </ul>

                        <!-- Input seleccionar fecha inicio y fin, y Botón agregar y Descargar -->
                        <div class="d-flex justify-content-md-start row mx-3 mt-4">
                            <div class="input-group col-md-4">
                                <input class="form-control col-md-auto" type="text" name="daterange" value="01/01/2015 - 01/31/2015">
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-secondary px-3"><i class="fa fa-history"></i></button>
                                </span>
                                <span class="input-group-append">
                                    <button type="button" class="btn btn-primary px-3"><i class="fa fa-eraser"></i></button>
                                </span>
                            </div>

                            <div class="row g-3 col-md-5">
                                <div class="col-auto">
                                    <label for="inputPassword6" class="col-form-label">Buscar:</label>
                                </div>
                                <div class="col-md-7">
                                    <input type="password" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
                                </div>
                            </div>
                        </div>

                        <!-- Tablas y su contenido -->
                        <div class="tab-content">
                            <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th><div class="icheckbox_square-green checked" style="position: relative;"><input type="checkbox" checked="" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></th>
                                                <th >ID</th>
                                                <th >Còdigo</th>
                                                <th >RUC/DNI</th>
                                                <th >Cliente</th>
                                                <th>Fecha</th>
                                                <th>Condiciòn</th>
                                                <th>Importe total</th>
                                                <th>Sunat</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><div class="icheckbox_square-green checked" style="position: relative;"><input type="checkbox" checked="" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                            <td>1</td>
                                            <td><span class="pie" style="display: none;">0.52/1.561</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 0 1 14.933563796318165 11.990700825968545 Z" fill="#1ab394"></path><path d="M 8 8 L 14.933563796318165 11.990700825968545 A 8 8 0 1 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                                            <td>203837834</td>
                                            <td>Cibi</td>
                                            <td>Jul 14, 2013</td>
                                            <td>Contado</td>
                                            <td>S/ 1,800.00</td>
                                            <td>
                                                <a href="#"><i class="fa fa-check-circle"></i></a>
                                            </td>
                                            <td>
                                                <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                            <td>2</td>
                                            <td><span class="pie" style="display: none;">6,9</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 0 1 12.702282018339785 14.47213595499958 Z" fill="#1ab394"></path><path d="M 8 8 L 12.702282018339785 14.47213595499958 A 8 8 0 1 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                                            <td>23908223</td>
                                            <td>Dexter</td>
                                            <td>Jul 16, 2013</td>
                                            <td>Contado</td>
                                            <td>s/ 2,456.50</td>
                                            <td>
                                                <a href="#"><i class="fa fa-check-circle"></i></a>
                                            </td>
                                            <td>
                                                <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                            <td>3</td>
                                            <td><span class="pie" style="display: none;">3,1</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 1 1 0 8.000000000000002 Z" fill="#1ab394"></path><path d="M 8 8 L 0 8.000000000000002 A 8 8 0 0 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                                            <td>23908223</td>
                                            <td>Dexter</td>
                                            <td>Jul 18, 2013</td>
                                            <td>Contado</td>
                                            <td>s/ 2,456.50</td>
                                            <td>
                                                <a href="#"><i class="fa fa-check-circle"></i></a>
                                            </td>
                                            <td>
                                                <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                            <td>4</td>
                                            <td><span class="pie" style="display: none;">4,9</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 0 1 15.48012994148332 10.836839096340286 Z" fill="#1ab394"></path><path d="M 8 8 L 15.48012994148332 10.836839096340286 A 8 8 0 1 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                                            <td>23908223</td>
                                            <td>Dexter</td>
                                            <td>Jul 22, 2013</td>
                                            <td>Contado</td>
                                            <td>s/ 2,456.50</td>
                                            <td>
                                                <a href="#"><i class="fa fa-check-circle"></i></a>
                                            </td>
                                            <td>
                                                <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>


                                </div>
                            </div>
                            <div role="tabpanel" id="tab-2" class="tab-pane">
                                <div class="panel-body">
                                    <!-- CONTENIDO DENTRO DEL TAB  2 -->
                                    <table class="table table-striped text-md-center">
                                        <thead>
                                            <tr>
                                                <th><div class="icheckbox_square-green checked" style="position: relative;"><input type="checkbox" checked="" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></th>
                                                <th >ID</th>
                                                <th >Còdigo</th>
                                                <th >RUC/DNI</th>
                                                <th >Cliente</th>
                                                <th>Fecha</th>
                                                <th>Condiciòn</th>
                                                <th>Importe total</th>
                                                <th>Sunat</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><div class="icheckbox_square-green checked" style="position: relative;"><input type="checkbox" checked="" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>1</td>
                                                <td><span class="pie" style="display: none;">0.52/1.561</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 0 1 14.933563796318165 11.990700825968545 Z" fill="#1ab394"></path><path d="M 8 8 L 14.933563796318165 11.990700825968545 A 8 8 0 1 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                                                <td>203837834</td>
                                                <td>Cibi</td>
                                                <td>Jul 14, 2013</td>
                                                <td>Contado</td>
                                                <td>S/ 1,800.00</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>2</td>
                                                <td><span class="pie" style="display: none;">6,9</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 0 1 12.702282018339785 14.47213595499958 Z" fill="#1ab394"></path><path d="M 8 8 L 12.702282018339785 14.47213595499958 A 8 8 0 1 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                                                <td>23908223</td>
                                                <td>Dexter</td>
                                                <td>Jul 16, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>3</td>
                                                <td><span class="pie" style="display: none;">3,1</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 1 1 0 8.000000000000002 Z" fill="#1ab394"></path><path d="M 8 8 L 0 8.000000000000002 A 8 8 0 0 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                                                <td>23908223</td>
                                                <td>Dexter</td>
                                                <td>Jul 18, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><div class="icheckbox_square-green" style="position: relative;"><input type="checkbox" class="i-checks" name="input[]" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                                <td>4</td>
                                                <td><span class="pie" style="display: none;">4,9</span><svg class="peity" height="16" width="16"><path d="M 8 8 L 8 0 A 8 8 0 0 1 15.48012994148332 10.836839096340286 Z" fill="#1ab394"></path><path d="M 8 8 L 15.48012994148332 10.836839096340286 A 8 8 0 1 1 7.999999999999998 0 Z" fill="#d7d7d7"></path></svg></td>
                                                <td>23908223</td>
                                                <td>Dexter</td>
                                                <td>Jul 22, 2013</td>
                                                <td>Contado</td>
                                                <td>s/ 2,456.50</td>
                                                <td>
                                                    <a href="#"><i class="fa fa-check-circle"></i></a>
                                                </td>
                                                <td>
                                                    <a href="#" class="px-3"><i class="fa fa-eye"></i></a>
                                                    <a href="#" class="px-3"><i class="fa fa-check text-navy"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Botones de navegación en la tabla -->
                        <div class="btn-group mt-2">
                            <button type="button" class="btn btn-white"><!--<i class="fa fa-chevron-left"></i>-->Anterior</button>
                            <button class="btn btn-white">1</button>
                            <button class="btn btn-white active">2</button>
                            <button class="btn btn-white">3</button>
                            <button class="btn btn-white">4</button>
                            <button type="button" class="btn btn-white"><!--<i class="fa fa-chevron-right"></i>-->Siguiente</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--Tomar en cuenta el Inspinia para hacer las cosas, en caso sean casos especificos, usar css y js, tratar de seguir la linea del Inspinia-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    $(function() {
    $('input[name="daterange"]').daterangepicker({
        opens: 'left'
    }, function(start, end, label) {
        console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
    });
    });
</script>

@endsection
