<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSGuiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_guias', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('nro_guia')->unsigned()->unique();
            $table->unsignedBigInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->string('orden_servicio')->nullable();
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
        Schema::dropIfExists('s_guias');
    }
}
