@extends('layout')
@section('title', 'Boleta')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@section('content')
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
                            <p style="color: #34d313; font-weight: bold">S/ ***.**</p>
                        </div>
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16" style="color: #c45a20">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            </svg>
                            <h4 style="font-weight: bold">FACTURA</h4>
                            <p>4 documentos</p>
                            <p style="color: #c45a20; font-weight: bold">S/ ***.**</p>
                        </div>
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16" style="color: #e22b35">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            </svg>
                            <h4 style="font-weight: bold">NOTA DE PEDIDO</h4>
                            <p>5 documentos</p>
                            <p style="color: #e22b35; font-weight: bold">S/ ***.**</p>
                        </div>
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16" style="color: #2dade0">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            </svg>
                            <h4 style="font-weight: bold">NOTA DE DÉBITO</h4>
                            <p>5 documentos</p>
                            <p style="color: #2dade0; font-weight: bold">S/ ***.**</p>
                        </div>
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="70" fill="currentColor" class="bi bi-circle" viewBox="0 0 16 16" style="color: #c515ea">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                            </svg>
                            <h4 style="font-weight: bold">GUIA DE REMISIÓN</h4>
                            <p>5 documentos</p>
                            <p style="color: #c515ea; font-weight: bold">S/ ***.**</p>
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
                            <a class="nav-link active" data-toggle="tab" href="#tab-1"><span class="number" style="font-weight: bold; margin-right: 8px; color:#000; background-color: #34d313; padding: 5px 10px;">1</span>BOLETA</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-2"><span class="number" style="font-weight: bold; margin-right: 8px; color:#000; background-color: #c45a20; padding: 5px 10px;">1</span>FACTURA</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-3"><span class="number" style="font-weight: bold; margin-right: 8px; color:#000; background-color: #e22b35; padding: 5px 10px;">1</span>NOTA DE CREDITO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-4"><span class="number" style="font-weight: bold; margin-right: 8px; color:#000; background-color: #2dade0; padding: 5px 10px;">1</span>NOTA DE DEBITO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#tab-5"><span class="number" style="font-weight: bold; margin-right: 8px; color:#000; background-color: #c515ea; padding: 5px 10px;">1</span>GUIA DE REMISION</a>
                        </li>
                        <li class="ml-auto">
                            <div style="position: relative; display: inline-block;">
                                <a href="#" class="button" 
                                   style="display: inline-flex; align-items: center; justify-content: center; font-size: 24px; 
                                          background-color: #007bff; color: white; border: none; border-radius: 8px; 
                                          padding: 1px 20px; text-decoration: none; cursor: pointer; 
                                          margin-right: 8px" 
                                   onclick="toggleOptions(event)">+</a>
                                <div id="options" style="display: none; position: absolute; top: 100%; left: 50%; 
                                     transform: translateX(-50%); background-color: white; 
                                     box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); border-radius: 4px; 
                                     z-index: 1; margin-top: 8px; white-space: nowrap;">
                                    <a style="font-weight: bold; font-size: 16px; padding: 10px 5px">Almacenes:</a>
                                    <a href="#" style="display: block; padding: 10px 16px; color: black; 
                                       border-radius: 4px; margin: 4px 0;">Galeria Arequipa</a>
                                    <a href="#" style="display: block; padding: 8px 16px; color: black; 
                                       border-radius: 4px; margin: 4px 0;">Galeria Centro de Lima</a>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div>
                                <a href="#" class="button " style="display: inline-flex; align-items: center; justify-content: center; font-size: 24px; background-color: #007bff; color: white; border: none; border-radius: 8px; padding: 7px 20px; text-decoration: none; cursor: pointer; align-items: flex-end;"><i class="fas fa-download download-icon"></i></a>
                            </div>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div role="tabpanel" id="tab-1" class="tab-pane active">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover">
                                    <div style="display: flex; align-items: center;">
                                        <input type="text" name="daterange" value="01/01/2018 - 01/15/2018" style="margin-right: 5px;" />
                                        <i class="fas fa-sync-alt" style="background-color: gray; color: white; border: none; border-radius: 5px; width: 30px; height: 30px; font-size: 15px; cursor: pointer; display: flex; justify-content: center; align-items: center; margin-right: 5px;"></i>
                                        <i class="fas fa-eraser" style="background-color: blue; color: white; border: none; border-radius: 5px; width: 30px; height: 30px; font-size: 15px; cursor: pointer; display: flex; justify-content: center; align-items: center; margin-right: 900px;"></i>
                                        <h5 type="text" name="daterange" style="font-weight: bold; font-size: 20px;">BUSCAR:</h5>
                                        <input type="text" name="daterange" value="                  " style="margin-right: 2px;">
                                    </div>
                                    <br>
                                    <thead>
                                        <tr>
                                            <td>
                                                <i class="fas fa-check check-square-box" style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; font-size: 16px; color: #fff; background-color: #fff; border: 2px solid #000; border-radius: 4px; cursor: pointer;"></i>
                                            </td>
                                            <td>ID</td>
                                            <td>CODIGO</td>
                                            <td>RUC/DNI</td>
                                            <td>CLIENTE</td>
                                            <td>FECHA</td>
                                            <td>CONDICION</td>
                                            <td>IMPORTE TOTAL</td>
                                            <td style="text-align:center;color: #0073c1">
                                                <img src="{{asset('sunat.png')}}" width="25px">SUNAT
                                            </td>
                                            <td>ACCIONES</td>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        <tr>
                                            <td>
                                                <i class="fas fa-check check-square-box" style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; font-size: 16px; color: #fff; background-color: #fff; border: 2px solid #000; border-radius: 4px; cursor: pointer;"></i>
                                            </td>
                                            <td>01</td>
                                            <td>123</td>
                                            <td>72846344</td>
                                            <td>Fabricio</td>
                                            <td>12/10/2024</td>
                                            <td>Cansado</td>
                                            <td> S/ 1200</td>
                                            <td style="text-align: center">
                                                <i class="fas fa-check check-icon" style="cursor: pointer; font-size: 24px; color: #fff; background-color: green; border-radius: 50%;"></i>
                                            </td>
                                            <td style="text-align: center">
                                                <i class="fas fa-eye eye-icon" style="cursor: pointer; font-size: 24px; color: #007bff;"></i>
                                                <i class="fas fa-check check-icon" style="cursor: pointer; font-size: 24px; color: #fff; background-color: green; border-radius: 50%;"></i>
                                                <i class="fas fa-check-square check-square-icon" style="cursor: pointer; font-size: 24px; color: #28a745;"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-white"><i class="fa fa-chevron-left"></i></button>
                                    <button class="btn btn-white">1</button>
                                    <button class="btn btn-white  active">2</button>
                                    <button class="btn btn-white">3</button>
                                    <button class="btn btn-white">4</button>
                                    <button type="button" class="btn btn-white"><i class="fa fa-chevron-right"></i> </button>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-2" class="tab-pane">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover">
                                    <div style="display: flex; align-items: center;">
                                        <input type="text" name="daterange" value="01/01/2018 - 01/15/2018" style="margin-right: 5px;" />
                                        <i class="fas fa-sync-alt" style="background-color: gray; color: white; border: none; border-radius: 5px; width: 30px; height: 30px; font-size: 15px; cursor: pointer; display: flex; justify-content: center; align-items: center; margin-right: 5px;"></i>
                                        <i class="fas fa-eraser" style="background-color: blue; color: white; border: none; border-radius: 5px; width: 30px; height: 30px; font-size: 15px; cursor: pointer; display: flex; justify-content: center; align-items: center; margin-right: 900px;"></i>
                                        <h5 type="text" name="daterange" style="font-weight: bold; font-size: 20px;">BUSCAR:</h5>
                                        <input type="text" name="daterange" value="                  " style="margin-right: 2px;">
                                    </div>
                                    <br>
                                    <thead>
                                        <tr>
                                            <td>
                                                <i class="fas fa-check check-square-box" style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; font-size: 16px; color: #fff; background-color: #fff; border: 2px solid #000; border-radius: 4px; cursor: pointer;"></i>
                                            </td>
                                            <td>ID</td>
                                            <td>CODIGO</td>
                                            <td>RUC/DNI</td>
                                            <td>CLIENTE</td>
                                            <td>FECHA</td>
                                            <td>CONDICION</td>
                                            <td>IMPORTE TOTAL</td>
                                            <td style="text-align:center;color: #0073c1">
                                                <img src="{{asset('sunat.png')}}" width="25px">SUNAT
                                            </td>
                                            <td>ACCIONES</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <i class="fas fa-check check-square-box" style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; font-size: 16px; color: #fff; background-color: #fff; border: 2px solid #000; border-radius: 4px; cursor: pointer;"></i>
                                            </td>
                                            <td>01</td>
                                            <td>123</td>
                                            <td>72846344</td>
                                            <td>Fabricio</td>
                                            <td>12/10/2024</td>
                                            <td>Cansado</td>
                                            <td> S/ 1200</td>
                                            <td style="text-align: center">
                                                <i class="fas fa-check check-icon" style="cursor: pointer; font-size: 24px; color: #fff; background-color: green; border-radius: 50%;"></i>
                                            </td>
                                            <td style="text-align: center">
                                                <i class="fas fa-eye eye-icon" style="cursor: pointer; font-size: 24px; color: #007bff;"></i>
                                                <i class="fas fa-check check-icon" style="cursor: pointer; font-size: 24px; color: #fff; background-color: green; border-radius: 50%;"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-white"><i class="fa fa-chevron-left"></i></button>
                                    <button class="btn btn-white">1</button>
                                    <button class="btn btn-white  active">2</button>
                                    <button class="btn btn-white">3</button>
                                    <button class="btn btn-white">4</button>
                                    <button type="button" class="btn btn-white"><i class="fa fa-chevron-right"></i> </button>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-3" class="tab-pane">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover">
                                    <div style="display: flex; align-items: center;">
                                        <input type="text" name="daterange" value="01/01/2018 - 01/15/2018" style="margin-right: 5px;" />
                                        <i class="fas fa-sync-alt" style="background-color: gray; color: white; border: none; border-radius: 5px; width: 30px; height: 30px; font-size: 15px; cursor: pointer; display: flex; justify-content: center; align-items: center; margin-right: 5px;"></i>
                                        <i class="fas fa-eraser" style="background-color: blue; color: white; border: none; border-radius: 5px; width: 30px; height: 30px; font-size: 15px; cursor: pointer; display: flex; justify-content: center; align-items: center; margin-right: 900px;"></i>
                                        <h5 type="text" name="daterange" style="font-weight: bold; font-size: 20px;">BUSCAR:</h5>
                                        <input type="text" name="daterange" value="                  " style="margin-right: 2px;">
                                    </div>
                                    <br>
                                    <thead>
                                        <tr>
                                            <td>
                                                <i class="fas fa-check check-square-box" style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; font-size: 16px; color: #fff; background-color: #fff; border: 2px solid #000; border-radius: 4px; cursor: pointer;"></i>
                                            </td>
                                            <td>ID</td>
                                            <td>CODIGO</td>
                                            <td>RUC/DNI</td>
                                            <td>CLIENTE</td>
                                            <td>FECHA</td>
                                            <td>CONDICION</td>
                                            <td>IMPORTE TOTAL</td>
                                            <td style="text-align:center;color: #0073c1">
                                                <img src="{{asset('sunat.png')}}" width="25px">SUNAT
                                            </td>
                                            <td>ACCIONES</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <i class="fas fa-check check-square-box" style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; font-size: 16px; color: #fff; background-color: #fff; border: 2px solid #000; border-radius: 4px; cursor: pointer;"></i>
                                            </td>
                                            <td>01</td>
                                            <td>123</td>
                                            <td>85635244</td>
                                            <td>GABY</td>
                                            <td>05/06/2024</td>
                                            <td>Trabajando</td>
                                            <td> S/ 500</td>
                                            <td style="text-align: center">
                                                <i class="fas fa-check check-icon" style="cursor: pointer; font-size: 24px; color: #fff; background-color: green; border-radius: 50%;"></i>
                                            </td>
                                            <td style="text-align: center">
                                                <i class="fas fa-eye eye-icon" style="cursor: pointer; font-size: 24px; color: #007bff;"></i>
                                                <i class="fas fa-check check-icon" style="cursor: pointer; font-size: 24px; color: #fff; background-color: green; border-radius: 50%;"></i>
                                                <i class="fas fa-file-alt document-icon" style="color: #007bff; font-size: 24px;"></i>
                                                <i class="fas fa-trash-alt trash-icon" style="font-size: 24px; color: #ff0000; cursor: pointer;"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-white"><i class="fa fa-chevron-left"></i></button>
                                    <button class="btn btn-white">1</button>
                                    <button class="btn btn-white  active">2</button>
                                    <button class="btn btn-white">3</button>
                                    <button class="btn btn-white">4</button>
                                    <button type="button" class="btn btn-white"><i class="fa fa-chevron-right"></i> </button>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-4" class="tab-pane">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover">
                                    <div style="display: flex; align-items: center;">
                                        <input type="text" name="daterange" value="01/01/2018 - 01/15/2018" style="margin-right: 5px;" />
                                        <i class="fas fa-sync-alt" style="background-color: gray; color: white; border: none; border-radius: 5px; width: 30px; height: 30px; font-size: 15px; cursor: pointer; display: flex; justify-content: center; align-items: center; margin-right: 5px;"></i>
                                        <i class="fas fa-eraser" style="background-color: blue; color: white; border: none; border-radius: 5px; width: 30px; height: 30px; font-size: 15px; cursor: pointer; display: flex; justify-content: center; align-items: center; margin-right: 900px;"></i>
                                        <h5 type="text" name="daterange" style="font-weight: bold; font-size: 20px;">BUSCAR:</h5>
                                        <input type="text" name="daterange" value="                  " style="margin-right: 2px;">
                                    </div>
                                    <br>
                                    <thead>
                                        <tr>
                                            <td>
                                                <i class="fas fa-check check-square-box" style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; font-size: 16px; color: #fff; background-color: #fff; border: 2px solid #000; border-radius: 4px; cursor: pointer;"></i>
                                            </td>
                                            <td>ID</td>
                                            <td>CODIGO</td>
                                            <td>RUC/DNI</td>
                                            <td>CLIENTE</td>
                                            <td>FECHA</td>
                                            <td>CONDICION</td>
                                            <td>IMPORTE TOTAL</td>
                                            <td style="text-align:center;color: #0073c1">
                                                <img src="{{asset('sunat.png')}}" width="25px">SUNAT
                                            </td>
                                            <td>ACCIONES</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <i class="fas fa-check check-square-box" style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; font-size: 16px; color: #fff; background-color: #fff; border: 2px solid #000; border-radius: 4px; cursor: pointer;"></i>
                                            </td>
                                            <td>01</td>
                                            <td>123</td>
                                            <td>96538455</td>
                                            <td>Fablia</td>
                                            <td>03/06/2024</td>
                                            <td>Trabajando</td>
                                            <td> S/ 400</td>
                                            <td style="text-align: center">
                                                <i class="fas fa-check check-icon" style="cursor: pointer; font-size: 24px; color: #fff; background-color: green; border-radius: 50%;"></i>
                                            </td>
                                            <td style="text-align: center">
                                                <i class="fas fa-eye eye-icon" style="cursor: pointer; font-size: 24px; color: #007bff;"></i>
                                                <i class="fas fa-check check-icon" style="cursor: pointer; font-size: 24px; color: #fff; background-color: green; border-radius: 50%;"></i>
                                                <i class="fas fa-file-alt document-icon" style="color: #007bff; font-size: 24px;"></i>
                                                <i class="fas fa-trash-alt trash-icon" style="font-size: 24px; color: #ff0000; cursor: pointer;"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-white"><i class="fa fa-chevron-left"></i></button>
                                    <button class="btn btn-white">1</button>
                                    <button class="btn btn-white  active">2</button>
                                    <button class="btn btn-white">3</button>
                                    <button class="btn btn-white">4</button>
                                    <button type="button" class="btn btn-white"><i class="fa fa-chevron-right"></i> </button>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" id="tab-5" class="tab-pane">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-hover">
                                    <div style="display: flex; align-items: center;">
                                        <input type="text" name="daterange" value="01/01/2018 - 01/15/2018" style="margin-right: 5px;" />
                                        <i class="fas fa-sync-alt" style="background-color: gray; color: white; border: none; border-radius: 5px; width: 30px; height: 30px; font-size: 15px; cursor: pointer; display: flex; justify-content: center; align-items: center; margin-right: 5px;"></i>
                                        <i class="fas fa-eraser" style="background-color: blue; color: white; border: none; border-radius: 5px; width: 30px; height: 30px; font-size: 15px; cursor: pointer; display: flex; justify-content: center; align-items: center; margin-right: 900px;"></i>
                                        <h5 type="text" name="daterange" style="font-weight: bold; font-size: 20px;">BUSCAR:</h5>
                                        <input type="text" name="daterange" value="                  " style="margin-right: 2px;">
                                    </div>
                                    <br>
                                    <thead>
                                        <tr>
                                            <td>
                                                <i class="fas fa-check check-square-box" style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; font-size: 16px; color: #fff; background-color: #fff; border: 2px solid #000; border-radius: 4px; cursor: pointer;"></i>
                                            </td>
                                            <td>ID</td>
                                            <td>CODIGO</td>
                                            <td>RUC/DNI</td>
                                            <td>CLIENTE</td>
                                            <td>FECHA</td>
                                            <td>CONDICION</td>
                                            <td>IMPORTE TOTAL</td>
                                            <td style="text-align:center;color: #0073c1">
                                                <img src="{{asset('sunat.png')}}" width="25px">SUNAT
                                            </td>
                                            <td>ACCIONES</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <i class="fas fa-check check-square-box" style="display: inline-flex; align-items: center; justify-content: center; width: 24px; height: 24px; font-size: 16px; color: green; background-color: #fff; border: 2px solid #000; border-radius: 4px; cursor: pointer;"></i>
                                            </td>
                                            <td>01</td>
                                            <td>123</td>
                                            <td>63256988</td>
                                            <td>Marlo</td>
                                            <td>12/10/2024</td>
                                            <td>Trabajando</td>
                                            <td> S/ 1000</td>
                                            <td style="text-align: center">
                                                <i class="fas fa-check check-icon" style="cursor: pointer; font-size: 24px; color: #fff; background-color: green; border-radius: 50%;"></i>
                                            </td>
                                            <td style="text-align: center">
                                                <i class="fas fa-user profile-icon" style="font-size: 24px; color: black; cursor: pointer;"></i>
                                                <i class="fas fa-truck truck-icon" style="font-size: 24px; color: black; cursor: pointer;"></i>
                                                <i class="fas fa-eye eye-icon" style="cursor: pointer; font-size: 24px; color: #007bff;"></i>
                                                <i class="fas fa-check check-icon" style="cursor: pointer; font-size: 24px; color: #fff; background-color: green; border-radius: 50%;"></i>
                                                <i class="fas fa-check-square check-square-icon" style="cursor: pointer; font-size: 24px; color: #28a745;"></i>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <br>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-white"><i class="fa fa-chevron-left"></i></button>
                                    <button class="btn btn-white">1</button>
                                    <button class="btn btn-white  active">2</button>
                                    <button class="btn btn-white">3</button>
                                    <button class="btn btn-white">4</button>
                                    <button type="button" class="btn btn-white"><i class="fa fa-chevron-right"></i> </button>
                                </div>
                            </div>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .dropdown-menu {
        left: 70px;
        padding: 20px 0;
    }

    #DataTables_Table_0_wrapper {
        padding-right: 0px;
    }

    .table {
        width: 100% !important;
    }

    .ibox-content>.row {
        margin: auto;
    }
