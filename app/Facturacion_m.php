<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturacion_m extends Model
{
    protected $table = 'facturacion_m';

	protected $guarded = [];

    public function cotizacion(){
        return $this->belongsTo(Cotizacion::class,'id_cotizador');
    }

    public function cotizacion_servicio(){
        return $this->belongsTo(Cotizacion_Servicios::class,'id_cotizador_servicio');
    }

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

    public function producto(){
        return $this->belongsTo(Producto::class,'producto_id');
    }
    public function tipo_operacion(){
        return $this->belongsTo(Tipo_operacion_f::class,'tipo_operacion_id');
    }

    public static function revision_cuotas($id){

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
            }else{
                $afec = $f_reg->servicio->tipo_afec_i_serv->codigo;
            }

            if (in_array($afec, array("10", "11", "12", "13", "14", "15", "16", "17"))) { // gravada
                $igv_f = ($f_reg->precio * $f_reg->cantidad) * (($igv->igv_total) / 100) + $igv_f;
                $precio = ($f_reg->precio * $f_reg->cantidad)  + $precio;
            }else{
                $precio = ($f_reg->precio * $f_reg->cantidad ) + $precio;
            }
            $total = round(($igv_f + $precio), 2);
        }
        //VALORES DE LSO 3
        // return $final_1; // -> cabecera
        // return $cuota_sum; //  -> cuotas
        // return $total; //  -> array
        // return $total;
        if($cuota_sum != $total){
            if ( $total > $cuota_sum ) {
                $diferencia = $total - $cuota_sum;
                $diferencia_2 = round($diferencia, 3);
                //cambio de la ultima cuota en centesimas para 2 decimales\
                $cuotas_cre = Cuotas_credito::where('facturacion_m_id', $id)->latest()->first();
                $nuevoMonto =  $cuotas_cre->monto + round($diferencia_2, 2);
                $cuotas_cre->update([
                    'monto' => $nuevoMonto
                ]);
            }else{
                $diferencia =  $cuota_sum - $total;
                $diferencia_2 = round($diferencia, 3);
                $cuotas_cre = Cuotas_credito::where('facturacion_m_id', $id)->latest()->first();
                $nuevoMonto = $cuotas_cre->monto - round($diferencia_2, 2);
                // return $diferencia_2;
                // $cuotas_cre->monto = $cuotas_cre->monto - round($diferencia_2, 2);
                $cuotas_cre->update([
                    'monto' => $nuevoMonto
                ]);
            }

        }
    }
}
