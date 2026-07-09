<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEstadoAtUnidadMedidaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('unidad_medida', function (Blueprint $table) {
            // 0 => ACTIVO ||  1 => DESACTIVO
            $table->boolean('estado')->default(0)->after('unidad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('unidad_medida', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
}
