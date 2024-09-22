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

    public function projectManager(){
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

    public function createdTime()
    {
        $timeElapsed = now()->diffInSeconds($this->created_at);
        
        switch (true) {
            case $timeElapsed < 60:
                return "{$timeElapsed}s";
            case $timeElapsed < 3600:
                return floor($timeElapsed / 60) . "min";
            case $timeElapsed < 86400:
                return floor($timeElapsed / 3600) . "h";
            case $timeElapsed < 2592000:
                return floor($timeElapsed / 86400) . "d";
            case $timeElapsed < 31536000:
                return floor($timeElapsed / 2592000) . "m";
            default:
                return floor($timeElapsed / 31536000) . "a";
        }
    }
}
