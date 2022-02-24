<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Boleta;
use App\Boleta_registro;
use App\Cotizacion;
use App\Cotizacion_boleta_registro;

class Sentencia extends Model
{
    public static function boleta(){
        //Llamado general de boletas para su respectivo bucle
        $boletas=Boleta::all();
        foreach($boletas as  $e =>  $boleta){
            $boleta->op_gravada=0;
            $boleta->op_exonerada=0;
            $boleta->op_inafecta=0;
            $boletas_registros=Boleta_registro::where('boleta_id',$boleta->id)->get();
            foreach($boletas_registros as  $e =>  $boleta_registro){
                $boleta_registro->precio_unitario_desc=round($boleta_registro->precio_unitario_desc/1.18,2);
                $boleta_registro->precio_unitario_comi=round($boleta_registro->precio_unitario_comi/1.18,2);
                $boleta_registro->save();
                if(isset($boleta_registro->producto_id)){
                    if(strpos($boleta_registro->producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                        $boleta->op_gravada += (round($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad,2));
                    }
                    if(strpos($boleta_registro->producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                        $boleta->op_exonerada += (round($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad,2));
                    }
                    if(strpos($boleta_registro->producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                        $boleta->op_inafecta += (round($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad,2));
                    }
                }elseif(isset($boleta_registro->servicio_id)){
                    if(strpos($boleta_registro->servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                        $boleta->op_gravada += (round($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad,2));
                    }
                    if(strpos($boleta_registro->servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                        $boleta->op_exonerada += (round($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad,2));
                    }
                    if(strpos($boleta_registro->servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                        $boleta->op_inafecta += (round($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad,2));
                    }
                }
            }
            $boleta->save();
        }
        return "cambio realizado";
    }

    public static function cotizacion(){
        //Llamado general de cotizaciones para su respectivo bucle
        $cotizaciones=Cotizacion::where('tipo','boleta')->get();
        foreach($cotizaciones as $e =>  $cotizacion){
            $cotizacion->op_gravada=0;
            $cotizacion->op_exonerada=0;
            $cotizacion->op_inafecta=0;
            $cotizacion_boletas_registros=Cotizacion_boleta_registro::where('cotizacion_id',$cotizacion->id)->get();
            
            foreach($cotizacion_boletas_registros as  $e =>  $cotizacion_boleta_registro){
                $cotizacion_boleta_registro->precio_unitario_desc=round($cotizacion_boleta_registro->precio_unitario_desc/1.18,2);
                $cotizacion_boleta_registro->precio_unitario_comi=round($cotizacion_boleta_registro->precio_unitario_comi/1.18,2);
                $cotizacion_boleta_registro->save();
                if(isset($cotizacion_boleta_registro->producto_id)){
                    if(strpos($cotizacion_boleta_registro->producto->tipo_afec_i_producto->informacion,'Gravado') !== false){
                        $cotizacion->op_gravada += (round($cotizacion_boleta_registro->precio_unitario_comi*$cotizacion_boleta_registro->cantidad,2));
                    }
                    if(strpos($cotizacion_boleta_registro->producto->tipo_afec_i_producto->informacion,'Exonerado') !== false){
                        $cotizacion->op_exonerada += (round($cotizacion_boleta_registro->precio_unitario_comi*$cotizacion_boleta_registro->cantidad,2));
                    }
                    if(strpos($cotizacion_boleta_registro->producto->tipo_afec_i_producto->informacion,'Inafecto') !== false){
                        $cotizacion->op_inafecta += (round($cotizacion_boleta_registro->precio_unitario_comi*$cotizacion_boleta_registro->cantidad,2));
                    }
                }elseif(isset($cotizacion_boleta_registro->servicio_id)){
                    if(strpos($cotizacion_boleta_registro->servicio->tipo_afec_i_serv->informacion,'Gravado') !== false){
                        $cotizacion->op_gravada += (round($cotizacion_boleta_registro->precio_unitario_comi*$cotizacion_boleta_registro->cantidad,2));
                    }
                    if(strpos($cotizacion_boleta_registro->servicio->tipo_afec_i_serv->informacion,'Exonerado') !== false){
                        $cotizacion->op_exonerada += (round($cotizacion_boleta_registro->precio_unitario_comi*$cotizacion_boleta_registro->cantidad,2));
                    }
                    if(strpos($cotizacion_boleta_registro->servicio->tipo_afec_i_serv->informacion,'Inafecto') !== false){
                        $cotizacion->op_inafecta += (round($cotizacion_boleta_registro->precio_unitario_comi*$cotizacion_boleta_registro->cantidad,2));
                    }
                }
            }
            $cotizacion->save();
        }
        return "cambio realizado";
    }
    /* Route::get('sentencia1', function (App\Sentencia $post) {
        return $post->boleta();
    });
    Route::get('sentencia2', function (App\Sentencia $post) {
        return $post->cotizacion();
    }); */
    
}
