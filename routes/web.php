<?php
// DB::listen(function($query){
// 	echo "<pre>{$query->sql}</pre>";
// });
// a

// Route::get('sentencia1', function (App\Sentencia $post) {
// 	return $post->boleta();
// });
// Route::get('sentencia2', function (App\Sentencia $post) {
// 	return $post->cotizacion();
// });

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ParameterCallController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\GuiaServicioController;
use App\Http\Controllers\GuiaServicioClienteController;
use App\Http\Controllers\OrdenServicioController;
use Illuminate\Support\Facades\Route;

Route::group(
	[ 'middleware' => ['auth','api','cambio_diario']],
	function(){

		// Route::view('/' , 'home')->name('inicio');
		Route::get('/' , 'ViewController@home')->name('inicio');

		Route::post('configuracion_guias_ingresos', 'ConfiguracionGuiaIngresosController@store')->name('envio_confi_ingresos');

		Route::post('/whatsapp','AgregadoRapidoController@send_whatsapp')->name('agregado.whatsapp_send');
		Route::resource('/almacen','AlmacenController');
		Route::resource('/apariencia','ConfigController');
		Route::resource('/cotizacion_manual','CotizacionManualController');
		Route::post('/cotizacion_manual/update/{id}','CotizacionManualController@update')->name('cotizacion_manual.update');
		Route::post('/cotizacion_manual/codigo','CotizacionManualController@change_almacen_tipo')->name('cotizacion_manual.change_almacen_tipo');
		Route::get('/cotizacion_manual/print/{id}','CotizacionManualController@print')->name('cotizacion_manual.print');
		Route::get('/cotizacion_manual/facturar/{id}','CotizacionManualController@facturar')->name('cotizacion_manual.facturar');
		Route::post('/cotizacion_manual/facturar_store' , 'CotizacionManualController@facturar_store')->name('cotizacion_manual.facturar_store');
		Route::get('/cotizacion_manual/boletear/{id}','CotizacionManualController@boletear')->name('cotizacion_manual.boletear');
		Route::post('/cotizacion_manual/boletear_store' , 'CotizacionManualController@boletear_store')->name('cotizacion_manual.boletear_store');
		Route::get('/cotizacion_manual/free_print/{id}' , 'CotizacionManualController@free_print')->name('cotizacion_manual.free_print');

		Route::get('/cotizacion_manual/nota_venta/{id}','CotizacionManualController@gen_nota_venta')->name('cotizacion_manual.gen_nota_venta');
		Route::post('/cotizacion_manual/nota_venta_store','CotizacionManualController@nota_venta_store')->name('cotizacion_manual.nota_venta_store');

		Route::resource('/categoria','CategoriaController')->only(['index','create','store','update']);;
		Route::resource('/vendedores','PersonalVentaController');
		Route::put('vendedores/aprobar/{id}', 'PersonalVentaController@aprobar')->name('vendedores.aprobar');
		Route::put('vendedores/procesado/{id}', 'PersonalVentaController@procesado')->name('vendedores.procesado');

		Route::put('vendedores/estado/{id}', 'PersonalVentaController@estado')->name('vendedores.estado');

		Route::resource('/registros','Ventas_registroController');

		// COTIZACIONES - ajax para el llamado de datos
		Route::get('/ventas/cotizaciones', 'Ventas_registroController@cotizacion_tab')->name('ventas.cotizacion');
		Route::get('/ventas/cotizaciones-data', 'Ventas_registroController@cotizacion_registers')->name('ventas.cotizacion_registers');
		Route::get('/ventas/cotizaciones-manual-data', 'Ventas_registroController@cotizacion_manual_registers')->name('ventas.cotizacion_manual_registers');
		Route::get('/ventas/nota-venta-data', 'Ventas_registroController@nota_venta_registers')->name('ventas.nota_venta_registers');


		Route::get('/ventas/cotizaciones_manuales', 'Ventas_registroController@cotizacion_manual_tab')->name('ventas.cotizacion_manual');
		Route::get('/ventas/notas_ventas', 'Ventas_registroController@nota_venta_tab')->name('ventas.nota_venta');

		Route::post('/cliente/contac','ClienteController@storecontact')->name('cliente.storecontact');
		Route::resource('/cliente','ClienteController');
		Route::resource('/cliente_sucursal','ClienteSucursalController')->except('[store]');
		// Route::post('/cliente_sucursal/{id}','ClienteSucursalController@store')->name('cliente_sucursal.store');
		// Route::post('/cliente_sucursal/departamento','ClienteController@ajax_dep')->name('sucursal_dep_cli.ajax_dep');

		Route::post('/cliente_retenedores/{id}' , 'ClienteRetenedoresController@update')->name('cliente_retenedores.reupdate');
		Route::resource('/compra','CompraController');

// COTIZACIONES BOLETA - FACTURA
		//boleta
		Route::post('/cotizacion/create_boleta' , 'CotizacionController@create_boleta')->name('cotizacion.create_boleta');
		Route::post('/cotizacion/create_boleta_ms' , 'CotizacionController@create_boleta_ms')->name('cotizacion.create_boleta_ms');
		Route::put('/cotizacion/store_boleta/{id}','CotizacionController@store_boleta')->name('cotizacion.store_boleta');
		//factura

		// Route::get('cotizacion/fast_print', 'CotizacionController@fast_print')->name('cotizacion.fast_print');
		Route::post('/cotizacion/create_factura' , 'CotizacionController@create_factura')->name('cotizacion.create_factura');
		// Route::post('/cotizacion/create_factura_ms' , 'CotizacionController@create_factura_ms')->name('cotizacion.create_factura_ms');

		Route::put('/cotizacion/store_factura/{id}','CotizacionController@store_factura')->name('cotizacion.store_factura');
		Route::get('/cotizacion/print_cotizacion/{id}' , 'CotizacionController@print')->name('cotizacion.print');
		Route::get('/cotizacion/free_print/{id}' , 'CotizacionController@free_print')->name('cotizacion.free_print');
		Route::post('/cotizacion/facturar/{id}' , 'CotizacionController@facturar')->name('cotizacion.facturar');
		Route::post('/cotizacion/facturar_store' , 'CotizacionController@facturar_store')->name('cotizacion.facturar_store');

		//BOLETA
		Route::post('/cotizacion/boletear/{id}' , 'CotizacionController@boletear')->name('cotizacion.boletear');
		Route::post('/cotizacion/boletear_store' , 'CotizacionController@boletear_store')->name('cotizacion.boletear_store');
		Route::get('/cotizacion/print_cotizacion_servicio/{id}' , 'CotizacionServiciosController@print')->name('cotizacion_servicio.print');
		Route::post('ticket_ajax_coti', 'CotizacionController@ticket_ajax_cotizacion')->name('ticket_ajax_coti');

		Route::resource('/cotizacion','CotizacionController');
		Route::post('/cotizacion/update/{id}','CotizacionController@update')->name('cotizacion.update');

		Route::post('cotizacion/nota_venta/{id}', 'CotizacionController@nota_venta_gen')->name('cotizacion.nota_venta');
		Route::post('cotizacion/nota_venta_store', 'CotizacionController@nota_venta_store')->name('cotizacion.nota_venta_store');

		// Route::put('/cotizacion/store/{id_moneda}','CotizacionController@store')->name('cotizacion.store');
		Route::resource('/empresa/banco','BancoController'); //Banco
		Route::post('/bancos/search', 'BancoController@search_registros')->name('bancos.registros_search');

//COTIZACIOBNES SERVICIO
		//FACTURA
		Route::post('/cotizacion_servicio/create_factura' , 'CotizacionServiciosController@create_factura')->name('cotizacion_servicio.create_factura');
		Route::post('/cotizacion_servicio/create_factura_ms' , 'CotizacionServiciosController@create_factura_ms')->name('cotizacion_servicio.create_factura_ms');
		Route::put('/cotizacion_servicio/store_factura/{id}','CotizacionServiciosController@store_factura')->name('cotizacion_servicio.store_factura');
		Route::get('/cotizacion_servicio/facturar/{id}' , 'CotizacionServiciosController@facturar')->name('cotizacion_servicio.facturar');
		Route::post('/cotizacion_servicio/facturar_store' , 'CotizacionServiciosController@facturar_store')->name('cotizacion_servicio.facturar_store');

		// boleta
		Route::post('/cotizacion_servicio/create_boleta' , 'CotizacionServiciosController@create_boleta')->name('cotizacion_servicio.create_boleta');
		Route::post('/cotizacion_servicio/create_boleta_ms' , 'CotizacionServiciosController@create_boleta_ms')->name('cotizacion_servicio.create_boleta_ms');
		Route::put('/cotizacion_servicio/store_boleta/{id}','CotizacionServiciosController@store_boleta')->name('cotizacion_servicio.store_boleta');
		Route::get('/cotizacion_servicio/boletear/{id}' , 'CotizacionServiciosController@boletear')->name('cotizacion_servicio.boletear');
		Route::post('/cotizacion_servicio/boletear_store' , 'CotizacionServiciosController@boletear_store')->name('cotizacion_servicio.boletear_store');

		Route::resource('/cotizacion_servicio','CotizacionServiciosController')->except(['store']);
		// Route::put('/cotizacion_servicio/store/{id_moneda}','CotizacionServiciosController@store')->name('cotizacion.store');
		Route::post('ticket_ajax_coti_serv', 'CotizacionServiciosController@ticket_ajax_cotizacion')->name('ticket_ajax_coti_serv');
//FACTURACION SERVICIOS
		Route::post('/facturacion_servicio/create_ms','FacturacionServicioController@create_ms')->name('facturacion_servicio.create_ms');
		Route::post('/facturacion_servicio/create','FacturacionServicioController@create')->name('facturacion_servicio.create');
		Route::resource('/facturacion_servicio','FacturacionServicioController')->except(['create']);

//BOLETA SERVICIOS
		Route::post('/boleta_servicio/create_ms','BoletaServicioController@create_ms')->name('boleta_servicio.create_ms');
		Route::post('/boleta_servicio/create','BoletaServicioController@create')->name('boleta_servicio.create');
		Route::resource('/boleta_servicio','BoletaServicioController')->except(['create']);
//NOTA VENTA
		Route::resource('/nota_venta','NotaVentaController')->except(['destroy','create']);
		Route::post('/nota_venta/create','NotaVentaController@create')->name('nota_venta.create');
		Route::post('/nota_venta/update/{id}','NotaVentaController@update')->name('nota_venta.update');
		Route::post('/nota_venta/anulacion/{id}','NotaVentaController@anulacion')->name('nota_venta.anulacion');
		Route::get('/nota_venta/print/{id}' , 'NotaVentaController@print')->name('nota_venta.print');
		Route::get('/nota_venta/ticket/{id}' , 'NotaVentaController@ticket')->name('nota_venta.ticket');
		Route::post('/nota_venta/precio_sugerido' , 'NotaVentaController@precio_sugerido')->name('nota_venta.precio_sugerido');


//NOTA VENTA

//FACTURACION ELECTRONICA
		//factura
		Route::post('/facturacion_electronica_factura','FacturacionElectronicaController@factura')->name('facturacion_electronica.factura_sunat');
		Route::post('/facturacion_electronica/send_all','FacturacionElectronicaController@fac_elec_all')->name('facturacion_electronica.factura_elec_all');
		Route::post('/facturacion_electronica/validacion','FacturacionElectronicaController@validacion_sunat')->name('facturacion_electronica.validacion_sunat');
		//factura manual
		Route::post('/facturacion_electronica_factura_m','FacturacionElectronicaController@facturacion_m_e')->name('facturacion_electronica.facturacion_m_e');
		Route::post('/facturacion_electronica_factura_m/send_all','FacturacionElectronicaController@fac_elec_man_all')->name('facturacion_electronica.fac_elec_man_all');
		//boleta
		Route::get('/facturacion_electronica_boleta','FacturacionElectronicaController@index_boleta')->name('facturacion_electronica.index_boleta');
		Route::post('/facturacion_electronica_boleta','FacturacionElectronicaController@boleta')->name('facturacion_electronica.boleta_sunat');
		Route::post('/facturacion_electronica_boleta/send_all','FacturacionElectronicaController@boleta_elec_all')->name('facturacion_electronica.boleta_elec_all');
		Route::post('/facturacion_electronica/validacion_boleta','FacturacionElectronicaController@validacion_sunat_boleta')->name('facturacion_electronica.validacion_sunat_boleta');
		//boleta manual
		Route::post('/facturacion_electronica_boleta_m','FacturacionElectronicaController@boleta_m_e')->name('facturacion_electronica.boleta_m_e');
		Route::post('/facturacion_electronica_boleta_m/send_all','FacturacionElectronicaController@boleta_m_e_all')->name('facturacion_electronica.boleta_m_e_all');
		//guia remision
		Route::get('/facturacion_electronica_guia_remision','FacturacionElectronicaController@index_guia_remision')->name('facturacion_electronica.index_guia_remision');
		Route::post('/facturacion_electronica_guia_remision_prueba','FacturacionElectronicaController@guia_remision')->name('facturacion_electronica.guia_remision_sunat');
		Route::post('/facturacion_electronica_guia_remision_prueba_all/send_all','FacturacionElectronicaController@guia_remision_elec_all')->name('facturacion_electronica.guia_remision_elec_all');
		// * Guia Remision Manual
		Route::post('/facturacion_electronica_guia_remision_m_prueba','FacturacionElectronicaController@guia_remision_m')->name('facturacion_electronica.guia_remision_m_sunat');
		Route::post('/facturacion_electronica_guia_remision_m_prueba_all/send_all','FacturacionElectronicaController@guia_remision_m_all')->name('facturacion_electronica.guia_remision_m_all');
		//  CONSULTA CDR??
		Route::post('/f_e_consulta_guia','FacturacionElectronicaController@valid_cdr')->name('facturacion_electronica.valid_cdr');
		Route::post('/f_e_consulta_guia_manual','FacturacionElectronicaController@valid_cdr_manual')->name('facturacion_electronica.valid_cdr_manual');

		//guia remision baja
		Route::post('/facturacion_electronica_guia_remision_baja_prueba','FacturacionElectronicaController@guia_remision_baja')->name('facturacion_electronica.guia_remision_baja_sunat');
		Route::post('/facturacion_electronica_guia_remision_baja_m_prueba','FacturacionElectronicaController@guia_remision_m_baja_sunat')->name('facturacion_electronica.guia_remision_m_baja_sunat');

		//Nota Credito
		Route::get('/facturacion_electronica_nota_credito','FacturacionElectronicaController@index_nota_credito')->name('facturacion_electronica.index_nota_credito');
		Route::post('/facturacion_electronica_nota_credito','FacturacionElectronicaController@nota_credito')->name('facturacion_electronica.nota_credito');
		Route::post('/facturacion_electronica_nota_credito/send_all','FacturacionElectronicaController@nota_credito_all')->name('facturacion_electronica.nota_credito_all');
		Route::post('/facturacion_electronica_nota_credito_boleta','FacturacionElectronicaController@nota_credito_boleta')->name('facturacion_electronica.nota_credito_bol');
		//Nota Debito
		Route::get('/facturacion_electronica_nota_debito','FacturacionElectronicaController@index_nota_debito')->name('facturacion_electronica.index_nota_debito');
		Route::post('/facturacion_electronica_nota_debito','FacturacionElectronicaController@nota_debito')->name('facturacion_electronica.nota_debito');
		Route::post('/facturacion_electronica_nota_debito_boleta','FacturacionElectronicaController@nota_debito_boleta')->name('facturacion_electronica.nota_debito_bol');





		Route::resource('/facturacion_electronica','FacturacionElectronicaController');



		//NOTA DE CREDITO
		Route::post('/nota-credito/motivo','NotaCreditoController@motivo')->name('nota-credito.motivo');

		Route::post('/nota-credito-create-nc','NotaCreditoController@create_nota_credito')->name('nota-credito.create_nota_credito');
		Route::post('/nota-credito-create_boleta-nc','NotaCreditoController@create_boleta_nota_credito')->name('nota-credito.create_nota_credito_boleta');
		Route::get('/nota-credito/print/{id}','NotaCreditoController@print')->name('nota_credito.print');
		Route::get('/nota-credito/pdf/{id}','NotaCreditoController@pdf')->name('nota_credito.pdf');
		Route::post('/nota-credito/anular','NotaCreditoController@anular')->name('nota_credito.anular');

		Route::get('/nota-credito/create_boleta','NotaCreditoController@create_boleta')->name('nota-credito.create_boleta');
		Route::post('/nota-credito/store-boleta/{id}','NotaCreditoController@store_boleta')->name('nota-credito.store_boleta');
		Route::post('/nota-credito/store-factura/{id}','NotaCreditoController@store_factura')->name('nota-credito.store_factura');
		Route::resource('/nota-credito','NotaCreditoController');


		Route::post('/nota-debito-create-nc','NotaDebitoController@create_nota_debito')->name('nota-debito.create_nota_debito');
		Route::post('/nota-debito-create_boleta-nc','NotaDebitoController@create_boleta_nota_debito')->name('nota-debito.create_nota_debito_boleta');

		Route::post('/nota_debito_store_factura/{id}','NotaDebitoController@store')->name('nota-debito.nota_debito_store_factura');
		Route::post('/nota_debito_store_boleta/{id}','NotaDebitoController@store_boleta')->name('nota-debito.nota_debito_bol');

		Route::get('/nota-debito/create_boleta','NotaDebitoController@create_boleta')->name('nota-debito.create_boleta');
		Route::resource('/nota-debito','NotaDebitoController');

		Route::resource('/debito','DebitoController');
		Route::resource('/documento','DocumentoController');
		Route::resource('/empresa','EmpresaController')->only(['index','update','store']);

		// Route::get('facturacion/boleta/{id}' , 'FacturacionController@show_boleta')->name('boleta');
		// Route::get('facturacion/create_boleta/' , 'FacturacionController@create_boleta')->name('create.boleta');
		Route::get('/facturacion/print/{id}','FacturacionController@print')->name('facturacion.print');
		Route::get('/facturacion/ticket/{id}','FacturacionController@ticket')->name('facturacion.ticket');
		Route::post('/facturacion/create/ajax','FacturacionController@ajax')->name('facturacion.ajax');
		// Route::post('/facturacion/create/sss','FacturacionController@ajax')->name('facturacion.ajax');
		Route::post('/facturacion/create_ajax','FacturacionController@create_ajax')->name('facturacion.create_ajax');

		Route::post('/facturacion/create_ms','FacturacionController@create_ms')->name('facturacion.create_ms');
		// Route::post('/facturacion/store/{id}','FacturacionController@store')->name('facturacion.store');
		Route::resource('/facturacion','FacturacionController')->except(['store','create']);
		Route::post('/facturacion/create','FacturacionController@create')->name('facturacion.create');
		Route::put('/facturacion/store/{id_moneda}','FacturacionController@store')->name('facturacion.store');
		Route::post('/facturacion/anular','FacturacionController@anulacion')->name('facturacion.anulacion');
		Route::post('/facturacion/ajax_remision', 'FacturacionController@ajax_remision')->name('facturacion.ajx_remision');
		// Route::post('ticket_ajax_boleta', 'BoletaController@ticket_ajax_boleta')->name('ticket_ajax_boleta');


		//facturacion manual
		//->Vista para facturacion manual próximamente...
		Route::get('/facturacion_manual/print/{id}','FacturacionMController@print')->name('facturacion_manual.print');
		Route::get('/facturacion_manual/ticket/{id}','FacturacionMController@ticket')->name('facturacion_manual.ticket');

		Route::post('/facturacion_manual/codigo','FacturacionMController@change_almacen_tipo')->name('facturacion_manual.change_almacen_tipo');
		Route::resource('facturacion_manual','FacturacionMController');
		Route::post('/facturacion_manual/ajax_remision', 'FacturacionMController@ajax_remision')->name('facturacion_manual.ajx_remision');

		//boleta manual manual
		Route::resource('boleta_manual','BoletaMController');
		Route::post('/boleta_manual/codigo','BoletaMController@change_almacen_tipo')->name('boleta_manual.change_almacen_tipo');
		Route::get('/boleta_manual/print/{id}','BoletaMController@print')->name('boleta_manual.print');
		Route::get('/boleta_manual/ticket/{id}','BoletaMController@ticket')->name('boleta_manual.ticket');


		Route::post('/boleta/create_ms','BoletaController@create_ms')->name('boleta.create_ms');
		Route::get('/boleta/print/{id}','BoletaController@print')->name('boleta.print');
		Route::resource('/boleta','BoletaController')->except(['store','create']);
		Route::post('/boleta/create','BoletaController@create')->name('boleta.create');
		Route::put('/boleta/store/{id_moneda}','BoletaController@store')->name('boleta.store');
		Route::get('/boleta/ticket/{id}','BoletaController@ticket')->name('boleta.ticket');
		/*Guia Remision*/
		//para guia agregar el store en create_moneda secundaria enviando este una acptacion de 2 variables put en store para la identificaion de la moneda principal o secundaria
		Route::get('/guia_remision/print/{id}' , 'GuiaRemisionController@print')->name('guia_remision.print');

		Route::resource('/guia_remision','GuiaRemisionController');
		Route::post('/guia_remision/sucursal','GuiaRemisionController@ajax_sucursal')->name('guia_remision.ajax_sucursal');
		// Route::post('/guia_remision/create','GuiaRemisionController@create')->name('guia_remision.create');
		// Route::post('/guia_remision/ajax_p','GuiaRemisionController@ajax_producto')->name('remision.ajax_producto');
		Route::post('/guia_remision/peso_stock','GuiaRemisionController@peso_stock')->name('guia_remision.peso_stock');
		/* REMISION MANUAL */
		Route::resource('/guia_remision_manual','GuiaRemisionManualController');
		// Route::post('/guia_remision_manual/ajax_p','GuiaRemisionManualController@ajax_producto')->name('remision_m.ajax_producto');
		Route::post('/guia_remision_manual/peso','GuiaRemisionManualController@peso_ajax')->name('remision_m.peso_ajax');
		Route::post('/guia_remision_manual/almacen_guia','GuiaRemisionManualController@almacen_remision_m')->name('remision_m.almacen_remision_m');

		Route::get('/guia_remision_manual/print/{id}','GuiaRemisionManualController@print')->name('remision_m.print');


		Route::post('stock_ajax', 'KardexSalidaController@stock_ajax')->name('stock_ajax');
		Route::post('stock_ajax_distribucion', 'KardexEntradaDistribucionController@stock_ajax_distribucion')->name('stock_ajax_distribucion');
		Route::get('/guia_distribucion', 'KardexEntradaDistribucionController@guia_interna')->name('guia_interna');
		Route::post('ajax_direccion_almacen', 'KardexEntradaDistribucionController@ajax_direccion_almacen')->name('ajax_direccion_almacen');

		Route::post('stock_ajax_traslado', 'KardexEntradaTrasladoAlmacenController@stock_ajax_traslado')->name('stock_ajax_traslado');

		//Llamada general de los parámetros requeridos por el articulo (producto-servicio), por medio de ajax (parameter_call)
		// Route::post('parameter_call', 'CotizacionController@parameter_call')->name('parameter_call');

		// * Llamada general de los parámetros requeridos por el articulo (producto-servicio), por medio de ajax (parameter_call)
		Route::post('parameter_call/description', 'ParameterCallController@description')->name('pa.description');
		Route::post('parameter_call/getClients', 'ParameterCallController@getClients')->name('pa.clients');
		Route::post('parameter_call/getArticles', 'ParameterCallController@getArticles')->name('pa.articles');
		Route::post('parameter_call/getMoney', 'ParameterCallController@getMoney')->name('pa.money');
		Route::post('parameter_call/checkEmailCredential', 'ParameterCallController@checkEmailCredential')->name('pa.check_email');
		Route::post('parameter_call/getNFactura', 'ParameterCallController@getNFactura')->name('pa.nfactura');
		Route::post('parameter_call/getNumberLetter', 'ParameterCallController@getNumberLetter')->name('pa.numberletters');
		Route::post('parameter_call/ajax_remision', 'ParameterCallController@ajax_remision')->name('pa.ajax_remision');

		Route::post('descripcion_ajax_serv', 'CotizacionServiciosController@descripcion_ajax_serv')->name('descripcion_ajax_serv');

		Route::post('ajax_periodo', 'PeriodoConsultaController@ajax_periodo')->name('ajax_periodo');
		Route::post('ajax_movimiento', 'Consulta_MovimientoController@ajax_movimiento')->name('ajax_movimiento');

		Route::post('ajax_periodo_ventas', 'PeriodoConsultaController@ajax_periodo_ventas')->name('ajax_periodo_ventas');
		Route::post('ajax_movimiento_ventas', 'Consulta_MovimientoController@ajax_movimiento_ventas')->name('ajax_movimiento_ventas');
		Route::post('ajax_movimiento_ventas_b', 'Consulta_MovimientoController@ajax_movimiento_ventas_b')->name('ajax_movimiento_ventas_b');

		Route::get('guias_remision/seleccionar', 'GuiaRemisionController@seleccionar')->name('guia_remision.seleccionar');
		Route::put('cotizacion/aprobar/{id}', 'CotizacionController@aprobar')->name('cotizacion.aprobar');
		Route::get('/guias_remision/creates/{id}' , 'GuiaRemisionController@cotizacion')->name('guias_remision.create');
		// Route::get('/guia_remision/print/{id}' , 'GuiaRemisionController@print')->name('guias_remision.print');


		Route::resource('/vehiculo','VehiculoController');
		Route::post('/ajax_vehiculo_mtc','VehiculoController@scrapping_mtc')->name('vehiculo.ajax_mtc');

		Route::resource('/familia','FamiliaController');
		Route::resource('/subfamilia','SubfamiliaController');
		// Route::post('/subfamilia/{id}','SubfamiliaController@store')->name('subfamilia.store');
		// Route::post('/subfamilia_update/{id}','SubfamiliaController@update')->name('subfamilia.update');
		Route::post('/subfamilia_search','SubfamiliaController@search_ajax')->name('subfamilia.search_ajax');

		//Agregado rapido
		Route::post('agregado_rapido/marcas','AgregadoRapidoController@marcas_store')->name('agregado_rapido.marca_store');
		Route::post('agregado_rapido/cliente','AgregadoRapidoController@cliente_store')->name('agregado_rapido.cliente_store');

		Route::post('agregado_rapido/cliente/cotizacion','AgregadoRapidoController@cliente_cotizado')->name('agregado_rapido.cliente_cotizado');

		Route::post('agregado_rapido/personal_store','AgregadoRapidoController@personal_store')->name('agregado_rapido.personal_store');

		// * MailBox Configuracion
		Route::resource('/configuracion_email','EmailConfiguracionesController');
		// Route::get('/email_backup','EmailConfiguracionesController@email_backup')->name('email_backup');
		Route::post('/email_backup/save','EmailConfiguracionesController@backup_save')->name('backup_save');
		// Route::post('/configuracion_email/update/{id}','EmailConfiguracionesController@update')->name('configuracion_email.update');
		Route::post('/email/config/pdf','EmailConfiguracionesController@store')->name('email.config');
		// * MailBox Borradores
		Route::resource('/borradores_email','EmailBorradoresController');
		// * MailBox Bandeja y Papelera
		Route::resource('/email','EmailBandejaEnviosController');

		Route::post('email/delete','EmailBandejaEnviosController@delete')->name('email.delete');
		Route::get('/trash','EmailBandejaEnviosController@trash')->name('email.trash');
		// Route::post('/trash/delete','EmailBandejaEnviosController@destroy')->name('email.destroy');
		Route::post('/email/config','EmailBandejaEnviosController@configstore')->name('email.configstore');
		Route::post('/email/config/{id}','EmailBandejaEnviosController@configupdate')->name('email.configupdate');

		// * MAILBOX ENVIOS TRANSACCIONES
		Route::post('email/send','EmailBandejaEnviosController@send')->name('email.send');

		Route::post('/email/cotizacion/{id}','EmailTransaccionesSend@cotizacion')->name('email.cotizacion');
		Route::post('/email/cotizacion_manual/{id}','EmailTransaccionesSend@cotizacion_manual')->name('email.cotizacion_manual');
		Route::post('/email/guia_remision/{id}','EmailTransaccionesSend@guia_remision')->name('email.guia_remision');
		Route::post('/email/factura/{id}','EmailTransaccionesSend@factura')->name('email.factura');
		Route::post('/email/factura_manual/{id}','EmailTransaccionesSend@factura_manual')->name('email.factura_manual');
		Route::post('/email/boleta/{id}','EmailTransaccionesSend@boleta')->name('email.boleta');
		Route::post('/email/boleta_manual/{id}','EmailTransaccionesSend@boleta_manual')->name('email.boleta_manual');
		Route::post('/email/nota_venta/{id}','EmailTransaccionesSend@nota_venta')->name('email.nota_venta');
		Route::post('/email/nota_credito/{id}','EmailTransaccionesSend@nota_credito')->name('email.nota_credito');
		Route::post('/email/guia_ingreso/{id}','EmailTransaccionesSend@guia_ingreso')->name('email.guia_ingreso');
		Route::post('/email/guia_egreso/{id}','EmailTransaccionesSend@guia_egreso')->name('email.guia_egreso');
		Route::post('/email/informe_tecnico/{id}','EmailTransaccionesSend@informe_tecnico')->name('email.informe_tecnico');
		Route::post('/email/guia_remision_m/{id}','EmailTransaccionesSend@guia_remision_m')->name('email.guia_remision_m');

		//Garantias
		Route::get('contacto_cliente','GarantiaGuiaIngresoController@contacto_cliente');
		Route::get('contacto_cliente_actualizar','GarantiaGuiaIngresoController@contacto_cliente_actualizar');
		Route::POST('garantia_guia_ingreso/email/enviar','GarantiaGuiaIngresoController@enviar')->name('garantia_ingreso.enviar');
		Route::get('garantia_guia_ingreso/email/{id}','GarantiaGuiaIngresoController@email')->name('guia_ingreso.email');

		Route::get('garantia_guia_ingreso/impresionIngreso/{id}' , 'GarantiaGuiaIngresoController@print')->name('impresiones_ingreso');
		Route::put('garantia_guia_ingreso/{guia}', 'GarantiaGuiaIngresoController@actualizar')->name('garantia_guia_ingreso.actualizar');
		Route::resource('/garantia_guia_ingreso','GarantiaGuiaIngresoController')->except(['create']);
		Route::post('/garantia_guia_ingreso/create' , 'GarantiaGuiaIngresoController@create')->name('garantia_guia_ingreso.create');
		//AJAX DE TICKETS
		Route::post('ticket_ajax_ingreso', 'GarantiaGuiaIngresoController@ticket_guia_ingreso')->name('ticket_ajax_ingreso');

		Route::POST('garantia_guia_egreso/email/enviar','GarantiaGuiaEgresoController@enviar')->name('garantia_egreso.enviar');
		Route::get('garantia_guia_egreso/email/{id}','GarantiaGuiaEgresoController@email')->name('guia_egreso.email');

		Route::get('garantia_guia_egreso/impresionEgreso/{id}' , 'GarantiaGuiaEgresoController@print')->name('impresiones_egreso');
		Route::get('garantia_guia_egreso/guias', 'GarantiaGuiaEgresoController@guias')->name('garantia_guia_egreso.guias');
		Route::resource('/garantia_guia_egreso','GarantiaGuiaEgresoController')->except(['create','edit','destroy']);

		Route::get('garantia_guia_egreso/create_egreso/{id}', 'GarantiaGuiaEgresoController@create_egreso')->name('garantia_guia_egreso.create_egreso');


		Route::get('garantia_informe_tecnico/impresionInformeTecnico/{id}' , 'GarantiaInformeTecnicoController@print')->name('impresiones_informe');
		Route::get('garantia_informe_tecnico/{id}/actualizar', 'GarantiaInformeTecnicoController@actualizar')->name('garantia_informe_tecnico.actualizar');
		Route::get('garantia_informe_tecnico/guias', 'GarantiaInformeTecnicoController@guias')->name('garantia_informe_tecnico.guias');

		Route::resource('/garantia_informe_tecnico','GarantiaInformeTecnicoController')->except(['create','edit','destroy']);
		Route::get('garantia_informe_tecnico/create_tecnico/{id}', 'GarantiaInformeTecnicoController@create_tecnico')
		->name('garantia_informe_tecnico.create_tecnico');
		//Consultas
		Route::get('consultas/garantias-guias-ingreso', 'ConsultasController@garantias_guias_ingreso')->name('consultas.garantias.guias_ingreso');
		Route::get('consultas/garantias-guias-egreso', 'ConsultasController@garantias_guias_egreso')->name('consultas.garantias.guias_egreso');
		Route::get('consultas/garantias-informe-tecnico', 'ConsultasController@garantias_informe_tecnico')->name('consultas.garantias.informe_tecnico');

		Route::get('contacto/{id}', 'ContactoController@index_id')->name('contacto.index_id');
		Route::get('contacto/crear/{id}', 'ContactoController@crear')->name('contacto.crear');
		Route::get('contacto/editar/{id}', 'ContactoController@editar')->name('contacto.editar');
		Route::resource('/contacto','ContactoController');

		Route::resource('/guia','GuiaController');
		Route::resource('/horarios','HorariosController');
		Route::resource('/igv','IgvController')->only(['index','edit','update']);
		Route::resource('/fe_configuracion','FEConfigController')->only(['index','edit','update']);

		//Inventarios
		Route::resource('/inventario-inicial','InventarioInicialController');

		// Route::post('/autocomplete/fetch', 'KardexEntradaController@fetch')->name('autocomplete.fetch');
		// Route::get('autocomplete', 'KardexEntradaController@search');

		Route::get('kardex_entrada_productos','KardexEntradaController@productos');

		Route::resource('/kardex-entrada-Distribucion','KardexEntradaDistribucionController');
		Route::get('/kardex_distribucion_guia_print/{id}','KardexEntradaDistribucionController@print')->name('kardex-distribucion.print');
		Route::resource('/kardex-entrada','KardexEntradaController');
		Route::post('/kardex-entrada/destroy','KardexEntradaController@destroy')->name('kardex-entrada.destroy');
		Route::post('/kardex-entrada/inventario-inicial','KardexEntradaController@InventarioInicial')->name('kardex-entrada.i_inicial');


		Route::post('/kardex-entrada-Traslado-almacen/create','KardexEntradaTrasladoAlmacenController@create')->name('kardex-entrada-Traslado-almacen.create');
		Route::resource('/kardex-entrada-Traslado-almacen','KardexEntradaTrasladoAlmacenController')->except(['create']);

		Route::post('/kardex-salida/create' , 'KardexSalidaController@create')->name('kardex-salida.create');
		Route::resource('/kardex-salida','KardexSalidaController')->except(['create']);
		Route::resource('/periodo-consulta','PeriodoConsultaController');
		Route::resource('/movimiento-consulta','Consulta_MovimientoController');
		Route::resource('/cierre-periodo','CierrePeriodoController');
		Route::get('/cierre-periodo/pdf/{id}','CierrePeriodoController@pdf')->name('cierre-periodo.pdf');

		//Fin de inventarios

		Route::resource('/motivo','MotivoController');
		Route::resource('/marca','MarcaController');
		Route::resource('/moneda','MonedaController');
		// ADELANTOS
		Route::post('/adelanto/search_registro', 'CreditosAdelantosController@view_adl_registro')->name('adelantos.ajax_registro');
		// FACTURA
		Route::post('/adelantos/lista_ajax_fact', 'CreditosAdelantosController@ajax_fact')->name('adelantos.ajax_fact');
		Route::post('/adelantos/lista_ajax_fact_m', 'CreditosAdelantosController@ajax_fact_m')->name('adelantos.ajax_fact_m');
		Route::post('/adelantos/store_factura', 'CreditosAdelantosController@store_adelanto_factura')->name('adelantos.store_adelanto_factura');

		// BOLETA
		Route::post('/adelantos/lista_ajax_bol', 'CreditosAdelantosController@ajax_bol')->name('adelantos.ajax_bol');
		Route::post('/adelantos/lista_ajax_bol_m', 'CreditosAdelantosController@ajax_bol_m')->name('adelantos.ajax_bol_m');
		Route::post('/adelantos/store_boleta', 'CreditosAdelantosController@store_adelanto_boleta')->name('adelantos.store_adelanto_boleta');

		// NOTA VENTA
		Route::post('/adelantos/store_nota_venta', 'CreditosAdelantosController@store_nota_venta')->name('adelantos.store_nota_venta');



		Route::get('/adelantos/comprobantes/facturas/{id}', 'CreditosAdelantosController@comprobante_facturas')->name('adelantos.comprobante');
		Route::get('/adelantos/comprobantes_pdf/{id}','CreditosAdelantosController@comprobantes_pdf')->name('adelantos.comprobantes_pdf');
		// PAGADOS
		Route::resource('/pagados','PagadosController');
		Route::post('/pagados/lista_ajax','PagadosController@lista_ajax')->name('pagos.lista_ajax');
		// Route::get('/pagos/facturas','PagadosController@index_factura')->name('pagos.index_factura');index_factura
		// PAGADOS FACTURAS
		Route::get('/pagos/facturas','PagadosController@view_facturas')->name('pagos.view_facturas');
		Route::post('/pagados/lista_ajax_fact','PagadosController@lista_ajax_fact')->name('pagos.lista_ajax_fact');
		Route::get('/pagos/facturas/{id}','PagadosController@show_facturas')->name('pagos.show_facturas');
		Route::get('/pagos/facturas/cliente/{ruc}','PagadosController@show_cliente_factura')->name('pagos.show_cliente_factura');
		// PAGADOS FACTURAS MANUALES
		Route::get('/pagos/facturas_m','PagadosController@view_facturas_m')->name('pagos.view_facturas_m');
		Route::post('/pagados/lista_ajax_fact_m','PagadosController@lista_ajax_fact_m')->name('pagos.lista_ajax_fact_m');
		Route::get('/pagos/facturas_m/{id}','PagadosController@show_facturas_m')->name('pagos.show_facturas_m');
		Route::get('/pagos/facturas_m/cliente/{ruc}','PagadosController@show_cliente_factura_m')->name('pagos.show_cliente_factura_m');
		// PAGADOS BOLETAS
		Route::post('/pagados/store_boleta','PagadosController@store_boleta')->name('pagos.store_boleta');

		Route::get('/pagos/boletas','PagadosController@view_boletas')->name('pagos.view_boletas');
		Route::post('/pagados/lista_ajax_boletas','PagadosController@lista_ajax_boleta')->name('pagos.lista_ajax_boletas');
		Route::get('/pagos/boletas/{id}','PagadosController@show_boletas')->name('pagos.show_boletas');
		Route::get('/pagos/boletas/cliente/{ruc}','PagadosController@show_cliente_boleta')->name('pagos.show_cliente_boleta');
		// PAGADOS BOLETAS MANUALES
		Route::get('/pagos/boletas_m','PagadosController@view_boletas_m')->name('pagos.view_boletas_m');
		Route::post('/pagados/lista_ajax_boletas_m','PagadosController@lista_ajax_boletas_m')->name('pagos.lista_ajax_boletas_m');
		Route::get('/pagos/boletas_m/{id}','PagadosController@show_boletas_m')->name('pagos.show_boletas_m');
		Route::get('/pagos/boletas_m/cliente/{ruc}','PagadosController@show_cliente_boleta_m')->name('pagos.show_cliente_boleta_m');
		//PAGADOS DE NOTA DE VENTA
		Route::post('/pagados/store_nota_venta','PagadosController@store_n_venta')->name('pagos.store_n_venta');

		Route::get('/pagos/nota_venta','PagadosController@view_nota_venta')->name('pagos.view_nota_venta');
		Route::post('/pagados/lista_ajax_n_venta','PagadosController@lista_ajax_n_venta')->name('pagos.lista_ajax_n_venta');
		Route::get('/pagos/nota_venta/{id}','PagadosController@show_nota_venta')->name('pagos.show_nota_venta');
		Route::get('/pagos/nota_venta/cliente/{ruc}','PagadosController@show_cliente_nota_v')->name('pagos.show_cliente_nota_v');



		Route::post('/show_cuotas','PagadosController@show_cuotas')->name('pagos.show_cuota');
		Route::get('/show_cuotas/print/{id}','PagadosController@print_cuotas')->name('pagos.print_cuotas');
		// Route::post('/pagados/store',)
		Route::resource('/pedidos','PedidosController');
		Route::resource('/personal','PersonalController');

		Route::get('/personal-laboral/{id}','PersonalDatosLaboralesController@idpersonal')->name('create.laboral');
		Route::resource('/personal-datos-laborales','PersonalDatosLaboralesController');
		Route::post('/productos_ajax','ProductosController@index_ajax')->name('productos.index_ajax');
		Route::resource('/productos','ProductosController');
		Route::resource('/promedios','PromediosController');

		Route::post('/provedor/add','ProvedorController@store_kardex')->name('provedor.store_kardex');

		//Agregado Rapido
		Route::get('provedorruc', 'ProvedorController@ruc');
		Route::get('clienteruc', 'ClienteController@ruc');
		Route::get('clientedni', 'ClienteController@dni');
		Route::resource('/provedor','ProvedorController');

		Route::resource('/servicios','ServiciosController');
		Route::post('/servicios_destroy','ServiciosController@destroy')->name('servicios.destroy');
		Route::resource('/transaccion-compra','TransaccionCompraController');
		Route::resource('/unidad-medida','UnidadMedidaController');


		//Usuarios
		Route::get('/usuario/lista','UsuarioController@lista')->name('usuario.lista');
		Route::get('usuario/crear/{id}','UsuarioController@crear')->name('usuario.crear');
		Route::post('usuario/creacion/{guia}', 'UsuarioController@creacion')->name('usuario.creacion');
		Route::post('usuario/envio_codigo/{id}', 'UsuarioController@envio_codigo')->name('usuario.envio_codigo');
		Route::post('usuario/activar/{id}', 'UsuarioController@activar')->name('usuario.activar');
		Route::get('usuario/permiso/{id}','UsuarioController@permiso')->name('usuario.permiso');
		Route::post('usuario/permisos/asignar/{id}','UsuarioController@asignar_permiso')->name('usuario.asignar_permiso');
		Route::post('usuario/permisos/delegar/{id}','UsuarioController@delegar_permiso')->name('usuario.delegar_permiso');
		Route::resource('/usuario','UsuarioController');
		Route::get('/usuarios','UsuarioController@index_usuarios')->name('usuarios.index');
		Route::resource('/venta','VentaController');

		Route::get('/cantidad_precio/servicio','CantidadPrecioController@index_servicio')->name('cantidad_precio.index_servicio');
		Route::resource('/cantidad_precio','CantidadPrecioController');

		Route::view('/configuracion_general' , 'configuracion_general.configuracion_general')->name('Configuracion');
//Validez y Garantia
		Route::resource('/garantia','GarantiaController');
		Route::resource('/validez','ValidezController');

		//Ajax
		// Route::get('/inventario.kardex.entrada.create', 'KardexEntradaController@index');
		// Route::post('/inventario.kardex.entrada.create/fetcha', 'KardexEntradaController@fetcha')->name('autocomplete.fetcha');
		// Route::post('/api','api.php');

		Route::resource('/eventos', 'EventosController');
		// Route::post('/eventos/update', 'EventosController@update')->name('eventos.update');
		Route::get('/mis_eventos', 'EventosController@evento_user')->name('eventos.user_indes');

		Route::resource('/categorias_eventos', 'CategoriasEventosController')->except('update');

		Route::post('/categories/update', 'CategoriasEventosController@update')->name('category.update');
		Route::post('/eventos/call', 'EventosController@eventos_show')->name('eventos.call');
		Route::post('/eventos/user_call', 'EventosController@eventos_show_user')->name('eventos.call_user');


        Route::post('/categories/select_color', 'ParameterCallController@color_set')->name('category.color');
		Route::post('/buscar_categoria', 'ParameterCallController@search_category')->name('category.search');
		Route::post('/buscar_users', 'ParameterCallController@search_users')->name('pa.user_search');
		Route::post('/buscar_tipo_op', 'ParameterCallController@search_tipo_operacion')->name('pa.tipo_op_search');



        Route::get('/estadisticas', 'EstadisticasController@index')->name('estadisticas.index');
        Route::get('/estadisticas/servicios', 'EstadisticasController@servicios')->name('estadisticas.servicios');
        Route::get('/estadisticas/clientes', 'EstadisticasController@clientes')->name('estadisticas.clientes');
        Route::get('/estadisticas/empleados', 'EstadisticasController@empleados')->name('estadisticas.empleados');

		// NUEVAS RUTAS EN VENTAS (cotizacion, cotizacion_manua, nota_venta)
		Route::get('/ventas/cotizacion', 'CotizacionController@index3')->name('cotizacion.index3');
		Route::get('/ventas/cotizacion_manual', 'CotizacionManualController@index2')->name('cotizacion_manual.index2');
		Route::get('/ventas/nota_venta', 'NotaVentaController@index2')->name('nota_venta.index2');

		Route::get('/creditos', 'CreditosAdelantosController@creditos')->name('cobranzas.creditos');
		Route::get('/creditos_show/{id}','CreditosAdelantosController@creditos_show')->name('cobranzas.creditos_show');
		Route::get('/creditos_show_FoB/{id}','CreditosAdelantosController@creditos_show_FoB')->name('cobranzas.creditos_show_FoB');


	});


