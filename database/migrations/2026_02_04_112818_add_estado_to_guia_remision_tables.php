<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoToGuiaRemisionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guia_remision', function (Blueprint $table) {
            $table->tinyInteger('estado')->after('motivo_traslado')->default(1);
        });
        Schema::table('guia_remision_manual', function (Blueprint $table) {
            $table->tinyInteger('estado')->after('motivo_traslado')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('guia_remision', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
        Schema::table('guia_remision_manual', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
}
