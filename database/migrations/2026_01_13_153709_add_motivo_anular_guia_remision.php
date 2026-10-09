<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMotivoAnularGuiaRemision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guia_remision', function (Blueprint $table) {
            $table->string('motivo_anulacion')->after('estado_anulado')->nullable();
        });
        Schema::table('guia_remision_manual', function (Blueprint $table) {
            $table->string('motivo_anulacion')->after('estado_anulado')->nullable();
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
            $table->dropColumn('motivo_anulacion');
        });

        Schema::table('guia_remision_manual', function (Blueprint $table) {
            $table->dropColumn('motivo_anulacion');
        });
    }
}
