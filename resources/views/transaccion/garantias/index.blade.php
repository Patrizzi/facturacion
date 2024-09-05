@extends('layout')

@section('title', 'Guias Ingreso') 
@section('breadcrumb', 'Guia de ingreso')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


<div>
<h1 class="" >RESUMEN DE SEPTIEMBRE</h1>
</div>

  <div class="card-group">
  <div class="card p-3">
    <div class="d-flex justify-content-center align-items-center card-img-top">
      <div class="bg-light rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px; font-size: 2rem;">
        <i class="bi bi-cloud-arrow-down-fill"></i>
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
      <div class="bg-light rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px; font-size: 2rem;">
        <i class="bi bi-cloud-check-fill"></i>
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
      <div class="bg-light rounded-circle d-flex justify-content-center align-items-center" style="width: 60px; height: 60px; font-size: 2rem;">
        <i class="bi bi-clipboard2-data-fill"></i>
      </div>
    </div>
    <div class="card-body text-center">
      <h5 class="card-title">Guia de Informe Tecnico</h5>
      <p class="card-text">8 Documentos</p>
      <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
    </div>
  </div>
</div>



<!-- Navegacion y los botones -->
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content" style="background-color: #f3f3f3;">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tab-cotizacion">
                                <span style="color: green;">&#9632;</span> GUIA DE INGRESO
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-cotizacion-manual">
                                <span style="color: orange;">&#9632;</span> GUIA DE EGRESO
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-nota-venta">
                                <span style="color: red;">&#9632;</span> INFORME TECNICO
                            </a>
                        </li>
                    </ul>
                    
                    <div class="ibox-content">
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
                                    <label class="col-lg-4 col-form-label" for=""><strong>BUSCAR:</strong></label>
                                    <select class="form-control col-lg-8" type="text"
                                        <option value="">Todos los comprobantes</option>
                                        <option value="factura">Factura</option>
                                        <option value="boleta">Boleta</option>
                                        <option value="nota_venta">Nota de Venta</option>
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
      <td>Flavia</td>
      <td>12345678</td>
      <td>@mdo</td>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td <i class="bi bi-hurricane"></i></td>
    </tr>

    <tr>
      <th scope="row">2</th>
      <td>Gaby</td>
      <td>T12345678</td>
      <td>@fat</td>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td <i class="bi bi-check"></i></td>
    </tr>

    <tr>
      <th scope="row">3</th>
      <td>Gaby</td>
      <td>12345678</td>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td>Mark</td>
      <td <i class="bi bi-check"></i></td>
    </tr>

    <tr>
      <th scope="row">4</th>
      <td>Gaby</td>
      <td>12345678</td>
      <td>Mark</td>
      <td>Otto</td>
      <td>@mdo</td>
      <td>Mark</td>
      <td <i class="bi bi-eye-fill"></i></td>
    </tr>

  </tbody>
</table>

<div class="btn-group" role="group" aria-label="Basic outlined example">
  <button type="button" class="btn btn-outline-primary">Anterior</button>
  <button type="button" class="btn btn-outline-primary">1</button>
  <button type="button" class="btn btn-outline-primary">2</button>
  <button type="button" class="btn btn-outline-primary">Siguiente</button>
</div>

@endsection