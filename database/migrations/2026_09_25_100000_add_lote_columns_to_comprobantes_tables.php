<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLoteColumnsToComprobantesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tablas = [
            'facturacion_registro',
            'facturacion_registro_m',
            'boleta_registro',
            'boleta_registros_m',
            'nota_venta_registro',
            'g_remision_registro',
            'kardex_salida_registro',
        ];

        foreach ($tablas as $tabla) {
            if (Schema::hasTable($tabla)) {
                Schema::table($tabla, function (Blueprint $table) use ($tabla) {
                    if (!Schema::hasColumn($tabla, 'lote_id')) {
                        $table->unsignedBigInteger('lote_id')->nullable()->index();
                    }
                    if (!Schema::hasColumn($tabla, 'codigo_lote')) {
                        $table->string('codigo_lote', 50)->nullable();
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tablas = [
            'facturacion_registro',
            'facturacion_registro_m',
            'boleta_registro',
            'boleta_registros_m',
            'nota_venta_registro',
            'g_remision_registro',
            'kardex_salida_registro',
        ];

        foreach ($tablas as $tabla) {
            if (Schema::hasTable($tabla)) {
                Schema::table($tabla, function (Blueprint $table) use ($tabla) {
                    if (Schema::hasColumn($tabla, 'codigo_lote')) {
                        $table->dropColumn('codigo_lote');
                    }
                    if (Schema::hasColumn($tabla, 'lote_id')) {
                        $table->dropColumn('lote_id');
                    }
                });
            }
        }
    }
}
