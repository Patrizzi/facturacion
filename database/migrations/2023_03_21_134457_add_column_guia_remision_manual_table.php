<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnGuiaRemisionManualTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guia_remision_manual', function (Blueprint $table) {
            $table->string('ticket_guia_remi_m_sunat')->after('g_electronica')->nullable();
            $table->boolean('estado_ticket_guia_m')->after('ticket_guia_remi_m_sunat')->default('0');
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