Auth::routes([
		'register' => false, // Registration
		'reset' => false, // Password Reset
		'verify' => false, // Email Verification
	]);

Route::post('sunat_cambio','TipoCambioController@sunat_cambio');
Route::resource('/tipo_cambio','TipoCambioController')->middleware('auth');

Route::get('garantia_guia_ingreso/pdf/{id}' , 'GarantiaGuiaIngresoController@pdf')->name('pdf_ingreso');


Route::get('garantia_guia_egreso/pdf/{id}' , 'GarantiaGuiaEgresoController@pdf')->name('pdf_egreso');
Route::get('garantia_informe_tecnico/pdf/{id}' , 'GarantiaInformeTecnicoController@pdf')->name('pdf_informe');
Route::get('cotizacion/pdf/{id}' , 'CotizacionController@pdf')->name('pdf_cotizacion');
Route::get('cotizacion_servicio/pdf/{id}' , 'CotizacionServiciosController@pdf')->name('pdf_cotizacion_servicio');
Route::get('guia_remision/pdf/{id}' , 'GuiaRemisionController@pdf')->name('pdf_guia');
Route::get('facturacion/pdf/{id}' , 'FacturacionController@pdf')->name('pdf_fac');
Route::get('facturacion_manual/pdf/{id}' , 'FacturacionMController@pdf')->name('pdf_fac_m');
Route::get('boleta/pdf/{id}' , 'BoletaController@pdf')->name('pdf_bol');
Route::get('/boleta_manual/pdf/{id}','BoletaMController@pdf')->name('boleta_manual.pdf');
Route::post('periodo_consulta/pdf' , 'PeriodoConsultaController@pdf')->name('periodo_consulta_pdf');
Route::post('movimiento-consulta/pdf' , 'Consulta_MovimientoController@pdf')->name('movimiento_consulta_pdf');
Route::get('/nota_venta/pdf/{id}' , 'NotaVentaController@pdf')->name('nota_venta_pdf');
Route::get('/cotizacion_manual/pdf/{id}','CotizacionManualController@pdf')->name('cotizacion_manual_pdf');
Route::get('/nota-credito/pdf/{id}','NotaCreditoController@pdf')->name('nota_credito.pdf');
Route::get('/guia_remision_manual/pdf/{id}','GuiaRemisionManualController@pdf')->name('remision_m.pdf');

