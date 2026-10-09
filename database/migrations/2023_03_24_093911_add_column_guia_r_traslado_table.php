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
            $table->unsignedBigInteger('id_kardex')->after('id')->nullable();
            $table->foreign('id_kardex')->references('id')->on('kardex_entrada')->onDelete('cascade');
            $table->string('vehiculo_publico')->nullable()->after('tipo_transporte');
            $table->string('conductor_id')->nullable()->after('vehiculo_publico');
            $table->unsignedBigInteger('vehiculo_id')->nullable()->after('conductor_id');
            $table->foreign('vehiculo_id')->references('id')->on('vehiculos')->onDelete('cascade');

            
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
