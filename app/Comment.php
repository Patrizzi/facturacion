<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';

    protected $guarded = [];
    
    protected $fillable = [
        'tarea_id', 
        'user_id', 
        'contenido', 
        'foto'
    ];

    public function task(){
        return $this->belongsTo(Task::class, 'tarea_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
