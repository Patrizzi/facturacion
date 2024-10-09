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
        $startDate = Carbon::createFromFormat('m/d/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('m/d/Y', explode(' - ', $request->daterange)[1])->endOfDay();
        $tipo = $request->tipo_coti;
        // Datos 
        $igv = Igv::first()->renta;

        if ($tipo == null) {
            $cotizaciones = Cotizacion::whereBetween('created_at', [$startDate, $endDate])->with(['cliente', 'moneda', 'forma_pago'])->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $cotizaciones = Cotizacion::whereBetween('created_at', [$startDate, $endDate])->where('tipo', $tipo)->with(['cliente', 'moneda', 'forma_pago'])->orderBy('created_at', 'desc')->paginate(10);
        }
        // Formatear los datos con los cálculos necesarios
        $cotizaciones->getCollection()->transform(function ($cotizacion) use ($igv) {
            // Cálculo del subtotal
            $subtotal = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;

            // Cálculo del total según el tipo de moneda
            if ($cotizacion->moneda_id == 2) { // Si la moneda es dólares
                $total = round($subtotal + ($cotizacion->op_gravada * $igv) / 100, 2);
                $cotizacion->total_conv = $total * $cotizacion->cambio; // Conversión a la moneda local
            } else {
                $total = round($subtotal + ($cotizacion->op_gravada * $igv) / 100, 2);
                $cotizacion->total_conv = $total; // Total en moneda local
            }
            $cotizacion->emision = Carbon::parse($cotizacion->created_at)->format('d-m-Y');
            // Añade el valor del total al objeto cotizacion
            $cotizacion->total = $cotizacion->moneda->simbolo . ' ' . number_format($cotizacion->total_conv, 2);

            $estado_proceso = Cotizacion::estado_proceso($cotizacion->id);
            $cotizacion->estado_proceso = $estado_proceso;
            // Retorna converido la variable para el getcollection
            return $cotizacion;
        });


        return view('transaccion.venta._shared.cotizacion', compact('cotizaciones', 'igv'));
    }
    public function cotizacion_registers(Request $request)
    {
        // DATA REQUEST
        $search = $request->query('search', array('value' => '', 'regex' => false));
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        // DATA DE DB
        $igv = Igv::first()->renta;
        // FILTRADO
        $filter = $search['value'];
        $sortColumns = [
            0 => 'id', // Ajusta los campos según tus columnas
            1 => 'cotizaciones.created_at',
            2 => 'cotizaciones.total_conv',
        ];

        
        $startDate = Carbon::createFromFormat('m/d/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('m/d/Y', explode(' - ', $request->daterange)[1])->endOfDay();
        $tipo = $request->tipo_coti;

        $query = Cotizacion::with(['cliente', 'moneda', 'forma_pago'])
            ->whereBetween('created_at', [$startDate, $endDate]);

        if (!empty($filter)) {
            $query->whereHas('cliente', function ($q) use ($filter) {
                $q->where('nombre', 'like', '%' . $filter . '%');
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

            $cotizacion->total = $cotizacion->moneda->simbolo . ' ' . number_format($cotizacion->total_conv, 2);
            $cotizacion->emision = Carbon::parse($cotizacion->created_at)->format('d-m-Y');
            $cotizacion->estado_proceso = Cotizacion::estado_proceso($cotizacion->id);
            return $cotizacion;
        });

        foreach ($cotizaciones as $cotizacion) {
            $json['data'][] = [
                $cotizacion->id,
                $cotizacion->id,
                $cotizacion->cod_cotizacion,
                $cotizacion->cliente->nombre,
                $cotizacion->cliente->numero_documento,
                $cotizacion->forma_pago->nombre,
                $cotizacion->fecha_emision,
                $cotizacion->total,
                $cotizacion->id
            ];
        }

        return response()->json($json);
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
