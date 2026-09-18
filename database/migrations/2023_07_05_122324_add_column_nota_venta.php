<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnNotaVenta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nota_venta', function (Blueprint $table){
            $table->unsignedBigInteger('id_cotizacion')->nullable()->after('cod_nota_venta');
            $table->foreign('id_cotizacion')->references('id')->on('cotizacion')->onDelete('cascade');

            $table->unsignedBigInteger('id_cotizacion_m')->nullable()->after('id_cotizacion');
            $table->foreign('id_cotizacion_m')->references('id')->on('cotizacion_manual')->onDelete('cascade');
        });
        Schema::table('nota_venta_registro', function (Blueprint $table){
            $table->text('descripcion')->nullable()->after('producto');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
