@extends('layout')
@section('title', 'Guias Ingreso') 
@section('breadcrumb', 'Guia de ingreso')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
{{-- Base para Agregar recuadro blanco donde deberia ir el contenido general de lo nuevo que se agrega--}}

<div class="wrapper wrapper-content animated fadeInRight">
 <div class="row">
  <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        {{-- Acá iria el titulo --}}
                        RESUMEN DE SEPTIEMBRE DEL 2024
                    </div>
                    <div class="ibox-content">
                        {{-- Acá iria el tema del contenido --}}
                        <div class="card-group">
    <div class="card p-3">
      <div class="d-flex justify-content-center align-items-center card-img-top">
        <div class="bg-primary rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px; font-size: 2rem;">
          <i class="bi bi-cloud-arrow-down-fill text-white"></i>
        </div>
      </div>
      <div class="card-body text-center">
        <h5 class="card-title">Guia de Ingreso</h5>
        <p class="card-text">5 Documentos</p>
        <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
      </div>
    </div>
    <div class="card p-3">
      <div class="d-flex justify-content-center align-items-center card-img-top">
        <div class="bg-success rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px; font-size: 2rem;">
          <i class="bi bi-cloud-check-fill text-white"></i>
        </div>
      </div>
      <div class="card-body text-center">
        <h5 class="card-title">Guia de Egreso</h5>
        <p class="card-text">3 Documentos</p>
        <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
      </div>
    </div>
    <div class="card p-3">
      <div class="d-flex justify-content-center align-items-center card-img-top">
        <div class="bg-warning rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px; font-size: 2rem;">
          <i class="bi bi-clipboard2-data-fill text-white"></i>
        </div>
      </div>
      <div class="card-body text-center">
        <h5 class="card-title">Guia de Informe Tecnico</h5>
        <p class="card-text">8 Documentos</p>
        <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
      </div>
    </div>
  </div>


{{--Base para agregar el tab para el los contenidos--}}

<div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <ul class="nav nav-tabs" role="tablist">
                                <li>
                                    <a class="nav-link active show" data-toggle="tab" href="#tab-1"><span style="color: green;">&#9632;</span> GUIA DE INGRESO
                                        {{-- link del tab 1 --}}
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" data-toggle="tab" href="#tab-2"><span style="color: orange;">&#9632;</span> GUIA DE EGRESO
                                        {{-- link del tab 2 --}}
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" data-toggle="tab" href="#tab-3"><span style="color: red;">&#9632;</span> GUIA DE INFORME TECNICO
                                        {{-- link del tab 2 --}}
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" id="tab-1" class="tab-pane  active show">
                                    <div class="panel-body">
                                        {{-- CONTENIDO DENTRO DEL TAB --}}
                                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                    <input class="form-control" type="text" name="daterange"
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-secondary" onclick="">
                                            <i class="fa fa-history"></i>
                                        </button>
                                    </span>
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-primary" onclick="">
                                            <i class="fa fa-eraser"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="search"><strong>BUSCAR:</strong></label>
                                <input class="form-control col-lg-8" type="text" id="search" placeholder="Buscar comprobantes">
                                    </select>
                                </div>
                            </div>
                        </div>
      
<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">CODIGO</th>
      <th scope="col">RUC/DNI</th>
      <th scope="col">CLIENTE</th>
      <th scope="col">MARCA</th>
      <th scope="col">FECHA</th>
      <th scope="col">MOTIVO</th>
      <th scope="col">ACCIONES</th>
      
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>LNV-0000011111</td>
      <td>EP-000001</td>
      <td>Flavia</td>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td <i class="bi bi-hurricane"style="font-size: 1.5rem;"></i></td>
    </tr>

    <tr>
      <th scope="row">2</th>
      <td>Gaby</td>
      <td>T12345678</td>
      <td>@fat</td>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td <i class="bi bi-check" style="font-size: 1.5rem;"></i></td>
    </tr>

    <tr>
      <th scope="row">3</th>
      <td>Gaby</td>
      <td>12345678</td>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td>Mark</td>
      <td <i class="bi bi-check"style="font-size: 1.5rem;"></i></td>
    </tr>

    <tr>
      <th scope="row">4</th>
      <td>Gaby</td>
      <td>12345678</td>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td>Mark</td>
      <td <i class="bi bi-eye-fill"style="font-size: 1.5rem;"></i></td>
    </tr>

  </tbody>
</table>

<div class="btn-group" role="group" aria-label="Basic outlined example">
  <button type="button" class="btn btn-outline-primary">Anterior</button>
  <button type="button" class="btn btn-outline-primary">1</button>
  <button type="button" class="btn btn-outline-primary">2</button>
  <button type="button" class="btn btn-outline-primary">Siguiente</button>
</div>
</div>
</div>

