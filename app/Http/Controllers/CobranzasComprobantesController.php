<?php

namespace App\Http\Controllers;

use App\Cuotas_credito;
use App\Facturacion_m;
use App\Igv;
use App\Moneda;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CobranzasComprobantesController extends Controller
{
    public function lista_facturas_manual_index(Request $request)
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

        $facturas_m = $query->where('estado_pago', 1)->take(10)->get();

        $json = [
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        ];

        $facturas_m->transform(function ($factura_m) use ($igv) {
            if($factura_m->forma_pago_id == 2){
                $cuotas = Cuotas_credito::where('facturacion_m_id', $factura_m->id)->count();
                if($cuotas == 0 || $cuotas == 1){
                    $factura_m->n_cuotas = "Pago Único";
                }else{
                    $factura_m->n_cuotas = $cuotas." Cuotas";
                }
            }else{
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
}
