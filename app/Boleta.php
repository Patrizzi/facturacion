<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boleta extends Model
{
	protected $table='boleta';

    protected $guarded=[];

    protected $with = ['producto','cliente'];
    
    // protected $with = ['cliente'];

    public function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }

    public function cotizacion(){
        return $this->belongsTo(Cotizacion::class,'id_cotizador');
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function forma_pago(){
        return $this->belongsTo(Forma_pago::class,'forma_pago_id');
    }
    public function moneda(){
        return $this->belongsTo(Moneda::class,'moneda_id');
    }

    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    }
    public function almacen(){
        return $this->belongsTo(Almacen::class,'almacen_id');
    }
    
    public static function revision_cuotas($id){

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
            }else{
                $afec = $bol_r->servicio->tipo_afec_i_serv->codigo;
            }

            if (in_array($afec, array("10", "11", "12", "13", "14", "15", "16", "17"))) { // gravada
                $igv_f = ($bol_r->precio * $bol_r->cantidad) * (($igv->igv_total) / 100) + $igv_f;
                $precio = ($bol_r->precio * $bol_r->cantidad)  + $precio;
            }else{
                $precio = ($bol_r->precio * $bol_r->cantidad ) + $precio;
            }
            $total = $igv_f + $precio;
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
                $cuotas_cre = Cuotas_credito::where('boleta_id', $id)->latest()->first();
                
                $cuotas_cre->monto = $cuotas_cre->monto + round($diferencia_2, 2);
                $cuotas_cre->save();
            }else{
                $diferencia =  $cuota_sum - $total;
                $diferencia_2 = round($diferencia, 3);
                $cuotas_cre = Cuotas_credito::where('boleta_id', $id)->latest()->first();
                $cuotas_cre->monto = $cuotas_cre->monto - round($diferencia_2, 2);
                $cuotas_cre->save();
            }

        }
    }
}
