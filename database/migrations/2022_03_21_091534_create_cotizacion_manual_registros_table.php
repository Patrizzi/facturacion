<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionManualRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacion_manual_registros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cotizacion_m_id')->nullable();
            $table->foreign('cotizacion_m_id')->references('id')->on('cotizacion_manual')->onDelete('cascade');

             $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

            $table->unsignedBigInteger('servicio_id')->nullable();
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');

            $table->text('descripcion_item')->nullable();
            
            $table->integer('cantidad');
            $table->double('precio',17,2);            
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
        Schema::dropIfExists('cotizacion_manual_registros');
    }
}
