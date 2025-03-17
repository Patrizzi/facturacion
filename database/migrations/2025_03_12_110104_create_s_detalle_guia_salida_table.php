<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSDetalleGuiaSalidaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_detalle_guia_salida', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('s_g_salida_id');
            $table->foreign('s_g_salida_id')->references('id')->on('s_guia_salida')->onDelete('cascade');
            $table->unsignedBigInteger('s_d_g_ingreso_id');
            $table->foreign('s_d_g_ingreso_id')->references('id')->on('s_detalle_guia_ingreso')->onDelete('cascade');
            $table->text('recomendaciones')->nullable();
            $table->boolean('aprobado')->nullable();
            $table->enum('estado', ['rechazado', 'en_revision', 'reparado'])->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('s_detalle_guia_salida');
    }
}
