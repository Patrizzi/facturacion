<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Personal_datos_laborales extends Model
{
    protected $table = 'personal_datos_laborales';

    protected $guarded = [];

    public function personal_l(){
        return $this->belongsTo(Personal::class,'personal_id');
    }

    public function personal_venta(){
        return $this->hasOne(Personal_venta::class, 'id_personal');
    }

    public function getFechaVinculacionAttribute()
	{
		if($this->attributes['fecha_vinculacion'] != null){
            return Carbon::parse($this->attributes['fecha_vinculacion'])->format('d/m/Y');
        }else{
            return 'Sin Registro';
        }

	}
}
