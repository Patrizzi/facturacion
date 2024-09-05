@extends('layout')
@section('title', 'Facturación')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

@section('content')

    <!-- ... -->
    <div class="bg-white m-4 p-2">
        <h4>Resumen de Febrero 2024</h4>
        <div class="row m-2 d-flex justify-content-center">
            <div class="col-2">
                <div class="border border-danger rounded-circle">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </div>
                <h4>Boleta Manual</h4>
                <p>4 documentos</p>
                <p class="text-danger"><b>S/***.**</b></p>
            </div>

            @for ($i = 1; $i <=4; $i++)
            <div class="col-2">
                <div class="border border-danger rounded-circle">
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                </div>
                <h4>Boleta Manual</h4>
                <p>4 documentos</p>
                <p>S/***.**</p>
            </div>
            @endfor
        </div>
    </div>
    <!-- Barra de navegaciòn de las diferentes tablas -->
    <div class="bg-light border border-dark mt-5 mx-4 p-1">
        <ul class="nav nav-underline d-flex justify-content-between align-items-center">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Boleta manual</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Factura manual</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Nota de crèdito</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Nota dèbito</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Guìa de remisiòn manual</a>
            </li>
            <li class="nav-item">
                <a class="nav-link bg-info text-light" href="#"><i class="bi bi-plus-lg"></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link bg-info text-light" href="#"><i class="bi bi-plus-lg"></i></a>
            </li>
          </ul>
    </div>

    <div class="bg-white mx-4 p-3">
        <div class="d-flex justify-content-md-start row">
            <div class="input-group col-md-4">
                <input type="text" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username with two button addons">
                <button class="btn btn-outline-secondary" type="button">button</button>
                <button class="btn btn-outline-secondary" type="button">Button</button>
            </div>

            <div class="col-md-5">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                      <label for="inputPassword6" class="col-form-label">Buscar: </label>
                    </div>
                    <div class="col-auto">
                      <input type="password" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline">
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Còdigo</th>
                    <th scope="col">RUC/DNI</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Condiciòn</th>
                    <th scope="col">Importe total</th>
                    <th scope="col">Sunat</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>Otto</td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>Otto</td>
                  </tr>
                  <tr>
                    <th scope="row">3</th>
                    <td colspan="2">Larry the Bird</td>
                    <td>@twitter</td>
                    <th scope="row">1</th>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>Otto</td>
                  </tr>

                </tbody>
            </table>
        </div>
    </div>
@endsection
