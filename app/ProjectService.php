<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectService extends Model
{
    protected $table = 'project_services';
    
    protected $guarded = [];
    
    protected $fillable = [
        'nombre'
    ];

    public function project_manager(){
        return $this->hasMany(ProjectManager::class);
    }
}
