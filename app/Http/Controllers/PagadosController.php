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
        $facturas = Facturacion::where('forma_pago_id',2)->get();
        $cuotas = Cuotas_credito::where('facturacion_id','!=',null)->get();
        // return $cuotas->where('facturacion_id','323')->count();
        $fecha_hoy = Carbon::now()->format('Y-m-d');
        // return $fecha_hoy;
        $monedas = Moneda::get();
        $tipo_cambio=TipoCambio::latest('created_at')->first();       // return $fecha_hoy;
        return view('cobranzas.cobros.index',compact('facturas','cuotas','fecha_hoy','monedas','tipo_cambio'));
    }
    public function lista_ajax(Request $request){
        // return $request->ids_facturas;
        $count_ids = count($request->ids_facturas);
        
        if($count_ids > 0){
            for ($i=0; $i < $count_ids; $i++) { 
                $var[] = $request->ids_facturas[$i];
            }
        }
        $facturas = Facturacion::WhereIn('id',$var)->get();
        foreach ($facturas as $key => $factura) {
            // $array_cuot = [];
            $cuotas = Cuotas_credito::where('facturacion_id', $factura->id)->get(); //* Codicional el estado de los cuales falta pagar 
            foreach ($cuotas as $llave => $cuota) {
                $array_cuot[$llave] = array(
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
                'total_factura' => $cuotas->sum('monto'),
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
        return $request;
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