<div role="tabpanel" id="tab-2" class="tab-pane">
                                    <div class="panel-body">
                                        {{-- CONTENIDO DENTRO DEL TAB 2 --}}
                                        
                                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                    <input class="form-control" type="text" name="daterange"
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-secondary" onclick="">
                                            <i class="fa fa-history"></i>
                                        </button>
                                    </span>
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-primary" onclick="">
                                            <i class="fa fa-eraser"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="search"><strong>BUSCAR:</strong></label>
                                <input class="form-control col-lg-8" type="text" id="search" placeholder="Buscar comprobantes">
                                    </select>
                                </div>
                            </div>
                        </div>

<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">CODIGO</th>
      <th scope="col">RUC/DNI</th>
      <th scope="col">CLIENTE</th>
      <th scope="col">MARCA</th>
      <th scope="col">FECHA</th>
      <th scope="col">MOTIVO</th>
      <th scope="col">ACCIONES</th>
      
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>LNV-00000222222</td>
      <td>EP-000001</td>
      <td>Flavia</td>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td <i class="bi bi-hurricane"style="font-size: 1.5rem;"></i></td>
    </tr>

    <tr>
      <th scope="row">2</th>
      <td>Gaby</td>
      <td>T12345678</td>
      <td>@fat</td>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td <i class="bi bi-check" style="font-size: 1.5rem;"></i></td>
    </tr>

    <tr>
      <th scope="row">3</th>
      <td>Gaby</td>
      <td>12345678</td>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td>Mark</td>
      <td <i class="bi bi-check"style="font-size: 1.5rem;"></i></td>
    </tr>

    <tr>
      <th scope="row">4</th>
      <td>Gaby</td>
      <td>12345678</td>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td>Mark</td>
      <td <i class="bi bi-eye-fill"style="font-size: 1.5rem;"></i></td>
    </tr>

  </tbody>
</table>

<div class="btn-group" role="group" aria-label="Basic outlined example">
  <button type="button" class="btn btn-outline-primary">Anterior</button>
  <button type="button" class="btn btn-outline-primary">1</button>
  <button type="button" class="btn btn-outline-primary">2</button>
  <button type="button" class="btn btn-outline-primary">Siguiente</button>
</div>
</div>
</div>



<div role="tabpanel" id="tab-3" class="tab-pane">
                                    <div class="panel-body">
                                        {{-- CONTENIDO DENTRO DEL TAB 2 --}}
                                        
                                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <label class="col-lg-2 col-form-label"><strong>Fecha:</strong></label>
                                    <input class="form-control" type="text" name="daterange"
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-secondary" onclick="">
                                            <i class="fa fa-history"></i>
                                        </button>
                                    </span>
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-primary" onclick="">
                                            <i class="fa fa-eraser"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group row">
                                <label class="col-lg-4 col-form-label" for="search"><strong>BUSCAR:</strong></label>
                                <input class="form-control col-lg-8" type="text" id="search" placeholder="Buscar comprobantes">
                                    </select>
                                </div>
                            </div>
                        </div>

<table class="table">
  <thead>
    <tr>
      <th scope="col">ID</th>
      <th scope="col">CODIGO</th>
      <th scope="col">RUC/DNI</th>
      <th scope="col">CLIENTE</th>
      <th scope="col">MARCA</th>
      <th scope="col">FECHA</th>
      <th scope="col">MOTIVO</th>
      <th scope="col">ACCIONES</th>
      
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>LNV-00000333</td>
      <td>EP-000001</td>
      <td>Flavia</td>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td <i class="bi bi-hurricane"style="font-size: 1.5rem;"></i></td>
    </tr>

    <tr>
      <th scope="row">2</th>
      <td>Gaby</td>
      <td>T12345678</td>
      <td>@fat</td>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td <i class="bi bi-check" style="font-size: 1.5rem;"></i></td>
    </tr>

    <tr>
      <th scope="row">3</th>
      <td>Gaby</td>
      <td>12345678</td>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td>Mark</td>
      <td <i class="bi bi-check"style="font-size: 1.5rem;"></i></td>
    </tr>

    <tr>
      <th scope="row">4</th>
      <td>Gaby</td>
      <td>12345678</td>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td>Mark</td>
      <td <i class="bi bi-eye-fill"style="font-size: 1.5rem;"></i></td>
    </tr>

  </tbody>
</table>

<div class="btn-group" role="group" aria-label="Basic outlined example">
  <button type="button" class="btn btn-outline-primary">Anterior</button>
  <button type="button" class="btn btn-outline-primary">1</button>
  <button type="button" class="btn btn-outline-primary">2</button>
  <button type="button" class="btn btn-outline-primary">Siguiente</button>
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


    @endsection





{{--Base para agregar la pestaña para los contenidos
<div>
<a class="nav-link" data-toggle="pestaña" href="#tab-3"><span style="color: red;">&#9632;</span> <i class="bi bi-plus-square p-2" style="font-size: 2rem;"></i>
</div>
--}}
{{-- enlace del tab 3 --}}





