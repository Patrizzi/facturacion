<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Boleta;
use App\Boleta_m;
use App\ComprobantesVentas;
use App\Facturacion;
use App\Facturacion_m;
use App\Guia_remision;
use App\GuiaRemisionManual;
use App\Igv;
use App\Moneda;
use App\Nota_Credito;
use App\Nota_Debito;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ComprobantesVentasController extends Controller
{
    public function comprobantes_tabs() {}

    public function index_boleta()
    {
        $mes_año = Carbon::now()->format('d-m-Y');
        $count_month_comprobantes = ComprobantesVentas::count_month_comprobantes($mes_año);
        $almacen = Almacen::get();
        $count_all_comprobantes = ComprobantesVentas::count_day_comprobantes();
        // return $count_month_comprobantes;
        return view('transaccion.comprobantes.boleta.index', compact('almacen', 'count_all_comprobantes', 'count_month_comprobantes'));
    }

    public function boleta_registers(Request $request)
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
            2 => 'codigo_boleta',
            3 => 'cliente.nombre',
            4 => 'cliente.numero_documento',
            5 => 'fecha_emision',
            6 => 'forma_pago.nombre',
            7 => 'total_conv',
        ];
        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();
        $estado_s = $request->estado_s;

        $query = Boleta::with(['cliente', 'moneda', 'forma_pago'])
            ->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        if (!empty($filter)) {
            // Agrupar las condiciones de búsqueda en una única cláusula where
            $query->where(function ($q) use ($filter) {
                $q->where('codigo_boleta', 'like', '%' . $filter . '%');
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

        if ($estado_s !== null) {
            $query->where('b_electronica', $estado_s);
        }

        $recordsTotal = $query->count();
        //codigo agregado:
        // ** INICIO - AGREGADO PARA FUNCIONALIDAD DE CHECKBOX MÚLTIPLE **
        // Si se requieren todos los registros (length = -1), no aplicar paginación
        if ($length == -1) {
            $boletas = $query->get();
        } else {
            $sortColumnName = $sortColumns[$order[0]['column']];
            $query->orderBy($sortColumnName, $order[0]['dir'])
                ->take($length)
                ->skip($start);
            $boletas = $query->get();
        }
        // codigo quitado:
        // $sortColumnName = $sortColumns[$order[0]['column']];
        // $query->orderBy($sortColumnName, $order[0]['dir'])
        //     ->take($length)
        //     ->skip($start);



        $boletas = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];
        $boletas->transform(function ($boleta) use ($igv) {
            $subtotal = $boleta->op_gravada + $boleta->op_inafecta + $boleta->op_exonerada;

            $total = round($subtotal + ($boleta->op_gravada * $igv) / 100, 2);

            // SEPARACION PARA EL TOTAL EN UNA SOLA MONEDA
            $boleta->total_conv = ComprobantesVentas::moneda_principal_convert($boleta->moneda_id, $total);

            $boleta->total = $boleta->moneda->simbolo . number_format($total, 2); //total para la columna de la tabla
            $boleta->emision = Carbon::parse($boleta->created_at)->format('d-m-Y');
            $boleta->estado_proceso = Boleta::estado_sunat($boleta->id);
            $boleta->estado_nota_credito = Boleta::estado_nota_credito($boleta->id);
            $boleta->estado_nota_debito = Boleta::estado_nota_debito($boleta->id);
            return $boleta;
        });

        $total_columna = 0;
        // Bucle de llamada para el llenado del datatable
        foreach ($boletas as $boleta) {
            $total_columna += $boleta->total_conv;
            $json['data'][] = [
                $boleta->id,
                $boleta->id,
                $boleta->codigo_boleta,
                $boleta->cliente->numero_documento,
                $boleta->cliente->nombre,
                $boleta->fecha_emision,
                $boleta->forma_pago->nombre,
                $boleta->total,
                $boleta->id,
                $boleta->estado_proceso,
                $boleta->estado_nota_credito,
                $boleta->estado_nota_debito,
            ];
        }
        // Llamado para la suma total
        $total_table = Boleta::total_sum_datatable($request, $startDate, $endDate);
        $json['total_columna'] = $moneda_principal->simbolo . number_format($total_columna, 2);
        $json['total_table'] = $moneda_principal->simbolo . number_format($total_table, 2);
        return response()->json($json);
    }

    public function index_boleta_manual()
    {
        $mes_año = Carbon::now()->format('d-m-Y');
        $count_month_comprobantes = ComprobantesVentas::count_month_comprobantes($mes_año);
        $almacen = Almacen::get();
        $count_all_comprobantes = ComprobantesVentas::count_day_comprobantes();
        return view('transaccion.comprobantes.boleta_manual.index', compact('almacen', 'count_all_comprobantes', 'count_month_comprobantes'));
    }

    public function boletaM_registers(Request $request)
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
            2 => 'codigo_boleta',
            3 => 'cliente.nombre',
            4 => 'cliente.numero_documento',
            5 => 'fecha_emision',
            6 => 'forma_pago.nombre',
            7 => 'total_conv',
        ];
        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();
        $estado_s = $request->estado_s;

        $query = Boleta_m::with(['cliente', 'moneda', 'forma_pago'])
            ->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        if (!empty($filter)) {
            // Agrupar las condiciones de búsqueda en una única cláusula where
            $query->where(function ($q) use ($filter) {
                $q->where('codigo_boleta', 'like', '%' . $filter . '%');
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

        if ($estado_s !== null) {
            $query->where('b_electronica', $estado_s);
        }

        $recordsTotal = $query->count();
        //codigo agregado:
        // ** INICIO - AGREGADO PARA FUNCIONALIDAD DE CHECKBOX MÚLTIPLE **
        // Si se requieren todos los registros (length = -1), no aplicar paginación
        if ($length == -1) {
            $boletas = $query->get();
        } else {
            $sortColumnName = $sortColumns[$order[0]['column']];
            $query->orderBy($sortColumnName, $order[0]['dir'])
                ->take($length)
                ->skip($start);
            $boletas = $query->get();
        }
        // codigo quitado:
        // $sortColumnName = $sortColumns[$order[0]['column']];
        // $query->orderBy($sortColumnName, $order[0]['dir'])
        //     ->take($length)
        //     ->skip($start);



        $boletas = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];
        $boletas->transform(function ($boleta) use ($igv) {
            $subtotal = $boleta->op_gravada + $boleta->op_inafecta + $boleta->op_exonerada;

            $total = round($subtotal + ($boleta->op_gravada * $igv) / 100, 2);

            // SEPARACION PARA EL TOTAL EN UNA SOLA MONEDA
            $boleta->total_conv = ComprobantesVentas::moneda_principal_convert($boleta->moneda_id, $total);

            $boleta->total = $boleta->moneda->simbolo . number_format($total, 2); //total para la columna de la tabla
            $boleta->emision = Carbon::parse($boleta->created_at)->format('d-m-Y');
            $boleta->estado_proceso = Boleta_m::estado_sunat($boleta->id);
            $boleta->estado_nota_credito = Boleta_m::estado_nota_credito($boleta->id);
            $boleta->estado_nota_debito = Boleta_m::estado_nota_debito($boleta->id);
            return $boleta;
        });

        $total_columna = 0;
        // Bucle de llamada para el llenado del datatable
        foreach ($boletas as $boleta) {
            $total_columna += $boleta->total_conv;
            $json['data'][] = [
                $boleta->id,
                $boleta->id,
                $boleta->codigo_boleta,
                $boleta->cliente->numero_documento,
                $boleta->cliente->nombre,
                $boleta->fecha_emision,
                $boleta->forma_pago->nombre,
                $boleta->total,
                $boleta->id,
                $boleta->estado_proceso,
                $boleta->estado_nota_credito,
                $boleta->estado_nota_debito,
            ];
        }
        // Llamado para la suma total
        $total_table = Boleta_m::total_sum_datatable($request, $startDate, $endDate);
        $json['total_columna'] = $moneda_principal->simbolo . number_format($total_columna, 2);
        $json['total_table'] = $moneda_principal->simbolo . number_format($total_table, 2);
        return response()->json($json);
    }

    public function index_factura()
    {
        $mes_año = Carbon::now()->format('d-m-Y');
        $count_month_comprobantes = ComprobantesVentas::count_month_comprobantes($mes_año);
        $count_all_comprobantes = ComprobantesVentas::count_day_comprobantes();
        $user_login = auth()->user();
        $conteo_almacen = Almacen::where('estado', 0)->count();
        $almacen = Almacen::where('estado', 0)->get();
        $almacen_primero = Almacen::where('estado', 0)->first();
        $igv = Igv::first();

        return view('transaccion.comprobantes.factura.index', compact('count_all_comprobantes', 'count_month_comprobantes', 'user_login', 'conteo_almacen', 'almacen', 'almacen_primero', 'igv'));
    }

    public function factura_registers(Request $request)
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
            2 => 'codigo_fac',
            3 => 'cliente.nombre',
            4 => 'cliente.numero_documento',
            5 => 'fecha_emision',
            6 => 'forma_pago.nombre',
            7 => 'total_conv',
        ];
        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();
        $estado_s = $request->estado_s;

        $query = Facturacion::with(['cliente', 'moneda', 'forma_pago'])
            ->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        if (!empty($filter)) {
            // Agrupar las condiciones de búsqueda en una única cláusula where
            $query->where(function ($q) use ($filter) {
                $q->where('codigo_fac', 'like', '%' . $filter . '%');
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

        if ($estado_s !== null) {
            $query->where('f_electronica', $estado_s);
        }
        $recordsTotal = $query->count();

        //codigo agregado:
        // ** INICIO - AGREGADO PARA FUNCIONALIDAD DE CHECKBOX MÚLTIPLE **
        // Si se requieren todos los registros (length = -1), no aplicar paginación
        if ($length == -1) {
            $facturas = $query->get();
        } else {
            $sortColumnName = $sortColumns[$order[0]['column']];
            $query->orderBy($sortColumnName, $order[0]['dir'])
                ->take($length)
                ->skip($start);
            $facturas = $query->get();
        }
        // codigo quitado:
        // $sortColumnName = $sortColumns[$order[0]['column']];
        // $query->orderBy($sortColumnName, $order[0]['dir'])
        //     ->take($length)
        //     ->skip($start);


        $facturas = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];
        $facturas->transform(function ($factura) use ($igv) {
            $subtotal = $factura->op_gravada + $factura->op_inafecta + $factura->op_exonerada;

            $total = round($subtotal + ($factura->op_gravada * $igv) / 100, 2);

            // SEPARACION PARA EL TOTAL EN UNA SOLA MONEDA
            $factura->total_conv = ComprobantesVentas::moneda_principal_convert($factura->moneda_id, $total);

            $factura->total = $factura->moneda->simbolo . number_format($total, 2); //total para la columna de la tabla
            $factura->emision = Carbon::parse($factura->created_at)->format('d-m-Y');
            $factura->estado_proceso = Facturacion::estado_sunat($factura->id);
            $factura->estado_nota_credito = Facturacion::estado_nota_credito($factura->id);
            $factura->estado_nota_debito = Facturacion::estado_nota_debito($factura->id);
            return $factura;
        });

        $total_columna = 0;
        // Bucle de llamada para el llenado del datatable
        foreach ($facturas as $factura) {
            $total_columna += $factura->total_conv;
            $json['data'][] = [
                $factura->id,
                $factura->id,
                $factura->codigo_fac,
                $factura->cliente->numero_documento,
                $factura->cliente->nombre,
                $factura->fecha_emision,
                $factura->forma_pago->nombre,
                $factura->total,
                $factura->id,
                $factura->estado_proceso,
                $factura->estado_nota_credito,
                $factura->estado_nota_debito,
            ];
        }
        // Llamado para la suma total
        $total_table = Facturacion::total_sum_datatable($request, $startDate, $endDate);
        $json['total_columna'] = $moneda_principal->simbolo . number_format($total_columna, 2);
        $json['total_table'] = $moneda_principal->simbolo . number_format($total_table, 2);
        return response()->json($json);
    }

    public function index_factura_manual()
    {
        $mes_año = Carbon::now()->format('d-m-Y');
        $count_month_comprobantes = ComprobantesVentas::count_month_comprobantes($mes_año);
        $count_all_comprobantes = ComprobantesVentas::count_day_comprobantes();
        $user_login = auth()->user();
        $conteo_almacen = Almacen::where('estado', 0)->count();
        $almacen = Almacen::where('estado', 0)->get();
        $almacen_primero = Almacen::where('estado', 0)->first();
        $igv = Igv::first();

        return view('transaccion.comprobantes.factura_manual.index', compact('count_all_comprobantes', 'count_month_comprobantes', 'user_login', 'conteo_almacen', 'almacen', 'almacen_primero', 'igv'));
    }

    public function facturaM_registers(Request $request)
    {
        //* DATOS PARA PASAR CON AJAX
        // DATA REQUEST
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', array(0, 'asc'));
        $filter = $request->get('value');
        // DATA DE DB
        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();
        // FILTRADO
        $estado_s = $request->get('estado_s');
        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'codigo_fac',
            3 => 'cliente.nombre',
            4 => 'cliente.numero_documento',
            5 => 'fecha_emision',
            6 => 'forma_pago.nombre',
            7 => 'total_conv',
        ];
        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();

        $query = Facturacion_m::with(['cliente', 'moneda', 'forma_pago'])
            ->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        if (!empty($filter)) {
            // Agrupar las condiciones de búsqueda en una única cláusula where
            $query->where(function ($q) use ($filter) {
                $q->where('codigo_fac', 'like', '%' . $filter . '%');
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

        if ($estado_s !== null) {
            $query->where('f_electronica', $estado_s);
        }

        $recordsTotal = $query->count();

                //codigo agregado:
        // ** INICIO - AGREGADO PARA FUNCIONALIDAD DE CHECKBOX MÚLTIPLE **
        // Si se requieren todos los registros (length = -1), no aplicar paginación
        if ($length == -1) {
            $facturas = $query->get();
        } else {
            $sortColumnName = $sortColumns[$order[0]['column']];
            $query->orderBy($sortColumnName, $order[0]['dir'])
                ->take($length)
                ->skip($start);
            $facturas = $query->get();
        }
        // codigo quitado:
        // $sortColumnName = $sortColumns[$order[0]['column']];
        // $query->orderBy($sortColumnName, $order[0]['dir'])
        //     ->take($length)
        //     ->skip($start);


        $facturas = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];
        $facturas->transform(function ($factura) use ($igv) {
            $subtotal = $factura->op_gravada + $factura->op_inafecta + $factura->op_exonerada;

            $total = round($subtotal + ($factura->op_gravada * $igv) / 100, 2);

            // SEPARACION PARA EL TOTAL EN UNA SOLA MONEDA
            $factura->total_conv = ComprobantesVentas::moneda_principal_convert($factura->moneda_id, $total);

            $factura->total = $factura->moneda->simbolo . number_format($total, 2); //total para la columna de la tabla
            $factura->emision = Carbon::parse($factura->created_at)->format('d-m-Y');
            $factura->estado_proceso = Facturacion_m::estado_sunat($factura->id);
            $factura->estado_nota_credito = Facturacion_m::estado_nota_credito($factura->id);
            $factura->estado_nota_debito = Facturacion_m::estado_nota_debito($factura->id);
            return $factura;
        });

        $total_columna = 0;
        // Bucle de llamada para el llenado del datatable
        foreach ($facturas as $factura) {
            $total_columna += $factura->total_conv;
            $json['data'][] = [
                $factura->id,
                $factura->id,
                $factura->codigo_fac,
                $factura->cliente->numero_documento,
                $factura->cliente->nombre,
                $factura->fecha_emision,
                $factura->forma_pago->nombre,
                $factura->total,
                $factura->id,
                $factura->estado_proceso,
                $factura->estado_nota_credito,
                $factura->estado_nota_debito,
            ];
        }
        // Llamado para la suma total
        $total_table = Facturacion_m::total_sum_datatable($request, $startDate, $endDate);
        $json['total_columna'] = $moneda_principal->simbolo . number_format($total_columna, 2);
        $json['total_table'] = $moneda_principal->simbolo . number_format($total_table, 2);
        return response()->json($json);
    }

    public function index_nota_credito()
    {
        $mes_año = Carbon::now()->format('d-m-Y');
        $count_month_comprobantes = ComprobantesVentas::count_month_comprobantes($mes_año);
        $count_all_comprobantes = ComprobantesVentas::count_day_comprobantes();
        return view('transaccion.comprobantes.nota_credito.index', compact('count_month_comprobantes', 'count_all_comprobantes'));
    }

    public function notaCredito_registers(Request $request)
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
            2 => 'codigo_n_c',
            3 => 'cliente.document_id',
            4 => 'cliente.nombre',
            5 => 'cliente.numero_documento',
            6 => 'fecha_emision',
            7 => 'forma_pago.nombre',
            8 => 'id',
            9 => 'id'
        ];
        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();

        $query = Nota_Credito::whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('codigo_n_c', 'like', '%' . $filter . '%');

                // Cliente en factura electrónica
                $q->orWhereHas('nota_i_facturacion.cliente', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });

                // Cliente en factura manual
                $q->orWhereHas('nota_i_fac_manual.cliente', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });

                // Cliente en boleta electrónica
                $q->orWhereHas('nota_i_boleta.cliente', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });

                // Cliente en boleta manual
                $q->orWhereHas('nota_i_boleta_manual.cliente', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });

                // Fecha de emisión
                $q->orWhere('fecha_emision', 'like', '%' . $filter . '%');

                // Forma de pago (si aplica a alguna relación, puedes agregarla aquí también)
            });
        }

        $tipoComprobante = $request->tipo_comprobante;

        if ($tipoComprobante) {
            $query->where(function ($q) use ($tipoComprobante) {
                switch ($tipoComprobante) {
                    case 'factura':
                        $q->whereNotNull('facturacion_id');
                        break;
                    case 'factura_manual':
                        $q->whereNotNull('facturacion_m_id');
                        break;
                    case 'boleta':
                        $q->whereNotNull('boleta_id');
                        break;
                    case 'boleta_manual':
                        $q->whereNotNull('boleta_m_id');
                        break;
                }
            });
        }

        $recordsTotal = $query->count();
        //codigo agregado:
        // ** INICIO - AGREGADO PARA FUNCIONALIDAD DE CHECKBOX MÚLTIPLE **
        // Si se requieren todos los registros (length = -1), no aplicar paginación
        if ($length == -1) {
            $notas_credito = $query->get();
        } else {
            $sortColumnName = $sortColumns[$order[0]['column']];
            $query->orderBy($sortColumnName, $order[0]['dir'])
                ->take($length)
                ->skip($start);
            $notas_credito = $query->get();
        }
        // codigo quitado:
        // $sortColumnName = $sortColumns[$order[0]['column']];
        // $query->orderBy($sortColumnName, $order[0]['dir'])
        //     ->take($length)
        //     ->skip($start);

        $notas_credito = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];
        $notas_credito->transform(function ($nota_credito) use ($igv) {
            $nota_credito->emision = Carbon::parse($nota_credito->created_at)->format('d-m-Y');
            if ($nota_credito->facturacion_id !== null) {
                $nota_credito->document_id =  $nota_credito->nota_i_facturacion->codigo_fac;
                $nota_credito->client_n_doc = $nota_credito->nota_i_facturacion->cliente->numero_documento;
                $nota_credito->client_nombre = $nota_credito->nota_i_facturacion->cliente->nombre;
                $nota_credito->forma_pago = $nota_credito->nota_i_facturacion->forma_pago->nombre;
            }
            if ($nota_credito->facturacion_m_id !== null) {
                $nota_credito->document_id =  $nota_credito->nota_i_fac_manual->codigo_fac;
                $nota_credito->client_n_doc = $nota_credito->nota_i_fac_manual->cliente->numero_documento;
                $nota_credito->client_nombre = $nota_credito->nota_i_fac_manual->cliente->nombre;
                $nota_credito->forma_pago = $nota_credito->nota_i_fac_manual->forma_pago->nombre;
            }
            if ($nota_credito->boleta_id !== null) {
                $nota_credito->document_id =  $nota_credito->nota_i_boleta->codigo_boleta;
                $nota_credito->client_n_doc = $nota_credito->nota_i_boleta->cliente->numero_documento;
                $nota_credito->client_nombre = $nota_credito->nota_i_boleta->cliente->nombre;
                $nota_credito->forma_pago = $nota_credito->nota_i_boleta->forma_pago->nombre;
            }
            if ($nota_credito->boleta_m_id !== null) {
                $nota_credito->document_id =  $nota_credito->nota_i_boleta_manual->codigo_boleta;
                $nota_credito->client_n_doc = $nota_credito->nota_i_boleta_manual->cliente->numero_documento;
                $nota_credito->client_nombre = $nota_credito->nota_i_boleta_manual->cliente->nombre;
                $nota_credito->forma_pago = $nota_credito->nota_i_boleta_manual->forma_pago->nombre;
            }
            $nota_credito->estado_proceso = Nota_Credito::estado_sunat($nota_credito->id);
            return $nota_credito;
        });

        $total_columna = 0;
        // Bucle de llamada para el llenado del datatable
        foreach ($notas_credito as $n_credito) {
            $total_columna += $n_credito->total_conv;
            $json['data'][] = [
                $n_credito->id,
                $n_credito->id,
                $n_credito->codigo_n_c,
                $n_credito->document_id,
                $n_credito->client_n_doc,
                $n_credito->client_nombre,
                $n_credito->emision,
                $n_credito->forma_pago,
                // $n_credito->total,
                $n_credito->id,
                $n_credito->estado_proceso
            ];
        }
        return response()->json($json);
    }

    public function index_nota_debito()
    {
        $mes_año = Carbon::now()->format('d-m-Y');
        $count_month_comprobantes = ComprobantesVentas::count_month_comprobantes($mes_año);
        $count_all_comprobantes = ComprobantesVentas::count_day_comprobantes();
        return view('transaccion.comprobantes.nota_debito.index', compact('count_month_comprobantes', 'count_all_comprobantes'));
    }

    public function notaDebito_registers(Request $request)
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
            2 => 'codigo_n_d',
            3 => 'cliente.document_id',
            4 => 'cliente.nombre',
            5 => 'cliente.numero_documento',
            6 => 'fecha_emision',
            7 => 'forma_pago.nombre',
            8 => 'id',
            9 => 'id'
        ];
        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();

        $query = Nota_Debito::whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('codigo_n_d', 'like', '%' . $filter . '%');

                // Cliente en factura electrónica
                $q->orWhereHas('nota_i_facturacion.cliente', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });

                // Cliente en factura manual
                $q->orWhereHas('nota_i_fac_manual.cliente', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });

                // Cliente en boleta electrónica
                $q->orWhereHas('nota_i_boleta.cliente', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });

                // Cliente en boleta manual
                $q->orWhereHas('nota_i_boleta_manual.cliente', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%')
                        ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });

                // Fecha de emisión
                $q->orWhere('fecha_emision', 'like', '%' . $filter . '%');

                // Forma de pago (si aplica a alguna relación, puedes agregarla aquí también)
            });
        }

        $tipoComprobante = $request->tipo_comprobante;

        if ($tipoComprobante) {
            $query->where(function ($q) use ($tipoComprobante) {
                switch ($tipoComprobante) {
                    case 'factura':
                        $q->whereNotNull('facturacion_id');
                        break;
                    case 'factura_manual':
                        $q->whereNotNull('facturacion_m_id');
                        break;
                    case 'boleta':
                        $q->whereNotNull('boleta_id');
                        break;
                    case 'boleta_manual':
                        $q->whereNotNull('boleta_m_id');
                        break;
                }
            });
        }

        $recordsTotal = $query->count();
        //codigo agregado:
        // ** INICIO - AGREGADO PARA FUNCIONALIDAD DE CHECKBOX MÚLTIPLE **
        // Si se requieren todos los registros (length = -1), no aplicar paginación
        if ($length == -1) {
            $notas_debitos = $query->get();
        } else {
            $sortColumnName = $sortColumns[$order[0]['column']];
            $query->orderBy($sortColumnName, $order[0]['dir'])
                ->take($length)
                ->skip($start);
            $notas_debitos = $query->get();
        }
        // codigo quitado:
        // $sortColumnName = $sortColumns[$order[0]['column']];
        // $query->orderBy($sortColumnName, $order[0]['dir'])
        //     ->take($length)
        //     ->skip($start);

        $notas_debitos = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];
        $notas_debitos->transform(function ($nota_debito) use ($igv) {
            $nota_debito->emision = Carbon::parse($nota_debito->created_at)->format('d-m-Y');
            if ($nota_debito->facturacion_id !== null) {
                $nota_debito->document_id =  $nota_debito->nota_i_facturacion->codigo_fac;
                $nota_debito->client_n_doc = $nota_debito->nota_i_facturacion->cliente->numero_documento;
                $nota_debito->client_nombre = $nota_debito->nota_i_facturacion->cliente->nombre;
                $nota_debito->forma_pago = $nota_debito->nota_i_facturacion->forma_pago->nombre;
            }
            if ($nota_debito->facturacion_m_id !== null) {
                $nota_debito->document_id =  $nota_debito->nota_i_fac_manual->codigo_fac;
                $nota_debito->client_n_doc = $nota_debito->nota_i_fac_manual->cliente->numero_documento;
                $nota_debito->client_nombre = $nota_debito->nota_i_fac_manual->cliente->nombre;
                $nota_debito->forma_pago = $nota_debito->nota_i_fac_manual->forma_pago->nombre;
            }
            if ($nota_debito->boleta_id !== null) {
                $nota_debito->document_id =  $nota_debito->nota_i_boleta->codigo_boleta;
                $nota_debito->client_n_doc = $nota_debito->nota_i_boleta->cliente->numero_documento;
                $nota_debito->client_nombre = $nota_debito->nota_i_boleta->cliente->nombre;
                $nota_debito->forma_pago = $nota_debito->nota_i_boleta->forma_pago->nombre;
            }
            if ($nota_debito->boleta_m_id !== null) {
                $nota_debito->document_id =  $nota_debito->nota_i_boleta_manual->codigo_boleta;
                $nota_debito->client_n_doc = $nota_debito->nota_i_boleta_manual->cliente->numero_documento;
                $nota_debito->client_nombre = $nota_debito->nota_i_boleta_manual->cliente->nombre;
                $nota_debito->forma_pago = $nota_debito->nota_i_boleta_manual->forma_pago->nombre;
            }
            $nota_debito->estado_proceso = Nota_Debito::estado_sunat($nota_debito->id);
            return $nota_debito;
        });

        $total_columna = 0;
        // Bucle de llamada para el llenado del datatable
        foreach ($notas_debitos as $n_debito) {
            $total_columna += $n_debito->total_conv;
            $json['data'][] = [
                $n_debito->id,
                $n_debito->id,
                $n_debito->codigo_n_d,
                $n_debito->document_id,
                $n_debito->client_n_doc,
                $n_debito->client_nombre,
                $n_debito->emision,
                $n_debito->forma_pago,
                // $n_debito->total,
                $n_debito->id,
                $n_debito->estado_proceso
            ];
        }
        return response()->json($json);
    }

    public function index_guia_remision()
    {
        $mes_año = Carbon::now()->format('d-m-Y');
        $count_month_comprobantes = ComprobantesVentas::count_month_comprobantes($mes_año);
        $count_all_comprobantes = ComprobantesVentas::count_day_comprobantes();
        $almacen = Almacen::get();
        return view('transaccion.comprobantes.guia_remision.index', compact('count_month_comprobantes', 'count_all_comprobantes','almacen'));
    }
    public function guiaRemision_registers(Request $request)
    {
        //* DATOS PARA PASAR CON AJAX
        $draw   = (int) $request->query('draw', 0);
        $start  = (int) $request->query('start', 0);
        $length = (int) $request->query('length', 25);
        $order  = $request->query('order', [['column' => 0, 'dir' => 'asc']]);

        // DATA DE DB
        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();

        // FILTRADO
        $filter   = $request->get('value');
        $estado_s = $request->get('estado_s');

        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'cod_guia',
            3 => 'cliente.nombre',
            4 => 'cliente.numero_documento',
            5 => 'fecha_emision',
            6 => 'fecha_entrega',
            7 => 'id',
        ];

        // 🛠️ Rango de fechas: aceptar " | " o " - "
        $daterange = $request->get('daterange', date('01/m/Y').' - '.date('t/m/Y'));
        if (strpos($daterange, '|') !== false) {
            [$startStr, $endStr] = array_map('trim', explode('|', $daterange));
        } else {
            [$startStr, $endStr] = array_map('trim', explode('-', $daterange));
        }
        try {
            $startDate = Carbon::createFromFormat('d/m/Y', $startStr)->startOfDay();
            $endDate   = Carbon::createFromFormat('d/m/Y', $endStr)->endOfDay();
        } catch (\Throwable $e) {
            $startDate = now()->startOfMonth();
            $endDate   = now()->endOfMonth();
        }

        $query = Guia_remision::with(['cliente'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc');

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('cod_guia', 'like', '%'.$filter.'%')
                ->orWhereHas('cliente', function ($qq) use ($filter) {
                    $qq->where('nombre', 'like', '%'.$filter.'%')
                        ->orWhere('numero_documento', 'like', '%'.$filter.'%');
                })
                ->orWhere('fecha_emision', 'like', '%'.$filter.'%')
                ->orWhere('fecha_entrega', 'like', '%'.$filter.'%');
            });
        }

        if ($estado_s !== null && $estado_s !== '') {
            $query->where('g_electronica', $estado_s);
        }

        // ⚡ Caso especial: solo IDs (para selección masiva en tu front)
        if ($request->has('get_all_ids') || $request->has('fetch_ids_only')) {
            $ids = $query->pluck('id')->toArray();
            // Formato compatible con tu getAllIds() (toma row[0])
            $data = array_map(fn($id) => [$id], $ids);

            return response()->json([
                'draw'            => $draw,
                'recordsTotal'    => count($ids),
                'recordsFiltered' => count($ids),
                'data'            => $data,
                'success'         => true,
            ]);
        }

        // Totales (con filtros)
        $recordsFiltered = $query->count();
        $recordsTotal    = Guia_remision::count();

        // Paginación / length = -1 (todos)
        $sortColumnIndex = (int) ($order[0]['column'] ?? 0);
        $sortDir         = $order[0]['dir'] ?? 'asc';
        $sortColumnName  = $sortColumns[$sortColumnIndex] ?? 'id';

        if ($length == -1) {
            $guia_remisions = $query->orderBy($sortColumnName, $sortDir)->get();
        } else {
            $guia_remisions = $query->orderBy($sortColumnName, $sortDir)
                                    ->skip($start)
                                    ->take($length)
                                    ->get();
        }

        $json = [
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => [],
        ];

        // Utilidad: normalizar fechas a DD-MM-YYYY
        $formatearFecha = function($fecha) {
            if (empty($fecha)) return '-';
            try {
                if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $fecha)) {
                    return Carbon::createFromFormat('d/m/Y', $fecha)->format('d-m-Y');
                }
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
                    return Carbon::createFromFormat('Y-m-d', $fecha)->format('d-m-Y');
                }
                if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $fecha)) {
                    return $fecha;
                }
                return Carbon::parse($fecha)->format('d-m-Y');
            } catch (\Throwable $e) {
                return str_replace('/', '-', $fecha);
            }
        };

        $guia_remisions->transform(function ($guia_r) use ($formatearFecha) {
            $guia_r->fecha_emision_formatted = $formatearFecha($guia_r->fecha_emision);
            $guia_r->fecha_entrega_formatted = $formatearFecha($guia_r->fecha_entrega);
            $guia_r->estado_proceso          = Guia_remision::estado_sunat($guia_r->id);
            return $guia_r;
        });

        foreach ($guia_remisions as $guia_r) {
            $json['data'][] = [
                $guia_r->id,                          // 0 - ID (para checkbox)
                $guia_r->id,                          // 1 - ID (col duplicada que ya usas)
                $guia_r->cod_guia,                    // 2 - Código
                $guia_r->cliente->numero_documento,   // 3 - RUC
                $guia_r->cliente->nombre,             // 4 - Cliente
                $guia_r->fecha_emision_formatted,     // 5 - Emisión
                $guia_r->fecha_entrega_formatted,     // 6 - Entrega
                $guia_r->id,                          // 7 - Ver (para link)
                $guia_r->estado_proceso,              // 8 - Estado
            ];
        }

        return response()->json($json);
    }


    public function index_guia_remision_manual()
    {
        $mes_año = Carbon::now()->format('d-m-Y');
        $count_month_comprobantes = ComprobantesVentas::count_month_comprobantes($mes_año);
        $count_all_comprobantes = ComprobantesVentas::count_day_comprobantes();
        return view('transaccion.comprobantes.guia_remision_manual.index', compact('count_month_comprobantes', 'count_all_comprobantes'));
    }
    public function guiaRemisionM_registers(Request $request)
    {
        //* DATOS PARA PASAR CON AJAX
        $draw   = $request->query('draw', 0);
        $start  = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order  = $request->query('order', [['column' => 0, 'dir' => 'asc']]);

        // DATA DE DB
        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();

        // FILTRADO
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'id',
            2 => 'cod_guia',
            3 => 'cliente.nombre',
            4 => 'cliente.numero_documento',
            5 => 'fecha_emision',
            6 => 'fecha_entrega',
            7 => 'id',
        ];

        // Rango de fechas
        $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
        $endDate   = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();
        $tipo      = $request->tipo_comprobante ?? $request->tipo_coti;

        // QUERY BASE CON FILTROS
        $query = GuiaRemisionManual::with(['cliente'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'desc');

        // FILTRO GLOBAL
        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('cod_guia', 'like', '%' . $filter . '%');
                $q->orWhereHas('cliente', function ($q) use ($filter) {
                    $q->where('nombre', 'like', '%' . $filter . '%')
                    ->orWhere('numero_documento', 'like', '%' . $filter . '%');
                });
                $q->orWhere('fecha_emision', 'like', '%' . $filter . '%');
                $q->orWhere('fecha_entrega', 'like', '%' . $filter . '%');
            });
        }

        // FILTRO POR TIPO
        if ($tipo !== null) {
            $query->where('tipo', $tipo);
        }

        // ⚡ CASO ESPECIAL 1: Solo obtener IDs (más eficiente para selección masiva)
        if ($request->has('get_all_ids') || $request->has('fetch_ids_only')) {
            $ids = $query->pluck('id')->toArray();

            return response()->json([
                'success' => true,
                'ids' => $ids,
                'total' => count($ids),
                'message' => 'IDs obtenidos correctamente'
            ]);
        }

        // TOTAL DE REGISTROS (ANTES DE APLICAR PAGINACIÓN)
        $recordsFiltered = $query->count(); // Total con filtros aplicados
        $recordsTotal = GuiaRemisionManual::count(); // Total sin filtros

        // ⚡ CASO ESPECIAL 2: length = -1 (obtener todos los registros)
        if ($length == -1) {
            // Para length = -1, obtenemos TODOS los registros sin paginación
            $sortColumnName = $sortColumns[$order[0]['column']] ?? 'id';
            $guia_remisions = $query->orderBy($sortColumnName, $order[0]['dir'])->get();

        } else {
            // PAGINACIÓN NORMAL
            $sortColumnName = $sortColumns[$order[0]['column']] ?? 'id';
            $guia_remisions = $query->orderBy($sortColumnName, $order[0]['dir'])
                                ->skip($start)
                                ->take($length)
                                ->get();
        }

        // FORMATO JSON PARA DATATABLES
        $json = [
            'draw'            => (int)$draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => [],
        ];


        $formatearFecha = function($fecha) {
            if (empty($fecha)) return '-';

            try {
                // Si está en formato DD/MM/YYYY (viene del accessor), convertir a DD-MM-YYYY para DataTables
                if (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $fecha)) {
                    return Carbon::createFromFormat('d/m/Y', $fecha)->format('d-m-Y');
                }

                // Si está en formato YYYY-MM-DD, convertir a DD-MM-YYYY
                if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
                    return Carbon::createFromFormat('Y-m-d', $fecha)->format('d-m-Y');
                }

                // Si ya está en formato DD-MM-YYYY, dejarlo así
                if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $fecha)) {
                    return $fecha;
                }

                // Para otros formatos, intentar parsing automático
                return Carbon::parse($fecha)->format('d-m-Y');

            } catch (\Throwable $e) {
                // Si falla, reemplazar / por - para evitar problemas con DataTables
                return str_replace('/', '-', $fecha);
            }
        };

        $guia_remisions->transform(function ($guia_r) use ($igv, $formatearFecha) {
            try {
                // Ahora el accessor ya maneja el parsing, solo necesitamos formatear para DataTables
                $guia_r->fecha_emision_formatted  = $formatearFecha($guia_r->fecha_emision);
                $guia_r->fecha_entrega_formatted  = $formatearFecha($guia_r->fecha_entrega);
                $guia_r->estado_proceso = GuiaRemisionManual::estado_sunat($guia_r->id);
                return $guia_r;
            } catch (\Exception $e) {
                $guia_r->fecha_emision_formatted  = '-';
                $guia_r->fecha_entrega_formatted  = '-';
                $guia_r->estado_proceso = 0;
                return $guia_r;
            }
        });

        // ARMAR RESPUESTA PARA DATATABLE
        foreach ($guia_remisions as $guia_r) {
            $json['data'][] = [
                $guia_r->id,                           // 0 - ID
                $guia_r->id,                           // 1 - ID (duplicate)
                $guia_r->cod_guia,                     // 2 - Código
                $guia_r->cliente->numero_documento,    // 3 - RUC
                $guia_r->cliente->nombre,              // 4 - Cliente
                $guia_r->fecha_emision_formatted,      // 5 - Fecha Emisión (DD-MM-YYYY)
                $guia_r->fecha_entrega_formatted,      // 6 - Fecha Entrega (DD-MM-YYYY)
                $guia_r->id,                           // 7 - Ver (ID for link)
                $guia_r->estado_proceso,               // 8 - Estado
            ];
        }


        return response()->json($json);
    }
}
