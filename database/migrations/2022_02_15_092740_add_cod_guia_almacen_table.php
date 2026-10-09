<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodGuiaAlmacenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cod_guia_almacen', function (Blueprint $table) {
            $table->integer('serie_factura_m')->after('cod_nota_debito')->default(0);
            $table->string('cod_factura_m')->after('serie_factura_m')->default(0);
        });
    }

    /**
     * 
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
