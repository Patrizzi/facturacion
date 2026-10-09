<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnRemisionRegistro extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('g_remision_registros', function (Blueprint $table) {
            $table->text('numero_serie')->nullable()->change();
        });
        Schema::table('guia_remision_m_registros', function (Blueprint $table) {
            $table->text('numero_serie')->nullable()->change();
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
