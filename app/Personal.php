<?php

namespace App;

use Carbon\Carbon;
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

	protected $appends = ['full_name'];

	public function datos_laborales(){
		return $this->hasOne(Personal_datos_laborales::class, 'personal_id');
	}

	public function users(){
		return $this->belongsTo(User::class);
	}

	public function getFullNameAttribute()
	{
		return $this->nombres . ' ' . $this->apellidos;
	}

	public function getFechaNacimientoAttribute()
	{
		$fecha_nacimiento = Carbon::parse($this->attributes['fecha_nacimiento'])->format('d-m-Y');
        return $fecha_nacimiento;
	}
	public function getGeneroAttribute(){
		$genero = ucwords($this->attributes['genero']);
        return $genero;
	}
	public function getFechaVinculacionAttribute(){
		$fecha_nacimiento = Carbon::parse($this->attributes['fecha_vinculacion'])->format('d-m-Y');
        return $fecha_nacimiento;
	}
	public function getFechaRetiroAttribute(){
		$fecha_nacimiento = Carbon::parse($this->attributes['fecha_retiro'])->format('d-m-Y');
        return $fecha_nacimiento;
	}
	public function getUserCreateAttribute(){
		if($this->users){
			return "1";
		}else{
			return "2";
		}
	}
}
