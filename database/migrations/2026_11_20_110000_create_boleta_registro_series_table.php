<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoletaRegistroSeriesTable extends Migration
{
    public function up()
    {
        Schema::create('boleta_registro_series', function (Blueprint $table) {
            $table->unsignedBigInteger('boleta_registro_id');
            $table->unsignedInteger('serie_id')->nullable();
            $table->string('numero_serie', 50);
            $table->unsignedInteger('posicion');

            $table->primary(['boleta_registro_id', 'posicion']);
            $table->unique(['boleta_registro_id', 'serie_id']);
            $table->foreign('boleta_registro_id')->references('id')->on('boleta_registro')->onDelete('cascade');
            $table->foreign('serie_id')->references('id')->on('series_productos')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('boleta_registro_series');
    }
}