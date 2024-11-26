@extends('layout')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
    <!-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
    <!-- Sección de Inventario -->
    <div>
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-content">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#tab-1"><span class="number" style="font-weight: bold; margin-right: 8px; color:#000; background-color: #34d313; padding: 5px 10px;">1</span>Kardex/Producto</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tab-2"><span class="number" style="font-weight: bold; margin-right: 8px; color:#000; background-color: #c45a20; padding: 5px 10px;">2</span>Consultas de Inventario</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tab-3"><span class="number" style="font-weight: bold; margin-right: 8px; color:#000; background-color: #e22b35; padding: 5px 10px;">3</span>Cierre de periodo</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#tab-4"><span class="number" style="font-weight: bold; margin-right: 8px; color:#000; background-color: #2dade0; padding: 5px 10px;">4</span>Movimiento Consulta</a>
                                    </li>
                                </ul>

                                <br>

                                <div class="tab-content">
                                    <!-- Contenido de Tab 1 -->
                                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                                        <div class="panel-body">
                                            <!-- ANIDAMOS MÁS TABS AQUÍ -->
                                            <div class="tabs-container">
                                                <ul class="nav nav-tabs" role="tablist">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="tab" href="#contenido-tab-1"><span class="number" style="font-weight: bold; margin-right: 8px; color:#000; background-color: #34d313; padding: 5px 10px;">I.</span>Entrada Producto</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#contenido-tab-2"><span class="number" style="font-weight: bold; margin-right: 8px; color:#000; background-color: #34d313; padding: 5px 10px;">II.</span>Distribucion Producto</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#contenido-tab-3"><span class="number" style="font-weight: bold; margin-right: 8px; color:#000; background-color: #34d313; padding: 5px 10px;">III.</span>Traslado de Almacen</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="tab" href="#contenido-tab-4"><span class="number" style="font-weight: bold; margin-right: 8px; color:#000; background-color: #34d313; padding: 5px 10px;">IV.</span>Salida Producto</a>
                                                    </li>
                                                </ul>
                                                <br>
                                                <div class="tab-content">
                                                    <div role="tabpanel" id="contenido-tab-1" class="tab-pane active">
                                                        <!-- Título centrado -->
                                                        <h2 style="text-align: center; margin-bottom: 20px;">Almacen Principal - Oficina Arequipa</h2>
                                                        <div class="search-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                            <!-- Barra de búsqueda y botón Buscar -->
                                                            <div style="flex-grow: 1;">
                                                                <input type="text" class="form-control" placeholder="Buscar..." style="width: 50%; display: inline-block;">
                                                                <button class="btn btn-primary" style="display: inline-block; margin-left: 10px;">Buscar</button>
                                                            </div>

                                                            <!-- Botones Agregar, Actualizar y Descarga -->
                                                            <div>
                                                                <button class="btn btn-success" style="margin-right: 10px;">Agregar</button>
                                                                <button class="btn btn-primary" style="margin-right: 10px;">Actualizar</button>

                                                                <!-- Botón de Descarga con menú desplegable -->
                                                                <div class="btn-group">
                                                                    <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Descarga
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item" href="#">Copy</a>
                                                                        <a class="dropdown-item" href="#">CSV</a>
                                                                        <a class="dropdown-item" href="#">Excel</a>
                                                                        <a class="dropdown-item" href="#">PDF</a>
                                                                        <a class="dropdown-item" href="#">Print</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="panel-body">
                                                            <!-- Contenido de Nested Tab 1 -->
                                                            <table class="table table-striped table-bordered table-hover">
                                                                <br>
                                                                <thead>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                                        </td>
                                                                        <td>ID</td>
                                                                        <td>CODIGO</td>
                                                                        <td>MOTIVO</td>
                                                                        <td>PROVEEDOR</td>
                                                                        <td>FECHA D. INGRESO</td>
                                                                        <td>N° DE G. DE REMISION</td>
                                                                        <td>N° DE FACTURA</td>
                                                                        <td>VISUALIZAR</td>
                                                                        <td>ESTADO</td>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                                        </td>
                                                                        <td>01</td>
                                                                        <td>GE001-00000002</td>
                                                                        <td>Compras locales</td>
                                                                        <td>GRUPO INFOZONAL S.A.C.</td>
                                                                        <td>10/01/2022</td>
                                                                        <td>0</td>
                                                                        <td>0</td>
                                                                        <td>
                                                                            <div>
                                                                                <button style="padding: 5PX 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                                                                                    VER
                                                                                </button>
                                                                            </div>
                                                                        </td>
                                                                        <td style="text-align: center">
                                                                            <button style="padding: 5PX 10px; background-color: red; color: white; border: none; border-radius: 5px; cursor: pointer;">
                                                                                ANULAR
                                                                            </button>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                                        </td>
                                                                        <td>02</td>
                                                                        <td>GE001-00000003</td>
                                                                        <td>Compras locales</td>
                                                                        <td>Saar HK Electronic Limited</td>
                                                                        <td>18/01/2022</td>
                                                                        <td>1</td>
                                                                        <td>1</td>
                                                                        <td>
                                                                            <div>
                                                                                <button style="padding: 5PX 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                                                                                    VER
                                                                                </button>
                                                                            </div>
                                                                        </td>
                                                                        <td style="text-align: center">
                                                                            <button style="padding: 5PX 10px; background-color: rgb(12, 196, 241); color: white; border: none; border-radius: 5px; cursor: pointer;">
                                                                                Guia en circulacion
                                                                            </button>
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
                                                    <div role="tabpanel" id="contenido-tab-2" class="tab-pane">
                                                        <!-- Barra de búsqueda con botones -->
                                                        <div class="search-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                            <!-- Barra de búsqueda y botón Buscar -->
                                                            <div style="flex-grow: 1;">
                                                                <input type="text" class="form-control" placeholder="Buscar..." style="width: 50%; display: inline-block;">
                                                                <button class="btn btn-primary" style="display: inline-block; margin-left: 10px;">Buscar</button>
                                                            </div>

                                                            <!-- Botones Agregar, Actualizar y Descarga -->
                                                            <div>
                                                                <button class="btn btn-success" style="margin-right: 10px;">Agregar</button>
                                                                <button class="btn btn-primary" style="margin-right: 10px;">Actualizar</button>

                                                                <!-- Botón de Descarga con menú desplegable -->
                                                                <div class="btn-group">
                                                                    <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Descarga
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item" href="#">Copy</a>
                                                                        <a class="dropdown-item" href="#">CSV</a>
                                                                        <a class="dropdown-item" href="#">Excel</a>
                                                                        <a class="dropdown-item" href="#">PDF</a>
                                                                        <a class="dropdown-item" href="#">Print</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="panel-body">
                                                            <!-- Contenido de Nested Tab 2 -->
                                                            <table class="table table-striped table-bordered table-hover">
                                                                <br>
                                                                <thead>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                                        </td>
                                                                        <td>ID</td>
                                                                        <td>CODIGO</td>
                                                                        <td>F. DISTRIBUCION</td>
                                                                        <td>CANT. DE PRODUCTOS</td>
                                                                        <td>CANT. DISTRIBUIDA</td>
                                                                        <td>ALMACEN</td>
                                                                        <td>GUIA DE REMISION</td>
                                                                        <td>VER</td>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                                        </td>
                                                                        <td>01</td>
                                                                        <td>GE001-00000001</td>
                                                                        <td>10/01/2022</td>
                                                                        <td>1000</td>
                                                                        <td>250</td>
                                                                        <td>20</td>
                                                                        <td>AUN NO</td>
                                                                        <td>
                                                                            <div>
                                                                                <button style="padding: 5PX 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                                                                                    VER
                                                                                </button>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                                        </td>
                                                                        <td>01</td>
                                                                        <td>GE001-00000001</td>
                                                                        <td>15/04/2023</td>
                                                                        <td>500</td>
                                                                        <td>80</td>
                                                                        <td>30</td>
                                                                        <td>AUN NO</td>
                                                                        <td>
                                                                            <div>
                                                                                <button style="padding: 5PX 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                                                                                    VER
                                                                                </button>
                                                                            </div>
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
                                                    <div role="tabpanel" id="contenido-tab-3" class="tab-pane">
                                                        <!-- Barra de búsqueda con botones -->
                                                        <div class="search-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                            <!-- Barra de búsqueda y botón Buscar -->
                                                            <div style="flex-grow: 1;">
                                                                <input type="text" class="form-control" placeholder="Buscar..." style="width: 50%; display: inline-block;">
                                                                <button class="btn btn-primary" style="display: inline-block; margin-left: 10px;">Buscar</button>
                                                            </div>

                                                            <!-- Botones Agregar, Actualizar y Descarga -->
                                                            <div>
                                                                <button class="btn btn-success" style="margin-right: 10px;">Agregar</button>
                                                                <button class="btn btn-primary" style="margin-right: 10px;">Actualizar</button>

                                                                <!-- Botón de Descarga con menú desplegable -->
                                                                <div class="btn-group">
                                                                    <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Descarga
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item" href="#">Copy</a>
                                                                        <a class="dropdown-item" href="#">CSV</a>
                                                                        <a class="dropdown-item" href="#">Excel</a>
                                                                        <a class="dropdown-item" href="#">PDF</a>
                                                                        <a class="dropdown-item" href="#">Print</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="panel-body">
                                                            <!-- Contenido de Nested Tab 3 -->
                                                            <table class="table table-striped table-bordered table-hover">
                                                                <br>
                                                                <thead>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                                        </td>
                                                                        <td>ID</td>
                                                                        <td>CODIGO</td>
                                                                        <td>ALMACEN. EMISOR</td>
                                                                        <td>ALMACEN RECEPTOR</td>
                                                                        <td>VER</td>
                                                                        <td>ESTADO</td>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                                        </td>
                                                                        <td>01</td>
                                                                        <td>GE001-00000001</td>
                                                                        <td>CENTRAL</td>
                                                                        <td>WILSON</td>
                                                                        <td>
                                                                            <div>
                                                                                <button style="padding: 5PX 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                                                                                    VER
                                                                                </button>
                                                                            </div>
                                                                        </td>
                                                                        <td style="text-align: center">
                                                                            <button style="padding: 5PX 10px; background-color: red; color: white; border: none; border-radius: 5px; cursor: pointer;">
                                                                                ANULAR
                                                                            </button>
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
                                                    <div role="tabpanel" id="contenido-tab-4" class="tab-pane">
                                                        <!-- Título centrado -->
                                                        <h2 style="text-align: center; margin-bottom: 20px;">Creacion de Almacen</h2>
                                                        <!-- Barra de búsqueda con botones -->
                                                        <div class="search-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                                            <!-- Barra de búsqueda y botón Buscar -->
                                                            <div style="flex-grow: 1;">
                                                                <input type="text" class="form-control" placeholder="Buscar..." style="width: 50%; display: inline-block;">
                                                                <button class="btn btn-primary" style="display: inline-block; margin-left: 10px;">Buscar</button>
                                                            </div>

                                                            <!-- Botones Agregar, Actualizar y Descarga -->
                                                            <div>
                                                                <button class="btn btn-success" style="margin-right: 10px;">Agregar</button>
                                                                <button class="btn btn-primary" style="margin-right: 10px;">Actualizar</button>

                                                                <!-- Botón de Descarga con menú desplegable -->
                                                                <div class="btn-group">
                                                                    <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        Descarga
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item" href="#">Copy</a>
                                                                        <a class="dropdown-item" href="#">CSV</a>
                                                                        <a class="dropdown-item" href="#">Excel</a>
                                                                        <a class="dropdown-item" href="#">PDF</a>
                                                                        <a class="dropdown-item" href="#">Print</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="panel-body">
                                                            <!-- Contenido de Nested Tab 4 -->
                                                            <table class="table table-striped table-bordered table-hover">
                                                                <br>
                                                                <thead>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                                        </td>
                                                                        <td>ID</td>
                                                                        <td>MOTIVO</td>
                                                                        <td>INFORMACION</td>
                                                                        <td>VER</td>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                                        </td>
                                                                        <td>01</td>
                                                                        <td>Devolucion cliente</td>
                                                                        <td>Salida</td>
                                                                        <td>
                                                                            <div>
                                                                                <button style="padding: 5PX 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                                                                                    VER
                                                                                </button>
                                                                            </div>
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
                                            <!-- FIN DE LOS TABS ANIDADOS -->
                                        </div>
                                    </div>

                                    <!-- Contenido de Tab 2 -->
                                    <div role="tabpanel" id="tab-2" class="tab-pane">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                                        <!-- Calendario -->
                                        <div id="reportrange1" class="form-control">
                                            <i class="fa fa-calendar"></i>
                                            <span>October 22, 2024 - November 20, 2024</span> <b class="caret"></b>
                                        </div>
                                    
                                        <!-- Botones -->
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <div style="display: flex; gap: 10px;">
                                                <div style="position: relative;">
                                                    <a href="#" class="button"
                                                        style="display: inline-flex; align-items: center; justify-content: center; font-size: 24px; background-color: #007bff; color: white; border: none; border-radius: 8px; padding: 5px 15px; text-decoration: none; cursor: pointer;"
                                                        onclick="toggleOptions(event)">+</a>
                                                    <div id="options" style="display: none; position: absolute; top: 100%; left: 50%; transform: translateX(-50%); background-color: white; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); border-radius: 4px; z-index: 1; margin-top: 8px; white-space: nowrap;">
                                                        <a style="font-weight: bold; font-size: 16px; padding: 10px 5px">Almacenes:</a>
                                                        <a href="#" style="display: block; padding: 10px 16px; color: black; border-radius: 4px; margin: 4px 0;">Galeria Arequipa</a>
                                                        <a href="#" style="display: block; padding: 8px 16px; color: black; border-radius: 4px; margin: 4px 0;">Galeria Centro de Lima</a>
                                                    </div>
                                                </div>
                                    
                                                <a href="#" class="button" style="display: inline-flex; align-items: center; justify-content: center; font-size: 24px; background-color: #007bff; color: white; border: none; border-radius: 8px; padding: 7px 15px; text-decoration: none; cursor: pointer;">
                                                    <i class="fas fa-download download-icon"></i>
                                                </a>
                                            </div>
                                    
                                            <div class="btn-group">
                                                <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Descarga
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Copy</a>
                                                    <a class="dropdown-item" href="#">CSV</a>
                                                    <a class="dropdown-item" href="#">Excel</a>
                                                    <a class="dropdown-item" href="#">PDF</a>
                                                    <a class="dropdown-item" href="#">Print</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>








                                        <div class="panel-body">
                                            <br>
                                            <table class="table table-striped table-bordered table-hover">
                                                <h3 class="text-center">COMPRAS</h3> <!-- Título más prominente -->
                                                <br>
                                                <thead>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                        </td>
                                                        <td>Nombre del Producto</td>
                                                        <td>Cantidad Inicial</td>
                                                        <td>Precio Nacional</td>
                                                        <td>Precio en el Extranjero</td>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                        </td>
                                                        <td>Lagtop</td>
                                                        <td>1200</td>
                                                        <td>S/ 600</td>
                                                        <td>$ 200</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table table-striped table-bordered table-hover">
                                                <h3 class="text-center">VENTAS</h3> <!-- Título más prominente -->
                                                <br>
                                                <thead>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                        </td>
                                                        <td>Tipo</td>
                                                        <td>Nombre del Producto</td>
                                                        <td>Cantidad</td>
                                                        <td>Precio Nacional</td>
                                                        <td>Precio Extranjero</td>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                        </td>
                                                        <td>Electronica</td>
                                                        <td>Lagtop</td>
                                                        <td>4 Unid</td>
                                                        <td>S/ 600</td>
                                                        <td>$ 200</td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    <!-- Contenido de Tab 3 -->
                                    <div role="tabpanel" id="tab-3" class="tab-pane">
                                        <div class="search-bar" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                            <!-- Barra de búsqueda y botón Buscar -->
                                            <div style="flex-grow: 1;">
                                                <input type="text" class="form-control" placeholder="Buscar..." style="width: 50%; display: inline-block;">
                                                <button class="btn btn-primary" style="display: inline-block; margin-left: 10px;">Buscar</button>
                                            </div>

                                            <!-- Botones Agregar, Actualizar y Descarga -->
                                            <div>
                                                <button class="btn btn-success" style="margin-right: 10px;">Agregar</button>
                                                <button class="btn btn-primary" style="margin-right: 10px;">Actualizar</button>

                                                <!-- Botón de Descarga con menú desplegable -->
                                                <div class="btn-group">
                                                    <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Descarga
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="#">Copy</a>
                                                        <a class="dropdown-item" href="#">CSV</a>
                                                        <a class="dropdown-item" href="#">Excel</a>
                                                        <a class="dropdown-item" href="#">PDF</a>
                                                        <a class="dropdown-item" href="#">Print</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <!-- CONTENIDO DENTRO DEL TAB 3 -->
                                            <table class="table table-striped table-bordered table-hover">
                                                <br>
                                                <thead>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                        </td>
                                                        <td>ID</td>
                                                        <td>MES</td>
                                                        <td>AÑO</td>
                                                        <td>VISUALIZAR</td>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                        </td>
                                                        <td>01</td>
                                                        <td>Octubre</td>
                                                        <td>2021</td>
                                                        <td>
                                                            <div>
                                                                <button style="padding: 5PX 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                                                                    VER
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                        </td>
                                                        <td>02</td>
                                                        <td>Noviembre</td>
                                                        <td>2021</td>
                                                        <td>
                                                            <div>
                                                                <button style="padding: 5PX 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">
                                                                    VER
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Contenido de Tab 4 -->
                                    <div role="tabpanel" id="tab-4" class="tab-pane">
                                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px;">
                                        <!-- Calendario -->
                                        <div id="reportrange1" class="form-control">
                                            <i class="fa fa-calendar"></i>
                                            <span>October 22, 2024 - November 20, 2024</span> <b class="caret"></b>
                                        </div>
                                    
                                        <!-- Botones -->
                                        <div style="display: flex; align-items: center; gap: 10px;">
                                            <div style="display: flex; gap: 10px;">
                                                <div style="position: relative;">
                                                    <a href="#" class="button"
                                                        style="display: inline-flex; align-items: center; justify-content: center; font-size: 24px; background-color: #007bff; color: white; border: none; border-radius: 8px; padding: 5px 15px; text-decoration: none; cursor: pointer;"
                                                        onclick="toggleOptions(event)">+</a>
                                                    <div id="options" style="display: none; position: absolute; top: 100%; left: 50%; transform: translateX(-50%); background-color: white; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); border-radius: 4px; z-index: 1; margin-top: 8px; white-space: nowrap;">
                                                        <a style="font-weight: bold; font-size: 16px; padding: 10px 5px">Almacenes:</a>
                                                        <a href="#" style="display: block; padding: 10px 16px; color: black; border-radius: 4px; margin: 4px 0;">Galeria Arequipa</a>
                                                        <a href="#" style="display: block; padding: 8px 16px; color: black; border-radius: 4px; margin: 4px 0;">Galeria Centro de Lima</a>
                                                    </div>
                                                </div>
                                    
                                                <a href="#" class="button" style="display: inline-flex; align-items: center; justify-content: center; font-size: 24px; background-color: #007bff; color: white; border: none; border-radius: 8px; padding: 7px 15px; text-decoration: none; cursor: pointer;">
                                                    <i class="fas fa-download download-icon"></i>
                                                </a>
                                            </div>
                                    
                                            <div class="btn-group">
                                                <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Descarga
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="#">Copy</a>
                                                    <a class="dropdown-item" href="#">CSV</a>
                                                    <a class="dropdown-item" href="#">Excel</a>
                                                    <a class="dropdown-item" href="#">PDF</a>
                                                    <a class="dropdown-item" href="#">Print</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                        <div class="panel-body">
                                            <table class="table table-striped table-bordered table-hover">
                                                <h3 class="text-center">COMPRAS PRODUCTOS</h3> <!-- Título más prominente -->
                                                <br>
                                                <thead>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                        </td>
                                                        <td>Fecha</td>
                                                        <td>Nº RUC</td>
                                                        <td>Proveedor</td>
                                                        <td>RUC</td>
                                                        <td>Nº DOC Prov</td>
                                                        <td>Sub.Total</td>
                                                        <td>IGV</td>
                                                        <td>Total</td>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                        </td>
                                                        <td>23/10/2024</td>
                                                        <td>20601381461</td>
                                                        <td>IMPACTO</td>
                                                        <td>26958463245</td>
                                                        <td>72846344</td>
                                                        <td>S/ 1200</td>
                                                        <td>S/ 216</td>
                                                        <td>S/ 1416</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table table-striped table-bordered table-hover">
                                                <h3 class="text-center">FACTURAS</h3> <!-- Título más prominente -->
                                                <br>
                                                <thead>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                        </td>
                                                        <td>Fecha</td>
                                                        <td>Nº RUC</td>
                                                        <td>Proveedor</td>
                                                        <td>RUC</td>
                                                        <td>Nº DOC</td>
                                                        <td>Moneda</td>
                                                        <td>Sub. Total</td>
                                                        <td>IGV</td>
                                                        <td>Total</td>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                        </td>
                                                        <td>23/10/2024</td>
                                                        <td>20956328574</td>
                                                        <td>LOGISTICA FERRE</td>
                                                        <td>20635894521</td>
                                                        <td>84526955</td>
                                                        <td>PEN</td>
                                                        <td>s/ 1200</td>
                                                        <td>S/ 216</td>
                                                        <td>S/ 1416</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="table table-striped table-bordered table-hover">
                                                <h3 class="text-center">BOLETAS</h3> <!-- Título más prominente -->
                                                <br>
                                                <thead>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                        </td>
                                                        <td>Fecha</td>
                                                        <td>Nº DOC</td>
                                                        <td>Cliente</td>
                                                        <td>RUC</td>
                                                        <td>Nº Doc</td>
                                                        <td>Moneda</td>
                                                        <td>Sub. Total</td>
                                                        <td>IGV</td>
                                                        <td>Total</td>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <input type="checkbox"  checked class="i-checks" name="input[]">
                                                        </td>
                                                        <td>23/10/2024</td>
                                                        <td>72846344</td>
                                                        <td>Fabricio</td>
                                                        <td>20601381461</td>
                                                        <td>72846344</td>
                                                        <td>PEN</td>
                                                        <td>s/ 1200</td>
                                                        <td>S/ 216</td>
                                                        <td>S/ 1416</td>
                                                    </tr>
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
        </div>
    </div>
    <!-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
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

