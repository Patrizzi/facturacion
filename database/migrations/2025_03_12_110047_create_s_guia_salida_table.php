<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSGuiaSalidaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_guia_salida', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('s_g_ingreso_id');
            $table->foreign('s_g_ingreso_id')->references('id')->on('s_guia_ingreso')->onDelete('cascade');
            $table->string('tecnico_reparacion');
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
        Schema::dropIfExists('s_guia_salida');
    }
}
