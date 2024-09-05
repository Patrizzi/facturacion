@extends('layout')
@section('title', 'Boleta')

@section('content')
<table class="table table-striped table-bordered table-hover dataTables-example" >
    <thead>
        <h5 style="text-align:center;color: #0073c1; font-weight: bold; font-size: 20px">CONTADOR TOTAL DEL MES</h5>

        <div class="row">
            <div class="col">
                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16" style="color: #34d313">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                </svg>
                <h4 style="font-weight: bold">BOLETA</h4>
                <p>4 documentos</p>
                <p style="color: #34d313; font-weight: bold" >S/ 120</p>
            </div>
            <div class="col">
                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16" style="color: #c45a20">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                </svg>
                <h4 style="font-weight: bold">FACTURA</h4>
                <p>4 documentos</p>
                <p style="color: #c45a20; font-weight: bold" >S/ 120</p>
            </div>
            <div class="col">
                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16" style="color: #e22b35">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                </svg>
                <h4 style="font-weight: bold">NOTA DE PEDIDO</h4>
                <p>5 documentos</p>
                <p style="color: #e22b35; font-weight: bold" >S/ 120</p>
            </div>
            <div class="col">
                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16" style="color: #2dade0">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                </svg>
                <h4 style="font-weight: bold">NOTA DE DEBITO</h4>
                <p>5 documentos</p>
                <p style="color: #2dade0; font-weight: bold" >S/ 120</p>
            </div>
            <div class="col">
                <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16" style="color: #c515ea">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                </svg>
                <h4 style="font-weight: bold">GUIA DE REMISION</h4>
                <p>5 documentos</p>
                <p style="color: #c515ea; font-weight: bold" >S/ 120</p>
            </div>

            <style>
                .row{
                    text-align: center
                }
            </style>
        </div>

        <div class="row" style="background: #ededed">
            <div class="col">
                <h4 style="font-weight: bold"><span class="label label-success">4</span>BOLETA</h4>
            </div>
            <div class="col">
                <h4 style="font-weight: bold"><span class="label label-success">5</span>FACTURA</h4>
            </div>
            <div class="col">
                <h4 style="font-weight: bold"><span class="label label-success">5</span>NOTA DE CREDITO</h4>
            </div>
            <div class="col">
                <h4 style="font-weight: bold"><span class="label label-success">5</span>NOTA DE DEBITO</h4>
            </div>
            <div class="col">
                <h4 style="font-weight: bold"><span class="label label-success">5</span>GUIA DE REMISION</h4>
            </div>
            <div class="col">
                <button></button>
            </div>
            <div class="col">
                <button></button>
            </div>

        </div>


        <div>
            <nav class="navbar navbar-light bg-light">
                <form class="form-inline">
                  <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                </form>
            </nav>
        </div>

    <!-- Texto de las tablas principales -->
        <tr>
            <th>ID</th>
            <th>Código de Boleta</th>
            <th>Cliente </th>
            <th>Ruc/DNI</th>
            <th>Fecha de Emision</th>
            <th>Importe T.</th>
            <th></th>
            <th style="text-align:center;color: #0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</th>
        </tr>
        <tr>
            <td>1</td>
            <td>B001</td>
            <td>Fabricio</td>
            <td>12345678901</td>
            <td>2024-09-01</td>
            <td>150</td>
        </tr>
        <tr>
            <td>2</td>
            <td>B002</td>
            <td>Flavia</td>
            <td>12345678902</td>
            <td>2024-09-02</td>
            <td>200</td>
        </tr>
        <tr>
            <td>3</td>
            <td>B003</td>
            <td>Gaby</td>
            <td>12345678903</td>
            <td>2024-09-03</td>
            <td>100</td>
        </tr>
    </thead>
</table>
@endsection


