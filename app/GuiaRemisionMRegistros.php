<?php
// App/GuiaRemisionMRegistros.php
namespace App;

use Illuminate\Database\Eloquent\Model;

class GuiaRemisionMRegistros extends Model
{
    protected $table = 'guia_remision_m_registros';
    protected $guarded = [];

    protected $casts = [
        'cantidad' => 'float',
        'peso'     => 'float',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id')->withDefault();
    }

    public function guia()
    {
        return $this->belongsTo(GuiaRemisionManual::class, 'guia_remision_m_id');
    }
}