<!-- ------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->
<script>
    document.getElementById("btn-agregar-EP").onclick = function() {
        document.getElementById("formulario-agregar-producto").style.display = "block";
    };

    function cerrarFormulario() {
        document.getElementById("formulario-agregar-producto").style.display = "none";
    }
</script>


<!-- scrip para los calendarios -->
<script>
    $('#reportrange span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

    $('#reportrange').daterangepicker({
        format: 'MM/DD/YYYY',
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/2012',
        maxDate: '12/31/2015',
        dateLimit: { days: 60 },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'right',
        drops: 'down',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-default',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Cancel',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    }, function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });
</script>
<script>
    $('#reportrange1 span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

    $('#reportrange1').daterangepicker({
        format: 'MM/DD/YYYY',
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/2012',
        maxDate: '12/31/2015',
        dateLimit: { days: 60 },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'right',
        drops: 'down',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-default',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Cancel',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    }, function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange1 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });
</script>
<script>
    $('#reportrange2 span').html(moment().subtract(29, 'days').format('MMMM D, YYYY') + ' - ' + moment().format('MMMM D, YYYY'));

    $('#reportrange2').daterangepicker({
        format: 'MM/DD/YYYY',
        startDate: moment().subtract(29, 'days'),
        endDate: moment(),
        minDate: '01/01/2012',
        maxDate: '12/31/2015',
        dateLimit: { days: 60 },
        showDropdowns: true,
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        opens: 'right',
        drops: 'down',
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-primary',
        cancelClass: 'btn-default',
        separator: ' to ',
        locale: {
            applyLabel: 'Submit',
            cancelLabel: 'Cancel',
            fromLabel: 'From',
            toLabel: 'To',
            customRangeLabel: 'Custom',
            daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            firstDay: 1
        }
    }, function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange2 span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    });
</script>

@endsection
