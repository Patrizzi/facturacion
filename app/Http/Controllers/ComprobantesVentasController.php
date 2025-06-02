<?php

namespace App\Http\Controllers;

use App\Almacen;
use App\Boleta;
use App\ComprobantesVentas;
use App\Igv;
use App\Moneda;
use App\Nota_Credito;
use App\Nota_Debito;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ComprobantesVentasController extends Controller
{
    public function comprobantes_tabs() {}

    public function index_boleta()
    {
        $mes_año = Carbon::now()->format('d-m-Y');
        $count_month_ventas = ComprobantesVentas::count_month_comprobantes($mes_año);
        $almacen = Almacen::get();
        $count_all_comprobantes = ComprobantesVentas::count_day_comprobantes();
        return view('transaccion.comprobantes.boleta.index', compact('almacen', 'count_all_comprobantes', 'count_month_ventas'));
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
        $tipo = $request->tipo_coti;

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

        if ($tipo !== null) {
            $query->where('tipo', $tipo);
        }

        $recordsTotal = $query->count();
        $sortColumnName = $sortColumns[$order[0]['column']];
        $query->orderBy($sortColumnName, $order[0]['dir'])
            ->take($length)
            ->skip($start);

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
        $count_month_ventas = ComprobantesVentas::count_month_ventas($mes_año);
        $almacen = Almacen::get();
        $count_all_comprobantes = ComprobantesVentas::count_day_comprobantes();
        return view('transaccion.comprobantes.boleta_manual.index', compact('almacen', 'count_all_comprobantes', 'count_month_ventas'));
    }

    public function index_factura()
    {

        $count_all_comprobantes = ComprobantesVentas::count_day_comprobantes();
        $user_login = auth()->user();
        $conteo_almacen = Almacen::where('estado', 0)->count();
        $almacen = Almacen::where('estado', 0)->get();
        $almacen_primero = Almacen::where('estado', 0)->first();
        $igv = Igv::first();

        return view('transaccion.comprobantes.factura.index', compact('count_all_comprobantes', 'user_login', 'conteo_almacen', 'almacen', 'almacen_primero', 'igv'));
    }

    public function index_factura_manual()
    {

        return view('transaccion.comprobantes.factura_manual.index');
    }
}
