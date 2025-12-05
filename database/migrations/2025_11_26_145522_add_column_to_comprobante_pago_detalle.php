<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToComprobantePagoDetalle extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobantes_pagos_detalles', function (Blueprint $table) {
            $table->unsignedBigInteger('moneda_id')->nullable()->after('montos_input');
            $table->foreign('moneda_id')->references('id')->on('monedas');
            $table->decimal('tipo_cambio', 15, 6)->nullable()->default(null)->after('moneda_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comprobantes_pagos_detalles', function (Blueprint $table) {
            //
        });
    }
}
