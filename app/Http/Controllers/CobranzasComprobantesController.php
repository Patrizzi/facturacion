<?php

namespace App\Http\Controllers;

use App\Boleta;
use App\Boleta_m;
use App\Cuotas_credito;
use App\Exports\CobranzasFacturasMExport;
use App\Facturacion;
use App\Facturacion_m;
use App\Igv;
use App\Moneda;
use App\NotaVenta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CobranzasComprobantesController extends Controller
{
    // * Lista de Comprobantes Facturas para mostrar
    public function lista_facturas_index(Request $request)
    {
        // dd($request);
        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();

        // dd($request);
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $cliente = $request->get('cliente_id');
        $estado_pago = $request->get('select_estado');
        $tipo_forma_pago = $request->get('tipo_forma_pago');
        $sortColumns = [
            0 => 'id',
            1 => 'estado_pago',
            2 => 'codigo_fac',
            3 => 'cliente.nombre',
            // 4 => 'fecha_emision',
            4 => 'forma_pago_id',
            5 => 'monto_total',
            6 => 'n_cuotas',
            7 => 'saldo',
            8 => 'ultima_fecha_pago',
            9 => 'id'
        ];

        if ($request->datarange != null) {
            $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->datarange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->datarange)[1])->endOfDay();

            $query = Facturacion::where('estado', 1)->whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'desc');
        } else {
            $query = Facturacion::where('estado', 1)->orderBy('id', 'desc');
        }
        if(!empty($cliente)){
            $query->where('cliente_id', $cliente);
        }
        if (!empty($estado_pago)) {
            $query->where('estado_pago', $estado_pago);
        } else {
            $query->whereIn('estado_pago', [0, 1]);
        }
        if ($tipo_forma_pago != null) {
            $query->where('forma_pago_id', (int)$request->tipo);
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $facturas = $query->get();

        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $facturas->transform(function ($factura) use ($igv) {
            if ($factura->forma_pago_id == 2) {
                $cuotas = Cuotas_credito::where('facturacion_id', $factura->id)->count();
                if ($cuotas == 0 || $cuotas == 1) {
                    $factura->n_cuotas = "Pago Único";
                } else {
                    $factura->n_cuotas = $cuotas . " Cuotas";
                }
            } else {
                $factura->n_cuotas = "Pago Único";
            }
            // Documento Adicional )NC - ND)
            $factura->doc_adicional = $factura->nota_credito ;    

            return $factura;
        });

        foreach ($facturas as $value) {
            $json['data'][] = [
                $value->id,
                $value->estado_pago_text,
                $value->codigo_fac,
                $value->cliente->nombre,
                $value->fecha_emision,
                // $value->forma_pago_id,
                $value->total_precio ?? 'S/' . '0',
                $value->n_cuotas ?? "Error",
                $value->saldo_pendiente ?? "---",
                $value->fecha_vencimiento,
                $value->id,
                $value->total_precio_desc_sin_forma,
                $value->doc_adicional,
            ];
        }
        return response()->json($json);
    }

    public function lista_facturas_pagados_index(Request $request)
    {
        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();

        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $cliente = $request->get('cliente_id');
        $tipo_forma_pago = $request->get('tipo_forma_pago');

        $sortColumns = [
            0 => 'id',
            1 => 'estado_pago',
            2 => 'codigo_fac',
            3 => 'cliente.nombre',
            4 => 'cliente.nombre',
            5 => 'forma_pago_id',
            6 => 'n_cuotas',
            7 => 'total_pago',
            8 => 'ultima_fecha_cancelado',
            9 => 'id'
        ];

        if ($request->daterange != null) {
            $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();

            $query = Facturacion::whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'desc');
        } else {
            $query = Facturacion::orderBy('id', 'desc');
        }
        if($cliente != null){
            $query->where('cliente_id', $cliente);
        }
        // return $query->where('estado_pago', 0)->get();
        // return $query->get();
        if ($tipo_forma_pago != null) {
            $query->where('forma_pago_id', (int)$request->tipo_forma_pago);
        }
        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('nombre', 'like', '%' . $filter . '%')
                    ->orWhere('codigo_fac', 'like', '%' . $filter . '%')
                    ->orWhereHas('cliente', function ($q, $request) use ($filter) {
                        $q->where('id', 'like', '%' . $request->cliente_id . '%');
                    });
            });
        }
        $query->where('estado_pago', 2);
        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $facturas_m = $query->get();

        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $facturas_m->transform(function ($factura_m) use ($igv) {
            if ($factura_m->forma_pago_id == 2) {
                $cuotas = Cuotas_credito::where('facturacion_id', $factura_m->id)->count();
                if ($cuotas == 0 || $cuotas == 1) {
                    $factura_m->n_cuotas = "Pago Único";
                } else {
                    $factura_m->n_cuotas = $cuotas . " Cuotas";
                }
            } else {
                $factura_m->n_cuotas = "Pago Único";
            }
            return $factura_m;
        });

        foreach ($facturas_m as $value) {
            $json['data'][] = [
                $value->id,
                $value->estado_pago_text,
                $value->codigo_fac,
                $value->cliente->nombre,
                $value->fecha_emision,
                // $value->id,
                $value->forma_pago->nombre ?? "Error",
                $value->n_cuotas ?? "---",
                $value->total_precio ?? 'S/' . '0',

                $value->ultima_fecha_pago ?? "---",
                $value->id,
            ];
        }
        return response()->json($json);
    }

    // * Lista de Comprobantes Facturas Manuales para mostrar
    public function lista_facturas_manual_index(Request $request)
    {

        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();

        // dd($request->get('estado_pago'));
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $cliente = $request->get('cliente_id');
        $estado_pago = $request->get('estado_pago');
        $tipo_forma_pago = $request->get('tipo');
        $sortColumns = [
            0 => 'id',
            1 => 'estado_pago',
            2 => 'codigo_fac',
            3 => 'cliente.nombre',
            // 4 => 'fecha_emision',
            4 => 'forma_pago_id',
            5 => 'monto_total',
            6 => 'n_cuotas',
            7 => 'saldo',
            8 => 'ultima_fecha_pago',
            9 => 'id'
        ];
        $query = Facturacion_m::query()
            ->where('estado', 1)
            ->orderBy('id', 'desc');

        $query->whereDoesntHave('nota_credito_register', function ($q) {
            $q->where('motivo', '01');
        });

        if (!empty($request->datarange)) {
            [$fechaInicio, $fechaFin] = explode(' - ', $request->datarange);

            $startDate = Carbon::createFromFormat('d/m/Y', $fechaInicio)->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', $fechaFin)->endOfDay();

            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        if (!empty($cliente)) {
            $query->where('cliente_id', $cliente);
        }

        if ($estado_pago !== null) {
            $query->where('estado_pago', $estado_pago);
        } else {
            $query->whereIn('estado_pago', [0, 1]);
        }

        if (!empty($tipo_forma_pago)) {
            $query->where('forma_pago_id', (int) $request->tipo);
        }

        $recordsTotal = $query->count();

        if ($length == -1) {
            $facturas = $query->get();
        } else {
            $sortColumnName = $sortColumns[$order[0]['column']];
            $query->orderBy($sortColumnName, $order[0]['dir'])
                ->take($length)
                ->skip($start);
            $facturas_m = $query->get();
        }

        $facturas_m = $query->get();
        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $facturas_m->transform(function ($factura_m) use ($igv) {
            if ($factura_m->forma_pago_id == 2) {
                $cuotas = Cuotas_credito::where('facturacion_m_id', $factura_m->id)->count();
                if ($cuotas == 0 || $cuotas == 1) {
                    $factura_m->n_cuotas = "Pago Único";
                } else {
                    $factura_m->n_cuotas = $cuotas . " Cuotas";
                }
            } else {
                $factura_m->n_cuotas = "Pago Único";
            }
            // Documento Adicional - NC
            $factura_m->doc_adicional = $factura_m->nota_credito;    
            return $factura_m;
        });

        foreach ($facturas_m as $value) {
            $json['data'][] = [
                $value->id,
                $value->estado_pago_text,
                $value->codigo_fac,
                $value->cliente->nombre,
                $value->fecha_emision,
                // $value->forma_pago_id,
                $value->total_precio ?? 'S/' . '0',
                $value->n_cuotas ?? "Error",
                $value->saldo_pendiente ?? "---",
                $value->fecha_vencimiento,
                $value->id,
                $value->total_precio_desc_sin_forma,
                $value->doc_adicional,
            ];
        }
        return response()->json($json);
    }

    public function lista_facturas_manual_pagados_index(Request $request)
    {
        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();

        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $cliente = $request->get('cliente_id');
        $estado_pago = $request->get('estado_pago');
        $tipo_forma_pago = $request->get('tipo');
        $sortColumns = [
            0 => 'id',
            1 => 'estado_pago',
            2 => 'codigo_fac',
            3 => 'cliente.nombre',
            4 => 'cliente.nombre',
            5 => 'forma_pago_id',
            6 => 'n_cuotas',
            7 => 'total_pago',
            8 => 'ultima_fecha_cancelado',
            9 => 'id'
        ];
        $query = Facturacion_m::orderBy('id', 'desc');
        if ($request->datarange !== null && $request->datarange !== "") {
            $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->datarange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->datarange)[1])->endOfDay();

            $query->whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'desc');
        }
        if($cliente != null){
            $query->where('cliente_id', $cliente);
        }
        if ($tipo_forma_pago != null) {
            $query->where('forma_pago_id', (int)$request->tipo);
        }
        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('nombre', 'like', '%' . $filter . '%')
                    ->orWhere('codigo_fac', 'like', '%' . $filter . '%')
                    ->orWhereHas('cliente', function ($q, $request) use ($filter) {
                        $q->where('id', 'like', '%' . $request->cliente_id . '%');
                    });
            });
        }
        $query->where('estado_pago', 2);
        $recordsTotal = $query->count();
        if ($length == -1) {
            $facturas_m = $query->get();
        } else {
            $sortColumnName = $sortColumns[$order[0]['column']];
            $query->orderBy($sortColumnName, $order[0]['dir'])
                ->take($length)
                ->skip($start);
            $facturas_m = $query->get();
        }

        $facturas_m = $query->get();

        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $facturas_m->transform(function ($factura_m) use ($igv) {
            if ($factura_m->forma_pago_id == 2) {
                $cuotas = Cuotas_credito::where('facturacion_m_id', $factura_m->id)->count();
                if ($cuotas == 0 || $cuotas == 1) {
                    $factura_m->n_cuotas = "Pago Único";
                } else {
                    $factura_m->n_cuotas = $cuotas . " Cuotas";
                }
            } else {
                $factura_m->n_cuotas = "Pago Único";
            }
            return $factura_m;
        });

        foreach ($facturas_m as $value) {
            $json['data'][] = [
                $value->id,
                $value->estado_pago_text,
                $value->codigo_fac,
                $value->cliente->nombre,
                $value->fecha_emision,
                // $value->id,
                $value->forma_pago->nombre ?? "Error",
                $value->n_cuotas ?? "---",
                $value->total_precio ?? 'S/' . '0',

                $value->ultima_fecha_pago ?? "---",
                $value->id,
            ];
        }
        return response()->json($json);
    }

    //* Lista de Comprobantes Boletas para mostrar
    public function lista_boletas_index(Request $request){
        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();

        // dd($request);
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $cliente = $request->get('cliente_id');
        $estado_pago = $request->get('estado_pago');
        $tipo = $request->get('tipo');
        $sortColumns = [
            0 => 'id',
            1 => 'estado_pago',
            2 => 'codigo_boleta',
            3 => 'cliente.nombre',
            // 4 => 'fecha_emision',
            4 => 'forma_pago_id',
            5 => 'monto_total',
            6 => 'n_cuotas',
            7 => 'saldo',
            8 => 'ultima_fecha_pago',
            9 => 'id'
        ];

        if ($request->datarange != null) {
            $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->datarange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->datarange)[1])->endOfDay();

            $query = Boleta::whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'desc');
        } else {
            $query = Boleta::orderBy('id', 'desc');
        }
        if($cliente != null){
            $query->where('cliente_id', $cliente);
        }
        if ($estado_pago != null) {
            $query->where('estado_pago', $estado_pago);
        } else {
            $query->whereIn('estado_pago', [0, 1]);
        }
         if ($tipo != null) {
            $query->where('forma_pago_id', $tipo);
        } else {
            $query->whereIn('estado_pago', [0, 1]);
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $facturas_m = $query->get();

        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $facturas_m->transform(function ($factura_m) use ($igv) {
            if ($factura_m->forma_pago_id == 2) {
                $cuotas = Cuotas_credito::where('boleta_id', $factura_m->id)->count();
                if ($cuotas == 0 || $cuotas == 1) {
                    $factura_m->n_cuotas = "Pago Único";
                } else {
                    $factura_m->n_cuotas = $cuotas . " Cuotas";
                }
            } else {
                $factura_m->n_cuotas = "Pago Único";
            }
            return $factura_m;
        });

        foreach ($facturas_m as $value) {
            $json['data'][] = [
                $value->id,
                $value->estado_pago_text,
                $value->codigo_boleta,
                $value->cliente->nombre,
                $value->fecha_emision,
                // $value->forma_pago_id,
                $value->total_precio ?? 'S/' . '0',
                $value->n_cuotas ?? "Error",
                $value->saldo_pendiente ?? "---",
                $value->fecha_vencimiento,
                $value->id,
            ];
        }
        return response()->json($json);
    }

    public function lista_boletas_pagados_index(Request $request)
    {
        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();

        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'estado_pago',
            2 => 'codigo_boleta',
            3 => 'cliente.nombre',
            4 => 'cliente.nombre',
            5 => 'forma_pago_id',
            6 => 'n_cuotas',
            7 => 'total_pago',
            8 => 'ultima_fecha_cancelado',
            9 => 'id'
        ];

        if ($request->daterange != null) {
            $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();

            $query = Boleta_m::whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'desc');
        } else {
            $query = Boleta_m::orderBy('id', 'desc');
        }

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('nombre', 'like', '%' . $filter . '%')
                    ->orWhere('codigo_boleta', 'like', '%' . $filter . '%')
                    ->orWhereHas('cliente', function ($q, $request) use ($filter) {
                        $q->where('id', 'like', '%' . $request->cliente_id . '%');
                    });
            });
        }
        $query->where('estado_pago', 2);
        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $facturas_m = $query->get();

        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $facturas_m->transform(function ($factura_m) use ($igv) {
            if ($factura_m->forma_pago_id == 2) {
                $cuotas = Cuotas_credito::where('boleta_id', $factura_m->id)->count();
                if ($cuotas == 0 || $cuotas == 1) {
                    $factura_m->n_cuotas = "Pago Único";
                } else {
                    $factura_m->n_cuotas = $cuotas . " Cuotas";
                }
            } else {
                $factura_m->n_cuotas = "Pago Único";
            }
            return $factura_m;
        });

        foreach ($facturas_m as $value) {
            $json['data'][] = [
                $value->id,
                $value->estado_pago_text,
                $value->codigo_boleta,
                $value->cliente->nombre,
                $value->fecha_emision,
                // $value->id,
                $value->forma_pago->nombre ?? "Error",
                $value->n_cuotas ?? "---",
                $value->total_precio ?? 'S/' . '0',

                $value->ultima_fecha_pago ?? "---",
                $value->id,
            ];
        }
        return response()->json($json);
    }

    //* Lista de Comprobantes Boletas para mostrar
    public function lista_boletas_manual_index(Request $request){
        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();

        // dd($request);
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $cliente = $request->get('cliente_id');
        $estado_pago = $request->get('estado_pago');
        $tipo_forma_pago = $request->get('tipo');
        $sortColumns = [
            0 => 'id',
            1 => 'estado_pago',
            2 => 'codigo_boleta',
            3 => 'cliente.nombre',
            // 4 => 'fecha_emision',
            4 => 'forma_pago_id',
            5 => 'monto_total',
            6 => 'n_cuotas',
            7 => 'saldo',
            8 => 'ultima_fecha_pago',
            9 => 'id'
        ];

        if ($request->datarange != null) {
            $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->datarange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->datarange)[1])->endOfDay();

            $query = Boleta_m::whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'desc');
        } else {
            $query = Boleta_m::orderBy('id', 'desc');
        }
        if($cliente != null){
            $query->where('cliente_id', $cliente);
        }
        if ($estado_pago != null) {
            $query->where('estado_pago', $estado_pago);
        } else {
            $query->whereIn('estado_pago', [0, 1]);
        }
        if ($tipo_forma_pago != null) {
            $query->where('forma_pago_id', (int)$request->tipo);
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $boleta_m = $query->get();

        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];
        
        $boleta_m->transform(function ($boleta) use ($igv) {
            if ($boleta->forma_pago_id == 2) {
                $cuotas = Cuotas_credito::where('boleta_m_id', $boleta->id)->count();
                if ($cuotas == 0 || $cuotas == 1) {
                    $boleta->n_cuotas = "Pago Único";
                } else {
                    $boleta->n_cuotas = $cuotas . " Cuotas";
                }
            } else {
                $boleta->n_cuotas = "Pago Único";
            }
            $boleta->doc_adicional = $boleta->nota_credito;    
            return $boleta;
        });
        
        foreach ($boleta_m as $value) {
            $json['data'][] = [
                $value->id,
                $value->estado_pago_text,
                $value->codigo_boleta,
                $value->cliente->nombre,
                $value->fecha_emision,
                // // $value->forma_pago_id,
                $value->total_precio ?? 'S/' . '0',
                $value->n_cuotas ?? "Error",
                $value->saldo_pendiente ?? "---",
                $value->fecha_vencimiento,
                $value->id,
                $value->total_precio_desc_sin_forma,
                $value->doc_adicional,
            ];
        }
        return response()->json($json);
    }

    public function lista_boletas_manual_pagados_index(Request $request)
    {
        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();

        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $cliente = $request->get('cliente_id');
        $estado_pago = $request->get('estado_pago');
        $tipo_forma_pago = $request->get('tipo');
        $sortColumns = [
            0 => 'id',
            1 => 'estado_pago',
            2 => 'codigo_boleta',
            3 => 'cliente.nombre',
            4 => 'cliente.nombre',
            5 => 'forma_pago_id',
            6 => 'n_cuotas',
            7 => 'total_pago',
            8 => 'ultima_fecha_cancelado',
            9 => 'id'
        ];

        if ($request->daterange != null) {
            $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();

            $query = Boleta_m::whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'desc');
        } else {
            $query = Boleta_m::orderBy('id', 'desc');
        }
        if($cliente != null){
            $query->where('cliente_id', $cliente);
        }
        if ($tipo_forma_pago != null) {
            $query->where('forma_pago_id', (int)$request->tipo);
        }
        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('nombre', 'like', '%' . $filter . '%')
                    ->orWhere('codigo_boleta', 'like', '%' . $filter . '%')
                    ->orWhereHas('cliente', function ($q, $request) use ($filter) {
                        $q->where('id', 'like', '%' . $request->cliente_id . '%');
                    });
            });
        }
        $query->where('estado_pago', 2);
        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $facturas_m = $query->get();

        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $facturas_m->transform(function ($factura_m) use ($igv) {
            if ($factura_m->forma_pago_id == 2) {
                $cuotas = Cuotas_credito::where('boleta_id', $factura_m->id)->count();
                if ($cuotas == 0 || $cuotas == 1) {
                    $factura_m->n_cuotas = "Pago Único";
                } else {
                    $factura_m->n_cuotas = $cuotas . " Cuotas";
                }
            } else {
                $factura_m->n_cuotas = "Pago Único";
            }
            return $factura_m;
        });

        foreach ($facturas_m as $value) {
            $json['data'][] = [
                $value->id,
                $value->estado_pago_text,
                $value->codigo_boleta,
                $value->cliente->nombre,
                $value->fecha_emision,
                // $value->id,
                $value->forma_pago->nombre ?? "Error",
                $value->n_cuotas ?? "---",
                $value->total_precio ?? 'S/' . '0',

                $value->ultima_fecha_pago ?? "---",
                $value->id,
            ];
        }
        return response()->json($json);
    }

    //* Lista de Comprobantes Nota Venta para mostrar
    public function lista_nota_venta_index(Request $request){
        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();

        // dd($request);
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $cliente = $request->get('cliente_id');
        $estado_pago = $request->get('estado_pago');
        $tipo = $request->get('tipo');
        $sortColumns = [
            0 => 'id',
            1 => 'estado_pago',
            2 => 'codigo_boleta',
            3 => 'cliente.nombre',
            4 => 'fecha_emision',
            // 4 => '',     
            5 => 'monto_total',
            6 => 'forma_pago_id',
            7 => 'saldo',
            8 => 'ultima_fecha_pago',
            9 => 'id'
        ];

        if ($request->datarange != null) {
            $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->datarange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->datarange)[1])->endOfDay();

            $query = NotaVenta::whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'desc');
        } else {
            $query = NotaVenta::orderBy('id', 'desc');
        }
        if($cliente != null){
            $query->where('cliente_id', $cliente);
        }
        if ($estado_pago != null) {
            $query->where('estado_pago', $estado_pago);
        } else {
            $query->whereIn('estado_pago', [0, 1]);
        }
         if ($tipo != null) {
            $query->where('forma_pago_id', $tipo);
        } else {
            $query->whereIn('estado_pago', [0, 1]);
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $boleta_m = $query->get();

        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $boleta_m->transform(function ($factura_m) use ($igv) {
            if ($factura_m->forma_pago_id == 2) {
                $factura_m->n_cuotas = "Pago Único a Crédito";
            } else {
                $factura_m->n_cuotas = "Pago Único";
            }
            return $factura_m;
        });

        foreach ($boleta_m as $value) {
            $json['data'][] = [
                $value->id,
                $value->estado_pago_text,
                $value->cod_nota_venta,
                $value->cliente->nombre,
                $value->fecha_emision,
                // $value->forma_pago_id,
                $value->total_precio ?? 'S/' . '0',
                $value->forma_pago ?? "Error",
                $value->saldo_pendiente ?? "---",
                // $value->fecha_vencimiento ?? "a",
                $value->id,
            ];
        }
        return response()->json($json);
    }

    public function lista_nota_venta_pagados_index(Request $request)
    {
        $igv = Igv::first()->renta;
        $moneda_principal = Moneda::where('principal', 1)->first();

        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 25);
        $order = $request->query('order', [['column' => 0, 'dir' => 'asc']]);
        $filter = $request->get('value');
        $sortColumns = [
            0 => 'id',
            1 => 'estado_pago',
            2 => 'cod_nota_venta',
            3 => 'cliente.nombre',
            4 => 'cliente.nombre',
            5 => 'forma_pago_id',
            6 => 'n_cuotas',
            7 => 'total_pago',
            8 => 'ultima_fecha_cancelado',
            9 => 'id'
        ];

        if ($request->daterange != null) {
            $startDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('d/m/Y', explode(' - ', $request->daterange)[1])->endOfDay();

            $query = NotaVenta::whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'desc');
        } else {
            $query = NotaVenta::orderBy('id', 'desc');
        }

        if (!empty($filter)) {
            $query->where(function ($q) use ($filter) {
                $q->where('nombre', 'like', '%' . $filter . '%')
                    ->orWhere('cod_nota_venta', 'like', '%' . $filter . '%')
                    ->orWhereHas('cliente', function ($q, $request) use ($filter) {
                        $q->where('id', 'like', '%' . $request->cliente_id . '%');
                    });
            });
        }
        $query->where('estado_pago', 2);
        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $facturas_m = $query->get();

        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        // $facturas_m->transform(function ($factura_m) use ($igv) {
        //     if ($factura_m->forma_pago_id == 2) {
        //         $cuotas = Cuotas_credito::where('boleta_id', $factura_m->id)->count();
        //         if ($cuotas == 0 || $cuotas == 1) {
        //             $factura_m->n_cuotas = "Pago Único";
        //         } else {
        //             $factura_m->n_cuotas = $cuotas . " Cuotas";
        //         }
        //     } else {
        //         $factura_m->n_cuotas = "Pago Único";
        //     }
        //     return $factura_m;
        // });

        foreach ($facturas_m as $value) {
            $json['data'][] = [
                $value->id,
                $value->estado_pago_text,
                $value->cod_nota_venta,
                $value->cliente->nombre,
                $value->fecha_emision,
                // $value->id,
                $value->forma_pago ?? "Error",
                // $value->n_cuotas ?? "---",
                $value->total_precio ?? 'S/' . '0',
                $value->ultima_fecha_pago ?? "---",
                $value->id,
            ];
        }
        return response()->json($json);
    }

    // Funcion de exportacion en excel Para los que faltan pagar
    public function exportarSinPagoFacturasM(Request $request){
        $ids = $request->json('factura_ids');
        if (!empty($ids)) {
            $export = new CobranzasFacturasMExport($ids);
        } else {
            $request->validate([
                'daterange' => 'required|string'
            ]);

            [$start, $end] = explode(' - ', $request->daterange);

            $export = new CobranzasFacturasMExport(null, [
                'start'  => Carbon::createFromFormat('d/m/Y', $start)->startOfDay(),
                'end'    => Carbon::createFromFormat('d/m/Y', $end)->endOfDay(),
                'filter' => $request->input('value'),
                'tipo'   => $request->input('tipo_coti'),
                'estado_pago' => '0'
            ]);
        }

        return Excel::download(
            $export,
            'Facturas_' . now('America/Lima')->format('Y-m-d') . '.xlsx'
        );
    }

     // Funcion de exportacion en excel para los pagados
    public function exportarPagadasFacturasM(Request $request){
        $ids = $request->json('factura_ids');
        if (!empty($ids)) {
            $export = new CobranzasFacturasMExport($ids);
        } else {
            $request->validate([
                'daterange' => 'required|string'
            ]);

            [$start, $end] = explode(' - ', $request->daterange);

            $export = new CobranzasFacturasMExport(null, [
                'start'  => Carbon::createFromFormat('d/m/Y', $start)->startOfDay(),
                'end'    => Carbon::createFromFormat('d/m/Y', $end)->endOfDay(),
                'filter' => $request->input('value'),
                'tipo'   => $request->input('tipo_coti'),
                'estado_pago' => '1'
            ]);
        }

        return Excel::download(
            $export,
            'Facturas_' . now('America/Lima')->format('Y-m-d') . '.xlsx'
        );
    }
}