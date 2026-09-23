<?php

use Illuminate\Support\Facades\Route;

Route::prefix('inventario/lotes-garantias/ajax')->group(function () {
    Route::post('/busqueda-serie', 'LotesGarantias\BusquedaSerieController@ajaxBuscarSerie')
        ->name('lotes-garantias.ajax.busqueda-serie');
});
