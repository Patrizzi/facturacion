<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_operacion_f extends Model
{
    protected $table = 'tipo_operacion_fs';
    protected $guarded = [];

    public static function add_new_items(){
        $tipo_op  = Tipo_operacion_f::get();
        return $tipo_op;
        foreach ($tipo_op as $key => $t_op) {
            if($t_op->informacion == 'Exportación'){
                $t_op->codigo = '0200';
                $t_op->save();
            }
            if($t_op->informacion == 'Venta Interna'){
                $t_op->codigo = '0200';
                $t_op->save();
            }
        }
        //* GUARDADO DE  LOS NUEVOS
        $new_tipo = new Tipo_operacion_f();
        $new_tipo->codigo = '1001';
        $new_tipo->informacion = 'Operacion Sujeta a Detracción';
        // $new_tipo->estado =
        $new_tipo->save();
        $new_tipo = new Tipo_operacion_f();
        $new_tipo->codigo = '1002';
        $new_tipo->informacion = 'Operacion sujeta a detracción - Recursos Hidrobiológicos';
        // $new_tipo->estado =
        $new_tipo->save();
        $new_tipo = new Tipo_operacion_f();
        $new_tipo->codigo = '1003';
        $new_tipo->informacion = 'Operacion sujeta a detracción - Servicios de transporte pasajeros';
        // $new_tipo->estado =
        $new_tipo->save();
        $new_tipo = new Tipo_operacion_f();
        $new_tipo->codigo = '1004';
        $new_tipo->informacion = 'Operacion sujeta a detracción - Servicios de transporte de carga';
        // $new_tipo->estado =
        $new_tipo->save();
    }
}
