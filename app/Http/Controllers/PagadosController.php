<?php

namespace App\Http\Controllers;

use App\Cuotas_credito;
use App\Facturacion;
use App\Moneda;
use App\TipoCambio;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        return $request;
        // CUOTAS DE DB cambio de estado? // agregar estado en columna de cuotas_Credito
        // Obtencion de las facturas seleccionadas
        $n_fact_s = $request->get('numero_factura');
        foreach ($n_fact_s as $key => $value) {
            $cuotas_pre = $request->get('cuotas_precio_'.$value);
            foreach ($cuotas_pre as $key2 => $value2) {
                $monto_cuota = explode('_',$value2);
                $couta = Cuotas_credito::where('id',$monto_cuota[0])->first();
                // $couta->estado = 1;
                // $couta->save();
            }
            // AGREGAR A LA NUEVA TABLA LOS REGISTROS?


        }
        return $couta;
        // crear tabla para el registro de estos datos, asignar tipo de doc, id doc, motno y campos que se le entran
        return $request;

        switch ($tipo_pag) {
            case '1': #CHEQUE
                // $pago_reg_1 = new DB();
                // $pago_reg_1-> = $request->get('cheque_name');
                // $pago_reg_1-> = $request->get('cheque_fecha_cobro');
                // $pago_reg_1-> = $request->get('cheque_banco_emisor');
                // $pago_reg_1-> = $request->get('cheque_beneficiario');
                // $pago_reg_1-> = $request->get('cheque_monto');
                // $pago_reg_1-> = $request->get('cheque_n_cuenta');
                // $pago_reg_1-> = $request->get('cheque_file');
                // $pago_reg_1-> = $request->get('notas_adicionales');
                // $pago_reg_1->save();
                break;
            case '2': #TARJETA
                // $pago_reg_2 = new DB();
                // $pago_reg_2-> = $request->get('tarjeta_titular');
                // $pago_reg_2-> = $request->get('tarjeta_banco');
                // $pago_reg_2-> = $request->get('tarjeta_file');
                // $pago_reg_2-> = $request->get('notas_adicionales');
                // $pago_reg_2->save();
                break;
            case '3': #EFECTIVO
                // $pago_reg_3 = new DB();
                // $pago_reg_3-> = $request->get('persona_efectivo');
                // $pago_reg_3-> = $request->get('fecha_efectivo');
                // $pago_reg_3-> = $request->get('monto_pago_efectivo');
                // $pago_reg_3-> = $request->get('monto_vuelto');
                // $pago_reg_3-> = $request->get('notas_adicionales');
                // $pago_reg_3->save();
                break;
            case '4': #Transferencia
                // $pago_reg_4 = new DB();
                // $pago_reg_4-> = $request->get('transferencia_titular');
                // $pago_reg_4-> = $request->get('transferencia_fecha');
                // $pago_reg_4-> = $request->get('transferencia_comprobante');
                // $pago_reg_4-> = $request->get('notas_adicionales');
                // $pago_reg_4->save();
                break;
        }
    }

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
}
