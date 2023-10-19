<?php

namespace App\Http\Controllers;

use App\ComprobantesPagos;
use App\ComprobantesPagosDetalle;
use App\ComprobantesPagosRegistros;
use App\Cuotas_credito;
use App\Facturacion;
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
        return view('cobranzas.cobros.index', compact('facturas', 'cuotas', 'fecha_hoy', 'monedas', 'tipo_cambio'));
    }
    public function lista_ajax(Request $request)
    {
        // return $request->ids_facturas;
        $count_ids = count($request->ids_facturas);

        if ($count_ids > 0) {
            for ($i = 0; $i < $count_ids; $i++) {
                $var[] = $request->ids_facturas[$i];
            }
        }
        $facturas = Facturacion::WhereIn('id', $var)->get();
        foreach ($facturas as $key => $factura) {
            // $array_cuot = [];
            $cuotas = Cuotas_credito::where('facturacion_id', $factura->id)->get(); //* Codicional el estado de los cuales falta pagar 
            foreach ($cuotas as $llave => $cuota) {
                $array_cuot[$llave] = array(
                    'id_cuota' => $cuota->id,
                    'cuota_n' => $cuota->numero_cuota,
                    'monto' => $cuota->monto,
                    'fecha_pago' => $cuota->fecha_pago,
                    'estado' =>  null
                );
            }

            $array_end[$key] = array(
                'factura_cod' => $factura->codigo_fac,
                'cliente_doc' => $factura->cliente->numero_documento,
                'cliente_nombre' => $factura->cliente->nombre,
                'factura_moneda' => $factura->moneda->nombre,
                'factura_simbolo' => $factura->moneda->simbolo,
                'total_factura' => round($cuotas->sum('monto'),2),
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
        $comprobante_pago = new ComprobantesPagos();
        $comprobante_pago->tipo_doc = 'factura';
        $comprobante_pago->factuacion_id = $request->get('id_factura') ;
        // $comprobante_pago->factuacion_m_id ;
        // $comprobante_pago->boleta_id ;
        // $comprobante_pago->boleta_m_id ;
        $comprobante_pago->tipo_pago = $tipo_pago_txt ;
        
        // $comprobante_pago->fecha_registro =  ;
        $comprobante_pago->save();
        
        foreach ($n_fact_s as $key => $value) {
            $cuotas_pre = $request->get('cuotas_precio_'.$value);
            foreach ($cuotas_pre as $key2 => $value2) {
                $monto_cuota = explode('_',$value2);
                $couta = Cuotas_credito::where('id',$monto_cuota[0])->first();
                // return $request;
                $couta->estado = 1;
                $couta->save();
            }
            // AGREGAR A LA NUEVA TABLA LOS REGISTROS?
            $comprobante_pago_reg = new ComprobantesPagosRegistros();
            $comprobante_pago_reg->comprobante_pago_id = $comprobante_pago->id;
            $comprobante_pago_reg->id_cuota_credito = $request->get('id_cuota');
            $comprobante_pago_reg->monto_total = $request->get('tot_cuotas')[$key];
            $comprobante_pago_reg->monto_pago = $request->get('tot_cuotas')[$key];
            // $comprobante_pago_reg->fecha_pago = $request->get('');
            $comprobante_pago_reg->save();

            $comprobante_pago = ComprobantesPagos::find($comprobante_pago->id);
            $comprobante_pago->monto_tot = $request->get('tot_cuotas')[$key];
            $comprobante_pago->monto_pago = $request->get('tot_cuotas')[$key];
            $comprobante_pago->save();
        }
        
        // crear tabla para el registro de estos datos, asignar tipo de doc, id doc, motno y campos que se le entran
        // return $request;

        switch ($tipo_pag) {
            case '1': 
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
                $pago_reg_1->file_input = $request->get('cheque_file');
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
                $pago_reg_2 = new ComprobantesPagosDetalle();
                $pago_reg_2->comprobante_pago_id = $comprobante_pago->id;
                $pago_reg_2->comprobante_pago_reg_id = $comprobante_pago_reg->id;
                $pago_reg_2->tipo_pago = "tarjeta";
                $pago_reg_2->persona_input = $request->get('tarjeta_titular');
                $pago_reg_2->bancos_input = $request->get('tarjeta_banco');
                $pago_reg_2->fechas_input = $request->get('tarjeta_fecha');
                $pago_reg_2->file_input = $request->get('tarjeta_file');
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
                $pago_reg_3->persona_input = $request->get('persona_efectivo');
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
                $pago_reg_4 = new ComprobantesPagosDetalle();
                $pago_reg_4->comprobante_pago_id = $comprobante_pago->id;
                $pago_reg_4->comprobante_pago_reg_id = $comprobante_pago_reg->id;
                $pago_reg_4->tipo_pago = "transferencia";
                $pago_reg_4->persona_input = $request->get('transferencia_titular');
                $pago_reg_4->fechas_input = $request->get('transferencia_fecha');
                $pago_reg_4->file_input = $request->get('transferencia_comprobante');
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

    public function view_mora(){
        $facturas_sp = Facturacion::where('forma_pago_id',2)->get();
        // Esto de CUOTAS 0 SIN PAGAR 1 PAGADO
        $cuotas_all = Cuotas_credito::where('facturacion_id', '!=', null)->get();
        foreach ($facturas_sp as $key => $f_sp) {
            $cuotas[$key] = Cuotas_credito::where('facturacion_id',$f_sp->id)->count();
        }
        // return $cuotas[0];
        // $facturas_mora = Facturacion::all();
        return view('cobranzas.cuotas.index',compact('facturas_sp','cuotas','cuotas_all'));
    }

    public function edit_mora($id){
        // POR AHORA EL ID ES EL CODIGO DE FACTURA
        $cod_fact = $id;
        $factura = Facturacion::where('codigo_fac', $id)->first();
        $fact_cuotas = Cuotas_credito::where('facturacion_id',$factura->id)->get();
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        $pagos = ComprobantesPagos::where('factuacion_id', $factura->id)->get();
        if (count($pagos) != 0) {
            foreach ($pagos as $key => $pagos_ind) {
                $pagos_reg = ComprobantesPagosRegistros::where('comprobante_pago_id', $pagos_ind->id)->get();
                $pagos_deta = ComprobantesPagosDetalle::where('comprobante_pago_id', $pagos_ind->id)->get();
            }
        }else{
            $pagos_reg = [];
            $pagos_deta = [];
        }
        // return $pagos;
        return view('cobranzas.cuotas.edit',compact('cod_fact','factura','fact_cuotas','fecha_hoy','pagos','pagos_reg','pagos_deta'));
    }
    public function show_cuotas(Request $request){
        $n_cuota = $request->data;
        $cuotas = Cuotas_credito::where('id', $n_cuota)->first();
        // return $cuotas;
        $pagos = ComprobantesPagosRegistros::where('id_cuota_credito', $cuotas->id)->get();
        foreach ($pagos as $key => $pagos_ind) {
            $pagos_deta = ComprobantesPagosDetalle::where('comprobante_pago_reg_id', $pagos_ind->id)->get();
        }
        return $pagos;
    }
}
