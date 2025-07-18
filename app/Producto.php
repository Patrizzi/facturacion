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

    protected $appeds = [
        'marca',
        'unidad_medida',
        'stock',
        'precio_nacional',
        'precio_extranjero'
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

    //public function moneda_i_producto(){
    //    return $this->belongsTo(Moneda::class,'monedas_id');
    //}

    public function estado_i_producto(){
        return $this->belongsTo(Estado::class,'estado_id');
    }

    public function unidad_i_producto(){
        return $this->belongsTo(Unidad_medida::class,'unidad_medida_id');
    }

    public function tipo_afec_i_producto(){
        return $this->belongsTo(Tipo_afectacion::class,'tipo_afectacion_id');
    }

    public function stock_producto() {
        return $this->hasOne(Stock_producto::class, 'producto_id', 'id');
    }

    public static function porcentaje_productos(){
        $productos = Producto::count();
        if ($productos === 0) {
            $data = [
                'total' => $productos,
                'activos' => 0,
                'inactivos' => 0,
                'anulados' => 0
            ];
            return $data;
        }
        $productos_activos = Producto::where('estado_anular', 1)->where('estado_id', '1')->count();
        $productos_inactivos = Producto::where('estado_id', 2)->count();
        $productos_anulados = Producto::where('estado_anular', 0)->count();

        $data = [
            'total' => $productos,
            'activos' => round(($productos_activos / $productos) * 100, 1),
            'inactivos' => round(($productos_inactivos / $productos) * 100, 1),
            'anulados' => round(($productos_anulados / $productos) * 100, 1)
        ];
        // dd($data);
        return $data;
    }

    public function getMarcaAttribute() {
        return optional($this->marcas_i_producto)->nombre;
    }

    public function getUnidadMedidaAttribute() {
        return optional($this->unidad_i_producto)->medida;
    }

    public function getStockAttribute() {
        $stock = optional($this->stock_producto)->stock ?? 'Indefinido';

        return $stock;
    }

    public function getPrecioNacionalAttribute() {
        $precioNacional = optional($this->stock_producto)->precio_nacional ?? 'No definido';

        return $precioNacional;
    }

    public function getPrecioExtranjeroAttribute() {
        $precioExtranjero = optional($this->stock_producto)->precio_extranjero ?? 'No definido';

        return $precioExtranjero;
    }
}
