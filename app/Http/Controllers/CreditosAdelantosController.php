<?php

namespace App\Http\Controllers;

use App\BancoRegistro;
use App\Boleta;
use App\Cliente;
use App\CreditosAdelantos;
use App\CreditosAdelantosRegistros;
use App\Cuotas_credito;
use App\Empresa;
use App\Facturacion;
use App\Facturacion_m;
use App\Igv;
use PDF;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Return_;

use function PHPUnit\Framework\isNull;

class CreditosAdelantosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function ajax_fact(Request $request)
    {

        $id_fact_m =  $request->id_factura_m;
        $igv = Igv::first();
        $factura = Facturacion_m::find($id_fact_m);
        $monto_adl = CreditosAdelantos::where('factura_m_id', $factura->id)->first();
        // return $monto_adl;
        if(isNull($monto_adl)){
            $monto_adl_precio = 0;
        }else{
            $monto_adl_precio = $monto_adl->precio_adelanto;
        }
        if ($factura->forma_pago_id == 2) {
            $cuotas = Cuotas_credito::where('facturacion_m_id', $factura->id)->get(); //* Codicional el estado de los cuales falta pagar 
            foreach ($cuotas as $llave => $cuota) {
                $monto_adl_cuota = CreditosAdelantosRegistros::where('cuota_cred_id', $cuota->id)->sum('montos_input');
                $new_monto =  round($cuota->monto - $monto_adl_precio,2);
                $array_cuot[$llave] = array(
                    'id_cuota' => $cuota->id,
                    'cuota_n' => $cuota->numero_cuota,
                    'monto' => $new_monto,
                    'fecha_pago' => $cuota->fecha_pago,
                    'estado' =>  $cuota->estado
                );
            }
            $pago_tot = round($cuotas->sum('monto'), 2);
        }else{
            $adle_header = CreditosAdelantos::where('factura_m_id', $factura->id)->first();
            $subtotal = $factura->op_gravada + $factura->op_inafecta + $factura->op_exonerada;
            $pago_tot = round($subtotal + ($factura->op_gravada * $igv->renta) / 100, 2);
            if(isset($adle_header)){
                // return $adle_header;
                $pago_tot = $pago_tot - $adle_header->precio_adelanto;
            }

            $array_cuot[0] = array(
                'id_cuota' => '1',
                'cuota_n' => '1',
                'monto' => round($pago_tot - $monto_adl_precio,2),
                'fecha_pago' => $factura->fecha_vencimiento,
                'estado' =>  '0'
            );

        }
        $array_end = array(
            'factura_cod' => $factura->codigo_fac,
            'cliente_doc' => $factura->cliente->numero_documento,
            'cliente_nombre' => $factura->cliente->nombre,
            'factura_moneda' => $factura->moneda->nombre,
            'factura_simbolo' => $factura->moneda->simbolo,
            'total_factura' => $pago_tot,
            'cuotas_array' => $array_cuot
        );
        return $array_end;
    }

    public function view_adl_registro(Request $request){
        $numero_adl = $request->id_adl_reg;
        $adl_reg = CreditosAdelantosRegistros::where('id', $numero_adl)->first();
        //  if ($adl_reg->cuota_cred_id != null) {  //CREDITO
            // $cre = Cuotas_credito::where('id',$adl_reg->cuota_cred_id)->first();
            $cre = CreditosAdelantos::where('id', $adl_reg->creditos_adl_id)->first();
            switch (true) {
                case $cre->factura_id != null:
                    $adl_reg->montos_input = $cre->factura_ids->moneda->simbolo.' '.number_format($adl_reg->montos_input,2);
                    break;
                case $cre->factura_m_id != null:
                    $adl_reg->montos_input = $cre->factura_m_ids->moneda->simbolo.' '.number_format($adl_reg->montos_input,2);
                    break;
                case $cre->boleta_id != null:
                    $adl_reg->montos_input = $cre->boleta_ids->moneda->simbolo.' '.number_format($adl_reg->montos_input,2);
                    break;
                case $cre->boleta_m_id != null:
                    $adl_reg->montos_input = $cre->boleta_m_ids->moneda->simbolo.' '.number_format($adl_reg->montos_input,2);
                    break;
                case $cre->nota_ven_id != null:
                    $adl_reg->montos_input = $cre->nota_venta_id->moneda->simbolo.' '.number_format($adl_reg->montos_input,2);
                    break;
            }
        // }else{
        //     $adl_reg->montos_input = $cre->boleta_m_ids->moneda->simbolo.' '.number_format($adl_reg->montos_input,2);
        // }
        if ($adl_reg->notas_adicionales == null) {
            $adl_reg->notas_adicionales = '<i>Sin notas Adicionales</i>';
        }
        if($adl_reg->adicional_input != null){
            $banco_reg = BancoRegistro::where('id', $adl_reg->adicional_input)->first();
            $adl_reg->adicional_input = $banco_reg->tipo_cuenta.' - '.$banco_reg->nombre_cuenta;
        }
        // $adl_reg->adicional_input = BancoRegistro::where('id', $adl_reg->adicional_input)->first();
        return $adl_reg;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_adelanto_factura(Request $request)
    {
        // return $request;  

        $tipo_adelanto = $request->get('input_adelanto');  
        $tipo_doc = $request->get('tipo_comprobante');
        
        $id_fact = $request->get('id_factura');
        switch ($tipo_adelanto) {
            case '1':
                $tipo_adl_txt = 'cheque';
                break;
            case '2':
                $tipo_adl_txt = 'tarjeta';
                break;
            case '3':
                $tipo_adl_txt = 'efectivo';
                break;
            case '4':
                $tipo_adl_txt = 'transferencia';
                break;
        }
        //* cambios en cuotas y creditos cuotas
        
        //guardado cabecera adelanto
        $igv = Igv::first();
        if($tipo_doc == "factura"){    
            $factura_search  = Facturacion::where('id', $id_fact)->first();
            $exist_Adl = CreditosAdelantos::where('factura_id',$factura_search->id)->first();
            $n_fact_s = $request->get('numero_factura');
        }else{            
            $factura_search  = Facturacion_m::where('id', $id_fact)->first();
            $exist_Adl = CreditosAdelantos::where('factura_m_id',$factura_search->id)->first();
            $n_fact_s = $request->get('numero_factura_m');
        }
        // GUARDADO DE FACTURA
        $factura_search->estado_pago = 1;
        $factura_search->save();

        $cuotas_pre = $request->get('cuotas_precio_' . $n_fact_s);
        $monto_cuota = explode('_', $cuotas_pre);
        //   $cuotas_pre;
        if($factura_search->forma_pago_id == 2){ // credito
            $cuota_cre = Cuotas_credito::where('id', $monto_cuota[0])->first();
            // return $cuota_cre;
            $total_cuota = round($cuota_cre->monto,2);
        }else{ //contado
            // precio total de la factura en caso de contado
            $sub_total = $factura_search->op_gravada + $factura_search->op_inafecta + $factura_search->op_exonerada;
            $total = $sub_total + ($sub_total * ($igv->igv_total / 100));
            $total_cuota = round($total,2);
        }

        if (!isset($exist_Adl)) {
            $adelanto = new CreditosAdelantos();
            if($tipo_doc == "factura"){    
                $adelanto->factuacion_id = $factura_search->id;
            }else{            
                $adelanto->factura_m_id = $factura_search->id;
            }
            $adelanto->precio_total_pago = $total_cuota;
            $adelanto->save();
        }else{
            $adelanto = $exist_Adl;
        }
        // return $request;
        //guardado  registros
        $adl_regist = new CreditosAdelantosRegistros();
        $adl_regist->creditos_adl_id = $adelanto->id;
        if($factura_search->forma_pago_id == 2){ // credito
            $adl_regist->cuota_cred_id = $cuota_cre->id;
        }
        
        // $adelanto_reg
        switch ($tipo_adelanto) {
            case '1': // CHEQUE
                if ($request->hasFile('cheque_file_adl')) {
                    $file = $request->file('cheque_file_adl');
                    $name_file = time() . $file->getClientOriginalName();
                    $destino = public_path('archivos/adelantos/');
                    $file->move($destino, $name_file);
                } else {
                    $name_file = null;
                }

                
                $adl_regist->tipo_pago = "cheque";
                if ($request->get('cheque_diferido') == 'on') { //registro de cheque diferido
                    $adl_regist->option_input = 1;
                    //cambio de estado a 2 para pendiente -> nuevo formulario para saber si ya pasó
                    //estado  0 = sin pagara |||  1 = pagado medio  ||| 2 pagado parcial
                    $adl_regist->estado = 2;
                }else{
                    //option input para cheque es para saber si es diferido o no
                    $adl_regist->option_input = 0;
                }
                $adl_regist->numero_input = $request->get('cheque_name_adl');
                $adl_regist->fechas_input = $request->get('cheque_fecha_cobro_adl');
                $adl_regist->bancos_input = $request->get('cheque_banco_emisor_adl');
                $adl_regist->persona_input = $request->get('cheque_beneficiario_adl');
                $adl_regist->montos_input = $request->get('cheque_monto');
                $adl_regist->adicional_input = $request->get('cheque_n_cuenta');
                $adl_regist->fecha_emision_input = $request->get('cheque_fecha_emision_adl');
                $adl_regist->file_input = $name_file;
                $adl_regist->notas_adicionales = $request->get('notas_adicionales_adl');
                $adl_regist->save();
                
                // $adelant_head = CreditosAdelantos::find($adelanto->id);
                // $adelant_head->fecha_pago =  $adl_regist->fechas_input;
                // $adelant_head->precio_total_pago =  $total_cuota;
                // $adelant_head->precio_adelanto =  $adl_regist->montos_input;
                // $adelant_head->save();

            break;
            case '2': //tarjeta

                if ($request->hasFile('tarjeta_file_adl')) {
                    $file = $request->file('tarjeta_file_adl');
                    $name_file = time() . $file->getClientOriginalName();
                    $destino = public_path('archivos/adelantos/');
                    $file->move($destino, $name_file);
                } else {
                    $name_file = null;
                }
                // 
                $adl_regist->tipo_pago = 'tarjeta';
                $adl_regist->persona_input = $request->get('tarjeta_titular_adl');
                $adl_regist->bancos_input = $request->get('tarjeta_banco_adl');
                $adl_regist->fechas_input = $request->get('tarjeta_fecha_adl');
                $adl_regist->montos_input = $request->get('tarjeta_mondo_adl');
                $adl_regist->file_input = $name_file;
                $adl_regist->notas_adicionales = $request->get('notas_adicionales_adl');
                $adl_regist->save();

                // $adelant_head = CreditosAdelantos::find($adelanto->id);
                // $adelant_head->ultima_fecha = $adl_regist->fechas_input;
                // $adelant_head->precio_total_pago = $total_cuota;
                // $adelant_head->precio_adelanto = $adl_regist->montos_input;
                // $adelant_head->save();
                
            break;
            case '3': // efectivo

                // 
                $adl_regist->tipo_pago = 'efectivo';
                $adl_regist->persona_input = $request->get('efectivo_persona_adl');
                $adl_regist->fechas_input = $request->get('fecha_efectivo_adl');
                $adl_regist->montos_input = $request->get('monto_adelanto_efectivo_adl');
                $adl_regist->notas_adicionales = $request->get('notas_adicionales_adl');
                $adl_regist->save();
                	
                // $adelant_head = CreditosAdelantos::find($adelanto->id);
                // $adelant_head->ultima_fecha = $adl_regist->fechas_input;
                // $adelant_head->precio_total_pago = $total_cuota;
                // $adelant_head->precio_adelanto = $adl_regist->montos_input;
                // $adelant_head->save();

            break;
            case '4': //transferencia
                # code
                if ($request->hasFile('transferencia_comprobante_adl')) {
                    $file = $request->file('transferencia_comprobante_adl'); 
                    $name_file = time() . $file->getClientOriginalName();
                    $destino = public_path('archivos/adelantos/');
                    $file->move($destino, $name_file);
                } else {
                    $name_file = null;
                }

                // $adl_regist->creaditos_adl_id = $adelanto->id;
                $adl_regist->tipo_pago = 'transferencia';
                $adl_regist->persona_input = $request->get('transferencia_titular_adl');
                $adl_regist->fechas_input = $request->get('transferencia_fecha_adl');
                $adl_regist->adicional_input = $request->get('transferencia_n_cuenta');
                $adl_regist->numero_input = $request->get('transferencia_operacion_adl');
                $adl_regist->bancos_input = $request->get('transferencia_banco_adl');
                $adl_regist->montos_input = $request->get('transferencia_monto');
                $adl_regist->file_input = $name_file;
                // numero de cuenta
                $adl_regist->notas_adicionales = $request->get('notas_adicionales_adl');
                $adl_regist->save();

                // $adelant_head = CreditosAdelantos::find($adelanto->id);
                // $adelant_head->ultima_fecha = $adl_regist->fechas_input;
                // $adelant_head->precio_total_pago = $total_cuota;
                // $adelant_head->precio_adelanto = $adl_regist->montos_input;
                // $adelant_head->save();

            break; 
        }

        // AUMENTAR LA SUMA DE ADELANTOS
        $adelanto->ultima_fecha = $adl_regist->fechas_input;
        $adelanto->precio_adelanto = $adelanto->precio_adelanto +$adl_regist->montos_input;
        $adelanto->save();
        // return $adelanto;

        // SI LA CUOTA ESTA CREADA NO CREAR CABECERA SOLO AÑADIR REGISTRO Y SUMNAR EN CABEZERA LOS MONTOS Y LA ULTIMA FECHA DE ADELANTO
        // return view('pagos') 
        return redirect()->route('pagos.show_facturas_m', $factura_search->codigo_fac);
    }

    public function store(Request $request)
    {
        //
    }

    public function pago_adelanto_diferido(){

    }
    /**
     * Display the specified resource.
     *
     * @param  \App\CreditosAdelantos  $creditosAdelantos
     * @return \Illuminate\Http\Response
     */
    public function show(CreditosAdelantos $creditosAdelantos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CreditosAdelantos  $creditosAdelantos
     * @return \Illuminate\Http\Response
     */
    public function edit(CreditosAdelantos $creditosAdelantos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CreditosAdelantos  $creditosAdelantos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CreditosAdelantos $creditosAdelantos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CreditosAdelantos  $creditosAdelantos
     * @return \Illuminate\Http\Response
     */
    public function destroy(CreditosAdelantos $creditosAdelantos)
    {
        //
    }
    public function comprobante_facturas(Request $request){
        return $request;
    }

    public function comprobantes_pdf($id){
        $empresa = Empresa::first();
        $adelanto_reg = CreditosAdelantosRegistros::where('id', $id)->first();
        $adl_header = CreditosAdelantos::where('id', $adelanto_reg->creditos_adl_id)->first();
        // return $adl_header;
        switch (true) {
            case $adl_header->factura_id != null:
                $doc = Facturacion::where('id', $adl_header->factura_id)->first();
                $cli_id = $doc->cliente_id;
                $moneda = $doc->moneda;
                $comprobante_num = $doc->codigo_fac;
            break;
            case $adl_header->factura_m_id != null:
                $doc = Facturacion_m::where('id', $adl_header->factura_m_id)->first();
                $cli_id = $doc->cliente_id;
                $moneda = $doc->moneda;
                $comprobante_num = $doc->codigo_fac;
            break;
            case $adl_header->boleta_id != null:
                $doc = Boleta::where('id', $adl_header->boleta_id)->first();
                $cli_id = $doc->cliente_id;
                $moneda = $doc->moneda;
                $comprobante_num = $doc->codigo_boleta;
            break;
            case $adl_header->boleta_m_id != null:
                $doc = Boleta::where('id', $adl_header->boleta_m_id)->first();
                $cli_id = $doc->cliente_id;
                $moneda = $doc->moneda;
                $comprobante_num = $doc->codigo_boleta;
            break;
        }
        if(isset($adelanto_reg->adicional_input)){
            $banco_reg = BancoRegistro::where('id', $adelanto_reg->adicional_input)->first();
            $adelanto_reg->adicional_input = $banco_reg->tipo_cuenta.' - '.$banco_reg->nombre_cuenta;
        }
        // $monto_restante_cuota = $ad
        $cliente = Cliente::where('id', $cli_id)->first();
        // return $cliente;
        // return view('cobranzas.comprobante_adelanto_pdf',compact('empresa','adelanto_reg','cliente','moneda', 'comprobante_num','adl_header','doc'));
        $pdf = PDF::loadView('cobranzas.comprobante_adelanto_pdf',compact('empresa','adelanto_reg','cliente','moneda', 'comprobante_num','adl_header','doc'));
        return $pdf->download('comprobante.pdf');
    }
}
