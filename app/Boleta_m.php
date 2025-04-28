<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boleta_m extends Model
{
    protected $table = 'boleta_m';

	protected $guarded = [];

    public function forma_pago(){
        return $this->belongsTo(Forma_pago::class,'forma_pago_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }
     public function moneda(){
        return $this->belongsTo(Moneda::class,'moneda_id');
    }

    public static function revision_cuotas($id){

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
            }else{
                $afec = $bol_m_r->servicio->tipo_afec_i_serv->codigo;
            }

            if (in_array($afec, array("10", "11", "12", "13", "14", "15", "16", "17"))) { // gravada
                $igv_f = ($bol_m_r->precio * $bol_m_r->cantidad) * (($igv->igv_total) / 100) + $igv_f;
                $precio = ($bol_m_r->precio * $bol_m_r->cantidad)  + $precio;
            }else{
                $precio = ($bol_m_r->precio * $bol_m_r->cantidad ) + $precio;
            }
            $total = round(($igv_f + $precio), 2);
        }
        // return $total;
        //VALORES DE LSO 3
        // return $final_1; // -> cabecera
        // return $cuota_sum; //  -> cuotas
        // return $total; //  -> array

        if($cuota_sum != $total){
            if ( $total > $cuota_sum ) {
                $diferencia = $total - $cuota_sum;
                $diferencia_2 = round($diferencia, 3);
                //cambio de la ultima cuota en centesimas para 2 decimales
                $cuotas_cre = Cuotas_credito::where('boleta_m_id', $id)->latest()->first();
                
                $nuevoMonto = $cuotas_cre->monto + round($diferencia_2, 2);
                $cuotas_cre->update([
                    'monto' => $nuevoMonto
                ]);
            }else{
                $diferencia =  $cuota_sum - $total;
                $diferencia_2 = round($diferencia, 3);
                $cuotas_cre = Cuotas_credito::where('boleta_m_id', $id)->latest()->first();
                $nuevoMonto = $cuotas_cre->monto - round($diferencia_2, 2);
                $cuotas_cre->update([
                    'monto' => $nuevoMonto
                ]);
            }

        }
    }
    public static function search_motivo_nc($id){
        $boleta = Boleta_m::find($id);
        $nota_credito = Nota_Credito::where('boleta_m_id',$boleta->id)->first();
        switch($nota_credito->motivo){
            case(01):
                $motivo_desc = 'Anulacion de la operacion';
                break;  
            case(02):
                $motivo_desc = 'Anulacion por error en el ruc';
                break;  
            case(03):
                $motivo_desc = 'Correcion por error en la descripcion';
                break;
            case(06):
                $motivo_desc = 'Devolucion total';
                break;
            case(07):
                $motivo_desc = 'Devolucion por Item';
                break;
        }
        return $motivo_desc;
     }
     public static function nota_credito_id($id){
        $boleta = Boleta_m::find($id);
        $nota_credito = Nota_Credito::where('boleta_m_id',$boleta->id)->first();
        if($nota_credito){
            return $nota_credito->id;
        }
     }
}
