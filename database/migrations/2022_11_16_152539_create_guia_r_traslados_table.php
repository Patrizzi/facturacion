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
            // $table->string('');
            $table->unsignedBigInteger('almacen_emisor')->nullable();
            $table->foreign('almacen_emisor')->references('id')->on('almacen')->onDelete('cascade');
            $table->unsignedBigInteger('almacen_receptor')->nullable();
            $table->foreign('almacen_receptor')->references('id')->on('almacen')->onDelete('cascade');
            
            $table->string('observaciones')->nullable();
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
