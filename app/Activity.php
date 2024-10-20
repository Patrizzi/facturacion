<?php

namespace App;

use Carbon\Carbon;
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
        $statuses = self::getStatuses();
    
        return $this->estado ? $statuses[$this->estado] ?? "No definido" : "No definido";
    }

    public static function getStatuses()
    {
        return [
            1 => "En progreso",
            2 => "Reprogramando",
            3 => "Retraso",
            4 => "Cancelado",
            5 => "Terminado",
        ];
    }

    public function percentage(): int {
        return 100;
    }

    public function diffDays(): int {
        return $this->fecha_inicio->diffInDays($this->fecha_cierre);
    }

    public function diffWeeks(): int {
        return $this->fecha_inicio->diffInWeeks($this->fecha_cierre);
    }

    public function daysToStart(Carbon $date): int {
        return $this->fecha_inicio->diffInDays($date);
    }

    public function daysToEnd(Carbon $date): int {
        return $this->fecha_cierre->diffInDays($date);
    }
}