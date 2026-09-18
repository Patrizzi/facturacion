<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodGuiaAlmacen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cod_guia_almacen', function (Blueprint $table) {
            $table->integer('serie_boleta_m')->after('cod_factura_m')->default(0);
            $table->string('cod_boleta_m')->after('serie_boleta_m')->default(0);
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
