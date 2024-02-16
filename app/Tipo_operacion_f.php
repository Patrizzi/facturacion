<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_operacion_f extends Model
{
    protected $table = 'tipo_operacion_fs';
    protected $guarded = [];

    public static function add_new_items(){
        $tipo_op  = Tipo_operacion_f::get();
        // return $tipo_op;
        foreach ($tipo_op as $key => $t_op) {
            if($t_op->informacion == 'Exportación'){
                $t_op->codigo = '0200';
                $t_op->save();
            }
            // if($t_op->informacion == ''){
            //     $t_op->codigo = '0200';
            //     $t_op->save();
            // }
        }
        $tipo_op2  = Tipo_operacion_f::where('codigo', '1001')->first();
        // dd($tipo_op);
        if (!isset($tipo_op2)) {
            //* GUARDADO DE  LOS NUEVOS
            $new_tipo = new Tipo_operacion_f();
            $new_tipo->codigo = '0201';
            $new_tipo->informacion = 'Exportación de Servicios - Prestación servicios realizados';
            $new_tipo->estado = 0;
            $new_tipo->save();
            $new_tipo = new Tipo_operacion_f();
            $new_tipo->codigo = '1001';
            $new_tipo->informacion = 'Operacion Sujeta a Detracción';
            $new_tipo->estado = 0;
            $new_tipo->save();
            $new_tipo = new Tipo_operacion_f();
            $new_tipo->codigo = '1002';
            $new_tipo->informacion = 'Operacion sujeta a detracción - Recursos Hidrobiológicos';
            $new_tipo->estado = 0;
            $new_tipo->save();
            $new_tipo = new Tipo_operacion_f();
            $new_tipo->codigo = '1003';
            $new_tipo->informacion = 'Operacion sujeta a detracción - Servicios de transporte pasajeros';
            $new_tipo->estado = 0;
            $new_tipo->save();
            $new_tipo = new Tipo_operacion_f();
            $new_tipo->codigo = '1004';
            $new_tipo->informacion = 'Operacion sujeta a detracción - Servicios de transporte de carga';
            $new_tipo->estado = 0;
            $new_tipo->save();
            $new_tipo = new Tipo_operacion_f();
            $new_tipo->codigo = '2001';
            $new_tipo->informacion = 'Operación Sujeta a Percepción';
            $new_tipo->estado = 0;
            $new_tipo->save();
            $new_tipo = new Tipo_operacion_f();
            $new_tipo->codigo = '2002';
            $new_tipo->informacion = 'Operación Sujeta a Retención de Renta de segunda categoría';
            $new_tipo->estado = 0;
            $new_tipo->save();
            $new_tipo = new Tipo_operacion_f();
            $new_tipo->codigo = '2100';
            $new_tipo->informacion = 'Créditos a empresas';
            $new_tipo->estado = 0;
            $new_tipo->save();

        }
    }
}
