<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CotizacionManual extends Model
{
    protected $table = 'cotizacion_manual';

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
    public function tipo_operacion()
    {
        return $this->belongsTo(Tipo_operacion_f::class, 'tipo_operacion_id');
    }
    public function tipo_documento(){
        return $this->belongsTo(Tipo_documento_sunat::class,'tipo_documento_id');
    }
    // nuevo guia
    public function servicio_guia() {
        return $this->hasMany(ServicioGuia::class, 'servicio_g_id');
    }

    public function coti_manual_registros() {
        return $this->hasMany(CotizacionManual_registros::class, 'cotizacion_m_id', 'id');
    }

    public static function count_mes($fecha)
    {
        //CANTIDAD DE COTIZACIONES Formato = 02-09-2023"
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $year = date('Y', strtotime($fecha_conv)); // Obtiene el año de la fecha
        $month = date('m', strtotime($fecha_conv)); // Obtiene el mes de la fecha
        $cotizacionesM  = CotizacionManual::whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
        $moneda = Moneda::where('principal', '1')->first();
        $igv = Igv::first();
        $total = 0;
        // PRECIOS DE COTIZACIONES X MES
        foreach ($cotizacionesM as $cotim) {
            // condicional principal soles
            if ($moneda->id == "1") { //Si es soles retorno soles
                if ($cotim->moneda->id == "1") { //soles
                    $subtotal = $cotim->op_gravada + $cotim->op_inafecta + $cotim->op_exonerada;
                    $total +=  $subtotal + ($cotim->op_gravada * ($igv->igv_total / 100));
                } else {  //dolares
                    $subtotal_sin = $cotim->op_gravada + $cotim->op_inafecta + $cotim->op_exonerada;
                    $subtotal = $subtotal_sin * $cotim->cambio;
                    $subtotal_dol = $cotim->op_gravada * $cotim->cambio;
                    $total +=  $subtotal + ($subtotal_dol * ($igv->igv_total / 100));
                }
                // $total = "1";
                // return $total;
            } else { // Si no retorno Dolares

                if ($cotim->moneda->id == "1") { //dolares
                    $subtotal_sin = $cotim->op_gravada + $cotim->op_inafecta + $cotim->op_exonerada;
                    $subtotal = $subtotal_sin / $cotim->cambio;
                    $subtotal_dol = $cotim->op_gravada / $cotim->cambio;
                    $total +=  $subtotal + ($cotim->op_gravada / ($igv->igv_total / 100));
                } else {  //soels
                    $subtotal = $cotim->op_gravada + $cotim->op_inafecta + $cotim->op_exonerada;
                    $total +=  $subtotal + ($cotim->op_gravada * ($igv->igv_total / 100));
                }
                // $total = "2";
            }
        }
        $moneda_total = $moneda->simbolo . " " . number_format(round($total, 2), 2);
        $mes = array(
            "cantidad" => $cotizacionesM->count(),
            "total" => $moneda_total
        );

        return $mes;
    }
    public static function estado_proceso($id)
    {
        $cotizacion = CotizacionManual::find($id);
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
    public static function total_sum_datatable($request, $startDate, $endDate)
    {
        // Data
        $igv = Igv::first()->renta;
        // FILTRADO
        $filter = $request->get('value');
        // Busqueda en DB
        $query = CotizacionManual::with(['cliente', 'moneda', 'forma_pago'])
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
