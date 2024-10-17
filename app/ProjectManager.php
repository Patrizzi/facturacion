<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Cliente;
use App\ProjectService;
use Carbon\Carbon;

class ProjectManager extends Model {
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

    public function administrador() {
        return $this->belongsTo(User::class, 'administrador_id');
    }

    public function responsable() {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function cliente() {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function project_service() {
        return $this->belongsTo(ProjectService::class, 'project_service_id');
    }

    public function activities() {
        return $this->hasMany(Activity::class, 'proyecto_id');
    }

    public function getPriority() {
        $priorities = self::getPriorities();

        return $this->prioridad ? ($priorities[$this->prioridad] ?? "No definido") : "No definido";
    }

    public static function getPriorities() {
        return [
            1 => "Alta",
            2 => "Media",
            3 => "Baja",
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
