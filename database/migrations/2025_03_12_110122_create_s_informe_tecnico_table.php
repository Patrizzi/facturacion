<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSInformeTecnicoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_informe_tecnico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('s_g_salida_id');
            $table->foreign('s_g_salida_id')->references('id')->on('s_guia_salida')->onDelete('cascade');
            $table->date('fecha');
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
        Schema::dropIfExists('s_informe_tecnico');
    }
}
