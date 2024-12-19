<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Boleta extends Model
{
    protected $table = 'boleta';

    protected $guarded = [];

    protected $with = ['producto', 'cliente'];

    // protected $with = ['cliente'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'id_cotizador');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function forma_pago()
    {
        return $this->belongsTo(Forma_pago::class, 'forma_pago_id');
    }
    public function moneda()
    {
        return $this->belongsTo(Moneda::class, 'moneda_id');
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    public static function revision_cuotas($id)
    {

        $igv = Igv::first();
        $boleta = Boleta::find($id);
        //dato 1 -- multiplicacion de operaciones + igv
        $op_grav = $boleta->op_gravada;
        $sub_tot = ($op_grav * ($igv->igv_total / 100));


        $op_ina = $boleta->op_inafecta;
        $op_exo = $boleta->op_exonerada;
        $op_grat = $boleta->op_gratuita;
        $subtotal = $boleta->op_gravada + $op_exo + $op_ina + $op_grat;
        $final_1 = $subtotal + $sub_tot;

        //dato 2 -- suma de cuotasp
        $cuotas_cre = Cuotas_credito::where('boleta_id', $id)->get();
        $cuota_sum = 0;
        foreach ($cuotas_cre as $key => $cuota) {
            $cuota_sum += $cuota->monto;
        }

        //dato 3 -- suma de registros
        $boleta_reg = Boleta_registro::where('boleta_id', $boleta->id)->get();
        $igv_f = 0;
        $gravada = 0;
        $precio = 0;
        foreach ($boleta_reg as $key => $bol_r) {
            if (isset($bol_r->producto->codigo_producto)) {
                $afec = $bol_r->producto->tipo_afec_i_producto->codigo;
            } else {
                $afec = $bol_r->servicio->tipo_afec_i_serv->codigo;
            }

            if (in_array($afec, array("10", "11", "12", "13", "14", "15", "16", "17"))) { // gravada
                $igv_f = ($bol_r->precio * $bol_r->cantidad) * (($igv->igv_total) / 100) + $igv_f;
                $precio = ($bol_r->precio * $bol_r->cantidad)  + $precio;
            } else {
                $precio = ($bol_r->precio * $bol_r->cantidad) + $precio;
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
                $cuotas_cre = Cuotas_credito::where('boleta_id', $id)->latest()->first();

                $cuotas_cre->monto = $cuotas_cre->monto + round($diferencia_2, 2);
                $cuotas_cre->save();
            } else {
                $diferencia =  $cuota_sum - $total;
                $diferencia_2 = round($diferencia, 3);
                $cuotas_cre = Cuotas_credito::where('boleta_id', $id)->latest()->first();
                $cuotas_cre->monto = $cuotas_cre->monto - round($diferencia_2, 2);
                $cuotas_cre->save();
            }
        }
    }

    public static function total_sum_datatable($request, $startDate, $endDate)
    {
        // Data
        $igv = Igv::first()->renta;
        // FILTRADO
        $filter = $request->get('value');
        // Busqueda en DB
        $query = Boleta::with(['cliente', 'moneda', 'forma_pago'])
            ->whereBetween('created_at', [$startDate, $endDate])->orderBy('created_at', 'desc');

        //  Filtro
        if (!empty($filter)) {
            // Agrupar las condiciones de búsqueda en una única cláusula where
            $query->where(function ($q) use ($filter) {
                $q->where('cod_boleta', 'like', '%' . $filter . '%');
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

    public static function count_month_ventas($fecha)
    {
        //CANTIDAD DE COTIZACIONES Formato = 02-09-2023"
        // $fecha = "02-09-2023";
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $year = date('Y', strtotime($fecha_conv)); // Obtiene el año de la fecha
        $month = date('m', strtotime($fecha_conv)); // Obtiene el mes de la fecha
        $cotizaciones  = Boleta::whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
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

        $mes = array(
            "cantidad" => $cotizaciones->count(),
            "total" => number_format(round($total, 2), 2)
        );

        return $mes;
    }

    public static function estado_sunat($id)
    {
        $boleta = Boleta::find($id);
        switch ($boleta->f_electronica) {
            case '1':
                $estado_sunat = "Enviado";
                break;
            case '2':
                $estado_sunat = "Anulado";
                break;
            default:
                $estado_sunat = "Sin enviar";
                break;
        }
    }
}
