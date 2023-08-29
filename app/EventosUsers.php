<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventosUsers extends Model
{
    public function users(){
        return $this->belongsTo(User::class,'evento_id');
    } 
}
