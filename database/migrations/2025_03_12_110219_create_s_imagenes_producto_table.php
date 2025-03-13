<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSImagenesProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('s_imagenes_producto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('s_d_g_salida_id');
            $table->foreign('s_d_g_salida_id')->references('id')->on('s_detalle_guia_salida')->onDelete('cascade');
            $table->string('foto');
            $table->text('descripcion');
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
        Schema::dropIfExists('s_imagenes_producto');
    }
}