</style>
<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- check -->
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('js/icheck.min.js') }}"></script>
<script>
$(document).ready(function(){
            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });

</script>

<!-- Page-Level Scripts -->
<script>
    $(document).ready(function() {
        table = $('.dataTables-example-facturacion').DataTable({
            pageLength: 10,
            order: [
                [0, "desc"]
            ],
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            footerCallback: function(tr, data, start, end, display) {
                var api = this.api(),
                    data;

                // Remove the formatting to get integer data for summation
                var intVal = function(i) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '') * 1 :
                        typeof i === 'number' ?
                        i : 0;
                };

                // Total over all pages
                total = api
                    .column(5)
                    .data()
                    .reduce(function(a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);

                // Total filtered rows on the selected column (code part added)
                var sumCol4Filtered = display.map(el => data[el][5]).reduce((a, b) => intVal(a) +
                    intVal(b), 0);

                // Update footer
                $(api.column(5).footer()).html(
                    'S/ ' + Math.round(sumCol4Filtered * 100) / 100
                );
            },
            buttons: []
        });

        revert_select();

        $(document).on('change', '#select_tipo_coti', function(event) {
            var nombre = $("#select_tipo_coti option:selected").val();
            // console.log(nombre);
            table.column(11).search(nombre).draw();
        });
        $('input[name="daterange"]').daterangepicker({
                "locale": {
                    "separator": " | ",
                    "applyLabel": "Guardar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "Desde",
                    "toLabel": "Hasta",
                    "customRangeLabel": "Custom",
                    "daysOfWeek": [
                        "Do",
                        "Lu",
                        "Ma",
                        "Mi",
                        "Ju",
                        "Vi",
                        "Sa"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                    "firstDay": 1
                }
            },
            function(start, end, label) {
                var dates = [];
                var currentDate = new Date(start);
                while (currentDate <= end) {
                    var day = ('0' + currentDate.getDate()).slice(-2);
                    var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                    var year = currentDate.getFullYear();

                    var formattedDate = day + '-' + month + '-' + year;
                    dates.push(formattedDate);

                    currentDate.setDate(currentDate.getDate() + 1);
                }
                var dateRangeString = dates.join('|');
                console.log(dateRangeString);
                table.column(4).search(dateRangeString, true, false).draw();
            }
        );
    });

    function limpiar_select() {
        table.column(4).search("").draw();
    }

    function revert_select() {
        table.column(4).search({{ date('m-Y') }}).draw();
    }


</script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script>//para el despliegue de las opciones de agregar
    function toggleOptions(event) {
        event.preventDefault();
        const options = document.getElementById('options');
        options.style.display = options.style.display === 'none' ? 'block' : 'none';
    }
</script>
@endsection
