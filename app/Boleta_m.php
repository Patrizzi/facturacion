<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Boleta_m extends Model
{
    protected $table = 'boleta_m';

    protected $guarded = [];

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

    public static function revision_cuotas($id)
    {

        $igv = Igv::first();
        $boleta_m = Boleta_m::find($id);
        //dato 1 -- multiplicacion de operaciones + igv
        $op_grav = $boleta_m->op_gravada;
        $sub_tot = ($op_grav * ($igv->igv_total / 100));


        $op_ina = $boleta_m->op_inafecta;
        $op_exo = $boleta_m->op_exonerada;
        $op_grat = $boleta_m->op_gratuita;
        $subtotal = $boleta_m->op_gravada + $op_exo + $op_ina + $op_grat;
        $final_1 = $subtotal + $sub_tot;

        //dato 2 -- suma de cuotasp
        $cuotas_cre = Cuotas_credito::where('boleta_m_id', $id)->get();
        $cuota_sum = 0;
        foreach ($cuotas_cre as $key => $cuota) {
            $cuota_sum += $cuota->monto;
        }

        //dato 3 -- suma de registros
        $boleta_m_reg = Boleta_registros_m::where('boleta_m_id', $boleta_m->id)->get();
        $igv_f = 0;
        $gravada = 0;
        $precio = 0;
        foreach ($boleta_m_reg as $key => $bol_m_r) {
            if (isset($bol_m_r->producto->codigo_producto)) {
                $afec = $bol_m_r->producto->tipo_afec_i_producto->codigo;
            } else {
                $afec = $bol_m_r->servicio->tipo_afec_i_serv->codigo;
            }

            if (in_array($afec, array("10", "11", "12", "13", "14", "15", "16", "17"))) { // gravada
                $igv_f = ($bol_m_r->precio * $bol_m_r->cantidad) * (($igv->igv_total) / 100) + $igv_f;
                $precio = ($bol_m_r->precio * $bol_m_r->cantidad)  + $precio;
            } else {
                $precio = ($bol_m_r->precio * $bol_m_r->cantidad) + $precio;
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
                $cuotas_cre = Cuotas_credito::where('boleta_m_id', $id)->latest()->first();

                $cuotas_cre->monto = $cuotas_cre->monto + round($diferencia_2, 2);
                $cuotas_cre->save();
            } else {
                $diferencia =  $cuota_sum - $total;
                $diferencia_2 = round($diferencia, 3);
                $cuotas_cre = Cuotas_credito::where('boleta_m_id', $id)->latest()->first();
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
        $cotizaciones  = Boleta_m::whereYear('created_at', $year)->whereMonth('created_at', $month)->get();
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
}
