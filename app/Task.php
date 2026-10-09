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

    // Funciones

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

    // Scopes

    

    // Relaciones

    public function activity(){
        return $this->belongsTo(Activity::class, 'actividad_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'tarea_id');
    }
}
