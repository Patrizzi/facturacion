<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSerieColumnsToComprobantesTables extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('series_productos')) {
            throw new RuntimeException('La tabla series_productos debe existir antes de agregar las FK serie_id.');
        }

        $this->addSerieColumn('facturacion_registro', 'producto_id');
        $this->addSerieColumn('boleta_registro', 'producto_id');
        $this->addSerieColumn('nota_venta_registro', 'nota_venta_id');
    }

    private function addSerieColumn($tableName, $fallbackAnchor)
    {
        if (!Schema::hasTable($tableName)) {
            throw new RuntimeException("La tabla {$tableName} debe existir antes de agregar la FK serie_id.");
        }

        if (Schema::hasColumn($tableName, 'serie_id')) {
            throw new RuntimeException("La columna {$tableName}.serie_id ya existe; revisa el estado de la migración antes de continuar.");
        }

        $hasLoteId = Schema::hasColumn($tableName, 'lote_id');
        $hasNumeroSerie = Schema::hasColumn($tableName, 'numero_serie');

        Schema::table($tableName, function (Blueprint $table) use ($hasLoteId, $fallbackAnchor, $hasNumeroSerie) {
            $serieId = $table->unsignedInteger('serie_id')->nullable();
            $serieId->after($hasLoteId ? 'lote_id' : ($hasNumeroSerie ? 'numero_serie' : $fallbackAnchor));
            // El comprobante conserva numero_serie aunque se elimine el registro de la serie.
            $table->foreign('serie_id')
                ->references('id')
                ->on('series_productos')
                ->nullOnDelete();

            if (!$hasNumeroSerie) {
                $table->string('numero_serie', 50)->nullable()->after('serie_id');
            }
        });
    }

    public function down()
    {
        foreach (['facturacion_registro', 'boleta_registro', 'nota_venta_registro'] as $tableName) {
            Schema::table($tableName, function (Blueprint $table) {
                $table->dropForeign(['serie_id']);
                $table->dropColumn('serie_id');
            });
        }

        Schema::table('nota_venta_registro', function (Blueprint $table) {
            $table->dropColumn('numero_serie');
        });
    }
}