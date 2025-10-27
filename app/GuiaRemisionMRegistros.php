<?php
// App/GuiaRemisionMRegistros.php
namespace App;

use Illuminate\Database\Eloquent\Model;

class GuiaRemisionMRegistros extends Model
{
    protected $table = 'guia_remision_m_registros';
    protected $guarded = [];

    // ✅ Cast para que number_format() no falle aunque la columna sea varchar
    protected $casts = [
        'cantidad' => 'float',
        'peso'     => 'float',
    ];

    // ✅ Producto (con default para evitar null->prop)
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id')->withDefault();
    }

    // ✅ Guía manual (FK: guia_remision_m_id)
    public function guia()
    {
        return $this->belongsTo(GuiaRemisionManual::class, 'guia_remision_m_id');
    }
}

