<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuiaRTrasladoRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guia_r_traslado_registros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_guia_r_traslado')->nullable();
            $table->foreign('id_guia_r_traslado')->references('id')->on('guia_r_traslados')->onDelete('cascade');
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->string('stock');
            $table->string('unidad');
            $table->string('cantidad');
            $table->string('cantidad_total');
            $table->longText('numero_series');
            $table->string('peso');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guia_r_traslado_registros');
    }
}
