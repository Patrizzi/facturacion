<?php

namespace App\Http\Controllers;

use App\CreditosAdelantos;
use App\Cuotas_credito;
use App\Facturacion_m;
use App\Igv;
use Illuminate\Http\Request;

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
        if ($factura->forma_pago_id == 2) {
            $cuotas = Cuotas_credito::where('facturacion_m_id', $factura->id)->get(); //* Codicional el estado de los cuales falta pagar 
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
            $pago_tot = round($subtotal + ($factura->op_gravada * $igv->renta) / 100, 2);

            $array_cuot[0] = array(
                'id_cuota' => '1',
                'cuota_n' => '1',
                'monto' => $pago_tot,
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
        return $request;    

        //* cambios en cuotas y creditos cuotas

        //guardado cabecera

    
        //guardado  registros
    }

    public function store(Request $request)
    {
        //
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
}
