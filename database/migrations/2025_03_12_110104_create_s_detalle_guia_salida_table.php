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
            $table->unsignedBigInteger('s_g_egreso_id');
            $table->foreign('s_g_egreso_id')->references('id')->on('s_guia_egreso')->onDelete('cascade');
            $table->text('recomendaciones');
            $table->boolean('aprobado')->nullable();
            $table->enum('estado', ['rechazado', 'en_revision', 'reparado'])->nullable();
            $table->unsignedBigInteger('user_id');
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
