<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComprobantesPagosDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comprobantes_pagos_detalles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('comprobante_pago_id')->nullable();  // Comprobante pago ID FK
            $table->foreign('Comprobante_pago_id')->references('id')->on('comprobantes_pagos')->onDelete('cascade');
            $table->unsignedBigInteger('comprobante_pago_reg_id')->nullable();  // Comprobante pago registros ID FK
            $table->foreign('Comprobante_pago_reg_id')->references('id')->on('comprobantes_pagos_registros')->onDelete('cascade');
            $table->string('tipo_pago'); // EFECTIVO - TARJETA - ETC
            $table->string('numero_input')->nullable();
            $table->string('fechas_input')->nullable();
            $table->double('montos_input',17,2)->nullable();
            $table->string('bancos_input')->nullable();
            $table->string('persona_input')->nullable();
            $table->string('adicional_input')->nullable();
            $table->text('file_input')->nullable();
            $table->text('notas_adicionales')->nullable();
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
        Schema::dropIfExists('comprobantes_pagos_detalles');
    }
}
