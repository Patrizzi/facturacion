<?php

namespace App\Http\Controllers;

use App\Cotizacion;
use App\CotizacionManual;
use App\Igv;
use App\NotaVenta;
use App\NotaVentaRegistro;
use App\Ventas_registro;
use Carbon\Carbon;
use Illuminate\Http\Request;

class Ventas_registroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {}

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
        //
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
    public function destroy($id) {}


    public function cotizacion_tab(Request $request)
    {
        $igv = Igv::first();

        // Verificamos si es una solicitud Ajax
        // if ($request->ajax()) {
        //     // Obtenemos el rango de fechas seleccionado
        //     $startDate = Carbon::createFromFormat('m/d/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        //     $endDate = Carbon::createFromFormat('m/d/Y', explode(' - ', $request->daterange)[1])->endOfDay();

        //     // Filtramos las cotizaciones por el rango de fechas
        //     $cotizacion = Cotizacion::whereBetween('created_at', [$startDate, $endDate])->get();

        //     return response()->json([
        //         'data' => $cotizacion
        //     ]);
        // }

        // Si no es una solicitud Ajax, cargamos las cotizaciones del mes actual
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        
        $cotizacion = Cotizacion::whereBetween('created_at', [$startDate, $endDate])->get();
        return view('transaccion.venta._shared.cotizacion', compact('cotizacion', 'igv'));
    }
    public function cotizacion_registers(Request $request)
    {
        $startDate = Carbon::createFromFormat('m/d/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('m/d/Y', explode(' - ', $request->daterange)[1])->endOfDay();

        // Filtramos las cotizaciones por el rango de fechas
        $cotizacion = Cotizacion::whereBetween('created_at', [$startDate, $endDate])->get();

        return response()->json([
            'data' => $cotizacion
        ]);
    }

    public function cotizacion_manual_tab()
    {
        $cotizacion_m = CotizacionManual::get();
        $igv = Igv::first();
        return view('transaccion.venta._shared.cotizacion_manual', compact('cotizacion_m', 'igv'));
    }

    public function nota_venta_tab()
    {
        $nota_venta = NotaVenta::all();
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
        $igv = Igv::first();
        return view('transaccion.venta._shared.nota_venta', compact('nota_venta', 'totales', 'igv'));
    }
}
