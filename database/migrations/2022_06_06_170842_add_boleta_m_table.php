<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBoletaMTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('boleta_m', function (Blueprint $table) {
            $table->unsignedBigInteger('cotizador_id')->nullable()->after('codigo_boleta');
            $table->foreign('cotizador_id')->references('id')->on('cotizacion_manual')->onDelete('cascade');
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