Route::post('periodo_consulta/print' , 'PeriodoConsultaController@print')->name('periodo_consulta_print');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('api/v1/product/{id}', [ProductosController::class, 'onlyProduct']);
Route::get('api/v1/allproduct', [ProductosController::class, 'allProduct']);



// ServicioController:
    Route::get('/servicio', 'ServicioController@index')->name('servicio.index');
    Route::get('/servicio/guia_salida', 'ServicioController@guia_salida')->name('servicio.guia_salida');
    Route::get('/servicio/informe_tecnico', 'ServicioController@informe_tecnico')->name('servicio.informe_tecnico');
    Route::get('/servicio/solicitud_servicio', 'ServicioController@solicitud_servicio')->name('servicio.solicitud_servicio');

    Route::get('/servicio', 'ServicioController@index')->name('servicio.index');
    Route::get('/servicio/guia_salida', 'ServicioController@guia_salida')->name('servicio.guia_salida');
    Route::get('/servicio/informe_tecnico', 'ServicioController@informe_tecnico')->name('servicio.informe_tecnico');
    Route::get('/servicio/solicitud_servicio', 'ServicioController@solicitud_servicio')->name('servicio.solicitud_servicio');


    Route::get('/servicio/vistaclientes', 'ServicioController@vistaclientes')->name('servicio.vistaclientes');
    Route::get('/guia', function () {
        return view('servicio.guia');
    })->name('guia');


    Route::get('/servicio/clientes', 'ServicioController@clientes')->name('servicio.clientes');
    Route::get('/servicio/guia', 'ServicioController@guia')->name('servicio.guia');



    Route::get('/clientes', [ClienteController::class, 'index']);
    Route::get('/clientes/editar/{id}', [ClienteController::class, 'editex']);
    // Route::get('/guia', [ClienteController::class, 'guia'])->name('clientes.guia');


    Route::get('/clientes', [ServicioController::class, 'index']);





    // GUIAS SERVICIO
    // Route::get('/servicio-guia', [ServicioController::class, 'index'])->name('servicio-guia.index');

    Route::get('/servicio-guias-clientes', [GuiaServicioClienteController::class, 'index'])->name('sGuias.index');
    Route::post('/servicio-guia/store', [GuiaServicioClienteController::class, 'store'])->name('sGuias.store');
