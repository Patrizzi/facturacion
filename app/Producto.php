<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model {
    protected $table = 'productos';
    protected $guarded = [];

    protected $fillable = [
        'codigo_producto',
        'codigo_original',
        'nombre',
        'utilidad',
        'precio_venta',
        'precio_impuesto',
        'descuento1',
        'descuento2',
        'descuento_maximo',
        'descripcion',
        'detalle',
        'origen',
        'garantia',
        'peso',
        'stock_minimo',
        'stock_maximo',
        'foto',
        'archivo',
        'estado_anular',
        'tipo_afectacion_id',
        'categoria_id',
        'familia_id',
        'subfamilia_id',
        'marca_id',
        'unidad_medida_id',
        'estado_id'
    ];

    // Relaciones con otras tablas (manteniendo los nombres originales)
    public function marcas_i_producto(){
        return $this->belongsTo(Marca::class,'marca_id');
    }

    public function categoria_i_producto(){
        return $this->belongsTo(Categoria::class,'categoria_id');
    }

    public function familia_i_producto(){
        return $this->belongsTo(Familia::class,'familia_id');
    }

    public function subfamilia_i_producto(){
        return $this->belongsTo(Subfamilia::class,'subfamilia_id');
    }

    public function moneda_i_producto(){
        return $this->belongsTo(Moneda::class,'monedas_id');
    }

    public function estado_i_producto(){
        return $this->belongsTo(Estado::class,'estado_id');
    }

    public function unidad_i_producto(){
        return $this->belongsTo(Unidad_medida::class,'unidad_medida_id');
    }

    public function tipo_afec_i_producto(){
        return $this->belongsTo(Tipo_afectacion::class,'tipo_afectacion_id');
    }
}
