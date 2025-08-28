<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicioInformeTecnicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicio_informe_tecnico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('servicio_g_egreso_id');
            $table->foreign('servicio_g_egreso_id')->references('id')->on('servicio_g_egresos');
            $table->date('fecha_creacion');
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
        Schema::dropIfExists('servicio_informe_tecnico');
    }
}
