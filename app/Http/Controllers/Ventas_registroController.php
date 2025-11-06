<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Cotizacion;
use App\CotizacionManual;
use App\Igv;
use App\Moneda;
use App\NotaVenta;
use App\NotaVentaRegistro;
use App\Ventas_registro;
use App\RenovacionServicios;

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


    public function cotizacion_tab(Request $request) {}
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
        $moneda_principal = Moneda::where('principal', 1)->first();
        // FILTRADO
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'cod_cotizacion',
            3 => 'cliente.nombre',
            4 => 'cliente.numero_documento',
            5 => 'fecha_emision',
            6 => 'forma_pago.nombre',
            7 => 'total_conv',
        ];

// Manejo seguro del rango de fechas
if ($request->filled('daterange')) {
    [$from, $to] = explode(' - ', $request->daterange);
    $startDate = Carbon::createFromFormat('d/m/Y', trim($from))->startOfDay();
    $endDate   = Carbon::createFromFormat('d/m/Y', trim($to))->endOfDay();
} else {
    // Si no hay rango, usar el mes actual
    $startDate = Carbon::now()->startOfMonth()->startOfDay();
    $endDate   = Carbon::now()->endOfMonth()->endOfDay();
}

        $tipo = $request->tipo_coti;

        $query = Cotizacion::with(['cliente', 'moneda', 'forma_pago'])
            ->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        if (!empty($filter)) {
            // Agrupar las condiciones de búsqueda en una única cláusula where
            $query->where(function ($q) use ($filter) {
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
        //codigo agregado:
        // ** INICIO - AGREGADO PARA FUNCIONALIDAD DE CHECKBOX MÚLTIPLE **
        // Si se requieren todos los registros (length = -1), no aplicar paginación
        if ($length == -1) {
            $cotizaciones = $query->get();
        } else {
            $sortColumnName = $sortColumns[$order[0]['column']];
            $query->orderBy($sortColumnName, $order[0]['dir'])
                ->take($length)
                ->skip($start);
            $cotizaciones = $query->get();
        }
        // codigo quitado:
        // $sortColumnName = $sortColumns[$order[0]['column']];
        // $query->orderBy($sortColumnName, $order[0]['dir'])
        //     ->take($length)
        //     ->skip($start);

        $cotizaciones = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];
        $cotizaciones->transform(function ($cotizacion) use ($igv) {
            $subtotal = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;

            $total = round($subtotal + ($cotizacion->op_gravada * $igv) / 100, 2);

            // SEPARACION PARA EL TOTAL EN UNA SOLA MONEDA
            $cotizacion->total_conv = Ventas_registro::moneda_principal_convert($cotizacion->moneda_id, $total);

            $cotizacion->total = $cotizacion->moneda->simbolo . number_format($total, 2); //total para la columna de la tabla
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
        $json['total_columna'] = $moneda_principal->simbolo . number_format($total_columna, 2);
        $json['total_table'] = $moneda_principal->simbolo . number_format($total_table, 2);
        return response()->json($json);
    }

    public function cotizacion_manual_tab()
    {
        // $cotizacion_m = CotizacionManual::get();
        // $igv = Igv::first();
        // return view('transaccion.venta._shared.cotizacion_manual', compact('cotizacion_m', 'igv'));
    }

    public function cotizacion_manual_registers(Request $request)
    {
        //* DATOS PARA PASAR CON AJAX

        // DATA REQUEST
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        // DATA DE DB
        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();
        // FILTRADO
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'cotizaciones_manual.id',
            2 => 'cotizaciones_manual.cod_cotizacion',
            3 => 'cotizaciones_manual.cliente.nombre',
            4 => 'cotizaciones_manual.cliente.numero_documento',
            5 => 'cotizaciones_manual.fecha_emision',
            6 => 'cotizaciones_manual.forma_pago',
        ];

        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();
        $tipo = $request->tipo_coti;

        $query = CotizacionManual::with(['cliente', 'moneda', 'forma_pago'])
            ->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        if (!empty($filter)) {
            // Agrupar las condiciones de búsqueda en una única cláusula where
            $query->where(function ($q) use ($filter) {
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
        //codigo agregado:
        // ** INICIO - AGREGADO PARA FUNCIONALIDAD DE CHECKBOX MÚLTIPLE **
        // Si se requieren todos los registros (length = -1), no aplicar paginación
        if ($length == -1) {
            $cotizaciones = $query->get();
        } else {
            $sortColumnName = $sortColumns[$order[0]['column']];
            $query->orderBy($sortColumnName, $order[0]['dir'])
                ->take($length)
                ->skip($start);
            $cotizaciones = $query->get();
        }
        // codigo quitado:
        // $sortColumnName = $sortColumns[$order[0]['column']];
        // $query->orderBy($sortColumnName, $order[0]['dir'])
        //     ->take($length)
        //     ->skip($start);

        $cotizaciones = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];
        $cotizaciones->transform(function ($cotizacion_manual) use ($igv) {
            $subtotal = $cotizacion_manual->op_gravada + $cotizacion_manual->op_inafecta + $cotizacion_manual->op_exonerada;

            $total = round($subtotal + ($cotizacion_manual->op_gravada * $igv) / 100, 2);

            // SEPARACION PARA EL TOTAL EN UNA SOLA MONEDA
            $cotizacion_manual->total_conv = Ventas_registro::moneda_principal_convert($cotizacion_manual->moneda_id, $total);

            $cotizacion_manual->total = $cotizacion_manual->moneda->simbolo . number_format($total, 2);
            $cotizacion_manual->emision = Carbon::parse($cotizacion_manual->created_at)->format('d-m-Y');
            $cotizacion_manual->estado_proceso = CotizacionManual::estado_proceso($cotizacion_manual->id);
            return $cotizacion_manual;
        });

        $total_columna = 0;
        // Bucle de llamada para el llenado del datatable
        foreach ($cotizaciones as $cotizacion_manual) {
            $total_columna += $cotizacion_manual->total_conv;
            $json['data'][] = [
                $cotizacion_manual->id,
                $cotizacion_manual->id,
                $cotizacion_manual->cod_cotizacion,
                $cotizacion_manual->cliente->numero_documento,
                $cotizacion_manual->cliente->nombre,
                $cotizacion_manual->fecha_emision,
                $cotizacion_manual->forma_pago->nombre,
                $cotizacion_manual->total,
                $cotizacion_manual->id,
                $cotizacion_manual->estado
            ];
        }
        // Llamado para la suma total
        $total_table = CotizacionManual::total_sum_datatable($request, $startDate, $endDate);
        $json['total_columna'] = $moneda_principal->simbolo . number_format($total_columna, 2);
        $json['total_table'] = $moneda_principal->simbolo . number_format($total_table, 2);
        return response()->json($json);
    }

public function renovacion_registers(Request $request)
{
    // DATA REQUEST
    $draw = $request->query('draw', 0);
    $start = $request->query('start', 0);
    $length = $request->query('length', 25);
    $order = $request->query('order', array(0, 'asc'));

    // DATA DE DB
    $igv = Igv::first()->renta;
    $moneda_principal = Moneda::where('principal', 1)->first();
    
    // FILTRADO
    $filter = $request->get('value');
    $sortColumns = [
        0 => 'id',
        1 => 'renovaciones_servicios.id',
        2 => 'renovaciones_servicios.cotizacion_manual_id',
        3 => 'renovaciones_servicios.created_at',
    ];

    if ($request->filled('daterange')) {
        [$from, $to] = explode(' - ', $request->daterange);
        $startDate = Carbon::createFromFormat('d/m/Y', trim($from))->startOfDay();
        $endDate   = Carbon::createFromFormat('d/m/Y', trim($to))->endOfDay();
    } else {
        $startDate = Carbon::now()->startOfMonth()->startOfDay();
        $endDate   = Carbon::now()->endOfMonth()->endOfDay();
    }
    
    $tipo = $request->tipo_renovacion;

    // QUERY PRINCIPAL
    $query = RenovacionServicios::with(['cotizacionManual.cliente', 'cotizacionManual.moneda', 'cotizacionManual.forma_pago'])
        ->whereHas('cotizacionManual')
        ->whereBetween('renovaciones_servicios.created_at', [$startDate, $endDate])
        ->orderBy('renovaciones_servicios.created_at', 'desc');

    // FILTROS
    if (!empty($filter)) {
        $query->where(function ($q) use ($filter) {
            $q->where('renovaciones_servicios.id', 'like', '%' . $filter . '%')
              ->orWhere('renovaciones_servicios.cotizacion_manual_id', 'like', '%' . $filter . '%');
            
            $q->orWhereHas('cotizacionManual', function ($q2) use ($filter) {
                $q2->where('cod_cotizacion', 'like', '%' . $filter . '%');
            });
            
            $q->orWhereHas('cotizacionManual.cliente', function ($q2) use ($filter) {
                $q2->where('nombre', 'like', '%' . $filter . '%')
                   ->orWhere('numero_documento', 'like', '%' . $filter . '%');
            });
            
            $q->orWhereHas('cotizacionManual.forma_pago', function ($q2) use ($filter) {
                $q2->where('nombre', 'like', '%' . $filter . '%');
            });
        });
    }

    if ($tipo !== null && $tipo !== '') {
        $query->whereHas('cotizacionManual', function($q) use ($tipo) {
            $q->where('tipo', $tipo);
        });
    }

    $recordsTotal = $query->count();
    
    // PAGINACIÓN CORRECTA (sin duplicación)
    if ($length == -1) {
        $renovaciones = $query->get();
    } else {
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);
        $renovaciones = $query->get();
    }

    $json = [
        'draw' => $draw,
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsTotal,
        'data' => [],
    ];
    
    $fecha_actual = Carbon::now();
    
    $renovaciones->transform(function ($renovacion) use ($igv, $fecha_actual) {
        $cotizacion_manual = $renovacion->cotizacionManual;
        
        if ($cotizacion_manual) {
            $subtotal = $cotizacion_manual->op_gravada + $cotizacion_manual->op_inafecta + $cotizacion_manual->op_exonerada;
            $total = round($subtotal + ($cotizacion_manual->op_gravada * $igv) / 100, 2);

            $renovacion->total_conv = Ventas_registro::moneda_principal_convert($cotizacion_manual->moneda_id, $total);
            $renovacion->total = $cotizacion_manual->moneda->simbolo . number_format($total, 2);
            $renovacion->emision = Carbon::parse($cotizacion_manual->created_at)->format('d-m-Y');
            $renovacion->estado_proceso = CotizacionManual::estado_proceso($cotizacion_manual->id);
            $renovacion->cotizacion_manual_data = $cotizacion_manual;
            
            // ===== CÁLCULO DE FECHA DE VENCIMIENTO Y TIEMPO DE VENCIMIENTO =====
            $fecha_emision = Carbon::parse($cotizacion_manual->fecha_emision);
            $fecha_vencimiento = null;
            $dias_texto = '-';

            if ($renovacion->frecuencia == 'Mensual' && $renovacion->dia_mensual) {
                $dias_acumulados = (int) $renovacion->dia_mensual;
                
                // CALCULAR DESDE LA FECHA DE EMISIÓN CON LOS DÍAS ACUMULADOS
                $fecha_vencimiento = $fecha_emision->copy()->addDays($dias_acumulados);
                
                // SI YA PASÓ, SEGUIR SUMANDO HASTA ENCONTRAR UNA FECHA FUTURA
                while ($fecha_vencimiento->isPast()) {
                    $fecha_vencimiento->addDays($dias_acumulados);
                }
                
            } elseif ($renovacion->frecuencia == 'Anual' && $renovacion->mes_anual) {
                $mes_vencimiento = (int) $renovacion->mes_anual;
                $anio_vencimiento = $renovacion->anio_anual ?? $fecha_actual->year;
                
                $fecha_vencimiento = Carbon::create($anio_vencimiento, $mes_vencimiento, 1)->endOfMonth();
                
                if ($fecha_vencimiento->isPast()) {
                    $fecha_vencimiento->addYear();
                }
            }

            // CALCULAR DÍAS RESTANTES
            if ($fecha_vencimiento) {
                $dias_diferencia = $fecha_actual->diffInDays($fecha_vencimiento, false);
                
                if ($dias_diferencia < 0) {
                    $dias_texto = abs($dias_diferencia) . ' días vencido';
                } elseif ($dias_diferencia == 0) {
                    $dias_texto = 'Vence hoy';
                } elseif ($dias_diferencia == 1){
                    $dias_texto = $dias_diferencia . ' día';
                } else {
                    $dias_texto = $dias_diferencia . ' días';
                }
            }

            $renovacion->fecha_vencimiento = $fecha_vencimiento;
            $renovacion->dias_vencimiento = $dias_texto;
            // ===== FIN CÁLCULO =====
            
        } else {
            $renovacion->total_conv = 0;
            $renovacion->total = '0.00';
            $renovacion->emision = '';
            $renovacion->estado_proceso = 0;
            $renovacion->cotizacion_manual_data = null;
            $renovacion->fecha_vencimiento = null;
            $renovacion->dias_vencimiento = '-';
        }
        
        return $renovacion;
    });
    $total_columna = 0;
    
    foreach ($renovaciones as $renovacion) {
        $total_columna += $renovacion->total_conv;
        
        $cotizacion_manual = $renovacion->cotizacion_manual_data;
        
        if ($cotizacion_manual) {
            $json['data'][] = [
                $renovacion->id,                                    // 0 - ID renovación
                $cotizacion_manual->id,                             // 1 - ID cotización
                $cotizacion_manual->cod_cotizacion,                 // 2 - N°
                $cotizacion_manual->cliente->numero_documento,      // 3 - RUC-DNI
                $cotizacion_manual->cliente->nombre,                // 4 - Cliente
                $cotizacion_manual->fecha_emision,                  // 5 - Fecha Emisión
                $renovacion->fecha_vencimiento 
                    ? $renovacion->fecha_vencimiento->format('d-m-Y') 
                    : '-',                                          // 6 - Fecha Vencimiento
                $renovacion->dias_vencimiento,                      // 7 - Tiempo Vencimiento
                $cotizacion_manual->forma_pago->nombre,             // 8 - Forma Pago
                $renovacion->total,                                 // 9 - Importe Total
                $renovacion->id,                                    // 10 - ID para acciones
                $cotizacion_manual->estado                          // 11 - Estado
            ];
        }
    }
    
    $total_table = RenovacionServicios::total_sum_datatable($request, $startDate, $endDate);
    
    $json['total_columna'] = $moneda_principal->simbolo . number_format($total_columna, 2);
    $json['total_table'] = $moneda_principal->simbolo . number_format($total_table, 2);
    
    return response()->json($json);
}
    public function nota_venta_tab()
    {
        // $nota_venta = NotaVenta::all();
        // $totales = [];
        // foreach ($nota_venta as $index =>  $nota_ventas) {
        //     $total = 0;
        //     $suma = 0;
        //     $nota_venta_reg = NotaVentaRegistro::where('nota_venta_id', $nota_ventas->id)->get();
        //     foreach ($nota_venta_reg as $nota_venta_regs) {
        //         $total += $nota_venta_regs->precio_nacional * $nota_venta_regs->cantidad;
        //     }
        //     $suma += $total;
        //     $totales[$index] = $suma;
        // }
        // $igv = Igv::first();
        // return view('transaccion.venta._shared.nota_venta', compact('nota_venta', 'totales', 'igv'));
    }

    public function nota_venta_registers(Request $request)
    {

        //* DATOS PARA PASAR CON AJAX

        // DATA REQUEST
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        // DATA DE DB
        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();
        // FILTRADO
        $filter = $request->get('value');
        $cliente = $request->get('cliente_id');
        $sortColumns = [
            0 => 'id',
            1 => 'cotizaciones_manual.id',
            2 => 'cotizaciones_manual.cod_cotizacion',
            3 => 'cotizaciones_manual.cliente.nombre',
            4 => 'cotizaciones_manual.cliente.numero_documento',
            5 => 'cotizaciones_manual.fecha_emision',
            6 => 'cotizaciones_manual.forma_pago',
        ];

        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();
        $tipo = $request->tipo_coti;

        $query = NotaVenta::with(['cliente', 'moneda'])
            ->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        if (!empty($filter)) {
            // Agrupar las condiciones de búsqueda en una única cláusula where
            $query->where(function ($q) use ($filter) {
                $q->where('cod_nota_venta', 'like', '%' . $filter . '%');
                $q->orWhereHas('cliente', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });
                $q->orWhere('fecha_emision', 'like', '%' . $filter . '%');
            });
        }
        if( $cliente !== null ) {
            $query->where('cliente_id', $cliente);
        }
        if ($tipo !== null) {
            $query->where('tipo', $tipo);
        }

        $recordsTotal = $query->count();
        //codigo agregado:
        // ** INICIO - AGREGADO PARA FUNCIONALIDAD DE CHECKBOX MÚLTIPLE **
        // Si se requieren todos los registros (length = -1), no aplicar paginación
        if ($length == -1) {
            $nota_venta = $query->get();
        } else {
            $sortColumnName = $sortColumns[$order[0]['column']];
            $query->orderBy($sortColumnName, $order[0]['dir'])
                ->take($length)
                ->skip($start);
            $nota_venta = $query->get();
        }
        // codigo quitado:
        // $sortColumnName = $sortColumns[$order[0]['column']];
        // $query->orderBy($sortColumnName, $order[0]['dir'])
        //     ->take($length)
        //     ->skip($start);

        $nota_venta = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $nota_venta->transform(function ($nota_venta) use ($igv) {
            //Forma de Pago
            // if ($nota_venta->forma_pago == 1) {
            //     $nota_venta->forma_pago = "Contado";
            // } else {
                // $nota_venta->forma_pago = "Credito";
            // }

            // CALCULO PARA EL TOTAL
            $nota_venta_reg = NotaVentaRegistro::where('nota_venta_id', $nota_venta->id)->get();
            $total = 0;
            $suma = 0;
            foreach ($nota_venta_reg as $index => $nota_reg) {
                $total += $nota_reg->precio_nacional * $nota_reg->cantidad;
            }
            $suma += $total;

            // SEPARACION PARA EL TOTAL EN UNA SOLA MONEDA
            $nota_venta->total_conv = Ventas_registro::moneda_principal_convert($nota_venta->moneda_id, $total);

            $nota_venta->total = $nota_venta->moneda->simbolo . number_format($total, 2);
            $nota_venta->emision = Carbon::parse($nota_venta->created_at)->format('d-m-Y');

            return $nota_venta;
        });

        $total_columna = 0;
        // Bucle de llamada para el llenado del datatable
        foreach ($nota_venta as $n_venta) {
            $total_columna += $n_venta->total_conv;
            $json['data'][] = [
                $n_venta->id,
                $n_venta->id,
                $n_venta->cod_nota_venta,
                $n_venta->cliente->numero_documento,
                $n_venta->cliente->nombre,
                $n_venta->fecha_emision,
                $n_venta->forma_pago,
                $n_venta->total,
                $n_venta->id,
                $n_venta->estado
            ];
        }
        // // Llamado para la suma total
        $total_table = NotaVenta::total_sum_datatable($request, $startDate, $endDate);
        $json['total_columna'] = $moneda_principal->simbolo . number_format($total_columna, 2);
        $json['total_table'] = $moneda_principal->simbolo . number_format($total_table, 2);
        return response()->json($json);
    }

    public function clientes_registers(Request $request)
    {
        //* DATOS PARA PASAR CON AJAX
        // return var_dump($request->dateranger);
        // DATA REQUEST
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        // DATA DE DB
        // FILTRADO
        $filter = $request->get('value');
        $tipo_doc = $request->get('tipo_doc');
        $sortColumns = [
            0 => 'clientes.id',
            1 => 'clientes.id',
            2 => 'clientes.nombre',
            3 => 'clientes.documento_identificacion',
            4 => 'clientes.numero_documento',
            5 => 'clientes.email',
            6 => 'clientes.celular',
            7 => 'clientes.fecha_ingreso',
            8 => 'clientes.id'
        ];



        if ($request->daterange == NULL) {
            $query = Cliente::orderBy('created_at', 'desc');
        } else {
            $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();
            $query = Cliente::whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');
        }
        if($tipo_doc != null){
            $query->where('documento_identificacion', $tipo_doc);
        }
        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('clientes.id', 'like', '%' . $filter . '%')
                    ->orWhere('clientes.nombre', 'like', '%' . $filter . '%')
                    ->orWhere('clientes.documento_identificacion', 'like', '%' . $filter . '%')
                    ->orWhere('clientes.numero_documento', 'like', '%' . $filter . '%')
                    ->orWhere('clientes.email', 'like', '%' . $filter . '%')
                    ->orWhere('clientes.celular', 'like', '%' . $filter . '%');
            });
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $clientes = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $clientes->transform(function ($cliente) {
            $cliente->fecha_ingreso = Carbon::parse($cliente->created_at)->format('d-m-Y');
            return $cliente;
        });

        foreach ($clientes as $cliente) {
            $json['data'][] = [
                $cliente->id,
                $cliente->id,
                $cliente->nombre,
                $cliente->documento_identificacion,
                $cliente->numero_documento,
                $cliente->email,
                $cliente->celular,
                $cliente->fecha_ingreso,
                $cliente->id
            ];
        }

        return response()->json($json);
    }
}
