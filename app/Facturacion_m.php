<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Facturacion_m extends Model
{
    protected $table = 'facturacion_m';

    protected $guarded = [];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'id_cotizador');
    }

    public function cotizacion_servicio()
    {
        return $this->belongsTo(Cotizacion_Servicios::class, 'id_cotizador_servicio');
    }

    public function forma_pago()
    {
        return $this->belongsTo(Forma_pago::class, 'forma_pago_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'moneda_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    public function tipo_operacion()
    {
        return $this->belongsTo(Tipo_operacion_f::class, 'tipo_operacion_id');
    }

    public static function revision_cuotas($id)
    {

        $igv = Igv::first();
        $factura_m = Facturacion_m::find($id);
        //dato 1 -- multiplicacion de operaciones + igv
        $op_grav = $factura_m->op_gravada;
        $sub_tot = ($op_grav * ($igv->igv_total / 100));


        $op_ina = $factura_m->op_inafecta;
        $op_exo = $factura_m->op_exonerada;
        $op_grat = $factura_m->op_gratuita;
        $subtotal = $factura_m->op_gravada + $op_exo + $op_ina + $op_grat;
        $final_1 = $subtotal + $sub_tot;

        //dato 2 -- suma de cuotas
        $cuotas_cre = Cuotas_credito::where('facturacion_m_id', $id)->get();
        $cuota_sum = 0;
        foreach ($cuotas_cre as $key => $cuota) {
            $cuota_sum += $cuota->monto;
        }

        //dato 3 -- suma de registros
        $factura_reg = Facturacion_registro_m::where('facturacion_m_id', $factura_m->id)->get();
        $igv_f = 0;
        $gravada = 0;
        $precio = 0;
        foreach ($factura_reg as $key => $f_reg) {
            if (isset($f_reg->producto->codigo_producto)) {
                $afec = $f_reg->producto->tipo_afec_i_producto->codigo;
            } else {
                $afec = $f_reg->servicio->tipo_afec_i_serv->codigo;
            }

            if (in_array($afec, array("10", "11", "12", "13", "14", "15", "16", "17"))) { // gravada
                $igv_f = ($f_reg->precio * $f_reg->cantidad) * (($igv->igv_total) / 100) + $igv_f;
                $precio = ($f_reg->precio * $f_reg->cantidad)  + $precio;
            } else {
                $precio = ($f_reg->precio * $f_reg->cantidad) + $precio;
            }
            $total = $igv_f + $precio;
        }
        // return $total;
        //VALORES DE LSO 3
        // return $final_1; // -> cabecera
        // return $cuota_sum; //  -> cuotas
        // return $total; //  -> array

        if ($cuota_sum != $total) {
            if ($total > $cuota_sum) {
                $diferencia = $total - $cuota_sum;
                $diferencia_2 = round($diferencia, 3);
                //cambio de la ultima cuota en centesimas para 2 decimales
                $cuotas_cre = Cuotas_credito::where('facturacion_m_id', $id)->latest()->first();

                $cuotas_cre->monto = $cuotas_cre->monto + round($diferencia_2, 2);
                $cuotas_cre->save();
            } else {
                $diferencia =  $cuota_sum - $total;
                $diferencia_2 = round($diferencia, 3);
                $cuotas_cre = Cuotas_credito::where('facturacion_m_id', $id)->latest()->first();
                $cuotas_cre->monto = $cuotas_cre->monto - round($diferencia_2, 2);
                $cuotas_cre->save();
            }
        }
    }

    public static function count_month_comprobantes($fecha)
    {
        //CANTIDAD DE COTIZACIONES Formato = 02-09-2023"
        // $fecha = "02-09-2023";
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $year = date('Y', strtotime($fecha_conv)); // Obtiene el año de la fecha
        $month = date('m', strtotime($fecha_conv)); // Obtiene el mes de la fecha
        $cotizaciones  = Facturacion_m::whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
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

    public static function total_sum_datatable($request, $startDate, $endDate)
    {
        // Data
        $igv = Igv::first()->renta;
        // FILTRADO
        $filter = $request->get('value');
        // Busqueda en DB
        $query = Facturacion_m::with(['cliente', 'moneda', 'forma_pago'])
            ->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        //  Filtro
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

    public static function estado_sunat($id)
    {
        $factura = Facturacion_m::find($id);
        switch ($factura->f_electronica) {
            case '1':
                // $estado_sunat = "Enviado";
                $estado_sunat = 1;
                break;
            case '2':
                // $estado_sunat = "Anulado";
                $estado_sunat = 2;
                break;
            default:
                // $estado_sunat = "Sin enviar";
                $estado_sunat = 0;
                break;
        }
        return $estado_sunat;
    }

    public static function estado_nota_credito($id)
    {
        $factura = Facturacion_m::find($id);
        $nota_credito = Nota_Credito::where('facturacion_m_id', $factura->id)->first();
        if (!$nota_credito) {
            return 99;
        }
        switch ($nota_credito->n_electronica) {
            case '1':
                // $estado_sunat = "Enviado";
                $estado_sunat = 1;
                break;
            case '2':
                // $estado_sunat = "Anulado";
                $estado_sunat = 2;
                break;
            default:
                // $estado_sunat = "Sin enviar";
                $estado_sunat = 0;
                break;
        }
        return $estado_sunat;
    }
    public static function estado_nota_debito($id)
    {
        $factura = Facturacion_m::find($id);
        $nota_debito = Nota_Debito::where('facturacion_m_id', $factura->id)->first();
        if (!$nota_debito) {
            return 99;
        }
        switch ($nota_debito->n_electronica) {
            case '1':
                // $estado_sunat = "Enviado";
                $estado_sunat = 1;
                break;
            case '2':
                // $estado_sunat = "Anulado";
                $estado_sunat = 2;
                break;
            default:
                // $estado_sunat = "Sin enviar";
                $estado_sunat = 0;
                break;
        }
        return $estado_sunat;
    }
}
