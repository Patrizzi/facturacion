<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNotaInformativaToGuiaRemisionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guia_remision', function (Blueprint $table) {
            $table->text('nota_informativa')->nullable()->after('estado');
        });

        Schema::table('guia_remision_manual', function (Blueprint $table) {
            $table->text('nota_informativa')->nullable()->after('estado');
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
            $table->dropColumn('nota_informativa');
        });

        Schema::table('guia_remision_manual', function (Blueprint $table) {
            $table->dropColumn('nota_informativa');
        });
    }
}
