<?php

use App\Http\Controllers\Auth\LoginController;
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
//GLOBAL LOGIN
Route::get('verifyCredentials/{email}/{password}', [LoginController::class, 'verifyCredentials']);

// PRODUCTOS
Route::group([ 'middleware' => 'api.validate'], function () {

    // your protected routes.
    Route::get('productos', [ApiController::class, 'getProductos']);
    Route::get('productos',function(){
        $producto = DB::table('productos')
        ->select('*',
            'productos.id as prod_id' ,
            'productos.nombre as prod_nomnre' ,
            'marcas.nombre as nombre_marca',
            'familias.descripcion as familia_desc',
            'tipo_afectacion.informacion as afectacion_info',
            'estado.nombre as estado_nom' )
        ->join('familias', 'productos.familia_id', '=', 'familias.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->join('tipo_afectacion', 'productos.tipo_afectacion_id', '=', 'tipo_afectacion.id')
        ->join('estado', 'productos.estado_id', '=', 'estado.id')
        ->get();
        return DataTables($producto)->toJson();
    });

    Route::get('productos-inactivo',function(){
        $producto = DB::table('productos')
        ->select('*',
            'productos.id as prod_id' ,
            'productos.nombre as prod_nomnre' ,
            'marcas.nombre as nombre_marca',
            'familias.descripcion as familia_desc',
            'tipo_afectacion.informacion as afectacion_info',
            'estado.nombre as estado_nom' )
            ->where ('estado_id','=','2')
        ->join('familias', 'productos.familia_id', '=', 'familias.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->join('tipo_afectacion', 'productos.tipo_afectacion_id', '=', 'tipo_afectacion.id')
        ->join('estado', 'productos.estado_id', '=', 'estado.id')
        ->get();
        return DataTables($producto)->toJson();
    });

    Route::get('productos-anular',function(){
        $producto = DB::table('productos')
        ->select('*',
            'productos.id as prod_id' ,
            'productos.nombre as prod_nomnre' ,
            'marcas.nombre as nombre_marca',
            'familias.descripcion as familia_desc',
            'tipo_afectacion.informacion as afectacion_info',
            'estado.nombre as estado_nom' )
            ->where ('estado_anular','=','0')
        ->join('familias', 'productos.familia_id', '=', 'familias.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->join('tipo_afectacion', 'productos.tipo_afectacion_id', '=', 'tipo_afectacion.id')
        ->join('estado', 'productos.estado_id', '=', 'estado.id')
        ->get();
        return DataTables($producto)->toJson();
    });

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

    Route::get('get_familias',[ApiController::class, 'getFamilias'])->name('api.get_familias');

    Route::get('get_garantias',[ApiController::class, 'getGarantias'])->name('api.get_garantias');

    Route::get('get_marcas',[ApiController::class, 'getMarcas'])->name('api.get_marcas');

    Route::get('get_motivos',[ApiController::class, 'getMotivos'])->name('api.get_motivos');

    Route::get('get_tipo_cambio',[ApiController::class, 'getTipoCambio'])->name('api.get_tipo_cambio');

    Route::get('get_categorias',[ApiController::class, 'getCategorias'])->name('api.get_categorias');

    Route::get('get_unidad_medida',[ApiController::class, 'getUnidadMedida'])->name('api.get_unidad_medida');

    Route::get('get_validez',[ApiController::class, 'getValidez'])->name('api.get_validez');

    Route::get('get_servicios',[ApiController::class, 'getServicios'])->name('api.get_servicios');

    Route::get('get_productos',[ApiController::class, 'getProductosTable'])->name('api.get_productos');

    Route::get('get_alarma',[ApiController::class, 'getAlarma'])->name('api.get_alarma');

    Route::get('get_guia_ingreso',[ApiController::class, 'getAlarma'])->name('api.get_guia_ingreso');



});

//TIPO DE CAMBIO


