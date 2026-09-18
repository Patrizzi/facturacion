<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Garantia extends Model
{
    protected $table = 'garantia';

	protected $guarded = [];
    
	// public function personal(){
 //        return $this->belongsTo(Personal::class,'responsable');
 //    }
}
