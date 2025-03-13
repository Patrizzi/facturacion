<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSDetalleGuiaIngresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_detalle_guia_ingreso', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('s_g_ingreso_id');
            $table->foreign('s_g_ingreso_id')->references('id')->on('s_guia_ingreso')->onDelete('cascade');
            $table->string('producto');
            $table->string('serie');
            $table->string('observacion');
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
        Schema::dropIfExists('s_detalle_guia_ingreso');
    }
}
