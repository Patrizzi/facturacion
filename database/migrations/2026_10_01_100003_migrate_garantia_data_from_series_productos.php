<?php

use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MigrateGarantiaDataFromSeriesProductos extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('series_productos') || !Schema::hasTable('garantias')) {
            throw new RuntimeException('Deben existir series_productos y garantias antes de migrar las fechas de garantía.');
        }

        foreach (['fecha_venta', 'fecha_vencimiento_garantia'] as $column) {
            if (!Schema::hasColumn('series_productos', $column)) {
                throw new RuntimeException("Falta la columna series_productos.{$column}; no se migraron datos.");
            }
        }

        $fechasIncompletas = DB::table('series_productos')
            ->where(function ($query) {
                $query->where(function ($query) {
                    $query->whereNull('fecha_venta')->whereNotNull('fecha_vencimiento_garantia');
                })->orWhere(function ($query) {
                    $query->whereNotNull('fecha_venta')->whereNull('fecha_vencimiento_garantia');
                });
            })
            ->exists();

        if ($fechasIncompletas) {
            throw new RuntimeException('Hay series con solo una fecha de garantía; completa esos datos antes de migrar.');
        }

        $hoy = Carbon::today();

        DB::table('series_productos')
            ->select('id', 'fecha_venta', 'fecha_vencimiento_garantia')
            ->whereNotNull('fecha_venta')
            ->whereNotNull('fecha_vencimiento_garantia')
            ->orderBy('id')
            ->chunkById(500, function ($series) use ($hoy) {
                foreach ($series as $serie) {
                    $fechaVenta = Carbon::parse($serie->fecha_venta)->startOfDay();
                    $fechaVencimiento = Carbon::parse($serie->fecha_vencimiento_garantia)->startOfDay();
                    $duracionMeses = max(0, $fechaVenta->diffInMonths($fechaVencimiento, false));

                    $garantiaExiste = DB::table('garantias')
                        ->where('serie_id', $serie->id)
                        ->where('fecha_venta', $fechaVenta->toDateString())
                        ->where('fecha_vencimiento', $fechaVencimiento->toDateString())
                        ->exists();

                    if (!$garantiaExiste) {
                        DB::table('garantias')->insert([
                            'serie_id' => $serie->id,
                            'estado_garantia' => $fechaVencimiento->gte($hoy) ? 'Vigente' : 'Expirada',
                            'fecha_venta' => $fechaVenta->toDateString(),
                            'fecha_vencimiento' => $fechaVencimiento->toDateString(),
                            'duracion_meses' => $duracionMeses,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            });
    }

    public function down()
    {
        // No borrar historial: las filas importadas también pueden haber recibido cambios posteriores.
    }
}