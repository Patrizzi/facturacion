<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Provedor extends Model
{
    protected $table = 'provedores';

	protected $guarded = [];

    public function getFechaCreacionAttribute(){
        $fecha_creacion = Carbon::parse($this->attributes['create_at'])->format('d-m-Y');
        return $fecha_creacion;
    }
}