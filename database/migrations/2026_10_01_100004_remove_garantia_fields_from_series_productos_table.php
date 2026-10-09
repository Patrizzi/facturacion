<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RemoveGarantiaFieldsFromSeriesProductosTable extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('series_productos')) {
            throw new RuntimeException('La tabla series_productos debe existir antes de retirar sus fechas de garantía.');
        }

        Schema::table('series_productos', function (Blueprint $table) {
            $table->dropColumn(['fecha_venta', 'fecha_vencimiento_garantia']);
        });
    }

    public function down()
    {
        Schema::table('series_productos', function (Blueprint $table) {
            $table->date('fecha_venta')->nullable();
            $table->date('fecha_vencimiento_garantia')->nullable();
        });

        $ultimaSerieId = null;

        DB::table('garantias')
            ->select('serie_id', 'fecha_venta', 'fecha_vencimiento', 'id')
            ->orderBy('serie_id')
            ->orderBy('fecha_vencimiento', 'desc')
            ->orderBy('id', 'desc')
            ->chunk(500, function ($garantias) use (&$ultimaSerieId) {
                foreach ($garantias as $garantia) {
                    if ($ultimaSerieId === $garantia->serie_id) {
                        continue;
                    }

                    DB::table('series_productos')
                        ->where('id', $garantia->serie_id)
                        ->update([
                            'fecha_venta' => $garantia->fecha_venta,
                            'fecha_vencimiento_garantia' => $garantia->fecha_vencimiento,
                        ]);

                    $ultimaSerieId = $garantia->serie_id;
                }
            });
    }
}