<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Marca extends Model
{
    protected $table = 'marcas';

    protected $guarded = [];

    public function productos(): HasMany
    {
        return $this->hasMany(Producto::class, 'marca_id');
    }
    public function servicios(): HasMany
    {
        return $this->hasMany(Servicios::class, 'marca_id');
    }

    public static function barras_marcas()
    {
        $topMarcas = Marca::withCount('productos')
            ->orderByDesc('productos_count')
            ->take(10)
            ->get();

        $barData = [];
        $ticks = [];
        $nombres = [];
        $index = 1;

        foreach ($topMarcas as $marca) {
            $barData[] = [$index, $marca->productos_count];
            $ticks[] = [$index, $marca->nombre];
            $nombres[] = $marca->nombre;
            $index++;
        }

        return [
            'barData' => $barData,
            'ticks' => $ticks,
            'nombres' => $nombres // arreglo solo con los nombres en orden
        ];
    }

    public static function barras_familias_servicios()
    {
        $topMarcas = Marca::withCount('servicios')
            ->orderByDesc('servicios_count')
            ->take(10)
            ->get();

        $barData = [];
        $ticks = [];
        $nombres = [];
        $index = 1;

        foreach ($topMarcas as $marca) {
            $barData[] = [$index, $marca->servicios_count];
            $ticks[] = [$index, $marca->nombre];
            $nombres[] = $marca->nombre;
            $index++;
        }

        return [
            'barData' => $barData,
            'ticks' => $ticks,
            'nombres' => $nombres // arreglo solo con los nombres en orden
        ];
    }
}
