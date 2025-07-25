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

    public function getFechaVinculacionAttribute()
	{
		return Carbon::parse($this->attributes['fecha_vinculacion'])->format('d/m/Y');
	}
}
