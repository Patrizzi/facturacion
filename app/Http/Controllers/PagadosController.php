<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\ComprobantesPagos;
use App\ComprobantesPagosDetalle;
use App\ComprobantesPagosRegistros;
use App\Cuotas_credito;
use App\Empresa;
use App\Facturacion;
use App\Igv;
use App\Moneda;
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
    public function index()
    {
        $facturas = Facturacion::where('forma_pago_id', 2)->get();
        $cuotas = Cuotas_credito::where('facturacion_id', '!=', null)->get();
        // return $cuotas->where('facturacion_id','323')->count();
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        // return $fecha_hoy;
        $monedas = Moneda::get();
        $tipo_cambio = TipoCambio::latest('created_at')->first();       // return $fecha_hoy;
        // return $facturas;
        return view('cobranzas.cobros.index', compact('facturas', 'cuotas', 'fecha_hoy', 'monedas', 'tipo_cambio'));
    }
    public function lista_ajax(Request $request)
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
            // $array_cuot = [];
            if ($factura->forma_pago_id == 2) {
                $cuotas = Cuotas_credito::where('facturacion_id', $factura->id)->get(); //* Codicional el estado de los cuales falta pagar 
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
            }else{
                $subtotal = $factura->op_gravada + $factura->op_inafecta + $factura->op_exonerada;
                $pago_tot = number_format(round($subtotal + ($factura->op_gravada * $igv->renta) / 100, 2), 2);

                $array_cuot[0] = array(
                    'id_cuota' => '1',
                    'cuota_n' => '1',
                    'monto' => $pago_tot,
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
    public function store(Request $request)
    {
        // return $request;
        $tipo_pag = $request->get('input_pago');
        // return  $tipo_pag;
        // CUOTAS DE DB cambio de estado? // agregar estado en columna de cuotas_Credito
        // Obtencion de las facturas seleccionadas
        $n_fact_s = $request->get('numero_factura');
        // $factura = Facturacion::where('cod_factura')->get();
        switch ($tipo_pag) {
            case '1':
                $tipo_pago_txt = 'cheque';
                // $comprobante = Facturacion::where('cod_factura', $n_fact_s )->get();
                break;
            case '2':
                $tipo_pago_txt = 'tarjeta';
                break;
            case '3':
                $tipo_pago_txt = 'efectivo';
                break;
            case '4':
                $tipo_pago_txt = 'transferencia';
                break;
        }
        // return $tipo_pag;
        // return $request;    
        // AGREGAR A LA NUEVA TABLA La cabecaer
        $facturas_comp = $request->get('id_factura');

        // fac
        // return $facturas_comp;
        foreach ($facturas_comp as $fc_comp) {

            $comprobante_pago = new ComprobantesPagos();
            $comprobante_pago->tipo_doc = 'factura';
            $comprobante_pago->factuacion_id = $fc_comp;
            // $comprobante_pago->factuacion_m_id ;
            // $comprobante_pago->boleta_id ;
            // $comprobante_pago->boleta_m_id ;
            $comprobante_pago->tipo_pago = $tipo_pago_txt;

            // $comprobante_pago->fecha_registro =  ;
            $comprobante_pago->save();
            $factura_search  = Facturacion::where('id', $fc_comp)->first();
            // return $request;
            foreach ($n_fact_s as $key => $value) {
                $cuotas_pre = $request->get('cuotas_precio_' . $value);
                foreach ($cuotas_pre as $key2 => $value2) {
                    $monto_cuota = explode('_', $value2);
                    // $monto_cuota = explode('_', $value2);
                    if ($factura_search->forma_pago_id == 2) {
                        $couta = Cuotas_credito::where('id', $monto_cuota[0])->first();
                        $couta->estado = 1;
                        $couta->save();
                    }

                    // AGREGAR A LA NUEVA TABLA LOS REGISTROS?
                    $comprobante_pago_reg = new ComprobantesPagosRegistros();
                    $comprobante_pago_reg->comprobante_pago_id = $comprobante_pago->id;
                    if($factura_search->forma_pago_id == 2){
                        $comprobante_pago_reg->id_cuota_credito = $request->get('id_cuota')[$key2];
                    }
                    $comprobante_pago_reg->monto_total = $request->get('tot_cuotas')[$key];
                    $comprobante_pago_reg->monto_pago = $monto_cuota[1];
                    $comprobante_pago_reg->save();

                    $comprobante_pago = ComprobantesPagos::find($comprobante_pago->id);
                    $comprobante_pago->monto_tot = $request->get('tot_cuotas')[$key];
                    $comprobante_pago->monto_pago =$monto_cuota[1];
                    $comprobante_pago->save();

                    switch ($tipo_pag) {
                        case '1':
            
                            if ($request->hasFile('cheque_file')) {
                                $file = $request->file('cheque_file');
                                $name_file = time() . $file->getClientOriginalName();
                                $destino = public_path('archivos/pagos_sistema/');
                                $file->move($destino, $name_file);
                            } else {
                                $name_file = null;
                            }
            
                            #CHEQUE
                            $pago_reg_1 = new ComprobantesPagosDetalle();
                            $pago_reg_1->comprobante_pago_id = $comprobante_pago->id;
                            $pago_reg_1->comprobante_pago_reg_id = $comprobante_pago_reg->id;
                            $pago_reg_1->tipo_pago = "cheque";
                            $pago_reg_1->numero_input = $request->get('cheque_name');
                            $pago_reg_1->fechas_input = $request->get('cheque_fecha_cobro');
                            $pago_reg_1->bancos_input = $request->get('cheque_banco_emisor');
                            $pago_reg_1->persona_input = $request->get('cheque_beneficiario');
                            $pago_reg_1->montos_input = $request->get('cheque_monto');
                            $pago_reg_1->adicional_input = $request->get('cheque_n_cuenta');
                            $pago_reg_1->fecha_emision_input = $request->get('cheque_fecha_emision');
                            $pago_reg_1->file_input = $name_file;
                            $pago_reg_1->notas_adicionales = $request->get('notas_adicionales');
                            $pago_reg_1->save();
                            $comprobante_pago = ComprobantesPagos::find($comprobante_pago->id);
                            $comprobante_pago->fecha_registro = $pago_reg_1->fechas_input;
                            $comprobante_pago->save();
                            $comprobante_pago_reg = ComprobantesPagosRegistros::find($comprobante_pago_reg->id);
                            $comprobante_pago_reg->fecha_pago = $pago_reg_1->fechas_input;
                            $comprobante_pago_reg->save();
                            break;
                        case '2':
                            #TARJETA
                            if ($request->hasFile('cheque_file')) {
                                $file = $request->file('cheque_file');
                                $name_file = time() . $file->getClientOriginalName();
                                $destino = public_path('archivos/pagos_sistema/');
                                $file->move($destino, $name_file);
                            } else {
                                $name_file = null;
                            }
            
                            $pago_reg_2 = new ComprobantesPagosDetalle();
                            $pago_reg_2->comprobante_pago_id = $comprobante_pago->id;
                            $pago_reg_2->comprobante_pago_reg_id = $comprobante_pago_reg->id;
                            $pago_reg_2->tipo_pago = "tarjeta";
                            $pago_reg_2->persona_input = $request->get('tarjeta_titular');
                            $pago_reg_2->bancos_input = $request->get('tarjeta_banco');
                            $pago_reg_2->fechas_input = $request->get('tarjeta_fecha');
                            $pago_reg_2->file_input = $name_file;
                            $pago_reg_2->notas_adicionales = $request->get('notas_adicionales');
                            $pago_reg_2->save();
                            $comprobante_pago = ComprobantesPagos::find($comprobante_pago->id);
                            $comprobante_pago->fecha_registro = $pago_reg_2->fechas_input;
                            $comprobante_pago->save();
                            $comprobante_pago_reg = ComprobantesPagosRegistros::find($comprobante_pago_reg->id);
                            $comprobante_pago_reg->fecha_pago = $pago_reg_2->fechas_input;
                            $comprobante_pago_reg->save();
                            break;
                        case '3':
                            #EFECTIVO
                            $pago_reg_3 = new ComprobantesPagosDetalle();
                            $pago_reg_3->comprobante_pago_id = $comprobante_pago->id;
                            $pago_reg_3->comprobante_pago_reg_id = $comprobante_pago_reg->id;
                            $pago_reg_3->tipo_pago = "efectivo";
                            $pago_reg_3->persona_input = $request->get('efectivo_persona');
                            $pago_reg_3->fechas_input = $request->get('fecha_efectivo');
                            $pago_reg_3->montos_input = $request->get('monto_pago_efectivo');
                            $pago_reg_3->adicional_input = $request->get('monto_vuelto');
                            $pago_reg_3->notas_adicionales = $request->get('notas_adicionales');
                            $pago_reg_3->save();
                            $comprobante_pago = ComprobantesPagos::find($comprobante_pago->id);
                            $comprobante_pago->fecha_registro = $pago_reg_3->fechas_input;
                            $comprobante_pago->save();
                            $comprobante_pago_reg = ComprobantesPagosRegistros::find($comprobante_pago_reg->id);
                            $comprobante_pago_reg->fecha_pago = $pago_reg_3->fechas_input;
                            $comprobante_pago_reg->save();
                            break;
                        case '4':
                            #Transferencia
                            if ($request->hasFile('cheque_file')) {
                                $file = $request->file('cheque_file'); 
                                $name_file = time() . $file->getClientOriginalName();
                                $destino = public_path('archivos/pagos_sistema/');
                                $file->move($destino, $name_file);
                            } else {
                                $name_file = null;
                            }
            
                            $pago_reg_4 = new ComprobantesPagosDetalle();
                            $pago_reg_4->comprobante_pago_id = $comprobante_pago->id;
                            $pago_reg_4->comprobante_pago_reg_id = $comprobante_pago_reg->id;
                            $pago_reg_4->tipo_pago = "transferencia";
                            $pago_reg_4->persona_input = $request->get('transferencia_titular');
                            $pago_reg_4->fechas_input = $request->get('transferencia_fecha');
                            $pago_reg_4->file_input = $name_file;
                            $pago_reg_4->notas_adicionales = $request->get('notas_adicionales');
                            $pago_reg_4->save();
                            $comprobante_pago = ComprobantesPagos::find($comprobante_pago->id);
                            $comprobante_pago->fecha_registro = $pago_reg_4->fechas_input;
                            $comprobante_pago->save();
                            $comprobante_pago_reg = ComprobantesPagosRegistros::find($comprobante_pago_reg->id);
                            $comprobante_pago_reg->fecha_pago = $pago_reg_4->fechas_input;
                            $comprobante_pago_reg->save();
                            break;
                    }
                }
                
            }
            //FALTA VERIFICAR SI TODAS LAS CUOTAS HAN SIDO PASADAS A PAGO TOTAL?
            $factura_estado = Facturacion::where('id',$fc_comp)->first();
            if($factura_estado->forma_pago_id == 1){
                $factura_estado->estado_pago = 2;
                $factura_estado->save();
            }
        }
 

        
        // return $comprobante_pago_reg;
        // return $request->get('tot_cuotas')[0];
        // crear tabla para el registro de estos datos, asignar tipo de doc, id doc, motno y campos que se le entran
        // return $request;

        return redirect()->back();
    }

    // public function store_individual)_
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function view_mora()
    {
        $facturas_sp = Facturacion::orderByDesc('id')->get();
        // Esto de CUOTAS 0 SIN PAGAR 1 PAGADO
        $cuotas_all = Cuotas_credito::where('facturacion_id', '!=', null)->get();
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $monedas = Moneda::get();
        $igv = Igv::first();
        // if (!isset($facturas_sp)) {
            foreach ($facturas_sp as $key => $f_sp) {
                $cuotas[$key] = Cuotas_credito::where('facturacion_id', $f_sp->id)->count();
                $client_id[$key] = $f_sp->cliente_id;
            }
        // }else{
            $cuotas = [];
            // $client_id = $f_sp->id;
        // }
        $tipo_cambio = TipoCambio::latest('created_at')->first();       // return $fecha_hoy;
        
        
        
        $clientes =  Cliente::whereIn('id', $client_id)->get();
        // return $clientes;
        foreach($clientes as $kry => $client){
            // BUSCAR FACTURAS POR CLIENTE
            $count_tot = Facturacion::where('cliente_id',$client->id)->count();
            $client['cantidad_fact'] = $count_tot;
            //pagadas
            $facturas = Facturacion::where('cliente_id',$client->id)->where('forma_pago_id',2)->get();
            if (count($facturas) > 0) {
                foreach ($facturas as $key => $f_sp) {
                    $cuota_lopp = Cuotas_credito::where('facturacion_id', $f_sp->id)->where('estado', 1)->get();
                    if(count($cuota_lopp) > 0){
                        $cuot[$key] = $cuota_lopp;
                    }    
                }
                $client['cuotas'] = $cuot;
            }else{
                $client['cuotas'] = 0;
            }
        }
        // return $clientes;



        return view('cobranzas.cuotas.index', compact('facturas_sp', 'cuotas', 'cuotas_all','fecha_hoy','monedas','tipo_cambio','clientes','igv'));
    }

    public function edit_mora($id)
    {
        // POR AHORA EL ID ES EL CODIGO DE FACTURA
        $cod_fact = $id;
        $factura = Facturacion::where('codigo_fac', $id)->first();
        $fact_cuotas = Cuotas_credito::where('facturacion_id', $factura->id)->get();
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $pagos = ComprobantesPagos::where('factuacion_id', $factura->id)->get();
        if (count($pagos) != 0) {
            foreach ($pagos as $key => $pagos_ind) {
                $pagos_reg_a = ComprobantesPagosRegistros::where('comprobante_pago_id', $pagos_ind->id)->get();
                $ids[] = $pagos_ind->id;
            }
            $pagos_reg = ComprobantesPagosRegistros::whereIn('comprobante_pago_id',$ids)->get();
            $pagos_deta = ComprobantesPagosDetalle::whereIn('comprobante_pago_id',$ids)->get();

        } else {
            $pagos_reg = [];
            $pagos_deta = [];
        }
        // return $pagos_reg;
        // return $reg_b->where('estado',1)->sum('monto');
        // return $pagos_deta;
        return view('cobranzas.cuotas.edit', compact('cod_fact', 'factura', 'fact_cuotas', 'fecha_hoy', 'pagos', 'pagos_reg', 'pagos_deta'));
    }
    public function show_cliente($ruc_cli){
        $ruc = $ruc_cli;
        $cliente = Cliente::where('numero_documento', $ruc)->first();
        $facturas = Facturacion::where('cliente_id',$cliente->id)->get();
        $cuotas_all = Cuotas_credito::where('facturacion_id', '!=', null)->get();
        $start_mes = Carbon::now()->startOfMonth()->format('m/d/Y');
        $end_mes = Carbon::now()->endOfMonth()->format('m/d/Y');;
        $igv = Igv::first();

        // Pagados en el mes conversion de Monedas
        foreach ($facturas as $key => $fact) {
            $subtotal = $fact->op_gravada + $fact->op_inafecta + $fact->op_exonerada;
            $total = $subtotal + ($fact->op_gravada * ($igv->renta / 100));
            if($fact->moneda->nombre == 'soles'){
                $soles[] =  $total;
                $dolares[] = $total * $fact->cambio;
            }else{
                $dolares[] = $total;
                $soles[] = $total / $fact->cambio;
            }
        }
        $tot_sol = array_sum($soles);
        $tot_dol = array_sum($dolares);
        
        $moneda_sol = Moneda::where('nombre','soles')->first();
        $moneda_dol = Moneda::where('nombre','Dolares')->first();

        $star_month = Carbon::now()->startOfMonth();
        $end_month = Carbon::now()->endOfMonth();
        $fact_mes = Facturacion::where('cliente_id',$cliente->id)->whereBetween('created_at',[$star_month,$end_month])->get();
        foreach ($fact_mes as $key => $fact_m) {
            $subtotal = $fact_m->op_gravada + $fact_m->op_inafecta + $fact_m->op_exonerada;
            $total = $subtotal + ($fact_m->op_gravada * ($igv->renta / 100));
            if($fact_m->moneda->nombre == 'soles'){
                $soles_m[] =  $total;
                $dolares_m[] = $total * $fact_m->cambio;
            }else{
                $dolares[] = $total;
                $soles_m[] = $total / $fact_m->cambio;
            }
        }
        $tot_sol_m = array_sum($soles_m);
        $tot_dol_m = array_sum($dolares_m);
        // return $fact_mes;

        // PAGOS EN DEUDA
        $fact_sin = Facturacion::where('cliente_id',$cliente->id)->where('estado_pago', '!=', 2)->get();
        foreach ($fact_sin as $key => $fact_s) {
            $subtotal = $fact_s->op_gravada + $fact_s->op_inafecta + $fact_s->op_exonerada;
            $total = $subtotal + ($fact_s->op_gravada * ($igv->renta / 100));
            if($fact_s->moneda->nombre == 'soles'){
                $soles_s_p[] =  round($total,2);
            }else{
                $soles_s_p[] = round($total / $fact_s->cambio,2);
            }
        }
        // return $soles_s_p;
        $tot_sol_sp = array_sum($soles_s_p);
        return view('cobranzas.cuotas.clientes',compact('ruc','cliente','facturas','cuotas_all','start_mes','end_mes','igv','tot_dol','tot_sol','moneda_sol','moneda_dol','fact_mes','tot_sol_m','fact_sin','tot_sol_sp'));
    }
    public function show_cuotas(Request $request)
    {
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
                $array_lote .= "<li>Cuota N °".$pg_ani->cuota_credito->numero_cuota."</li>";
            }
        }else{
            $array_lote .= "";
        }
        $end_html = "";
        $end_html .= "
            <ul class='nav nav-tabs'>
            " . $nav_head ."
            </ul>
            " . $val_html;
        if(count($pagos_anidados) > 1){
            $end_html .= "
                    <div style='margin: 10px 15% 10px 24%'>
                        <p><strong>Esta cuota se pagó en Lote junto con:</strong></p>
                        ".$array_lote."
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
    public function print_cuotas(Request $request,$id)
    {
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $factura = Facturacion::where('id', $id)->first();
        $fact_cuotas = Cuotas_credito::where('facturacion_id', $factura->id)->get();
        
        $pagos = ComprobantesPagos::where('factuacion_id', $factura->id)->get();
        $empresa = Empresa::first();
        if (count($pagos) != 0) {
            foreach ($pagos as $key => $pagos_ind) {
                $pagos_reg_a = ComprobantesPagosRegistros::where('comprobante_pago_id', $pagos_ind->id)->get();
                $ids[] = $pagos_ind->id;
            }
            $pagos_reg = ComprobantesPagosRegistros::whereIn('comprobante_pago_id',$ids)->get();
            $pagos_deta = ComprobantesPagosDetalle::whereIn('comprobante_pago_id',$ids)->get();

        } else {
            $pagos_reg = [];
            $pagos_deta = [];
        }
        // return $pagos_reg;
        // $cuotas = Cuotas_credito::where('facturacion_id', $factura->id)->get();
        return view('cobranzas.cuotas.print',compact('empresa','factura','fact_cuotas','pagos_reg','pagos','fecha_hoy'));
                
    }
}
