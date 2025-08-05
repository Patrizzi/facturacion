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
    // Route::get('productos', [ApiController::class, 'getProductos']);
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
        return response()->json($producto);
    });

    // Route::get('productos-inactivo',function(){
    //     $producto = DB::table('productos')
    //     ->select('*',
    //         'productos.id as prod_id' ,
    //         'productos.nombre as prod_nomnre' ,
    //         'marcas.nombre as nombre_marca',
    //         'familias.descripcion as familia_desc',
    //         'tipo_afectacion.informacion as afectacion_info',
    //         'estado.nombre as estado_nom' )
    //         ->where ('estado_id','=','2')
    //     ->join('familias', 'productos.familia_id', '=', 'familias.id')
    //     ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
    //     ->join('tipo_afectacion', 'productos.tipo_afectacion_id', '=', 'tipo_afectacion.id')
    //     ->join('estado', 'productos.estado_id', '=', 'estado.id')
    //     ->get();
    //     return DataTables($producto)->toJson();
    // });

    // Route::get('productos-anular',function(){
    //     $producto = DB::table('productos')
    //     ->select('*',
    //         'productos.id as prod_id' ,
    //         'productos.nombre as prod_nomnre' ,
    //         'marcas.nombre as nombre_marca',
    //         'familias.descripcion as familia_desc',
    //         'tipo_afectacion.informacion as afectacion_info',
    //         'estado.nombre as estado_nom' )
    //         ->where ('estado_anular','=','0')
    //     ->join('familias', 'productos.familia_id', '=', 'familias.id')
    //     ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
    //     ->join('tipo_afectacion', 'productos.tipo_afectacion_id', '=', 'tipo_afectacion.id')
    //     ->join('estado', 'productos.estado_id', '=', 'estado.id')
    //     ->get();
    //     return DataTables($producto)->toJson();
    // });

    
});

// Rutas por autenticación para su uso dentro del Sistema de Leonosoft
Route::group(['middleware' => ['web', 'auth','cambio_diario']], function () {

   // GARANTIA GUIA INGRESO
    Route::get('garantia_ingreso',[ApiController::class, 'getGarantiaIngreso']);
    // GARANTIA GUIA INGRESO para Egreso
    Route::get('garantia_ingreso_guias',[ApiController::class, 'getGarantiaIngresoGuias']);
    // GARANTIA GUIA Egreso para Informe Tecnico
    Route::get('garantia_egreso_guias',[ApiController::class, 'getGarantiaEgresoGuias']);
    // GARANTIA GUIA EGRESO
    // Route::get('garantia_egreso',[ApiController::class, 'getGarantiaEgreso']);
    //INFORME TECNICO
    Route::get('informe_tecnico', [ApiController::class, 'getInformeTecnico']);
    //CLIENTES
    Route::get('clientes',[ApiController::class, 'getClientes']);
    //FAMILIAS
    Route::get('get_familias',[ApiController::class, 'getFamilias'])->name('api.get_familias');
    // GARANTIA PARA COMPROBANTES
    Route::get('get_garantias',[ApiController::class, 'getGarantias'])->name('api.get_garantias');
    // MARCAS
    Route::get('get_marcas',[ApiController::class, 'getMarcas'])->name('api.get_marcas');
    // MOTIVOS
    Route::get('get_motivos',[ApiController::class, 'getMotivos'])->name('api.get_motivos');
    // TIPO DE CAMBIO
    Route::get('get_tipo_cambio',[ApiController::class, 'getTipoCambio'])->name('api.get_tipo_cambio');
    // CATEGORIAS PARA PRODUCTOS
    Route::get('get_categorias',[ApiController::class, 'getCategorias'])->name('api.get_categorias');
    // UNIDAD DE MEDIDA
    Route::get('get_unidad_medida',[ApiController::class, 'getUnidadMedida'])->name('api.get_unidad_medida');
    // VALIDEZ
    Route::get('get_validez',[ApiController::class, 'getValidez'])->name('api.get_validez');
    // SERVICIOS
    Route::get('get_servicios',[ApiController::class, 'getServicios'])->name('api.get_servicios');
    // PRODUCTOS
    Route::get('get_productos',[ApiController::class, 'getProductosTable'])->name('api.get_productos');
    // ALARMAS
    Route::get('get_alarma',[ApiController::class, 'getAlarma'])->name('api.get_alarma');
    // GUIA INGRESO
    Route::get('get_guia_ingreso',[ApiController::class, 'getGarantiaIngresoTable'])->name('api.get_guia_ingreso');
    // GUIA EGRESO
    Route::get('get_guia_egreso',[ApiController::class, 'getGarantiaEgresoTable'])->name('api.get_guia_egreso');
    // INFORME TECNICO
    Route::get('get_guia_informe_tecnico',[ApiController::class, 'getGarantiaInformeTecnicoTable'])->name('api.get_guia_informe_tecnico');
    // PERSONAL
    Route::get('get_personal',[ApiController::class, 'getPersonalTable'])->name('api.get_personal');

    Route::get('get_proveedor',[ApiController::class, 'getProveedorTable'])->name('api.get_proveedor');
});


