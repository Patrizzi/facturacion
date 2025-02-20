<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GarantiaGuiaEgreso extends Model
{
    protected $table = 'garantia_guia_egreso';

    protected $fillable = [
        'motivo',
        'fecha',
        'orden_servicio',
        'estado',
        'egresado',
        'asunto',
        'nombre_equipo',
        'numero_serie',
        'codigo_interno',
        'fecha_compra',
        'descripcion_problema',
        'revision_diagnostico',
        'estetica',
        'marca_id',
        'personal_lab_id',
        'cliente_id',
        'contacto_cliente_id',
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
        return $this->belongsTo(Personal::class,'personal_id');
    }

    //para el cliente
    public function clientes_i(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }

    //para el contacto del cliente
    public function contactos(){
        return $this->belongsTo(Contacto::class,'cliente_id');
    }
}
