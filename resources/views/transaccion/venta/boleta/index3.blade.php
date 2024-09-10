@extends('layout')
@section('title', 'Boleta')

@section('content')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5 style="text-align:center;color: #0073c1; font-weight: bold; font-size: 20px">CONTADOR TOTAL DEL MES</h5>
                </div>
                <div class="ibox-content">
                    <div class="row" style="text-align: center;">
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16" style="color: #34d313">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            </svg>
                            <h4 style="font-weight: bold">BOLETA</h4>
                            <p>4 documentos</p>
                            <p style="color: #34d313; font-weight: bold">S/ 120</p>
                        </div>
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16" style="color: #c45a20">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            </svg>
                            <h4 style="font-weight: bold">FACTURA</h4>
                            <p>4 documentos</p>
                            <p style="color: #c45a20; font-weight: bold">S/ 120</p>
                        </div>
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16" style="color: #e22b35">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            </svg>
                            <h4 style="font-weight: bold">NOTA DE PEDIDO</h4>
                            <p>5 documentos</p>
                            <p style="color: #e22b35; font-weight: bold">S/ 120</p>
                        </div>
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16" style="color: #2dade0">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            </svg>
                            <h4 style="font-weight: bold">NOTA DE DÉBITO</h4>
                            <p>5 documentos</p>
                            <p style="color: #2dade0; font-weight: bold">S/ 120</p>
                        </div>
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16" style="color: #c515ea">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            </svg>
                            <h4 style="font-weight: bold">GUIA DE REMISIÓN</h4>
                            <p>5 documentos</p>
                            <p style="color: #c515ea; font-weight: bold">S/ 120</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content">
                <div class="tabs-container">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tab-1">BOLETA</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-2">FACTURA</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" id="tab-1" class="tab-pane active">
                            <button class="btn btn-primary" onclick="showForm('boleta')">Agregar Producto</button>
                            <div id="form-boleta" class="product-form" style="display: none;">
                                <form id="form-boleta-data">
                                    <!-- Campos del formulario -->
                                    <div class="form-group">
                                        <label for="id-boleta">ID</label>
                                        <input type="number" class="form-control" id="id-boleta" name="id">
                                    </div>
                                    <div class="form-group">
                                        <label for="codigo-boleta">Código de Boleta</label>
                                        <input type="text" class="form-control" id="codigo-boleta" name="codigo">
                                    </div>
                                    <div class="form-group">
                                        <label for="cliente-boleta">Cliente</label>
                                        <input type="text" class="form-control" id="cliente-boleta" name="cliente">
                                    </div>
                                    <div class="form-group">
                                        <label for="ruc-boleta">Ruc/DNI</label>
                                        <input type="text" class="form-control" id="ruc-boleta" name="ruc">
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha-boleta">Fecha de Emisión</label>
                                        <input type="date" class="form-control" id="fecha-boleta" name="fecha">
                                    </div>
                                    <div class="form-group">
                                        <label for="importe-boleta">Importe</label>
                                        <input type="number" class="form-control" id="importe-boleta" name="importe" step="0.01">
                                    </div>
                                    <button type="submit" class="btn btn-success">Agregar</button>
                                </form>
                            </div>
                            <div class="panel-body">
                                <table id="table-boleta" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Código de Boleta</th>
                                            <th>Cliente</th>
                                            <th>Ruc/DNI</th>
                                            <th>Fecha de Emisión</th>
                                            <th>Importe T.</th>
                                            <th style="text-align:center;color: #0073c1">
                                                <img src="{{asset('sunat.png')}}" width="25px">SUNAT
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Aquí irán los datos de la boleta -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-2" class="tab-pane">
                            <button class="btn btn-primary" onclick="showForm('factura')">Agregar Producto</button>
                            <div id="form-factura" class="product-form" style="display: none;">
                                <form id="form-factura-data">
                                    <!-- Campos del formulario -->
                                    <div class="form-group">
                                        <label for="id-factura">ID</label>
                                        <input type="number" class="form-control" id="id-factura" name="id">
                                    </div>
                                    <div class="form-group">
                                        <label for="codigo-factura">Código de Boleta</label>
                                        <input type="text" class="form-control" id="codigo-factura" name="codigo">
                                    </div>
                                    <div class="form-group">
                                        <label for="cliente-factura">Cliente</label>
                                        <input type="text" class="form-control" id="cliente-factura" name="cliente">
                                    </div>
                                    <div class="form-group">
                                        <label for="ruc-factura">Ruc/DNI</label>
                                        <input type="text" class="form-control" id="ruc-factura" name="ruc">
                                    </div>
                                    <div class="form-group">
                                        <label for="fecha-factura">Fecha de Emisión</label>
                                        <input type="date" class="form-control" id="fecha-factura" name="fecha">
                                    </div>
                                    <div class="form-group">
                                        <label for="importe-factura">Importe</label>
                                        <input type="number" class="form-control" id="importe-factura" name="importe" step="0.01">
                                    </div>
                                    <button type="submit" class="btn btn-success">Agregar</button>
                                </form>
                            </div>
                            <div class="panel-body">
                                <table id="table-factura" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Código de Boleta</th>
                                            <th>Cliente</th>
                                            <th>Ruc/DNI</th>
                                            <th>Fecha de Emisión</th>
                                            <th>Importe T.</th>
                                            <th style="text-align:center;color: #0073c1">
                                                <img src="{{asset('sunat.png')}}" width="25px">SUNAT
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Aquí irán los datos de la factura -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showForm(type) {
        document.getElementById('form-boleta').style.display = 'none';
        document.getElementById('form-factura').style.display = 'none';
        document.getElementById('form-' + type).style.display = 'block';
    }

    document.getElementById('form-boleta-data').addEventListener('submit', function(event) {
        event.preventDefault();
        const id = document.getElementById('id-boleta').value;
        const codigo = document.getElementById('codigo-boleta').value;
        const cliente = document.getElementById('cliente-boleta').value;
        const ruc = document.getElementById('ruc-boleta').value;
        const fecha = document.getElementById('fecha-boleta').value;
        const importe = document.getElementById('importe-boleta').value;

        const table = document.getElementById('table-boleta').getElementsByTagName('tbody')[0];
        const newRow = table.insertRow();
        newRow.insertCell(0).textContent = id;
        newRow.insertCell(1).textContent = codigo;
        newRow.insertCell(2).textContent = cliente;
        newRow.insertCell(3).textContent = ruc;
        newRow.insertCell(4).textContent = fecha;
        newRow.insertCell(5).textContent = importe;
        newRow.insertCell(6).textContent = ''; // SUNAT

        document.getElementById('form-boleta-data').reset();
        document.getElementById('form-boleta').style.display = 'none';
    });

    document.getElementById('form-factura-data').addEventListener('submit', function(event) {
        event.preventDefault();
        const id = document.getElementById('id-factura').value;
        const codigo = document.getElementById('codigo-factura').value;
        const cliente = document.getElementById('cliente-factura').value;
        const ruc = document.getElementById('ruc-factura').value;
        const fecha = document.getElementById('fecha-factura').value;
        const importe = document.getElementById('importe-factura').value;

        const table = document.getElementById('table-factura').getElementsByTagName('tbody')[0];
        const newRow = table.insertRow();
        newRow.insertCell(0).textContent = id;
        newRow.insertCell(1).textContent = codigo;
        newRow.insertCell(2).textContent = cliente;
        newRow.insertCell(3).textContent = ruc;
        newRow.insertCell(4).textContent = fecha;
        newRow.insertCell(5).textContent = importe;
        newRow.insertCell(6).textContent = ''; // SUNAT

        document.getElementById('form-factura-data').reset();
        document.getElementById('form-factura').style.display = 'none';
    });
</script>
@endsection
