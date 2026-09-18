<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPagosAdelantos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comprobantes_pagos_detalles', function (Blueprint $table) {
            $table->boolean('option_input')->nullable()->after('fecha_emision_input');
            $table->boolean('estado')->nullable()->after('option_input');
        });
        Schema::table('creditos_adelantos_registros', function (Blueprint $table) {
            $table->string('fecha_emision_input')->nullable()->after('persona_input');
            $table->boolean('option_input')->nullable()->after('fecha_emision_input');
            $table->boolean('estado')->nullable()->after('option_input'); // para cheque - diferido / etc   
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
