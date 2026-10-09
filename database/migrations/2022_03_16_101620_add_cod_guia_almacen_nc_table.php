<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodGuiaAlmacenNcTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cod_guia_almacen', function (Blueprint $table) {
            $table->integer('serie_nota_credito_b')->after('cod_nota_credito')->default(0);
            $table->string('cod_nota_credito_b')->after('serie_nota_credito_b')->default(0);
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
