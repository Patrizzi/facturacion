<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobantesPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobantes_pagos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('tipo_doc'); // FACTURA  - BOLETA - FACT M - BOL M 
            $table->unsignedBigInteger('factuacion_id')->nullable();  // FACTURA
            $table->foreign('factuacion_id')->references('id')->on('facturacion')->onDelete('cascade');
            $table->unsignedBigInteger('factuacion_m_id')->nullable();  // FACTURA_MANUAL
            $table->foreign('factuacion_m_id')->references('id')->on('facturacion_m')->onDelete('cascade');
            $table->unsignedBigInteger('boleta_id')->nullable();  // BOLETA
            $table->foreign('boleta_id')->references('id')->on('boleta')->onDelete('cascade');
            $table->unsignedBigInteger('boleta_m_id')->nullable();  // BOLETA_MANUAL
            $table->foreign('boleta_m_id')->references('id')->on('boleta_m')->onDelete('cascade');
            $table->string('tipo_pago'); // CREDITO siempres
            $table->double('monto_tot',17,2);
            $table->double('monto_pago',17,2);
            $table->string('fecha_registro');
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
        Schema::dropIfExists('comprobantes_pagos');
    }
}
