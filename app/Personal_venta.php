<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal_venta extends Model
{
   protected $table = 'personal_ventas';

    protected $guarded = [];

    public function personal(){
        return $this->belongsTo(Personal_datos_laborales::class,'id_personal');
    }

    public function getComisionAttribute(){
        $value = $this->attributes['comision'];
        if (is_null($value) || $value === '') {
            return 0; // o 0 si prefieres
        }

        // Normalizar (por si viene con espacios tipo " 5 % ")
        $value = trim($value);

        // Quitar % solo si existe
        if (str_contains($value, '%')) {
            $value = str_replace('%', '', $value);
        }

        return (float) $value;
    }

}
