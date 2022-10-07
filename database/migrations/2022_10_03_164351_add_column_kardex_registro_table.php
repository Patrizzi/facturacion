<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnKardexRegistroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kardex_entrada_registro', function (Blueprint $table) {
            $table->string('unidad')->after('precio_extranjero')->default(1);
            $table->string('unidad_cantidad')->after('cantidad')->default(0); //multiplicacion de unidad x cantiadad, condicional en 0 para anteriores registros
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
