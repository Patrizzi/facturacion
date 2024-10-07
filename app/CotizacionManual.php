<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CotizacionManual extends Model
{
    protected $table = 'cotizacion_manual';

    protected $guarded = [];
    
    public function cliente(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }
    public function forma_pago(){
        return $this->belongsTo(Forma_pago::class,'forma_pago_id');
    }
    public function personal(){
        return $this->belongsTo(Personal::class,'personal_id');
    }
    public function moneda(){
        return $this->belongsTo(Moneda::class,'moneda_id');
    }
    public function almacen(){
        return $this->belongsTo(Almacen::class,'almacen_id');
    }
    public function comisionista(){
        return $this->belongsTo(Personal_venta::class,'comisionista_id');
    }

     public function user_personal(){
        return $this->belongsTo(User::class,'user_id');
    }
    public static function count_mes($fecha){
        //CANTIDAD DE COTIZACIONES Formato = 02-09-2023"
        //  $fecha = "24-03-2022";
        $fecha_conv = Carbon::createFromFormat('d-m-Y', $fecha)->format('Y-m-d');
        $cotizacionesM  = CotizacionManual::whereDate('created_at', '=', $fecha_conv)->get();
        $moneda = Moneda::where('principal', '1')->first();
        $igv = Igv::first();
        //return $cotizacionesM;
        $total = 0;
        // PRECIOS DE COTIZACIONES X MES 
        foreach ($cotizacionesM as $cotim) {
            // condicional soles
            if($moneda->id == "1"){ //Si es soles retorno soles
                if($cotim->moneda->id == "1"){ //soles
                    $subtotal = $cotim->op_gravada + $cotim->op_inafecta + $cotim->op_exonerada;    
                    $total +=  $subtotal + ($cotim->op_gravada * ($igv->igv_total/100));
                }else{  //dolares
                    $subtotal_sin = $cotim->op_gravada + $cotim->op_inafecta + $cotim->op_exonerada;    
                    $subtotal = $subtotal_sin * $cotim->cambio;
                    $subtotal_dol = $cotim->op_gravada * $cotim->cambio;
                    $total +=  $subtotal + ($subtotal_dol * ($igv->igv_total/100));
                }
                // $total = "1";
                // return $total;
            }else{ // Si no retorno Dolares

                if($cotim->moneda->id == "1"){ //dolares
                    $subtotal_sin = $cotim->op_gravada + $cotim->op_inafecta + $cotim->op_exonerada;
                    $subtotal = $subtotal_sin / $cotim->cambio;
                    $subtotal_dol = $cotim->op_gravada / $cotim->cambio;
                    $total +=  $subtotal + ($cotim->op_gravada / ($igv->igv_total/100));
                }else{  //soels
                    $subtotal = $cotim->op_gravada + $cotim->op_inafecta + $cotim->op_exonerada;    
                    $total +=  $subtotal + ($cotim->op_gravada * ($igv->igv_total/100));
                }
                // $total = "2";
            }
        }
        
        $mes = array(
            "cantidad" => $cotizacionesM->count(),
            "total" => number_format(round($total,2),2)
            // "total_dolares" => $total_dolares
        );

        return $mes;
    }
}
