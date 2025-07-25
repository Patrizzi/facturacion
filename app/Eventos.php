<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eventos extends Model
{
    public function clientes(){
        return $this->belongsTo(Cliente::class,'cliente_id');
    } 
    public function category(){
        return $this->belongsTo(CategoriasEventos::class,'categori_id');
    } 

    public function getseguimientoattributes(){
        switch ($this->estado_seguimiento) {
            case 1:
                return 'Sin Seguimiento';
            case 2:
                return 'Pendiente';
            case 3:
                return 'En progreso';
            case 4:
                return 'Completada';
            case 5:
                return 'Cancelada';
            default:
                return 'Desconocido';
        }
    }
}