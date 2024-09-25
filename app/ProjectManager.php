<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Cliente;
use App\ProjectService;
use Carbon\Carbon;

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
    
    protected $dates = ['fecha_inicio', 'fecha_cierre'];
    
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
    
    public function activities(){
        return $this->hasMany(Activity::class, 'proyecto_id');
    }
    
    public function getPriority()
    {
        $priorities = [
            1 => "Alta",
            2 => "Media",
            3 => "Baja",
        ];

        return $priorities[$this->prioridad] ?? "No definido";
    }

    public function calculateDifferenceDays(): int
    {
        return $this->fecha_inicio->diffInDays($this->fecha_cierre);
    }

    public function calculateDifferenceWeeks(): int
    {
        return $this->fecha_inicio->diffInWeeks($this->fecha_cierre);
    }

    public function calculateDaysToDateStart(Carbon $date): int
    {
        return $date->diffInDays($this->fecha_inicio);
    }

    public function calculateWeeksToDateStart(Carbon $date): int
    {
        return $date->diffInWeeks($this->fecha_inicio);
    }

    public function calculateDaysToDateClosing(Carbon $date): int
    {
        return $date>diffInDays($this->fecha_cierre);
    }

    public function calculateWeeksToDateClosing(Carbon $date): int
    {
        return $date->diffInWeeks($this->fecha_cierre);
    }
}
