<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRemisionCodGuiaAlmacen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cod_guia_almacen', function (Blueprint $table) {
            $table->integer('serie_remision_m')->after('cod_boleta_m')->default(0);
            $table->string('cod_remision_m')->after('serie_remision_m')->default(0);
        });
    }
}
