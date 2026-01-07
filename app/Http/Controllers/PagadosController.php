<?php

namespace App\Http\Controllers;

use App\Banco;
use App\BancoRegistro;
use App\Boleta;
use App\Boleta_m;
use App\Cliente;
use App\ComprobantesPagos;
use App\ComprobantesPagosDetalle;
use App\ComprobantesPagosRegistros;
use App\CreditosAdelantos;
use App\CreditosAdelantosRegistros;
use App\Cuotas_credito;
use App\Empresa;
use App\Facturacion;
use App\Facturacion_m;
use App\Igv;
use App\Moneda;
use App\Nota_Credito;
use App\Nota_Debito;
use App\NotaVenta;
use App\NotaVentaRegistro;
use App\TipoCambio;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\Mime\Part\Multipart\DigestPart;

class PagadosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //*! */ Solo pago general, no adelantos
    public function store(Request $request)
    {
        // return $request;
        // Se escoge el tipo de pago
        $tipo_pago = $request->get('input_pago');
        switch ($tipo_pago) {
            case '1':
                $metodo_pago_tipo = 'cheque';
                $fecha_registro = $request->get('cheque_fecha_cobro');
                break;
            case '2':
                $metodo_pago_tipo = 'tarjeta';
                $fecha_registro = $request->get('tarjeta_fecha');
                break;
            case '3':
                $metodo_pago_tipo = 'efectivo';
                $fecha_registro = $request->get('fecha_efectivo');
                break;
            case '4':
                $metodo_pago_tipo = 'transferencia';
                $fecha_registro = $request->get('transferencia_fecha');
                break;
        }
        $comprobantes = $request->get('tipo_comprobante');
        if ($comprobantes == "factura") {
            $lista_facturas = $request->get('id_factura');
        } else {
            $lista_facturas = $request->get('id_factura_m');
        }
        if (!is_array($lista_facturas)) {
            $lista_facturas = array($lista_facturas);
        }
        // return $request;
        // Objeto de Facturas o Factura manuales
        foreach ($lista_facturas as $index_f => $factura) {
            
            // return $factura;
            // Busqueda x tipo de factura
            if ($comprobantes == "factura") {
                $factura_db = Facturacion::find($factura);
                $documento = "factura";
            } else {
                $factura_db = Facturacion_m::find($factura);
                $documento = "factura_manual";
            }
            
            if( !$factura_db || $factura_db->estado_pago == 2){ //*Si ya está pagada x a o b
                continue;
            }
            // return $factura;
            // Registro de Cabecera
            $comprobante_header = new ComprobantesPagos();
            $comprobante_header->tipo_doc = $documento;
            if ($comprobantes == "factura") {
                $comprobante_header->factuacion_id = $factura_db->id;
            } else {
                $comprobante_header->factuacion_m_id = $factura_db->id;
            }
            $comprobante_header->tipo_pago = $metodo_pago_tipo;
            $comprobante_header->fecha_registro = $fecha_registro;
            $comprobante_header->monto_tot = $request->get('tot_cuotas')[$index_f]; //precio total x factura para pago de cuota completo
            $comprobante_header->monto_pago = $request->get('tot_cuotas')[$index_f]; //precio total x factura para pago de cuota completo
            $comprobante_header->save();

            // Bucle x Cuota
            $cuotas_factura = $request->get('cuotas_precio_' . $factura_db->codigo_fac);

            foreach ($cuotas_factura as $index_c => $cuota) {
                $id_x_monto = explode('_', $cuota);
                $id_cuota = $id_x_monto[0];
                $monto = $id_x_monto[1];
                $cuota_id = null;
                //? Solo credito o tambien contado, eso no se pensó bien
                if ($factura_db->forma_pago_id == 2) { //Si es crédito
                    // Se cambia el estado de la cuota a "Pagado" total en tabla cuotas, en el observer
                    $cuota_credito = Cuotas_credito::find($id_cuota);
                    $cuota_credito->estado = 2;
                    $cuota_credito->save();

                    $cuota_id = $id_cuota;
                }
                // else{ //Si es contado
                // }
                // Crear Registros x cuota pagada
                $registros_comp = new ComprobantesPagosRegistros();
                $registros_comp->comprobante_pago_id = $comprobante_header->id;
                $registros_comp->id_cuota_credito = $cuota_id; //Cuota para credito
                $registros_comp->monto_total = $cuota_credito->monto ?? $monto; //monto total de la cuota
                $registros_comp->monto_pago = $monto; //monto del pago 
                $registros_comp->fecha_pago = $fecha_registro;
                $registros_comp->save();

                switch ($tipo_pago) {
                    case '1': //! pago con cheque
                        $pago_cheque = new ComprobantesPagosDetalle();
                        $pago_cheque->tipo_pago = $metodo_pago_tipo;
                        $pago_cheque->comprobante_pago_id = $comprobante_header->id;
                        $pago_cheque->comprobante_pago_reg_id = $registros_comp->id;
                        // Si es diferido o no
                        if ($request->get('cheque_diferido') == 'on') {
                            $pago_cheque->option_input = 1;
                        } else {
                            $pago_cheque->option_input = 0;
                        }
                        $pago_cheque->numero_input = $request->get('cheque_name');
                        $pago_cheque->fechas_input = $request->get('cheque_fecha_cobro');
                        $pago_cheque->bancos_input = $request->get('cheque_banco_emisor');
                        $pago_cheque->persona_input = $request->get('cheque_beneficiario');
                        $pago_cheque->montos_input = $request->get('cheque_monto');
                        $pago_cheque->adicional_input = $request->get('cheque_n_cuenta');
                        $pago_cheque->tipo_cambio = $request->get('tipo_cambio_cheque');
                        $pago_cheque->moneda_id = $request->get('moneda_pago_cheque');
                        $pago_cheque->fecha_emision_input = $request->get('cheque_fecha_emision');
                        if ($request->hasFile('cheque_file')) { // Si existe archivo
                            $file = $request->file('cheque_file');
                            $name_file = time() . $file->getClientOriginalName();
                            \Storage::disk('pagos')->put($name_file,  \File::get($file));
                        }
                        $pago_cheque->file_input = $name_file ?? null;
                        $pago_cheque->notas_adicionales = $request->get('cheque_notas_adicionales');
                        $pago_cheque->save();
                        break;
                    case '2': //! Pago con Tarjeta
                        $pago_tarjeta = new ComprobantesPagosDetalle();
                        $pago_tarjeta->comprobante_pago_id = $comprobante_header->id;
                        $pago_tarjeta->comprobante_pago_reg_id = $registros_comp->id;
                        $pago_tarjeta->tipo_pago = "tarjeta";
                        $pago_tarjeta->persona_input = $request->get('tarjeta_titular');
                        $pago_tarjeta->bancos_input = $request->get('tarjeta_banco');
                        $pago_tarjeta->fechas_input = $request->get('tarjeta_fecha');
                        $pago_tarjeta->tipo_cambio = $request->get('tipo_cambio_tarjeta');
                        $pago_tarjeta->moneda_id = $request->get('moneda_pago_tarjeta');
                        $pago_tarjeta->montos_input = $request->get('tarjeta_monto');
                        if ($request->hasFile('tarjeta_file')) {
                            $file = $request->file('tarjeta_file');
                            $name_file = time() . $file->getClientOriginalName();
                            \Storage::disk('pagos')->put($name_file,  \File::get($file));
                        }
                        $pago_tarjeta->file_input = $name_file ?? null;
                        $pago_tarjeta->notas_adicionales = $request->get('tarjeta_notas_adicionales');
                        $pago_tarjeta->save();
                        break;
                    case '3': //!Pago Efectivo
                        $pago_efectivo = new ComprobantesPagosDetalle();
                        $pago_efectivo->comprobante_pago_id = $comprobante_header->id;
                        $pago_efectivo->comprobante_pago_reg_id = $registros_comp->id;
                        $pago_efectivo->tipo_pago = "efectivo";
                        $pago_efectivo->persona_input = $request->get('efectivo_persona');
                        $pago_efectivo->fechas_input = $request->get('fecha_efectivo');
                        $pago_efectivo->montos_input = $request->get('monto_pago_efectivo');
                        $pago_efectivo->adicional_input = $request->get('monto_vuelto');
                        $pago_efectivo->tipo_cambio = $request->get('tipo_cambio_efectivo');
                        $pago_efectivo->moneda_id = $request->get('moneda_pago_efectivo');
                        $pago_efectivo->notas_adicionales = $request->get('efectivo_notas_adicionales');
                        $pago_efectivo->save();
                        break;
                    case '4': //! Pago Transferencia
                        $pago_tranf = new ComprobantesPagosDetalle();
                        $pago_tranf->comprobante_pago_id = $comprobante_header->id;
                        $pago_tranf->comprobante_pago_reg_id = $registros_comp->id;
                        $pago_tranf->tipo_pago = "transferencia";
                        $pago_tranf->persona_input = $request->get('transferencia_titular');
                        $pago_tranf->fechas_input = $request->get('transferencia_fecha');
                        $pago_tranf->numero_input = $request->get('transferencia_operacion_pag');
                        $pago_tranf->montos_input = $request->get('monto_pago_transferencia');
                        $pago_tranf->adicional_input = $request->get('transferencia_n_cuenta');
                        $pago_tranf->tipo_cambio = $request->get('tipo_cambio_transferencia');
                        $pago_tranf->moneda_id = $request->get('moneda_pago_transferencia');
                        if ($request->hasFile('transferencia_comprobante')) {
                            $file = $request->file('transferencia_comprobante');
                            $name_file = time() . " - " . $file->getClientOriginalName();
                            \Storage::disk('pagos')->put($name_file,  \File::get($file));
                        }
                        $pago_tranf->file_input = $name_file ?? null;
                        $pago_tranf->notas_adicionales = $request->get('transferencia_notas_adicionales');
                        $pago_tranf->save();

                        break;
                }
                // Cambio para las cuotas en contado
                if ($factura_db->forma_pago_id == 1) {
                    $factura_db->estado_pago = 2;
                    $factura_db->save();
                }
            }
        }
        return redirect()->back()->with('success', "El pago se adjuntó correctamente");
    }
    //*! */ Solo pago general, no adelantos

    public function store_boleta(Request $request)
    {
        return $request;
        // Se escoge el tipo de pago
        $tipo_pago = $request->get('input_pago');
        switch ($tipo_pago) {
            case '1':
                $metodo_pago_tipo = 'cheque';
                $fecha_registro = $request->get('cheque_fecha_cobro');
                break;
            case '2':
                $metodo_pago_tipo = 'tarjeta';
                $fecha_registro = $request->get('tarjeta_fecha');
                break;
            case '3':
                $metodo_pago_tipo = 'efectivo';
                $fecha_registro = $request->get('fecha_efectivo');
                break;
            case '4':
                $metodo_pago_tipo = 'transferencia';
                $fecha_registro = $request->get('transferencia_fecha');
                break;
        }
        $comprobantes = $request->get('tipo_comprobante');
        if ($comprobantes == "boleta") {
            $lista_boletas = $request->get('id_boleta');
        } else {
            $lista_boletas = $request->get('id_boleta_m');
        }
        if (!is_array($lista_boletas)) {
            $lista_boletas = array($lista_boletas);
        }
        // return $request;
        // Objeto de Boletas o Boletas manuales
        foreach ($lista_boletas as $index_f => $boleta) {
            // return $boleta;
            // Busqueda x tipo de boleta
            if ($comprobantes == "boleta") {
                $boleta_db = Boleta::find($boleta);
                $documento = "boleta";
            } else {
                $boleta_db = Boleta_m::find($boleta);
                $documento = "boleta_manual";
            }

            if( !$boleta_db || $boleta_db->estado_pago == 2){ //*Si ya está pagada x a o b
                continue;
            }

            // return $boleta;
            // Registro de Cabecera
            $comprobante_header = new ComprobantesPagos();
            $comprobante_header->tipo_doc = $documento;
            if ($comprobantes == "boleta") {
                $comprobante_header->boleta_id = $boleta_db->id;
            } else {
                $comprobante_header->boleta_m_id = $boleta_db->id;
            }
            $comprobante_header->tipo_pago = $metodo_pago_tipo;
            $comprobante_header->fecha_registro = $fecha_registro;
            $comprobante_header->monto_tot = $request->get('tot_cuotas')[$index_f]; //precio total x boleta para pago de cuota completo
            $comprobante_header->monto_pago = $request->get('tot_cuotas')[$index_f]; //precio total x boleta para pago de cuota completo
            $comprobante_header->save();

            // Bucle x Cuota
            $cuotas_boleta = $request->get('cuotas_precio_' . $boleta_db->codigo_boleta);

            foreach ($cuotas_boleta as $index_c => $cuota) {
                $id_x_monto = explode('_', $cuota);
                $id_cuota = $id_x_monto[0];
                $monto = $id_x_monto[1];
                $cuota_id = null;
                //? Solo credito o tambien contado, eso no se pensó bien
                if ($boleta_db->forma_pago_id == 2) { //Si es crédito
                    // Se cambia el estado de la cuota a "Pagado" total en tabla cuotas, en el observer
                    $cuota_credito = Cuotas_credito::find($id_cuota);
                    $cuota_credito->estado = 2;
                    $cuota_credito->save();

                    $cuota_id = $id_cuota;
                }
                // else{ //Si es contado
                // }
                // Crear Registros x cuota pagada
                $registros_comp = new ComprobantesPagosRegistros();
                $registros_comp->comprobante_pago_id = $comprobante_header->id;
                $registros_comp->id_cuota_credito = $cuota_id; //Cuota para credito
                $registros_comp->monto_total = $cuota_credito->monto ?? $monto; //monto total de la cuota
                $registros_comp->monto_pago = $monto; //monto del pago 
                $registros_comp->fecha_pago = $fecha_registro;
                $registros_comp->save();

                switch ($tipo_pago) {
                    case '1': //! pago con cheque
                        $pago_cheque = new ComprobantesPagosDetalle();
                        $pago_cheque->tipo_pago = $metodo_pago_tipo;
                        $pago_cheque->comprobante_pago_id = $comprobante_header->id;
                        $pago_cheque->comprobante_pago_reg_id = $registros_comp->id;
                        // Si es diferido o no
                        if ($request->get('cheque_diferido') == 'on') {
                            $pago_cheque->option_input = 1;
                        } else {
                            $pago_cheque->option_input = 0;
                        }
                        $pago_cheque->numero_input = $request->get('cheque_name');
                        $pago_cheque->fechas_input = $request->get('cheque_fecha_cobro');
                        $pago_cheque->bancos_input = $request->get('cheque_banco_emisor');
                        $pago_cheque->persona_input = $request->get('cheque_beneficiario');
                        $pago_cheque->montos_input = $request->get('cheque_monto');
                        $pago_cheque->adicional_input = $request->get('cheque_n_cuenta');
                        $pago_cheque->tipo_cambio = $request->get('tipo_cambio_cheque');
                        $pago_cheque->moneda_id = $request->get('moneda_pago_cheque');
                        $pago_cheque->fecha_emision_input = $request->get('cheque_fecha_emision');
                        if ($request->hasFile('cheque_file')) { // Si existe archivo
                            $file = $request->file('cheque_file');
                            $name_file = time() . $file->getClientOriginalName();
                            \Storage::disk('pagos')->put($name_file,  \File::get($file));
                        }
                        $pago_cheque->file_input = $name_file ?? null;
                        $pago_cheque->notas_adicionales = $request->get('cheque_notas_adicionales');
                        $pago_cheque->save();
                        break;
                    case '2': //! Pago con Tarjeta
                        $pago_tarjeta = new ComprobantesPagosDetalle();
                        $pago_tarjeta->comprobante_pago_id = $comprobante_header->id;
                        $pago_tarjeta->comprobante_pago_reg_id = $registros_comp->id;
                        $pago_tarjeta->tipo_pago = "tarjeta";
                        $pago_tarjeta->persona_input = $request->get('tarjeta_titular');
                        $pago_tarjeta->bancos_input = $request->get('tarjeta_banco');
                        $pago_tarjeta->fechas_input = $request->get('tarjeta_fecha');
                        $pago_tarjeta->tipo_cambio = $request->get('tipo_cambio_tarjeta');
                        $pago_tarjeta->moneda_id = $request->get('moneda_pago_tarjeta');
                        $pago_tarjeta->montos_input = $request->get('tarjeta_monto');
                        if ($request->hasFile('tarjeta_file')) {
                            $file = $request->file('tarjeta_file');
                            $name_file = time() . $file->getClientOriginalName();
                            \Storage::disk('pagos')->put($name_file,  \File::get($file));
                        }
                        $pago_tarjeta->file_input = $name_file ?? null;
                        $pago_tarjeta->notas_adicionales = $request->get('tarjeta_notas_adicionales');
                        $pago_tarjeta->save();
                        break;
                    case '3': //!Pago Efectivo
                        $pago_efectivo = new ComprobantesPagosDetalle();
                        $pago_efectivo->comprobante_pago_id = $comprobante_header->id;
                        $pago_efectivo->comprobante_pago_reg_id = $registros_comp->id;
                        $pago_efectivo->tipo_pago = "efectivo";
                        $pago_efectivo->persona_input = $request->get('efectivo_persona');
                        $pago_efectivo->fechas_input = $request->get('fecha_efectivo');
                        $pago_efectivo->montos_input = $request->get('monto_pago_efectivo');
                        $pago_efectivo->adicional_input = $request->get('monto_vuelto');
                        $pago_efectivo->tipo_cambio = $request->get('tipo_cambio_efectivo');
                        $pago_efectivo->moneda_id = $request->get('moneda_pago_efectivo');
                        $pago_efectivo->notas_adicionales = $request->get('efectivo_notas_adicionales');
                        $pago_efectivo->save();
                        break;
                    case '4': //! Pago Transferencia
                        $pago_tranf = new ComprobantesPagosDetalle();
                        $pago_tranf->comprobante_pago_id = $comprobante_header->id;
                        $pago_tranf->comprobante_pago_reg_id = $registros_comp->id;
                        $pago_tranf->tipo_pago = "transferencia";
                        $pago_tranf->persona_input = $request->get('transferencia_titular');
                        $pago_tranf->fechas_input = $request->get('transferencia_fecha');
                        $pago_tranf->numero_input = $request->get('transferencia_operacion_pag');
                        $pago_tranf->montos_input = $request->get('monto_pago_transferencia');
                        $pago_tranf->adicional_input = $request->get('transferencia_n_cuenta');
                        $pago_tranf->tipo_cambio = $request->get('tipo_cambio_transferencia');
                        $pago_tranf->moneda_id = $request->get('moneda_pago_transferencia');
                        if ($request->hasFile('transferencia_comprobante')) {
                            $file = $request->file('transferencia_comprobante');
                            $name_file = time() . " - " . $file->getClientOriginalName();
                            \Storage::disk('pagos')->put($name_file,  \File::get($file));
                        }
                        $pago_tranf->file_input = $name_file ?? null;
                        $pago_tranf->notas_adicionales = $request->get('transferencia_notas_adicionales');
                        $pago_tranf->save();

                        break;
                }
                // Cambio para las cuotas en contado
                if ($boleta_db->forma_pago_id == 1) {
                    $boleta_db->estado_pago = 2;
                    $boleta_db->save();
                }
            }
        }
        return redirect()->back()->with('success', "El pago se adjuntó correctamente");
    }
    public function store_n_venta(Request $request)
    {
        // return $request; 
        // Se escoge el tipo de pago
        $tipo_pago = $request->get('input_pago');
        switch ($tipo_pago) {
            case '1':
                $metodo_pago_tipo = 'cheque';
                $fecha_registro = $request->get('cheque_fecha_cobro');
                break;
            case '2':
                $metodo_pago_tipo = 'tarjeta';
                $fecha_registro = $request->get('tarjeta_fecha');
                break;
            case '3':
                $metodo_pago_tipo = 'efectivo';
                $fecha_registro = $request->get('fecha_efectivo');
                break;
            case '4':
                $metodo_pago_tipo = 'transferencia';
                $fecha_registro = $request->get('transferencia_fecha');
                break;
        }
        // $comprobantes = $request->get('tipo_comprobante');
        $lista_nventa = $request->get('id_nventa');
        if (!is_array($lista_nventa)) {
            $lista_nventa = array($lista_nventa);
        }
        // return $request;
        // Objeto de Facturas o Factura manuales
        foreach ($lista_nventa as $index_f => $nventa) {
            // return $nventa;
            // Busqueda x tipo de factura
            $notaventa_db = NotaVenta::find($nventa);
            if( !$notaventa_db || $notaventa_db->estado_pago == 2){ //*Si ya está pagada x a o b
                continue;
            }

            $documento = "nota_venta";
            // return $nventa;
            // Registro de Cabecera
            $comprobante_header = new ComprobantesPagos();
            $comprobante_header->tipo_doc = $documento;
            $comprobante_header->nota_venta_id = $notaventa_db->id;
            $comprobante_header->tipo_pago = $metodo_pago_tipo;
            $comprobante_header->fecha_registro = $fecha_registro;
            $comprobante_header->monto_tot = $request->get('tot_cuotas')[$index_f]; //precio total x factura para pago de cuota completo
            $comprobante_header->monto_pago = $request->get('tot_cuotas')[$index_f]; //precio total x factura para pago de cuota completo
            $comprobante_header->save();

            // Bucle x Cuota
            $codigo = $notaventa_db->cod_nota_venta;
            $new_cod = strtr($codigo,' ', "_");
            $cuotas_n_venta = $request->get('cuotas_precio_' . $new_cod);
            // return $cuotas_n_venta;
            foreach ($cuotas_n_venta as $index_c => $cuota) {
                $id_x_monto = explode('_', $cuota);
                $id_cuota = $id_x_monto[0];
                $monto = $id_x_monto[1];
                $cuota_id = null;
                //? Nota de Venta no tiene Creditos en cuotas creditos
                // if ($notaventa_db->forma_pago_id == 2) { //Si es crédito
                //     // Se cambia el estado de la cuota a "Pagado" total en tabla cuotas, en el observer
                //     $cuota_credito = Cuotas_credito::find($id_cuota);
                //     $cuota_credito->estado = 2;
                //     $cuota_credito->save();

                //     $cuota_id = $id_cuota;
                // }
                // else{ //Si es contado
                // }
                // Crear Registros x cuota pagada
                $registros_comp = new ComprobantesPagosRegistros();
                $registros_comp->comprobante_pago_id = $comprobante_header->id;
                $registros_comp->id_cuota_credito = $cuota_id; //Cuota para credito
                $registros_comp->monto_total = $cuota_credito->monto ?? $monto; //monto total de la cuota
                $registros_comp->monto_pago = $monto; //monto del pago 
                $registros_comp->fecha_pago = $fecha_registro;
                $registros_comp->save();

                switch ($tipo_pago) {
                    case '1': //! pago con cheque
                        $pago_cheque = new ComprobantesPagosDetalle();
                        $pago_cheque->tipo_pago = $metodo_pago_tipo;
                        $pago_cheque->comprobante_pago_id = $comprobante_header->id;
                        $pago_cheque->comprobante_pago_reg_id = $registros_comp->id;
                        // Si es diferido o no
                        if ($request->get('cheque_diferido') == 'on') {
                            $pago_cheque->option_input = 1;
                        } else {
                            $pago_cheque->option_input = 0;
                        }
                        $pago_cheque->numero_input = $request->get('cheque_name');
                        $pago_cheque->fechas_input = $request->get('cheque_fecha_cobro');
                        $pago_cheque->bancos_input = $request->get('cheque_banco_emisor');
                        $pago_cheque->persona_input = $request->get('cheque_beneficiario');
                        $pago_cheque->montos_input = $request->get('cheque_monto');
                        $pago_cheque->adicional_input = $request->get('cheque_n_cuenta');
                        $pago_cheque->tipo_cambio = $request->get('tipo_cambio_cheque');
                        $pago_cheque->moneda_id = $request->get('moneda_pago_cheque');
                        $pago_cheque->fecha_emision_input = $request->get('cheque_fecha_emision');
                        if ($request->hasFile('cheque_file')) { // Si existe archivo
                            $file = $request->file('cheque_file');
                            $name_file = time() . $file->getClientOriginalName();
                            \Storage::disk('pagos')->put($name_file,  \File::get($file));
                        }
                        $pago_cheque->file_input = $name_file ?? null;
                        $pago_cheque->notas_adicionales = $request->get('cheque_notas_adicionales');
                        $pago_cheque->save();
                        break;
                    case '2': //! Pago con Tarjeta
                        $pago_tarjeta = new ComprobantesPagosDetalle();
                        $pago_tarjeta->comprobante_pago_id = $comprobante_header->id;
                        $pago_tarjeta->comprobante_pago_reg_id = $registros_comp->id;
                        $pago_tarjeta->tipo_pago = "tarjeta";
                        $pago_tarjeta->persona_input = $request->get('tarjeta_titular');
                        $pago_tarjeta->bancos_input = $request->get('tarjeta_banco');
                        $pago_tarjeta->fechas_input = $request->get('tarjeta_fecha');
                        $pago_tarjeta->tipo_cambio = $request->get('tipo_cambio_tarjeta');
                        $pago_tarjeta->moneda_id = $request->get('moneda_pago_tarjeta');
                        $pago_tarjeta->montos_input = $request->get('tarjeta_monto');
                        if ($request->hasFile('tarjeta_file')) {
                            $file = $request->file('tarjeta_file');
                            $name_file = time() . $file->getClientOriginalName();
                            \Storage::disk('pagos')->put($name_file,  \File::get($file));
                        }
                        $pago_tarjeta->file_input = $name_file ?? null;
                        $pago_tarjeta->notas_adicionales = $request->get('tarjeta_notas_adicionales');
                        $pago_tarjeta->save();
                        break;
                    case '3': //!Pago Efectivo
                        $pago_efectivo = new ComprobantesPagosDetalle();
                        $pago_efectivo->comprobante_pago_id = $comprobante_header->id;
                        $pago_efectivo->comprobante_pago_reg_id = $registros_comp->id;
                        $pago_efectivo->tipo_pago = "efectivo";
                        $pago_efectivo->persona_input = $request->get('efectivo_persona');
                        $pago_efectivo->fechas_input = $request->get('fecha_efectivo');
                        $pago_efectivo->montos_input = $request->get('monto_pago_efectivo');
                        $pago_efectivo->adicional_input = $request->get('monto_vuelto');
                        $pago_efectivo->tipo_cambio = $request->get('tipo_cambio_efectivo');
                        $pago_efectivo->moneda_id = $request->get('moneda_pago_efectivo');
                        $pago_efectivo->notas_adicionales = $request->get('efectivo_notas_adicionales');
                        $pago_efectivo->save();
                        break;
                    case '4': //! Pago Transferencia
                        $pago_tranf = new ComprobantesPagosDetalle();
                        $pago_tranf->comprobante_pago_id = $comprobante_header->id;
                        $pago_tranf->comprobante_pago_reg_id = $registros_comp->id;
                        $pago_tranf->tipo_pago = "transferencia";
                        $pago_tranf->persona_input = $request->get('transferencia_titular');
                        $pago_tranf->fechas_input = $request->get('transferencia_fecha');
                        $pago_tranf->numero_input = $request->get('transferencia_operacion_pag');
                        $pago_tranf->montos_input = $request->get('monto_pago_transferencia');
                        $pago_tranf->adicional_input = $request->get('transferencia_n_cuenta');
                        $pago_tranf->tipo_cambio = $request->get('tipo_cambio_transferencia');
                        $pago_tranf->moneda_id = $request->get('moneda_pago_transferencia');
                        if ($request->hasFile('transferencia_comprobante')) {
                            $file = $request->file('transferencia_comprobante');
                            $name_file = time() . " - " . $file->getClientOriginalName();
                            \Storage::disk('pagos')->put($name_file,  \File::get($file));
                        }
                        $pago_tranf->file_input = $name_file ?? null;
                        $pago_tranf->notas_adicionales = $request->get('transferencia_notas_adicionales');
                        $pago_tranf->save();

                        break;
                }
                // Cambio para las cuotas en contado
                // if ($notaventa_db->forma_pago_id == 1) {
                    $notaventa_db->estado_pago = 2;
                    $notaventa_db->save();
                // }
            }
        }
        return redirect()->back()->with('success', "El pago se adjuntó correctamente");
    }

    //* FACTURAS
    public function index_factura()
    {
        // $facturas = Facturacion::where('forma_pago_id', 2)->get();
        // $cuotas = Cuotas_credito::where('facturacion_id', '!=', null)->get();
        // // return $cuotas->where('facturacion_id','323')->count();
        // $fecha_hoy = Carbon::now()->format('Y-m-d');
        // // return $fecha_hoy;
        // $monedas = Moneda::get();
        // $tipo_cambio = TipoCambio::latest('created_at')->first();       // return $fecha_hoy;
        // // return $facturas;
        $bancos_pluck = Banco::where('estado', 0)->pluck('id');
        $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $monedas = Moneda::get();
        $igv = Igv::first();
        $tipo_cambio = TipoCambio::latest('created_at')->first();

        return view('cobranzas.facturas.index', compact('monedas', 'fecha_hoy', 'tipo_cambio', 'igv', 'bancos'));
    }

    public function index_factura_pagados()
    {
        $bancos_pluck = Banco::where('estado', 0)->pluck('id');
        $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
        $tipo_cambio = TipoCambio::latest('created_at')->first();
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $monedas = Moneda::get();
        $igv = Igv::first();

        return view('cobranzas.facturas.index_pagados', compact('monedas', 'fecha_hoy', 'tipo_cambio', 'igv', 'bancos'));
    } 

    // // ! Falta
    // public function index_facturas_clientes()
    // {
    //     $facturas_m = Facturacion_m::orderByDesc('id')->where('f_electronica', 1)->get();
    //     $cuotas_all = Cuotas_credito::where('facturacion_m_id', '!=', null)->get();
    //     $bancos_pluck = Banco::where('estado', 0)->pluck('id');
    //     $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
    //     $cuentas = BancoRegistro::whereIn('banco_id', $bancos_pluck)->where('estado_detraccion', 0)->get();
    //     $fecha_hoy = Carbon::now()->format('Y-m-d');
    //     $monedas = Moneda::get();
    //     $adelantos = CreditosAdelantos::where('factura_m_id', '!=', null)->get();
    //     $igv = Igv::first();
    //     foreach ($facturas_m as $key => $f_sp) {
    //         $cuotas[$key] = Cuotas_credito::where('facturacion_m_id', $f_sp->id)->count();
    //         $client_id[$key] = $f_sp->cliente_id;
    //     }
    //     $tipo_cambio = TipoCambio::latest('created_at')->first();
    //     if (count($facturas_m) != 0) {
    //         $clientes =  Cliente::whereIn('id', $client_id)->get();
    //         foreach ($clientes as $kry => $client) {

    //             // BUSCAR FACTURAS POR CLIENTE
    //             $count_tot = Facturacion_m::where('cliente_id', $client->id)->where('f_electronica', 1)->count();
    //             $client['cantidad_fact'] = $count_tot;
    //             $facturas = Facturacion_m::where('cliente_id', $client->id)->where('forma_pago_id', 2)->where('f_electronica', 1)->get();
    //             if (count($facturas) != 0) {
    //                 foreach ($facturas as $key => $f_sp) {
    //                     $cuota_lopp[] = Cuotas_credito::where('facturacion_m_id', $f_sp->id)->where('estado', 1)->get();
    //                     if (count($cuota_lopp) > 0) {
    //                         $cuot[$key] = $cuota_lopp;
    //                     }
    //                 }
    //                 $client['cuotas'] = $cuot;
    //             } else {
    //                 // return "b";
    //                 $client['cuotas'] = 0;
    //             }
    //         }
    //         foreach ($facturas_m as $key0 => $fa) {
    //             $client_id2[] = $fa->cliente_id;
    //         }
    //         $q_1 = array_values(array_unique($client_id2));
    //         foreach ($clientes as $key => $client_2) {
    //             $facturas_3 = Facturacion_m::where('cliente_id', $client_2->id)->where('estado_pago', 2)->where('f_electronica', 1)->get();
    //             $cli_3 = Cliente::where('id', $client_2->id)->first();
    //             $precio_fact_cli = 0;
    //             $precio_fact_cli_dol = 0;
    //             // unset($val_tot);
    //             foreach ($facturas_3 as $key2 => $fact3) {
    //                 if ($fact3->forma_pago_id == 2) { //credito
    //                     $precio_tot = Cuotas_credito::where('facturacion_m_id', $fact3->id)->where('estado', 1)->pluck('monto')->sum();
    //                     if ($fact3->moneda->nombre == 'soles') {
    //                         $var_tot_sol = $precio_tot;
    //                         $var_tot_dol = $precio_tot / $fact3->cambio;
    //                     } else {
    //                         $var_tot_sol = $precio_tot * $fact3->cambio;
    //                         $var_tot_dol = $precio_tot;
    //                     }
    //                 } else {
    //                     $subtotal = $fact3->op_gravada + $fact3->op_inafecta + $fact3->op_exonerada;
    //                     $tot = round($subtotal + ($fact3->op_gravada * $igv->renta) / 100, 2);
    //                     if ($fact3->moneda->nombre == 'soles') {
    //                         $var_tot_sol = $tot;
    //                         $var_tot_dol = $tot / $fact3->cambio;
    //                     } else {
    //                         $var_tot_dol = $tot;
    //                         $var_tot_sol = $tot * $fact3->cambio;
    //                     }
    //                 }
    //                 $precio_fact_cli += $var_tot_sol;
    //                 $precio_fact_cli_dol += $var_tot_dol;
    //             }
    //             $var_precio_tot[] = array("tot" => number_format(round($precio_fact_cli, 2), 2), "tot_dol" => number_format(round($precio_fact_cli_dol, 2), 2));
    //         }
    //     } else {
    //         $cuotas = 0;
    //         $clientes = [];
    //         $var_precio_tot = [0];
    //     }
    //     // // return $clientes;
    //     // $last_pagos = ComprobantesPagos::where('factuacion_m_id', '!=', null)->get();
    //     return view('cobranzas.facturas_manuales.index_clientes', compact('facturas_m', 'cuotas', 'cuotas_all', 'fecha_hoy', 'monedas', 'tipo_cambio', 'clientes', 'igv', 'var_precio_tot', 'cuentas', 'adelantos', 'bancos'));
    // }

    public function show_facturas($id)
    {
        // *2025 Terminado
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $igv = Igv::first();
        $factura = Facturacion::find($id);
        $moneda_sec = Moneda::where('id', '!=', $factura->moneda_id)->first();
        // Funcionamiento para el modal de pagos
        $monedas = Moneda::get();
        $bancos_pluck = Banco::where('estado', 0)->pluck('id');
        $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
        $tipo_cambio = TipoCambio::latest('created_at')->first();
        // $fecha_hoy = Carbon::now()->format('Y-m-d');
        return view('cobranzas.facturas.show', compact('factura', 'igv', 'fecha_hoy','moneda_sec','monedas','bancos','tipo_cambio'));
    }
    
    public function lista_ajax_fact(Request $request)
    {
        // return $request->ids_facturas;
        $count_ids = count($request->ids_facturas);
        $igv = Igv::first();
        if ($count_ids > 0) {
            for ($i = 0; $i < $count_ids; $i++) {
                $var[] = $request->ids_facturas[$i];
            }
        }
        $facturas = Facturacion::WhereIn('id', $var)->get();
        foreach ($facturas as $key => $factura) {
            $monto_adl = CreditosAdelantos::where('factura_id', $factura->id)->first();
            if ($factura->forma_pago_id == 2) {
                $cuotas = Cuotas_credito::where('facturacion_id', $factura->id)->get(); //* Codicional el estado de los cuales falta pagar
                foreach ($cuotas as $llave => $cuota) {
                    $new_monto = round($cuota->monto, 2);
                    if (isset($monto_adl)) {
                        $new_monto = round($cuota->monto - $monto_adl->precio_adelanto, 2);
                    }

                    $array_cuot[$llave] = array(
                        'id_cuota' => $cuota->id,
                        'cuota_n' => $cuota->numero_cuota,
                        'monto' => $new_monto,
                        'fecha_pago' => $cuota->fecha_pago,
                        'estado' =>  $cuota->estado
                    );
                }
                $pago_tot = round($cuotas->sum('monto'), 2);
            } else {

                $subtotal = $factura->op_gravada + $factura->op_inafecta + $factura->op_exonerada;
                $pago_tot = round($subtotal + ($factura->op_gravada * $igv->renta) / 100, 2);
                if (isset($monto_adl)) {
                    $pago_tot = $pago_tot - $monto_adl->precio_adelanto;
                }

                $array_cuot[0] = array(
                    'id_cuota' => '1',
                    'cuota_n' => '1',
                    'monto' => round($pago_tot, 2),
                    'fecha_pago' => $factura->fecha_vencimiento,
                    'estado' =>  '0'
                );
            }

            $array_end[$key] = array(
                'factura_cod' => $factura->codigo_fac,
                'cliente_doc' => $factura->cliente->numero_documento,
                'cliente_nombre' => $factura->cliente->nombre,
                'factura_moneda' => $factura->moneda->nombre,
                'factura_simbolo' => $factura->moneda->simbolo,
                'total_factura' => round($pago_tot, 2),
                'cuotas_array' => $array_cuot
            );
        }
        return $array_end;
    }
    
    // // ! Falta
    // public function show_cliente_factura($ruc_cli)
    // {
    //     $ruc = $ruc_cli;
    //     $cliente = Cliente::where('numero_documento', $ruc)->first();
    //     $facturas = Facturacion::where('cliente_id', $cliente->id)->get();
    //     $cuotas_all = Cuotas_credito::where('facturacion_id', '!=', null)->get();
    //     $start_mes = Carbon::now()->startOfMonth()->format('m/d/Y');
    //     $end_mes = Carbon::now()->endOfMonth()->format('m/d/Y');;
    //     $igv = Igv::first();

    //     // Pagados en el mes conversion de Monedas
    //     foreach ($facturas as $key => $fact) {
    //         $subtotal = $fact->op_gravada + $fact->op_inafecta + $fact->op_exonerada;
    //         $total = $subtotal + ($fact->op_gravada * ($igv->renta / 100));
    //         if ($fact->moneda->nombre == 'soles') {
    //             $soles[] =  $total;
    //             $dolares[] = $total / $fact->cambio;
    //         } else {
    //             $dolares[] = $total;
    //             $soles[] = $total * $fact->cambio;
    //         }
    //     }
    //     $tot_sol = array_sum($soles);
    //     $tot_dol = array_sum($dolares);
    //     // return $tot_dol;
    //     $moneda_sol = Moneda::where('nombre', 'soles')->first();
    //     $moneda_dol = Moneda::where('nombre', 'Dolares')->first();

    //     $star_month = Carbon::now()->startOfMonth();
    //     $end_month = Carbon::now()->endOfMonth();
    //     $fact_mes = Facturacion::where('cliente_id', $cliente->id)->whereBetween('created_at', [$star_month, $end_month])->get();
    //     $soles_m = [];
    //     $dolares_m = [];
    //     foreach ($fact_mes as $key => $fact_m) {
    //         $subtotal = $fact_m->op_gravada + $fact_m->op_inafecta + $fact_m->op_exonerada;
    //         $total = $subtotal + ($fact_m->op_gravada * ($igv->renta / 100));
    //         if ($fact_m->moneda->nombre == 'soles') {
    //             $soles_m[] =  $total;
    //             $dolares_m[] = $total * $fact_m->cambio;
    //         } else {
    //             $dolares[] = $total;
    //             $soles_m[] = $total / $fact_m->cambio;
    //         }
    //     }
    //     $tot_sol_m = array_sum($soles_m);
    //     $tot_dol_m = array_sum($dolares_m);


    //     // PAGOS EN DEUDA
    //     $fact_sin = Facturacion::where('cliente_id', $cliente->id)->where('estado_pago', '!=', 2)->get();
    //     $soles_s_p = [];
    //     foreach ($fact_sin as $key => $fact_s) {
    //         $subtotal = $fact_s->op_gravada + $fact_s->op_inafecta + $fact_s->op_exonerada;
    //         $total = $subtotal + ($fact_s->op_gravada * ($igv->renta / 100));
    //         if ($fact_s->moneda->nombre == 'soles') {
    //             $soles_s_p[] =  round($total, 2);
    //         } else {
    //             $soles_s_p[] = round($total / $fact_s->cambio, 2);
    //         }
    //     }
    //     $tot_sol_sp = array_sum($soles_s_p);
    //     if (count($facturas) == 0) {
    //         $nota_credito[0] = null;
    //         $nota_debito[0] = null;
    //     } else {
    //         foreach ($facturas as $key => $factura3) {
    //             $nota_credito[$key] = Nota_Credito::where('facturacion_id', $factura3->id)->first();
    //             $nota_debito[$key] = Nota_Debito::where('facturacion_id', $factura3->id)->first();
    //             if (!isset($nota_credito[$key])) {
    //                 $nota_credito[$key] = null;
    //             }
    //             if (!isset($nota_debito[$key])) {
    //                 $nota_debito[$key] = null;
    //             }
    //         }
    //     }
    //     // return $cuotas_all;

    //     return view('cobranzas.facturas.clientes', compact('ruc', 'cliente', 'facturas', 'cuotas_all', 'start_mes', 'end_mes', 'igv', 'tot_dol', 'tot_sol', 'moneda_sol', 'moneda_dol', 'fact_mes', 'tot_sol_m', 'fact_sin', 'tot_sol_sp', 'nota_credito', 'nota_debito'));
    // }

    //* FACTURAS MANUALES
    public function index_facturas_m()
    {
        $bancos_pluck = Banco::where('estado', 0)->pluck('id');
        $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $monedas = Moneda::get();
        $igv = Igv::first();
        $tipo_cambio = TipoCambio::latest('created_at')->first();
        // $comprobar = Facturacion_m::revision_pagados_contado();
        // $comprobar = Facturacion_m::revision_pagados_cuotas();
        return view('cobranzas.facturas_manuales.index', compact('monedas', 'fecha_hoy', 'tipo_cambio', 'igv', 'bancos'));
    }

    public function index_factura_m_pagados()
    {
        $bancos_pluck = Banco::where('estado', 0)->pluck('id');
        $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
        $tipo_cambio = TipoCambio::latest('created_at')->first();
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $monedas = Moneda::get();
        $igv = Igv::first();

        return view('cobranzas.facturas_manuales.index_pagados', compact('monedas', 'fecha_hoy', 'tipo_cambio', 'igv', 'bancos'));
    }
    // // ! Falta
    // public function index_facturas_m_clientes()
    // {
    //     $facturas_m = Facturacion_m::orderByDesc('id')->where('f_electronica', 1)->get();
    //     $cuotas_all = Cuotas_credito::where('facturacion_m_id', '!=', null)->get();
    //     $bancos_pluck = Banco::where('estado', 0)->pluck('id');
    //     $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
    //     $cuentas = BancoRegistro::whereIn('banco_id', $bancos_pluck)->where('estado_detraccion', 0)->get();
    //     $fecha_hoy = Carbon::now()->format('Y-m-d');
    //     $monedas = Moneda::get();
    //     $adelantos = CreditosAdelantos::where('factura_m_id', '!=', null)->get();
    //     $igv = Igv::first();
    //     foreach ($facturas_m as $key => $f_sp) {
    //         $cuotas[$key] = Cuotas_credito::where('facturacion_m_id', $f_sp->id)->count();
    //         $client_id[$key] = $f_sp->cliente_id;
    //     }
    //     $tipo_cambio = TipoCambio::latest('created_at')->first();
    //     if (count($facturas_m) != 0) {
    //         $clientes =  Cliente::whereIn('id', $client_id)->get();
    //         foreach ($clientes as $kry => $client) {

    //             // BUSCAR FACTURAS POR CLIENTE
    //             $count_tot = Facturacion_m::where('cliente_id', $client->id)->where('f_electronica', 1)->count();
    //             $client['cantidad_fact'] = $count_tot;
    //             $facturas = Facturacion_m::where('cliente_id', $client->id)->where('forma_pago_id', 2)->where('f_electronica', 1)->get();
    //             if (count($facturas) != 0) {
    //                 foreach ($facturas as $key => $f_sp) {
    //                     $cuota_lopp[] = Cuotas_credito::where('facturacion_m_id', $f_sp->id)->where('estado', 1)->get();
    //                     if (count($cuota_lopp) > 0) {
    //                         $cuot[$key] = $cuota_lopp;
    //                     }
    //                 }
    //                 $client['cuotas'] = $cuot;
    //             } else {
    //                 // return "b";
    //                 $client['cuotas'] = 0;
    //             }
    //         }
    //         foreach ($facturas_m as $key0 => $fa) {
    //             $client_id2[] = $fa->cliente_id;
    //         }
    //         $q_1 = array_values(array_unique($client_id2));
    //         foreach ($clientes as $key => $client_2) {
    //             $facturas_3 = Facturacion_m::where('cliente_id', $client_2->id)->where('estado_pago', 2)->where('f_electronica', 1)->get();
    //             $cli_3 = Cliente::where('id', $client_2->id)->first();
    //             $precio_fact_cli = 0;
    //             $precio_fact_cli_dol = 0;
    //             // unset($val_tot);
    //             foreach ($facturas_3 as $key2 => $fact3) {
    //                 if ($fact3->forma_pago_id == 2) { //credito
    //                     $precio_tot = Cuotas_credito::where('facturacion_m_id', $fact3->id)->where('estado', 1)->pluck('monto')->sum();
    //                     if ($fact3->moneda->nombre == 'soles') {
    //                         $var_tot_sol = $precio_tot;
    //                         $var_tot_dol = $precio_tot / $fact3->cambio;
    //                     } else {
    //                         $var_tot_sol = $precio_tot * $fact3->cambio;
    //                         $var_tot_dol = $precio_tot;
    //                     }
    //                 } else {
    //                     $subtotal = $fact3->op_gravada + $fact3->op_inafecta + $fact3->op_exonerada;
    //                     $tot = round($subtotal + ($fact3->op_gravada * $igv->renta) / 100, 2);
    //                     if ($fact3->moneda->nombre == 'soles') {
    //                         $var_tot_sol = $tot;
    //                         $var_tot_dol = $tot / $fact3->cambio;
    //                     } else {
    //                         $var_tot_dol = $tot;
    //                         $var_tot_sol = $tot * $fact3->cambio;
    //                     }
    //                 }
    //                 $precio_fact_cli += $var_tot_sol;
    //                 $precio_fact_cli_dol += $var_tot_dol;
    //             }
    //             $var_precio_tot[] = array("tot" => number_format(round($precio_fact_cli, 2), 2), "tot_dol" => number_format(round($precio_fact_cli_dol, 2), 2));
    //         }
    //     } else {
    //         $cuotas = 0;
    //         $clientes = [];
    //         $var_precio_tot = [0];
    //     }
    //     // // return $clientes;
    //     // $last_pagos = ComprobantesPagos::where('factuacion_m_id', '!=', null)->get();
    //     return view('cobranzas.facturas_manuales.index_clientes', compact('facturas_m', 'cuotas', 'cuotas_all', 'fecha_hoy', 'monedas', 'tipo_cambio', 'clientes', 'igv', 'var_precio_tot', 'cuentas', 'adelantos', 'bancos'));
    // }

    public function lista_ajax_fact_m(Request $request)
    {
        // return $request->ids_facturas;
        $count_ids = count($request->ids_facturas);
        $igv = Igv::first();
        if ($count_ids > 0) {
            for ($i = 0; $i < $count_ids; $i++) {
                $var[] = $request->ids_facturas[$i];
            }
        }
        $facturas = Facturacion_m::WhereIn('id', $var)->get();
        foreach ($facturas as $key => $factura) {
            $monto_adl = CreditosAdelantos::where('factura_m_id', $factura->id)->first();
            if ($factura->forma_pago_id == 2) {
                $cuotas = Cuotas_credito::where('facturacion_m_id', $factura->id)->get(); //* Codicional el estado de los cuales falta pagar
                foreach ($cuotas as $llave => $cuota) {
                    // $monto_adl_cuota = CreditosAdelantosRegistros::where('cuota_cred_id', $cuota->id)->sum('montos_input');
                    $new_monto =  round($cuota->monto, 2);
                    if (isset($monto_adl)) {
                        $new_monto =  round($cuota->monto - $monto_adl->precio_adelanto, 2);
                    }

                    $array_cuot[$llave] = array(
                        'id_cuota' => $cuota->id,
                        'cuota_n' => $cuota->numero_cuota,
                        'monto' => $new_monto,  //monto = cuota - adelanto
                        'fecha_pago' => $cuota->fecha_pago,
                        'estado' =>  $cuota->estado
                    );
                }
                $pago_tot = round($cuotas->sum('monto'), 2);
            } else {
                $array_cuot = [];
                // $adle_header = CreditosAdelantos::where('factura_m_id', $factura->id)->first();
                // return $adle_header;
                $subtotal = $factura->op_gravada + $factura->op_inafecta + $factura->op_exonerada;
                $pago_tot = round($subtotal + ($factura->op_gravada * $igv->renta) / 100, 2);
                if (isset($monto_adl)) {
                    $pago_tot = $pago_tot - $monto_adl->precio_adelanto;
                }

                $array_cuot[0] = array(
                    'id_cuota' => '1',
                    'cuota_n' => '1',
                    'monto' => round($pago_tot, 2),
                    'fecha_pago' => $factura->fecha_vencimiento,
                    'estado' =>  '0'
                );
            }

            $array_end[$key] = array(
                'factura_cod' => $factura->codigo_fac,
                'cliente_doc' => $factura->cliente->numero_documento,
                'cliente_nombre' => $factura->cliente->nombre,
                'factura_moneda' => $factura->moneda->nombre,
                'factura_simbolo' => $factura->moneda->simbolo,
                'total_factura' => $pago_tot,
                'cuotas_array' => $array_cuot
            );
        }
        return $array_end;
    }

    public function show_facturas_manual($id)
    {
        // *2025 Terminado
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $igv = Igv::first();
        $factura_m = Facturacion_m::find($id);
        $moneda_sec = Moneda::where('id', '!=', $factura_m->moneda_id)->first();
        // Funcionamiento para el modal de pagos
        $monedas = Moneda::get();
        $bancos_pluck = Banco::where('estado', 0)->pluck('id');
        $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
        $tipo_cambio = TipoCambio::latest('created_at')->first();
        // $fecha_hoy = Carbon::now()->format('Y-m-d');
        return view('cobranzas.facturas_manuales.show', compact('factura_m', 'igv', 'fecha_hoy','moneda_sec','monedas','bancos','tipo_cambio'));
    }

    // // ! Falta
    // public function show_cliente_factura_m($ruc_cli)
    // {
    //     $ruc = $ruc_cli;
    //     $cliente = Cliente::where('numero_documento', $ruc)->first();
    //     $facturas = Facturacion_m::where('cliente_id', $cliente->id)->get();
    //     $cuotas_all = Cuotas_credito::where('facturacion_m_id', '!=', null)->get();
    //     $start_mes = Carbon::now()->startOfMonth()->format('m/d/Y');
    //     $end_mes = Carbon::now()->endOfMonth()->format('m/d/Y');;
    //     $igv = Igv::first();

    //     // Pagados en el mes conversion de Monedas
    //     foreach ($facturas as $key => $fact) {
    //         $subtotal = $fact->op_gravada + $fact->op_inafecta + $fact->op_exonerada;
    //         $total = $subtotal + ($fact->op_gravada * ($igv->renta / 100));
    //         if ($fact->moneda->nombre == 'soles') {
    //             $soles[] =  $total;
    //             $dolares[] = $total / $fact->cambio;
    //         } else {
    //             $dolares[] = $total;
    //             $soles[] = $total * $fact->cambio;
    //         }
    //     }
    //     $tot_sol = array_sum($soles);
    //     $tot_dol = array_sum($dolares);
    //     // return $tot_dol;
    //     $moneda_sol = Moneda::where('nombre', 'soles')->first();
    //     $moneda_dol = Moneda::where('nombre', 'Dolares')->first();

    //     $star_month = Carbon::now()->startOfMonth();
    //     $end_month = Carbon::now()->endOfMonth();
    //     $fact_mes = Facturacion_m::where('cliente_id', $cliente->id)->whereBetween('created_at', [$star_month, $end_month])->get();
    //     $soles_m = [];
    //     $dolares_m = [];
    //     foreach ($fact_mes as $key => $fact_m) {
    //         $subtotal = $fact_m->op_gravada + $fact_m->op_inafecta + $fact_m->op_exonerada;
    //         $total = $subtotal + ($fact_m->op_gravada * ($igv->renta / 100));
    //         if ($fact_m->moneda->nombre == 'soles') {
    //             $soles_m[] =  $total;
    //             $dolares_m[] = $total * $fact_m->cambio;
    //         } else {
    //             $dolares[] = $total;
    //             $soles_m[] = $total / $fact_m->cambio;
    //         }
    //     }
    //     $tot_sol_m = array_sum($soles_m);
    //     $tot_dol_m = array_sum($dolares_m);


    //     // PAGOS EN DEUDA
    //     $fact_sin = Facturacion_m::where('cliente_id', $cliente->id)->where('estado_pago', '!=', 2)->get();
    //     $soles_s_p = [];
    //     foreach ($fact_sin as $key => $fact_s) {
    //         $subtotal = $fact_s->op_gravada + $fact_s->op_inafecta + $fact_s->op_exonerada;
    //         $total = $subtotal + ($fact_s->op_gravada * ($igv->renta / 100));
    //         if ($fact_s->moneda->nombre == 'soles') {
    //             $soles_s_p[] =  round($total, 2);
    //         } else {
    //             $soles_s_p[] = round($total / $fact_s->cambio, 2);
    //         }
    //     }
    //     $tot_sol_sp = array_sum($soles_s_p);
    //     if (count($facturas) == 0) {
    //         $nota_credito[0] = null;
    //         $nota_debito[0] = null;
    //     } else {
    //         foreach ($facturas as $key => $factura3) {
    //             $nota_credito[$key] = Nota_Credito::where('facturacion_m_id', $factura3->id)->first();
    //             $nota_debito[$key] = Nota_Debito::where('facturacion_m_id', $factura3->id)->first();
    //             if (!isset($nota_credito[$key])) {
    //                 $nota_credito[$key] = null;
    //             }
    //             if (!isset($nota_debito[$key])) {
    //                 $nota_debito[$key] = null;
    //             }
    //         }
    //     }
    //     // return $cuotas_all;

    //     return view('cobranzas.facturas_manuales.clientes', compact('ruc', 'cliente', 'facturas', 'cuotas_all', 'start_mes', 'end_mes', 'igv', 'tot_dol', 'tot_sol', 'moneda_sol', 'moneda_dol', 'fact_mes', 'tot_sol_m', 'fact_sin', 'tot_sol_sp', 'nota_credito', 'nota_debito'));
    // }


    //* BOLETAS
    public function index_boletas()
    {
        $bancos_pluck = Banco::where('estado', 0)->pluck('id');
        $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $monedas = Moneda::get();
        $igv = Igv::first();
        $tipo_cambio = TipoCambio::latest('created_at')->first();
        return view('cobranzas.boletas.index', compact('monedas', 'fecha_hoy', 'tipo_cambio', 'igv', 'bancos'));
    }

    public function index_boleta_pagados()
    {
        $bancos_pluck = Banco::where('estado', 0)->pluck('id');
        $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
        $tipo_cambio = TipoCambio::latest('created_at')->first();
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $monedas = Moneda::get();
        $igv = Igv::first();

        return view('cobranzas.boletas.index_pagados', compact('monedas', 'fecha_hoy', 'tipo_cambio', 'igv', 'bancos'));
    }

    // // ! Falta
    // public function index_boletas_clientes()
    // {
    //     $facturas_m = Facturacion_m::orderByDesc('id')->where('f_electronica', 1)->get();
    //     $cuotas_all = Cuotas_credito::where('facturacion_m_id', '!=', null)->get();
    //     $bancos_pluck = Banco::where('estado', 0)->pluck('id');
    //     $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
    //     $cuentas = BancoRegistro::whereIn('banco_id', $bancos_pluck)->where('estado_detraccion', 0)->get();
    //     $fecha_hoy = Carbon::now()->format('Y-m-d');
    //     $monedas = Moneda::get();
    //     $adelantos = CreditosAdelantos::where('factura_m_id', '!=', null)->get();
    //     $igv = Igv::first();
    //     foreach ($facturas_m as $key => $f_sp) {
    //         $cuotas[$key] = Cuotas_credito::where('facturacion_m_id', $f_sp->id)->count();
    //         $client_id[$key] = $f_sp->cliente_id;
    //     }
    //     $tipo_cambio = TipoCambio::latest('created_at')->first();
    //     if (count($facturas_m) != 0) {
    //         $clientes =  Cliente::whereIn('id', $client_id)->get();
    //         foreach ($clientes as $kry => $client) {

    //             // BUSCAR FACTURAS POR CLIENTE
    //             $count_tot = Facturacion_m::where('cliente_id', $client->id)->where('f_electronica', 1)->count();
    //             $client['cantidad_fact'] = $count_tot;
    //             $facturas = Facturacion_m::where('cliente_id', $client->id)->where('forma_pago_id', 2)->where('f_electronica', 1)->get();
    //             if (count($facturas) != 0) {
    //                 foreach ($facturas as $key => $f_sp) {
    //                     $cuota_lopp[] = Cuotas_credito::where('facturacion_m_id', $f_sp->id)->where('estado', 1)->get();
    //                     if (count($cuota_lopp) > 0) {
    //                         $cuot[$key] = $cuota_lopp;
    //                     }
    //                 }
    //                 $client['cuotas'] = $cuot;
    //             } else {
    //                 // return "b";
    //                 $client['cuotas'] = 0;
    //             }
    //         }
    //         foreach ($facturas_m as $key0 => $fa) {
    //             $client_id2[] = $fa->cliente_id;
    //         }
    //         $q_1 = array_values(array_unique($client_id2));
    //         foreach ($clientes as $key => $client_2) {
    //             $facturas_3 = Facturacion_m::where('cliente_id', $client_2->id)->where('estado_pago', 2)->where('f_electronica', 1)->get();
    //             $cli_3 = Cliente::where('id', $client_2->id)->first();
    //             $precio_fact_cli = 0;
    //             $precio_fact_cli_dol = 0;
    //             // unset($val_tot);
    //             foreach ($facturas_3 as $key2 => $fact3) {
    //                 if ($fact3->forma_pago_id == 2) { //credito
    //                     $precio_tot = Cuotas_credito::where('facturacion_m_id', $fact3->id)->where('estado', 1)->pluck('monto')->sum();
    //                     if ($fact3->moneda->nombre == 'soles') {
    //                         $var_tot_sol = $precio_tot;
    //                         $var_tot_dol = $precio_tot / $fact3->cambio;
    //                     } else {
    //                         $var_tot_sol = $precio_tot * $fact3->cambio;
    //                         $var_tot_dol = $precio_tot;
    //                     }
    //                 } else {
    //                     $subtotal = $fact3->op_gravada + $fact3->op_inafecta + $fact3->op_exonerada;
    //                     $tot = round($subtotal + ($fact3->op_gravada * $igv->renta) / 100, 2);
    //                     if ($fact3->moneda->nombre == 'soles') {
    //                         $var_tot_sol = $tot;
    //                         $var_tot_dol = $tot / $fact3->cambio;
    //                     } else {
    //                         $var_tot_dol = $tot;
    //                         $var_tot_sol = $tot * $fact3->cambio;
    //                     }
    //                 }
    //                 $precio_fact_cli += $var_tot_sol;
    //                 $precio_fact_cli_dol += $var_tot_dol;
    //             }
    //             $var_precio_tot[] = array("tot" => number_format(round($precio_fact_cli, 2), 2), "tot_dol" => number_format(round($precio_fact_cli_dol, 2), 2));
    //         }
    //     } else {
    //         $cuotas = 0;
    //         $clientes = [];
    //         $var_precio_tot = [0];
    //     }
    //     // // return $clientes;
    //     // $last_pagos = ComprobantesPagos::where('factuacion_m_id', '!=', null)->get();
    //     return view('cobranzas.facturas_manuales.index_clientes', compact('facturas_m', 'cuotas', 'cuotas_all', 'fecha_hoy', 'monedas', 'tipo_cambio', 'clientes', 'igv', 'var_precio_tot', 'cuentas', 'adelantos', 'bancos'));
    // }

    public function lista_ajax_boleta(Request $request)
    {
        // return $request->ids_facturas;
        $count_ids = count($request->ids_boletas);
        $igv = Igv::first();
        if ($count_ids > 0) {
            for ($i = 0; $i < $count_ids; $i++) {
                $var[] = $request->ids_boletas[$i];
            }
        }
        $boletas = Boleta::WhereIn('id', $var)->get();
        foreach ($boletas as $key => $boleta) {
            $monto_adl = CreditosAdelantos::where('boleta_id', $boleta->id)->first();
            if ($boleta->forma_pago_id == 2) {
                $cuotas = Cuotas_credito::where('boleta_id', $boleta->id)->get(); //* Codicional el estado de los cuales falta pagar
                foreach ($cuotas as $llave => $cuota) {
                    $new_monto = round($cuota->monto, 2);
                    if (isset($monto_adl)) {
                        $new_monto = round($cuota->monto - $monto_adl->precio_adelanto, 2);
                    }
                    $array_cuot[$llave] = array(
                        'id_cuota' => $cuota->id,
                        'cuota_n' => $cuota->numero_cuota,
                        'monto' => $new_monto,
                        'fecha_pago' => $cuota->fecha_pago,
                        'estado' =>  $cuota->estado
                    );
                }
                $pago_tot = round($cuotas->sum('monto'), 2);
            } else {
                $subtotal = $boleta->op_gravada + $boleta->op_inafecta + $boleta->op_exonerada;
                $pago_tot = round($subtotal + ($boleta->op_gravada * $igv->renta) / 100, 2);
                if (isset($monto_adl)) {
                    $pago_tot = $pago_tot - $monto_adl->precio_adelanto;
                }

                $array_cuot[0] = array(
                    'id_cuota' => '1',
                    'cuota_n' => '1',
                    'monto' => round($pago_tot, 2),
                    'fecha_pago' => $boleta->fecha_vencimiento,
                    'estado' =>  '0'
                );
            }

            $array_end[$key] = array(
                'factura_cod' => $boleta->codigo_boleta,
                'cliente_doc' => $boleta->cliente->numero_documento,
                'cliente_nombre' => $boleta->cliente->nombre,
                'factura_moneda' => $boleta->moneda->nombre,
                'factura_simbolo' => $boleta->moneda->simbolo,
                'total_factura' => round($pago_tot, 2),
                'cuotas_array' => $array_cuot
            );
        }
        return $array_end;
    }

    public function show_boletas($id)
    {
        // *2025 Terminado
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $igv = Igv::first();
        $boleta = Boleta::find($id);
        // return $boleta;
        $moneda_sec = Moneda::where('id', '!=', $boleta->moneda_id)->first();
        // Funcionamiento para el modal de pagos
        $monedas = Moneda::get();
        $bancos_pluck = Banco::where('estado', 0)->pluck('id');
        $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
        $tipo_cambio = TipoCambio::latest('created_at')->first();
        // $fecha_hoy = Carbon::now()->format('Y-m-d');
        return view('cobranzas.boletas.show', compact('boleta', 'igv', 'fecha_hoy','moneda_sec','monedas','bancos','tipo_cambio'));
    }

    // public function show_cliente_boleta($ruc_cli)
    // {
    //     $ruc = $ruc_cli;
    //     $cliente = Cliente::where('numero_documento', $ruc)->first();
    //     $boletas = Boleta::where('cliente_id', $cliente->id)->get();
    //     $cuotas_all = Cuotas_credito::where('boleta_id', '!=', null)->get();
    //     $start_mes = Carbon::now()->startOfMonth()->format('m/d/Y');
    //     $end_mes = Carbon::now()->endOfMonth()->format('m/d/Y');;
    //     $igv = Igv::first();

    //     // Pagados en el mes conversion de Monedas
    //     foreach ($boletas as $key => $bol) {
    //         $subtotal = $bol->op_gravada + $bol->op_inafecta + $bol->op_exonerada;
    //         $total = $subtotal + ($bol->op_gravada * ($igv->renta / 100));
    //         if ($bol->moneda->nombre == 'soles') {
    //             $soles[] =  $total;
    //             $dolares[] = $total / $bol->cambio;
    //         } else {
    //             $dolares[] = $total;
    //             $soles[] = $total * $bol->cambio;
    //         }
    //     }
    //     $tot_sol = array_sum($soles);
    //     $tot_dol = array_sum($dolares);
    //     // return $tot_dol;
    //     $moneda_sol = Moneda::where('nombre', 'soles')->first();
    //     $moneda_dol = Moneda::where('nombre', 'Dolares')->first();

    //     $star_month = Carbon::now()->startOfMonth();
    //     $end_month = Carbon::now()->endOfMonth();
    //     $bol_mes = Boleta::where('cliente_id', $cliente->id)->whereBetween('created_at', [$star_month, $end_month])->get();
    //     $soles_m = [];
    //     $dolares_m = [];
    //     foreach ($bol_mes as $key => $bol_m) {
    //         $subtotal = $bol_m->op_gravada + $bol_m->op_inafecta + $bol_m->op_exonerada;
    //         $total = $subtotal + ($bol_m->op_gravada * ($igv->renta / 100));
    //         if ($bol_m->moneda->nombre == 'soles') {
    //             $soles_m[] =  $total;
    //             $dolares_m[] = $total * $bol_m->cambio;
    //         } else {
    //             $dolares[] = $total;
    //             $soles_m[] = $total / $bol_m->cambio;
    //         }
    //     }
    //     $tot_sol_m = array_sum($soles_m);
    //     $tot_dol_m = array_sum($dolares_m);


    //     // PAGOS EN DEUDA
    //     $bol_sin = Boleta::where('cliente_id', $cliente->id)->where('estado_pago', '!=', 2)->get();
    //     $soles_s_p = [];
    //     foreach ($bol_sin as $key => $bol_s) {
    //         $subtotal = $bol_s->op_gravada + $bol_s->op_inafecta + $bol_s->op_exonerada;
    //         $total = $subtotal + ($bol_s->op_gravada * ($igv->renta / 100));
    //         if ($bol_s->moneda->nombre == 'soles') {
    //             $soles_s_p[] =  round($total, 2);
    //         } else {
    //             $soles_s_p[] = round($total / $bol_s->cambio, 2);
    //         }
    //     }
    //     $tot_sol_sp = array_sum($soles_s_p);
    //     if (count($boletas) == 0) {
    //         $nota_credito[0] = null;
    //         $nota_debito[0] = null;
    //     } else {
    //         foreach ($boletas as $key => $boleta2) {
    //             $nota_credito[$key] = Nota_Credito::where('boleta_id', $boleta2->id)->first();
    //             $nota_debito[$key] = Nota_Debito::where('boleta_id', $boleta2->id)->first();
    //             if (!isset($nota_credito[$key])) {
    //                 $nota_credito[$key] = null;
    //             }
    //             if (!isset($nota_debito[$key])) {
    //                 $nota_debito[$key] = null;
    //             }
    //         }
    //     }
    //     // return $cuotas_all;

    //     return view('cobranzas.boletas.clientes', compact('ruc', 'cliente', 'boletas', 'cuotas_all', 'start_mes', 'end_mes', 'igv', 'tot_dol', 'tot_sol', 'moneda_sol', 'moneda_dol', 'bol_mes', 'tot_sol_m', 'bol_sin', 'tot_sol_sp', 'nota_credito', 'nota_debito'));
    // }
    // BOLETAS MANUALES
    public function index_boletas_manual(){
        $bancos_pluck = Banco::where('estado', 0)->pluck('id');
        $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $monedas = Moneda::get();
        $igv = Igv::first();
        $tipo_cambio = TipoCambio::latest('created_at')->first();
        return view('cobranzas.boletas_manuales.index', compact('monedas', 'fecha_hoy', 'tipo_cambio', 'igv', 'bancos'));
    }

    public function index_boletas_m_pagados(){
        $bancos_pluck = Banco::where('estado', 0)->pluck('id');
        $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
        $tipo_cambio = TipoCambio::latest('created_at')->first();
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $monedas = Moneda::get();
        $igv = Igv::first();

        return view('cobranzas.boletas_manuales.index_pagados', compact('monedas', 'fecha_hoy', 'tipo_cambio', 'igv', 'bancos'));
    }

    // // ! Falta
    // public function index_boletas_m_clientes()
    // {
    //     $facturas_m = Facturacion_m::orderByDesc('id')->where('f_electronica', 1)->get();
    //     $cuotas_all = Cuotas_credito::where('facturacion_m_id', '!=', null)->get();
    //     $bancos_pluck = Banco::where('estado', 0)->pluck('id');
    //     $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
    //     $cuentas = BancoRegistro::whereIn('banco_id', $bancos_pluck)->where('estado_detraccion', 0)->get();
    //     $fecha_hoy = Carbon::now()->format('Y-m-d');
    //     $monedas = Moneda::get();
    //     $adelantos = CreditosAdelantos::where('factura_m_id', '!=', null)->get();
    //     $igv = Igv::first();
    //     foreach ($facturas_m as $key => $f_sp) {
    //         $cuotas[$key] = Cuotas_credito::where('facturacion_m_id', $f_sp->id)->count();
    //         $client_id[$key] = $f_sp->cliente_id;
    //     }
    //     $tipo_cambio = TipoCambio::latest('created_at')->first();
    //     if (count($facturas_m) != 0) {
    //         $clientes =  Cliente::whereIn('id', $client_id)->get();
    //         foreach ($clientes as $kry => $client) {

    //             // BUSCAR FACTURAS POR CLIENTE
    //             $count_tot = Facturacion_m::where('cliente_id', $client->id)->where('f_electronica', 1)->count();
    //             $client['cantidad_fact'] = $count_tot;
    //             $facturas = Facturacion_m::where('cliente_id', $client->id)->where('forma_pago_id', 2)->where('f_electronica', 1)->get();
    //             if (count($facturas) != 0) {
    //                 foreach ($facturas as $key => $f_sp) {
    //                     $cuota_lopp[] = Cuotas_credito::where('facturacion_m_id', $f_sp->id)->where('estado', 1)->get();
    //                     if (count($cuota_lopp) > 0) {
    //                         $cuot[$key] = $cuota_lopp;
    //                     }
    //                 }
    //                 $client['cuotas'] = $cuot;
    //             } else {
    //                 // return "b";
    //                 $client['cuotas'] = 0;
    //             }
    //         }
    //         foreach ($facturas_m as $key0 => $fa) {
    //             $client_id2[] = $fa->cliente_id;
    //         }
    //         $q_1 = array_values(array_unique($client_id2));
    //         foreach ($clientes as $key => $client_2) {
    //             $facturas_3 = Facturacion_m::where('cliente_id', $client_2->id)->where('estado_pago', 2)->where('f_electronica', 1)->get();
    //             $cli_3 = Cliente::where('id', $client_2->id)->first();
    //             $precio_fact_cli = 0;
    //             $precio_fact_cli_dol = 0;
    //             // unset($val_tot);
    //             foreach ($facturas_3 as $key2 => $fact3) {
    //                 if ($fact3->forma_pago_id == 2) { //credito
    //                     $precio_tot = Cuotas_credito::where('facturacion_m_id', $fact3->id)->where('estado', 1)->pluck('monto')->sum();
    //                     if ($fact3->moneda->nombre == 'soles') {
    //                         $var_tot_sol = $precio_tot;
    //                         $var_tot_dol = $precio_tot / $fact3->cambio;
    //                     } else {
    //                         $var_tot_sol = $precio_tot * $fact3->cambio;
    //                         $var_tot_dol = $precio_tot;
    //                     }
    //                 } else {
    //                     $subtotal = $fact3->op_gravada + $fact3->op_inafecta + $fact3->op_exonerada;
    //                     $tot = round($subtotal + ($fact3->op_gravada * $igv->renta) / 100, 2);
    //                     if ($fact3->moneda->nombre == 'soles') {
    //                         $var_tot_sol = $tot;
    //                         $var_tot_dol = $tot / $fact3->cambio;
    //                     } else {
    //                         $var_tot_dol = $tot;
    //                         $var_tot_sol = $tot * $fact3->cambio;
    //                     }
    //                 }
    //                 $precio_fact_cli += $var_tot_sol;
    //                 $precio_fact_cli_dol += $var_tot_dol;
    //             }
    //             $var_precio_tot[] = array("tot" => number_format(round($precio_fact_cli, 2), 2), "tot_dol" => number_format(round($precio_fact_cli_dol, 2), 2));
    //         }
    //     } else {
    //         $cuotas = 0;
    //         $clientes = [];
    //         $var_precio_tot = [0];
    //     }
    //     // // return $clientes;
    //     // $last_pagos = ComprobantesPagos::where('factuacion_m_id', '!=', null)->get();
    //     return view('cobranzas.facturas_manuales.index_clientes', compact('facturas_m', 'cuotas', 'cuotas_all', 'fecha_hoy', 'monedas', 'tipo_cambio', 'clientes', 'igv', 'var_precio_tot', 'cuentas', 'adelantos', 'bancos'));
    // }

    public function lista_ajax_boletas_m(Request $request)
    {
        // return $request->ids_facturas;
        $count_ids = count($request->ids_facturas);
        $igv = Igv::first();
        if ($count_ids > 0) {
            for ($i = 0; $i < $count_ids; $i++) {
                $var[] = $request->ids_facturas[$i];
            }
        }
        $boletas = Boleta_m::WhereIn('id', $var)->get();
        foreach ($boletas as $key => $boleta) {
            // $array_cuot = [];
            if ($boleta->forma_pago_id == 2) {
                $cuotas = Cuotas_credito::where('boleta_m_id', $boleta->id)->get(); //* Codicional el estado de los cuales falta pagar
                foreach ($cuotas as $llave => $cuota) {
                    $array_cuot[$llave] = array(
                        'id_cuota' => $cuota->id,
                        'cuota_n' => $cuota->numero_cuota,
                        'monto' => $cuota->monto,
                        'fecha_pago' => $cuota->fecha_pago,
                        'estado' =>  $cuota->estado
                    );
                }
                $pago_tot = round($cuotas->sum('monto'), 2);
            } else {
                $subtotal = $boleta->op_gravada + $boleta->op_inafecta + $boleta->op_exonerada;
                $pago_tot = round($subtotal + ($boleta->op_gravada * $igv->renta) / 100, 2);

                $array_cuot[0] = array(
                    'id_cuota' => '1',
                    'cuota_n' => '1',
                    'monto' => $pago_tot,
                    'fecha_pago' => $boleta->fecha_vencimiento,
                    'estado' =>  '0'
                );
            }

            $array_end[$key] = array(
                'factura_cod' => $boleta->codigo_boleta,
                'cliente_doc' => $boleta->cliente->numero_documento,
                'cliente_nombre' => $boleta->cliente->nombre,
                'factura_moneda' => $boleta->moneda->nombre,
                'factura_simbolo' => $boleta->moneda->simbolo,
                'total_factura' => $pago_tot,
                'cuotas_array' => $array_cuot
            );
        }
        return $array_end;
    }

    public function show_boletas_m($id)
    {
        /// *2025 Terminado
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $igv = Igv::first();
        $boleta = Boleta_m::find($id);
        $moneda_sec = Moneda::where('id', '!=', $boleta->moneda_id)->first();
        // Funcionamiento para el modal de pagos
        $monedas = Moneda::get();
        $bancos_pluck = Banco::where('estado', 0)->pluck('id');
        $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
        $tipo_cambio = TipoCambio::latest('created_at')->first();
        // $fecha_hoy = Carbon::now()->format('Y-m-d');
        return view('cobranzas.boletas_manuales.show', compact('boleta', 'igv', 'fecha_hoy','moneda_sec','monedas','bancos','tipo_cambio'));
    }
    // public function show_cliente_boleta_m($ruc_cli)
    // {
    //     $ruc = $ruc_cli;
    //     $cliente = Cliente::where('numero_documento', $ruc)->first();
    //     $boletas = Boleta_m::where('cliente_id', $cliente->id)->get();
    //     $cuotas_all = Cuotas_credito::where('boleta_m_id', '!=', null)->get();
    //     $start_mes = Carbon::now()->startOfMonth()->format('m/d/Y');
    //     $end_mes = Carbon::now()->endOfMonth()->format('m/d/Y');;
    //     $igv = Igv::first();

    //     // Pagados en el mes conversion de Monedas
    //     foreach ($boletas as $key => $bol) {
    //         $subtotal = $bol->op_gravada + $bol->op_inafecta + $bol->op_exonerada;
    //         $total = $subtotal + ($bol->op_gravada * ($igv->renta / 100));
    //         if ($bol->moneda->nombre == 'soles') {
    //             $soles[] =  $total;
    //             $dolares[] = $total / $bol->cambio;
    //         } else {
    //             $dolares[] = $total;
    //             $soles[] = $total * $bol->cambio;
    //         }
    //     }
    //     $tot_sol = array_sum($soles);
    //     $tot_dol = array_sum($dolares);
    //     // return $tot_dol;
    //     $moneda_sol = Moneda::where('nombre', 'soles')->first();
    //     $moneda_dol = Moneda::where('nombre', 'Dolares')->first();

    //     $star_month = Carbon::now()->startOfMonth();
    //     $end_month = Carbon::now()->endOfMonth();
    //     $bol_mes = Boleta_m::where('cliente_id', $cliente->id)->whereBetween('created_at', [$star_month, $end_month])->get();
    //     $soles_m = [];
    //     $dolares_m = [];
    //     foreach ($bol_mes as $key => $bol_m) {
    //         $subtotal = $bol_m->op_gravada + $bol_m->op_inafecta + $bol_m->op_exonerada;
    //         $total = $subtotal + ($bol_m->op_gravada * ($igv->renta / 100));
    //         if ($bol_m->moneda->nombre == 'soles') {
    //             $soles_m[] =  $total;
    //             $dolares_m[] = $total * $bol_m->cambio;
    //         } else {
    //             $dolares[] = $total;
    //             $soles_m[] = $total / $bol_m->cambio;
    //         }
    //     }
    //     $tot_sol_m = array_sum($soles_m);
    //     $tot_dol_m = array_sum($dolares_m);


    //     // PAGOS EN DEUDA
    //     $bol_sin = Boleta_m::where('cliente_id', $cliente->id)->where('estado_pago', '!=', 2)->get();
    //     $soles_s_p = [];
    //     foreach ($bol_sin as $key => $bol_s) {
    //         $subtotal = $bol_s->op_gravada + $bol_s->op_inafecta + $bol_s->op_exonerada;
    //         $total = $subtotal + ($bol_s->op_gravada * ($igv->renta / 100));
    //         if ($bol_s->moneda->nombre == 'soles') {
    //             $soles_s_p[] =  round($total, 2);
    //         } else {
    //             $soles_s_p[] = round($total / $bol_s->cambio, 2);
    //         }
    //     }
    //     $tot_sol_sp = array_sum($soles_s_p);
    //     if (count($boletas) == 0) {
    //         $nota_credito[0] = null;
    //         $nota_debito[0] = null;
    //     } else {
    //         foreach ($boletas as $key => $boleta2) {
    //             $nota_credito[$key] = Nota_Credito::where('boleta_m_id', $boleta2->id)->first();
    //             $nota_debito[$key] = Nota_Debito::where('boleta_m_id', $boleta2->id)->first();
    //             if (!isset($nota_credito[$key])) {
    //                 $nota_credito[$key] = null;
    //             }
    //             if (!isset($nota_debito[$key])) {
    //                 $nota_debito[$key] = null;
    //             }
    //         }
    //     }
    //     // return $cuotas_all;

    //     return view('cobranzas.boletas.clientes', compact('ruc', 'cliente', 'boletas', 'cuotas_all', 'start_mes', 'end_mes', 'igv', 'tot_dol', 'tot_sol', 'moneda_sol', 'moneda_dol', 'bol_mes', 'tot_sol_m', 'bol_sin', 'tot_sol_sp', 'nota_credito', 'nota_debito'));
    // }

    //* NOTA DE VENTA

    public function index_nota_venta(){
        $bancos_pluck = Banco::where('estado', 0)->pluck('id');
        $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $monedas = Moneda::get();
        $igv = Igv::first();
        $tipo_cambio = TipoCambio::latest('created_at')->first();
        return view('cobranzas.nota_venta.index', compact('monedas', 'fecha_hoy', 'tipo_cambio', 'igv', 'bancos'));
    }

    public function index_nota_venta_pagados(){
        $bancos_pluck = Banco::where('estado', 0)->pluck('id');
        $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $monedas = Moneda::get();
        $igv = Igv::first();
        $tipo_cambio = TipoCambio::latest('created_at')->first();
        return view('cobranzas.nota_venta.index_pagados', compact('monedas', 'fecha_hoy', 'tipo_cambio', 'igv', 'bancos'));
    }


    public function view_nota_venta()
    {
        $access = ParameterCallController::verifyPermissionAccess(["admin-access"]);
        if (!$access) {
            return redirect()->route('inicio');
        }
        $nota_venta = NotaVenta::orderBy('id')->get();
        // NO VA CUOTAS
        $fecha_hoy =  Carbon::now()->format('Y-m-d');
        $bancos_pluck = Banco::where('estado', 0)->pluck('id');
        $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
        // Esto de CUOTAS 0 SIN PAGAR 1 PAGADO
        $cuentas = BancoRegistro::whereIn('banco_id', $bancos_pluck)->where('estado_detraccion', 0)->get();
        $adelantos = CreditosAdelantos::where('nota_ven_id', '!=', null)->get();
        $monedas = Moneda::get();
        $igv = Igv::first();
        foreach ($nota_venta as $key => $n_v) {
            $nv_ids[] = $n_v->cliente_id;
        }
        // return $nv_ids;
        $tipo_cambio = TipoCambio::latest('created_at')->first();
        $clientes =  Cliente::whereIn('id', $nv_ids)->get();

        foreach ($clientes as $kry => $client) {
            // BUSCAR NOTA DE VENTA POR CLIENTE
            $count_tot = NotaVenta::where('cliente_id', $client->id)->count();
            $client['cantidad_nota_v'] = $count_tot;
            $nota_ven = NotaVenta::where('cliente_id', $client->id)->where('forma_pago', 2)->get();
        }
        foreach ($clientes as $key => $client_2) {
            $nota_venta_3 = NotaVenta::where('cliente_id', $client_2->id)->get();
            $cli_3 = Cliente::where('id', $client_2->id)->first();
            $precio_fact_cli = 0;
            $precio_fact_cli_dol = 0;
            // unset($val_tot);
            foreach ($nota_venta_3 as $key2 => $nota_v) {
                $precio_nota_v_cli = 0;
                $precio_nota_v_cli_dol = 0;

                // BUSQUEDA DE TIPO DE CAMBIO DEL DIA
                $tipo_c = TipoCambio::where('fecha', Carbon::parse($nota_v->fecha_emision)->format('Y-m-d'))->first();
                // return $tipo_c;
                $subtotal = $nota_v->op_gravada + $nota_v->op_inafecta + $nota_v->op_exonerada;
                $tot = round($subtotal + ($nota_v->op_gravada * $igv->renta) / 100, 2);
                if ($nota_v->moneda->nombre == 'soles') {
                    $var_tot_sol = $tot;
                    $var_tot_dol = $tot / $tipo_c->paralelo;
                } else {
                    $var_tot_dol = $tot;
                    $var_tot_sol = $tot * $tipo_c->paralelo;
                }
                $precio_nota_v_cli += $var_tot_sol;
                $precio_nota_v_cli_dol += $var_tot_dol;
            }
            $var_precio_tot[] = array("tot" => number_format(round($precio_nota_v_cli, 2), 2), "tot_dol" => number_format(round($precio_nota_v_cli_dol, 2), 2));
        }
        // return $nota_venta;
        $totales = [];
        foreach ($nota_venta as $index =>  $nota_ventas) {
            $total = 0;
            $suma = 0;
            $nota_venta_reg = NotaVentaRegistro::where('nota_venta_id', $nota_ventas->id)->get();
            foreach ($nota_venta_reg as $nota_venta_regs) {
                $total += $nota_venta_regs->precio_nacional * $nota_venta_regs->cantidad;
            }
            $suma += $total;
            $totales[$index] = $suma;
        }
        $compr_pago = ComprobantesPagos::where('nota_venta_id', '!=', null)->get();

        // return $nota_venta;
        return view('cobranzas.nota_venta.index', compact('nota_venta', 'fecha_hoy', 'monedas', 'tipo_cambio', 'clientes', 'igv', 'totales', 'var_precio_tot', 'compr_pago', 'cuentas', 'adelantos', 'bancos'));
    }


    public function lista_ajax_n_venta(Request $request)
    {
        // return $request->ids_facturas;
        $count_ids = count($request->ids_facturas);
        $igv = Igv::first();
        if ($count_ids > 0) {
            for ($i = 0; $i < $count_ids; $i++) {
                $var[] = $request->ids_facturas[$i];
            }
        }
        $n_venta = NotaVenta::WhereIn('id', $var)->get();

        foreach ($n_venta as $key => $n_vent) {
            $monto_adl = CreditosAdelantos::where('nota_ven_id', $n_vent->id)->first();
            $total = 0;
            $suma = 0;
            $registro = NotaVentaRegistro::where('nota_venta_id', $n_vent->id)->get();
            foreach ($registro as $nota_venta_regs) {
                $total += $nota_venta_regs->precio_nacional * $nota_venta_regs->cantidad;
            }
            $suma += $total;
            if (isset($monto_adl)) {
                $new_monto = round($suma - $monto_adl->precio_adelanto, 2);
            } else {
                $new_monto = $suma;
            }
            $array_cuot[0] = array(
                'id_cuota' => '1',
                'cuota_n' => '1',
                'monto' => round($new_monto,2),
                // 'fecha_pago' => $n_vent->fecha_vencimiento,
                'estado' =>  '0'
            );
            $array_end[$key] = array(
                'factura_cod' => $n_vent->cod_nota_venta,
                'cliente_doc' => $n_vent->cliente->numero_documento,
                'cliente_nombre' => $n_vent->cliente->nombre,
                'factura_moneda' => $n_vent->moneda->nombre,
                'factura_simbolo' => $n_vent->moneda->simbolo,
                'total_factura' => $new_monto,
                'cuotas_array' => $array_cuot
            );
        }
        return $array_end;
    }



    public function show_nota_venta($id)
    {
        /// *2025 Terminado
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $igv = Igv::first();
        $nota_venta = NotaVenta::find($id);
        $moneda_sec = Moneda::where('id', '!=', $nota_venta->moneda_id)->first();
        // Funcionamiento para el modal de pagos
        $monedas = Moneda::get();
        $bancos_pluck = Banco::where('estado', 0)->pluck('id');
        $bancos = Banco::where('estado', 0)->whereIn('id', $bancos_pluck)->get();
        $tipo_cambio = TipoCambio::latest('created_at')->first();
        // $fecha_hoy = Carbon::now()->format('Y-m-d');
        return view('cobranzas.nota_venta.show', compact('nota_venta', 'igv', 'fecha_hoy','moneda_sec','monedas','bancos','tipo_cambio'));
    }



    // public function show_cliente_nota_v($ruc_cli)
    // {
    //     $ruc = $ruc_cli;
    //     $cliente = Cliente::where('numero_documento', $ruc)->first();
    //     $nota_ve = NotaVenta::where('cliente_id', $cliente->id)->get();
    //     // return $nota_ve->id;
    //     $nota_ve_reg2 = NotaVentaRegistro::whereIn('nota_venta_id', $nota_ve->pluck('id'))->get();
    //     // $cuotas_all = Cuotas_credito::where('boleta_m_id', '!=', null)->get();
    //     $start_mes = Carbon::now()->startOfMonth()->format('m/d/Y');
    //     $end_mes = Carbon::now()->endOfMonth()->format('m/d/Y');;
    //     $igv = Igv::first();

    //     // Pagados en el mes conversion de Monedas
    //     foreach ($nota_ve as $key => $n_v) {
    //         $total = 0;
    //         $totales1 = 0;
    //         $nota_v_rg = NotaVentaRegistro::where('nota_venta_id', $n_v->id)->get();
    //         foreach ($nota_v_rg as $nota_venta_regs) {
    //             $total += $nota_venta_regs->precio_nacional * $nota_venta_regs->cantidad;
    //         }
    //         $totales1 += $total;
    //         $tipo_c = TipoCambio::where('fecha', Carbon::parse($n_v->fecha_emision)->format('Y-m-d'))->first();
    //         if ($n_v->moneda->nombre == 'soles') {
    //             $soles[] =  $totales1;
    //             $dolares[] = $totales1 / $tipo_c->paralelo;
    //         } else {
    //             $dolares[] = $totales1;
    //             $soles[] = $totales1 * $tipo_c->paralelo;
    //         }
    //     }
    //     $tot_sol = array_sum($soles);
    //     $tot_dol = array_sum($dolares);
    //     // return $tot_dol;
    //     $moneda_sol = Moneda::where('nombre', 'soles')->first();
    //     $moneda_dol = Moneda::where('nombre', 'Dolares')->first();

    //     $star_month = Carbon::now()->startOfMonth();
    //     $end_month = Carbon::now()->endOfMonth();
    //     $n_v_mes = NotaVenta::where('cliente_id', $cliente->id)->whereBetween('created_at', [$star_month, $end_month])->get();
    //     $soles_m = [];
    //     $dolares_m = [];
    //     foreach ($n_v_mes as $key => $n_v_m) {
    //         $total = 0;
    //         $totales = 0;
    //         $nota_v_rg = NotaVentaRegistro::where('nota_venta_id', $n_v->id)->get();
    //         foreach ($nota_v_rg as $nota_venta_regs) {
    //             $total += $nota_venta_regs->precio_nacional * $nota_venta_regs->cantidad;
    //         }
    //         $totales += $total;
    //         $tipo_c = TipoCambio::where('fecha', Carbon::parse($n_v->fecha_emision)->format('Y-m-d'))->first();

    //         if ($n_v_m->moneda->nombre == 'soles') {
    //             $soles_m[] =  $totales;
    //             $dolares_m[] = $totales * $tipo_c->paralelo;
    //         } else {
    //             $dolares[] = $totales;
    //             $soles_m[] = $totales / $tipo_c->paralelo;
    //         }
    //     }
    //     $tot_sol_m = array_sum($soles_m);
    //     $tot_dol_m = array_sum($dolares_m);


    //     // PAGOS EN DEUDA
    //     $n_v = NotaVenta::where('cliente_id', $cliente->id)->where('estado_pago', '!=', 2)->get();
    //     $soles_s_p = [];
    //     foreach ($n_v as $key => $n_v_f) {
    //         $total = 0;
    //         $totales = 0;
    //         $nota_v_rg = NotaVentaRegistro::where('nota_venta_id', $n_v_f->id)->get();
    //         foreach ($nota_v_rg as $nota_venta_regs) {
    //             $total += $nota_venta_regs->precio_nacional * $nota_venta_regs->cantidad;
    //         }
    //         $totales += $total;
    //         $tipo_c = TipoCambio::where('fecha', Carbon::parse($n_v_f->fecha_emision)->format('Y-m-d'))->first();
    //         if ($n_v_f->moneda->nombre == 'soles') {
    //             $soles_s_p[] =  $total;
    //         } else {
    //             $soles_s_p[] = $total / $tipo_c;
    //         }
    //     }
    //     $tot_sol_sp = array_sum($soles_s_p);
    //     // if(count($nota_ve) == 0){
    //     //     $nota_credito[0] = null;
    //     //     $nota_debito[0] = null;
    //     // }else{
    //     //     foreach ($nota_ve as $key => $boleta2) {
    //     //         $nota_credito[$key] = Nota_Credito::where('boleta_m_id', $boleta2->id)->first();
    //     //         $nota_debito[$key] = Nota_Debito::where('boleta_m_id', $boleta2->id)->first();
    //     //         if (!isset($nota_credito[$key])) {
    //     //             $nota_credito[$key] = null;
    //     //         }
    //     //         if (!isset($nota_debito[$key])) {
    //     //             $nota_debito[$key] = null;
    //     //         }
    //     //     }
    //     // }
    //     // return $cuotas_all;
    //     // return $nota_ve;
    //     return view('cobranzas.nota_venta.clientes', compact('ruc', 'cliente', 'nota_ve', 'nota_ve_reg2', 'start_mes', 'end_mes', 'igv', 'tot_dol', 'tot_sol', 'moneda_sol', 'moneda_dol', 'n_v_mes', 'tot_sol_m', 'n_v', 'tot_sol_sp'));
    // }




    public function show_cuotas(Request $request)
    {
        // return $request
        $n_cuota = $request->data;
        $cuotas = Cuotas_credito::where('id', $n_cuota)->first();
        if ($cuotas->facturacion_id != null) {
            $simbolo = $cuotas->factura_ids->moneda->simbolo;
        }
        if ($cuotas->factura_m_ids != null) {
            $simbolo = $cuotas->factura_m_ids->moneda->simbolo;
        }
        if ($cuotas->boleta_ids != null) {
            $simbolo = $cuotas->boleta_ids->moneda->simbolo;
        }
        if ($cuotas->boleta_m_ids != null) {
            $simbolo = $cuotas->boleta_m_ids->moneda->simbolo;
        }

        $pagos = ComprobantesPagosRegistros::where('id_cuota_credito', $cuotas->id)->get();
        $nav_head = "";
        $val_html = "";
        $array_lote = "";
        foreach ($pagos as $key => $pagos_ind) {
            $pagos_deta = ComprobantesPagosDetalle::where('comprobante_pago_reg_id', $pagos_ind->id)->first();

            if ($key == 0) {
                $nav_head .= "<li><a class='nav-link active' data-toggle='tab' href='#tab-" . $key . "'>Pago " . $key + 1 . "</a></li>";
            } else {
                $nav_head .= "<li><a class='nav-link' data-toggle='tab' href='#tab-" . $key . "'>Pago " . $key + 1 . "</a></li>";
            }
            // Comprobante existencia
            // return $pagos_deta;
            if ($pagos_deta->file_input == null) {
                $comprobante = "<p class='btn btn-secondary view_tarjeta' id='tarjeta_comprobante'>Sin Comprobante</p>";
            } else {
                $comprobante = "<a class='btn btn-primary' href='" . asset('archivos/pagos_sistema/' . $pagos_deta->file_input) . "' download='" . $pagos_deta->file_input . "'>Descargar comprobante</a>";
            }


            $ids_pago_reg[] = $pagos_ind->comprobante_pago_id;
            if ($pagos_deta->tipo_pago == "cheque") {
                $val_html = "
                <div class='tab-content '>
                    <div id='tab-" . $key . "' class='tab-pane active'>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>N° de Cheque</strong></label>
                                        <p class='form-control view_cheque' id='cheque_num'>" . $pagos_deta->numero_input . "</p>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Fecha de Cobro</strong></label>
                                        <p class='form-control view_cheque' id='cheque_fecha'>" . Carbon::parse($pagos_deta->fechas_input)->format('d/m/Y') . "</p>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Banco Emisor</strong></label>
                                        <p class='form-control view_cheque' id='cheque_banco'>" . $pagos_deta->bancos_input . "</p>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Beneficiario</strong></label>
                                        <p class='form-control view_cheque' id='cheque_beneficiario'>" . $pagos_deta->persona_input . "</p>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Monto</strong></label>
                                        <p class='form-control view_cheque' id='cheque_monto'>" . $simbolo . " " . number_format($pagos_deta->montos_input, 2) . "</p>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>N° de cuenta</strong></label>
                                        <p class='form-control view_cheque' id='cheque_cuenta'>" . $pagos_deta->adicional_input . "</p>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Fecha de Emision</strong></label>
                                        <p class='form-control view_cheque' id='cheque_fecha'>" . Carbon::parse($pagos_deta->fecha_emision_input)->format('d/m/Y') . "</p>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Comprobante</strong></label><br>
                                        " . $comprobante . "
                                    </div>
                                </div>
                                <div class='col-sm-12'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Notas
                                                Adicionales</strong></label><br>
                                        <span class='form-control view_efectivo text-area-false' id='efectivo_notas'>" . $pagos_deta->notas_adicionales . "</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                ";
            }
            if ($pagos_deta->tipo_pago == "tarjeta") {
                $val_html = "
                <div class='tab-content '>
                    <div id='tab-" . $key . "' class='tab-pane active'>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Tipo de Pago</strong></label>
                                        <p class='form-control view_tarjeta' id='tipo_pago'>TARJETA</p>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Titular de la Tarjeta</strong></label>
                                        <p class='form-control view_tarjeta' id='tarjeta_titular'>" . $pagos_deta->persona_input . "</p>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Banco</strong></label>
                                        <p class='form-control view_tarjeta' id='tarjeta_banco'>" . $pagos_deta->bancos_input . "</p>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Fecha</strong></label>
                                        <p class='form-control view_tarjeta' id='tarjeta_fecha'>" . Carbon::parse($pagos_deta->fechas_input)->format('d/m/Y') . "</p>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Comprobante</strong></label><br>
                                        " . $comprobante . "
                                    </div>
                                </div>
                                <div class='col-sm-12'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Notas
                                                Adicionales</strong></label><br>
                                        <span class='form-control view_efectivo text-area-false' id='efectivo_notas'>" . $pagos_deta->notas_adicionales . "</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ";
            }
            if ($pagos_deta->tipo_pago == "efectivo") {
                $val_html .= "
                <div class='tab-content '>
                    <div id='tab-" . $key . "' class='tab-pane active'>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-sm-12'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Tipo de Pago</strong></label>
                                        <p class='form-control view_efectivo' id='tipo_pago'>EFECTIVO</p>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Persona que cancela</strong></label>
                                        <p class='form-control view_efectivo' id='efectivo_persona'>" . $pagos_deta->persona_input . "</p>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Fecha</strong></label>
                                        <p class='form-control view_efectivo' id='efectivo_fecha'>" . Carbon::parse($pagos_deta->fechas_input)->format('d/m/Y') . "</p>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Monto de Pago</strong></label>
                                        <p class='form-control view_efectivo' id='efectivo_monto'>" . $simbolo . " " . number_format($pagos_deta->montos_input, 2) . "</p>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Vuelto</strong></label>
                                        <p class='form-control view_efectivo' id='efectivo_vuelto'>" . $simbolo . " " . number_format($pagos_deta->adicional_input, 2) . "</p>
                                    </div>
                                </div>
                                <div class='col-sm-12'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Notas
                                                Adicionales</strong></label><br>
                                        <span class='form-control view_efectivo text-area-false' id='efectivo_notas'>" . $pagos_deta->notas_adicionales . "</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ";
            }
            if ($pagos_deta->tipo_pago == "transferencia") {
                $val_html = "
                <div class='tab-content '>
                    <div id='tab-" . $key . "' class='tab-pane active'>
                        <div class='panel-body'>
                            <div class='row'>
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Titular</strong></label>
                                        <p class='form-control view_transferencia' id='transferencia_titular'>" . $pagos_deta->persona_input . "</p>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Fecha</strong></label>
                                        <p class='form-control view_transferencia' id='transferencia_fecha'>" . Carbon::parse($pagos_deta->fechas_input)->format('d/m/Y') . "</p>
                                    </div>
                                </div>
                                <div class='col-sm-6'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Comprobante</strong></label><br>
                                        " . $comprobante . "
                                    </div>
                                </div>
                                <div class='col-sm-12'>
                                    <div class='form-group'>
                                        <label class='form-label'><strong>Notas
                                                Adicionales</strong></label><br>
                                        <span class='form-control view_efectivo text-area-false' id='efectivo_notas'>" . $pagos_deta->notas_adicionales . "</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ";
            }
        }
        $pagos_anidados = ComprobantesPagosRegistros::whereIn('comprobante_pago_id', $ids_pago_reg)->get();

        if (count($pagos_anidados) > 1) {
            foreach ($pagos_anidados as $key => $pg_ani) {
                $array_lote .= "<li>Cuota N °" . $pg_ani->cuota_credito->numero_cuota . "</li>";
            }
        } else {
            $array_lote .= "";
        }
        $end_html = "";
        $end_html .= "
            <ul class='nav nav-tabs'>
            " . $nav_head . "
            </ul>
            " . $val_html;
        if (count($pagos_anidados) > 1) {
            $end_html .= "
                    <div style='margin: 10px 15% 10px 24%'>
                        <p><strong>Esta cuota se pagó en Lote junto con:</strong></p>
                        " . $array_lote . "
                    </div>
                </div>
            ";
        }
        // json_encode($pagos_deta);

        $array_return = array(
            'datos_cuota' => '2',
            'html_end' => $end_html,
        );

        return $array_return;
    }
    public function print_facturas_cuotas(Request $request, $id)
    {
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $factura = Facturacion::where('id', $id)->first();
        $fact_cuotas = Cuotas_credito::where('facturacion_id', $factura->id)->get();

        $pagos = ComprobantesPagos::where('factuacion_id', $factura->id)->get();
        $empresa = Empresa::first();
        $igv = Igv::first();
        if (count($pagos) != 0) {
            foreach ($pagos as $key => $pagos_ind) {
                $pagos_reg_a = ComprobantesPagosRegistros::where('comprobante_pago_id', $pagos_ind->id)->get();
                $ids[] = $pagos_ind->id;
            }
            $pagos_reg = ComprobantesPagosRegistros::whereIn('comprobante_pago_id', $ids)->get();
            $pagos_deta = ComprobantesPagosDetalle::with([
                'comprobante_pago.facturacion',
                'comprobante_pago_registros.cuota_credito',
                'comprobante_pago_registros',
                'moneda',
            ])->whereIn('comprobante_pago_id', $ids)->get();
        } else {
            $pagos_reg = [];
            $pagos_deta = [];
        }
        // return $pagos_deta[0]->calcularMontoPagadoFormat();
        // $cuotas = Cuotas_credito::where('facturacion_id', $factura->id)->get();
        return view('cobranzas.facturas.print', compact('empresa', 'factura', 'fact_cuotas', 'pagos_reg', 'pagos_deta', 'pagos', 'fecha_hoy', 'igv'));
    }
    public function print_facturas_m_cuotas(Request $request, $id)
    {
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $factura = Facturacion_m::where('id', $id)->first();
        $fact_cuotas = Cuotas_credito::where('facturacion_m_id', $factura->id)->get();

        $pagos = ComprobantesPagos::where('factuacion_m_id', $factura->id)->get();
        $empresa = Empresa::first();
        $igv = Igv::first();
        if (count($pagos) != 0) {
            foreach ($pagos as $key => $pagos_ind) {
                $pagos_reg_a = ComprobantesPagosRegistros::where('comprobante_pago_id', $pagos_ind->id)->get();
                $ids[] = $pagos_ind->id;
            }
            $pagos_reg = ComprobantesPagosRegistros::whereIn('comprobante_pago_id', $ids)->get();
            $pagos_deta = ComprobantesPagosDetalle::with([
                'comprobante_pago.facturacionM',
                'comprobante_pago_registros.cuota_credito',
                'comprobante_pago_registros',
                'moneda',
            ])->whereIn('comprobante_pago_id', $ids)->get();
        } else {
            $pagos_reg = [];
            $pagos_deta = [];
        }
        // return $factura;
        // $cuotas = Cuotas_credito::where('facturacion_id', $factura->id)->get();
        return view('cobranzas.facturas_manuales.print', compact('empresa', 'factura', 'fact_cuotas', 'pagos_reg', 'pagos_deta', 'pagos', 'fecha_hoy', 'igv'));
    }
    public function print_boleta_cuotas(Request $request, $id)
    {
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $boleta = Boleta::where('id', $id)->first();
        $bol_cuotas = Cuotas_credito::where('boleta_id', $boleta->id)->get();

        $pagos = ComprobantesPagos::where('boleta_id', $boleta->id)->get();
        $empresa = Empresa::first();
        $igv = Igv::first();
        if (count($pagos) != 0) {
            foreach ($pagos as $key => $pagos_ind) {
                $pagos_reg_a = ComprobantesPagosRegistros::where('comprobante_pago_id', $pagos_ind->id)->get();
                $ids[] = $pagos_ind->id;
            }
            $pagos_reg = ComprobantesPagosRegistros::whereIn('comprobante_pago_id', $ids)->get();
            $pagos_deta = ComprobantesPagosDetalle::with([
                'comprobante_pago.boleta',
                'comprobante_pago_registros.cuota_credito',
                'comprobante_pago_registros',
                'moneda',
            ])->whereIn('comprobante_pago_id', $ids)->get();
        } else {
            $pagos_reg = [];
            $pagos_deta = [];
        }
        // return $factura;
        // $cuotas = Cuotas_credito::where('facturacion_id', $factura->id)->get();
        return view('cobranzas.boletas.print', compact('empresa', 'boleta', 'bol_cuotas', 'pagos_reg', 'pagos_deta', 'pagos', 'fecha_hoy', 'igv'));
    }
    public function print_boletas_m_cuotas(Request $request, $id)
    {
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $boleta = Boleta_m::where('id', $id)->first();
        $bol_cuotas = Cuotas_credito::where('boleta_m_id', $boleta->id)->get();

        $pagos = ComprobantesPagos::where('boleta_m_id', $boleta->id)->get();
        $empresa = Empresa::first();
        $igv = Igv::first();
        if (count($pagos) != 0) {
            foreach ($pagos as $key => $pagos_ind) {
                $pagos_reg_a = ComprobantesPagosRegistros::where('comprobante_pago_id', $pagos_ind->id)->get();
                $ids[] = $pagos_ind->id;
            }
            $pagos_reg = ComprobantesPagosRegistros::whereIn('comprobante_pago_id', $ids)->get();
            $pagos_deta = ComprobantesPagosDetalle::with([
                'comprobante_pago.boletaM',
                'comprobante_pago_registros.cuota_credito',
                'comprobante_pago_registros',
                'moneda',
            ])->whereIn('comprobante_pago_id', $ids)->get();
        } else {
            $pagos_reg = [];
            $pagos_deta = [];
        }
        // return $factura;
        // $cuotas = Cuotas_credito::where('facturacion_id', $factura->id)->get();
        return view('cobranzas.boletas_manuales.print', compact('empresa', 'boleta', 'bol_cuotas', 'pagos_reg', 'pagos_deta', 'pagos', 'fecha_hoy', 'igv'));
    }

    public function print_n_venta(Request $request, $id)
    {
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $nota_venta = NotaVenta::find($id);
        // $nota_venta_reg = NotaVentaRegistro
        // $nv_cuotas = Cuotas_credito::where('nota_venta_id', $nota_venta->id)->get();
        $pagos = ComprobantesPagos::where('nota_venta_id', $nota_venta->id)->get();
        $empresa = Empresa::first();
        $igv = Igv::first();
        if (count($pagos) != 0) {
            foreach ($pagos as $key => $pagos_ind) {
                $pagos_reg_a = ComprobantesPagosRegistros::where('comprobante_pago_id', $pagos_ind->id)->get();
                $ids[] = $pagos_ind->id;
            }
            $pagos_reg = ComprobantesPagosRegistros::whereIn('comprobante_pago_id', $ids)->get();
            $pagos_deta = ComprobantesPagosDetalle::with([
                'comprobante_pago.notaVenta',
                'comprobante_pago_registros.cuota_credito',
                'comprobante_pago_registros',
                'moneda',
            ])->whereIn('comprobante_pago_id', $ids)->get();
        } else {
            $pagos_reg = [];
            $pagos_deta = [];
        }
        // return $factura;
        // $cuotas = Cuotas_credito::where('facturacion_id', $factura->id)->get();
        return view('cobranzas.nota_venta.print', compact('empresa', 'nota_venta', 'pagos_reg', 'pagos_deta', 'pagos', 'fecha_hoy', 'igv'));
    }
}
