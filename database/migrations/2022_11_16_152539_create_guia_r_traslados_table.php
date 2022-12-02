<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuiaRTrasladosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guia_r_traslados', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('cod_guia');
            $table->string('motivo');
            // foreign
            $table->integer('tipo_transporte')->nullable();
            $table->string('fecha_emision');
            $table->string('fecha_entrega')->nullable();
            $table->string('almacen_receptor');
            $table->string('almacen_emisor');
            $table->string('observaciones');
            $table->boolean('estado')->default('0');

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
        Schema::dropIfExists('guia_r_traslados');
    }
}
