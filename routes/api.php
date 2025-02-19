<?php

use Illuminate\Http\Request;
use App\GarantiaGuiaIngreso;
use App\GarantiaGuiaEgreso;
use App\GarantiaInformeTecnico;
use App\Producto;
use App\Categoria;
use App\Http\Controllers\ApiController;
// use DB;
// use DataTables;
Use App\Cliente;

use App\Providers\RouteServiceProvider;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
// PRODUCTOS
Route::group([ 'middleware' => 'api.validate'], function () {

            // your protected routes.
    Route::get('productos', [ApiController::class, 'getProductos']);
    // GARANTIA GUIA INGRESO
    Route::get('garantia_ingreso',[ApiController::class, 'getGarantiaIngreso']);
    // GARANTIA GUIA INGRESO para Egreso
    Route::get('garantia_ingreso_guias',[ApiController::class, 'getGarantiaIngresoGuias']);
    // GARANTIA GUIA Egreso para Informe Tecnico
    Route::get('garantia_egreso_guias',[ApiController::class, 'getGarantiaEgresoGuias']);
    // GARANTIA GUIA EGRESO
    Route::get('garantia_egreso',[ApiController::class, 'getGarantiaEgreso']);
    //INFORME TECNICO
    Route::get('informe_tecnico', [ApiController::class, 'getInformeTecnico']);

    //CLIENTES
    Route::get('clientes',[ApiController::class, 'getClientes']);
});
//TIPO DE CAMBIO


