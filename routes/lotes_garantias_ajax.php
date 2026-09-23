<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Rutas AJAX - Control de Lotes y Garantías
|--------------------------------------------------------------------------
| Cada desarrollador registra aquí su endpoint AJAX específico conforme a
| INSTRUCCIONES_AGENTES_IA.md para evitar colisiones en routes/web.php.
|
*/

Route::prefix('inventario/lotes-garantias/ajax')->group(function () {
    // DEV 1: Detalle de Lote (se activará cuando Dev 1 cree su controlador)
    // Route::post('/detalle-lote', 'LotesGarantias\DetalleLoteController@ajaxLotes')->name('lotes-garantias.ajax.detalle-lote');

    // DEV 2: Búsqueda por Serie (se activará cuando Dev 2 cree su controlador)
    // Route::post('/busqueda-serie', 'LotesGarantias\BusquedaSerieController@ajaxBuscarSerie')->name('lotes-garantias.ajax.busqueda-serie');

    // DEV 3: Inventario Inicial
    Route::post('/inventario-inicial', 'LotesGarantias\InventarioInicialController@ajaxInventario')
        ->name('lotes-garantias.ajax.inventario-inicial');

    // DEV 4: Garantías (se activará cuando Dev 4 cree su controlador)
    // Route::post('/garantia-producto', 'LotesGarantias\GarantiasController@ajaxGarantiaProducto')->name('lotes-garantias.ajax.garantia-producto');
    // Route::post('/garantia-cliente', 'LotesGarantias\GarantiasController@ajaxGarantiaCliente')->name('lotes-garantias.ajax.garantia-cliente');
});
