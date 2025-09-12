<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnServicioInformeTecnico extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('servicio_informe_tecnico', function (Blueprint $table) {
            $table->dropForeign(['servicio_g_egreso_id']);
            $table->dropColumn('servicio_g_egreso_id');

            $table->unsignedBigInteger('servicio_g_id')->after('id');
            $table->foreign('servicio_g_id')->references('id')->on('servicio_guias');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('servicio_informe_tecnico', function (Blueprint $table) {
            //
        });
    }
}
