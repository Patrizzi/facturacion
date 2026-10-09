<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobantesPagosRegistrosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobantes_pagos_registros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('comprobante_pago_id')->nullable();  // Comprobante pago ID FK
            $table->foreign('Comprobante_pago_id')->references('id')->on('comprobantes_pagos')->onDelete('cascade');
            $table->unsignedBigInteger('id_cuota_credito')->nullable();  // Id Cuota del comprobante a credito
            $table->foreign('id_cuota_credito')->references('id')->on('cuotas_creditos')->onDelete('cascade');
            $table->string('monto_total');
            $table->string('monto_pago');
            $table->string('fecha_pago')->nullable();
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
        Schema::dropIfExists('comprobantes_pagos_registros');
    }
}
