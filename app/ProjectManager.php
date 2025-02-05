<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\User;
use App\Cliente;
use App\ProjectService;

class ProjectManager extends Model {
    protected $table = 'project_managers';

    protected $guarded = [];

    protected $attributes = [
        // Valores por defecto al crear una instancia
    ];

    protected $fillable = [
        'ruc',
        'nombre',
        'centro_costo',
        'administrador_id',
        'responsable_id',
        'cliente_id',
        'service_id',
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

    public function servicio() {
        return $this->belongsTo(Servicios::class, 'service_id');
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
}
