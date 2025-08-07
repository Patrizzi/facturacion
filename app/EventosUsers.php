<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class EventosUsers extends Model
{
    public function users(){
        return $this->belongsTo(User::class,'user_id');
    } 

    public static function get_user_events(){
    
        if(auth()->user()->id == 1){
            $events = Eventos::where('fecha_inicio', '<=' , Carbon::now())->where('fecha_final', '>=' , Carbon::now())->get();
            return $events->count();
        }else{  
            $event_user = EventosUsers::where('user_id',auth()->user()->id)->get();
            $events = Eventos::whereIn('id',$event_user->pluck('evento_id'))->where('fecha_inicio', '<=' , Carbon::now())->where('fecha_final', '>=' , Carbon::now())->get();
            return $events->count();
        }
    }
}
