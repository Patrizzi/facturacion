<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Model;

class GuiaRTraslado extends Model
{
    protected $table = 'g_remision_registros';

	protected $guarded = [];


    public static function codigo_guia_tr(){
        $ultima_entrada = GuiaRTraslado::orderby('created_at','DESC')->first();
        if(isset($ultima_entrada)){
            $numero = substr(strstr($ultima_entrada->codigo_guia, '-'), 1);
            $numero++;
            $cantidad_registro=str_pad($numero, 8, "0", STR_PAD_LEFT);
            $codigo_guia='GRT'.'-'.$cantidad_registro;
        }else{
            $cantidad_registro=str_pad('1', 8, "0", STR_PAD_LEFT);
            $codigo_guia='GRT'.'-'.$cantidad_registro;
        }
        return $codigo_guia;
    }
    public static function save_table_g_traslad($kardex_id,$cod_guia,$tipo_tra,$fecha_entr,$observaciones){

        // $kardex_entrada = Kardex_entrada::where('id',$kardex_id)->first();
        // $guia_tras = new GuiaRTraslado;
        // $guia_tras->id_kardex_distribucion = $kardex_entrada->id;
        // $guia_tras->cod_guia = $cod_guia;
        // $guia_tras->motivo = $kardex_entrada->motivo->motivo->nombre;
        // $guia_tras->tipo_transporte =
        // $guia_tras->fecha_emision = new DateTime();
        // $guia_tras->fecha_entrega = 
        // $guia_tras->almacen_emision = $kardex_entrada->almacen_emisor_id;
        // $guia_tras->almacen_receptor = $kardex_entrada->almacen_recpetor_id;
        // $guia_tras->observaciones = $observaciones;
        // $guia_tras->estado = 0; //* ESTADO 0 = ACTIVO
        // $guia_tras->save();

        // //KARDEX REGISTRO
        // // $kardex_reg = kardex_entrada_registro::where('kardex_entrada_id',$kardex_entrada->id)->get();
        // foreach ($kardex_reg as $index => $kard_reg) {
        //     $guia_tra_reg = new guia_r_traslado_registro();
        //     $guia_tra_reg->id_guia_r_traslado = $guia_tras->id;
        //     $guia_tra_reg->producto_id = $kard_reg->producto_id;
        //     $guia_tra_reg->stock = $
        //     $guia_tra_reg->unidad = 
        //     $guia_tra_reg->cantidad = 
        //     $guia_tra_reg->cantidad_total = 
        //     $guia_tra_reg->numero_series = 
        //     $guia_tra_reg->peso = 
        //     $guia_tra_reg->save();
        // }
        
    }
}
