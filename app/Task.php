<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $guarded = [];
    
    protected $fillable = [
        'actividad_id', 
        'user_id', 
        'contenido', 
        'fecha_inicio', 
        'fecha_cierre', 
        'estado'
    ];
    
    protected $dates = ['fecha_inicio', 'fecha_cierre'];

    public function actividad(){
        return $this->belongsTo(Activity::class, 'actividad_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'tarea_id');
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
