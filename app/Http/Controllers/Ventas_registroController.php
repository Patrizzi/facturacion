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

    }
    //* DATA DE DATATABLES
    public function cotizacion_registers(Request $request)
    {
        //* DATOS PARA PASAR CON AJAX

        // DATA REQUEST
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        // DATA DE DB
        $igv = Igv::first()->renta;
        // FILTRADO
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'cotizaciones.id',
            2 => 'cotizaciones.cod_cotizacion',
            3 => 'cotizaciones.cliente.nombre',
            4 => 'cotizaciones.cliente.numero_documento',
            5 => 'cotizaciones.fecha_emision',
            6 => 'cotizaciones.forma_pago',
        ];

        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();
        $tipo = $request->tipo_coti;

        $query = Cotizacion::with(['cliente', 'moneda', 'forma_pago'])
            ->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        if (!empty($filter)) {
            // Agrupar las condiciones de búsqueda en una única cláusula where
            $query->where(function($q) use ($filter) {
                $q->where('cod_cotizacion', 'like', '%' . $filter . '%');
                $q->orWhereHas('cliente', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });
                $q->orWhere('fecha_emision', 'like', '%' . $filter . '%');
                $q->orWhereHas('forma_pago', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%');
                });
            });
        }
        
        if ($tipo !== null) {
            $query->where('tipo', $tipo);
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $cotizaciones = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];
        $cotizaciones->transform(function ($cotizacion) use ($igv) {
            $subtotal = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;

            if ($cotizacion->moneda_id == 2) {
                $total = round($subtotal + ($cotizacion->op_gravada * $igv) / 100, 2);
                $cotizacion->total_conv = $total * $cotizacion->cambio;
            } else {
                $total = round($subtotal + ($cotizacion->op_gravada * $igv) / 100, 2);
                $cotizacion->total_conv = $total;
            }
            $cotizacion->total = 'S/.' . number_format($cotizacion->total_conv, 2);
            $cotizacion->emision = Carbon::parse($cotizacion->created_at)->format('d-m-Y');
            $cotizacion->estado_proceso = Cotizacion::estado_proceso($cotizacion->id);
            return $cotizacion;
        });
        
        $total_columna = 0;
        // Bucle de llamada para el llenado del datatable
        foreach ($cotizaciones as $cotizacion) {
            $total_columna += $cotizacion->total_conv;
            $json['data'][] = [
                $cotizacion->id,
                $cotizacion->id,
                $cotizacion->cod_cotizacion,
                $cotizacion->cliente->numero_documento,
                $cotizacion->cliente->nombre,
                $cotizacion->fecha_emision,
                $cotizacion->forma_pago->nombre,
                $cotizacion->total,
                $cotizacion->id,
                $cotizacion->estado
            ];
        }
        // Llamado para la suma total
        $total_table = Cotizacion::total_sum_datatable($request, $startDate, $endDate);
        $json['total_columna'] = "S/. ".number_format($total_columna, 2);
        $json['total_table'] = "S/. ".number_format($total_table, 2) ;
        return response()->json($json);
    }

    public function cotizacion_manual_tab()
    {
        $cotizacion_m = CotizacionManual::get();
        $igv = Igv::first();
        return view('transaccion.venta._shared.cotizacion_manual', compact('cotizacion_m', 'igv'));
    }

    public function cotizacion_manual_registers(){

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
