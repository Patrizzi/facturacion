<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturacionRegistroMTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturacion_registro_m', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('facturacion_m_id')->nullable();
            $table->foreign('facturacion_m_id')->references('id')->on('facturacion_m')->onDelete('cascade');

             $table->unsignedBigInteger('producto_id')->nullable();
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');

            $table->unsignedBigInteger('servicio_id')->nullable();
            $table->foreign('servicio_id')->references('id')->on('servicios')->onDelete('cascade');

            $table->string('numero_serie')->nullable();
            $table->text('descripcion_item')->nullable();

            $table->double('precio',17,2);
            $table->integer('cantidad');
            

            
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
        Schema::dropIfExists('facturacion_registro_m');
    }
}
