<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GarantiaGuiaIngreso extends Model
{
    protected $table = 'garantia_guia_ingreso';

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

    public function marcas_i(){
        return $this->belongsTo(Marca::class,'marca_id');
    }

    public function personal_laborales(){
        return $this->belongsTo(Personal::class,'personal_lab_id');
    }

    public function clientes_i(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    }

    public function contactos(){
        return $this->belongsTo(Contacto::class,'contacto_cliente_id');
    }


}
