<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotaVentaIdToRenovacionVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('renovacion_ventas', function (Blueprint $table) {
            $table->unsignedBigInteger('nota_venta_id')
                  ->nullable()
                  ->after('cotizacion_manual_id');

            $table->foreign('nota_venta_id')
                  ->references('id')
                  ->on('nota_venta')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('renovacion_ventas', function (Blueprint $table) {
            $table->dropForeign(['nota_venta_id']);
            $table->dropColumn('nota_venta_id');
        });
    }
}
