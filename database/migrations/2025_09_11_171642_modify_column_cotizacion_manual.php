<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyColumnCotizacionManual extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cotizacion_manual', function (Blueprint $table) {
            $table->unsignedBigInteger('servicio_g_id')->after('tipo_documento_id')->nullable();
            $table->foreign('servicio_g_id')->references('id')->on('servicio_guias')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE cotizacion_manual MODIFY es_serv_tec TINYINT(1) DEFAULT 0 NULL');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cotizacion_manual', function (Blueprint $table) {
            //
        });
    }
}
