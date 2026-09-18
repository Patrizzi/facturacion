<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuiaRemisionMRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guia_remision_m_registros', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('guia_remision_m_id');
            $table->foreign('guia_remision_m_id')->references('id')->on('guia_remision_manual')->onDelete('cascade');

            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

            $table->string('cantidad');
            $table->string('numero_serie');

            $table->string('peso');
            $table->string('estado');

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
        Schema::dropIfExists('guia_remision_m_registros');
    }
}