<<<<<<< HEAD

    // Mostrar la guía con productos
    Route::get('/servicio-guia/cliente/{guia_id}', [GuiaServicioController::class, 'index'])->name('sGuia.show');

    // Guardar los productos de la guía
    Route::post('/servicio-guia/cliente/{guia_id}/productos', [GuiaServicioController::class, 'BloAct'])->name('servicio.guia.productos.store');
=======

    Route::get('/servicio-guia/cliente/{guia_id}', [GuiaServicioController::class, 'index'])->name('sGuia.show');
    Route::get('/orden-servicio/guias', [OrdenServicioController::class, 'index'])->name('oServicio.index');
>>>>>>> d45d2e49b4c6c21cf147b4bac7ba81dd9c77b7bb




    Route::get('/servicio-guias/cliente/{guia_id}/guia', [ServicioController::class, 'mostrarGuia'])->name('sGuiaCliente');

    Route::get('/servicio/guia_de_salida', 'GuiaSalidaController@index')->name('servicio.guiasalida');
    Route::get('/servicio/guia', 'ServicioController@guia')->name('servicio.guia');

    // GuiaSalidaController es solo para prueba
    Route::get('/servicio/guiasalidaprueba', 'GuiaSalidaController@index')->name('servicio.guiasalida');
    Route::get('/servicio/guia_de_salida', 'GuiaSalidaController@guia_de_salida')->name('servicio.guiasalida');
    Route::post('/actualizar-guia-salida', [GuiaServicioController::class, 'actualizarGuiaSalida']);








