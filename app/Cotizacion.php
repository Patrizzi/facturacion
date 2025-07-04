<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizacion';

    protected $guarded = [];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function forma_pago()
    {
        return $this->belongsTo(Forma_pago::class, 'forma_pago_id');
    }
    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }
    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'moneda_id');
    }
    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    public function comisionista()
    {
        return $this->belongsTo(Personal_venta::class, 'comisionista_id');
    }

    public function user_personal()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function aprobado()
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }
    public static function count_mes($fecha)
    {
        //CANTIDAD DE COTIZACIONES Formato = 02-09-2023"
        // $fecha = "02-09-2023";
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $year = date('Y', strtotime($fecha_conv)); // Obtiene el año de la fecha
        $month = date('m', strtotime($fecha_conv)); // Obtiene el mes de la fecha
        $cotizaciones  = Cotizacion::whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
        $moneda = Moneda::where('principal', '1')->first();
        $igv = Igv::first();
        // return $moneda;
        $total = 0;
        // PRECIOS DE COTIZACIONES X MES 
        foreach ($cotizaciones as $coti) {
            // condicional soles
            if ($moneda->id == "1") { //Si es soles retorno soles
                if ($coti->moneda->id == "1") { //soles
                    $subtotal = $coti->op_gravada + $coti->op_inafecta + $coti->op_exonerada;
                    $total =  $subtotal + ($coti->op_gravada * ($igv->igv_total / 100));
                } else {  //dolares
                    $subtotal_sin = $coti->op_gravada + $coti->op_inafecta + $coti->op_exonerada;
                    $subtotal = $subtotal_sin * $coti->cambio;
                    $subtotal_dol = $coti->op_gravada * $coti->cambio;
                    $total =  $subtotal + ($subtotal_dol * ($igv->igv_total / 100));
                }
            } else { // Si no retorno Dolares

                if ($coti->moneda->id == "1") { //dolares
                    $subtotal_sin = $coti->op_gravada + $coti->op_inafecta + $coti->op_exonerada;
                    $subtotal = $subtotal_sin / $coti->cambio;
                    $subtotal_dol = $coti->op_gravada / $coti->cambio;
                    $total =  $subtotal + ($coti->op_gravada * ($igv->igv_total / 100));
                } else {  //soels
                    $subtotal = $coti->op_gravada + $coti->op_inafecta + $coti->op_exonerada;
                    $total =  $subtotal + ($coti->op_gravada * ($igv->igv_total / 100));
                }
            }
        }
        $moneda_total = $moneda->simbolo . " " . number_format(round($total, 2), 2);
        $mes = array(
            "cantidad" => $cotizaciones->count(),
            "total" => $moneda_total
        );

        return $mes;
    }
    public static function estado_proceso($id)
    {
        $cotizacion = Cotizacion::find($id);
        //Estado
        if ($cotizacion->estado == 0) {
            $estado_actual = "Sin Proceso";
        } else {
            // Separar factura boleta y nota venta
            switch ($cotizacion->tipo) {
                case 'factura':
                    $estado_actual = "Facturado";
                    break;
                case 'boleta':
                    $estado_actual = "Boleteado";
                    break;
                case 'nota_venta':
                    $estado_actual = "Nota de Venta Registrada";
                    break;
                default:
                    $estado_actual = "Sin Proceso";
                    break;
            }
        }
        return $estado_actual;
    }
    public static function search_params($request)
    {
        // Datos 
        if (!isset($request->daterange)) {
            $startDate =  Carbon::now()->format('Y-m-01');
            $endDate =  Carbon::now()->format('Y-m-t');
        } else {
            $startDate = Carbon::createFromFormat('m/d/Y', explode(' - ', $request->daterange)[0])->startOfDay();
            $endDate = Carbon::createFromFormat('m/d/Y', explode(' - ', $request->daterange)[1])->endOfDay();
        }

        // Busqueda por tipos
        $tipo = $request->tipo_coti;
        if ($tipo == null) {
            $cotizaciones = Cotizacion::whereBetween('created_at', [$startDate, $endDate])->with(['cliente', 'moneda', 'forma_pago'])->orderBy('created_at', 'desc')->paginate(25);
        } else {
            $cotizaciones = Cotizacion::whereBetween('created_at', [$startDate, $endDate])->where('tipo', $tipo)->with(['cliente', 'moneda', 'forma_pago'])->orderBy('created_at', 'desc')->paginate(25);
        }
        $igv = Igv::first()->renta;
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

        return $cotizaciones;
    }

    public static function total_sum_datatable($request, $startDate, $endDate)
    {
        // Data
        $igv = Igv::first()->renta;
        // FILTRADO
        $filter = $request->get('value');
        // Busqueda en DB
        $query = Cotizacion::with(['cliente', 'moneda', 'forma_pago'])
            ->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        //  Filtro
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
        if ($request->get('tipo_coti') !== null) {
            $query->where('tipo', $request->get('tipo_coti'));
        }

        $cotizaciones = $query->get();

        $total_table = 0;
        // Transformacion a moneda principal
        $cotizaciones->transform(function ($cotizacion) use ($igv, &$total_table) {
            $subtotal = $cotizacion->op_gravada + $cotizacion->op_inafecta + $cotizacion->op_exonerada;
            $total = round($subtotal + ($cotizacion->op_gravada * $igv) / 100, 2);
            // SEPARACION PARA EL TOTAL EN UNA SOLA MONEDA
            $cotizacion->total_conv = Ventas_registro::moneda_principal_convert($cotizacion->moneda_id, $total);
            // Sumar el total convertido a la suma acumulada
            $total_table += $cotizacion->total_conv;
            return $cotizacion;
        });
        return $total_table;
    }
}
