<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnGuiaRTrasladoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('guia_r_traslados', function (Blueprint $table) {
            // $table->foreign('id_kardex_distribucion')->after('id');
            $table->unsignedBigInteger('id_kardex_distribucion')->after('id')->nullable();
            $table->foreign('id_kardex_distribucion')->references('id')->on('kardex_entrada')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
    }
}
