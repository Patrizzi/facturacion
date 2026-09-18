<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicioGEgresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_g_egresos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('servicio_g_ingreso_id');
            $table->foreign('servicio_g_ingreso_id')->references('id')->on('servicio_g_ingresos');
            $table->date('fecha_inicio_reparacion');
            $table->text('diagnostico')->nullable();
            $table->text('descripcion_os')->nullable();
            $table->date('fecha_fin_reparacion')->nullable();
            $table->tinyInteger('estado')->default(0);
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
        Schema::dropIfExists('servicio_g_egresos');
    }
}
