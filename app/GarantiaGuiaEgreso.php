<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GarantiaGuiaEgreso extends Model
{
    protected $table = 'garantia_guia_egreso';

    protected $fillable = [
        'fecha', 'orden_servicio', 'estado', 'egresado', 'informe_tecnico',
        'descripcion_problema', 'diagnostico_solucion', 'recomendaciones',
        'created_at', 'updated_at'
    ];

    protected $guarded = [];

    public function garantia_ingreso_i(){
        return $this->belongsTo(GarantiaGuiaIngreso::class,'garantia_ingreso_id');
    }

    public function marcas_i(){
        return $this->belongsTo(Marca::class,'marca_id');
    }

    //para el ingeniero asignado
    public function personal_laborales(){
        return $this->hasOneThrough(
            Personal::class, GarantiaGuiaIngreso::class,
            'id', 'id',
            'garantia_ingreso_id', 'personal_lab_id'
        );
    }

    //para el cliente
    public function clientes_i(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }

    //para el contacto del cliente
    public function contactos(){
        return $this->belongsTo(Contacto::class,'cliente_id');
    }

    public static function count_month_comprobantes($mes_año)
    {
        $count = self::whereMonth('fecha', '=', $mes_año->month)
            ->whereYear('fecha', '=', $mes_año->year)
            ->count();

        return $count;
    }
}
