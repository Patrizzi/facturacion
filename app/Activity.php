<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Activity extends Model
{
    protected $table = 'activities';

    protected $guarded = [];

    protected $attributes = [
        // Valores por defecto al crear una instancia
    ];
    
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

    // Funciones

    public function getStatus()
    {
        $statuses = self::getStatuses();
    
        return $this->estado ? $statuses[$this->estado] ?? "No definido" : "No definido";
    }

    public static function getStatuses(...$fields)
    {
        // Definir los estados con los atributos disponibles
        $statuses = [
            1 => ['text' => 'En progreso', 'icon' => 'fa fa-spinner'],
            2 => ['text' => 'Reprogramando', 'icon' => 'fa fa-calendar'],
            3 => ['text' => 'Retraso', 'icon' => 'fa fa-exclamation-triangle'],
            4 => ['text' => 'Cancelado', 'icon' => 'fa fa-times'],
            5 => ['text' => 'Terminado', 'icon' => 'fa fa-check'],
        ];
    
        $defaultValues = [
            'text' => 'No definido',
            'icon' => 'fa fa-question',
        ];
    
        if (empty($fields)) {
            return array_map(fn($status) => $status['text'] ?? $defaultValues['text'], $statuses);
        }
    
        // Devuelve solo los campos solicitados, usando valores predeterminados si faltan
        return array_map(function($status) use ($fields, $defaultValues) {
            $result = [];
            foreach ($fields as $field) {
                $result[$field] = $status[$field] ?? $defaultValues[$field];
            }
            return $result;
        }, $statuses);
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

    // Relaciones
    
    public function project_manager(){
        return $this->belongsTo(ProjectManager::class, 'proyecto_id');
    }

    public function responsable(){
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function tasks(){
        return $this->hasMany(Task::class, 'actividad_id');
    }
}