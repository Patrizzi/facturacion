<?php

Route::post('/garantia-producto', 'LotesGarantias\GarantiasController@ajaxGarantiaProducto')->name('lotes-garantias.ajax.garantia-producto');
Route::post('/garantia-cliente', 'LotesGarantias\GarantiasController@ajaxGarantiaCliente')->name('lotes-garantias.ajax.garantia-cliente');
