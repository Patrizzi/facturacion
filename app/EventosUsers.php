<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventosUsers extends Model
{
    public function users(){
        return $this->belongsTo(User::class,'user_id');
    } 
}
