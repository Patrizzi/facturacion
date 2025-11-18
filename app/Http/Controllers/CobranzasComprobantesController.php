<?php

namespace App\Http\Controllers;

use App\Facturacion_m;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CobranzasComprobantesController extends Controller
{
    public function lista_facturas_manual_index(Request $request)
    {
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
            // 4 => 'fecha_emision',
            4 => 'forma_pago_id',
            5 => 'monto_total',
            6 => 'n_cuotas',
            7 => 'saldo',
            8 => 'ultima_fecha_pago',
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

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

        $facturas_m = $query->take(10)->get();

        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $facturas_m->transform()


        foreach ($facturas_m as $value) {
            $json['data'][] = [
                $value->id,
                $value->estado ?? "a",
                $value->codigo_fac,
                $value->cliente->nombre,
                $value->fecha_emision,
                // $value->forma_pago_id,
                $value->monto_total ?? 'S/' . '0',
                $value->n_cuotas ?? "Pago Único",
                $value->saldo ?? "0.00",
                $value->ultima_pago ?? "--- --- ---",
                $value->id,
            ];
        }
        return response()->json($json);
    }
}
