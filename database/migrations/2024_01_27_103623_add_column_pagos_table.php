<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobantes_pagos', function (Blueprint $table) {
            $table->unsignedBigInteger('nota_venta_id')->nullable()->after('boleta_m_id');  // NOTA DE VENTA
            $table->foreign('nota_venta_id')->references('id')->on('nota_venta')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
