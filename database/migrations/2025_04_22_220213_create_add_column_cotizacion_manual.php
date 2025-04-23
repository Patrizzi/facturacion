<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddColumnCotizacionManual extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotizacion_manual', function (Blueprint $table) {
            $table->unsignedBigInteger('guia_id')->nullable();
            $table->foreign('guia_id')->references('id')->on('s_guias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cotizacion_manual', function (Blueprint $table) {
            $table->dropForeign(['guia_id']);
            $table->dropColumn('guia_id');
        });
    }
}
