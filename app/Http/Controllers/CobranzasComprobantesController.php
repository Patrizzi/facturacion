<?php

namespace App\Http\Controllers;

use App\Boleta;
use App\Boleta_m;
use App\Cuotas_credito;
use App\Facturacion;
use App\Facturacion_m;
use App\Igv;
use App\Moneda;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CobranzasComprobantesController extends Controller
{
    // * Lista de Comprobantes Facturas para mostrar
    public function lista_facturas_index(Request $request)
    {

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

            $query = Facturacion::whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'desc');
        } else {
            $query = Facturacion::orderBy('id', 'desc');
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

    public function lista_facturas_pagados_index(Request $request)
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

    // * Lista de Comprobantes Facturas Manuales para mostrar
    public function lista_facturas_manual_index(Request $request)
    {

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

            $query = Facturacion_m::whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'desc');
        } else {
            $query = Facturacion_m::orderBy('id', 'desc');
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
        // if (!empty($filter)) {
        //     $query->where(function ($q) use ($filter) {
        //         $q->where('nombre', 'like', '%' . $filter . '%')
        //             ->orWhere('codigo_fac', 'like', '%' . $filter . '%')
        //             ->orWhereHas('cliente', function ($q, $request) use ($filter) {
        //                 $q->where('id', 'like', '%' . $request->cliente_id . '%');
        //             });
        //     });
        // }


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

    public function lista_facturas_manual_pagados_index(Request $request)
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

            $query = Facturacion_m::whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'desc');
        } else {
            $query = Facturacion_m::orderBy('id', 'desc');
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

            $query = Boleta::whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'desc');
        } else {
            $query = Boleta::orderBy('id', 'desc');
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

        foreach ($boleta_m as $value) {
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

    public function lista_boletas_manual_pagados_index(Request $request)
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

            $query = Boleta::whereBetween('created_at', [$startDate, $endDate])->orderBy('id', 'desc');
        } else {
            $query = Boleta::orderBy('id', 'desc');
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
}
