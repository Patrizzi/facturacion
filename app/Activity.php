<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';

    protected $guarded = [];
    
    protected $fillable = [
        'proyecto_id', 
        'responsable_id', 
        'nombre', 
        'contenido', 
        'fecha_inicio', 
        'fecha_cierre', 
        'estado', 
        'color', 
        'foto'
    ];

    protected $dates = ['fecha_inicio', 'fecha_cierre'];

    public function project_manager(){
        return $this->belongsTo(ProjectManager::class, 'proyecto_id');
    }

    public function responsable(){
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function tasks(){
        return $this->hasMany(Task::class, 'actividad_id');
    }

    public function getStatus()
    {
        $statuses = [
            1 => "En progreso",
            2 => "Reprogramando",
            3 => "Retraso",
            4 => "Cancelado",
            5 => "Terminado",
        ];
    
        return $statuses[$this->estado] ?? "No definido";
    }
}