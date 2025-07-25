<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
	protected $table = 'personal';

	protected $fillable = [
		'nombres',
		'apellidos',
		'fecha_nacimiento',
		'celular',
		'telefono',
		'email',
		'genero',
		'documento_identificacion',
		'numero_documento',
		'nacionalidad',
		'estado_civil',
		'nivel_educativo',
		'profesion',
		'direccion',
		'licencia',
		'estado_trabajador_laboral',
		'estado',
		'usuario_registrado',
		'foto',
	];


	protected $guarded = [];


	public function datos_laborales(){
		return $this->hasOne(Personal_datos_laborales::class, 'personal_id');
	}

	public function getFullNameAttribute()
	{
		return $this->nombres . ' ' . $this->apellidos;
	}
}
