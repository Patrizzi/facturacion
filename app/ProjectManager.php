<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Cliente;
use App\ProjectService;

class ProjectManager extends Model
{
    protected $table = 'project_managers';

    protected $guarded = [];
    
    protected $fillable = [
        'ruc', 
        'nombre', 
        'centro_costo', 
        'administrador_id', 
        'responsable_id', 
        'cliente_id', 
        'project_service_id', 
        'fecha_inicio', 
        'fecha_cierre', 
        'prioridad'
    ];
    
    public function administrador(){
        return $this->belongsTo(User::class, 'administrador_id');
    }

    public function responsable(){
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function project_service(){
        return $this->belongsTo(ProjectService::class, 'project_service_id');
    }
}
