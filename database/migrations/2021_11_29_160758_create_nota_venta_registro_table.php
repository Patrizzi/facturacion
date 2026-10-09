<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaVentaRegistroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_venta_registro', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('nota_venta_id')->nullable();
            $table->foreign('nota_venta_id')->references('id')->on('nota_venta')->onDelete('cascade');

            $table->string('producto')->nullable();
            $table->string('cantidad')->nullable();
            $table->double('precio_nacional',10,2);
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
        Schema::dropIfExists('nota_venta_registro');
    }
}
