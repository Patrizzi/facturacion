<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicioGIngresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_g_ingresos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('servicio_guia_id');
            $table->foreign('servicio_guia_id')->references('id')->on('servicio_guias');
            $table->string('nombre_equipo');
            $table->string('nro_serie')->nullable();
            $table->date('fecha_agregada');
            $table->tinyInteger('estado')->default(0);
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
        Schema::dropIfExists('servicio_g_ingresos');
    }
}
